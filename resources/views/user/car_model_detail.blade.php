@extends('layouts.app')

@section('title', $carModel->name . ' - AutoLux')

@section('content')
<!-- Hero Section -->
<section class="relative w-full h-screen overflow-hidden">
    <!-- Background Video/Image -->
    <div class="absolute inset-0">
        <img src="{{ $carModel->image_url }}" alt="{{ $carModel->name }}" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/60"></div>
    </div>
    
    <!-- Navigation Dots -->
    <div class="absolute right-8 top-1/2 transform -translate-y-1/2 z-20">
        <div class="flex flex-col space-y-4">
            <a href="#overview" class="w-3 h-3 bg-white rounded-full opacity-60 hover:opacity-100 transition-opacity"></a>
            <a href="#variants" class="w-3 h-3 bg-white rounded-full opacity-60 hover:opacity-100 transition-opacity"></a>
            <a href="#gallery" class="w-3 h-3 bg-white rounded-full opacity-60 hover:opacity-100 transition-opacity"></a>
            <a href="#specs" class="w-3 h-3 bg-white rounded-full opacity-60 hover:opacity-100 transition-opacity"></a>
        </div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 h-full flex items-center">
        <div class="max-w-7xl mx-auto px-6 w-full">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-16 items-center h-full">
                <!-- Left Content -->
                <div class="text-white space-y-8">
                    <!-- Brand Badge -->
                    <div class="inline-flex items-center bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-6 py-3">
                        <i class="fas fa-crown text-yellow-400 mr-3"></i>
                        <span class="text-sm font-medium">{{ $carModel->car->name ?? 'Premium Vehicle' }}</span>
                    </div>
                    
                    <!-- Main Title -->
                    <div>
                        <h1 class="text-6xl xl:text-8xl font-black mb-6 leading-none">
                            {{ $carModel->name }}
                        </h1>
                        <p class="text-xl xl:text-2xl text-gray-300 max-w-xl leading-relaxed">
                            {{ $carModel->description ?? 'Khám phá sự hoàn hảo trong thiết kế và công nghệ tiên tiến nhất.' }}
                        </p>
                    </div>
                    
                    <!-- Key Specifications -->
                    @php
                        $firstVariant = $variants->first();
                        $features = $firstVariant ? json_decode($firstVariant->features, true) : [];
                    @endphp
                    <div class="grid grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="text-4xl font-black text-blue-400 mb-2">{{ $features['Quãng đường'] ?? '---' }}</div>
                            <div class="text-sm text-gray-400 uppercase tracking-wider">Quãng đường</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-black text-blue-400 mb-2">{{ $features['Tăng tốc 0-100km/h'] ?? '---' }}</div>
                            <div class="text-sm text-gray-400 uppercase tracking-wider">Tăng tốc</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-black text-blue-400 mb-2">{{ $features['Công suất'] ?? '---' }}</div>
                            <div class="text-sm text-gray-400 uppercase tracking-wider">Công suất</div>
                        </div>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-6 pt-4">
                        <a href="#variants" class="group inline-flex items-center justify-center px-10 py-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-lg rounded-2xl hover:from-blue-700 hover:to-blue-800 transition-all duration-500 transform hover:scale-105 shadow-2xl">
                            <i class="fas fa-car mr-3 group-hover:translate-x-1 transition-transform"></i>
                            Khám phá các phiên bản
                        </a>
                        <a href="#gallery" class="group inline-flex items-center justify-center px-10 py-5 border-2 border-white text-white font-bold text-lg rounded-2xl hover:bg-white hover:text-gray-900 transition-all duration-500 backdrop-blur-sm">
                            <i class="fas fa-images mr-3 group-hover:rotate-12 transition-transform"></i>
                            Thư viện ảnh
                        </a>
                    </div>
                </div>
                
                <!-- Right Car Display -->
                <div class="hidden xl:block relative">
                    <div class="relative group">
                        <!-- Main Car Image -->
                        <img src="{{ $carModel->image_url }}" alt="{{ $carModel->name }}" 
                             class="w-full h-auto rounded-3xl shadow-2xl transform rotate-6 group-hover:rotate-0 transition-all duration-700" />
                        
                        <!-- Floating Price Card -->
                        <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-2xl p-6 transform rotate-3 group-hover:rotate-0 transition-all duration-700">
                            <div class="text-center">
                                <div class="text-3xl font-black text-gray-900 mb-1">
                                    {{ number_format($firstVariant->product->price ?? 0) }} đ
                                </div>
                                <div class="text-sm text-gray-500 font-medium">Giá khởi điểm</div>
                                <div class="w-12 h-1 bg-blue-600 rounded-full mx-auto mt-3"></div>
                            </div>
                        </div>
                        
                        <!-- Floating Specs -->
                        <div class="absolute top-8 -left-8 bg-black/80 backdrop-blur-sm rounded-2xl p-4 text-white">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-400">{{ $features['Tốc độ tối đa'] ?? '---' }}</div>
                                <div class="text-xs text-gray-300 uppercase tracking-wider">Tốc độ tối đa</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20">
        <div class="flex flex-col items-center text-white">
            <span class="text-sm mb-2 opacity-60">Cuộn xuống</span>
            <div class="w-6 h-10 border-2 border-white rounded-full flex justify-center">
                <div class="w-1 h-3 bg-white rounded-full mt-2 animate-bounce"></div>
            </div>
        </div>
    </div>
    </section>

    <!-- Overview Section -->
    <section id="overview" class="py-24 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-black text-gray-900 mb-6">Tổng quan</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    {{ $carModel->name }} là sự kết hợp hoàn hảo giữa thiết kế hiện đại và công nghệ tiên tiến, 
                    mang đến trải nghiệm lái xe đẳng cấp thế giới.
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-600 to-blue-700 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-rocket text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Hiệu suất vượt trội</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Động cơ mạnh mẽ với công nghệ tiên tiến, mang đến hiệu suất vượt trội và trải nghiệm lái xe đầy cảm xúc.
                    </p>
                </div>
                
                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-green-600 to-green-700 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-leaf text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Thân thiện môi trường</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Công nghệ xanh tiên tiến, giảm thiểu khí thải và tiết kiệm nhiên liệu tối ưu cho tương lai bền vững.
                    </p>
                </div>
                
                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-purple-600 to-purple-700 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-shield-alt text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">An toàn tối ưu</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Hệ thống an toàn toàn diện với các công nghệ bảo vệ tiên tiến, đảm bảo an toàn tối đa cho mọi hành trình.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-black text-gray-900 mb-6">Thư viện ảnh</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Khám phá vẻ đẹp chi tiết của {{ $carModel->name }} qua bộ sưu tập ảnh chất lượng cao</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($carModel->images as $image)
                <div class="group relative overflow-hidden rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-700">
                    <img src="{{ $image->image_url }}" alt="{{ $carModel->name }}" 
                         class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-700" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                        <h3 class="text-xl font-bold mb-2">{{ $carModel->name }}</h3>
                        <p class="text-gray-200">Khám phá chi tiết</p>
                    </div>
                </div>
                @endforeach
                
                @if($carModel->images->isEmpty())
                <div class="col-span-full text-center py-20">
                    <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="fas fa-images text-5xl text-gray-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Chưa có ảnh</h3>
                    <p class="text-gray-500 text-lg">Thư viện ảnh sẽ được cập nhật sớm</p>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Car Variants Section -->
    <section id="variants" class="py-24 bg-gradient-to-br from-gray-900 to-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-black text-white mb-6">Các phiên bản</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">Chọn phiên bản phù hợp với nhu cầu và phong cách của bạn</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($variants as $variant)
                <div class="group bg-white rounded-3xl shadow-2xl overflow-hidden hover:shadow-3xl transition-all duration-700 transform hover:-translate-y-4">
                    <div class="relative">
                        <img src="{{ $variant->image_url }}" alt="{{ $variant->name }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700" />
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        @if($variant->is_featured)
                        <div class="absolute top-6 left-6 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 px-4 py-2 rounded-full text-sm font-bold shadow-xl">
                            <i class="fas fa-star mr-2"></i> Nổi bật
                        </div>
                        @endif
                        
                        <!-- Wishlist Button -->
                        <div class="absolute top-6 right-6">
                            <form action="{{ route('wishlist.add') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $variant->product->id }}">
                                <button type="submit" class="bg-white/90 backdrop-blur-sm text-gray-600 hover:text-red-500 p-3 rounded-full shadow-xl transition-all duration-300 hover:scale-110 group-hover:bg-white">
                                    <i class="far fa-heart text-xl"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Quick Specs -->
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                            @php
                                $features = json_decode($variant->features, true);
                            @endphp
                            <div class="grid grid-cols-2 gap-4">
                                @if(isset($features['Quãng đường']))
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-400">{{ $features['Quãng đường'] }}</div>
                                    <div class="text-xs text-gray-300 uppercase tracking-wider">Quãng đường</div>
                                </div>
                                @endif
                                @if(isset($features['Tăng tốc 0-100km/h']))
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-400">{{ $features['Tăng tốc 0-100km/h'] }}</div>
                                    <div class="text-xs text-gray-300 uppercase tracking-wider">Tăng tốc</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <div class="mb-6">
                            <h3 class="text-3xl font-black text-gray-900 mb-3">{{ $variant->name }}</h3>
                            <p class="text-gray-600 leading-relaxed text-lg">{{ $variant->description }}</p>
                        </div>
                        
                        <!-- Key Features -->
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            @if(isset($features['Công suất']))
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-4">
                                <p class="text-sm text-blue-600 font-semibold mb-1 uppercase tracking-wider">Công suất</p>
                                <p class="text-2xl font-black text-gray-900">{{ $features['Công suất'] }}</p>
                            </div>
                            @endif
                            @if(isset($features['Tốc độ tối đa']))
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-4">
                                <p class="text-sm text-green-600 font-semibold mb-1 uppercase tracking-wider">Tốc độ tối đa</p>
                                <p class="text-2xl font-black text-gray-900">{{ $features['Tốc độ tối đa'] }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Price -->
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <span class="text-4xl font-black text-gray-900">{{ number_format($variant->product->price) }} đ</span>
                                <p class="text-sm text-gray-500 font-medium">Giá khởi điểm</p>
                            </div>
                            <div class="w-16 h-1 bg-gradient-to-r from-blue-600 to-blue-700 rounded-full"></div>
                        </div>
                        
                        <!-- CTA Button -->
                        <a href="{{ route('car_variants.show', $variant->id) }}" 
                           class="group/btn block w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-5 rounded-2xl font-bold text-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-500 transform hover:scale-105 shadow-xl">
                            <i class="fas fa-eye mr-3 group-hover/btn:translate-x-1 transition-transform"></i>
                            Khám phá chi tiết
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features & Specifications Section -->
    <section id="specs" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-5xl font-black text-gray-900 mb-6">Thông số kỹ thuật</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Khám phá chi tiết các tính năng và thông số của từng phiên bản</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($variants as $variant)
                <div class="group bg-gradient-to-br from-gray-50 via-white to-gray-50 rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-700 rounded-3xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-500">
                            <i class="fas fa-cog text-3xl text-white"></i>
                        </div>
                        <h3 class="text-3xl font-black text-gray-900 mb-3">{{ $variant->name }}</h3>
                        <div class="w-20 h-1 bg-gradient-to-r from-blue-600 to-blue-700 mx-auto rounded-full"></div>
                    </div>
                    
                    @php
                        $variantFeatures = json_decode($variant->features, true) ?? [];
                    @endphp
                    
                    <div class="space-y-4 mb-8">
                        @foreach($variantFeatures as $key => $value)
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 hover:bg-gray-50 rounded-lg px-3 transition-colors duration-300">
                            <span class="text-gray-700 font-semibold">{{ $key }}</span>
                            <span class="text-gray-900 font-black text-lg">{{ $value }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="text-center mb-8">
                        <div class="text-4xl font-black text-blue-600 mb-2">{{ number_format($variant->product->price ?? 0) }} đ</div>
                        <div class="text-sm text-gray-500 font-medium">Giá khởi điểm</div>
                    </div>
                    
                    <!-- Color Options -->
                    @if($variant->colors->count() > 0)
                    <div class="mb-8">
                        <h4 class="text-xl font-bold text-gray-900 mb-4 text-center">Màu sắc có sẵn</h4>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach($variant->colors as $color)
                            <div class="flex flex-col items-center group/color">
                                <div class="w-16 h-16 rounded-2xl border-4 border-gray-200 shadow-lg overflow-hidden group-hover/color:border-blue-500 transition-colors duration-300">
                                    <img src="{{ $color->image_url }}" alt="{{ $color->color_name }}" class="w-full h-full object-cover" />
                                </div>
                                <span class="mt-3 text-sm text-gray-700 font-medium text-center">{{ $color->color_name }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <a href="{{ route('car_variants.show', $variant->id) }}" 
                       class="group/btn block w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-4 rounded-2xl font-bold text-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-500 transform hover:scale-105 shadow-xl">
                        <i class="fas fa-info-circle mr-3 group-hover/btn:rotate-12 transition-transform"></i>
                        Xem chi tiết
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact & Order Section -->
    <section class="py-24 bg-gradient-to-br from-gray-900 via-gray-800 to-black relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, white 2px, transparent 2px), radial-gradient(circle at 75% 75%, white 2px, transparent 2px); background-size: 50px 50px;"></div>
        </div>
        
        <div class="relative z-10 max-w-5xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-6xl font-black text-white mb-6">Đặt hàng {{ $carModel->name }}</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    Liên hệ với chúng tôi để được tư vấn chuyên nghiệp và đặt hàng phiên bản phù hợp nhất với nhu cầu của bạn
                </p>
            </div>
            
            <div class="bg-white rounded-3xl shadow-3xl p-10">
                <form action="#" class="space-y-8" method="POST" novalidate>
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3" for="fullName">
                                <i class="fas fa-user mr-2 text-blue-600"></i>Họ và tên
                            </label>
                            <input class="w-full rounded-2xl border-2 border-gray-200 px-6 py-4 text-lg focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 group-hover:border-blue-300"
                                id="fullName" name="fullName" placeholder="Nguyễn Văn A" required type="text" />
                        </div>
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3" for="phone">
                                <i class="fas fa-phone mr-2 text-blue-600"></i>Số điện thoại
                            </label>
                            <input class="w-full rounded-2xl border-2 border-gray-200 px-6 py-4 text-lg focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 group-hover:border-blue-300"
                                id="phone" name="phone" placeholder="0123456789" required type="tel" />
                        </div>
                    </div>
                    
                    <div class="group">
                        <label class="block text-sm font-bold text-gray-700 mb-3" for="email">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>Email
                        </label>
                        <input class="w-full rounded-2xl border-2 border-gray-200 px-6 py-4 text-lg focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 group-hover:border-blue-300"
                            id="email" name="email" placeholder="email@example.com" required type="email" />
                    </div>
                    
                    <!-- Vehicle Selection -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3" for="variant">
                                <i class="fas fa-car mr-2 text-blue-600"></i>Chọn phiên bản
                            </label>
                            <select class="w-full rounded-2xl border-2 border-gray-200 px-6 py-4 text-lg focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 group-hover:border-blue-300 appearance-none bg-white"
                                id="variant" name="variant" required>
                                <option value="">-- Chọn phiên bản --</option>
                                @foreach($variants as $variant)
                                <option value="{{ $variant->id }}" data-colors='@json($variant->colors)'>{{ $variant->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <div class="group">
                            <label class="block text-sm font-bold text-gray-700 mb-3" for="color">
                                <i class="fas fa-palette mr-2 text-blue-600"></i>Chọn màu sắc
                            </label>
                            <select class="w-full rounded-2xl border-2 border-gray-200 px-6 py-4 text-lg focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 group-hover:border-blue-300 appearance-none bg-white"
                                id="color" name="color" required>
                                <option value="">-- Chọn màu --</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="group">
                        <label class="block text-sm font-bold text-gray-700 mb-3" for="additionalNotes">
                            <i class="fas fa-comment mr-2 text-blue-600"></i>Ghi chú thêm
                        </label>
                        <textarea class="w-full rounded-2xl border-2 border-gray-200 px-6 py-4 text-lg focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 resize-none group-hover:border-blue-300"
                            id="additionalNotes" name="additionalNotes" placeholder="Yêu cầu đặc biệt hoặc câu hỏi của bạn?" rows="5"></textarea>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="text-center pt-6">
                        <button class="group inline-flex items-center justify-center px-12 py-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-xl rounded-2xl hover:from-blue-700 hover:to-blue-800 transition-all duration-500 transform hover:scale-105 shadow-2xl" type="submit">
                            <i class="fas fa-paper-plane mr-4 group-hover:translate-x-1 transition-transform"></i>
                            Gửi yêu cầu đặt hàng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection