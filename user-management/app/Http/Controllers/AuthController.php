<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;                
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|digits:10',
            'dob' => 'required|date',
            'gender' => 'required',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status_code' => 201,
            'message' => 'User registered successfully'
        ]);
    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email','password'))) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'status_code' => 200,
            'message' => 'Login success'
        ]);
    }
}
