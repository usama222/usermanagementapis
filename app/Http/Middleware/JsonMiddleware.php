<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class JsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Accept');
        if ($header != 'application/json') {
            return response()->error('Bad Request', "Invalid `Accept` header", '1.0',  400);
        }
        if (!$request->isMethod('post')) return $next($request);
        $header = $request->header('Content-type');
        if (!Str::contains($header, 'application/json')) {
            return response()->error('Unsupported Media Type', "Invalid `Content-Type` header", '1.0',  415);
        }
        return $next($request);
    }
}
