<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClientPermission;
use App\Models\ResetPassword;
use App\Models\User;
use App\Models\UsersVerify;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Nette\Utils\Json;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        if ($user2->role == 'Admin') {
            $ability[0] = ["action" => "manage", "subject" => "all"];

        } else if ($user2->role == 'Client') {
            $clientPermission = ClientPermission::where('plan', $user2->currentPlan)->first();

            if ($clientPermission) {
                $permissions = json_decode($clientPermission->permissions);

                $permissionsStr = Permission::whereIn('name', $permissions)->pluck('permission_string');
                foreach ($permissionsStr as $key => $value) {
                    $ability[$key] = json_decode($value);
                }

            }
        } else {
            $permissions = $user2->roles[0]->permissions->pluck('permission_string');

            foreach ($permissions as $key => $value) {
                if ($value) {
                    $value = json_decode($value);
                    $ability[$key] = $value;

                }
            }
        }
        if ($user2->avatar) {
            $user2->avatar = asset('/storage/user/avatars/' . $user2->avatar);
        }
        $userData = User::find($user->id);
        $userData->ability = $ability;
        $userData->notifications = $user->notifications ? unserialize($user->notifications) : [];
        return response()->json([
            'accessToken' => $token,
            'refreshToken' => $token,
            'userData' => $userData,
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
        $user->role = 'Client';

        if ($user->save()) {
            $user->assignRole('Client');
            $token = Str::random(64);
            $deleteOldTokens = UsersVerify::where('email', $request->email)->delete();
            $VerifyToken = new UsersVerify();
            $VerifyToken->token = $token;
            $VerifyToken->email = $request->email;
            $VerifyToken->save();
            Mail::send('emails.VerifyMail', ['token' => $token, 'url' => config('app.url'), 'email' => $request->email], function ($message) use ($user) {
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
        $user2 = User::find($user->id);
        if ($user2->role == 'Admin') {
            $ability[0] = ["action" => "manage", "subject" => "all"];

        } else if ($user2->role == 'Client') {
            $clientPermission = ClientPermission::where('plan', $user2->currentPlan)->first();

            if ($clientPermission) {
                $permissions = json_decode($clientPermission->permissions);

                $permissionsStr = Permission::whereIn('name', $permissions)->pluck('permission_string');
                foreach ($permissionsStr as $key => $value) {
                    $ability[$key] = json_decode($value);
                }

            }
        } else {
            $permissions = $user2->roles[0]->permissions->pluck('permission_string');
            foreach ($permissions as $key => $value) {
                if ($value) {
                    $value = json_decode($value);
                    $ability[$key] = $value;
                }
            }
        }

        $user = User::find($user->id);
        $user->ability = $ability;
        if ($user->avatar) {
            $user->avatar = asset('/storage/user/avatars/' . $user->avatar);
        }
        $user->notifications = $user->notifications ? unserialize($user->notifications) : [];
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
        Mail::send('emails.ForgetPassword', ['token' => $token, 'url' => config('app.url'), 'email' => $request->email], function ($message) use ($request) {
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
                $ability = [];
                if ($user2->role == 'Admin') {
                    $ability[0] = ["action" => "manage", "subject" => "all"];

                } else if ($user2->role == 'Client') {
                    $clientPermission = ClientPermission::where('plan', $user2->currentPlan)->first();

                    if ($clientPermission) {
                        $permissions = json_decode($clientPermission->permissions);

                        $permissionsStr = Permission::whereIn('name', $permissions)->pluck('permission_string');
                        foreach ($permissionsStr as $key => $value) {
                            $ability[$key] = json_decode($value);
                        }

                    }
                } else {
                    $permissions = $user2->roles[0]->permissions->pluck('permission_string');

                    foreach ($permissions as $key => $value) {
                        if ($value) {
                            $value = json_decode($value);
                            $ability[$key] = $value;

                        }
                    }
                }
                if ($userData->avatar) {
                    $userData->avatar = asset('/storage/user/avatars/' . $userData->avatar);
                }
                $userData = User::find($userData->id);
                $userData->ability = $ability;
                $userData->notifications = $userData->notifications ? unserialize($user->notifications) : [];
                return view('callback', [
                    'accessToken' => $token,
                    'userData' => $userData,
                ]);

            } else {
                $pass = '@user' . rand(10000, 9999999999) . $user->getId();
                $saveuser = User::updateOrCreate([
                    'google_id' => $user->getId(),
                    'fullName' => $user->getName(),
                    'username' => $user->getName() . rand(10000, 6666666666),
                    'email' => $user->getEmail(),
                    'contact' => $user->getName(),
                    'role' => 'Client',
                    'password' => Hash::make($pass),
                ]);
                $saveuser->assignRole('Client');
                $userData = Auth::loginUsingId($saveuser->id);
                $tokenResult = $userData->createToken('Personal Access Token');
                $token = $tokenResult->plainTextToken;
                $user2 = User::find($userData->id);
                $ability = [];
                if ($user2->role == 'Admin') {
                    $ability[0] = ["action" => "manage", "subject" => "all"];

                } else if ($user2->role == 'Client') {
                    $clientPermission = ClientPermission::where('plan', $user2->currentPlan)->first();

                    if ($clientPermission) {
                        $permissions = json_decode($clientPermission->permissions);

                        $permissionsStr = Permission::whereIn('name', $permissions)->pluck('permission_string');
                        foreach ($permissionsStr as $key => $value) {
                            $ability[$key] = json_decode($value);
                        }

                    }
                } else {
                    $permissions = $user2->roles[0]->permissions->pluck('permission_string');

                    foreach ($permissions as $key => $value) {
                        if ($value) {
                            $value = json_decode($value);
                            $ability[$key] = $value;

                        }
                    }
                }
                if ($userData->avatar) {
                    $userData->avatar = asset('/storage/user/avatars/' . $userData->avatar);
                }
                $userData = User::find($userData->id);
                $userData->ability = $ability;
                $userData->notifications = $userData->notifications ? unserialize($user->notifications) : [];
                return view('callback', [
                    'accessToken' => $token,
                    'userData' => $userData,
                ]);
            }

        } catch (\Exception$th) {
            return $th;
        }

    }
    public function CreateRoles()
    {
        return ClientPermission::get();
        // $role = Role::create(['name' => 'Editor']);
        // $role = Role::create(['name' => 'Client']);
        // $role = Role::create(['name' => 'Manager']);
        // $role = Role::create(['name' => 'Admin']);
        // $users = User::get();
        // foreach ($users as $key => $user) {
        //     $user->assignRole($user->role);
        // }
        // return 'all';
        // $user = User::find(4);
        // $user->assignRole('client');
        // $user->roles[0]->permissions->pluck('name', 'permission_string');
        // $role = Role::create(['name' => 'editor']);
        // $role = Role::create(['name' => 'author']);
        // $role = Role::create(['name' => 'Manager']);
        // $pString = json_encode(["action" => "read", "subject" => "Managemenu"]);
        // return $permission = Permission::create(['name' => 'Managemenu', 'permission_string' => $pString]);
        // $permission = Permission::create(['name' => 'Unlocking']);
        // $permission = Permission::create(['name' => 'Unautherize']);

        // return $role = Role::findByName('Client');
        // return $role->givePermissionTo('Dashboard2');
        // $role->givePermissionTo('Unautherize');
        // $role->givePermissionTo('Dashboard');
        // $role->givePermissionTo('Profile');
        // $user = json_encode(["action" => "read", "subject" => "Users"]);
        // $permission = Permission::create(['name' => 'Users', 'permission_string' => $user]);

    }

}
