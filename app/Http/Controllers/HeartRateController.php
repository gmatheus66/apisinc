<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\HeartRate;

class HeartRateController extends Controller
{
     /**
    * @OA\Post(
    *     path="/doctor/register",
    *     description="Doctor Register",
    *     tags={"Doctor"},
    *     @OA\Parameter(
    *         name="patient_id",
    *         in="query",
    *         description="Patient ID",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="date_measurement",
    *         in="query",
    *         description="Date Measurement",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="heart",
    *         in="query",
    *         description="Heart",
    *         required=true,
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="OK",
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Missing Data"
    *     ),
    *     @OA\Response(
    *          response=401,
    *          description="Unauthenticated",
    *     ),
    * )
    */
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|min:1|max:3',
            'date_measurement' => 'required',
            'heart' => 'required'
        ]);
        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors());
        }
        if(sizeof(HeartRate::where('date_measurement', $request->get('date_measurement') )->get()) ){
            return response()->json( ['data' => ['msg' => 'Heart Rate already registered']] );
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

    public function get_heart_rates(){

        if(HeartRate::where('patient_id', auth('patient')->user()->id )->get()){
            return response()->json( HeartRate::where('patient_id', auth('patient')->user()->id )->get() );
        }
        else{
            return response()->json('Has no registered heart rate for this user');
        }
    }
}
