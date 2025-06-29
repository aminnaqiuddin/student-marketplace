<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->where('status', 'active');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = ['New', 'Used'];
        return view('products.create', compact('categories', 'conditions'));
    }

    public function store(Request $request)
    {
        // Validate base rules first
        $baseRules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $request->validate($baseRules);

        // Get category and check if it skips condition
        $category = Category::find($request->category_id);
        $categoryName = strtolower($category->name);
        $skipCondition = in_array($categoryName, ['services', 'food & beverages', 'event tickets']);

        // Dynamically add validation
        $dynamicRules = [];
        if (!$skipCondition) {
            $dynamicRules['condition'] = 'required|in:New,Used';
            $dynamicRules['condition_rating'] = 'nullable|string|max:255';
        }
        $dynamicRules['quantity'] = $categoryName === 'services' ? 'nullable' : 'nullable|integer|min:1';

        $request->validate($dynamicRules);

        // Prepare data
        $skipConditionCategories = ['services', 'food & beverages', 'event tickets'];

        $category = Category::find($request->category_id);
        $categoryName = strtolower($category->name);
        $isConditionRequired = !in_array($categoryName, $skipConditionCategories);

        $productData = [
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'condition' => $isConditionRequired ? $request->condition : null,
            'condition_rating' => ($isConditionRequired && $request->condition === 'Used') ? $request->condition_rating : null,
            'quantity' => in_array($categoryName, $skipConditionCategories) ? null : $request->quantity,
            'status' => 'active',
        ];

        $product = Product::create($productData);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function show(Product $product)
    {
        $similarProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id) // exclude current
            ->latest()
            ->take(4)
            ->get();

        $user = auth()->user();

        // ✅ Define $hasPurchased first
        $hasPurchased = auth()->check() && Order::where('user_id', auth()->id())
            ->where('status', 'paid')
            ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
            ->exists();

        // ✅ Now safely use $hasPurchased
        if (
            $product->status !== 'active' &&
            (!$user || ($user->id !== $product->user_id && !$hasPurchased))
        ) {
            return redirect()->route('products.index')->with('error', 'This product is no longer available.');
        }

        $product->load(['images', 'category', 'user', 'reviews.user']);

        return view('products.show', compact('product', 'similarProducts', 'hasPurchased'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::all();
        $conditions = ['New', 'Used'];
        return view('products.edit', compact('product', 'categories', 'conditions'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        // Validate base fields
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'delete_images.*' => 'nullable|integer|exists:product_images,id',
        ]);

        $category = Category::find($request->category_id);
        $categoryName = strtolower($category->name);
        $skipCondition = in_array($categoryName, ['services', 'food & beverages', 'event tickets']);

        // Conditionally validate extra fields
        if (!$skipCondition) {
            $request->validate([
                'condition' => 'required|in:New,Used',
                'condition_rating' => 'nullable|string|max:255',
            ]);
        }

        $request->validate([
            'quantity' => $categoryName === 'services' ? 'nullable' : 'nullable|integer|min:1',
        ]);

        // Update product fields
        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'condition' => $skipCondition ? null : $request->condition,
            'condition_rating' => (!$skipCondition && $request->condition === 'Used') ? $request->condition_rating : null,
            'quantity' => $skipCondition ? null : $request->quantity,
        ]);

        //  Delete selected images
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    \Storage::disk('public')->delete($image->image_path); // remove from storage
                    $image->delete(); // remove from DB
                }
            }
        }

        //  Upload new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('products.show', $product->id)->with('success', 'Product updated successfully.');
    }


    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function myProducts()
    {
        $products = Auth::user()->products()->latest()->get();
        return view('products.my-products', compact('products'));
    }

    public function rate(Request $request, Product $product)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5']);
        $product->rateOnce($request->rating, auth()->user());
        return back()->with('success', 'Thanks for rating this product!');
    }

    public function toggleStatus(Product $product)
    {
        $this->authorize('update', $product); // Only owner can toggle

        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        return redirect()->back()->with('success', 'Product status updated.');
    }
}
