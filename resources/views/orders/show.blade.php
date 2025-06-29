@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <h2 class="text-2xl font-bold text-uitm-purple mb-6">Order Details</h2>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Order ID: {{ $order->id }}</h3>
            <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('F j, Y') }}</p>
        </div>

        <div class="mb-6">
            <h4 class="text-md font-semibold text-gray-600 mb-2">Products</h4>

            @foreach ($order->items as $item)
            <div class="flex items-center space-x-4 border rounded-lg p-4 mb-4">
                <!-- Product Image -->
                @if ($item->product && $item->product->images->first())
                    <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                         alt="{{ $item->product->title }}"
                         class="w-20 h-20 object-cover rounded border">
                @else
                    <div class="w-20 h-20 bg-gray-100 rounded flex items-center justify-center border text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                        </svg>
                    </div>
                @endif

                <!-- Product Info -->
                <div>
                    <p class="font-semibold text-gray-800">{{ $item->product->title ?? 'Unknown Product' }}</p>
                    <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                    <p class="text-sm text-gray-600">Price: RM {{ number_format($item->price, 2) }}</p>

                    @if ($order->status === 'paid' && $item->product)
                        <a href="{{ route('products.show', ['product' => $item->product->id, '#review']) }}"
                        class="inline-block mt-2 text-sm text-uitm-purple font-semibold hover:underline">
                            Write a Review
                        </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mb-4">
            <h4 class="text-md font-semibold text-gray-600">Status</h4>
            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600') }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="mb-4">
            <h4 class="text-md font-semibold text-gray-600">Total Price</h4>
            <p class="text-gray-700 font-semibold">RM {{ number_format($order->total_price, 2) }}</p>
        </div>
    </div>
</div>
@endsection
