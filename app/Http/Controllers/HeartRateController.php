<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\HeartRate;

class HeartRateController extends Controller
{
    public function register(Request $request){

        return \response()->json($request);
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|min:1|max:2',
            'date_measurement' => 'required',
            'heart' => 'required' 
        ]);

        if(sizeof($validator->errors() > 0)){
            return response()->json($validator->errors());
        }
        try{
            $heart = HeartRate::create([
                'patient_id' => $request->get('patient_id'),
                'date_measurement' => $request->get('date_measurement'),
                'heart_rate' => $request->get('heart')
            ]);
            
            return response()->json(['data' => ['msg' => 'Heart Rate registed success']], 200);
        }
        catch(Exception $e){
            return response()->json($e);
        }
    }
}
