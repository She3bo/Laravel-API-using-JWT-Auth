<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token'));
    }
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $credentials = $request->only('email','password');
        $token = JWTAuth::attempt($credentials);
        try {
            if(!$token){
                return response()->json(['error'=>'invalid email or password'],401);
            }
        } catch (JWTException $e) {
            return response()->json(['error'=>'could not create token'],500);
        }
        return response()->json(compact('token'));
    }
}
