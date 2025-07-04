@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- ===== Hero Banner ===== --}}
<section class="relative h-screen bg-gradient-to-br from-indigo-900 via-purple-900 to-indigo-800 flex items-center justify-center text-white overflow-hidden">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/20 to-purple-600/20"></div>
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-20 left-20 w-72 h-72 bg-indigo-500/30 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-purple-500/30 rounded-full blur-3xl"></div>
        </div>
    </div>
    <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
        <h1 class="text-5xl md:text-7xl font-extrabold mb-6 drop-shadow-lg animate-fade-in-up">
            <span class="bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">
                Showroom Xe Hơi
            </span>
        </h1>
        <p class="text-xl md:text-2xl font-medium mb-8 drop-shadow max-w-2xl mx-auto leading-relaxed">
            Khám phá bộ sưu tập xe hơi cao cấp và phụ kiện chất lượng. Trải nghiệm dịch vụ tốt nhất.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#featured" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-full font-semibold transition duration-300 transform hover:scale-105">
                <i class="fas fa-car mr-2"></i>Khám phá xe
            </a>
            <a href="#accessories" class="bg-white/20 hover:bg-white/30 text-white px-8 py-4 rounded-full font-semibold transition duration-300 backdrop-blur-sm">
                <i class="fas fa-tools mr-2"></i>Phụ kiện
            </a>
        </div>
    </div>
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <i class="fas fa-chevron-down text-2xl text-white/70"></i>
    </div>
</section>

{{-- ===== Car Brands Section ===== --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Hãng xe đối tác</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Chúng tôi hợp tác với các hãng xe hàng đầu thế giới để mang đến những sản phẩm chất lượng nhất</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-8">
            @foreach ($cars as $car)
            <div class="cursor-pointer group car-brand-logo" data-car-id="{{ $car->id }}">
                <div class="bg-gray-50 rounded-2xl p-6 hover:bg-indigo-50 transition duration-300 group-hover:shadow-lg">
                    <img src="{{ $car->logo_path }}"
                        class="w-20 h-20 object-contain mx-auto mb-4 transition-transform group-hover:scale-110"
                        alt="{{ $car->name }}">
                    <p class="text-gray-800 font-semibold text-center">{{ $car->name }}</p>
                </div>
            </div>
            @endforeach
        </div>

        @foreach ($cars as $car)
        @if($car->carModels->count())
        <div id="models-{{ $car->id }}" class="mt-12 hidden">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-8">
                <h3 class="text-3xl font-bold mb-6 text-center text-gray-900">{{ $car->name }} - Dòng xe</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($car->carModels as $model)
                    <a href="{{ route('car_models.show', $model->id) }}"
                        class="block bg-white rounded-xl p-4 hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                        <img src="{{ $model->image_url }}" class="w-full h-32 object-cover rounded-lg mb-3"
                            alt="{{ $model->name }}">
                        <h4 class="text-center font-semibold text-gray-800">{{ $model->name }}</h4>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</section>

{{-- ===== Featured Variants Section ===== --}}
<section id="featured" class="py-20 bg-gradient-to-br from-gray-50 to-indigo-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                <i class="fas fa-star text-yellow-500 mr-3"></i>Sản phẩm nổi bật
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Những mẫu xe được yêu thích nhất với thiết kế hiện đại và công nghệ tiên tiến</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($featuredVariants as $variant)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 group relative transform hover:-translate-y-2">
                @if($variant->product)
                <div class="absolute top-4 right-4 z-10">
                    @php
                        $isInWishlist = \App\Helpers\WishlistHelper::isInWishlist($variant->product->id);
                    @endphp
                    <button class="bg-white/90 backdrop-blur-sm p-3 rounded-full hover:bg-red-500 hover:text-white transition duration-300 shadow-lg wishlist-btn"
                            data-product-id="{{ $variant->product->id }}">
                        <i class="{{ $isInWishlist ? 'fas fa-heart text-red-500' : 'far fa-heart' }} text-lg"></i>
                    </button>
                </div>
                @endif
                                        <a href="{{ route('car_variants.show', $variant->id) }}" class="block hover:no-underline text-gray-800">
                    <div class="relative overflow-hidden">
                        <img src="{{ $variant->image_url }}"
                            class="w-full h-56 object-cover group-hover:scale-110 transition duration-500"
                            alt="{{ $variant->name }}" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-indigo-600 transition">{{ $variant->name }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2 text-sm leading-relaxed">{{ $variant->description }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-indigo-600">{{ $variant->product ? number_format($variant->product->price) : '0' }} đ</span>
                            <div class="flex items-center text-yellow-500">
                                <i class="fas fa-star text-sm"></i>
                                <span class="text-sm text-gray-600 ml-1">4.8</span>
                            </div>
                        </div>
                    </div>
                </a>
                @if($variant->product)
                <div class="px-6 pb-6">
                    <form method="POST" action="{{ route('cart.add') }}" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $variant->product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-300 flex items-center justify-center gap-2 shadow-lg">
                            <i class="fas fa-cart-plus"></i>
                            Thêm vào giỏ hàng
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== Accessories Section ===== --}}
<section id="accessories" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                <i class="fas fa-tools text-indigo-600 mr-3"></i>Phụ kiện xe hơi
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Phụ kiện chất lượng cao, thiết kế hiện đại cho xe của bạn</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($accessories as $item)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 group relative transform hover:-translate-y-2">
                    @if($item->product)
                    <div class="absolute top-4 right-4 z-10">
                        @php
                            $isInWishlist = \App\Helpers\WishlistHelper::isInWishlist($item->product->id);
                        @endphp
                        <button class="bg-white/90 backdrop-blur-sm p-3 rounded-full hover:bg-red-500 hover:text-white transition duration-300 shadow-lg wishlist-btn"
                                data-product-id="{{ $item->product->id }}">
                            <i class="{{ $isInWishlist ? 'fas fa-heart text-red-500' : 'far fa-heart' }} text-lg"></i>
                        </button>
                    </div>
                    @endif
                    <a href="{{ route('accessories.show', $item->id) }}" class="block hover:no-underline text-gray-800">
                        <div class="relative overflow-hidden">
                            <img src="{{ $item->product->image_url }}" 
                                 class="w-full h-56 object-cover group-hover:scale-110 transition duration-500" 
                                 alt="{{ $item->name }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-xl text-gray-800 mb-3 group-hover:text-indigo-600 transition">{{ $item->name }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-2 text-sm leading-relaxed">{{ $item->description }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-indigo-600">{{ $item->product ? number_format($item->product->price) : '0' }} đ</span>
                                <div class="flex items-center text-yellow-500">
                                    <i class="fas fa-star text-sm"></i>
                                    <span class="text-sm text-gray-600 ml-1">4.7</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @if($item->product)
                    <div class="px-6 pb-6">
                        <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-300 flex items-center justify-center gap-2 shadow-lg">
                                <i class="fas fa-cart-plus"></i>
                                Thêm vào giỏ hàng
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== Customer Reviews Section ===== --}}
<section class="py-20 bg-gradient-to-br from-indigo-50 to-purple-50">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Khách hàng nói gì?</h2>
        <p class="text-lg text-gray-600 mb-12 max-w-2xl mx-auto">Những đánh giá chân thực từ khách hàng đã sử dụng dịch vụ của chúng tôi</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">NV</span>
                </div>
                <div class="flex justify-center mb-4">
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                </div>
                <p class="text-gray-700 italic mb-6 leading-relaxed">"Xe đẹp, chất lượng cao và dịch vụ rất tốt! Nhân viên tư vấn rất nhiệt tình và chuyên nghiệp."</p>
                <div class="font-bold text-indigo-700">Nguyễn Văn An</div>
                <div class="text-sm text-gray-500">Khách hàng VIP</div>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-red-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">TT</span>
                </div>
                <div class="flex justify-center mb-4">
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                </div>
                <p class="text-gray-700 italic mb-6 leading-relaxed">"Lần đầu mua xe mà cảm thấy hài lòng đến vậy. Quy trình mua bán rất minh bạch và nhanh chóng."</p>
                <div class="font-bold text-indigo-700">Trần Thị Bình</div>
                <div class="text-sm text-gray-500">Doanh nhân</div>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-teal-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">LH</span>
                </div>
                <div class="flex justify-center mb-4">
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                    <i class="fas fa-star text-yellow-500"></i>
                </div>
                <p class="text-gray-700 italic mb-6 leading-relaxed">"Tôi sẽ giới thiệu showroom này cho bạn bè! Dịch vụ hậu mãi rất tốt và chăm sóc khách hàng chu đáo."</p>
                <div class="font-bold text-indigo-700">Lê Hoàng Cường</div>
                <div class="text-sm text-gray-500">Kỹ sư</div>
            </div>
        </div>
    </div>
</section>

{{-- ===== About Section ===== --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-6">Hành trình của chúng tôi</h2>
                <p class="text-lg text-gray-600 leading-relaxed mb-6">
                    Showroom của chúng tôi được thành lập với sứ mệnh mang đến những chiếc xe tuyệt vời nhất đến tay người dùng. 
                    Với đội ngũ chuyên nghiệp, tận tâm và đam mê công nghệ, chúng tôi không ngừng cải tiến để phục vụ bạn tốt hơn.
                </p>
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center p-4 bg-indigo-50 rounded-xl">
                        <div class="text-3xl font-bold text-indigo-600 mb-2">500+</div>
                        <div class="text-gray-600">Khách hàng hài lòng</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-xl">
                        <div class="text-3xl font-bold text-purple-600 mb-2">50+</div>
                        <div class="text-gray-600">Mẫu xe đa dạng</div>
                    </div>
                </div>
                <a href="#" class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-300">
                    Tìm hiểu thêm
                </a>
            </div>
            <div class="relative">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-4">Tại sao chọn chúng tôi?</h3>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-300"></i>
                            <span>Chất lượng xe được kiểm định nghiêm ngặt</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-300"></i>
                            <span>Dịch vụ hậu mãi 24/7</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-300"></i>
                            <span>Giá cả cạnh tranh nhất thị trường</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-300"></i>
                            <span>Đội ngũ tư vấn chuyên nghiệp</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== Blog Section ===== --}}
<section class="py-20 bg-gradient-to-br from-gray-50 to-indigo-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                <i class="fas fa-newspaper text-indigo-600 mr-3"></i>Tin tức & Blog
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Cập nhật những tin tức mới nhất về xe hơi, công nghệ và xu hướng thị trường</p>
        </div>
        
        @if($blogs->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @foreach ($blogs as $blog)
            <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2 group">
                <div class="relative overflow-hidden">
                    <img src="{{ $blog->image_path ? asset('storage/' . $blog->image_path) : asset('images/default-blog.jpg') }}"
                        class="w-full h-56 object-cover group-hover:scale-110 transition duration-500" 
                        alt="{{ $blog->title }}" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-tag mr-1"></i>Tin tức
                        </span>
                    </div>
                    <div class="absolute bottom-4 left-4 text-white opacity-0 group-hover:opacity-100 transition duration-300">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>{{ $blog->created_at ? $blog->created_at->format('d/m/Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white text-xs"></i>
                        </div>
                        <span class="text-sm text-gray-500">Admin</span>
                        <span class="mx-2 text-gray-300">•</span>
                        <span class="text-sm text-gray-500">{{ $blog->created_at ? $blog->created_at->diffForHumans() : 'N/A' }}</span>
                    </div>
                    
                    <h3 class="font-bold text-xl mb-3 line-clamp-2 text-gray-800 group-hover:text-indigo-600 transition duration-300">
                        {{ $blog->title }}
                    </h3>
                    
                    <p class="text-gray-600 mb-4 line-clamp-3 text-sm leading-relaxed">
                        {{ Str::limit($blog->content, 150) }}
                    </p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-gray-500 text-sm">
                            <i class="fas fa-eye mr-1"></i>
                            <span>1.2k lượt xem</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-comment mr-1"></i>
                            <span>5 bình luận</span>
                        </div>
                        <a href="#" class="inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-700 transition duration-300 group-hover:scale-105">
                            Đọc thêm
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition duration-300"></i>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-newspaper mr-2"></i>
                Xem tất cả tin tức
            </a>
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-6 flex items-center justify-center">
                <i class="fas fa-newspaper text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có tin tức nào</h3>
            <p class="text-gray-500">Chúng tôi sẽ cập nhật tin tức mới nhất sớm nhất có thể!</p>
        </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
    @keyframes fadeInBottom {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInBottom 1s ease-out forwards;
        animation-delay: 0.5s;
        opacity: 0;
    }

    .animate-slide-in-up {
        animation: slideInUp 1s ease-out forwards;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Toggle models
    function toggleModels(id) {
        document.querySelectorAll('[id^="models-"]').forEach(el => el.classList.add('hidden'));
        document.getElementById('models-' + id).classList.remove('hidden');
    }

    // Function to initialize page functionality
    function initializePage() {
        // Initialize car brand logos
        document.querySelectorAll('.car-brand-logo').forEach(function(el) {
            // Remove existing listeners to prevent duplicates
            el.removeEventListener('click', handleCarBrandClick);
            el.addEventListener('click', handleCarBrandClick);
        });

        // Initialize smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            // Remove existing listeners to prevent duplicates
            anchor.removeEventListener('click', handleSmoothScroll);
            anchor.addEventListener('click', handleSmoothScroll);
        });

        // Initialize wishlist buttons
        initializeWishlistButtons();

        // Ensure wishlist count is up to date
        updateWishlistCountFromServer();
    }

    // Event handlers
    function handleCarBrandClick() {
        toggleModels(this.getAttribute('data-car-id'));
    }

    function handleSmoothScroll(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', initializePage);

    // Initialize on page show (for browser navigation)
    window.addEventListener('pageshow', initializePage);

    // Initialize on turbolinks load (if using turbolinks)
    if (typeof Turbolinks !== 'undefined') {
        document.addEventListener('turbolinks:load', initializePage);
    }

    // Additional navigation handling
    window.addEventListener('focus', function() {
        // Re-initialize when window gains focus (user returns to tab)
        setTimeout(initializePage, 100);
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        setTimeout(initializePage, 100);
    });

    // Handle tab visibility change
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            // User returned to the tab
            setTimeout(initializePage, 100);
        }
    });

    // Wishlist functionality
    function toggleWishlist(productId) {
        const button = $(`[data-product-id="${productId}"]`);
        const icon = button.find('i');
        const isInWishlist = icon.hasClass('fas');

        if (isInWishlist) {
            // Remove from wishlist
            removeFromWishlist(productId, button);
        } else {
            // Add to wishlist
            addToWishlist(productId, button);
        }
    }

    function addToWishlist(productId, button) {
        $.ajax({
            url: '{{ route("wishlist.add") }}',
            method: 'POST',
            data: {
                product_id: productId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    const icon = button.find('i');
                    icon.removeClass('far').addClass('fas fa-heart text-red-500 text-lg');
                    updateWishlistCount(response.wishlist_count);
                    showMessage(response.message, 'success');
                }
            },
            error: function() {
                showMessage('Có lỗi xảy ra khi thêm vào yêu thích', 'error');
            }
        });
    }

    function removeFromWishlist(productId, button) {
        $.ajax({
            url: '{{ route("wishlist.remove") }}',
            method: 'POST',
            data: {
                product_id: productId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    const icon = button.find('i');
                    icon.removeClass('fas text-red-500').addClass('far fa-heart text-lg');
                    updateWishlistCount(response.wishlist_count);
                    showMessage(response.message, 'success');
                }
            },
            error: function() {
                showMessage('Có lỗi xảy ra khi xóa khỏi yêu thích', 'error');
            }
        });
    }

    // Use the global updateWishlistCount function from layout
    // No need to redefine it here

    function updateWishlistCountFromServer() {
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
    }

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

    function initializeWishlistButtons() {
        // Use event delegation instead of direct listeners
        // This ensures buttons work even if added dynamically
        $(document).off('click', '.wishlist-btn').on('click', '.wishlist-btn', function(e) {
            e.preventDefault();
            const productId = $(this).data('product-id');
            toggleWishlist(productId);
        });
    }
</script>
@endpush