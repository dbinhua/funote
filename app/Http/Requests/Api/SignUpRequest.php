<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
        switch ($this->method()){
            case 'POST':
                return [
                    'name' => ['required','string'],
                    'email' => ['required','string','email'],
                    'password' => ['required','string']
                ];

            default:
                return [];
        }
    }

    public function messages()
    {
        return [
            'name.required' => '用户名不能为空',
            'email.required' => '邮箱不能为空',
            'password.required' => '密码不能为空',
            'email.email' => '邮箱格式不正确',
        ];
    }
}
