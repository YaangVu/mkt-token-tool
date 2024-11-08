<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function clientSignIn(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::whereUsername($request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'code' => 401,
                'message' => 'Invalid credentials',
                'serviceTime' => Carbon::now()->toDateTimeString(),
            ], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'code' => 200,
            'data' => [
                'username' => $user->username,
                'token' => $token,
                'teams' => $user->teams->select(['id','name']),
                'childStatus' => 0, // Example value, adjust as needed
                'versions' => "1.0", // Example value, adjust as needed
            ],
            'message' => 'Login successful',
            'serviceTime' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
