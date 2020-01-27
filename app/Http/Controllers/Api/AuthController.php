<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
   {
       //return response()->json(['entrou'=>'esta merda entrou']);
        $validatedData = Validator::make($request->all() ,[
            'name'=>'required|max:55',
            'email'=>'email|required|unique:users',
            'password'=>'required'
        ]);

        if(sizeof($validatedData->errors()) > 0 ){
            return response()->json($validatedData->errors());
        }
        
        
        $validatedData->password = Hash::make($request->get('password'));

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['user'=> $user, 'access_token'=> $accessToken]);
    
   }


   public function login(Request $request)
   {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
 
        if(!auth()->attempt($loginData)) {
            return response(['message'=>'Invalid credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

   }
   public function logout(Request $request)
   {
       $request->user()->token()->revoke();
       return response()->json([
           'message' => 'Successfully logged out'
       ]);
   }
}
