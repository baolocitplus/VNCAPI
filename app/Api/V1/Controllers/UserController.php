<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;
use Config;
use App\User;
use DB;
use App\Api\V1\Requests\SignUpRequest;

class UserController extends Controller
{
    /**
     * Log the user in
     *
     * @param LoginRequest $request
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */

    public function __construct()
    {
        $this->middleware('jwt.auth', [])->except('login', 'signUp', 'refresh');
    }

    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            $token = Auth::guard()->attempt($credentials);

            if(!$token) {
                throw new AccessDeniedHttpException();
            }

        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        return response()
            ->json([
                'status' => 'success',
                'token' => $token,
                'data' => Auth::guard()->user(),
                'expires_in' => Auth::guard()->factory()->getTTL() * 60
            ]);
    }


    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {
        $user = new User($request->all());
        $email = $request->input('email');
        $checkEmail = DB::select('select email from users where email=?',[$email]);
        if ($checkEmail != null) {
            return response()->json([
                'error_code' => 401,
                'error_message' => 'Email exist',
            ]);
        }
        if(!$user->save()) {
            throw new HttpException(500);
        }
        $token = $JWTAuth->fromUser($user);
        if(!Config::get('boilerplate.sign_up.release_token')) {
            return response()->json([
                'status' => 'success',
                'token' => $token,
                'data' => $user
            ], 201);
        }


        return response()->json([
            'status' => 'success',
            'token' => $token,
            'data' => $user
        ], 201);
    }


    public function refresh()
    {
        $token = Auth::guard()->refresh();

        return response()->json([
            'status' => 'ok',
            'token' => $token,
            'expires_in' => Auth::guard()->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        Auth::guard()->logout();

        return response()
            ->json(['message' => 'Successfully logged out']);
    }

}
