<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UsersVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ResetPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Notifications\VerifyEmail;
use Nette\Utils\Json;

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
        $ability = [];
        $user2 = User::find($user->id);
        $ability[0] = ["action" => "manage", "subject" => "all"];
        if ($user->avatar) {
            $user->avatar = asset('/storage/user/avatars/' . $user->avatar);
        }
        $user2->notifications = $user->notifications ? unserialize($user->notifications) : [];
        $user2->ability = $ability;
        return response()->json([
            'accessToken' => $token,
            'refreshToken' => $token,
            'userData' => $user2,
        ]);
    }
    public function registration(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|unique:users',
            'password' => 'required|string',
        ]);

        $user = new User();
        $user->fullName = $request->fullName;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->role = 'admin';

        if ($user->save()) {

            $token = Str::random(64);
            $deleteOldTokens = UsersVerify::where('email', $request->email)->delete();
            $VerifyToken = new UsersVerify();
            $VerifyToken->token = $token;
            $VerifyToken->email = $request->email;
            $VerifyToken->save();
            Mail::send('emails.VerifyMail', ['token' => $token, 'url' => env('APP_URL'), 'email' => $request->email], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Verify Email');
            });
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }
    public function user(Request $request)
    {
        $user = $request->user();
        $ability = [];
        $user = User::find($user->id);
        $ability[0] = ["action" => "manage", "subject" => "all"];
        $user->notifications = $user->notifications ? unserialize($user->notifications) : [];
        $user->ability = $ability;
        return response()->json($user);
    }

    public function generateForgotPasswordToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);
        $deleteOldTokens = ResetPassword::where('email', $request->email)->delete();
        $Reset = new ResetPassword([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        $Reset->save();
        Mail::send('emails.ForgetPassword', ['token' => $token, 'url' => env('APP_URL'), 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return response()->json(['status' => 'success']);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $retriveToken = ResetPassword::where('email', $request->email)->where('token', $request->token)->first();
        if ($retriveToken) {
            $user = User::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);
            $deleteOldTokens = ResetPassword::where('email', $request->email)->delete();
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failed']);
        }

    }
    public function verifyEmail(Request $request)
    {
        $retriveToken = UsersVerify::where('email', $request->email)->where('token', $request->token)->first();
        if ($retriveToken) {
            $deleteOldTokens = UsersVerify::where('email', $request->email)->delete();
            $user = User::where('email', $request->email)
                ->update(['is_email_verified' => 1, 'email_verified_at' => Carbon::now()]);
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }
    public function googleRedirect()
    {
        return response()->json([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
        ]);
    }
    public function googleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            // dd($user);
            $getuser = User::where('email', '=', $user->getEmail())->first();
            if ($getuser) {
                $saveuser3 = User::where('email', '=', $user->email)->update(['google_id' => $user->getId(), 'is_email_verified' => 1]);
                $saveuser = User::where('email', '=', $user->getEmail())->first();
                $userData = Auth::loginUsingId($saveuser->id);
                $tokenResult = $userData->createToken('Personal Access Token');
                $token = $tokenResult->plainTextToken;
                $ability = [];
                $user2 = User::find($userData->id);
                $ability[0] = ["action" => "manage", "subject" => "all"];
                if ($user->avatar) {
                    $user->avatar = asset('/storage/user/avatars/' . $user->avatar);
                }
                $user2->notifications = $user2->notifications ? unserialize($user2->notifications) : [];
                $user2->ability = $ability;
             
                return view('callback', [
                    'accessToken' => $token,
                    'userData' => $user2,
                ]);

            } else {
                $pass = '@user' . rand(10000, 9999999999) . $user->getId();
                $saveuser = User::updateOrCreate([
                    'google_id' => $user->getId(),
                    'fullName' => $user->getName(),
                    'username' => $user->getName() . rand(10000, 6666666666),
                    'email' => $user->getEmail(),
                    'contact' => $user->getName(),
                    'role' => 'admin',
                    'password' => Hash::make($pass),
                ]);
                $userData = Auth::loginUsingId($saveuser->id);
                $tokenResult = $userData->createToken('Personal Access Token');
                $token = $tokenResult->plainTextToken;
                $user2 = User::find($userData->id);
                $ability[0] = ["action" => "manage", "subject" => "all"];
                if ($user->avatar) {
                    $user->avatar = asset('/storage/user/avatars/' . $user->avatar);
                }
                $user2->notifications = $user2->notifications ? unserialize($user2->notifications) : [];
                $user2->ability = $ability;
                return view('callback', [
                    'accessToken' => $token,
                    'userData' => $user2,
                ]);
            }

        } catch (\Exception$th) {
            return $th;
        }

    }

}
