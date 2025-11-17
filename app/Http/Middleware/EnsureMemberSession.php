<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMemberSession
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('member_id')) {
            return redirect()
                ->route('universityMemberLogin')
                ->with('auth_error', 'Please sign in to continue.');
        }

        return $next($request);
    }
}
