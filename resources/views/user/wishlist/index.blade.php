@extends('layouts.app')

@section('title', 'Danh sách yêu thích')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">
                <i class="fas fa-heart text-red-500 mr-3"></i>Danh sách yêu thích
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Những sản phẩm bạn đã yêu thích và muốn mua sau
            </p>
        </div>

        @if($wishlistItems->count() > 0)
            <!-- Wishlist Items -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($wishlistItems as $item)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 group relative transform hover:-translate-y-2">
                        <!-- Remove from wishlist button -->
                        <div class="absolute top-4 right-4 z-10">
                            <button onclick="removeFromWishlist({{ $item->product->id }})" 
                                    class="bg-white/90 backdrop-blur-sm p-3 rounded-full hover:bg-red-500 hover:text-white transition duration-300 shadow-lg remove-wishlist-btn"
                                    data-product-id="{{ $item->product->id }}">
                                <i class="fas fa-heart text-red-500 group-hover:text-white"></i>
                            </button>
                        </div>

                        <!-- Product Image -->
                        <div class="relative overflow-hidden">
                            <img src="{{ $item->product->image_url }}" 
                                 class="w-full h-56 object-cover group-hover:scale-110 transition duration-500" 
                                 alt="{{ $item->product->name }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-indigo-600 transition duration-300">
                                {{ $item->product->name }}
                            </h3>
                            
                            <p class="text-gray-600 mb-4 line-clamp-2 text-sm leading-relaxed">
                                {{ Str::limit($item->product->description ?? 'Sản phẩm chất lượng cao', 100) }}
                            </p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-indigo-600">{{ number_format($item->product->price) }} đ</span>
                                <div class="flex items-center text-yellow-500">
                                    <i class="fas fa-star text-sm"></i>
                                    <span class="text-sm text-gray-600 ml-1">4.8</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-300 flex items-center justify-center gap-2 shadow-lg">
                                        <i class="fas fa-cart-plus"></i>
                                        Thêm vào giỏ hàng
                                    </button>
                                </form>
                                
                                <button onclick="removeFromWishlist({{ $item->product->id }})" 
                                        class="w-full bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold hover:bg-red-50 hover:text-red-600 transition duration-300 flex items-center justify-center gap-2 remove-wishlist-btn"
                                        data-product-id="{{ $item->product->id }}">
                                    <i class="fas fa-trash"></i>
                                    Xóa khỏi yêu thích
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Clear All Button -->
            <div class="text-center" id="clear-all-button">
                <button onclick="clearWishlist()" 
                        class="bg-red-500 hover:bg-red-600 text-white px-8 py-4 rounded-xl font-semibold transition duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-trash mr-2"></i>
                    Xóa tất cả yêu thích
                </button>
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-8 flex items-center justify-center">
                    <i class="fas fa-heart text-gray-400 text-5xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-600 mb-4">Danh sách yêu thích trống</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    Bạn chưa có sản phẩm nào trong danh sách yêu thích. Hãy khám phá các sản phẩm và thêm vào yêu thích!
                </p>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    Khám phá sản phẩm
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Success/Error Messages -->
<div id="message-container" class="fixed top-4 right-4 z-50"></div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Remove from wishlist
    function removeFromWishlist(productId) {
        $.ajax({
            url: '{{ route("wishlist.remove") }}',
            method: 'POST',
            data: {
                product_id: productId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showMessage(response.message, 'success');
                    updateWishlistCount(response.wishlist_count);
                    
                    // Remove the item from DOM
                    $(`.remove-wishlist-btn[data-product-id="${productId}"]`).closest('.bg-white').fadeOut(300, function() {
                        $(this).remove();
                        
                        // Kiểm tra số lượng sản phẩm còn lại
                        const remainingItems = $('.grid .bg-white').length;
                        console.log('Remaining items:', remainingItems); // Debug log
                        
                        if (remainingItems === 0) {
                            console.log('No items left, showing empty state'); // Debug log
                            showEmptyState();
                        }
                    });
                }
            },
            error: function() {
                showMessage('Có lỗi xảy ra khi xóa khỏi yêu thích', 'error');
            }
        });
    }

    // Clear all wishlist
    function clearWishlist() {
        if (confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm khỏi danh sách yêu thích?')) {
            $.ajax({
                url: '{{ route("wishlist.clear") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        showMessage(response.message, 'success');
                        updateWishlistCount(response.wishlist_count);
                        showEmptyState();
                    }
                },
                error: function() {
                    showMessage('Có lỗi xảy ra khi xóa danh sách yêu thích', 'error');
                }
            });
        }
    }

    // Show empty state
    function showEmptyState() {
        // Hide the wishlist items container and clear all button
        $('.grid').fadeOut(300);
        $('#clear-all-button').fadeOut(300);
        
        // After animations complete, replace the content
        setTimeout(function() {
            // Replace the entire content area with the original empty state
            $('.container').html(`
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                        <i class="fas fa-heart text-red-500 mr-3"></i>Danh sách yêu thích
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Những sản phẩm bạn đã yêu thích và muốn mua sau
                    </p>
                </div>
                
                <div class="text-center py-16">
                    <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-8 flex items-center justify-center">
                        <i class="fas fa-heart text-gray-400 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-4">Danh sách yêu thích trống</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">
                        Bạn chưa có sản phẩm nào trong danh sách yêu thích. Hãy khám phá các sản phẩm và thêm vào yêu thích!
                    </p>
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Khám phá sản phẩm
                    </a>
                </div>
            `);
        }, 300);
    }

    // Add to cart with AJAX
    $(document).on('submit', '.add-to-cart-form', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const button = form.find('button[type="submit"]');
        const originalText = button.html();
        
        // Show loading state
        button.html('<i class="fas fa-spinner fa-spin"></i> Đang thêm...');
        button.prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    showMessage(response.message, 'success');
                    updateCartCount(response.cart_count);
                }
            },
            error: function() {
                showMessage('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
            },
            complete: function() {
                // Restore button state
                button.html(originalText);
                button.prop('disabled', false);
            }
        });
    });

    // Show message
    function showMessage(message, type) {
        const messageContainer = $('#message-container');
        const alertClass = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        
        const alert = $(`
            <div class="${alertClass} text-white px-6 py-4 rounded-lg shadow-lg mb-4 transform transition-all duration-300 translate-x-full">
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-3"></i>
                    <span>${message}</span>
                    <button class="ml-auto text-white hover:text-gray-200" onclick="$(this).parent().parent().remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `);
        
        messageContainer.append(alert);
        
        // Animate in
        setTimeout(() => {
            alert.removeClass('translate-x-full');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            alert.addClass('translate-x-full');
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    }

    // Use the global updateWishlistCount function from layout
    // No need to redefine it here

    // Update cart count in header
    function updateCartCount(count) {
        const cartBadge = $('.cart-count');
        if (cartBadge.length) {
            cartBadge.text(count);
            if (count === 0) {
                cartBadge.hide();
            } else {
                cartBadge.show();
            }
        }
    }

    // Initialize page
    function initializePage() {
        // Add smooth animations
        $('.bg-white').each(function(index) {
            $(this).css({
                'animation-delay': (index * 0.1) + 's'
            }).addClass('animate-fade-in-up');
        });
    }

    // Initialize on document ready
    $(document).ready(initializePage);

    // Initialize on page show (for browser navigation)
    window.addEventListener('pageshow', initializePage);

    // Initialize on turbolinks load (if using turbolinks)
    if (typeof Turbolinks !== 'undefined') {
        document.addEventListener('turbolinks:load', initializePage);
    }
</script>
@endpush

@push('styles')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush 