<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Post;
use Nette\Schema\ValidationException;

class AdminController extends Controller {

    public function validationPost (Request $request) {
        $validated = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'comment' => ['required', 'string']
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => $validated->errors()
            ]);
        }
    }

    public function showPost (Request $request) {

        $user = User::find(auth()->id());
        $posts = $user->posts;
        return response()->json([
            'post' => $posts
        ]);
    }

    public function addPost(Request $request)
    {
           $this->validationPost($request);

            Post::create([
                'title' => $request->title,
                'comment' => $request->comment,
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'message' => 'Post created'
            ]);
        }

    public function deletePost(Request $request)
    {
        $post = Post::find($request->id);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted'
        ]);
    }
    public function editPost(Request $request)
    {
        $this->validationPost($request);

        $post = Post::find($request->id);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        $post->update([
            'title' => $request->title,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Post updated'
        ]);
    }

}

