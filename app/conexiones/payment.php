<?php
require '../vendor/autoload.php';

// This is your real test secret API key.
// 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
// sk_test_51IQ79SDzY9AsmTJ8r9YX3CqYBNtjd06LLO3TUyrLdHZRKXViP7CZIDCWE834Qtkhuaf0Xit7vKjo7tVZBt6uk3gJ002Yj4eKvJ
\Stripe\Stripe::setApiKey('sk_test_51IQ79SDzY9AsmTJ8r9YX3CqYBNtjd06LLO3TUyrLdHZRKXViP7CZIDCWE834Qtkhuaf0Xit7vKjo7tVZBt6uk3gJ002Yj4eKvJ');

header('Content-Type: application/json');

try {
  // retrieve JSON from POST body
  $json_str = file_get_contents('php://input');
  $json_obj = json_decode($json_str);

  // Alternatively, set up a webhook to listen for the payment_intent.succeeded event
  // and attach the PaymentMethod to a new Customer
  $customer = \Stripe\Customer::create();
  $paymentIntent = \Stripe\PaymentIntent::create([
    'amount' => 5746445,
    'currency' => 'eur',
    'customer' => $customer->id,
    'description' => 'Suscripció Cuantime',
    'setup_future_usage' => 'off_session',
  ]);

  $output = [
    'clientSecret' => $paymentIntent->client_secret,
  ];

  echo json_encode($output);
} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}