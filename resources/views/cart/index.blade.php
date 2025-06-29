@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Your Shopping Cart</h2>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="space-y-4">
            @php $totalPrice = 0; @endphp

            @foreach(session('cart') as $id => $item)
                @php
                    $itemTotal = $item['price'] * $item['quantity'];
                    $totalPrice += $itemTotal;
                @endphp
                <div class="bg-white shadow-md rounded-lg p-4 flex gap-4 items-center">
                    <!-- Thumbnail Image -->
                    <div class="w-24 h-24 flex-shrink-0 bg-gray-100 border rounded overflow-hidden">
                        @if (!empty($item['image_path']))
                            <img src="{{ asset('storage/' . $item['image_path']) }}"
                                 alt="{{ $item['title'] }}"
                                 class="object-cover w-full h-full">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                                No Image
                            </div>
                        @endif
                    </div>

                    <!-- Item Details -->
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $item['title'] }}</h3>
                        <p class="text-sm text-gray-600">Price: RM {{ number_format($item['price'], 2) }}</p>
                        <p class="text-sm text-gray-600">Quantity: {{ $item['quantity'] }}</p>
                        <p class="text-sm text-gray-800 font-medium">Subtotal: RM {{ number_format($itemTotal, 2) }}</p>
                    </div>

                    <!-- Remove Button -->
                    <div>
                        <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                            @csrf
                            <button type="submit"
                                class="text-red-600 hover:text-red-800 font-semibold hover:underline transition">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total, Checkout, and Clear Cart -->
        <div class="mt-8 flex flex-col sm:flex-row justify-between items-center border-t pt-4 gap-4">
            <span class="text-xl font-bold text-gray-800">Total: RM {{ number_format($totalPrice, 2) }}</span>

            <div class="flex gap-4">
                <!-- Clear Cart Button -->
                <form id="clear-cart-form" action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="button"
                        id="clear-cart-btn"
                        class="bg-red-500 text-white px-5 py-2 rounded hover:bg-red-600 transition">
                        Clear Cart
                    </button>
                </form>

                <!-- Checkout Button -->
                <a href="{{ route('checkout.index') }}"
                   class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 text-yellow-800 border-l-4 border-yellow-400 p-4 rounded">
            <p>Your cart is currently empty.</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('clear-cart-btn').addEventListener('click', function (e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will remove all items from your cart.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, clear it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('clear-cart-form').submit();
            }
        });
    });
</script>
@endpush

