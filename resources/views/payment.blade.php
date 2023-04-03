<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <x-app-layout>
        @section('content')
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Payment') }}
                </h2>
            </x-slot>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Complete Payment</div>

                            <div class="card-body">
                                <form action="{{ url('/payment-process') }}" method="POST" id="payment-form">
                                    @csrf
                                    <input type="hidden" name="lessonId" value="{{ $lesson->id }}">
                                    <div class="form-row">
                                        <label for="card-element">
                                            Credit or debit card
                                        </label>
                                        <div id="card-element">
                                            <!-- A Stripe Element will be inserted here. -->
                                        </div>
                                        <!-- Used to display form errors. -->
                                        <div id="card-errors" role="alert"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Confirm Payment</button>
                                </form>

                                <script>
                                    // Create a Stripe client.
                                    var stripe = Stripe('{{ env('STRIPE_KEY') }}');

                                    // Create an instance of Elements.
                                    var elements = stripe.elements();

                                    // Custom styling to be moved to app.css later
                                    var style = {
                                        base: {
                                            color: '#32325d',
                                            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                            fontSmoothing: 'antialiased',
                                            fontSize: '16px',
                                            '::placeholder': {
                                                color: '#aab7c4'
                                            }
                                        },
                                        invalid: {
                                            color: '#fa755a',
                                            iconColor: '#fa755a'
                                        }
                                    };

                                    // Create an instance of the card Element.
                                    var card = elements.create('card', {
                                        style: style
                                    });

                                    // Add an instance of the card Element into the `card-element` <div>.
                                    card.mount('#card-element');

                                    // Handle real-time validation errors from the card Element.
                                    card.addEventListener('change', function(event) {
                                        var displayError = document.getElementById('card-errors');
                                        if (event.error) {
                                            displayError.textContent = event.error.message;
                                        } else {
                                            displayError.textContent = '';
                                        }
                                    });

                                    // Handle form submission.
                                    var form = document.getElementById('payment-form');
                                    form.addEventListener('submit', function(event) {
                                        event.preventDefault();

                                        stripe.createToken(card).then(function(result) {
                                            if (result.error) {
                                                // Inform the user if there was an error.
                                                var errorElement = document.getElementById('card-errors');
                                                errorElement.textContent = result.error.message;
                                            } else {
                                                // Send the token to your server.
                                                stripeTokenHandler(result.token);
                                            }
                                        });
                                    });

                                    // Submit the form with the token ID.
                                    function stripeTokenHandler(token) {
                                        // Insert the token ID into the form so it gets submitted to the server
                                        var form = document.getElementById('payment-form');
                                        var hiddenInput = document.createElement('input');
                                        hiddenInput.setAttribute('type', 'hidden');
                                        hiddenInput.setAttribute('name', 'stripeToken');
                                        hiddenInput.setAttribute('value', token.id);
                                        form.appendChild(hiddenInput);

                                        // Set the form action to the correct route and method
                                        form.setAttribute('action', '{{ url('/payment-process') }}');
                                        form.setAttribute('method', 'POST');

                                        // Submit the form
                                        form.submit();
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
    </x-app-layout>
</body>

</html>
