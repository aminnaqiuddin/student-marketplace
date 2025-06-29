<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\PaymentIntent;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (SignatureVerificationException $e) {
            Log::error('Webhook signature verification failed: '.$e->getMessage());
            return response('Invalid signature', 403);
        }

        // Handle specific events
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->updateOrderStatus($paymentIntent, 'paid');
                break;

            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->updateOrderStatus($paymentIntent, 'failed');
                break;

            case 'checkout.session.completed':
                $session = $event->data->object;
                if ($session->payment_status === 'paid') {
                    $this->updateOrderStatus($session->payment_intent, 'paid');
                }
                break;
        }

        return response('Webhook Handled', 200);
    }

    protected function updateOrderStatus($paymentData, $status)
    {
        // Find order by payment intent ID
        $order = Order::where('stripe_payment_id', $paymentData->id)->first();

        if ($order) {
            $order->update(['status' => $status]);
            Log::info("Order #{$order->id} status updated to: {$status}");

            // Add any additional fulfillment logic here
            // e.g., send confirmation email, update inventory, etc.
        } else {
            Log::warning("Order not found for payment: {$paymentData->id}");
        }
    }
}
