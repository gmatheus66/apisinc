<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Handbook;

class HandbookController extends Controller
{
    public function get_handbook_patient(){

        if( Handbook::select('id','name_handbook','patient_id', 'service_date', 'doctor_id' )->where('patient_id', auth('patient')->user()->id )->get() ){
            return response()->json( Handbook::select('id','name_handbook','patient_id', 'service_date', 'doctor_id' )->where('patient_id', auth('patient')->user()->id )->get()  );
        }
        else{
            return response()->json( ['data' => ['msg' => 'This user has no registered medical records']] );
        }

    }
    public function get_detail_handbook_patient($id){
        $validate = Validator::make(['id' => $id] ,['id' => 'min:1|max:24']);

        if($validate->fails()) return response()->json($validate->errors());

        if(Handbook::where('patient_id', auth()->user()->id )->where('id', $id)->get()){
            return response()->json( Handbook::where('patient_id', auth()->user()->id )->where('id', $id)->get() );
        }
        else{
            return response()->json( ['data' => ['msg' => 'This user has no registered medical records']] );
        }
    }
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'name_handbook' => 'required|min:5|max:50',
            'limitation' => 'required|in:Cognitive,Locomotion,Vision,Hearing',
            'body_mass' => 'required|numeric|between:0,999.99',
            'weight' => 'required|numeric|between:0,299.99',
            'service_date' => 'required|date',
            'complaints' => 'required|max:500',
            'symptoms' => 'required|max:100',
            'vital_signs' => 'required|max:50',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'blood_pressure' => 'required|numeric',
            'hgt' => 'required|numeric',
            'temperature' => 'required',
            'relative_id' => 'min:1',
            'patient_id' => 'required|min:1',

        ]);
        if(sizeof($validator->errors()) > 0){
			return response()->json($validator->errors());
        }

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
                'doctor_id' => auth('doctors')->user()->id,
                'temperature' => $request->get('temperature')
                ]);

                return response()->json(['data' => ['msg' => 'Handbook registed successfully'] ],200);

        }
        catch(Exception $e){
            return response()->json($e);
        }
    }
}
