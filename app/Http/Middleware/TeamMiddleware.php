<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamMiddleware
{
    static Team $team;

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $teams = $request->user()->teams->keyBy('id')->select('name');
        $teamIdRequest = $request->header('team_id');
        if (!$teams->has($teamIdRequest)) {
            abort(403, 'Unauthorized team');
        }

        self::$team = Team::find($teamIdRequest);

        return $next($request);
    }
}
