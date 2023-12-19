<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function postCommented(Request $request)
    {
        $request->validate([
            'comment'=>'required|min:1'
        ]);
        DB::beginTransaction();
        try
        {
            $comment = new Comment();
            $comment->post_id = $request->post_id;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;
            $commented = $comment->save();
            if(!$commented){
                DB::rollBack();
                return response()->json(['error' => 'Cannot Comment']);
            }

            DB::commit();
            return response()->json(['message' => 'success']);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
