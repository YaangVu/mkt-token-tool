<?php

namespace App\Http\Controllers;

use App\Constants\DefaultRoles;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
                'teams' => $user->teams->select(['id', 'name']),
                'childStatus' => 0, // Example value, adjust as needed
                'versions' => "1.0", // Example value, adjust as needed
            ],
            'message' => 'Login successful',
            'serviceTime' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public function clientSignUp(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'deposit' => 'required|numeric|min:0',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Log the validated data
        Log::info('Validated Data:', $validatedData);

        $name = Str::ucfirst($request->username);

        /**
         * Create a new User
         * @var User $user
         */
        $user = User::create([
            'username' => $request->username,
            'name' => $name,
            'password' => Hash::make($request->password),
        ]);

        /**
         * Create a Team for the new User and assign the User as the Team's owner
         * @var Team $team
         */
        $team = Team::create([
            'name' => "$name's Team",
            'created_by' => $user->id,
            'coin_requested' => $request->deposit,
        ]);

        $roleId = Role::whereName(DefaultRoles::TEAM_ADMIN)->first()->id;

        // Assign the User to the Team
        $user->teams()->attach($team->id, ['role_id' => $roleId]);

        // Assign the User the Team Admin role
        $user->roles()->attach($roleId, ['team_id' => $team->id]);

        Auth::login($user);

        return redirect('/admin');
    }
}
