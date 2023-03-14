<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
            'remember' => 'boolean'
        ]);
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);
        if(!Auth::attempt($credentials, $remember)){
            Auth::logout();
            return response([
                'message' => 'email or password is incorrect'
            ], 403);
        }
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        if(!$user->is_admin){
            return response(['message' => 'This user does not have permission to login as admin'], 422);    
        }
        
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function logout()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response('', 204);
    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }
}
