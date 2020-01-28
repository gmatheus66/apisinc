<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Handbook;


class HandbookController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'name_handbook' => 'required|min:5|max:50',
            'limitation' => 'required|in:Cognitive,Locomotion,Vision,Hearing',
            'body_mass' => 'required|numeric|between:0,199.99',
            'weight' => 'required|numeric|between:0,299.99',
            'service_date' => 'required|date',
            'complaints' => 'required|max:500',
            'symptoms' => 'required|max:100',
            'vital_signs' => 'required|max:50',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'blood_pressure' => 'required|numeric|between:0,199.99',
            'hgt' => 'required|numeric|between:0,199.99',
            'temperature' => 'required',
            'relative_id' => 'required|min:1|max:2',
            'patient_id' => 'required|min:1|max:2',
            'doctor_id' => 'required|min:1|max:2'
        ]);
        if(sizeof($validator->errors()) > 0){
			return response()->json($validator->errors());
        }
        if(auth()->user()->type == "Doctor"){

            try{
                $hand = Handbook::create([
                    'name_handbook' => $request->get('name_handbook'),
                    'limitation' => $request->get('limitation'),
                    'body_mass' => $request->get('body_mass'),
                    'weight' => $request->get('weight'),
                    'service_date' => $request->get('service_date'),
                    'complaints' => $request->get('complaints'),
                    'symptoms' => $request->get('symptoms'),
                    'vital_signs' => $request->get('vital_signs'),
                    'blood_type' => $request->get('blood_type'),
                    'blood_pressure' => $request->get('blood_pressure'),
                    'hgt' => $request->get('hgt'),
                    'relative_id' => $request->get('relative_id'),
                    'patient_id' => $request->get('patient_id'),
                    'doctor_id' => $request->get('doctor_id'),
                    'temperature' => $request->get('temperature')
                    ]);
                    
                    return response()->json(['data' => ['msg' => 'Handbook registed successfully'] ],200);
                    
            }
            catch(Exception $e){
                return response()->json($e);
            }
        }
        else{
            return response()->json(['data' => ['msg' => 'This user is not allowed to perform this operation'] ]);
        }

    }
}
