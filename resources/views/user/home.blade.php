@extends('layouts.app')

@section('title', 'Home')

@section('content')

    {{-- ===== Banner ===== --}}
    <section class="relative h-screen bg-black flex items-center justify-center text-white overflow-hidden">
        <img src="https://digitalassets.tesla.com/tesla-contents/image/upload/f_auto,q_auto/Homepage-Promotional-Carousel-Model-3-Desktop-US.png"
            class="absolute inset-0 w-full h-full object-cover opacity-70" />
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
        <div class="relative z-10 text-center px-6 animate-fade-in-up">
            <h1 class="text-6xl font-extrabold mb-4 drop-shadow-lg">Model S</h1>
            <p class="text-xl font-medium mb-8 drop-shadow">Tốc độ tối thượng. Tính an toàn vô song.</p>
        </div>
    </section>

    {{-- ===== Car Brands (Logo + Name) ===== --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-12">Hãng xe</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-8 text-center">
                @foreach ($cars as $car)
                    <div class="cursor-pointer group" onclick="toggleModels({{ $car->id }})">
                        <img src="{{ $car->logo_url }}"
                            class="w-24 h-24 object-contain mx-auto mb-2 transition-transform group-hover:scale-110"
                            alt="{{ $car->name }}">
                        <p class="text-gray-800 font-semibold">{{ $car->name }}</p>
                    </div>
                @endforeach
            </div>

            @foreach ($cars as $car)
                @if($car->carModels->count())
                    <div id="models-{{ $car->id }}" class="mt-10 hidden">
                        <h3 class="text-2xl font-bold mb-4">{{ $car->name }} - Dòng xe</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            @foreach ($car->carModels as $model)
                                <a href="{{ route('car_models.show', $model->id) }}"
                                    class="block border p-4 rounded-xl hover:shadow transition">
                                    <img src="{{ $model->image_url }}" class="w-full h-28 object-cover rounded mb-2"
                                        alt="{{ $model->name }}">
                                    <h4 class="text-center font-medium text-gray-800">{{ $model->name }}</h4>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    {{-- ===== Featured Variants with Wishlist ===== --}}
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-12">Sản phẩm nổi bật</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($featuredVariants as $variant)
                <div class="bg-white border rounded-xl overflow-hidden hover:shadow-lg transition group relative">
                    
                    {{-- Wishlist icon --}}
                    <div class="absolute top-3 right-3 z-10">
                        <form method="POST" action="{{ route('wishlist.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $variant->product_id }}">
                            <button class="text-red-500 text-xl hover:scale-110 transition">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Link toàn card trừ nút --}}
                    <a href="{{ route('car_variants.show', $variant->id) }}" class="block hover:no-underline text-gray-800">
                        <img src="{{ $variant->main_image_url }}"
                            class="w-full h-48 object-cover group-hover:scale-105 transition duration-300"
                            alt="{{ $variant->name }}" />
                        <div class="p-4">
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $variant->name }}</h3>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-3">{{ $variant->description }}</p>
                            <span class="text-red-600 font-bold block">{{ number_format($variant->product->price) }} đ</span>
                        </div>
                    </a>

                    {{-- Add to cart --}}
                    <div class="px-4 pb-4">
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $variant->product_id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button
                                class="w-full bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700 transition">
                                <i class="fas fa-cart-plus mr-1"></i> Thêm vào giỏ
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</section>

    {{-- ===== Accessories ===== --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-12">Phụ kiện</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($accessories as $item)
                    <div class="border p-4 rounded-xl text-center hover:shadow-md transition bg-white relative">
                        <img src="{{ $item->product->image_url }}" class="h-32 mx-auto object-contain mb-3"
                            alt="{{ $item->product->name }}">
                        <h3 class="font-medium text-gray-800 line-clamp-2">{{ $item->product->name }}</h3>
                        <p class="text-red-600 font-bold mt-2">{{ number_format($item->product->price) }} đ</p>
                        <form method="POST" action="{{ route('cart.add') }}" class="absolute top-4 right-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button class="bg-indigo-600 text-white px-2 py-1 rounded-full text-sm hover:bg-indigo-700">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== Customer Comments with Avatar and Equal Height ===== --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-12">Khách hàng nói gì?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-xl shadow flex flex-col justify-between min-h-[220px]">
                    <img src="/images/customer1.jpg" class="w-16 h-16 rounded-full mx-auto mb-4" alt="Nguyễn Văn A">
                    <p class="text-gray-700 italic mb-4">"Xe đẹp, chất lượng cao và dịch vụ rất tốt!"</p>
                    <div class="font-semibold text-indigo-700">Nguyễn Văn A</div>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow flex flex-col justify-between min-h-[220px]">
                    <img src="/images/customer2.jpg" class="w-16 h-16 rounded-full mx-auto mb-4" alt="Trần Thị B">
                    <p class="text-gray-700 italic mb-4">"Lần đầu mua xe mà cảm thấy hài lòng đến vậy."</p>
                    <div class="font-semibold text-indigo-700">Trần Thị B</div>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl shadow flex flex-col justify-between min-h-[220px]">
                    <img src="/images/customer3.jpg" class="w-16 h-16 rounded-full mx-auto mb-4" alt="Lê Hoàng C">
                    <p class="text-gray-700 italic mb-4">"Tôi sẽ giới thiệu showroom này cho bạn bè!"</p>
                    <div class="font-semibold text-indigo-700">Lê Hoàng C</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Story Section with Slide-in Text ===== --}}
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-6 text-center animate-slide-in-up">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-6">Hành trình của chúng tôi</h2>
            <p class="max-w-3xl mx-auto text-gray-700 leading-relaxed text-lg">
                Showroom của chúng tôi được thành lập với sứ mệnh mang đến những chiếc xe tuyệt vời nhất đến tay người dùng.
                Với đội ngũ chuyên nghiệp, tận tâm và đam mê công nghệ, chúng tôi không ngừng cải tiến để phục vụ bạn tốt
                hơn.
            </p>
        </div>
    </section>

    {{-- ===== Blogs ===== --}}
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-extrabold text-center text-gray-900 mb-12">Tin tức & Blog</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($blogs as $blog)
                    <a href="#" class="block bg-white border rounded-xl overflow-hidden hover:shadow-lg transition">
                        <img src="{{ $blog->image_path ? asset('storage/' . $blog->image_path) : asset('images/default-blog.jpg') }}"
                            class="w-full h-52 object-cover" />
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $blog->title }}</h3>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-3">{{ Str::limit($blog->content, 120) }}</p>
                            <span class="text-indigo-700 font-semibold">Đọc thêm &rarr;</span>
                        </div>
                    </a>
                @endforeach
            </div>
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
    </style>
@endpush

@push('scripts')
    <script>
        function toggleModels(id) {
            document.querySelectorAll('[id^="models-"]').forEach(el => el.classList.add('hidden'));
            document.getElementById('models-' + id).classList.remove('hidden');
        }
    </script>
@endpush