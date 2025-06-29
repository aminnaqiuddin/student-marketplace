<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReport;
use App\Models\Product;

class ProductReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'reason' => 'required|string|max:1000',
        ]);

        ProductReport::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Thank you for reporting this product.');
    }

    public function create(Product $product)
    {
        return view('products.report', compact('product'));
    }
}
