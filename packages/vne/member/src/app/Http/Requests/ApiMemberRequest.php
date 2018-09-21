<?php

namespace Vne\Member\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiMemberRequest extends FormRequest
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
            case 'GET':{
                return [
                       
                ];
            }
            case 'DELETE': {
                return [
                    
                ];
            }
            case 'POST': {
                return [
                    'token' => 'required'    
                ];
            }
            case 'PUT':{
                return [
                    'token' => 'required'    
                ];
            }
            case 'PATCH':
            default:
                break;
        }
    }
}
