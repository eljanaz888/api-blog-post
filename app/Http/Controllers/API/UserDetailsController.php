<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserDetailsController extends Controller
{
    //add user details

    public function addUserDetails(Request $request)
    {
        // Validate the request data
        try {
            $request->validate([
                'street_address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'postal_code' => 'required|integer|max:255',
                'country' => 'required|string|max:255',
                'phone_number' => 'required|string|max:10',
                'date_of_birth' => 'required|date|max:255',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error', 'error' => $e->getMessage(),
            ], 404);
        }

        try {
            // Create a new user details for the authenticated user
            $userDetails = $request->user()->userDetails()->create([
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error', 'error' => $e->getMessage(),
            ], 404);
        }

        // Return a 201 response with the created user details object
        return response()->json([
            'userDetails' => $userDetails,
        ], 201);
    }

    //function to update user details

    public function updateUserDetails(Request $request)
    {
        // Validate the request data
        try {
            $request->validate([
                'street_address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'postal_code' => 'required|integer|max:255',
                'country' => 'required|string|max:255',
                'phone_number' => 'required|string|max:10',
                'date_of_birth' => 'required|date|max:255',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error', 'error' => $e->getMessage(),
            ], 404);
        }

        try {
            // Update the user details for the authenticated user
            $userDetails = $request->user()->userDetails()->update([
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error', 'error' => $e->getMessage(),
            ], 404);
        }

        // Return a 201 response with the updated user details object
        return response()->json([
            'userDetails' => $userDetails,
        ], 201);
    }
}
