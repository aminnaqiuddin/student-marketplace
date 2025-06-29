<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = $this->buildLineItemsFromCart();

        if (empty($lineItems)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Create order record first
        $order = Order::create([
            'user_id' => auth()->id(),
            'amount' => $this->getCartTotal(),
            'status' => 'pending',
            'items' => session('cart')
        ]);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => URL::to('/payment/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => URL::to('/payment/cancel'),
            'metadata' => [
                'order_id' => $order->id
            ]
        ]);

        // Save Stripe references to order
        $order->update([
            'stripe_session_id' => $session->id,
            'stripe_payment_intent' => $session->payment_intent
        ]);

        return redirect($session->url);
    }

    private function buildLineItemsFromCart(): array
    {
        $cart = session('cart', []);
        $lineItems = [];

        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => $item['title'],
                    ],
                    'unit_amount' => (int) ($item['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        return $lineItems;
    }

    private function getCartTotal()
    {
        return collect(session('cart'))->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = Session::retrieve($sessionId);

            $order = Order::where('stripe_session_id', $session->id)->first();

            if ($order) {
                // Double-check payment status
                if ($session->payment_status === 'paid') {
                    $order->update(['status' => 'paid']);
                    session()->forget('cart');
                    return view('checkout.success', compact('order'));
                }
            }
        } catch (\Exception $e) {
            Log::error('Success page error: '.$e->getMessage());
        }

        return redirect()->route('payment.cancel');
    }

    public function cancel()
    {
        return redirect('/cart')->with('error', 'Payment was cancelled. You can try again.');
    }

    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (SignatureVerificationException $e) {
            Log::error('Webhook signature error: '.$e->getMessage());
            return response('Invalid signature', 403);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->fulfillOrder($session);
                break;

            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->updateOrderStatus($paymentIntent->id, 'paid');
                break;

            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->updateOrderStatus($paymentIntent->id, 'failed');
                break;
        }

        return response('Webhook handled', 200);
    }

    protected function fulfillOrder($session)
    {
        $order = Order::where('stripe_session_id', $session->id)->first();

        if ($order && $session->payment_status === 'paid') {
            $order->update([
                'status' => 'paid',
                'stripe_payment_intent' => $session->payment_intent
            ]);

            // Add any order fulfillment logic here
            Log::info("Order #{$order->id} fulfilled via webhook");
        }
    }

    protected function updateOrderStatus($paymentIntentId, $status)
    {
        $order = Order::where('stripe_payment_intent', $paymentIntentId)->first();

        if ($order) {
            $order->update(['status' => $status]);
            Log::info("Order #{$order->id} status updated to {$status} via webhook");
        }
    }
}
