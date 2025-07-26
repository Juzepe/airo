<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json([
            'message' => 'User registered successfully',
            'token' => JWTAuth::fromUser($user),
            'user' => new UserResource($user),
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $token = JWTAuth::attempt($request->only('email', 'password'));

        if (! $token) {
            throw ValidationException::withMessages([
                'password' => ['Invalid credentials'],
            ]);
        }

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token,
            'user' => new UserResource($request->user()),
        ], 200);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'User logged out successfully',
        ], 200);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => new UserResource($user),
        ], 200);
    }
}
