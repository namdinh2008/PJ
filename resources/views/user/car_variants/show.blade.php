@extends('layouts.app')

@section('title', $variant->name)

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
                            <a href="#" class="text-gray-500 hover:text-gray-700">{{ $variant->carModel->car->name ?? 'Xe hơi' }}</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="#" class="text-gray-500 hover:text-gray-700">{{ $variant->carModel->name ?? 'Model' }}</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-900 font-medium">{{ $variant->name }}</span>
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
                    <img src="{{ $variant->image_url }}"
                         id="main-image"
                         class="w-full h-96 object-cover rounded-2xl shadow-lg"
                         alt="{{ $variant->name }}">
                    <div class="absolute top-4 left-4">
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-star mr-1"></i>Nổi bật
                        </span>
                    </div>
                </div>
                
                <!-- Thumbnail Gallery -->
                <div class="grid grid-cols-4 gap-4">
                    @foreach($variant->colors as $color)
                        <!-- Debug info: {{ $color->image_url }} -->
                        <img src="{{ $color->image_url }}"
                             class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-75 transition color-thumbnail"
                             onclick="changeMainImage(this.src)"
                             alt="{{ $color->color_name }}">
                    @endforeach
                    
                    @if($variant->images && $variant->images->where('is_main', false)->count() > 0)
                        @foreach($variant->images->where('is_main', false) as $image)
                            <img src="{{ $image->image_url }}"
                                 class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-75 transition"
                                 onclick="changeMainImage(this.src)"
                                 alt="{{ $variant->name }}">
                        @endforeach
                    @elseif($variant->colors->count() < 4)
                        @for($i = $variant->colors->count(); $i < 4; $i++)
                            <img src="{{ $variant->image_url }}"
                                 class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-75 transition"
                                 onclick="changeMainImage(this.src)"
                                 alt="{{ $variant->name }}">
                        @endfor
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $variant->name }}</h1>
                    <p class="text-lg text-gray-600 mb-4">{{ $variant->carModel->name ?? 'Model' }}</p>
                    
                    <!-- Rating -->
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <span class="ml-2 text-gray-600">(4.8/5) - 128 đánh giá</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-2xl">
                    <div class="flex items-baseline gap-4">
                        <span class="text-4xl font-bold text-indigo-600">{{ number_format($variant->product->price) }} đ</span>
                        <span class="text-lg text-gray-500 line-through">{{ number_format($variant->product->price * 1.1) }} đ</span>
                        <span class="bg-red-500 text-white px-2 py-1 rounded text-sm font-semibold">-10%</span>
                    </div>
                    <p class="text-gray-600 mt-2">Giá đã bao gồm thuế VAT</p>
                </div>

                <!-- Color Options -->
                @if($variant->colors->count() > 0)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Chọn màu sắc</h3>
                    <div class="flex gap-3">
                        @foreach($variant->colors as $color)
                            <button type="button" 
                                    onclick="selectColor({{ $color->id }}, '{{ $color->color_name }}')"
                                    class="color-option flex flex-col items-center p-3 border-2 border-gray-200 rounded-lg hover:border-indigo-500 transition"
                                    data-color-id="{{ $color->id }}">
                                {{-- <div class="w-8 rounded-full bg-{{ strtolower($color->color_name) }}-500 mb-2"></div> --}}
                                <span class="text-sm text-gray-700 font-bold">{{ $color->color_name }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Add to Cart -->
                <div class="space-y-4">
                    <form method="POST" action="{{ route('cart.add') }}" id="add-to-cart-form" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $variant->product->id }}">
                        <input type="hidden" name="color_id" value="" id="selected-color-id">
                        <!-- Debug info -->
                        {{-- <div class="text-xs text-gray-500 mb-2">
                            Debug: Product ID = {{ $variant->product->id ?? 'NULL' }}, 
                            Variant ID = {{ $variant->id }}, 
                            Product Name = {{ $variant->product->name ?? 'NULL' }}
                        </div> --}}
                        
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
                                    class="flex-1 bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-indigo-700 transition flex items-center justify-center gap-3 text-lg">
                                <i class="fas fa-cart-plus"></i>
                                Thêm vào giỏ hàng
                            </button>
                            @php
                                $isInWishlist = false;
                                if (auth()->check()) {
                                    $isInWishlist = \App\Helpers\WishlistHelper::isInWishlist($variant->product->id);
                                }
                            @endphp
                            <button type="button" id="wishlist-btn" data-product-id="{{ $variant->product->id }}"
                                    class="px-6 py-4 border-2 border-gray-300 rounded-xl hover:border-indigo-500 transition">
                                <i class="{{ $isInWishlist ? 'fas text-red-500' : 'far' }} fa-heart text-xl"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Quick Info -->
                <div class="grid grid-cols-2 gap-4 pt-6 border-t">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-shipping-fast text-2xl text-indigo-600 mb-2"></i>
                        <div class="text-sm font-semibold">Giao hàng miễn phí</div>
                        <div class="text-xs text-gray-500">Trong 3-5 ngày</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-shield-alt text-2xl text-indigo-600 mb-2"></i>
                        <div class="text-sm font-semibold">Bảo hành 12 tháng</div>
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
                            class="tab-button border-b-2 border-indigo-500 py-2 px-1 text-sm font-medium text-indigo-600">
                        Mô tả
                    </button>
                    <button onclick="showTab('specifications')" 
                            class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Thông số kỹ thuật
                    </button>
                    <button onclick="showTab('reviews')" 
                            class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700">
                        Đánh giá (128)
                    </button>
                </nav>
            </div>

            <!-- Description Tab -->
            <div id="description" class="tab-content py-8">
                <div class="prose max-w-none">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mô tả sản phẩm</h3>
                    <p class="text-gray-700 leading-relaxed mb-6">{{ $variant->description }}</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-cog text-indigo-600"></i> Tính năng nổi bật
                            </h4>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check text-green-500"></i>
                                    Thiết kế hiện đại, sang trọng
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check text-green-500"></i>
                                    Chất liệu cao cấp, bền bỉ
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check text-green-500"></i>
                                    Dễ dàng lắp đặt và sử dụng
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fas fa-check text-green-500"></i>
                                    Bảo hành chính hãng 12 tháng
                                </li>
                            </ul>
                        </div>
                        
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-info-circle text-indigo-600"></i> Thông tin bổ sung
                            </h4>
                            <ul class="space-y-2 text-gray-700">
                                <li><strong>Xuất xứ:</strong> Chính hãng</li>
                                <li><strong>Chất liệu:</strong> Cao cấp</li>
                                <li><strong>Kích thước:</strong> Đa dạng</li>
                                <li><strong>Màu sắc:</strong> {{ $variant->colors->pluck('color_name')->implode(', ') }}</li>
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
                                    <span class="font-medium">{{ $variant->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Model:</span>
                                    <span class="font-medium">{{ $variant->carModel->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Hãng xe:</span>
                                    <span class="font-medium">{{ $variant->carModel->car->name ?? 'N/A' }}</span>
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
                                    <span class="font-medium">2-5kg</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Chất liệu:</span>
                                    <span class="font-medium">Cao cấp</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Bảo hành:</span>
                                    <span class="font-medium">12 tháng</span>
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
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Viết đánh giá
                    </button>
                </div>
                
                <div class="space-y-6">
                    <!-- Review Stats -->
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <div class="flex items-center gap-8">
                            <div class="text-center">
                                <div class="text-4xl font-bold text-indigo-600">4.8</div>
                                <div class="flex text-yellow-400 justify-center my-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                                <div class="text-sm text-gray-600">128 đánh giá</div>
                            </div>
                            
                            <div class="flex-1">
                                <div class="space-y-2">
                                    @for($i = 5; $i >= 1; $i--)
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-gray-600 w-8">{{ $i }} sao</span>
                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ 100 - ($i * 10) }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600 w-12">{{ 100 - ($i * 10) }}%</span>
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
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <span class="text-indigo-600 font-semibold">NV</span>
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
                                <span class="text-sm text-gray-500">2 ngày trước</span>
                            </div>
                            <p class="text-gray-700">Sản phẩm chất lượng rất tốt, giao hàng nhanh chóng. Rất hài lòng với dịch vụ!</p>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <span class="text-indigo-600 font-semibold">TL</span>
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
                            <p class="text-gray-700">Chất lượng sản phẩm tốt, giá cả hợp lý. Sẽ mua thêm trong tương lai.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-16">
            <h3 class="text-2xl font-bold text-gray-900 mb-8">Sản phẩm liên quan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @for($i = 1; $i <= 4; $i++)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition">
                        <img src="https://via.placeholder.com/300x200/4f46e5/ffffff?text=Sản+phẩm+{{ $i }}" 
                             class="w-full h-48 object-cover" alt="Sản phẩm {{ $i }}">
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 mb-2">Sản phẩm liên quan {{ $i }}</h4>
                            <p class="text-indigo-600 font-bold">{{ number_format(rand(1000000, 5000000)) }} đ</p>
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

function selectColor(colorId, colorName) {
    // Remove active state from all color options
    document.querySelectorAll('.color-option').forEach(option => {
        option.classList.remove('border-indigo-500', 'bg-indigo-50');
        option.classList.add('border-gray-200');
    });
    
    // Add active state to selected color
    event.target.closest('.color-option').classList.remove('border-gray-200');
    event.target.closest('.color-option').classList.add('border-indigo-500', 'bg-indigo-50');
    
    // Update hidden input
    document.getElementById('selected-color-id').value = colorId;
}

function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-indigo-500', 'text-indigo-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName).classList.remove('hidden');
    
    // Add active state to clicked button
    event.target.classList.remove('border-transparent', 'text-gray-500');
    event.target.classList.add('border-indigo-500', 'text-indigo-600');
}

// Add to cart with AJAX and animation
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('add-to-cart-form');
    const productImage = document.getElementById('main-image');
    const addToCartButton = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Check if color is selected when colors are available
        const colorOptions = document.querySelectorAll('.color-option');
        const colorInput = document.getElementById('selected-color-id');
        
        if (colorOptions.length > 0 && (!colorInput.value || colorInput.value === '')) {
            showMessage('Vui lòng chọn màu sắc trước khi thêm vào giỏ hàng', 'error');
            return;
        }

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
            body: new URLSearchParams(formData),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message || 'Đã thêm vào giỏ hàng!', 'success');
                if (typeof updateCartCount === 'function' && data.cart_count !== undefined) {
                    updateCartCount(data.cart_count);
                }
            } else {
                showMessage(data.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
        })
        .finally(() => {
            // Restore button state
            addToCartButton.innerHTML = originalText;
            addToCartButton.disabled = false;
        });
    });
});

// Check if color images are loading correctly
document.addEventListener('DOMContentLoaded', function() {
    const colorThumbnails = document.querySelectorAll('.color-thumbnail');
    
    colorThumbnails.forEach(img => {
        img.addEventListener('error', function() {
            console.error('Failed to load image:', this.src);
            this.src = 'https://via.placeholder.com/100x100/cccccc/ffffff?text=' + this.alt;
        });
        
        console.log('Color image src:', img.src);
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
    // Find all cart count badges
    const badges = document.querySelectorAll('.cart-count');
    
    if (badges.length > 0) {
        // Update all cart count badges on the page
        badges.forEach(function(badge) {
            badge.textContent = count;
            if (count === 0) {
                badge.style.display = 'none';
            } else {
                badge.style.display = 'flex';
            }
        });
    } else {
        // If no badge exists, try to find the cart icon in the header
        const cartIcon = document.querySelector('a[href*="cart"] i.fa-shopping-cart');
        if (cartIcon && cartIcon.parentElement) {
            const newBadge = document.createElement('span');
            newBadge.id = 'cart-count-badge';
            newBadge.className = 'absolute -top-1 -right-1 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center cart-count';
            newBadge.textContent = count;
            cartIcon.parentElement.style.position = 'relative';
            cartIcon.parentElement.appendChild(newBadge);
        }
    }
    
    // Also try to update the cart count in the header specifically
    const headerBadge = document.getElementById('cart-count-badge');
    if (headerBadge) {
        headerBadge.textContent = count;
        if (count === 0) {
            headerBadge.style.display = 'none';
        } else {
            headerBadge.style.display = 'flex';
        }
    }
}

// Use the global updateWishlistCount function from layout
// No need to redefine it here

// Add wishlist functionality
document.addEventListener('DOMContentLoaded', function() {
    const wishlistBtn = document.getElementById('wishlist-btn');
    
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const icon = this.querySelector('i');
            const isInWishlist = icon.classList.contains('fas');
            
            // Determine the URL based on current state
            const url = isInWishlist 
                ? '{{ route("wishlist.remove") }}'
                : '{{ route("wishlist.add") }}';
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `product_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
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
</script>
@endpush
@endsection