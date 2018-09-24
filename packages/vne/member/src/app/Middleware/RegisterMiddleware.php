<?php

namespace Vne\Member\App\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class CheckRegister
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('member')->user()->is_reg == 0) {
            return '2';
        }
        return $next($request);
    }

}