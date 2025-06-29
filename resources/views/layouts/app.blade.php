<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Chatify CSS (loaded after other styles) -->
    <link href="{{ asset('css/chatify.css') }}" rel="stylesheet">

    <!-- Inject page-specific styles -->
    @stack('styles')

    <!-- Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/chatify-auto-open.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-white text-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <!-- jQuery (required for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Pusher & Chatify JS (for authenticated users only) -->
    @auth
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script>
            window.Pusher = Pusher;
            window.chatify = {
                authId: {{ Auth::id() }},
                authName: "{{ Auth::user()->name }}",
                autoOpenUserId: new URLSearchParams(window.location.search).get('id')
            };
        </script>
        <script src="{{ asset('js/chatify.js') }}"></script>
    @endauth

    <!-- Stack scripts for Swiper -->
    @stack('scripts')

     <script>
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif

        @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif
    </script>


    <!-- Footer -->
    <footer class="bg-uitm-purple text-white border-t border-uitm-gold">
        <div class="max-w-7xl mx-auto px-6 py-12 sm:px-10 lg:px-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-y-10 gap-x-8">
                <!-- Categories -->
                <div class="min-h-[260px]">
                    <h5 class="font-bold text-lg mb-3">Categories</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-uitm-gold">Mens' Fashion</a></li>
                        <li><a href="#" class="hover:text-uitm-gold">Women's Fashion</a></li>
                        <li><a href="#" class="hover:text-uitm-gold">Books & Stationery</a></li>
                        <li><a href="#" class="hover:text-uitm-gold">Laptops & Accessories</a></li>
                        <li><a href="#" class="hover:text-uitm-gold">Mobile Phones & Gadgets</a></li>
                        <li><a href="#" class="hover:text-uitm-gold">Sports & Outdoors</a></li>
                        <li><a href="#" class="hover:text-uitm-gold">Services</a></li>
                        <li><a href="#" class="hover:text-uitm-gold">Video Games & Consoles</a></li>
                        <li><a href="#" class="hover:text-uitm-gold">Audio Equipment</a></li>
                        <li><a href="#" class="hover:text-uitm-gold">Photography</a></li>
                        <li><a href="#" class="hover:text-uitm-gold">Food & Beverages</a></li>
                        <li><a href="#" class="hover:text-uitm-gold">Event Tickets</a></li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div class="min-h-[260px]">
                    <h5 class="font-bold text-lg mb-3">Quick Links</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('products.index') }}" class="hover:text-uitm-gold">Browse Products</a></li>
                        <li><a href="{{ route('products.create') }}" class="hover:text-uitm-gold">Sell Item</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-uitm-gold">My Cart</a></li>
                    </ul>
                </div>

                <!-- About -->
                <div class="min-h-[260px]">
                    <h5 class="font-bold text-lg mb-3">About</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-uitm-gold">About Us</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-uitm-gold">Terms & Conditions</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-uitm-gold">Privacy Policy</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-uitm-gold">Frequently Asked Questions</a></li>
                    </ul>
                </div>

                <!-- Connect -->
                <div class="min-h-[260px] flex flex-col justify-between">
                    <div>
                        <h5 class="font-bold text-lg mb-3">Connect</h5>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-uitm-gold">Facebook</a></li>
                            <li><a href="#" class="hover:text-uitm-gold">Instagram</a></li>
                            <li><a href="#" class="hover:text-uitm-gold">Support</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-12 border-t border-uitm-gold pt-6 text-sm text-center text-gray-300">
                &copy; {{ date('Y') }} <span class="text-white font-semibold">UniTrade</span>. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
