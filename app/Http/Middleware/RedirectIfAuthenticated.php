<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Nếu có URL trước đó (referer) và không phải là trang login/register, quay về đó
                $previous = url()->previous();

                // Nếu là trang login hoặc register thì mới chuyển hướng riêng theo role
                if (str_contains($previous, '/login') || str_contains($previous, '/register')) {
                    $user = Auth::user();

                    if ($user->role_id == 1) {
                        return redirect()->route('admin.dashboard');
                    }

                    return redirect()->route('user.homepage');
                }

                // ✅ Nếu không thì quay lại trang trước đó
                return redirect($previous);
            }
        }

        return $next($request);
    }
}
