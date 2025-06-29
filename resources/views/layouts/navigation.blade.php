@php
    use Illuminate\Support\Facades\Auth;
@endphp

<nav x-data="{ open: false, menuOpen: false, notifyOpen: false }" class="bg-uitm-purple border-b border-uitm-gold text-white">
    <style>[x-cloak] { display: none !important; }</style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 gap-4">
            <!-- Logo & Sell Button -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('products.index') }}" class="text-xl font-bold text-white">
                    UniTrade
                </a>
                @auth
                    <a href="{{ route('products.create') }}"
                        class="bg-uitm-gold text-white px-4 py-1.5 rounded-md text-base font-semibold shadow hover:brightness-105 transition flex items-center">
                        Sell
                    </a>
                @endauth
            </div>

            <!-- Search (centered) -->
            <div class="hidden sm:flex flex-1 justify-center px-4 mx-auto">
                <form action="{{ route('products.index') }}" method="GET" class="relative w-full max-w-md">
                    <input type="search" name="search" placeholder="Search products..."
                        class="w-full pl-4 pr-10 py-2 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-uitm-gold">
                    <button type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-uitm-purple hover:text-uitm-gold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Right Icons -->
            <div class="hidden sm:flex items-center space-x-4">
                @auth
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="flex items-center hover:text-uitm-gold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.3 5.6a1 1 0 001 .4h11.6a1 1 0 001-.4L17 13M10 21a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                    </a>

                    <!-- Chat -->
                    <a href="{{ route('chatify') }}" class="flex items-center hover:text-uitm-gold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M18 10c0 3.866-3.582 7-8 7a8.71 8.71 0 01-2.808-.463l-4.167 1.145a.75.75 0 01-.924-.924l1.145-4.167A8.71 8.71 0 012 10c0-3.866 3.582-7 8-7s8 3.134 8 7zm-11-1.25a1.25 1.25 0 100 2.5 1.25 1.25 0 000-2.5zm3.75 1.25a1.25 1.25 0 112.5 0 1.25 1.25 0 01-2.5 0zm5 0a1.25 1.25 0 11-2.5 0 1.25 1.25 0 012.5 0z"
                                  clip-rule="evenodd" />
                        </svg>
                    </a>

                    <!-- Notifications -->
                    <div class="relative flex items-center">
                        <button @click="notifyOpen = !notifyOpen" class="relative flex items-center hover:text-uitm-gold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if(Auth::user()->unreadNotifications->count())
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </button>
                        <div x-show="notifyOpen" x-cloak @click.outside="notifyOpen = false"
                             class="absolute right-0 mt-2 w-80 bg-white text-uitm-purple rounded shadow-lg z-50">
                            <div class="p-2 font-bold border-b">Notifications</div>
                            @forelse(Auth::user()->unreadNotifications->take(5) as $notification)
                                <div class="px-4 py-2 text-sm border-b">
                                    {{ $notification->data['message'] ?? 'New notification.' }}
                                </div>
                            @empty
                                <div class="px-4 py-2 text-sm text-gray-500">No new notifications</div>
                            @endforelse
                            <div class="border-t">
                                <a href="{{ route('notifications.index') }}"
                                   class="block text-center text-sm text-uitm-purple py-2 hover:bg-uitm-gold/10">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile -->
                    <div class="relative flex items-center">
                        <button @click="menuOpen = !menuOpen" class="flex items-center space-x-2 text-white">
                            <span>{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="menuOpen" x-cloak @click.outside="menuOpen = false"
                             class="absolute mt-2 right-0 bg-white text-uitm-purple rounded-lg shadow-lg w-48 z-50">
                            <x-nav-link :href="route('profile.index')" class="block px-4 py-2">
                                {{ __('Profile') }}
                            </x-nav-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2">
                                    {{ __('Logout') }}
                                </x-nav-link>
                            </form>
                        </div>
                    </div>
                @endauth

                @guest
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-nav-link>
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                @endguest
            </div>

            <!-- Mobile Hamburger (unchanged) -->
            <div class="-me-2 flex sm:hidden">
                <button @click="open = !open"
                        class="p-2 rounded-md text-gray-200 hover:bg-uitm-dark focus:outline-none transition">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
