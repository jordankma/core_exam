<?php

namespace Contest\Contestmanage\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
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
                    'topic_id' => 'required'
                ];
            }
            case 'POST': {
                return [
                    'description' => 'required',
                    'name' => 'required',
                    'number' => 'required|numeric|min:1',
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'end_notify' => 'required',
                    'type' => 'required',
                    'round_id' => 'required',
                    'exam_repeat_time' => 'required|numeric|min:0'
                ];
            }
            case 'PUT':{
                return [
                    'description' => 'required',
                    'name' => 'required',
                    'number' => 'required|numeric|min:1',
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'end_notify' => 'required',
                    'type' => 'required',
                    'round_id' => 'required',
                    'exam_repeat_time' => 'required|numeric|min:0'
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
            'end_notify.required'  => 'Thông báo không được để trống',
        ];
    }
}
