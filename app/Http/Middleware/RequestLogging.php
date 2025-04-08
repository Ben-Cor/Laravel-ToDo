<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestLogging
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->getStatusCode() === 404) {
            Log::info('404', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
            ]);
        } else {
            Log::channel('requests')->info('Requests', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
            ]);
        }

        return $response;
    }
}
