<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Doctor;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    private $doc;

	public function __construct(Doctor $d){
		$this->doc = $d;
	}
	public function index(){
		if(sizeof($this->doc->all())<= 0){
			return response()->json(['dados'=>'No doctors are registed']);
		}
		else{
			return response()->json($this->doc->all(),200);
		}
	}
	public function store(Request $request){
		$Validator = Validator::make($request->all(),[
			'name' => 'required|string|min:2|max:50',
			'crm' =>'required|numeric|max:8|unique:doctors,crm',
			'specialization'=> 'required|string|min:5|max:50',
			'institution_id'=>'required|string|min:5|max:50'
			]);
			
			if(sizeof($validator->errors()) > 0){
				return response()->json($validator->errors());
			}
			try{
				
				$this->doc->create([
					'name'=> $request->get('name'),
					'crm'=> $request->get('crm'),
					'specialization'=> $request->get('specialization'),
					'institution_id'=> $request->get('institution_id')
					
					]);
					return response()->json(['data' => ['msg' => 'Doctor registed successfully'] ],200);
					
				}catch(Exception $e){
					return response()->json($e);
				}
			}
}	

