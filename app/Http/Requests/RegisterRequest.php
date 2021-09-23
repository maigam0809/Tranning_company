<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'last_name' =>'required|string|min:3',
            'first_name' =>'required|string|min:2',
            'name' =>'required|string|min:2',
            'email' =>'required|email|unique:users,email',
            'password' =>'required|min:8|max:50',
            'passwordAgain'=>'required|same:password',

        ];
    }

    public function messages(){
        return [
            'required' =>':attribute không được để trống.',
            'min:3' => ':attribute tối thiểu là 3 ký tự.',
            'min:2' => ':attribute tối thiểu là 2 ký tự.',
            'email' => ':attribute không đúng dạng email.',
            'unique' => ':attribute đã được sử dụng.',
            'same' =>  ':attribute không khớp',
            'regex' =>  ':attribute nhập không đúng',
            'string' =>  ':attribute phải là chữ.',

        ];
    }

    public function attributes(){
        return [
            'last_name' =>"Họ",
            'first_name' =>"Tên ",
            'name' =>"Tên đăng nhập",
            'email' =>"Email",
            'password' =>"Password",
            'passwordAgain' =>"Nhập lại password",
        ];
    }
}
