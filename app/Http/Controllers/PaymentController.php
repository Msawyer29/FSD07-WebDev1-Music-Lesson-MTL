<?php

namespace App\Http\Controllers;

use App\Http\Controllers\LessonController;
use App\Models\Lesson;
use Exception;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Exception\CardException;
use Stripe\Exception\RateLimitException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiatePayment($lessonId) //Remove Request - only parameter being passed in the request is the lessonId, which is already being retrieved from the URL parameters in the method signature.
    {
        //Log::info('Request method: ' . $request->method()); // Add this line to log the request method

        $lesson = Lesson::find($lessonId);

        if (!$lesson) {
            return back()->with('error', 'Lesson not found.');
        }

        return view('payment', ['lesson' => $lesson]);
    }

    public function processPayment(Request $request)
    {
        Stripe::setApiKey(env('sk_test_51MsdkuKcBJEP5uncIuqppZQjusxkSmyoUckZlJcSWguGqBwhYzJH3saJufEut6aGoBLRdPlWN9PvnL5xZPEf734O00pSNYU9Wx'));

        $lessonId = $request->input('lessonId');
        $lesson = Lesson::find($lessonId);

        if (!$lesson) {
            Log::error('Lesson not found');
            return back()->with('error', 'Lesson not found.');
        }

        $amount = 5000; // $50 in cents

        try {
            $charge = \Stripe\Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Lesson Payment',
            ]);

            // Update the lesson payment status here
            $lesson->paymentConfirmation = 1;
            $lesson->save();

            Log::info('Payment successful');

            return redirect()->route('payment.success')->with('success', 'Payment successful!');
        } catch (\Stripe\Exception\CardException $e) {
            Log::error('Card error: ' . $e->getMessage());
            return back()->with('error', 'Card error: ' . $e->getMessage());
        } catch (\Stripe\Exception\RateLimitException $e) {
            Log::error('Rate limit error: ' . $e->getMessage());
            return back()->with('error', 'Rate limit error: ' . $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            Log::error('Invalid request error: ' . $e->getMessage());
            return back()->with('error', 'Invalid request error: ' . $e->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            Log::error('Authentication error: ' . $e->getMessage());
            return back()->with('error', 'Authentication error: ' . $e->getMessage());
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            Log::error('API connection error: ' . $e->getMessage());
            return back()->with('error', 'API connection error: ' . $e->getMessage());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('API error: ' . $e->getMessage());
            return back()->with('error', 'API error: ' . $e->getMessage());
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        } finally {
            // add console log here
            Log::info('Redirected to payment success page');
        }
    }

    public function success()
    {
        return view('payment-success');
    }
}