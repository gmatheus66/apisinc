<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Relative;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RelativeController extends Controller
{
    /**
    * @OA\Post(
    *     path="/relative/register",
    *     description="Relative Register",
    *     tags={"Relative"},
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
			'email' => 'required|max:50|min:10|unique:relatives,email',
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

            $rel = Relative::create([
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

            $token = auth('relatives')->login($rel);

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
            'expires_in'   => auth('relatives')->factory()->getTTL() * 60,
            'user' => auth('relatives')->user()
        ]);
	}

    /**
    * @OA\Post(
    *     path="/relative/logout",
    *     description="Login Relative",
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
    public function logout()
    {
        auth('relatives')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
    * @OA\Post(
    *     path="/relative/login",
    *     description="Login Relative",
    *     tags={"Relative"},
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

        if (! $token = auth('relatives')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

		return $this->respondWithToken($token);
    }
    /**
    * @OA\Get(
    *     path="/relative/detail",
    *     description="Returns a detail Relative",
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
    public function detail_auth_user(){
		return auth()->user();
    }
    /**
    * @OA\Get(
    *     path="/relative/check",
    *     description="Returns a check Relative",
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
    public function check_user(){

		try{
		 	return response()->json(auth('relatives')->check());
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

