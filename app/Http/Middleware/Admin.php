<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Auth::guard('admin');
        if (!$guard->check()) {
            return redirect()->route('admin.login');
        }

        $admin = $guard->user();
        if (!$admin || (int)$admin->status !== 1) {
            $guard->logout();
            if ($request->ajax()) {
                return response()->json(['message' => 'Account is inactive.'], 403);
            }
            return redirect()
                ->route('admin.login')
                ->with('error_message', 'Your account has been deactivated. Please contact your administrator.');
        }

        return $next($request);
    }
}
