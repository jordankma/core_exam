<?php

namespace Contest\Contestmanage\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
                    'config_id' => 'required'
                ];
            }
            case 'POST': {
                return [
                    'environment' => 'required',
                    'type' => 'required',
                    'description' => 'required',
                    'name' => 'required'
                ];
            }
            case 'PUT':{
                return [
                    'environment' => 'required',
                    'type' => 'required',
                    'description' => 'required',
                    'name' => 'required'
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
            'code.required'  => 'Định danh không được để trống',
            'description.required'  => 'Mô tả không được để trống',
            'items_type.required'  => 'Hãy chọn loại item',
            'html_type.required'  => 'Loại html không được để trống',
            'varible.required'  => 'Tên biến không được để trống',
        ];
    }
}
