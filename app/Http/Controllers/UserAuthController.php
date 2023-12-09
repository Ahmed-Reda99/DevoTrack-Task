<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegistrationRequest;

class UserAuthController extends Controller
{

    public function register (UserRegistrationRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        $token = $user->createToken('devotrack');

        return [
            'user' => new UserResource($user),
            'token' => $token->plainTextToken
        ];
    }

    public function login (UserLoginRequest $request)
    {
        $user = User::whereEmail($request->email)->first();

        if(Hash::check($request->password, $user->password))
        {
            $token = $user->createToken('devotrack');

            return [
                'user' => new UserResource($user),
                'token' => $token->plainTextToken
            ];
        }
        else
            return response()->json([
                'message' => 'Your Password Is Incorrect'
            ], 422);
    }

    public function logout ()
    {
        auth()->user()->currentAccessToken()->delete(); // revoke current token

        return response()->json([
            'message' => "Logged Out Successfully"
        ]);
    }

    public function refreshToken ()
    {
        $user = auth()->user();
        
        $user->tokens()->delete(); // revoke all tokens

        $token = $user->createToken('devotrack');
        
        return [
            'user' => new UserResource($user),
            'token' => $token->plainTextToken
        ];
    }

    public function currentUser ()
    {
        return auth()->user();
    }

}
