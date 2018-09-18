<?php

namespace Adtech\Core\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JsonRequest extends FormRequest
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
                    'json_id' => 'required'
                ];
            }
            case 'POST': {
                return [
                    'domain_id' => 'required|numeric',
                    'name' => 'required',
                    'path' => 'required|unique:mysql_core.adtech_core_json,path'
                ];
            }
            case 'PUT':{
                return [
                    'domain_id' => 'required|numeric',
                    'json_id' => 'required',
                    'name' => 'required'
                ];
            }
            case 'PATCH':
            default:
                break;
        }
    }
}
