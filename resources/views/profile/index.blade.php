@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js" defer></script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20" x-data="{ activeTab: 'orders' }">
    <!-- User Info Box -->
    <div class="bg-white rounded-lg shadow p-6 mb-8 flex items-start space-x-6">
        <!-- Avatar on the left -->
        <div class="h-20 w-20 rounded-full bg-gray-200 overflow-hidden">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" class="h-full w-full object-cover" alt="{{ $user->name }}">
            @else
                <span class="text-3xl font-bold text-uitm-purple flex items-center justify-center h-full">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            @endif
        </div>

        <!-- User details -->
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <h1 class="text-2xl font-bold text-uitm-purple">{{ $user->name }}</h1>

                    @if($user->email_verified_at)
                        <span class="inline-flex items-center text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Verified
                        </span>
                    @endif
                </div>

                <a href="{{ route('profile.edit') }}" class="text-sm text-uitm-purple hover:underline">
                    Edit Profile
                </a>
            </div>


            <p class="text-sm text-gray-500 mt-1">Joined {{ $user->created_at->format('F d, Y') }}</p>

            <!-- Average Rating -->
            @if($averageRating)
                <div class="flex items-center mt-2">
                    <span class="text-xl font-bold text-gray-800 mr-2">{{ number_format($averageRating, 1) }}</span>
                    @for($i = 1; $i <= 5; $i++)
                        <span class="text-yellow-400 text-xl">
                            {!! $i <= round($averageRating) ? '★' : '☆' !!}
                        </span>
                    @endfor
                </div>
            @else
                <p class="text-sm text-gray-500 mt-2">No reviews yet</p>
            @endif
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <button @click="activeTab = 'orders'"
                    :class="{
                        'border-uitm-purple text-uitm-purple': activeTab === 'orders',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'orders'
                    }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                My Orders
            </button>
            <button @click="activeTab = 'listings'"
                    :class="{
                        'border-uitm-purple text-uitm-purple': activeTab === 'listings',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'listings'
                    }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                My Listings
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div>
        <!-- Orders Tab -->
        <div x-show="activeTab === 'orders'" x-transition class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold">My Orders</h2>
            </div>

            @if($orders->isEmpty())
                <div class="p-6 text-center text-gray-600">
                    You haven't placed any orders yet.
                </div>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <li class="p-6 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex items-start space-x-4">
                                @php
                                    $firstItem = $order->items->first();
                                    $product = $firstItem?->product;
                                    $image = $product?->images->first()?->image_path ?? null;
                                @endphp

                                <!-- Product Thumbnail -->
                                @if($image)
                                    <img src="{{ asset('storage/' . $image) }}"
                                        alt="{{ $product->title }}"
                                        class="w-20 h-20 object-cover rounded border">
                                @else
                                    <div class="w-20 h-20 bg-gray-100 rounded flex items-center justify-center border text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                                        </svg>
                                    </div>
                                @endif

                                <!-- Order Summary -->
                                <div>
                                    <p class="font-medium text-gray-900">Order #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-700 mt-1">
                                        {{ $product?->title ?? 'Unknown Product' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Order Status Badge -->
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <div class="mt-3 flex justify-between items-center">
                            <p class="text-gray-700 font-semibold">
                                RM {{ number_format($order->total_price, 2) }}
                            </p>
                            <a href="{{ route('orders.show', $order) }}" class="text-sm text-uitm-purple hover:underline">
                                View Details
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>

                <div class="px-6 py-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

        <!-- Listings Tab -->
        <div x-show="activeTab === 'listings'" x-transition>
            <div class="px-6 py-4 border-b border-gray-200 bg-white rounded-t-lg">
                <h2 class="text-xl font-semibold">My Listings</h2>
            </div>

            @if($products->isEmpty())
                <div class="bg-white p-6 rounded-b-lg text-center text-gray-600">
                    You haven't listed any products yet.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 p-6 bg-white rounded-b-lg">
                    @foreach($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="block border p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300 bg-white group">
                        @if($product->images->count() > 0)
                            <div class="aspect-w-1 aspect-h-1 w-full bg-gray-100 rounded-lg overflow-hidden border mb-4">
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                     alt="{{ $product->title }}"
                                     class="object-cover w-full h-full transition duration-300 group-hover:scale-105">
                            </div>
                        @else
                            <div class="aspect-w-1 aspect-h-1 w-full bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 border mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        @if($product->status === 'sold')
                            <span class="inline-block mb-2 px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded">
                                Sold
                            </span>
                        @endif

                        <h3 class="text-lg font-semibold mb-1 text-gray-900">{{ $product->title }}</h3>
                        <p class="text-uitm-purple font-bold mb-2">RM {{ number_format($product->price, 2) }}</p>
                        <p class="text-sm text-gray-600">{{ ucfirst($product->condition) }}</p>
                        <p class="text-xs text-gray-500 mt-2">{{ $product->created_at->diffForHumans() }}</p>
                    </a>
                    @endforeach
                </div>
                <div class="bg-white px-6 py-4 rounded-b-lg">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
