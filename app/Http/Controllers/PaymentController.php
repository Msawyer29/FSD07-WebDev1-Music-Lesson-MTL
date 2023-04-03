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
    public function initiatePayment(Request $request, $lessonId)
    {
        //Log::info('Request method: ' . $request->method()); // Add this line to log the request method

        $lessonId = $request->input('lessonId');
        $lesson = Lesson::find($lessonId);

        if (!$lesson) {
            return back()->with('error', 'Lesson not found.');
        }

        return view('payment', ['lesson' => $lesson]);
    }

    public function processPayment(Request $request)
    {
        $lessonId = $request->input('lessonId');
        $lesson = Lesson::find($lessonId);

        if (!$lesson) {
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

            return redirect()->route('payment.success')->with('success', 'Payment successful!');
        } catch (\Stripe\Exception\CardException $e) {
            return back()->with('error', 'Card error: ' . $e->getMessage());
        } catch (\Stripe\Exception\RateLimitException $e) {
            return back()->with('error', 'Rate limit error: ' . $e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return back()->with('error', 'Invalid request error: ' . $e->getMessage());
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return back()->with('error', 'Authentication error: ' . $e->getMessage());
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return back()->with('error', 'API connection error: ' . $e->getMessage());
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return back()->with('error', 'API error: ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function success()
    {
        return redirect()->route('payment.success')->with('success', 'Payment successful!');
    }
}