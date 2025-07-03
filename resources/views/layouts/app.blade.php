<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @font-face {
            font-family: 'Tesla';
            src: url('https://fonts.cdnfonts.com/s/16251/TESLA.woff') format('woff');
            font-display: swap;
        }

        .font-tesla {
            font-family: 'Tesla', 'Arial Black', Arial, sans-serif;
            letter-spacing: 0.5em;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">
    @php
        use App\Models\Car;
        $navCars = Car::with('carModels')->get();
    @endphp

    <header class="fixed top-0 left-0 right-0 z-50 bg-white bg-opacity-90 backdrop-blur-md shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 md:px-6 py-3 md:py-4">
            <a class="flex items-center space-x-2" href="/">
                <span class="font-tesla text-2xl sm:text-3xl md:text-4xl text-gray-900 tracking-widest select-none">
                    TESLA
                </span>
            </a>

            <nav class="hidden md:flex space-x-4 lg:space-x-8 font-semibold text-xs lg:text-sm">
                @foreach ($navCars as $car)
                    <div class="relative group">
                        <button class="hover:text-gray-700 transition">
                            {{ $car->name }}
                        </button>
                        @if ($car->carModels->count())
                            <div
                                class="absolute left-0 mt-2 w-48 bg-white border rounded shadow-lg hidden group-hover:block z-50">
                                @foreach ($car->carModels as $model)
                                    <a href="{{ route('car_models.show', $model->id) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 whitespace-nowrap">
                                        {{ $model->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </nav>

            <div class="hidden md:flex space-x-4 lg:space-x-6 font-semibold text-xs lg:text-sm items-center">
                @guest
                    <a class="hover:text-gray-700 transition" href="{{ route('login') }}">Account</a>
                @else
                    <div class="relative" id="desktop-profile-dropdown-wrapper">
                        <button id="desktop-profile-dropdown-btn"
                            class="hover:text-gray-700 transition flex items-center focus:outline-none">
                            <span class="truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="desktop-profile-dropdown-menu"
                            class="absolute right-0 mt-2 min-w-max bg-white border rounded shadow-lg z-50 hidden text-right">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-right whitespace-nowrap">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-right px-4 py-2 text-gray-700 hover:bg-gray-100 whitespace-nowrap">Log
                                    out</button>
                            </form>
                        </div>
                    </div>
                @endguest

                <a href="{{ route('cart.index') }}" class="relative flex items-center ml-2">
                    <svg id="cart-icon" class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        viewBox="0 0 24 24">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                    </svg>
                    @php
                        $cartCount = \App\Models\CartItem::where(function ($q) {
                            if (auth()->check()) {
                                $q->where('user_id', auth()->id());
                            } else {
                                $q->where('session_id', session()->getId());
                            }
                        })->sum('quantity');
                    @endphp
                    @if ($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-2 py-0.5">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </div>

            <button aria-label="Open menu"
                class="md:hidden focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-700" id="menu-btn">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <nav aria-label="Mobile menu" class="md:hidden bg-white border-t border-gray-200 hidden" id="mobile-menu">
            <div class="px-6 py-4 space-y-4 font-semibold text-base">
                @foreach ($navCars as $car)
                    <div>
                        <span class="block text-gray-900 font-bold">{{ $car->name }}</span>
                        @foreach ($car->carModels as $model)
                            <a class="block text-sm ml-3 hover:text-gray-700"
                                href="{{ route('car_models.show', $model->id) }}">{{ $model->name }}</a>
                        @endforeach
                    </div>
                @endforeach
                @guest
                    <a class="block hover:text-gray-700 transition" href="{{ route('login') }}">Account</a>
                @else
                    <a class="block hover:text-gray-700 transition" href="{{ route('profile.edit') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-0 py-2 text-gray-700 hover:bg-gray-100">Log
                            out</button>
                    </form>
                @endguest
                <a href="{{ route('cart.index') }}" class="block hover:text-gray-700 transition">Giỏ hàng</a>
            </div>
        </nav>
    </header>

    <main class="pt-20">
        @yield('content')
    </main>
    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 md:gap-12">
            <div>
                <h3 class="text-white font-semibold mb-4">Tesla</h3>
                <ul class="space-y-2 text-sm">
                    <li><a class="hover:underline" href="#">Model S</a></li>
                    <li><a class="hover:underline" href="#">Model 3</a></li>
                    <li><a class="hover:underline" href="#">Model X</a></li>
                    <li><a class="hover:underline" href="#">Model Y</a></li>
                    <li><a class="hover:underline" href="#">Solar Roof</a></li>
                    <li><a class="hover:underline" href="#">Solar Panels</a></li>
                    <li><a class="hover:underline" href="#">Powerwall</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-4">Shop & Learn</h3>
                <ul class="space-y-2 text-sm">
                    <li><a class="hover:underline" href="#">Shop</a></li>
                    <li><a class="hover:underline" href="#">Account</a></li>
                    <li><a class="hover:underline" href="#">Charging</a></li>
                    <li><a class="hover:underline" href="#">Find Us</a></li>
                    <li><a class="hover:underline" href="#">Support</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-4">Tesla © 2024</h3>
                <ul class="space-y-2 text-sm">
                    <li><a class="hover:underline" href="#">Privacy & Legal</a></li>
                    <li><a class="hover:underline" href="#">Vehicle Recalls</a></li>
                    <li><a class="hover:underline" href="#">Contact</a></li>
                    <li><a class="hover:underline" href="#">Careers</a></li>
                    <li><a class="hover:underline" href="#">News</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-4">Follow Tesla</h3>
                <div class="flex space-x-6 text-gray-400 text-xl">
                    <a aria-label="Tesla Facebook" class="hover:text-white" href="#"><i
                            class="fab fa-facebook-f"></i></a>
                    <a aria-label="Tesla Twitter" class="hover:text-white" href="#"><i class="fab fa-twitter"></i></a>
                    <a aria-label="Tesla Instagram" class="hover:text-white" href="#"><i
                            class="fab fa-instagram"></i></a>
                    <a aria-label="Tesla YouTube" class="hover:text-white" href="#"><i class="fab fa-youtube"></i></a>
                    <a aria-label="Tesla LinkedIn" class="hover:text-white" href="#"><i
                            class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>
    @stack('scripts')
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        menuBtn && mobileMenu && menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('desktop-profile-dropdown-btn');
            const menu = document.getElementById('desktop-profile-dropdown-menu');
            const wrapper = document.getElementById('desktop-profile-dropdown-wrapper');
            if (btn && menu && wrapper) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                });
                document.addEventListener('click', function (e) {
                    if (!wrapper.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>