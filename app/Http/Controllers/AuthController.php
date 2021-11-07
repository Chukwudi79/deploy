<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:8|min:6',
            'confirmpassword' => 'required|same:password',
            'avatar' => 'nullable|mimes:jpeg,png|max:50',
        ];
        $this->validate($request, $rules);
        $user = new User;

        if($request->hasFile('avatar')){
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $upload = 'avatar-' . rand(time(), 9999999) . '.' . $extension;
            $avatar = $request->file('avatar')->storeAs('public/profile', $upload);

            $user->avatar = $avatar;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 2; //Company Role is represented as 2 while Admin will be 1
        $user->save();

        $user->avatar = (!empty($user->avatar)) ? env('APP_URL') . Storage::disk('local')->url($user->avatar) : $user->avatar; //Forward write user avatar url

        return response()->json(['status' => 'success', 'message' => 'User Created Successfully!', 'data' => $user], 200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token
        ]);
    }
}
