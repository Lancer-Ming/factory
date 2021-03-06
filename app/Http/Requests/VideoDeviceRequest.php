<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoDeviceRequest extends FormRequest
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
            'd_name' => 'required|max:60',
            'appkey' => 'required',
            'channel_no' => 'required',
            'secret' => 'required',
            'validate_code' => 'required'
        ];
    }
}
