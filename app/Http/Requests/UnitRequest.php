<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
            case "DELETE":
                return [
                    'id' => 'required|Array',
                    'page' => 'required'
                ];
                break;
            default:
                return [
                    'name' => 'required',
                    'unit_no' => 'required'
                ];
            break;
        }


    }

    public function attributes()
    {
        return [
            'name' => '企业名',
            'unit_no' => '单位机构代码',
            'page' => '页码'
        ];
    }
}
