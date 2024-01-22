<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $posts = Post::with('categories','user','group','likes')
                    ->whereHas('group', function ($query) use ($user) {
                        $query->whereIn('id', $user->groups->pluck('id'));
                    })//only display posts from group, that user is in
                    ->latest()
                    ->paginate(4);
        return view('posts.home',compact('posts'));
    }

    public function create($group_id = null)
    {
        $categories = Category::where('status',1)->get();
        $groups = null;

        if ($group_id !== null) {
            $groups = null;
            $group = Group::findOrFail($group_id);
        } 
        else 
        {
            $groups = Group::where('deleted_at', null)->whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })->get();
            $group = null;
        }

        return view('posts.post-create', ['categories' => $categories, 'groups' => $groups, 'group' => $group]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'group_id' => 'required|exists:groups,id'
        ]);
        // dd($request);
        DB::beginTransaction();
        try
        {
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->user_id = Auth::user()->id;
            $post->group_id = $request->group_id;
            $posted = $post->save();
            if(!$posted)
            {
                throw new \Exception('Error Saving Post.');
            }
            $post->categories()->sync($request->input('categories', []));
            DB::commit();
            if ($request->group) 
            {
                return redirect()->route('group.view',$request->group)->with('success', 'Your Post has Uploaded');
            } 
            
            return redirect()->route('home')->with('success', 'Your Post has Uploaded');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Post Upload Failed');
        }
    }

    public function edit(Post $post)
    {
        $this->authorize('isOwner',$post);
        $categories = Category::all();
        return view('posts.post-edit',['post'=>$post,'categories'=>$categories]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('isOwner',$post);
        // dd($request);
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);
        DB::beginTransaction();
        try
        {
            $post->title = $request->title;
            $post->content = $request->content;
            $posted = $post->save();
            if(!$posted)
            {
                throw new \Exception('Error Updating Post.');
            }
            $post->categories()->sync($request->input('categories', []));
            DB::commit();
            return redirect()->route('home')->with('success', 'Your Post has Updated');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Post Update Failed');
        }
    }

    public function destroy(Post $post)
    {
        $this->authorize('isOwnerOrAdmin',$post);
        $deleted = $post->delete();
        if(!$deleted)
        {
            DB::rollBack();
            return redirect()->route('home')->with('error','Cannot Delete this Post');
        }
        else
        {
            return redirect()->route('home')->with('success', 'You had Deleted the Post'); 
        }
    }

    public function detail(Post $post)
    {
        $categories = Category::all();
        $post->load('group','comments.user');
        return view('posts.post-detail',['post'=>$post,'categories'=>$categories]);
    }

    public function groupEdit(Post $post)
    {
        $this->authorize('isOwner',$post);
        $categories = Category::all();
        return view('posts.group-post-edit',['post'=>$post,'categories'=>$categories]);
    }

    public function groupUpdate(Request $request, Post $post)
    {
        $this->authorize('isOwner',$post);
        // dd($request);
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);
        DB::beginTransaction();
        try
        {
            $post->title = $request->title;
            $post->content = $request->content;
            $posted = $post->save();
            if(!$posted)
            {
                throw new \Exception('Error Updating Post.');
            }
            $post->categories()->sync($request->input('categories', []));
            DB::commit();
            return redirect()->route('group.view',$post->group->id)->with('success', 'Your Post has Updated');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Post Update Failed');
        }
    }

    public function groupDelete(Post $post)
    {
        $group_id = $post->group->id;
        $this->authorize('isOwnerOrAdmin',$post);
        $deleted = $post->delete();
        if(!$deleted)
        {
            DB::rollBack();
            return redirect()->route('group.view',$group_id)->with('error','Cannot Delete this Post');
        }
        else
        {
            return redirect()->route('group.view',$group_id)->with('success', 'You had Deleted the Post'); 
        }
    }

    public function groupDetail(Post $post)
    {
        $categories = Category::all();
        $post->load('group','comments.user');
        return view('posts.group-post-detail',['post'=>$post,'categories'=>$categories]);
    }
}
