<?php

namespace App\Http\Middleware;

use App\Services\VisitTrackerService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPublicVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->getStatusCode() < 400) {
            VisitTrackerService::trackWebsiteVisit($request);
        }

        return $response;
    }
}
