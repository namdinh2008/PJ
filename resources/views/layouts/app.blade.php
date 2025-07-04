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

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Smooth transitions */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">
    @php
    use App\Models\Car;
    $navCars = Car::with('carModels')->get();
    @endphp

    <header class="fixed top-0 left-0 right-0 z-50 bg-white bg-opacity-95 backdrop-blur-md shadow-lg border-b border-gray-100">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 md:px-6 py-4 md:py-5">
            <a class="flex items-center space-x-3" href="/">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-car text-white text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-xl sm:text-2xl md:text-3xl text-gray-900 tracking-tight">
                        AutoLux
                    </span>
                    <span class="text-xs text-gray-500 font-medium">Premium Auto Showroom</span>
                </div>
            </a>

            <nav class="hidden md:flex space-x-6 lg:space-x-8 font-medium text-sm lg:text-base">
                @foreach ($navCars as $car)
                <div class="relative group" data-car-dropdown="{{ $car->id }}">
                    <button class="px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200 flex items-center space-x-1">
                        <span>{{ $car->name }}</span>
                        <i class="fas fa-chevron-down text-xs opacity-60"></i>
                    </button>
                    @if ($car->carModels->count())
                    <div class="absolute left-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-xl hidden z-50 transform opacity-0 transition-all duration-200">
                        <div class="p-2">
                            @foreach ($car->carModels as $model)
                            <a href="{{ route('car_models.show', $model->id) }}"
                                class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-all duration-200 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-car text-blue-500"></i>
                                    <span>{{ $model->name }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </nav>

            <div class="hidden md:flex space-x-4 lg:space-x-6 font-medium text-sm items-center">
                @guest
                <a class="px-4 py-2 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200 flex items-center space-x-2" href="{{ route('login') }}">
                    <i class="fas fa-user text-gray-500"></i>
                    <span>Đăng nhập</span>
                </a>
                @else
                <div class="relative" id="desktop-profile-dropdown-wrapper">
                    <button id="desktop-profile-dropdown-btn"
                        class="px-4 py-2 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200 flex items-center space-x-2 focus:outline-none">
                        <i class="fas fa-user-circle text-gray-500"></i>
                        <span class="truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs opacity-60"></i>
                    </button>
                    <div id="desktop-profile-dropdown-menu"
                        class="absolute right-0 mt-2 min-w-max bg-white border border-gray-200 rounded-xl shadow-xl z-50 hidden text-right">
                        <div class="p-2">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-all duration-200 whitespace-nowrap">
                                <i class="fas fa-user-edit mr-2"></i>Hồ sơ
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-all duration-200 whitespace-nowrap">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endguest

                <!-- Wishlist Icon -->
                <a href="{{ route('wishlist.index') }}" class="relative flex items-center p-2 rounded-lg hover:bg-gray-50 hover:text-red-500 transition-all duration-200">
                    <i class="fas fa-heart w-6 h-6"></i>
                    @php
                    $wishlistCount = 0;
                    if (auth()->check()) {
                        $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                    } else {
                        $wishlistCount = count(session()->get('wishlist', []));
                    }
                    @endphp
                    @if ($wishlistCount > 0)
                    <span id="wishlist-count-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center wishlist-count">
                        {{ $wishlistCount }}
                    </span>
                    @else
                    <span id="wishlist-count-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center wishlist-count" style="display: none;">
                        0
                    </span>
                    @endif
                </a>

                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="relative flex items-center p-2 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200">
                    <i class="fas fa-shopping-cart w-6 h-6"></i>
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
                    <span id="cart-count-badge" class="absolute -top-1 -right-1 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center cart-count">
                        {{ $cartCount }}
                    </span>
                    @else
                    <span id="cart-count-badge" class="absolute -top-1 -right-1 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center cart-count" style="display: none;">
                        0
                    </span>
                    @endif
                </a>
            </div>

            <button aria-label="Open menu"
                class="md:hidden p-2 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-inset transition-all duration-200" id="menu-btn">
                <i class="fas fa-bars text-xl text-gray-700"></i>
            </button>
        </div>

        <nav aria-label="Mobile menu" class="md:hidden bg-white border-t border-gray-200 hidden" id="mobile-menu">
            <div class="px-6 py-6 space-y-6">
                <!-- Car Models -->
                @foreach ($navCars as $car)
                <div class="space-y-3">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center space-x-2">
                        <i class="fas fa-car text-blue-500"></i>
                        <span>{{ $car->name }}</span>
                    </h3>
                    <div class="ml-6 space-y-2">
                        @foreach ($car->carModels as $model)
                        <a class="block py-2 px-4 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200 text-gray-700"
                            href="{{ route('car_models.show', $model->id) }}">
                            <i class="fas fa-chevron-right text-xs mr-2 opacity-60"></i>
                            {{ $model->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
                
                <!-- User Menu -->
                <div class="border-t border-gray-200 pt-6 space-y-3">
                    @guest
                    <a class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200 text-gray-700"
                        href="{{ route('login') }}">
                        <i class="fas fa-user text-gray-500"></i>
                        <span>Đăng nhập</span>
                    </a>
                    @else
                    <a class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200 text-gray-700"
                        href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-edit text-gray-500"></i>
                        <span>Hồ sơ</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-red-50 hover:text-red-600 transition-all duration-200 text-gray-700 text-left">
                            <i class="fas fa-sign-out-alt text-gray-500"></i>
                            <span>Đăng xuất</span>
                        </button>
                    </form>
                    @endguest
                    
                    <a href="{{ route('wishlist.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-gray-50 hover:text-red-500 transition-all duration-200 text-gray-700">
                        <i class="fas fa-heart text-gray-500"></i>
                        <span>Yêu thích</span>
                    </a>
                    <a href="{{ route('cart.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200 text-gray-700">
                        <i class="fas fa-shopping-cart text-gray-500"></i>
                        <span>Giỏ hàng</span>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="pt-24">
        @yield('content')
    </main>
    {{-- Footer --}}
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-gray-300 py-16 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-car text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold text-lg">AutoLux</h3>
                            <p class="text-xs text-gray-400">Premium Auto Showroom</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 mb-4">
                        Chuyên cung cấp các dòng xe cao cấp với chất lượng dịch vụ tốt nhất.
                    </p>
                    <div class="flex space-x-4 text-gray-400">
                        <a class="hover:text-blue-400 transition-colors" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="hover:text-blue-400 transition-colors" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="hover:text-blue-400 transition-colors" href="#"><i class="fab fa-youtube"></i></a>
                        <a class="hover:text-blue-400 transition-colors" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4 flex items-center">
                        <i class="fas fa-car-side mr-2 text-blue-400"></i>
                        Dòng xe
                    </h4>
                    <ul class="space-y-2 text-sm">
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Sedan</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">SUV</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Luxury</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Sports</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Electric</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4 flex items-center">
                        <i class="fas fa-tools mr-2 text-blue-400"></i>
                        Dịch vụ
                    </h4>
                    <ul class="space-y-2 text-sm">
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Mua xe</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Thuê xe</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Bảo hành</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Bảo dưỡng</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Tư vấn</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-400"></i>
                        Thông tin
                    </h4>
                    <ul class="space-y-2 text-sm">
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Về chúng tôi</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Liên hệ</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Chính sách</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Điều khoản</a></li>
                        <li><a class="hover:text-blue-400 transition-colors" href="#">Tuyển dụng</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Footer -->
            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-sm text-gray-400">
                        © 2024 AutoLux. Tất cả quyền được bảo lưu.
                    </div>
                    <div class="flex space-x-6 text-sm">
                        <a class="hover:text-blue-400 transition-colors" href="#">Chính sách bảo mật</a>
                        <a class="hover:text-blue-400 transition-colors" href="#">Điều khoản sử dụng</a>
                        <a class="hover:text-blue-400 transition-colors" href="#">Sitemap</a>
                    </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            // Profile dropdown
            const btn = document.getElementById('desktop-profile-dropdown-btn');
            const menu = document.getElementById('desktop-profile-dropdown-menu');
            const wrapper = document.getElementById('desktop-profile-dropdown-wrapper');
            
            if (btn && menu && wrapper) {
                let hideTimeout;
                
                // Show dropdown on click
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                });
                
                // Hide dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!wrapper.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
                
                // Improved hover behavior for dropdown
                wrapper.addEventListener('mouseenter', function() {
                    clearTimeout(hideTimeout);
                    menu.classList.remove('hidden');
                });
                
                wrapper.addEventListener('mouseleave', function() {
                    hideTimeout = setTimeout(() => {
                        menu.classList.add('hidden');
                    }, 300); // 300ms delay before hiding
                });
                
                // Prevent hiding when hovering over the menu
                menu.addEventListener('mouseenter', function() {
                    clearTimeout(hideTimeout);
                });
                
                menu.addEventListener('mouseleave', function() {
                    hideTimeout = setTimeout(() => {
                        menu.classList.add('hidden');
                    }, 300); // 300ms delay before hiding
                });
            }
            
            // Car models dropdowns
            const carDropdowns = document.querySelectorAll('[data-car-dropdown]');
            carDropdowns.forEach(dropdown => {
                const button = dropdown.querySelector('button');
                const menu = dropdown.querySelector('div[class*="absolute"]');
                let hideTimeout;
                
                if (button && menu) {
                    // Show dropdown on hover
                    dropdown.addEventListener('mouseenter', function() {
                        clearTimeout(hideTimeout);
                        menu.classList.remove('hidden');
                        setTimeout(() => {
                            menu.classList.remove('opacity-0');
                        }, 10);
                    });
                    
                    // Hide dropdown with delay
                    dropdown.addEventListener('mouseleave', function() {
                        hideTimeout = setTimeout(() => {
                            menu.classList.add('opacity-0');
                            setTimeout(() => {
                                menu.classList.add('hidden');
                            }, 200);
                        }, 300); // 300ms delay before hiding
                    });
                    
                    // Prevent hiding when hovering over the menu
                    menu.addEventListener('mouseenter', function() {
                        clearTimeout(hideTimeout);
                    });
                    
                    menu.addEventListener('mouseleave', function() {
                        hideTimeout = setTimeout(() => {
                            menu.classList.add('opacity-0');
                            setTimeout(() => {
                                menu.classList.add('hidden');
                            }, 200);
                        }, 300); // 300ms delay before hiding
                    });
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('submit', '.add-to-cart-form', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $button = $form.find('button[type="submit"]');
            var originalText = $button.html();
            
            // Show loading state
            $button.html('<i class="fas fa-spinner fa-spin"></i> Đang thêm...');
            $button.prop('disabled', true);
            
            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        showMessage(response.message || 'Đã thêm vào giỏ hàng!', 'success');
                        
                        // Update cart count
                        if (response.cart_count !== undefined) {
                            updateCartCount(response.cart_count);
                        }
                    } else {
                        showMessage(response.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
                    }
                },
                error: function() {
                    showMessage('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
                },
                complete: function() {
                    // Restore button state
                    $button.html(originalText);
                    $button.prop('disabled', false);
                }
            });
            return false;
        });

        // Show message function
        function showMessage(message, type) {
            // Create message element
            const messageDiv = document.createElement('div');
            messageDiv.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
            
            messageDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-3"></i>
                    <span>${message}</span>
                    <button class="ml-auto text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(messageDiv);
            
            // Animate in
            setTimeout(() => {
                messageDiv.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                messageDiv.classList.add('translate-x-full');
                setTimeout(() => messageDiv.remove(), 300);
            }, 5000);
        }

        // Update cart count function (global)
        function updateCartCount(count) {
            // Update all cart count badges on the page
            $('.cart-count').each(function() {
                $(this).text(count);
                if (count === 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            
            // Also update the cart count badge in the header navigation
            $('#cart-count-badge').each(function() {
                $(this).text(count);
                if (count === 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });

            // Update any other cart count elements
            $('[data-cart-count]').each(function() {
                $(this).text(count);
                if (count === 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        }

        // Update wishlist count function (global)
        function updateWishlistCount(count) {
            // Update all wishlist count badges on the page
            $('.wishlist-count').each(function() {
                $(this).text(count);
                if (count === 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            
            // Also update the wishlist count badge in the header navigation
            $('#wishlist-count-badge').each(function() {
                $(this).text(count);
                if (count === 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });

            // Update any other wishlist count elements
            $('[data-wishlist-count]').each(function() {
                $(this).text(count);
                if (count === 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        }

        // Initialize counts on page load
        $(document).ready(function() {
            // Get initial wishlist count from server
            $.ajax({
                url: '{{ route("wishlist.count") }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        updateWishlistCount(response.wishlist_count);
                    }
                },
                error: function() {
                    // Silently fail, don't show error for count updates
                }
            });

            // Get initial cart count from server
            $.ajax({
                url: '{{ route("cart.count") }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        updateCartCount(response.cart_count);
                    }
                },
                error: function() {
                    // Silently fail, don't show error for count updates
                }
            });
        });

        // Also initialize on page show (for browser navigation)
        window.addEventListener('pageshow', function() {
            // Get initial wishlist count from server
            $.ajax({
                url: '{{ route("wishlist.count") }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        updateWishlistCount(response.wishlist_count);
                    }
                },
                error: function() {
                    // Silently fail, don't show error for count updates
                }
            });

            // Get initial cart count from server
            $.ajax({
                url: '{{ route("cart.count") }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        updateCartCount(response.cart_count);
                    }
                },
                error: function() {
                    // Silently fail, don't show error for count updates
                }
            });
        });
    </script>
</body>

</html>