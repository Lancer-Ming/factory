<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        switch($this->method()) {
            case 'POST':
                return [
                    'username' => 'required|string'
                ];
                break;
            case 'PATCH':
                $uri = $this->getRequestUri();
                $role_id = explode('/', $uri)[2];
                return [
                    'username' => 'unique:roles,name,'.$role_id
                ];
                break;
        }
        return [
            //
        ];
    }
}
