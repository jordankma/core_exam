<?php

namespace Adtech\Core\App\Http\Controllers\Auth;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Validator, Auth;

class LoginController extends Controller
{
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    private function _guard()
    {
        return Auth::guard('web');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function _authenticate(Request $request)
    {
        $count_login = 0;
        if ($request->session()->has('count_login')) {
            $count_login = $request->session()->get('count_login');
        }

        $validator = Validator::make($request->all(), [
            'g-recaptcha-response'=>'required|recaptcha',
        ]);
        if (!$validator->fails() || $count_login < 5) {

            $routePrefix = $request->route()->getPrefix();
            $email = $request->input('email');
            $password = $request->input('password');
            $remember = $request->input('remember', false);
            if ($this->_guard()->attempt(['email' => $email, 'password' => $password], $remember)) {
                $request->session()->regenerateToken();
                $request->session()->forget('count_login');
                \Session::flash('flash_messenger', trans('adtech-core::messages.login_success'));
                $routeName = $routePrefix == config('site.admin_prefix') ? 'backend.homepage' : 'frontend.homepage';
                return redirect()->intended(route($routeName));
            }
        }

        if ($request->session()->has('count_login')) {
            $request->session()->put('count_login', $request->session()->get('count_login') + 1);
        } else {
            $request->session()->put('count_login', 1);
        }
        $request->session()->regenerateToken();
        \Session::flash('flash_messenger', trans('adtech-core::messages.login_failed'));
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'inputEmail' => trans('adtech-core::messages.login_failed'),
                'inputPassword' => trans('adtech-core::messages.login_failed')
            ]);
    }

    public function login(Request $request)
    {
        if ($this->user) {
            $routeName = 'backend.homepage';
            return redirect()->intended(route($routeName));
        }

        if ($request->isMethod('post')) {
            return $this->_authenticate($request);
        }

        return view('ADTECH-CORE::modules.core.auth.login');
    }

    public function logout(Request $request)
    {
        $this->_guard()->logout();

//        $request->session()->flush();

        //$request->session()->regenerate();

        \Session::flash('flash_messenger', trans('adtech-core::messages.logout_success'));

        return redirect(route('adtech.core.auth.login'));
    }
}
