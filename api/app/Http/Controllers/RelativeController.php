<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Relative;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RelativeController extends Controller
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
        ]);
        if(sizeof($validator->errors()) > 0 ){
			return response()->json($validator->errors());
        }

        
        try{

            $rel = Relative::create([
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
            ]);
            
            $token = auth('relatives')->login($rel);

			return $this->respondWithToken($token);

        }
        catch(Exception $e){
            return response()->json($e);
        }
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => auth('relatives')->factory()->getTTL() * 60,
            'user' => auth('relatives')->user()
        ]);
	}
	

    public function logout()
    {
        auth('relatives')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function login(Request $request){

		$loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
		]);
		
		
		$credentials = request(['email', 'password']);

        if (! $token = auth('relatives')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

		return $this->respondWithToken($token);
    }
    
    public function detail_auth_user(){
		return auth()->user();
	}
}

