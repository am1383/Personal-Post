<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Rules\CheckOldPassword;
use App\Rules\CheckSamePassword;

class AdminController extends Controller
{
    /**
     * Validate post data.
     */
    public function validationPost(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'comment' => ['required', 'string']
        ]);
    }

    /**
     * Validate password data.
     */
    public function validationPassword(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', new CheckOldPassword()],
            'newPassword' => ['required', 'string', 'min:8', new CheckSamePassword()]
        ]);
    }

    /**
     * Show posts of the authenticated user.
     */
    public function showPost(Request $request)
    {
        $user = User::find(auth()->id());
        $posts = $user->posts;

        return response()->json([
            'posts' => $posts
        ]);
    }

    /**
     * Add a new post.
     */
    public function addPost(Request $request)
    {
        $this->validationPost($request);

        Post::create([
            'title' => $request->title,
            'comment' => $request->comment,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Post created successfully'
        ]);
    }

    /**
     * Delete a post by ID.
     */
    public function deletePost(Request $request)
    {
        $post = Post::find($request->id);
        $this->authorize('delete', $post);
        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }

    /**
     * Edit an existing post.
     */
    public function editPost(Request $request)
    {
        $this->validationPost($request);
        $post = Post::find($request->id);
        $this->authorize('update', $post);

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
            'message' => 'Post updated successfully'
        ]);
    }

    /**
     * Update the user's password.
     */
    public function editPassword(Request $request)
    {
        $this->validationPassword($request);

        auth()->user()->update([
            'password' => bcrypt($request->newPassword)  // Fixed typo
        ]);

        return response()->json([
            'message' => 'Password updated successfully'
        ]);
    }
}
