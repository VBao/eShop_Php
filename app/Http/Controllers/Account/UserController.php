<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account\ListUserResource;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->only('name', 'email', 'password', 'address', 'phone','gender');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6|max:50',
            'address' => 'required|string',
            'phone' => 'required|string|min:10|max:10',
            'gender'=>'required|boolean'
        ]);

        if ($validator->fails()) return response()->json(['error' => $validator->messages()], 400);
//        error_log($request->gender);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'is_admin' => 0,
            'created_at' => now()
        ]);
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => User::where('email', '=', $request->email)->first()
        ], Response::HTTP_OK);
    }


    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);
        if ($validator->fails()) return response()->json(['status' => $validator->messages()], 200);
        try {
            if (!$token = Auth::attempt($credentials)) {
                return response()->json([
                    'success' => 'failed',
                    'message' => 'Login credentials invalid'
                ], 400);
            }
        } catch (Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }
        //Token created, return with success response and jwt token
        return response()->json([
            'success' => 'success',
            'token' => $token,
            'info' => ['name' => \Auth::user()->name,
                'email' => \Auth::user()->email,
                'phone' => \Auth::user()->phone,
                'address' => \Auth::user()->address,
                'admin' => \Auth::user()->is_admin
            ]
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
//        Validated do logout
        error_log($request->bearerToken());
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $ex) {
            return response()->json(['error' => $ex->getMessage(), 'message' => 'Sorry we can\'t logout'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['success']);
    }

    /**
     * @throws ValidationException
     */
    public function get_user(Request $request): JsonResponse
    {
        $validator = Validator::validate($request, ['token' => 'required']);
        $user = JWTAuth::authenticate(JWTAuth::getToken());
        return response()->json(['user' => $user,]);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $data = $request->only('new_password');
        $validator = Validator::make($data,
            [
                'new_password' => 'string|min:6|max:50'
            ]);
        if (!(isset($request->current_password) && isset($request->new_password))) return response()->json(['error' => 'Missing current or new password'], 422);
        $auth = Auth::user();
        $user = User::find($auth->id);
        if (!password_verify($request->current_password, $user->password)) return response()->json(['error' => 'failed to confirm current password'], 422);
        if ($validator->fails()) return \response()->json(['error' => $validator->messages()], 400);
        $user->password = bcrypt($request->password);
        $user->save();
        return \response()->json(['status' => 'success']);
    }

    public function forgetPassword(Request $request): JsonResponse
    {
        $usr = User::where('email', '=', $request->query('email'))->first();
        if ($usr == null) return \response()->json(['error' => 'Not found any user with provided mail'], 400);
        Password::sendResetLink(['email' => $usr->email]);
        return \response()->json(['result' => 'Reset email has been sent']);
    }

    public function resetPassword(Request $request): JsonResponse
    {
//        TODO validate token
        $validator = Validator::make($request->only('password', 'token'), [
            'password' => 'required|min:6|max:50',
            'token' => 'required|string'
        ]);
        if ($validator->fails()) return response()->json(['error' => $validator->messages()], 200);

        \Password::reset($request->only('email', 'password', 'token'), function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ]);
            $user->updated_at = now();
            $user->save();
        });
        return \response()->json(['result' => 'Password change successful'], 200);
    }

    public function users(): JsonResponse
    {
        return \response()->json(['data' => [
            'user' => ListUserResource::collection(User::query()->where('is_admin', '=', 0)->get()),
            'admin' => ListUserResource::collection(User::query()->where('is_admin', '=', 1)->get())
        ]]);
    }

    public function createAdmin(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only('name', 'email', 'password', 'phone', 'address'),
            [
                'name' => 'required|string|min:6',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:10|max:50',
                'phone' => 'required|string|min:1o|max:10',
                'address' => 'required|string|min:15'
            ]);
        if ($validator->fails()) return response()->json(['error' => $validator->messages()], 400);
        $user = User::create(array_merge($request->only('name', 'email', 'phone', 'address'), ['password' => bcrypt($request->password), 'created_at' => now()]));
        $user->is_admin = 1;
        $user->save();
        return \response()->json(array_merge(['result' => 'Create success'], $user->only('name', 'email')), 200);
    }

    public function updateInfo(Request $request)
    {
        $msg = [];
        $user = Auth::user();
        try {
            foreach ($request->data as $key => $value) {
                if (strcmp($key, 'password') == 0) {
                    $msg['warning'] = 'Please update password separately';
                    continue;
                }
                $user->$key = $value;
            }
            $user->save();
            $msg['result'] = 'updated';
        } catch (QueryException $e) {
            if ($e->getCode() == "42S22")
                return \response()->json(['error' => "Please re-check all key in json"], 400);
        }
        return \response()->json($msg, 200);
    }
}
