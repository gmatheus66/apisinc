<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RelativePatient;
use App\Relative;
use App\Patient;
use Illuminate\Support\Facades\Validator;

class RelativePatientController extends Controller
{
    /**
    * @OA\Get(
    *     path="/relative/patient",
    *     description="Returns patients linked to family members",
    *     tags={"Relative"},
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
    public function get_my_patient_relatives(){
        $rel = RelativePatient::where('relative_id', \auth('relatives')->user()->id )->get();
        return \response()->json($rel);
    }

    /**
    * @OA\Post(
    *     path="/register/patient",
    *     description="relative Register",
    *     tags={"Relative"},
    *     @OA\Parameter(
    *         name="relative_id",
    *         in="query",
    *         description="Relative ID",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="patient_id",
    *         in="query",
    *         description="Patient ID",
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

        $validator = Validator::make($request->all(),[
            'relative_id' =>  'required|numeric|exists:App\Relative,id',
            'patient_id' => 'required|numeric|exists:App\Patient,id'
        ]);

        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors());
        }

        try{
                $relpat = RelativePatient::create([
                    'relative_id' => $request->get('relative_id'),
                    'patient_id' => $request->get('patient_id'),
                    'relative_patient' => false
                ]);

                return response()->json("Relative relationship");
        }
        catch(Exception $e){

            return \response()->json("Error Relative relationship");

        }

    }

    public function get_relative_patient($id){
        $validator = Validator::make(['id' => $id],[
            'id' => 'required|numeric|exists:RelativePatient,relative_id'
        ]);
        $get = RelativePatient::where('relative_id',$id)->get();
        return response()->json($get);
    }
}
