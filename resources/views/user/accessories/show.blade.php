@extends('layouts.app')

@section('title', $accessory->name)

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-home"></i>
                            <span class="sr-only">Trang chủ</span>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="#" class="text-gray-500 hover:text-gray-700">Phụ kiện</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-900 font-medium">{{ $accessory->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Image Gallery -->
            <div class="space-y-4">
                <div class="relative">
                    <img src="{{ $accessory->product->image_url }}"
                         id="main-image"
                         class="w-full h-96 object-cover rounded-2xl shadow-lg"
                         alt="{{ $accessory->name }}">
                    <div class="absolute top-4 left-4">
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-tag mr-1"></i>Phụ kiện
                        </span>
                    </div>
                </div>
                
                <!-- Thumbnail Gallery -->
                <div class="grid grid-cols-4 gap-4">
                    @for($i = 1; $i <= 4; $i++)
                        <img src="{{ $accessory->product->image_url }}"
                             class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-75 transition"
                             onclick="changeMainImage(this.src)"
                             alt="{{ $accessory->name }}">
                    @endfor
                </div>
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $accessory->name }}</h1>
                    <p class="text-lg text-gray-600 mb-4">Phụ kiện xe hơi cao cấp</p>
                    
                    <!-- Rating -->
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <span class="ml-2 text-gray-600">(4.7/5) - 95 đánh giá</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-2xl">
                    <div class="flex items-baseline gap-4">
                        <span class="text-4xl font-bold text-green-600">{{ number_format($accessory->product->price) }} đ</span>
                        <span class="text-lg text-gray-500 line-through">{{ number_format($accessory->product->price * 1.15) }} đ</span>
                        <span class="bg-green-500 text-white px-2 py-1 rounded text-sm font-semibold">-15%</span>
                    </div>
                    <p class="text-gray-600 mt-2">Giá đã bao gồm thuế VAT</p>
                </div>

                <!-- Add to Cart -->
                <div class="space-y-4">
                    <form method="POST" action="{{ route('cart.add') }}" id="add-to-cart-form" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $accessory->product_id }}">
                        
                        <div class="flex items-center gap-4">
                            <label class="text-lg font-semibold text-gray-900">Số lượng:</label>
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" onclick="changeQuantity(-1)" class="px-4 py-2 text-gray-600 hover:bg-gray-100">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="quantity" value="1" min="1" 
                                       class="w-16 text-center border-none focus:ring-0" id="quantity-input">
                                <button type="button" onclick="changeQuantity(1)" class="px-4 py-2 text-gray-600 hover:bg-gray-100">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                    class="flex-1 bg-green-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-green-700 transition flex items-center justify-center gap-3 text-lg">
                                <i class="fas fa-cart-plus"></i>
                                Thêm vào giỏ hàng
                            </button>
                            @php
                                $isInWishlist = false;
                                if (auth()->check()) {
                                    $isInWishlist = \App\Helpers\WishlistHelper::isInWishlist($accessory->product->id);
                                }
                            @endphp
                            <button type="button"
                                    class="px-6 py-4 border-2 border-gray-300 rounded-xl hover:border-green-500 transition"
                                    data-product-id="{{ $accessory->product->id }}">
                                <i class="{{ $isInWishlist ? 'fas fa-heart text-red-500' : 'far fa-heart' }} text-lg"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Quick Info -->
                <div class="grid grid-cols-2 gap-4 pt-6 border-t">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-shipping-fast text-2xl text-green-600 mb-2"></i>
                        <div class="text-sm font-semibold">Giao hàng miễn phí</div>
                        <div class="text-xs text-gray-500">Trong 2-3 ngày</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-shield-alt text-2xl text-green-600 mb-2"></i>
                        <div class="text-sm font-semibold">Bảo hành 6 tháng</div>
                        <div class="text-xs text-gray-500">Chính hãng</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="mt-16">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button onclick="showTab('description')" 
                            class="tab-button border-b-2 border-green-500 py-2 px-1 text-sm font-medium text-green-600">
                        Mô tả
                    </button>
                    <button onclick="showTab('specifications')" 
                            class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Thông số kỹ thuật
                    </button>
                    <button onclick="showTab('reviews')" 
                            class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Đánh giá (95)
                    </button>
                </nav>
            </div>

            <!-- Description Tab -->
            <div id="description" class="tab-content py-8">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mô tả sản phẩm</h3>
                    <p class="text-gray-700 leading-relaxed mb-6">{{ $accessory->description }}</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-cog text-green-600"></i> Tính năng nổi bật
                            </h4>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check text-green-500"></i>
                                    Chất liệu cao cấp, bền bỉ
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check text-green-500"></i>
                                    Thiết kế hiện đại, dễ lắp đặt
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check text-green-500"></i>
                                    Tương thích với nhiều dòng xe
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check text-green-500"></i>
                                    Bảo hành chính hãng 6 tháng
                                </li>
                            </ul>
                        </div>
                        
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-info-circle text-green-600"></i> Thông tin bổ sung
                            </h4>
                            <ul class="space-y-2 text-gray-700">
                                <li><strong>Xuất xứ:</strong> Chính hãng</li>
                                <li><strong>Chất liệu:</strong> Cao cấp</li>
                                <li><strong>Kích thước:</strong> Đa dạng</li>
                                <li><strong>Màu sắc:</strong> Đen, Trắng, Xám</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications Tab -->
            <div id="specifications" class="tab-content py-8 hidden">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Thông số kỹ thuật</h3>
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6 border-b md:border-b-0 md:border-r border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Thông tin cơ bản</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tên sản phẩm:</span>
                                    <span class="font-medium">{{ $accessory->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Loại phụ kiện:</span>
                                    <span class="font-medium">Phụ kiện xe hơi</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Thương hiệu:</span>
                                    <span class="font-medium">Chính hãng</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Trạng thái:</span>
                                    <span class="font-medium text-green-600">Còn hàng</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Thông số kỹ thuật</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kích thước:</span>
                                    <span class="font-medium">Đa dạng</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Trọng lượng:</span>
                                    <span class="font-medium">0.5-2kg</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Chất liệu:</span>
                                    <span class="font-medium">Cao cấp</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Bảo hành:</span>
                                    <span class="font-medium">6 tháng</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div id="reviews" class="tab-content py-8 hidden">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Đánh giá sản phẩm</h3>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        Viết đánh giá
                    </button>
                </div>
                
                <div class="space-y-6">
                    <!-- Review Stats -->
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <div class="flex items-center gap-8">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-green-600">4.7</div>
                                <div class="flex text-yellow-400 justify-center my-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                                <div class="text-sm text-gray-600">95 đánh giá</div>
                            </div>
                            
                            <div class="flex-1">
                                <div class="space-y-2">
                                    @for($i = 5; $i >= 1; $i--)
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-gray-600 w-8">{{ $i }} sao</span>
                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ 100 - ($i * 15) }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600 w-12">{{ 100 - ($i * 15) }}%</span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sample Reviews -->
                    <div class="space-y-4">
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <span class="text-green-600 font-semibold">NV</span>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">Nguyễn Văn A</div>
                                        <div class="flex text-yellow-400 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">3 ngày trước</span>
                            </div>
                            <p class="text-gray-700">Phụ kiện chất lượng rất tốt, lắp đặt dễ dàng và phù hợp với xe của tôi!</p>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <span class="text-green-600 font-semibold">TL</span>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">Trần Lê B</div>
                                        <div class="flex text-yellow-400 text-sm">
                                            @for($i = 1; $i <= 4; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">1 tuần trước</span>
                            </div>
                            <p class="text-gray-700">Sản phẩm đẹp, giá cả hợp lý. Giao hàng nhanh và đóng gói cẩn thận.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-16">
            <h3 class="text-2xl font-bold text-gray-900 mb-8">Phụ kiện liên quan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @for($i = 1; $i <= 4; $i++)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition">
                        <img src="https://via.placeholder.com/300x200/10b981/ffffff?text=Phụ+kiện+{{ $i }}" 
                             class="w-full h-48 object-cover" alt="Phụ kiện {{ $i }}">
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 mb-2">Phụ kiện liên quan {{ $i }}</h4>
                            <p class="text-green-600 font-bold">{{ number_format(rand(500000, 2000000)) }} đ</p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function changeMainImage(src) {
    document.getElementById('main-image').src = src;
}

function changeQuantity(delta) {
    const input = document.getElementById('quantity-input');
    const newValue = Math.max(1, parseInt(input.value) + delta);
    input.value = newValue;
}

function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-green-500', 'text-green-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName).classList.remove('hidden');
    
    // Add active state to clicked button
    event.target.classList.remove('border-transparent', 'text-gray-500');
    event.target.classList.add('border-green-500', 'text-green-600');
}

// Add to cart with AJAX and animation
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add-to-cart-form');
    const productImage = document.getElementById('main-image');
    const addToCartButton = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Show loading state
        const originalText = addToCartButton.innerHTML;
        addToCartButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
        addToCartButton.disabled = true;

        // Animation
        if (productImage) {
            const imageClone = productImage.cloneNode(true);
            const rect = productImage.getBoundingClientRect();

            imageClone.style.position = 'fixed';
            imageClone.style.left = rect.left + 'px';
            imageClone.style.top = rect.top + 'px';
            imageClone.style.width = rect.width + 'px';
            imageClone.style.height = rect.height + 'px';
            imageClone.style.transition = 'all 0.75s ease-in-out';
            imageClone.style.zIndex = 9999;
            imageClone.style.borderRadius = '9999px';
            imageClone.style.opacity = '0.9';

            document.body.appendChild(imageClone);

            setTimeout(() => {
                imageClone.style.left = 'calc(100vw - 80px)';
                imageClone.style.top = '20px';
                imageClone.style.width = '40px';
                imageClone.style.height = '40px';
                imageClone.style.opacity = '0.1';
            }, 50);

            setTimeout(() => {
                document.body.removeChild(imageClone);
            }, 850);
        }

        // AJAX request
        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message || 'Đã thêm vào giỏ hàng!', 'success');
                updateCartCount(data.cart_count);
            } else {
                showMessage(data.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
            }
        })
        .catch(error => {
            showMessage('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
        })
        .finally(() => {
            // Restore button state
            addToCartButton.innerHTML = originalText;
            addToCartButton.disabled = false;
        });
    });
});

// Show message function
function showMessage(message, type) {
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

// Update cart count function
function updateCartCount(count) {
    const badge = document.getElementById('cart-count-badge');
    if (badge) {
        badge.textContent = count;
        if (count === 0) {
            badge.style.display = 'none';
        } else {
            badge.style.display = 'block';
        }
    } else if (count > 0) {
        const cartIcon = document.getElementById('cart-icon');
        if (cartIcon && cartIcon.parentElement) {
            const newBadge = document.createElement('span');
            newBadge.id = 'cart-count-badge';
            newBadge.className = 'absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-2 py-0.5';
            newBadge.textContent = count;
            cartIcon.parentElement.appendChild(newBadge);
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const wishlistBtn = document.querySelector('button[data-product-id]');
    console.log('Wishlist button found:', wishlistBtn);
    
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function() {
            console.log('Wishlist button clicked');
            const productId = this.getAttribute('data-product-id');
            const icon = this.querySelector('i');
            const isInWishlist = icon.classList.contains('fas');
            
            console.log('Product ID:', productId);
            console.log('Is in wishlist:', isInWishlist);
            
            // Determine the URL based on current state
            const url = isInWishlist 
                ? '{{ route("wishlist.remove") }}'
                : '{{ route("wishlist.add") }}';
            
            console.log('Request URL:', url);
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `product_id=${productId}`
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Toggle icon state
                    if (isInWishlist) {
                        icon.classList.remove('fas', 'text-red-500');
                        icon.classList.add('far');
                    } else {
                        icon.classList.remove('far');
                        icon.classList.add('fas', 'text-red-500');
                    }
                    
                    // Update wishlist count if the function exists
                    if (typeof updateWishlistCount === 'function' && data.wishlist_count !== undefined) {
                        updateWishlistCount(data.wishlist_count);
                    }
                    
                    showMessage(data.message || (isInWishlist ? 'Đã xóa khỏi danh sách yêu thích' : 'Đã thêm vào danh sách yêu thích'), 'success');
                } else {
                    console.error('Request failed:', data.message);
                    showMessage(data.message || 'Có lỗi xảy ra', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Có lỗi xảy ra', 'error');
            });
        });
    }

});

// Use the global updateWishlistCount function from layout
// No need to redefine it here
</script>
@endpush
@endsection 