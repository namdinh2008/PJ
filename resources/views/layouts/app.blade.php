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

        /* Dropdown wrapper styling */
        .car-dropdown-wrapper, .profile-dropdown-wrapper {
            position: relative;
            display: inline-block;
        }
        
        /* Custom hover behavior for dropdowns */
        .car-dropdown-wrapper:hover .car-dropdown-menu,
        .profile-dropdown-wrapper:hover .profile-dropdown-menu {
            display: block !important;
            opacity: 1 !important;
        }
        
        /* Add a dropdown bridge to cover the gap */
        .dropdown-bridge {
            position: absolute;
            height: 10px;
            width: 100%;
            top: 100%;
            left: 0;
            background-color: transparent;
        }
        
        /* Position the dropdown menu directly below the button */
        .car-dropdown-menu, .profile-dropdown-menu {
            margin-top: 0 !important;
            top: calc(100% + 6px);
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
                    <div class="car-dropdown-wrapper">
                        <button class="px-3 py-2 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200 flex items-center space-x-1">
                            <span>{{ $car->name }}</span>
                            <i class="fas fa-chevron-down text-xs opacity-60"></i>
                        </button>
                        <div class="dropdown-bridge"></div>
                        @if ($car->carModels->count())
                        <div class="absolute left-0 w-56 bg-white border border-gray-200 rounded-xl shadow-xl hidden z-50 transform opacity-0 transition-all duration-200 car-dropdown-menu">
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
                    <div class="profile-dropdown-wrapper">
                        <button id="desktop-profile-dropdown-btn"
                            class="px-4 py-2 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200 flex items-center space-x-2 focus:outline-none">
                            <i class="fas fa-user-circle text-gray-500"></i>
                            <span class="truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs opacity-60"></i>
                        </button>
                        <div class="dropdown-bridge"></div>
                        <div id="desktop-profile-dropdown-menu"
                            class="absolute right-0 min-w-max bg-white border border-gray-200 rounded-xl shadow-xl z-50 hidden text-right profile-dropdown-menu">
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
                </div>
                @endguest

                <!-- Wishlist Icon -->
                <a href="{{ route('wishlist.index') }}" class="relative flex items-center justify-center p-2 rounded-lg hover:bg-gray-50 hover:text-red-500 transition-all duration-200">
                    <i class="fas fa-heart text-lg"></i>
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
                <a href="{{ route('cart.index') }}" class="relative flex items-center justify-center p-2 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition-all duration-200">
                    <i class="fas fa-shopping-cart text-lg"></i>
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
    <footer class="bg-gray-950 text-gray-300 py-12">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 lg:gap-16">
            <div class="md:col-span-1">
                <div class="flex items-center mb-5 space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-700 to-indigo-800 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-car text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-extrabold text-xl leading-tight">AutoLux</h3>
                        <p class="text-xs text-blue-300 font-medium tracking-wide opacity-80">Premium Auto Showroom</p>
                    </div>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed max-w-sm">
                    Khám phá bộ sưu tập xe sang trọng và trải nghiệm dịch vụ đẳng cấp tại showroom của chúng tôi.
                </p>
            </div>

            <div class="md:col-span-1">
                <h4 class="text-white font-bold mb-4 text-base tracking-wide">Thông tin</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300 ease-in-out">Về chúng tôi</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300 ease-in-out">Liên hệ</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300 ease-in-out">Câu hỏi thường gặp</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300 ease-in-out">Tuyển dụng</a></li>
                </ul>
            </div>

            <div class="md:col-span-1">
                <h4 class="text-white font-bold mb-4 text-base tracking-wide">Dịch vụ</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300 ease-in-out">Mua bán xe</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300 ease-in-out">Thuê xe</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300 ease-in-out">Bảo dưỡng</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-blue-400 transition duration-300 ease-in-out">Tài chính</a></li>
                </ul>
            </div>

            <div class="md:col-span-1">
                <h4 class="text-white font-bold mb-4 text-base tracking-wide">Kết nối với chúng tôi</h4>
                <div class="flex space-x-5 text-gray-400 text-xl mb-6">
                    <a href="#" class="hover:text-blue-400 transition duration-300 ease-in-out transform hover:scale-110"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-pink-500 transition duration-300 ease-in-out transform hover:scale-110"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-red-500 transition duration-300 ease-in-out transform hover:scale-110"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="hover:text-blue-500 transition duration-300 ease-in-out transform hover:scale-110"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <h4 class="text-white font-bold mb-3 text-base tracking-wide">Đăng ký nhận tin</h4>
                <form id="newsletter-form" class="flex">
                    <input 
                        type="email" 
                        name="newsletter_email"
                        placeholder="Nhập email của bạn" 
                        class="flex-grow p-3 rounded-l-lg bg-gray-800 text-gray-300 placeholder-gray-500 border border-gray-700 text-sm transition-all duration-300 
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-80 focus:border-blue-400 focus:border-2" 
                        required
                    />
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-r-lg transition duration-300 ease-in-out text-sm font-semibold border border-blue-700 hover:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-80">Gửi</button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <span>© 2024 AutoLux. Tất cả quyền được bảo lưu.</span>
            <div class="flex space-x-8 mt-5 md:mt-0">
                <a href="#" class="hover:text-blue-400 transition duration-300 ease-in-out">Chính sách bảo mật</a>
                <a href="#" class="hover:text-blue-400 transition duration-300 ease-in-out">Điều khoản dịch vụ</a>
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
            const profileDropdownWrapper = wrapper.querySelector('.profile-dropdown-wrapper');
            
            if (btn && menu && wrapper && profileDropdownWrapper) {
                // Show dropdown on click
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (menu.classList.contains('hidden')) {
                        menu.classList.remove('hidden');
                    } else {
                        menu.classList.add('hidden');
                    }
                });
                
                // Hide dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!profileDropdownWrapper.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
                
                // Hover behavior is handled by CSS
            }
            
            // Car models dropdowns
            const carDropdowns = document.querySelectorAll('[data-car-dropdown]');
            carDropdowns.forEach(dropdown => {
                const wrapper = dropdown.querySelector('.car-dropdown-wrapper');
                const button = dropdown.querySelector('button');
                const menu = dropdown.querySelector('.car-dropdown-menu');
                
                if (button && menu && wrapper) {
                    // Show dropdown on hover - handled by CSS now
                    
                    // For click events on mobile
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // Close other dropdowns
                        document.querySelectorAll('.car-dropdown-menu').forEach(m => {
                            if (m !== menu) {
                                m.classList.add('hidden');
                                m.classList.add('opacity-0');
                            }
                        });
                        
                        // Toggle current dropdown
                        if (menu.classList.contains('hidden')) {
                            menu.classList.remove('hidden');
                            setTimeout(() => {
                                menu.classList.remove('opacity-0');
                            }, 10);
                        } else {
                            menu.classList.add('opacity-0');
                            setTimeout(() => {
                                menu.classList.add('hidden');
                            }, 100);
                        }
                    });
                    
                    // Hide dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!wrapper.contains(e.target)) {
                            menu.classList.add('opacity-0');
                            menu.classList.add('hidden');
                        }
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

        // Handle newsletter form submission
        $(document).on('submit', '#newsletter-form', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $button = $form.find('button[type="submit"]');
            var $input = $form.find('input[name="newsletter_email"]');
            var email = $input.val();
            var originalText = $button.html();
            
            // Validate email
            if (!email || !email.includes('@')) {
                showMessage('Vui lòng nhập email hợp lệ', 'error');
                return false;
            }
            
            // Show loading state
            $button.html('<i class="fas fa-spinner fa-spin"></i>');
            $button.prop('disabled', true);
            
            // Simulate an AJAX call (replace with actual endpoint when available)
            setTimeout(function() {
                // Success response (this would be an actual AJAX call in production)
                showMessage('Cảm ơn bạn đã đăng ký nhận tin!', 'success');
                $input.val(''); // Clear the input
                
                // Restore button state
                $button.html(originalText);
                $button.prop('disabled', false);
            }, 1000);
            
            return false;
        });
    </script>
</body>

</html>