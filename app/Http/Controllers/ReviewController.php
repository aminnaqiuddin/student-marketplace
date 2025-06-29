<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Prevent duplicate reviews
        //$existing = $product->reviews()->where('user_id', auth()->id())->first();
        //if ($existing) {
            //return back()->with('error', 'You have already reviewed this product.');
        //}

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('products.show', $product)->with('success', 'Review submitted!');
        }
}
