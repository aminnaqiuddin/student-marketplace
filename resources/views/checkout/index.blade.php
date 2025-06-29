@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">
        {{ isset($product) ? 'Buy Now' : 'Confirm Your Order' }}
    </h2>

    @if(isset($product))
        {{-- BUY NOW FLOW --}}
        <div class="bg-white shadow-md rounded-lg p-6 space-y-4">
            <div class="flex justify-between items-center border-b pb-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $product->title }}</h3>
                    <p class="text-sm text-gray-600">Quantity: 1</p>
                </div>
                <div class="text-right text-gray-800 font-medium">
                    RM {{ number_format($product->price, 2) }}
                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t">
                <span class="text-xl font-bold text-gray-800">Total:</span>
                <span class="text-xl font-bold text-gray-800">RM {{ number_format($product->price, 2) }}</span>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">Please fix the following errors:</span>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.process') }}" method="POST" class="mt-6 space-y-4 bg-white p-4 rounded border border-gray-200">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="buy_now" value="1">

                <h3 class="text-lg font-bold text-gray-800">Shipping Information</h3>

                <div>
                    <label for="name" class="block font-medium">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                </div>

                <div>
                    <label for="email" class="block font-medium">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror">
                </div>

                <div>
                    <label for="address" class="block font-medium">Address</label>
                    <textarea name="address" id="address" required
                        class="w-full border rounded px-3 py-2 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                    Place Order
                </button>
            </form>
        </div>

    @elseif(count($cart) > 0)
        {{-- CART CHECKOUT FLOW --}}
        <div class="bg-white shadow-md rounded-lg p-6 space-y-4">
            @foreach($cart as $item)
                <div class="flex justify-between items-center border-b pb-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $item['title'] }}</h3>
                        <p class="text-sm text-gray-600">Quantity: {{ $item['quantity'] }}</p>
                    </div>
                    <div class="text-right text-gray-800 font-medium">
                        RM {{ number_format($item['price'] * $item['quantity'], 2) }}
                    </div>
                </div>
            @endforeach

            <div class="flex justify-between items-center pt-4 border-t">
                <span class="text-xl font-bold text-gray-800">Total:</span>
                <span class="text-xl font-bold text-gray-800">RM {{ number_format($totalPrice, 2) }}</span>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">Please fix the following errors:</span>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.process') }}" method="POST" class="mt-6 space-y-4 bg-white p-4 rounded border border-gray-200">
                @csrf

                <h3 class="text-lg font-bold text-gray-800">Shipping Information</h3>

                <div>
                    <label for="name" class="block font-medium">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
                </div>

                <div>
                    <label for="email" class="block font-medium">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror">
                </div>

                <div>
                    <label for="address" class="block font-medium">Address</label>
                    <textarea name="address" id="address" required
                        class="w-full border rounded px-3 py-2 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                    Place Order
                </button>
            </form>
        </div>
    @else
        <div class="bg-yellow-50 text-yellow-800 border-l-4 border-yellow-400 p-4 rounded">
            <p>Your cart is empty. <a href="{{ route('products.index') }}" class="underline font-medium">Browse products</a>.</p>
        </div>
    @endif
</div>
@endsection
