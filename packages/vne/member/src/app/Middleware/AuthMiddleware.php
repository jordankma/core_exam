<?php

namespace Vne\Member\App\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class AuthMiddleware
{
    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('member')->check() == false) {
            if ($request->ajax()) {
                $response = [
                    'status' => 'NOT_LOGIN',
                    'message' => 'Unauthorized'
                ];
                return response(json_encode($response), 401);
            } else {
                return redirect()->guest(route('dhcd.member.auth.login'));
            }
        }

        return $next($request);
    }
}