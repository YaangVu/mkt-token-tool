<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller
{
    public function signIn(Request $request)
    {
        $request->validate([
            'account' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = Client::whereUsername($request->account)->first();

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
                'account' => $user->email,
                'token' => $token,
                'childStatus' => 0, // Example value, adjust as needed
                'versions' => "1.0", // Example value, adjust as needed
            ],
            'message' => 'Login successful',
            'serviceTime' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
