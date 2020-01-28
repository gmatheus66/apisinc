<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Institution;
use Illuminate\Support\Facades\Validator;

class InstitutionsController extends Controller
{
    
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
			'name' => 'required|string|min:2|max:50',
			'ENI' => 'required|unique:institutions,ENI',
			'address'=> 'required|string|min:5|max:50',
			'city'=> 'required|string|min:5|max:25',
			'country' =>'required|min:2|max:35',
			'state_province' => 'required|max:25',
			'zip' => 'required|max:8',
        ]);
        if(sizeof($validator->errors()) > 0){
			return response()->json($validator->errors());
        }

        try{
            $inst = Institution::create([
                'name' => $request->get('name'),
                'ENI' => $request->get('ENI'),
                'address' => $request->get('address'),
                'city' => $request->get('city'),
                'country' => $request->get('country'),
                'state_province' => $request->get('state_province'),
                'zip' => $request->get('zip')
            ]);
            return response()->json(['data' => ['msg' => 'Institutions registed successfully'] ],200);

        }
        catch(Exception $e){

        }
        
    }

}
