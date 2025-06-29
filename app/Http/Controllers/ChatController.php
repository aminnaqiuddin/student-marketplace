<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function show(Product $product)
    {
        $currentUser = Auth::user();
        $seller = $product->user; // assuming 'user' is the relationship on the Product model

        return view('chat', compact('product', 'seller'));
    }
}
