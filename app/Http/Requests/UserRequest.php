<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class UserRequest extends FormRequest
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
        $uri = $this->getRequestUri();
        $user_id = explode('/', $uri)[2];
        switch($this->method()) {
            case "POST":
                return [
                    'username' => 'required|between:1,10|unique:users',
                    'realname' => 'required|between:1,10',
                    'sex' => 'required|integer',
                    'email' => 'email|required',
                    'role_id' => 'required',
                    'password' => 'required|between:6,20'
                ];
                break;
            case "PATCH":
                return [
                    'username' => 'required|between:1,10|unique:users,username,'.$user_id,
                    'realname' => 'required|between:1,10',
                    'sex' => 'required|integer',
                    'email' => 'email|required',
                    'role_id' => 'required',
                    'password' => 'required|between:6,20'
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'role_id' => '用户角色'
        ];
    }
}
