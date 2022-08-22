<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string',
            'c_password' => 'required|same:password',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }
    public function users(Request $request)
    {
        $query = User::query();
        if ($request->q && $request->q != '') {
            $query->where('fullName', 'like', '%' . $request->q . '%')->orWhere('username', 'like', '%' . $request->q . '%')->orWhere('email', 'like', '%' . $request->q . '%');
        }
        if ($request->role && $request->role != '') {
            $query->where('role', $request->role);
        }
        if ($request->plan && $request->plan != '') {
            $query->where('currentPlan', $request->plan);
        }
        if ($request->status && $request->status != '') {
            $query->where('status', $request->status);
        }

        $users = $query->paginate($request->perPage ? $request->perPage : 10);
        return response()->json(['users' => $users]);
    }
    public function usersById(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if ($user) {
            if ($user->avatar) {
                $user->avatar = asset('/storage/user/avatars/' . $user->avatar);
            }
            if ($user->contactOptions) {
                // $user->contactOptions = explode(",", $user->contactOptions);
                $user->contactOptions = unserialize($user->contactOptions);
            } else {
                $user->contactOptions = [];
            }
            return response()->json($user);

        }
    }
    public function addUser(Request $request)
    {

        Validator::make($request->all(), [
            'fullName' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|unique:users',
            'role' => 'required|string',
            'currentPlan' => 'required|string',
            'company' => 'required|string',
            'country' => 'required|string',
            'contact' => 'required|string',
        ])->validate();
        $user = new User([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'username' => $request->username,
            'role' => $request->role,
            'currentPlan' => $request->currentPlan,
            'company' => $request->company,
            'country' => $request->country,
            'contact' => $request->contact,
            'status' => 'active',
            'password' => bcrypt($request->username),
        ]);
        $user->save();
        return response()->json(['status' => 'success']);
        // if($user->save()){
        //     $tokenResult = $user->createToken('Personal Access Token');
        //     $token = $tokenResult->plainTextToken;

        //     return response()->json([
        //     'message' => 'Successfully created user!',
        //     'accessToken'=> $token,
        //     ],201);
        // }
        // else{
        //     return response()->json(['error'=>'Provide proper details']);
        // }
    }
    public function updateAvatar(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        if ($user->avatar) {
            if (Storage::exists('/public/user/avatars/' . $user->avatar)) {
                Storage::delete('/public/user/avatars/' . $user->avatar);
            }
        }
        $extension = explode('/', mime_content_type($request->avatar))[1];

        $image = str_replace('data:image/' . $extension . ';base64,', '', $request->avatar);
        $avatar = base64_decode($image);

        $imageName = rand(1054545450, 999933333) . '.' . $extension;
        $file = File::put(storage_path('app/public/user/avatars/') . '' . $imageName, $avatar);
        $user->avatar = $imageName;
        $user->save();
        return response()->json(['status' => 'success']);
    }
    public function removeAvatar(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if ($user->avatar) {
            if (Storage::exists('/public/user/avatars/' . $user->avatar)) {
                Storage::delete('/public/user/avatars/' . $user->avatar);
            }
        }
        return response()->json(['status' => 'success']);
    }
    public function updateUserAccount(Request $request)
    {

        Validator::make($request->all(), [
            'fullName' => 'required|string',
            'role' => 'required|string',
            'currentPlan' => 'required|string',
            'company' => 'required|string',
            'country' => 'required|string',
            'contact' => 'required|string',
        ])->validate();
        $user = User::find($request->id);
        if ($user) {
            $user->fullName = $request->fullName;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->role = $request->role;
            $user->company = $request->company;
            $user->status = $request->status;
            $user->save();
            return response()->json(['status' => 'success']);

        } else {
            return response()->json(['status' => 'failed']);

        }

    }
    public function updateUserInformation(Request $request)
    {

        Validator::make($request->all(), [
            // 'fullName' => 'required|string',
            // 'role' => 'required|string',
            // 'currentPlan' => 'required|string',
            // 'company' => 'required|string',
            // 'country' => 'required|string',
            // 'contact' => 'required|string',
        ])->validate();
        $user = User::find($request->id);
        if ($user) {
            $user->dob = $request->dob;
            $user->contact = $request->contact ? $request->contact : $user->contact;
            $user->website = $request->website;
            $user->language = $request->language;
            $user->gender = $request->gender;
            $user->contactOptions = serialize($request->contactOptions);
            $user->addressLine1 = $request->addressLine1;
            $user->addressLine2 = $request->addressLine2;
            $user->postcode = $request->postcode;
            $user->country = $request->country ? $request->country : $user->country;
            $user->city = $request->city;
            $user->state = $request->state;
            $user->save();
            return response()->json(['status' => 'success']);

        } else {
            return response()->json(['status' => 'failed']);

        }

    }
    public function deleteUser(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            if ($user->avatar) {
                if (Storage::exists('/public/user/avatars/' . $user->avatar)) {
                    Storage::delete('/public/user/avatars/' . $user->avatar);
                }

            }
            $user->delete();
        return response()->json(['status' => 'success']);

        }
        else {
            return response()->json(['status' => 'failed']);

        }
    }
}
