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
            $member = Member::where('u_name',$u_name)->first();
            $time = time();
            $member->token = md5($u_name.$password.$time); 
            $member->expire_token = $time; 
            $member->is_login = 1; 
            $member->save();
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
        $member = Member::where('u_name',$this->_guard()->user()->u_name)->first();
        $member->is_login  = 0;
        $member->save();

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

    public function verify(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $data['data'] = array();
            $token = $request->input('token');
            $member = Member::where('token',$token)->first();
            if(empty($member)){  
                $data['status'] = false; 
                $data['messeger'] = 'invalid token';
                return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
            } else{
                if($member->is_login == 0 || $member->is_reg == 0 || $member->is_reg == 1){
                    $data['data']['is_login'] = false;
                    $data['status'] = false; 
                    $data['messeger'] = '';     
                }     
                elseif($member->is_login == 1){
                    $data['status'] = true; 
                    $data['messeger'] = '';
                    $data['data']['is_login'] = true;    
                    $data['data']['user_id'] = $member->member_id;    
                }
            }
            return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
        } else {
            return $validator->messages();    
        }
    }

    public function loginApi(Request $request){
        $u_name = $request->input('u_name');
        $password = $request->input('password');
        $data['status'] = false;
        $data['messeger'] = 'Đăng nhập thất bại';
        $ret = Auth::guard('member')->attempt(['u_name' => $u_name, 'password' => $password]);
        if (!empty($ret)) {
            $member = Member::where('u_name',$u_name)->first();
            $time = time();
            $token = md5($u_name.$password.$time);
            $member->token = $token; 
            $member->expire_token = $time; 
            $member->is_login = 1; 
            $member->save();
            $data['status'] = true;
            $data['messeger'] = 'Đăng nhập thành công';
            $data['data']['token'] = $token;
        }
        return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
}
