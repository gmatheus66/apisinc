<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Patient;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PatientsController extends Controller
{
	private $patient;

	public function __construct(Patient $p){
		$this->patient = $p;
	}

    public function index(){
    
		if (sizeof($this->patient->all()) <= 0) {
			return response()->json(['data'=>['msg'=> 'Patient does not exist']]);
		}
		else{
			return response()->json($this->patient->all(),200);
		}
	}

	public function register(Request $request){


		$validator = Validator::make($request->all(),[
			'name' => 'required|string|max:50|min:3',
			'age' => 'required|numeric|min:1|max:3',
			'sex' => 'required|in:Male,Female,Another',
			'telephone' => 'required|numeric|min:8|max:9',
			'email' => 'required|max:50|min:10',
			'ocupation' => 'required|string|max:50|min:5',
			'address' => 'required|string|max:60|min:5',
			'city' => 'required|string|max:25|min:2',
			'country' => 'required|string|min:4|max:20',
			'state_province' => 'required|string|min:2|max:20',
			'zip' => 'required|numeric|min:5|max:9',
		]);

		if(sizeof($validator->errors()) > 0 ){
			return response()->json($validator->errors());
		}

		try{
			$this->patient->create([
				'name' => $request->get('name'),
				'age' => $request->get('age'),
				'sex' => $request->get('sex'),
				'telephone' => $request->get('telephone'),
				'email' => $request->get('email'),
				'ocupation' => $request->get('ocupation'),
				'address' => $request->get('address'),
				'city' => $request->get('city'),
				'country' => $request->get('country'),
				'state_province' => $request->get('state_province'),
				'zip' => $request->get('zip'),
			]);
			return response()->json(['data' => ['msg' => 'Patient successfully registered'] ],200);
		}
		catch(Exception $e){
			return response()->json($e);
		}
	}

	public function login(){
		
	}
}
