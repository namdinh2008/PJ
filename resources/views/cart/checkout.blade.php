@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-8 text-center text-gray-900 tracking-tight">
            <i class="fas fa-credit-card mr-2 text-indigo-700"></i>Thanh toán đơn hàng
        </h2>

        @if ($errors->any())
        <div class="mb-6 px-4 py-3 rounded bg-red-100 text-red-700 font-semibold shadow">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Order Summary --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-shopping-cart text-indigo-500"></i> Chi tiết đơn hàng
                    </h3>
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                        @php 
                        $itemTotal = $item->product->price * $item->quantity; 
                        $imageUrl = $item->product->image_url;
                        if ($item->product->product_type === 'car_variant' && $item->product->carVariant) {
                            $imageUrl = $item->product->carVariant->image_url;
                        }
                    @endphp
                        <div class="flex items-center gap-4 p-4 border rounded-lg">
                            <img src="{{ $imageUrl }}"
                                class="w-20 h-20 object-cover rounded-lg bg-gray-100"
                                alt="{{ $item->product->name }}">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900">{{ $item->product->name }}</div>
                                @if($item->color)
                                <div class="text-sm text-gray-500">Màu: {{ $item->color->color_name }}</div>
                                @endif
                                <div class="text-sm text-gray-600">Số lượng: {{ $item->quantity }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-indigo-700">{{ number_format($item->product->price) }} đ</div>
                                <div class="text-sm text-gray-500">x {{ $item->quantity }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Shipping Options --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-truck text-indigo-500"></i> Phương thức vận chuyển
                    </h3>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="shipping_method" value="standard" checked class="mr-3">
                            <div class="flex-1">
                                <div class="font-semibold">Giao hàng tiêu chuẩn</div>
                                <div class="text-sm text-gray-500">3-5 ngày làm việc</div>
                            </div>
                            <div class="font-bold text-indigo-700">30,000 đ</div>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="shipping_method" value="express" class="mr-3">
                            <div class="flex-1">
                                <div class="font-semibold">Giao hàng nhanh</div>
                                <div class="text-sm text-gray-500">1-2 ngày làm việc</div>
                            </div>
                            <div class="font-bold text-indigo-700">50,000 đ</div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Checkout Form --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-32">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-user text-indigo-500"></i> Thông tin thanh toán
                    </h3>

                    <form action="{{ route('cart.checkout') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">Số điện thoại <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:border-indigo-400 transition" required value="{{ old('phone', $user->phone ?? '') }}">
                        </div>
                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" name="name" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:border-indigo-400 transition" required value="{{ old('name', $user->name ?? '') }}">
                        </div>
                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">Email</label>
                            <input type="email" name="email" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:border-indigo-400 transition" value="{{ old('email', $user->email ?? '') }}">
                        </div>
                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">Địa chỉ <span class="text-red-500">*</span></label>
                            <textarea name="address" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:border-indigo-400 transition" rows="3" required>{{ old('address', $user->address ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">Ghi chú</label>
                            <textarea name="note" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:border-indigo-400 transition" rows="2">{{ old('note') }}</textarea>
                        </div>
                        <div>
                            <label class="block font-semibold mb-2 text-gray-700">Phương thức thanh toán</label>
                            <select name="payment_method" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:border-indigo-400 transition">
                                <option value="cod" {{ old('payment_method', 'cod') == 'cod' ? 'selected' : '' }}>💵 Thanh toán khi nhận hàng (COD)</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>🏦 Chuyển khoản ngân hàng</option>
                                <option value="vnpay" {{ old('payment_method') == 'vnpay' ? 'selected' : '' }}>💳 VNPay</option>
                                <option value="momo" {{ old('payment_method') == 'momo' ? 'selected' : '' }}>📱 Momo</option>
                            </select>
                        </div>

                        {{-- Order Summary --}}
                        <div class="bg-gray-50 rounded-lg p-4 mt-6">
                            <h4 class="font-bold mb-3 text-gray-800">Tóm tắt đơn hàng</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span>Tạm tính:</span>
                                    <span>{{ number_format($total) }} đ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Phí vận chuyển:</span>
                                    <span id="shipping-fee">30,000 đ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Thuế VAT:</span>
                                    <span>{{ number_format($total * 0.1) }} đ</span>
                                </div>
                                <div class="border-t pt-2 font-bold text-lg">
                                    <div class="flex justify-between">
                                        <span>Tổng cộng:</span>
                                        <span id="total-amount" class="text-indigo-700">{{ number_format($total + 30000 + ($total * 0.1)) }} đ</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 shadow-lg transition text-lg flex items-center justify-center gap-2">
                            <i class="fas fa-check"></i> Đặt hàng ngay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingInputs = document.querySelectorAll('input[name="shipping_method"]');
        const shippingFee = document.getElementById('shipping-fee');
        const totalAmount = document.getElementById('total-amount');
        const subtotal = {
            {
                $total
            }
        };
        const vat = subtotal * 0.1;

        function updateTotal() {
            const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
            const shippingCost = selectedShipping.value === 'express' ? 50000 : 30000;

            shippingFee.textContent = shippingCost.toLocaleString() + ' đ';
            const total = subtotal + shippingCost + vat;
            totalAmount.textContent = total.toLocaleString() + ' đ';
        }

        shippingInputs.forEach(input => {
            input.addEventListener('change', updateTotal);
        });
    });
</script>
@endpush
@endsection