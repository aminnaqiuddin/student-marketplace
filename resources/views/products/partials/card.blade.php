<!-- resources/views/products/partials/card.blade.php -->
<a href="{{ route('products.show', $product->id) }}" class="block border p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300 bg-white group">

    <!-- Image with aspect ratio -->
    @if ($product->images->first())
        <div class="aspect-w-1 aspect-h-1 w-full bg-gray-100 rounded-lg overflow-hidden border mb-4">
            <img
                src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                alt="{{ $product->title }}"
                class="object-cover w-full h-full transition duration-300 group-hover:scale-105"
            >
        </div>
    @else
        <div class="aspect-w-1 aspect-h-1 w-full bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 border mb-4">
            No Image
        </div>
    @endif

    <!-- Product Details -->
    <h2 class="text-lg font-semibold mb-1 text-gray-900 truncate">{{ $product->title }}</h2>
    <p class="text-black-600 font-bold mb-2">RM {{ number_format($product->price, 2) }}</p>
    <p class="text-sm text-gray-600">{{ ucfirst($product->condition) }}</p>

</a>
