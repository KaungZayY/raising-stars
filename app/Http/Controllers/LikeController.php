<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function postLiked(Request $request)
    {
        try{
            DB::beginTransaction();
            $like = new Like();
            $like->post_id = $request->post_id;
            $like->user_id = Auth::user()->id;
            $liked = $like->save();

            if(!$liked){
                DB::rollBack();
                return response()->json(['error' => 'You have already Liked this Post']);
            }

            DB::commit();
            return response()->json(['message' => 'success']);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
    }

    //Unlike Post Machenic
    public function postUnLiked(Request $request)
    {
        // dd($request);
        try 
        {
            Like::where('user_id', Auth::user()->id)
                ->where('post_id', $request->post_id)
                ->delete();
    
            return response()->json(['message' => 'Remove success']);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
