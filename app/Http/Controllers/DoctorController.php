<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Doctor;
use Illuminate\Support\Facades\Validator;


class DoctorController extends Controller
{
    /**
    * @OA\Get(
    *     path="/doctor/detail",
    *     description="Returns a detail doctor",
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
	public function detail_auth_user(){
		return auth('doctors')->user();
    }
    /**
    * @OA\Post(
    *     path="admim/doctor/register",
    *     description="Doctor Register",
    *     tags={"Admim"},
    *     @OA\Parameter(
    *         name="name",
    *         in="query",
    *         description="Name",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="email",
    *         in="query",
    *         description="Email",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="crm",
    *         in="query",
    *         description="Crm",
    *         required=true,
    *     ),
    *     @OA\Parameter(
    *         name="specialization",
    *         in="query",
    *         description="Specialization",
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
    *     security={{ "apiAuth": {} }},
    * )
    */
    public function register(Request $request){

		$validator = Validator::make($request->all(),[
			'name' => 'required|string|min:2|max:50',
			'email' => 'required',
			'crm' =>'required|min:6|max:12|unique:doctors,crm',
			'specialization'=> 'required|string|min:5|max:50',
			'password' => 'required'

		]);

		if(sizeof($validator->errors()) > 0){
			return response()->json($validator->errors());
        }

		try{

			$doc = Doctor::create([
				'name'=> $request->get('name'),
				'email' => $request->get('email'),
				'crm'=> $request->get('crm'),
				'specialization'=> $request->get('specialization'),
				'password' => Hash::make($request->get('password')),
			]);

			$token = auth('doctors')->login($doc);

			return $this->respondWithToken($token);

		}catch(Exception $e){
			return response()->json($e);
		}
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => auth('doctors')->factory()->getTTL() * 60,
            'user' => auth('doctors')->user()
        ]);
	}

    /**
    * @OA\Post(
    *     path="/doctor/logout",
    *     description="Login Doctor",
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
    public function logout()
    {
        auth('doctors')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
    * @OA\Post(
    *     path="/doctor/login",
    *     description="Login Doctor",
    *     tags={"Doctor"},
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

        if (! $token = auth('doctors')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

		return $this->respondWithToken($token);
	}
    /**
    * @OA\Get(
    *     path="/doctor/check",
    *     description="Returns a check Doctor",
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
	public function check_user(){

		try{
		 	return response()->json(auth('doctors')->check());
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
