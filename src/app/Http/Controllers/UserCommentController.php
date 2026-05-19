<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserCommentController extends Controller
{
    public function comment(Request $request)
    {

        $validated = $request->validate(['product_comment' => 'required', 'like' => 'int|required']);

        $comment = $request->get('product_comment');
        $product_id = $request->get('product_id');

        $user = Auth::user();
        if ($user != null) {

            DB::table('user_comments')->updateOrInsert(
                ['product_id' => $product_id, 'user_id' => $user->id],
                [
                    'product_comment' => $comment,
                    'rating' => $validated['like']
                ],
            );
            return redirect('/store');
        } else {
            return redirect('/home');
        }
    }
}
