<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
//use Tymon\JWTAuth\Facades\JWTAuth;


class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) return response()->json(['error' => $validator->messages()], 200);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'date' => $data
        ], Response::HTTP_OK);
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) return response()->json(['status' => $validator->messages()], 200);

        try {
            if (!$token =Auth::attempt($credentials)) {
                return response()->json([
                    'success' => 'failed',
                    'message' => 'Login credentials invalid'
                ], 400);
            }
        } catch (Exception $ex) {
//            return $credentials;
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);


        }
//Token created, return with success response and jwt token
        return response()->json([
            'success' => 'success',
            'token' => $token
        ]);
    }

    public function logout(Request $request){
//        Validate token
        $validator = Validator::make($request,[
            'token' => 'required'
        ]);
        if ($validator->fails()) return response()->json(['error' => $validator->messages()],200);

//        Validated do logout
        try {
            JWTAuth::invalidate($request->token);
            return response()->json(['success']);
        }catch (JWTException $ex){
            return response()->json(['error' => false, 'message'=>'Sorry we can\'t logout'],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_user(Request $request){
        $validator = Validator::validate($request,['token'=>'required']);
//        $user = JWTAuth::authenticate($request->token);
        $user = (new JWTAuth)->authenticate($request->token);
        return response()->json(['user'=>$user,]);
    }
}
