<?php

namespace App\Http\Middleware;

use App\Services\PertanyaanLkeStatusService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RefreshLKEStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        app(PertanyaanLkeStatusService::class)->updateAllStatus();

        return $next($request); 
    }
}
