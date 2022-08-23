<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;
        $ability =[];
        $user2 =  User::find($user->id);
        $ability[0] = ["action"=> "manage","subject"=> "all"];   
        $user2->ability = $ability;
                        return response()->json([
            'accessToken' => $token,
            'refreshToken' => $token,
            'userData' => $user2,
        ]);
    }
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    public function refresh(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'refreshToken' => $request->user()->createToken('Personal Access Token')->plainTextToken,
        ]);
    }
}
