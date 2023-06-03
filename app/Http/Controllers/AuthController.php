<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
     /**
     * @queryParam Registration Method
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('Bearertoken')->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'User Create Successfully',
             'user' => $user,
            'token' => $token
        ], 200);
    }

    /**
     * @queryParam Login Method
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Bearertoken')->accessToken;
            return response()->json([
                'success' => true,
                'message' => 'Login sucessfully',
                'token' => $token
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * @query All User method
     */
    public function userInfo(Request $request)
    {

        $users = DB::table('users')->get();
        return response()->json([
            'sucess' => true,
            'message' => 'Fetch All User List',
            'user' => $users
        ], 200);

    }
}