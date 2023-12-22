<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('category.category-list',['categories'=>$categories]);
    }

    public function create()
    {
        return view('category.category-create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'category' => 'required|unique:categories,category,NULL,NULL,category,' . strtolower($request->category),//case insensitive validation
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error','Adding New Category Failed or Category Tag Already Exists');
            exit();
        }

        //Db Transaction Start
        DB::beginTransaction();
        try
        {
            $category = new Category();
            $category->category = $request->category;
            $category->status = $request->status ? 1 : 0;       //If has value, save 1
            $category->created_at = now();
            $category->updated_at = now();
            $saved = $category->save();
            if(!$saved)
            {
                throw new \Exception('Error Saving Category Tag.');
            }
            DB::commit();
            return redirect()->route('category')->with('success', 'You have Added New Category Tag');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Cannot Add New Category Tag');
        }
    }

    public function edit(Category $category)
    {
        return view('category.category-edit',['category'=>$category]);
    }

    public function update(Request $request, Category $category)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'category' => 'required|unique:categories,category,' . $category->id . ',id,category,' . strtolower($request->category),
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error','Adding New Category Failed or Category Already Exists');
            exit();
        }
        
        //Update DB transaction
        DB::beginTransaction();
        try
        {
            $category->category = $request->category;
            $category->status = $request->status ? 1 : 0;       //If has value, save 1
            $category->updated_at = now();
            $updated = $category->save();
            if(!$updated)
            {
                throw new \Exception('Error Updating Category.');
            }
            DB::commit();
            return redirect()->route('category')->with('success', 'Category has Updated');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Category Update Failed');
        }
    }

    public function destroy(Category $category)
    {
        // dd($category);
        $deleted = $category->delete();
        if(!$deleted)
        {
            DB::rollBack();
            return redirect()->route('category')->with('error','Cannot Delete this Category Tag');
        }
        else
        {
            return redirect()->route('category')->with('success', 'You had Removed the Category Tag'); 
        }
    }

    public function archives()
    {
        $categories = Category::onlyTrashed()->get();
        return view('category.category-archives',['categories'=>$categories]);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->find($id);
        $category->restore();
        return redirect()->route('category')->with('success', 'You had Restored the Category Tag'); 
    }

    public function forcedelete($id)
    {
        $category = Category::withTrashed()->find($id);
        $category->forceDelete();
        return redirect()->route('category')->with('success', 'Deleted'); 
    }
}
