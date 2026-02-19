<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->isBlocked()) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Your account has been blocked.']);
        }

        $allowed = empty($roles) || in_array($user->role, $roles, true);
        if (!$allowed) {
            abort(403);
        }

        return $next($request);
    }
}
