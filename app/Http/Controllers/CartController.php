<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    // Display cart contents
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Add product to cart
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Check if this product is already in cart
        if (isset($cart[$product->id])) {
            // If product has quantity (repeatable item), respect its stock limit
            if ($product->quantity !== null) {
                if ($cart[$product->id]['quantity'] < $product->quantity) {
                    $cart[$product->id]['quantity']++;
                } else {
                    return redirect()->route('cart.index')->with('error', 'You have reached the maximum stock for this product.');
                }
            } else {
                // Product is unique (like service) — do not add again
                return redirect()->route('cart.index')->with('error', 'This item is already in your cart.');
            }
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => 1,
                'image_path' => $product->images->first()?->image_path ?? null,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    // Remove product from cart
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    // Clear entire cart
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    // Show the checkout form
    public function showCheckoutForm()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('cart.checkout', compact('cart'));
    }

    // Handle checkout form submission and create order
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
        ]);

        // Calculate total price
        $total = collect($cart)->reduce(function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'total_price' => $total,
            'status' => 'pending',
        ]);

        // Create order items + deduct stock
        foreach ($cart as $productId => $item) {
            if (!is_numeric($productId) || empty($item['title'])) {
                Log::warning("Skipped invalid cart item", ['product_id' => $productId, 'item' => $item]);
                continue;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => (int) $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'title' => $item['title'],
            ]);

            $product = Product::find((int)$productId);
            if ($product && $product->quantity !== null) {
                $product->quantity -= $item['quantity'];

                if ($product->quantity <= 0) {
                    $product->quantity = 0;
                    $product->status = 'sold';
                }

                $product->save();
            }
        }

        // Clear cart session
        session()->forget('cart');

        return redirect()->route('checkout.success')->with('success', 'Order created successfully. Proceed with payment.');
    }

    // Thank you page (optional but recommended for cleaner UX)
    public function success()
    {
        return view('cart.success');
    }
}
