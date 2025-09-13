<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    // Register API - name, email, password and password_confirmation
    public function register(Request $request) {

        $request->validate([
            "name"=> "required|string",
            "email"=> "required|email|unique:users,email",
            "password"=> "required|confirmed",
        ]);

        User::create(attributes: $request->all());

        return response()->json([
            "status" => true,
            "message"=> "User Registered Successfully"
        ]);
    }

    // Login API
    public function login(Request $request) {

        $request->validate([
            "name"=> "required|string",
            "email"=> "required|email|unique:users,email",
            "password"=> "required|confirmed",
        ]);

        // user check email
        $user = User::Where("email", $request->email) ->first();

        if (!empty($user)) {

            // check password
            if(Hash::check($request->password, $user->password)) {
                $token = $user->createToken("myToken")->plainTextToken;

                return response()->json([
                    "status" => true,
                    "message"=> "User Logged In Successfully",
                    "token" => $token,
                ]);
            } else {
                return response()->json([
                    "status"=> false,
                    "message"=> "Password does not match",
                ]);
            }
        } else {
            return response()->json([
                "status"=> false,
                "message"=> "Email does not exist",
            ]);
        }
    }

    // Profile API
    public function profile() {

    }

    // Logout API
    public function logout() {

    }
    
}
