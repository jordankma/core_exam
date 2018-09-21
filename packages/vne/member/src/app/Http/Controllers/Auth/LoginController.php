<?php

namespace Vne\Member\App\Http\Controllers\Auth;

use Adtech\Application\Cms\Controllers\MController as Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    private function _guard()
    {
        return Auth::guard('member');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function _authenticate(Request $request)
    {
        $routePrefix = $request->route()->getPrefix();
        $u_name = $request->input('u_name');
        $password = $request->input('password');
        $remember = $request->input('remember', false);
        if ($this->_guard()->attempt(['u_name' => $u_name, 'password' => $password], $remember)) {
            $request->session()->regenerateToken();
            shell_exec('cd ../ && /egserver/php/bin/php artisan view:clear');
            \Session::flash('flash_messenger', trans('adtech-core::messages.login_success'));
            $routeName = 'frontend.homepage';
            return redirect()->intended(route($routeName));
        } else {
            $request->session()->regenerateToken();
            \Session::flash('flash_messenger', trans('adtech-core::messages.login_failed'));
            return redirect()->back()
                ->withInput($request->only('u_name'))
                ->withErrors([
                    'inputUname' => trans('adtech-core::messages.login_failed'),
                    'inputPassword' => trans('adtech-core::messages.login_failed')
                ]);
        }

        return null;
    }

    public function login(Request $request)
    {
        if ($this->user) {
            $routeName = 'frontend.homepage';
            return redirect()->intended(route($routeName));
        }

        if ($request->isMethod('post')) {
            return $this->_authenticate($request);
        }

        return view('VNE-MEMBER::modules.member.auth.login');
    }

    public function logout(Request $request)
    {
        $this->_guard()->logout();

        $request->session()->flush();

        //$request->session()->regenerate();

        \Session::flash('flash_messenger', trans('adtech-core::messages.logout_success'));

        return redirect(route('vne.member.auth.login'));
    }
}
