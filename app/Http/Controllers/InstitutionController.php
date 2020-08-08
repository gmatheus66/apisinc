<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;
use Illuminate\Support\Facades\Validator;

class InstitutionController extends Controller
{
    /**
    * @OA\Post(
    *     path="/institution/register",
    *     description="Relative Register",
    *     tags={"Admin"},
    *     @OA\Parameter(
    *         name="name",
    *         in="query",
    *         description="Name",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="telephone",
    *         in="query",
    *         description="Telephone",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="address",
    *         in="query",
    *         description="Address",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="city",
    *         in="query",
    *         description="City",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="country",
    *         in="query",
    *         description="Country",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="state_province",
    *         in="query",
    *         description="State Province",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="zip",
    *         in="query",
    *         description="Zip",
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
            'name' => 'required|string|max:50|min:3',
			'telephone' => 'required|numeric',
			'address' => 'required|string|max:60|min:5',
			'city' => 'required|string|max:25|min:2',
			'country' => 'required|string',
			'state_province' => 'required|string|min:2|max:20',
			'zip' => 'required|numeric',
        ]);
        if(sizeof($validator->errors()) > 0 ){
			return response()->json($validator->errors());
        }


        try{

            $inst = Institution::create([
				'name' => $request->get('name'),
				'telephone' => $request->get('telephone'),
				'address' => $request->get('address'),
				'city' => $request->get('city'),
				'country' => $request->get('country'),
				'state_province' => $request->get('state_province'),
				'zip' => $request->get('zip'),
            ]);


        }
        catch(Exception $e){
            return response()->json($e);
        }
    }
}
