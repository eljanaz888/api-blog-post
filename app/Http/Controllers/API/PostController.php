<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function createPost(Request $request)
    {
        // Validate the request data
        try {
            $request->validate([
                'content' => 'required|string|max:500',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error', 'error' => $e->getMessage(),
            ], 404);
        }

        try {
            // Create a new post for the authenticated user
            $post = $request->user()->posts()->create([
                'content' => $request->content,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error', 'error' => $e->getMessage(),
            ], 404);
        }

        // Return a 201 response with the created post object
        return response()->json([
            'post' => $post,
        ], 201);
    }

    public function deletePost(Request $request)
    {
        try {
            $user = $request->user();
            $post = Post::find($request->post_id);
            if (!$post) {
                return response()->json([
                    'message' => 'Post not found',
                ], 404);
            }
            if (Gate::allows('delete-post', $post)) {
                $post->delete();
                return response()->json([
                    'message' => 'Post deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'You are not authorized to delete this post',
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error', 'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function updatePost(Request $request)
    {
        try {
            $user = User::find($request->user()->id);
            $post = $user->posts()->find($request->post_id);

            if (!$post) {
                return response()->json([
                    'message' => 'Post not found',
                ], 404);
            }
            if (!Gate::allows('update-post', $post)) {
                return response()->json([
                    'message' => 'You are not authorized to update this post',
                ], 403);
            }

            $post->update([
                'content' => $request->content,
            ]);

            return response()->json([
                'message' => 'Post updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error', 'error' => $e->getMessage(),
            ], 404);
        }
    }
}
