<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     public function index()
    {
       return User::paginate(10);
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|string|required',
            'password' => 'string|required'
        ]);
        $credentials = $request->only([
            'email','password'
         ]);
        if(Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                            'token' => $token,
                            'user' => $user,
                            'status' => 200
                             ], 200);
        } else {
            return response()->json([
                'token' => 'User does not exits',
                'user' => 'User does not exists',
                'status' => 404
                 ], 404);
        }
    }
    public function logout(Request $request)
    {
        try {
            $tokenValue = $request->input('tokenValue');
            $accessToken = PersonalAccessToken::findToken($tokenValue);

            if ($accessToken) {
                $accessToken->delete();
                return[
                    'message' => 'Logout successfully!',
                ];
            } else {
                return[
                    'message' => 'cant find token',
                ];
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the token'], 500);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['password'] = Hash::make($data['password']);

        // Check if profile image is present in the request
        if ($request->hasFile('profile')) {
            $fileNameWithExtension = $request->file('profile')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);

            $extension = $request->file('profile')->getClientOriginalExtension();

            $profileImageName = $fileName.'_'.time().'.'.$extension;

            $request->file('profile')->move(base_path('../src/assets/'), $profileImageName);
            // storeAs('public', $profileImageName);

            $data['profile'] = $profileImageName;
        }

        // Create a new student record with the provided data
        $user = User::create($data);

        return response()->json([
            'message' => 'register Successfully',
            'user' => $user
        ], 200);
    }
    public function update(Request $request, $id)
    {
        // Retrieve the user by its ID
        $user = User::findOrFail($id);

        // Update user data
        $data = $request->all();

        // Hash the password if it's present in the request
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Check if profile image is present in the request
        if ($request->hasFile('profile')) {
            $fileNameWithExtension = $request->file('profile')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);

            $extension = $request->file('profile')->getClientOriginalExtension();

            $profileImageName = $fileName.'_'.time().'.'.$extension;

            $request->file('profile')->move(base_path('../src/assets/'), $profileImageName);

            $data['profile'] = $profileImageName;
        }

        // Update the user record
        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    public function destroy(User $User, $id)
    {
        $user = User::find($id);

        if($user) {
            $user->delete();
            return response()->json(['message' => 'user successfully deleted!'], 200);
        } else {
            return response()->json(['message' => 'user not found.'], 404);
        }
    }
}