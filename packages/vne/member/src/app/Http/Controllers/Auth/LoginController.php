<?php

namespace Vne\Member\App\Http\Controllers\Auth;

use Adtech\Application\Cms\Controllers\MController as Controller;
use Illuminate\Http\Request;
use Vne\Member\App\Models\Member;
use Auth,Validator,DateTime;

class LoginController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số",
        'phone.regex' =>'Sai định dạng'
    );
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
        $data['status'] = false;
        $data['messeger'] = "Tên tài khoản hoặc mật khẩu sai!!!";
        $routePrefix = $request->route()->getPrefix();
        $u_name = $request->input('u_name');
        $password = $request->input('password');
        $remember = $request->input('remember', false);
        if ($this->_guard()->attempt(['u_name' => $u_name, 'password' => $password], $remember)) {
            
            $request->session()->regenerateToken();
            shell_exec('cd ../ && /egserver/php/bin/php artisan view:clear');
            $data['status'] = true;
            $data['messeger'] = "Đăng nhập thành công";
            return json_encode($data);
        } else {
            $request->session()->regenerateToken();
            return json_encode($data);
        }

        return null;
    }

    public function login(Request $request)
    {
        if ($this->user) {
            $data['status'] = true;
            return json_encode($data);
        }

        if ($request->isMethod('post')) {
            return $this->_authenticate($request);
        }
        $routeName = 'index';
        return redirect()->intended(route($routeName));
    }

    public function logout(Request $request)
    {
        $this->_guard()->logout();

        $request->session()->flush();

        //$request->session()->regenerate();

        \Session::flash('flash_messenger', trans('adtech-core::messages.logout_success'));

        return redirect(route('vne.member.auth.login'));
    }

    public function register(Request $request){
        $data['status'] = false;
        $validator = Validator::make($request->all(), [
            'u_name' => 'required|unique:vne_member,u_name|min:3|max:50',
            'password' => 'required',
            'phone' => 'required|unique:vne_member,phone'
        ], $this->messages);
        if (!$validator->fails()) {
            $member = new Member();
            $member->u_name = $request->input('u_name');
            $member->password = bcrypt($request->input('password'));
            $member->phone = $request->input('phone');
            $member->created_at = new DateTime();
            $member->updated_at = new DateTime();

            
            if($member->save()){
                $u_name = $member->u_name;
                $password = $member->password;
                $remember = '';
                $this->_authenticate($request);
                $data['status'] = true;
                $data['messeger'] = "Đăng ký thành công mời bạn đăng nhập";
            }
            return json_encode($data);
        } else {
            return $validator->messages();
        }
    }
}
