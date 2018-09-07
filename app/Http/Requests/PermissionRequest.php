<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
        return [
            'name' => 'required',
            'label' => 'required|string',
            'is_category' => 'integer'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '路由名',
            'label' => '权限名称',
            'is_category' => '是否为菜单属性'
        ];
    }
}
