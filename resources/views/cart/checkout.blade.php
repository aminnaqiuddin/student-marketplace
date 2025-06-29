@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <h2 class="text-3xl font-bold mb-6">Checkout</h2>

    <form action="{{ route('cart.checkout.process') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Name</label>
            <input
                type="text"
                name="name"
                id="name"
                required
                class="w-full border px-3 py-2 rounded"
                value="{{ old('name') }}"
            >
        </div>

        <div class="mb-4">
            <label for="email" class="block font-semibold mb-1">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                required
                class="w-full border px-3 py-2 rounded"
                value="{{ old('email') }}"
            >
        </div>

        <div class="mb-4">
            <label for="address" class="block font-semibold mb-1">Address</label>
            <textarea
                name="address"
                id="address"
                rows="3"
                required
                class="w-full border px-3 py-2 rounded"
            >{{ old('address') }}</textarea>
        </div>

        <button
            type="submit"
            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition"
        >
            Place Order
        </button>
    </form>
</div>
@endsection
