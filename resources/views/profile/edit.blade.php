@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Sidebar: User Info & Password --}}
                <div class="col-span-1 space-y-8">
                    {{-- User Card --}}
                    <div class="bg-white shadow rounded-2xl p-6 flex flex-col items-center">
                        <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-4 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4f46e5&color=fff&size=128" alt="Avatar" class="w-24 h-24 object-cover">
                        </div>
                        <div class="text-center">
                            <div class="font-bold text-xl text-gray-900">{{ $user->name }}</div>
                            <div class="text-gray-500 text-sm mt-1">{{ $user->email }}</div>
                            @if($user->phone)
                                <div class="text-gray-500 text-sm mt-1"><i class="fas fa-phone mr-1"></i>{{ $user->phone }}</div>
                            @endif
                            @if($user->address)
                                <div class="text-gray-500 text-sm mt-1"><i class="fas fa-map-marker-alt mr-1"></i>{{ $user->address }}</div>
                            @endif
                        </div>
                    </div>
                    {{-- Edit Info --}}
                    <div class="bg-white shadow rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-user-edit text-indigo-500"></i> Cập nhật thông tin</h3>
                        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                            @csrf
                            @method('patch')
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Họ tên</label>
                                <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @error('name')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input id="email" name="email" type="email" class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                                <input id="phone" name="phone" type="text" class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('phone', $user->phone) }}" autocomplete="tel">
                                @error('phone')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                                <input id="address" name="address" type="text" class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('address', $user->address) }}" autocomplete="address">
                                @error('address')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="flex items-center gap-4 mt-4">
                                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700 transition">Lưu thay đổi</button>
                                @if (session('status') === 'profile-updated')
                                    <span class="text-green-600 text-sm">Đã lưu thay đổi!</span>
                                @endif
                            </div>
                        </form>
                    </div>
                    {{-- Change Password --}}
                    <div class="bg-white shadow rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-key text-indigo-500"></i> Đổi mật khẩu</h3>
                        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                            @csrf
                            @method('put')
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Mật khẩu hiện tại</label>
                                <input id="current_password" name="current_password" type="password" class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" autocomplete="current-password">
                                @error('current_password')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu mới</label>
                                <input id="password" name="password" type="password" class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" autocomplete="new-password">
                                @error('password')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu mới</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" autocomplete="new-password">
                                @error('password_confirmation')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="flex items-center gap-4 mt-4">
                                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700 transition">Đổi mật khẩu</button>
                                @if (session('status') === 'password-updated')
                                    <span class="text-green-600 text-sm">Đã đổi mật khẩu!</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                {{-- Main: Order History --}}
                <div class="col-span-2">
                    <div class="bg-white shadow rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2"><i class="fas fa-box-open text-indigo-500"></i> Lịch sử đơn hàng</h3>
                        @if($orders->isEmpty())
                            <div class="text-gray-500 text-center py-8">Bạn chưa có đơn hàng nào.</div>
                        @else
                            <div class="space-y-6">
                                @foreach($orders as $order)
                                    <div class="border rounded-xl p-4 bg-gray-50 shadow-sm">
                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2 gap-2">
                                            <div class="text-gray-700 text-sm">Mã đơn: <span class="font-semibold">#{{ $order->id }}</span></div>
                                            <div class="text-gray-700 text-sm">Ngày đặt: <span class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                                            <div class="text-sm font-semibold px-3 py-1 rounded-full @if($order->status === 'pending') bg-yellow-100 text-yellow-800 @elseif($order->status === 'completed') bg-green-100 text-green-800 @else bg-gray-200 text-gray-700 @endif">
                                                <i class="fas fa-circle mr-1 text-xs align-middle"></i>{{ ucfirst($order->status) }}
                                            </div>
                                            <div class="text-indigo-700 font-bold text-lg">{{ number_format($order->total_price) }} đ</div>
                                        </div>
                                        <div class="overflow-x-auto mt-2">
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="bg-gray-100">
                                                        <th class="py-2 px-2 text-left">Sản phẩm</th>
                                                        <th class="py-2 px-2 text-left">Màu</th>
                                                        <th class="py-2 px-2 text-center">SL</th>
                                                        <th class="py-2 px-2 text-right">Giá</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->items as $item)
                                                        <tr>
                                                            <td class="py-1 px-2">{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</td>
                                                            <td class="py-1 px-2">{{ $item->color?->color_name ?? '-' }}</td>
                                                            <td class="py-1 px-2 text-center">{{ $item->quantity }}</td>
                                                            <td class="py-1 px-2 text-right">{{ number_format($item->price) }} đ</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
