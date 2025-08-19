@extends('layouts.app')
@section('content')
<div class="container py-10">
    <h1 class="text-3xl font-bold mb-6 text-center">Tin tức & Blog</h1>
    <div class="flex justify-center">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl w-full">
            @foreach($blogs as $blog)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                    <a href="{{ route('blogs.show', $blog->slug) }}">
                        <img src="{{ Str::startsWith($blog->image_path, ['http://', 'https://']) ? $blog->image_path : ($blog->image_path ? asset('storage/' . $blog->image_path) : asset('images/default-blog.jpg')) }}" class="w-full h-48 object-cover" alt="{{ $blog->title }}">
                    </a>
                    <div class="p-5">
                        <div class="flex items-center text-xs text-gray-500 mb-2">
                            <i class="fas fa-user mr-1"></i> Admin
                            <span class="mx-2">•</span>
                            <i class="fas fa-calendar-alt mr-1"></i> {{ $blog->created_at ? $blog->created_at->format('d/m/Y') : 'N/A' }}
                        </div>
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="block font-bold text-lg text-gray-800 hover:text-indigo-600 mb-2 line-clamp-2">{{ $blog->title }}</a>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($blog->content, 120) }}</p>
                        <a href="{{ route('blogs.show', $blog->slug) }}" class="text-indigo-600 font-semibold hover:underline">Đọc thêm &rarr;</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-10 flex justify-center">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
