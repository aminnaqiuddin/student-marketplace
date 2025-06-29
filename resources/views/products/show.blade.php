@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">

    <div class="relative mb-2">
        {{-- Image Carousel --}}
        @if ($product->images->isNotEmpty())
            <div class="swiper mySwiper mb-8">
                <div class="swiper-wrapper">
                    @foreach ($product->images as $image)
                        <div class="swiper-slide border border-black rounded-lg p-2 bg-white">
                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                alt="{{ $product->title }}"
                                class="w-full h-[400px] object-contain rounded-lg bg-white">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-2"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        @else
            <div class="w-full h-[400px] bg-gray-200 flex items-center justify-center rounded-lg text-gray-500 mb-8">
                No Image Available
            </div>
        @endif
    </div>

    {{-- Product + Seller Info --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Product Info -->
        <div class="md:col-span-2 space-y-4">
            <h1 class="text-3xl font-bold text-gray-900">{{ $product->title }}</h1>
            <p class="text-2xl text-black font-semibold">RM {{ number_format($product->price, 2) }}</p>
            {{-- Action Buttons --}}
            <div class="flex items-center gap-2 mt-2">
                <button type="button"
                    onclick="shareProduct()"
                    class="flex items-center px-3 py-1 bg-white text-sm text-gray-800 rounded shadow hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 12v.01M12 4v.01M20 12v.01M12 20v.01M12 12a4 4 0 110-8 4 4 0 010 8z" />
                    </svg>
                    Share
                </button>

                <a href="{{ route('report.product.form', $product->id) }}"
                class="flex items-center px-3 py-1 bg-white text-sm text-red-600 rounded shadow hover:bg-gray-100 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636a9 9 0 11-12.728 0M12 9v4m0 4h.01" />
                    </svg>
                    Report
                </a>
            </div>
            <div class="flex flex-wrap items-center text-sm text-gray-600 gap-4">
                <span class="bg-gray-200 px-3 py-1 rounded-full">
                    Condition:
                    <span class="font-medium text-gray-800">
                        {{ ucfirst($product->condition) }}
                        @if($product->condition === 'Used' && $product->condition_rating)
                            • {{ $product->condition_rating }}
                        @endif
                    </span>
                </span>
                <span class="bg-gray-200 px-3 py-1 rounded-full">
                    Category: <span class="font-medium text-gray-800">{{ $product->category->name ?? 'N/A' }}</span>
                </span>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-800 mt-4 mb-1">Description</h2>
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $product->description }}
                </p>
            </div>
        </div>

        <!-- Seller Info -->
<div class="md:col-span-1 border rounded-lg p-6 shadow-sm bg-white h-fit">
    <h2 class="text-lg font-semibold mb-4">Seller Info</h2>
    <div class="flex items-start space-x-4">
        <!-- Avatar -->
        <div class="h-20 w-20 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
            @if($product->user->avatar)
                <img src="{{ asset('storage/' . $product->user->avatar) }}"
                    class="h-full w-full object-cover"
                    alt="{{ $product->user->name }}">
            @else
                <span class="text-3xl font-bold text-uitm-purple flex items-center justify-center h-full">
                    {{ strtoupper(substr($product->user->name, 0, 1)) }}
                </span>
            @endif
        </div>

        <!-- Seller Details -->
        <div class="flex-1 min-w-0">
            <a href="{{ auth()->check() && auth()->id() === $product->user_id ? route('profile.index') : route('profile.show', $product->user) }}"
               class="text-2xl font-bold text-uitm-purple hover:underline block truncate">
                {{ $product->user->name ?? 'Unknown Seller' }}
            </a>

            @php
                $sellerRating = $product->user->sellerRating();
            @endphp

            @if($sellerRating)
                <div class="flex items-center gap-1 mt-1 flex-wrap">
                    <span class="text-xl font-bold text-gray-800">{{ number_format($sellerRating, 1) }}</span>
                    <div class="flex text-yellow-400 text-lg">
                        @for($i = 1; $i <= 5; $i++)
                            <span>{!! $i <= round($sellerRating) ? '★' : '☆' !!}</span>
                        @endfor
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-500 mt-2">No reviews yet</p>
            @endif
        </div>
    </div>

    <p class="text-gray-500 text-sm mt-4 border-t pt-2">Posted on {{ $product->created_at->format('d M Y') }}</p>

    {{-- Action Buttons --}}
    @if(auth()->check() && auth()->id() === $product->user_id)
        <a href="{{ route('products.edit', $product) }}"
           class="mt-4 block w-full bg-yellow-600 text-white py-2 rounded hover:bg-yellow-700 transition text-center">
            Edit
        </a>
        <form action="{{ route('products.toggleStatus', $product) }}" method="POST" class="mt-2">
            @csrf
            <button type="submit"
                class="w-full py-2 rounded flex items-center justify-center gap-2 font-semibold
                {{ $product->status === 'active'
                    ? 'bg-red-600 hover:bg-red-700 text-white'
                    : 'bg-green-600 hover:bg-green-700 text-white' }}">

                @if($product->status === 'active')
                    <!-- Deactivate Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Deactivate Listing
                @else
                    <!-- Activate Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Activate Listing
                @endif
            </button>
        </form>
        <form id="delete-product-form" action="{{ route('products.destroy', $product) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" id="delete-product-btn"
                    class="mt-4 w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
                Delete
            </button>
        </form>
    @else
        @auth
            <a href="{{ route('chatify') }}?id={{ $product->user_id }}"
            class="block w-full bg-uitm-purple text-white py-2 rounded hover:bg-uitm-purple-dark transition text-center mt-4">
                Message Seller
            </a>
            <form action="{{ route('checkout.buyNow') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Buy
                </button>
            </form>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Add to Cart
                </button>
            </form>
        @else
            <p class="mt-4 text-center text-gray-600">Please <a href="{{ route('login') }}" class="text-blue-600 underline">login</a> to interact with this listing.</p>
        @endauth
    @endif
</div>

    </div>
</div>

{{-- Section Divider --}}
<hr class="max-w-7xl mx-auto border-t-4 border-gray-400 my-12" />

{{--  Full-width Reviews Section Aligned with Product --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2">
            {{-- Customer Reviews --}}
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center gap-3">
                    <span class="text-yellow-500 text-2xl font-bold">
                        {{ number_format($product->averageRating, 1) ?? '0.0' }}
                    </span>
                    <div class="flex text-yellow-400 text-xl">
                        @for ($i = 1; $i <= 5; $i++)
                            <span>{!! $i <= round($product->averageRating) ? '★' : '☆' !!}</span>
                        @endfor
                    </div>
                    <span class="text-gray-700 text-lg font-medium">
                        Product Reviews / Ratings ({{ $product->reviews->count() }})
                    </span>
                </h2>
                @if($product->reviews->isEmpty())
                    <p class="text-gray-600">No reviews yet. Be the first to review this product!</p>
                @else
                    <div class="space-y-4">
                        @foreach($product->reviews as $review)
                            <div class="border rounded-lg p-4 bg-white shadow-sm">
                                <div class="flex justify-between items-center mb-1">
                                    <p class="font-semibold text-gray-800">{{ $review->user->name }}</p>
                                    <span class="text-yellow-500">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967..." />
                                            </svg>
                                        @endfor
                                    </span>
                                </div>
                                @if($review->comment)
                                    <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Leave a Review Form --}}
            @auth
                @if($hasPurchased && auth()->id() !== $product->user_id && !$product->reviews->contains('user_id', auth()->id()))
                    <div id="review">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Leave a Review</h3>
                        <form action="{{ route('products.reviews.store', $product) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                                <select name="rating" id="rating" required class="w-full border rounded px-3 py-2">
                                    <option value="">-- Select --</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label for="comment" class="block text-sm font-medium text-gray-700">Comment (optional)</label>
                                <textarea name="comment" id="comment" rows="4" class="w-full border rounded px-3 py-2" placeholder="Write your review here..."></textarea>
                            </div>
                            <button type="submit" class="bg-uitm-purple text-white px-4 py-2 rounded hover:bg-uitm-purple-dark">
                                Submit Review
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>

{{-- Section Divider --}}
<hr class="max-w-7xl mx-auto border-t-4 border-gray-400 my-12" />

{{-- Similar Listings --}}
@if($similarProducts->isNotEmpty())
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 mb-20">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Similar Listings</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($similarProducts as $product)
                <a href="{{ route('products.show', $product->id) }}"
                   class="block border p-4 rounded-lg shadow-md transition duration-300 bg-white group hover:shadow-lg">

                    <!-- Image -->
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

                    <!-- Title -->
                    <h2 class="text-lg font-semibold mb-1 text-gray-900">{{ $product->title }}</h2>

                    <!-- Price -->
                    <p class="text-uitm-purple font-bold mb-2">RM {{ number_format($product->price, 2) }}</p>

                    <!-- Condition -->
                    <p class="text-sm text-gray-600">
                        {{ ucfirst($product->condition) }}
                        @if ($product->condition === 'Used' && $product->condition_rating)
                            <span class="ml-2 inline-block text-yellow-700 text-xs bg-yellow-100 px-2 py-0.5 rounded">
                                {{ $product->condition_rating }}
                            </span>
                        @endif
                    </p>
                </a>
            @endforeach
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper(".mySwiper", {
        loop: true,
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
        640: {
            slidesPerView: 1,
        },
        1024: {
            slidesPerView: 1,
        }
    }
    });

    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $product->title }}',
                text: 'Check out this product on UniMarketplace!',
                url: window.location.href
            }).then(() => {
                console.log('Thanks for sharing!');
            }).catch((err) => {
                console.error('Share failed:', err.message);
            });
        } else {
            alert('Sharing is not supported in this browser. You can copy the URL manually.');
        }
    }
</script>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('delete-product-btn')?.addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "This product will be permanently deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-product-form').submit();
            }
        });
    });
</script>
@endpush
