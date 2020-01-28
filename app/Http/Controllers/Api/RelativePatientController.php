<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Relatives_patient;

class RelativePatientController extends Controller
{
    public function register(Request $request){

        //return response()->json($request->get('kinship_degree'));

        $validator = Validator::make($request->all(),[
			'kinship_degree' => 'required|in:Grandparents,Mother,Father,Grandchild,Son,Sister,Broher,Wife,Husband,Girlfriend,Boyfriend,Other',
			'relative_id' => 'required|min:1|max:2',
			'patient_id'=>'required|min:1|max:2',
			
        ]);
     
        if(sizeof($validator->errors()) > 0){
			return response()->json($validator->errors());
        }
        
        try{

            $relpat = Relatives_patient::create([
                'kinship_degree' => $request->get('kinship_degree'),
                'relative_id' => $request->get('relative_id'),
                'patient_id' => $request->get('patient_id')
            ]);

            return response()->json(['data' => ['msg' => 'Relatives registed successfully' ] ],200);

        }
        catch(Exception $e){
            return response()->json($e);
        }
    }

}