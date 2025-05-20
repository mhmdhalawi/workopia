<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();


            // Authentication passed...
            return response()->json([
                'message' => 'Login successful',
                'user' => Auth::user(),
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // hash the password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // check if request is coming from admin or market
        if ($request->is('api/admin/*')) {
            $validatedData['is_admin'] = true;
        }

        // Create the user
        $user = User::create($validatedData);


        // Optionally, you can return a response 
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    public function logout()
    {
        Auth::logout();
        // session()->flush();
        // Optionally, you can return a response
        return response()->json([
            'message' => 'Logout successful',
        ]);
    }
}
