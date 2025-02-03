<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PostController extends Controller
{
    
    public function index()
{
    $posts = Post::paginate(10);
    
    foreach ($posts as $post) {
        $post->created_at = Carbon::parse($post->created_at)->format('d M Y');
    }

    return view('posts.index', compact('posts'));
}

    
    public function create()
    {
        return view('posts.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|unique:posts',
            'description' => 'required|min:10',
        ]);

        Post::create($request->all());

        return redirect()->route('posts.index')->with('success', 'تمت إضافة التدوينة بنجاح');
    }

    
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }


    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|min:3|unique:posts,title,' . $post->id,
            'description' => 'required|min:10',
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index')->with('success', 'تم تعديل التدوينة بنجاح');
    }

    
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'تم حذف التدوينة بنجاح');
    }
}