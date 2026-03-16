<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $userRole = $user->role ?? 'worker';

        // Check if user has required role
        if (!empty($roles)) {
            if (!in_array($userRole, $roles)) {
                // Redirect based on role
                if ($userRole === 'worker') {
                    return redirect()->route('worker.dashboard');
                }
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
