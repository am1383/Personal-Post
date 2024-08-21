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
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        }

        $user = User::find(auth()->id());
        $posts = $user->posts;
        return response()->json([
            'post' => $posts
        ]);
    }

    public function addPost(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        }
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
    }

