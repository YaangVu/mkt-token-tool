<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TeamMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $teams = $request->user()->teams->keyBy('id')->select('name');
        $teamIdRequest = $request->header('team_id');
        Log::info("All headers: ", $request->header());
        Log::info("TeamMiddleware: team_id=$teamIdRequest, current user has teams: ", $teams->all());
        if (!$teams->has($teamIdRequest)) {
            abort(403, 'Unauthorized team');
        }

        // Set tenant team for current user by team_id
        Filament::setTenant(Team::find($teamIdRequest), true);
        setPermissionsTeamId($teamIdRequest);

        return $next($request);
    }
}
