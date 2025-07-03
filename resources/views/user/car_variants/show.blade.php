@extends('layouts.app')

@section('title', $variant->name)

@section('content')
<div class="container mx-auto px-4 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <img src="{{ $variant->main_image_url }}"
                 id="product-image"
                 class="w-full rounded-xl shadow"
                 alt="{{ $variant->name }}">
        </div>
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $variant->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $variant->description }}</p>
            <p class="text-red-600 text-2xl font-bold mb-6">{{ number_format($variant->product->price) }} đ</p>

            <form method="POST" action="{{ route('cart.add') }}" id="add-to-cart-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $variant->product_id }}">
                <input type="hidden" name="quantity" value="1">
                <button
                    class="bg-indigo-600 text-white px-6 py-3 rounded-full hover:bg-indigo-700 transition flex items-center gap-2">
                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('add-to-cart-form');
        const productImage = document.getElementById('product-image');
        const cartIcon = document.getElementById('cart-icon');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!productImage || !cartIcon) {
                form.submit(); // fallback
                return;
            }

            const imageClone = productImage.cloneNode(true);
            const rect = productImage.getBoundingClientRect();
            const cartRect = cartIcon.getBoundingClientRect();

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
                imageClone.style.left = cartRect.left + 'px';
                imageClone.style.top = cartRect.top + 'px';
                imageClone.style.width = '40px';
                imageClone.style.height = '40px';
                imageClone.style.opacity = '0.1';
            }, 50);

            setTimeout(() => {
                document.body.removeChild(imageClone);
                form.submit();
            }, 850);
        });
    });
</script>
@endpush