<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use Illuminate\Support\Facades\Validator;

class PatientsController extends Controller
{
	private $paciente;

	public function __construct(Patient $c){
		$this->patient = $c;
	}

    public function index(){
    
    if (sizeoff($this->patient-all()) <= 0) {
    	return response()->json(['data'=>['msg'=> 'Patient does not exist']]);
    }
    else{
    	return response()->json($this->patient->all(),200);
    }
}
