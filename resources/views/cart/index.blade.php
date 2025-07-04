@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 py-8">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">
                <i class="fas fa-shopping-cart text-indigo-500 mr-3"></i>Giỏ hàng của bạn
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Quản lý và thanh toán các sản phẩm bạn đã chọn
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 px-4 py-3 rounded bg-green-100 text-green-800 text-center font-semibold shadow">{{ session('success') }}</div>
        @endif
        
        @if($cartItems->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-8 flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-gray-400 text-5xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-600 mb-4">Giỏ hàng trống</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    Bạn chưa có sản phẩm nào trong giỏ hàng. Hãy khám phá các sản phẩm và thêm vào giỏ hàng!
                </p>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    Khám phá sản phẩm
                </a>
            </div>
        @else
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-1 space-y-6">
                @foreach($cartItems as $item)
                    @php $itemTotal = $item->product->price * $item->quantity; @endphp
                    <div class="flex flex-col sm:flex-row items-center bg-white rounded-2xl shadow-lg p-6 gap-6 group hover:shadow-xl transition duration-300 relative cart-item-row transform hover:-translate-y-1" data-id="{{ $item->id }}">
                        <img src="{{ $item->product->image_url ?? asset('images/default-product.jpg') }}" class="w-28 h-28 object-contain rounded-xl bg-gray-100 border border-gray-200" alt="{{ $item->product->name }}">
                        <div class="flex-1 w-full">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-6">
                                <div class="flex-1">
                                    <div class="font-bold text-xl text-gray-900 mb-1">{{ $item->product->name }}</div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="flex items-center gap-2 color-display">
                                            <span class="text-xs text-gray-600">Màu:</span>
                                            @if($item->color)
                                            <div class="flex items-center gap-1 group relative">
                                                <div class="w-4 h-4 rounded-full border border-gray-300 shadow-sm hover:shadow-md transition-shadow cursor-pointer" 
                                                     style="background-color: {{ $item->color->color_name ? \App\Helpers\ColorHelper::getColorHex($item->color->color_name) : '#CCCCCC' }};" 
                                                     title="{{ $item->color->color_name }}">
                                                </div>
                                                <span class="text-xs text-gray-700 font-medium">{{ $item->color->color_name }}</span>
                                            </div>
                                            @else
                                            <span class="text-xs text-gray-500 italic">Chưa chọn</span>
                                            @endif
                                        </div>
                                        @if($item->product->product_type === 'car_variant' && isset($item->product->carVariant) && $item->product->carVariant && isset($item->product->carVariant->colors) && $item->product->carVariant->colors->count() > 0)
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-600">Chọn màu:</span>
                                            <div class="flex items-center gap-2">
                                                @foreach($item->product->carVariant->colors as $color)
                                                <button type="button" 
                                                        class="color-option w-6 h-6 rounded-full border-2 transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $item->color_id == $color->id ? 'border-blue-500 ring-2 ring-blue-200' : 'border-gray-300' }}"
                                                        style="background-color: {{ \App\Helpers\ColorHelper::getColorHex($color->color_name) }};"
                                                        data-color-id="{{ $color->id }}"
                                                        data-color-name="{{ $color->color_name }}"
                                                        data-item-id="{{ $item->id }}"
                                                        data-update-url="{{ route('cart.update', $item->id) }}"
                                                        data-csrf="{{ csrf_token() }}"
                                                        title="{{ $color->color_name }}">
                                                </button>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 mt-2 sm:mt-0">
                                    <div class="text-indigo-700 font-bold text-lg min-w-[100px] text-right sm:text-left">
                                        <span class="item-price" data-price="{{ $item->product->price }}">{{ number_format($item->product->price) }}</span> đ
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-20 border-2 border-gray-200 rounded-lg px-3 py-1 text-center focus:ring-2 focus:border-indigo-400 transition cart-qty-input text-lg font-semibold" data-update-url="{{ route('cart.update', $item->id) }}" data-csrf="{{ csrf_token() }}" data-id="{{ $item->id }}">
                                    </div>
                                    <div class="font-bold text-gray-900 min-w-[120px] text-right sm:text-left text-lg">
                                        <span class="item-total" data-id="{{ $item->id }}">{{ number_format($itemTotal) }}</span> đ
                                    </div>
                                    <button type="button" class="bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 p-3 rounded-full font-bold text-base transition duration-300 remove-item-btn shadow-sm hover:shadow-md" data-id="{{ $item->id }}" data-url="{{ route('cart.remove', $item->id) }}" data-csrf="{{ csrf_token() }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <button type="button" id="clear-cart-btn" class="w-full bg-red-500 hover:bg-red-600 text-white px-8 py-4 rounded-xl font-semibold transition duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center gap-2" data-url="{{ route('cart.clear') }}" data-csrf="{{ csrf_token() }}">
                    <i class="fas fa-trash mr-2"></i>
                    Xóa toàn bộ giỏ hàng
                </button>
            </div>
            <div class="w-full lg:w-96">
                <div class="sticky top-32 bg-white rounded-2xl shadow-lg p-6 flex flex-col gap-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xl font-semibold text-gray-700">Tổng cộng</span>
                        <span class="text-3xl font-extrabold text-indigo-600"><span id="cart-total">{{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity)) }}</span> đ</span>
                    </div>
                    <form action="{{ route('cart.checkout.form') }}" method="GET" class="w-full">
                        <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-xl font-semibold hover:from-green-700 hover:to-emerald-700 transition duration-300 transform hover:scale-105 shadow-lg text-lg flex items-center justify-center gap-2">
                            <i class="fas fa-credit-card mr-2"></i>
                            Thanh toán
                        </button>
                    </form>
                    <a href="{{ route('home') }}" class="w-full text-center text-indigo-600 hover:text-indigo-700 font-semibold text-sm mt-4 transition duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

function formatNumber(num) {
    return num.toLocaleString('vi-VN');
}

// Function to get color hex based on color name
function getColorHex(colorName) {
    const colorMap = {
        // Chữ thường
        'trắng': '#FFFFFF',
        'trang': '#FFFFFF',
        'white': '#FFFFFF',
        'đen': '#000000',
        'den': '#000000',
        'black': '#000000',
        'xám': '#808080',
        'xam': '#808080',
        'gray': '#808080',
        'bạc': '#C0C0C0',
        'bac': '#C0C0C0',
        'silver': '#C0C0C0',
        'đỏ': '#FF0000',
        'do': '#FF0000',
        'red': '#FF0000',
        'xanh dương': '#0000FF',
        'xanh duong': '#0000FF',
        'blue': '#0000FF',
        'xanh lá': '#00FF00',
        'xanh la': '#00FF00',
        'green': '#00FF00',
        'vàng': '#FFFF00',
        'vang': '#FFFF00',
        'yellow': '#FFFF00',
        'cam': '#FFA500',
        'orange': '#FFA500',
        'tím': '#800080',
        'tim': '#800080',
        'purple': '#800080',
        'hồng': '#FFC0CB',
        'hong': '#FFC0CB',
        'pink': '#FFC0CB',
        'nâu': '#A52A2A',
        'nau': '#A52A2A',
        'brown': '#A52A2A',
        
        // Chữ hoa đầu
        'Trắng': '#FFFFFF',
        'Trang': '#FFFFFF',
        'Đen': '#000000',
        'Den': '#000000',
        'Xám': '#808080',
        'Xam': '#808080',
        'Bạc': '#C0C0C0',
        'Bac': '#C0C0C0',
        'Đỏ': '#FF0000',
        'Do': '#FF0000',
        'Xanh dương': '#0000FF',
        'Xanh duong': '#0000FF',
        'Xanh lá': '#00FF00',
        'Xanh la': '#00FF00',
        'Vàng': '#FFFF00',
        'Vang': '#FFFF00',
        'Cam': '#FFA500',
        'Tím': '#800080',
        'Tim': '#800080',
        'Hồng': '#FFC0CB',
        'Hong': '#FFC0CB',
        'Nâu': '#A52A2A',
        'Nau': '#A52A2A'
    };
    
    const normalizedName = colorName.trim();
    return colorMap[normalizedName] || '#CCCCCC'; // Default gray if not found
}

const qtyInputs = document.querySelectorAll('.cart-qty-input');
qtyInputs.forEach(input => {
    input.addEventListener('input', debounce(function(e) {
        const url = this.dataset.updateUrl;
        const csrf = this.dataset.csrf;
        const quantity = parseInt(this.value);
        const id = this.dataset.id;
        if (quantity < 1) return;
        // Show loading state
        this.classList.add('opacity-50');
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ quantity })
        })
        .then(res => res.json())
        .then(data => {
            // Remove loading state
            input.classList.remove('opacity-50');
            // Update input value in case backend changed it
            if (data.quantity !== undefined) {
                input.value = data.quantity;
            }
            // Update item total and cart total without reload
            const price = parseInt(document.querySelector(`.cart-item-row[data-id='${id}'] .item-price`).dataset.price);
            const itemTotal = price * input.value;
            document.querySelector(`.cart-item-row[data-id='${id}'] .item-total`).textContent = formatNumber(itemTotal);
            // Update cart total
            let newTotal = 0;
            let cartCount = 0;
            document.querySelectorAll('.cart-item-row').forEach(row => {
                const qty = parseInt(row.querySelector('.cart-qty-input').value);
                const price = parseInt(row.querySelector('.item-price').dataset.price);
                newTotal += qty * price;
                cartCount += qty;
            });
            document.getElementById('cart-total').textContent = formatNumber(newTotal);
            // Update cart count badge immediately
            if (typeof updateCartCount === 'function') {
                updateCartCount(cartCount);
            } else {
                const badge = document.getElementById('cart-count-badge');
                if (badge) badge.textContent = cartCount;
            }
        })
        .catch(() => {
            input.classList.remove('opacity-50');
        });
        // Update UI immediately for better UX
        const price = parseInt(document.querySelector(`.cart-item-row[data-id='${id}'] .item-price`).dataset.price);
        const itemTotal = price * quantity;
        document.querySelector(`.cart-item-row[data-id='${id}'] .item-total`).textContent = formatNumber(itemTotal);
        let newTotal = 0;
        let cartCount = 0;
        document.querySelectorAll('.cart-item-row').forEach(row => {
            const qty = parseInt(row.querySelector('.cart-qty-input').value);
            const price = parseInt(row.querySelector('.item-price').dataset.price);
            newTotal += qty * price;
            cartCount += qty;
        });
        document.getElementById('cart-total').textContent = formatNumber(newTotal);
        // Update cart count badge immediately
        if (typeof updateCartCount === 'function') {
            updateCartCount(cartCount);
        } else {
            const badge = document.getElementById('cart-count-badge');
            if (badge) badge.textContent = cartCount;
        }
    }, 600));
});

// Handle color option selection
document.querySelectorAll('.color-option').forEach(button => {
    button.addEventListener('click', function() {
        console.log('Color option clicked:', this.dataset); // Debug log
        
        const url = this.dataset.updateUrl;
        const csrf = this.dataset.csrf;
        const colorId = this.dataset.colorId;
        const colorName = this.dataset.colorName;
        const itemId = this.dataset.itemId;
        
        console.log('Sending request:', { url, colorId, colorName, itemId }); // Debug log
        
        // Update visual selection immediately
        const colorContainer = this.closest('.flex.items-center.gap-2');
        const allColorOptions = colorContainer.querySelectorAll('.color-option');
        allColorOptions.forEach(opt => {
            opt.classList.remove('border-blue-500', 'ring-2', 'ring-blue-200');
            opt.classList.add('border-gray-300');
        });
        this.classList.remove('border-gray-300');
        this.classList.add('border-blue-500', 'ring-2', 'ring-blue-200');
        
        // Show loading state
        this.classList.add('opacity-50');
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ color_id: colorId })
        })
        .then(res => {
            console.log('Response status:', res.status);
            console.log('Response headers:', res.headers);
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            // Remove loading state
            this.classList.remove('opacity-50');
            
            console.log('Color update response:', data); // Debug log
            
            if (data.success) {
                console.log('Updating color display...'); // Debug log
                // Cập nhật phần hiển thị màu đã chọn
                const cartItemRow = this.closest('.cart-item-row');
                const colorDisplay = cartItemRow.querySelector('.color-display');
                console.log('Found color display:', colorDisplay); // Debug log
                
                if (colorDisplay) {
                    const colorHex = getColorHex(data.color_name || this.dataset.colorName);
                    console.log('Color hex:', colorHex); // Debug log
                    colorDisplay.innerHTML = `
                        <span class="text-xs text-gray-600">Màu:</span>
                        <div class="flex items-center gap-1 group relative">
                            <div class="w-4 h-4 rounded-full border border-gray-300 shadow-sm" style="background-color: ${colorHex};" title="${data.color_name || this.dataset.colorName}"></div>
                            <span class="text-xs text-gray-700 font-medium">${data.color_name || this.dataset.colorName}</span>
                        </div>
                    `;
                    console.log('Color display updated successfully'); // Debug log
                } else {
                    console.log('Color display not found!'); // Debug log
                }
                // Show success message
                if (typeof showMessage === 'function') {
                    showMessage(data.message, 'success');
                } else {
                    // Fallback success message
                    console.log('Color updated successfully:', data.message);
                }
            } else {
                console.log('Request failed:', data); // Debug log
                // Handle error response - revert visual selection if needed
                const errorMessage = data.message || 'Có lỗi xảy ra khi cập nhật màu sắc';
                if (typeof showMessage === 'function') {
                    showMessage(errorMessage, 'error');
                } else {
                    alert(errorMessage);
                }
            }
        })
        .catch((error) => {
            this.classList.remove('opacity-50');
            console.error('Color update error:', error); // Debug log
            if (typeof showMessage === 'function') {
                showMessage('Có lỗi xảy ra khi cập nhật màu sắc', 'error');
            } else {
                alert('Có lỗi xảy ra khi cập nhật màu sắc');
            }
        });
    });
});

// Handle remove item buttons
document.querySelectorAll('.remove-item-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) return;
        
        const url = this.dataset.url;
        const csrf = this.dataset.csrf;
        const itemId = this.dataset.id;
        
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Remove the item row
                document.querySelector(`.cart-item-row[data-id='${itemId}']`).remove();
                
                // Update cart count
                if (typeof updateCartCount === 'function') {
                    updateCartCount(data.cart_count);
                }
                
                // Recalculate total
                let newTotal = 0;
                document.querySelectorAll('.cart-item-row').forEach(row => {
                    const qty = parseInt(row.querySelector('.cart-qty-input').value);
                    const price = parseInt(row.querySelector('.item-price').dataset.price);
                    newTotal += qty * price;
                });
                document.getElementById('cart-total').textContent = formatNumber(newTotal);
                
                // Show success message
                if (typeof showMessage === 'function') {
                    showMessage(data.message, 'success');
                }
                
                // If cart is empty, reload page to show empty state
                if (data.cart_count === 0) {
                    location.reload();
                }
            }
        })
        .catch(() => {
            if (typeof showMessage === 'function') {
                showMessage('Có lỗi xảy ra khi xóa sản phẩm', 'error');
            }
        });
    });
});

// Handle clear cart button
document.getElementById('clear-cart-btn').addEventListener('click', function() {
    if (!confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')) return;
    
    const url = this.dataset.url;
    const csrf = this.dataset.csrf;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            if (typeof updateCartCount === 'function') {
                updateCartCount(data.cart_count);
            }
            
            // Show success message
            if (typeof showMessage === 'function') {
                showMessage(data.message, 'success');
            }
            
            // Reload page to show empty state
            location.reload();
        }
    })
    .catch(() => {
        if (typeof showMessage === 'function') {
            showMessage('Có lỗi xảy ra khi xóa giỏ hàng', 'error');
        }
    });
});
</script>

<style>
    .cart-item-row {
        transition: all 0.3s ease;
    }
    
    .color-option {
        transition: all 0.3s ease;
    }
    
    .color-option:hover {
        transform: scale(1.1);
    }
    
    /* Smooth transitions for all interactive elements */
    .remove-item-btn, button, a {
        transition: all 0.3s ease;
    }
    
    /* Hover effects for better UX */
    .cart-item-row:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush