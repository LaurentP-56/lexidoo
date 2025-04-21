<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NonGar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->provider === 'gar') {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Cette fonctionnalité n\'est pas disponible pour les utilisateurs GAR.'], 403);
            }
            
            return redirect()->route('dashboard')->with('error', 'Cette fonctionnalité n\'est pas disponible pour les utilisateurs GAR.');
        }

        return $next($request);
    }
} 