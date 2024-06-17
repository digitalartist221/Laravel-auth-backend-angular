<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{   

    /*
    public function register(Request $request)  {
        
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        
         //un jour
         return response()->json(['message' => $user]);

    }

    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))){
            return response([
                "message" => "authentification invalide"
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = Auth::user();

        // Generate JWT token for the user
        $token = $user->createToken('token')->plainTextToken;

        

        // Return the token as JSON response
        $cookie = cookie('jwt', $token, 60*24);
         //un jour
        return response()->json(['message' => $token])->withCookie($cookie);
    }
    //
    public function user()  {
        $user = Auth::user();

        return $user;
    }

    public function logout(Request $request){
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'success'
        ]);
    }*/

    // Register a new user
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token]);
    }

    // Login a user
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['token' => $token]);
    }

    // Get the authenticated user
    public function user()
    {
        return response()->json(Auth::user());
    }

    // Logout a user
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
