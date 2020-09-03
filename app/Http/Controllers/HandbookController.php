<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Handbook;
use App\Doctor;
use App\Patient;

class HandbookController extends Controller
{
    /**
    * @OA\Get(
    *     path="/patient/gethandbook",
    *     description="Returns patient records",
    *     tags={"Patient"},
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
    *     security={{ "apiAuth": {} }},
    * )
    */
    public function get_handbook_patient(){

        if( Handbook::select('id','name_handbook','patient_id', 'service_date', 'doctor_id' )->where('patient_id', auth('patient')->user()->id )->get() ){

            $handbooks_data = Handbook::select('id','name_handbook','patient_id', 'service_date', 'doctor_id' )->where('patient_id', auth('patient')->user()->id )->get();
            $handbooks_array = json_decode($handbooks_data ,true);;
            $new_handbooks_array = [];
            foreach($handbooks_array as $value_handbooks){
                $doctor_name = Doctor::select('name')->where('id',$value_handbooks["doctor_id"])->get();
                $doctor = ['doctor_name' => $doctor_name[0]->name ];
                $value = array_merge($value_handbooks,$doctor);
                array_push($new_handbooks_array, $value);
            }
            return response()->json($new_handbooks_array);
        }
        else{
            return response()->json( ['data' => ['msg' => 'This user has no registered medical records']] );
        }

    }
    /**
    * @OA\Get(
    *     path="/doctor/gethandbook",
    *     description="Returns doctor records",
    *     tags={"Doctor"},
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
    *     security={{ "apiAuth": {} }},
    * )
    */
    public function get_handbook_doctor(){

        if( Handbook::select('id','name_handbook','patient_id', 'service_date', 'doctor_id' )->where('doctor_id', auth('doctors')->user()->id )->get() ){

            $handbooks_data = Handbook::select('id','name_handbook','patient_id', 'service_date', 'doctor_id' )->where('doctor_id', auth('doctors')->user()->id )->get();
            $handbooks_array = json_decode($handbooks_data ,true);;
            $new_handbooks_array = [];
            foreach($handbooks_array as $value_handbooks){
                $patient_name = Patient::select('name')->where('id',$value_handbooks["patient_id"])->get();
                $patient = ['patient_name' => $patient_name[0]->name ];
                $value = array_merge($value_handbooks,$patient);
                array_push($new_handbooks_array, $value);
            }
            return response()->json($new_handbooks_array);
        }
        else{
            return response()->json( ['data' => ['msg' => 'This user has no registered medical records']] );
        }

    }
    /**
    * @OA\Get(
    *     path="/patient/gethandbook/{id}",
    *     description="Returns patient records detail",
    *     tags={"Patient"},
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
    *     security={{ "apiAuth": {} }},
    * )
    */
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
    /**
    * @OA\Post(
    *     path="/doctor/handbook/register",
    *     description="Handbook Register",
    *     tags={"Doctor"},
    *     @OA\Parameter(
    *         name="name_handbook",
    *         in="query",
    *         description="Name Handbook",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="limitation",
    *         in="query",
    *         description="Limitation in:Cognitive,Locomotion,Vision,Hearing",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="body_mass",
    *         in="query",
    *         description="Body Mass",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="weight",
    *         in="query",
    *         description="Weight",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="service_date",
    *         in="query",
    *         description="Service Date",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="complaints",
    *         in="query",
    *         description="Complaints",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="symptoms",
    *         in="query",
    *         description="Symptoms",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="vital_signs",
    *         in="query",
    *         description="Vital Signs",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="blood_type",
    *         in="query",
    *         description="Blood Type in:A+,A-,B+,B-,AB+,AB-,O+,O-",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="blood_pressure",
    *         in="query",
    *         description="Blood Pressure",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="hgt",
    *         in="query",
    *         description="HGT",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="temperature",
    *         in="query",
    *         description="Temperature",
    *         required=true,
    *     ),
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
    *     security={{ "apiAuth": {} }},
    * )
    */
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'name_handbook' => 'required|min:5|max:50',
            'limitation' => 'required|in:Cognitive,Locomotion,Vision,Hearing,None',
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
