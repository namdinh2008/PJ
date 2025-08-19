<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Danh sách blog, có phân trang
    public function index()
    {
        $blogs = Blog::orderByDesc('created_at')->paginate(6);
        return view('user.blogs.index', compact('blogs'));
    }

    // Chi tiết blog
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        // Gợi ý: lấy thêm các bài liên quan
        $related = Blog::where('id', '!=', $blog->id)->latest()->take(3)->get();
        return view('user.blogs.show', compact('blog', 'related'));
    }
}
