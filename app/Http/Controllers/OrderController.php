<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Assuming you have a 'orders' relationship in User model
        $orders = $user->orders()->with('product')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    //order show
    public function show(Order $order)
    {
        $this->authorize('view', $order); // optional if you're using policies

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

}

