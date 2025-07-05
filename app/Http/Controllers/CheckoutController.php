<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Notifications\ProductSoldNotification;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\ApiErrorException;

class CheckoutController extends Controller
{
    public function index()
    {
        if (session()->has('buy_now')) {
            $item = session('buy_now');
            $product = Product::findOrFail($item['product_id']);
            $product->quantity = $item['quantity'];
            $cart = [
                $product->id => [
                    'title' => $product->title,
                    'price' => $product->price,
                    'quantity' => $product->quantity
                ]
            ];
        } else {
            $cart = session('cart', []);
        }

        if (empty($cart)) {
            return redirect()->route('products.index')->with('warning', 'Your cart is empty');
        }

        $totalPrice = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);

        return view('checkout.index', [
            'cart' => $cart,
            'totalPrice' => $totalPrice
        ]);
    }

    public function buyNow(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        session()->put('buy_now', [
            'product_id' => $product->id,
            'title' => $product->title,
            'price' => $product->price,
            'quantity' => 1
        ]);

        return redirect()->route('checkout.index');
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:1000',
            'phone' => 'sometimes|string|max:20'
        ]);

        $cart = session()->has('buy_now')
            ? [session('buy_now.product_id') => session('buy_now')]
            : session('cart', []);

        if (empty($cart)) {
            return redirect()->route('checkout.index')->with('error', 'Your cart is empty');
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'phone' => $validated['phone'] ?? null,
            'total_price' => $this->calculateCartTotal($cart),
            'status' => 'pending',
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'title' => $item['title'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        $successUrl = url("/checkout/success/{$order->id}/__SESSION_ID__");

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $this->buildLineItems($cart),
                'mode' => 'payment',
                'success_url' => str_replace('__SESSION_ID__', '{CHECKOUT_SESSION_ID}', $successUrl),
                'cancel_url' => route('checkout.cancel'),
                'customer_email' => $validated['email'],
                'metadata' => ['order_id' => $order->id],
            ]);

            $order->update(['stripe_session_id' => $session->id]);

            return redirect($session->url);

        } catch (ApiErrorException $e) {
            Log::error('Stripe session creation error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'cart' => $cart,
            ]);
            return back()->with('error', 'Payment processing error. Please try again.');
        }
    }

    public function paymentSuccess($orderId, $sessionId)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = StripeSession::retrieve($sessionId);
            $order = Order::findOrFail($orderId);

            if (
                $session->payment_status !== 'paid' ||
                $session->metadata->order_id != $orderId ||
                $order->stripe_session_id !== $session->id
            ) {
                throw new \Exception('Payment validation failed');
            }

            if ($order->status !== 'paid') {
                $order->update([
                    'status' => 'paid',
                    'stripe_payment_intent' => $session->payment_intent
                ]);

                session()->forget('cart');
                session()->forget('buy_now');

                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product && $product->status === 'active') {
                        $product->status = 'sold';
                        $product->save();

                        if ($product->user) {
                            $product->user->notify(new ProductSoldNotification($item));
                        }
                    }
                }
            }

            return view('checkout.success', [
                'order' => $order,
                'payment_id' => $session->payment_intent
            ]);

        } catch (\Exception $e) {
            Log::error('Payment success error: ' . $e->getMessage());
            return redirect()->route('checkout.cancel');
        }
    }

    public function paymentCancel()
    {
        return redirect()->route('cart.index')->with('warning', 'Payment was cancelled. Your cart has been saved.');
    }

    protected function calculateCartTotal($cart): float
    {
        return array_reduce($cart, fn($total, $item) => $total + ($item['price'] * $item['quantity']), 0);
    }

    protected function buildLineItems($cart): array
    {
        return array_values(array_map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => $item['title'],
                    ],
                    'unit_amount' => intval(floatval($item['price']) * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }, $cart));
    }
}
