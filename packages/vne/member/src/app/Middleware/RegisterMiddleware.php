<?php

namespace Vne\Member\App\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class CheckRegister
{
    public function handle($request, Closure $next)
    {
    	if(Auth::guard('member')->check()){
	        if (Auth::guard('member')->user()->is_reg == 0) {
	            return redirect()->route('vne.memberfrontend.show');
            }
            elseif(Auth::guard('member')->user()->is_lock == 1){
                return redirect()->route('vne.member.auth.logout');
            }
        	return $next($request);
    	} else{
    		return redirect()->route('index');		
    	}
    }

}