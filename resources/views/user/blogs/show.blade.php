@extends('layouts.app')
@section('content')
<div class="container py-10 max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('blogs.index') }}" class="text-indigo-600 hover:underline flex items-center mb-2"><i class="fas fa-arrow-left mr-2"></i>Quay lại danh sách</a>
        <h1 class="text-3xl font-bold mb-2">{{ $blog->title }}</h1>
        <div class="flex items-center text-xs text-gray-500 mb-4">
            <i class="fas fa-user mr-1"></i> Admin
            <span class="mx-2">•</span>
            <i class="fas fa-calendar-alt mr-1"></i> {{ $blog->created_at ? $blog->created_at->format('d/m/Y') : 'N/A' }}
        </div>
        <img src="{{ Str::startsWith($blog->image_path, ['http://', 'https://']) ? $blog->image_path : ($blog->image_path ? asset('storage/' . $blog->image_path) : asset('images/default-blog.jpg')) }}" class="w-full h-72 object-cover rounded-xl mb-6" alt="{{ $blog->title }}">
        <div class="prose max-w-none text-gray-800">{!! nl2br(e($blog->content)) !!}</div>
    </div>
    @if($related->count())
    <div class="mt-10">
        <h2 class="text-xl font-semibold mb-4">Bài viết liên quan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($related as $item)
                <a href="{{ route('blogs.show', $item->slug) }}" class="block bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                    <div class="font-bold text-gray-800 mb-1 line-clamp-1">{{ $item->title }}</div>
                    <div class="text-xs text-gray-500 mb-2">{{ $item->created_at->format('d/m/Y') }}</div>
                    <div class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($item->content, 60) }}</div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
