<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InactivityTimeoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            $timeout = 7200; // 2 hours in seconds
            $lastActivity = session('last_activity');

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                \Illuminate\Support\Facades\Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('status', 'Your session timed out due to inactivity. Please log in again.');
            }

            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}
