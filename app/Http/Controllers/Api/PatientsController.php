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
}
