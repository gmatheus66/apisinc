<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Patient;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PatientsController extends Controller
{
	private $patient;


	public function __construct(User $p){
		$this->patient = $p;
	}

    public function index(){
		
		if(auth()->user()->type == "Patient" || auth()->user()->type == "Relatives"){

			return response()->json(['data' => ['msg' => 'This user is not allowed to perform this operation'] ]);
		}
		else{

			if (sizeof($this->patient->all()) <= 0) {
				return response()->json(['data'=>['msg'=> 'Patient does not exist']]);
			}
			else{
				return response()->json([$this->patient->all(), auth()->user()->type],200);
			}
		}
	}

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
			'type' => 'required|in:Patient',
		
		]);

		if(sizeof($validator->errors()) > 0 ){
			return response()->json($validator->errors());
		}

		try{
			$pat = User::create([
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
			$accessToken = $pat->createToken('authToken')->accessToken;

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

	public function show($id){
		if(auth()->user()->type == "Doctor"){
			$user = User::find($id);
			return response()->json($user);
		}
		else{
			//Fazer select para o familiar so consultar quem for da familia dele
			//e o usuario so retornar apenas dados dele
			$user = User::find($id);
			return response()->json($user);
		}
	}


}
	