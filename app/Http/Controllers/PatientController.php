<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
    * @OA\Get(
    *     path="/relative/patients",
    *     description="Returns a list of patients for the relative",
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
    *     security={{ "apiAuth": {} }},
    * )
    */
	public function get_all_patient_relatives(){
		$patients = Patient::all();
		return response()->json($patients);
    }
    /**
    * @OA\Get(
    *     path="/doctor/patient",
    *     description="Returns a list of patients for the doctor",
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
	public function get_all_patient_doctor(){
		$patients = DB::select('select id, name from patients');
		return response()->json($patients);
    }

     /**
    * @OA\Post(
    *     path="/patient/register",
    *     description="Patient Register",
    *     tags={"Patient"},
    *     @OA\Parameter(
    *         name="name",
    *         in="query",
    *         description="Name",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="birthday",
    *         in="query",
    *         description="Birthday",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="sex",
    *         in="query",
    *         description="Sex",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="telephone",
    *         in="query",
    *         description="Telephone",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="email",
    *         in="query",
    *         description="Email",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="occupation",
    *         in="query",
    *         description="Occupation",
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
    *     @OA\Parameter(
    *         name="password",
    *         in="query",
    *         description="Password",
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
			'birthday' => 'required|date',
			'sex' => 'required|in:Male,Female,Another',
			'telephone' => 'required|numeric',
			'email' => 'required|max:50|min:10|unique:patients,email',
			'occupation' => 'required|string|max:50|min:5',
			'address' => 'required|string|max:60|min:5',
			'city' => 'required|string|max:25|min:2',
			'country' => 'required|string',
			'state_province' => 'required|string|min:2|max:20',
			'zip' => 'required|numeric',
			'password' => 'required',
		]);

		if(sizeof($validator->errors()) > 0 ){
			return response()->json($validator->errors());
		}

		try{
			$pat = Patient::create([
				'name' => $request->get('name'),
				'birthday' => $request->get('birthday'),
				'sex' => $request->get('sex'),
				'telephone' => $request->get('telephone'),
				'email' => $request->get('email'),
				'occupation' => $request->get('occupation'),
				'address' => $request->get('address'),
				'city' => $request->get('city'),
				'country' => $request->get('country'),
				'state_province' => $request->get('state_province'),
				'zip' => $request->get('zip'),
				'password' => Hash::make($request->get('password')),
			]);

            $token = auth('patient')->login($pat);

			return $this->respondWithToken($token);
		}
		catch(Exception $e){
			return response()->json($e);
		}
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => auth('patient')->factory()->getTTL() * 60,
            'user' => auth('patient')->user()
        ]);
    }

    /**
    * @OA\Post(
    *     path="/patient/logout",
    *     description="Logout Patient",
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
    public function logout()
    {
		config([
            'jwt.blacklist_enabled' => true
        ]);
        auth('patient')->logout();
		auth('patient')->invalidate(auth('patient')->parseToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
    * @OA\Post(
    *     path="/patient/login",
    *     description="Login Patient",
    *     tags={"Patient"},
    *     @OA\Parameter(
    *         name="email",
    *         in="query",
    *         description="Email",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="password",
    *         in="query",
    *         description="Password",
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
    public function login(Request $request){

		$loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
		]);


		$credentials = request(['email', 'password']);

        if (! $token = auth('patient')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

		return $this->respondWithToken($token);
    }

    /**
    * @OA\Get(
    *     path="/patient/detail",
    *     description="Returns a detail Patient",
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
    public function detail_auth_user(){
		return auth('patient')->user();
	}
    /**
    * @OA\Get(
    *     path="/patient/check",
    *     description="Returns a check Patient",
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
	public function check_user(){

		try{
		 	return response()->json(auth('patient')->check());
		}
		catch (UnauthorizedHttpException $e) {
			return response()->json(false);
		}
		catch (TokenBlacklistedException $e) {
			return response()->json(false);
		}
		catch (TokenExpiredException $e) {
			return response()->json(false);
		}
		catch (TokenInvalidException $e) {
			return response()->json(false);
		}
		catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(false);
		}
		catch (Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e) {
			return response()->json(false);
		}
		catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(false);
		}
		catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json(false);
		}

	}

}
