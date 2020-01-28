<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Doctor;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    private $doc;

	public function __construct(User $d){
		$this->doc = $d;
	}
	public function index(){
		if(auth()->user()->type == "Patient" || auth()->user()->type == "Relatives" || auth()->user()->type == "Doctor" ){
		
			return response()->json(['data' => ['msg' => 'This user is not allowed to perform this operation'] ]);
		
		}
		else{

			if(sizeof($this->doc->all())<= 0){
				return response()->json(['dados'=>'No doctors are registed']);
			}
			else{
				return response()->json($this->doc->all(),200);
			}
		}
	}
	public function register(Request $request){
		$validator = Validator::make($request->all(),[
			'name' => 'required|string|min:2|max:50',
			'email' => 'required',
			'crm' =>'required|min:6|max:12|unique:doctors,crm',
			'specialization'=> 'required|string|min:5|max:50',
			'institution_id'=>'required|min:1|max:50',
			'type' => 'required|in:Doctor',
			'password' => 'required'
			
		]);
			
		if(sizeof($validator->errors()) > 0){
			return response()->json($validator->errors());
		}
		try{
			
			$doc = User::create([
				'name'=> $request->get('name'),
				'email' => $request->get('email'),
				'crm'=> $request->get('crm'),
				'specialization'=> $request->get('specialization'),
				'institution_id'=> $request->get('institution_id'),
				'type' => $request-> get('type'),
				'password' => Hash::make($request->get('password')),
				]);

				$accessToken = $doc->createToken('authToken')->accessToken;

				return response()->json(['data' => ['msg' => 'Doctor registed successfully', 'access_token'=> $accessToken ] ],200);
				
		}catch(Exception $e){
			return response()->json($e);
		}
	}

	public function login(Request $request){

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
}	

