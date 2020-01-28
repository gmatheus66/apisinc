<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RelativesController extends Controller
{

    public function register(Request $request){
    
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50|min:3',
			'birthday' => 'required|date',
			'sex' => 'required|in:Male,Female,Another',
			'telephone' => 'required|numeric',
			'email' => 'required|max:50|min:10|unique:users,email',
			'occupation' => 'required|string|max:50|min:5',
			'address' => 'required|string|max:60|min:5',
			'city' => 'required|string|max:25|min:2',
			'country' => 'required|string',
			'state_province' => 'required|string|min:2|max:20',
			'zip' => 'required|numeric',
			'password' => 'required',
			'type' => 'required|in:Relatives'
        ]);
        if(sizeof($validator->errors()) > 0 ){
			return response()->json($validator->errors());
        }
        
        try{

            $rel = User::create([
				'name' => $request->get('name'),
				'birthday' => $request->get('birthday'),
				'sex' => $request->get('sex'),
				'telephone' => $request->get('telephone'),
				'email' => $request->get('email'),
				'occupation' => $request->get('occupation'),
				'address' => $request->get('address'),
				'city' => $request->get('city'),
				'country' => $request->get('country'),
				'state_province' => $request->get('state_province'),
				'zip' => $request->get('zip'),
				'password' => Hash::make($request->get('password')),
				'type' => $request->get('type'),
			]);
			$accessToken = $rel->createToken('authToken')->accessToken;

			return response()->json(['data' => ['msg' => 'Patient successfully registered', $accessToken] ],200);

        }
        catch(Exception $e){
            return response()->json($e);
        }

    }

    public function login(Request $request){

        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
 
        if(!Auth::attempt($loginData)) {
            return response(['message'=>'Invalid credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), $accessToken]);

    }


}
