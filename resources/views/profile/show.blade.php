@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js" defer></script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20" x-data="{ activeTab: 'listings' }">
    <!-- Seller Profile Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex items-center space-x-4">
            <div class="h-20 w-20 rounded-full bg-gray-200 overflow-hidden">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="h-full w-full object-cover" alt="{{ $user->name }}">
                @else
                    <span class="text-3xl font-bold text-uitm-purple flex items-center justify-center h-full">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                @endif
            </div>
            <div>
                <h1 class="text-2xl font-bold text-uitm-purple flex items-center gap-2">
                    {{ $user->name }}
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
                </h1>

                <p class="text-gray-500">Seller since {{ $user->created_at->format('F Y') }}</p>

                @if($averageRating)
                    <div class="flex items-center mt-2">
                        <span class="font-bold text-lg mr-2">{{ number_format($averageRating, 1) }}</span>
                        @for($i = 1; $i <= 5; $i++)
                            <span class="text-yellow-400 text-lg">
                                {!! $i <= round($averageRating) ? '★' : '☆' !!}
                            </span>
                        @endfor
                    </div>
                @else
                    <p class="text-sm text-gray-500 mt-2">No reviews yet</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <button @click="activeTab = 'listings'"
                    :class="{
                        'border-uitm-purple text-uitm-purple': activeTab === 'listings',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'listings'
                    }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Listings
            </button>
            {{-- Placeholder for future reactivation of reviews --}}
            <button @click="activeTab = 'reviews'"
                    :class="{
                        'border-uitm-purple text-uitm-purple': activeTab === 'reviews',
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'reviews'
                    }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Reviews
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div>
        <!-- Listings Tab -->
        <div x-show="activeTab === 'listings'" x-transition>
            @if($products->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-600">
                    This seller hasn't listed any products yet.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        @include('products.partials.card', ['product' => $product])
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

        <!-- Reviews Tab -->
        <div x-show="activeTab === 'reviews'" x-transition>
            <h2 class="text-xl font-semibold mb-4 sr-only">Seller Reviews</h2>
            @if($reviews->isEmpty())
                <div class="bg-white rounded-lg shadow p-6 text-center text-gray-600">
                    No reviews yet.
                </div>
            @else
                <div class="bg-white rounded-lg shadow divide-y divide-gray-200">
                    @foreach($reviews as $review)
                        <div class="p-6">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="font-medium">{{ $review->reviewer->name }}</span>
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>{!! $i <= $review->rating ? '★' : '☆' !!}</span>
                                    @endfor
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="text-gray-700">{{ $review->comment }}</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-2">{{ $review->created_at->format('M d, Y') }}</p>
                        </div>
                    @endforeach
                    <div class="p-4">
                        {{ $reviews->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
