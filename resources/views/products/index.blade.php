@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 mb-20">

    <!-- 🔸 Browse Categories Header -->
    <h2 class="text-xl font-bold mb-4 text-gray-800">Browse Categories</h2>

    <!-- Category Slider -->
    <div class="mb-8 relative">
        <div class="swiper categorySwiper">
            <div class="swiper-wrapper">
                @php
                    $categories = [
                        ['id' => 1, 'name' => "Men's Fashion", 'icon' => '🧥'],
                        ['id' => 2, 'name' => "Women's Fashion", 'icon' => '👗'],
                        ['id' => 3, 'name' => "Books & Stationery", 'icon' => '📚'],
                        ['id' => 4, 'name' => "Laptops & Accessories", 'icon' => '💻'],
                        ['id' => 5, 'name' => "Mobile Phones & Gadgets", 'icon' => '📱'],
                        ['id' => 6, 'name' => "Sports & Outdoors", 'icon' => '🏀'],
                        ['id' => 7, 'name' => "Services", 'icon' => '🛠️'],
                        ['id' => 8, 'name' => "Video Games & Consoles", 'icon' => '🎮'],
                        ['id' => 9, 'name' => "Audio Equipment", 'icon' => '🎧'],
                        ['id' => 10, 'name' => "Photography", 'icon' => '📷'],
                        ['id' => 11, 'name' => "Food & Beverages", 'icon' => '🍔'],
                        ['id' => 12, 'name' => "Event Tickets", 'icon' => '🎟️'],
                    ];

                    $selectedCategory = null;
                    if(request('category')) {
                        foreach ($categories as $cat) {
                            if ($cat['id'] == request('category')) {
                                $selectedCategory = $cat;
                                break;
                            }
                        }
                    }
                @endphp

                @foreach ($categories as $cat)
                    <div class="swiper-slide w-36 h-28 min-w-0 box-border">
                        <a href="{{ route('products.index', ['category' => $cat['id']]) }}"
                            class="w-full h-full flex flex-col justify-start items-center bg-white border border-gray-200 rounded-lg shadow-sm text-center hover:bg-gray-100 transition-all duration-200 overflow-hidden px-2 py-3">

                            <!-- Icon -->
                            <div class="text-2xl h-8 flex items-center justify-center mb-1">
                                {{ $cat['icon'] }}
                            </div>

                            <!-- Name with fixed height -->
                            <div class="text-xs font-medium text-gray-700 text-center px-2 h-10 leading-tight overflow-hidden line-clamp-2 break-words">
                                {{ $cat['name'] }}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Arrows -->
            <div class="swiper-button-prev text-uitm-purple"></div>
            <div class="swiper-button-next text-uitm-purple"></div>
        </div>
    </div>

    <!-- 🔸 Dynamic Header for Category or All Products -->
    <h2 class="text-xl font-bold mb-4 text-gray-800">
        @if ($selectedCategory)
            {{ $selectedCategory['name'] }}
        @else
            Explore Products
        @endif
    </h2>

    <!-- Product Grid or Empty Message -->
    @if ($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <a href="{{ route('products.show', $product->id) }}"
                   class="block border p-4 rounded-lg shadow-md transition duration-300 bg-white group hover:shadow-lg">

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
                    <h2 class="text-lg font-semibold mb-1 text-gray-900">{{ $product->title }}</h2>
                    <p class="text-uitm-purple font-bold mb-2">RM {{ number_format($product->price, 2) }}</p>

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

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <p class="text-center text-gray-500 mt-8 text-sm">
            No products available{{ $selectedCategory ? ' in this category yet.' : ' yet.' }}
        </p>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    const categorySwiper = new Swiper(".categorySwiper", {
        slidesPerView: 2.3,
        spaceBetween: 12,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: { slidesPerView: 4.5 },
            768: { slidesPerView: 6 },
            1024: { slidesPerView: 8 },
        },
    });
</script>
@endpush
