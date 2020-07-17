<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdmimController extends Controller
{
    
    /**
    * @OA\Post(
    *     path="/admim/logout",
    *     description="Login Doctor",
    *     tags={"Admim"},
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
        auth('admims')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
    * @OA\Post(
    *     path="/admim/login",
    *     description="Login Admim",
    *     tags={"Admim"},
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

        if (! $token = auth('admims')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

		return $this->respondWithToken($token);
    }
    
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => auth('admims')->factory()->getTTL() * 60,
            'user' => auth('admims')->user()
        ]);
	}


}
