<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('categories')->latest()->paginate(4);

        return view('home',compact('posts'));
    }

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
        try
        {
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->user_id = Auth::user()->id;
            $posted = $post->save();
            if(!$posted)
            {
                throw new \Exception('Error Saving Post.');
            }
            $post->categories()->sync($request->input('categories', []));
            DB::commit();
            return redirect()->route('home')->with('success', 'Your Post has Uploaded');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Post Upload Failed');
        }
    }
}
