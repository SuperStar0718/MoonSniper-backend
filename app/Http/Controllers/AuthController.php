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
                'error' => 'Unauthorized',
            ], );
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;
        $ability =[];
        $user2 =  User::find($user->id);
        $ability[0] = ["action"=> "manage","subject"=> "all"];
        if ($user->avatar) {
            $user->avatar = asset('/storage/user/avatars/' . $user->avatar);
        }
        $user2->notifications = $user->notifications?unserialize($user->notifications):[];
        $user2->ability = $ability;
                        return response()->json([
            'accessToken' => $token,
            'refreshToken' => $token,
            'userData' => $user2,
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        $ability =[];
        $user =  User::find($user->id);
        $ability[0] = ["action"=> "manage","subject"=> "all"];
        $user->notifications = $user->notifications?unserialize($user->notifications):[];
        $user->ability = $ability;
        return response()->json( $user);
    }
   
   
}
