@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <div class="bg-white rounded-lg shadow-lg p-8 text-center max-w-xl mx-auto">

        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="bg-green-100 p-4 rounded-full">
                <svg class="h-16 w-16 text-green-600 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        <!-- Heading -->
        <h2 class="text-3xl font-bold text-green-700 mb-2">Payment Successful!</h2>
        <p class="text-lg text-gray-700">Thank you for your order 🎉</p>

        <!-- Order Details -->
        <div class="mt-4 mb-4 space-y-1 text-gray-700 text-lg">
            <p>Order ID: <span class="font-semibold">#{{ $order->id }}</span></p>
            <p>Payment ID: <span class="font-semibold">{{ $payment_id }}</span></p>
            <p>Total Paid: <span class="font-bold text-green-800 text-2xl">RM{{ number_format($order->total_price, 2) }}</span></p>
        </div>

        <!-- Continue Button -->
        <a href="{{ route('products.index') }}"
           class="inline-block mt-6 px-6 py-3 bg-uitm-purple text-white text-lg rounded-lg hover:bg-uitm-purple-dark transition">
           Continue Shopping
        </a>
    </div>
</div>
@endsection
