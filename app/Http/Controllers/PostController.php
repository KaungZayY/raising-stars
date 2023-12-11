<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function create()
    {
        $categories = Category::all();

        return view('post-create', ['categories' => $categories]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);
        // dd($request);
        DB::beginTransaction();
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->save();
        $post->categories()->sync($request->input('categories', []));
        DB::commit();
        
        return redirect()->back();
    }
}
