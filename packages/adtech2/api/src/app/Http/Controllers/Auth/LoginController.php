<?php

namespace Adtech\Api\App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    private function _guard()
    {
        return Auth::guard('api');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['u_name', 'password']);

        if (! $token = $this->_guard()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tokenData = $this->respondWithToken($token);
        $token = json_decode($tokenData->content(), true);

        $member = $this->_guard()->user();
        $data = [
            "data" => [
                "id"  => $member->member_id,
                "avatar" => $member->avatar,
                "u_name" => $member->u_name,
                "email" => $member->email,
                "ten_hien_thi" => $member->name,
                "is_files_main_customers" => true,
                "token" => $token
            ],
            "success" => true,
            "message" => "ok!"
        ];

        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $member = $this->_guard()->user();
        if(!empty($member)){
            $member_info = [
                "id" => $member->member_id,
                "anh_ca_nhan" => $member->avatar,
                "ten_hien_thi" => $member->name,
                "email" => $member->email,
                "so_dien_thoai" => $member->phone,
                "doan_thanh_nien" => $member->don_vi,
                "ngay_vao_dang" => $member->ngay_vao_dang,
                "dan_toc" => $member->dan_toc,
                "chuc_vu" => $member->position,
                "ton_giao" => $member->ton_giao,
                "trinh_do_ly_luan" => $member->trinh_do_ly_luan,
                "trinh_do_chuyen_mon" => $member->trinh_do_chuyen_mon,
                "noi_lam_viec" => $member->address
            ];
            $data = [
                "success" => true,
                "message" => "Lấy thông tin thành công",
                "data" => $member_info
            ];
        } else {
            $data = '{
                    "success" : false,
                    "message" : "token_invalid"
                }';
        }
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->_guard()->logout();

        $data = '{
                    "success" : true,
                    "message" : "Successfully logged out"
                }';

        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $tokenData = $this->respondWithToken($this->_guard()->refresh());
        $token = json_decode($tokenData->content(), true);

        $member = $this->_guard()->user();
        $data = [
            "data" => [
                "id"  => $member->member_id,
                "avatar" => $member->avatar,
                "u_name" => $member->u_name,
                "email" => $member->email,
                "ten_hien_thi" => $member->name,
                "is_files_main_customers" => true,
                "token" => $token
            ],
            "success" => true,
            "message" => "ok!"
        ];

        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->_guard()->factory()->getTTL() * 60
        ]);
    }
}