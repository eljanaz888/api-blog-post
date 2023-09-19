<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Reply;

class ReplyController extends Controller
{
    //function to create a reply

    public function createReply(Request $request)
    {
        // Validate the request data
        try {
            $request->validate([
                'content' => 'required|string|max:500'

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error', 'error' => $e->getMessage(),
            ], 404);
        }

        try {
            // Create a new reply for the authenticated user
            $reply = $request->user()->replies()->create([
                'content' => $request->content,
                'post_id' => $request->post_id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error', 'error' => $e->getMessage(),
            ], 404);
        }

        // Return a 201 response with the created reply object
        return response()->json([
            'reply' => $reply,
        ], 201);
    }

    //function to delete a reply

    public function deleteReply(Request $request)
    {
        try {
            $user = $request->user();
            $reply = Reply::find($request->reply_id);
            if (!$reply) {
                return response()->json([
                    'message' => 'Reply not found',
                ], 404);
            }
            if (Gate::allows('delete-reply', $reply)) {
                $reply->delete();
                return response()->json([
                    'message' => 'Reply deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'You are not authorized to delete this reply',
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error', 'error' => $e->getMessage(),
            ], 404);
        }
    }
}
