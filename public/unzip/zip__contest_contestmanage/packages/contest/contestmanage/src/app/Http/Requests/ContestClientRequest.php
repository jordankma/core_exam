<?php

namespace Contest\Contestmanage\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContestClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [
                    'client_id' => 'required'
                ];
            }
            case 'POST': {
                return [
                    'description' => 'required',
                    'name' => 'required',
                    'environment' => 'required',
                    'height' => 'required|numeric|min:1',
                    'width' => 'required|numeric|min:1',
                ];
            }
            case 'PUT':{
                return [
                    'description' => 'required',
                    'name' => 'required',
                    'environment' => 'required',
                    'height' => 'required|numeric|min:1',
                    'width' => 'required|numeric|min:1',
                ];
            }
            case 'PATCH':
            default:
                break;
        }
    }

    public function messages(){
        return [
            'name.required' => 'Tên không được để trống',
            'description.required'  => 'Mô tả không được để trống',
            'number.required'  => 'Thứ tự không được để trống',
            'number.numeric'  => 'Thứ tự không hợp lệ',
            'number.min'  => 'Thứ tự không hợp lệ',
            'start_date.required'  => 'Ngày bắt đầu không được để trống',
            'end_date.required'  => 'Ngày kết thúc không được để trống',
            'before_start_notify.required'  => 'Thông báo không được để trống',
            'after_end_notify.required'  => 'Thông báo không được để trống',
        ];
    }
}
