<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Use the Laravel built in auth to check for user validation
        if (!Auth::attempt($validate)) {
            return response()->json([
                'message' => 'Login information invalid',
            ], 401);
        }

        $user = User::where('email', $validate['email'])->first();

        return response()->json([
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    public function register(Request $request) {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'email'=> 'required|max:125|email|unique:users,email',
            'password'=> 'required|confirmed|min:6',
        ]);

        $validate['password'] = Hash::make($validated['password']); // Hash our password

        $user = User::create($validated);

        return response()->json([
            'data'=> $user,
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
        ], 201);
    }
}
