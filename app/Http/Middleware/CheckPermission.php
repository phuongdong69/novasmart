<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if (!$user->hasPermission($permission)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Bạn không có quyền truy cập tính năng này.',
                    'error' => 'FORBIDDEN'
                ], 403);
            }

            return redirect()->back()->with('error', 'Bạn không có quyền truy cập tính năng này.');
        }

        return $next($request);
    }
}
