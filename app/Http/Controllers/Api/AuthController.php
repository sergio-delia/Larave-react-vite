<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /* Creato prima le request php artisan make:request SignupRequest e LoginRequest */
    public function signup(SignupRequest $request){

        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        /** @var User $user */
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);

        //per fare più in breve si potrebbe fare return response(compact('user','token'))

    }


    public function login(LoginRequest $request){
        $credentials = $request->validated();

        if(!Auth::attempt($credentials)){
            return response([
                'message' => 'Email o password errata'
            ], 422);
        }

        $user = Auth::user();

        /** @var User $user */
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }




    public function logout(Request $request){

        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete();



        return response('', 204);

    }
}
