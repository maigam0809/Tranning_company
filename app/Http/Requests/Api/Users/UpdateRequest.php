<?php

namespace App\Http\Requests\Api\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'first_name' =>'required',
            'last_name' =>'required',
            'email' =>[
                'required',
                'email',
                new RuleEmailUnique(),
            ],
            'address' =>'required|min:8',
            'role'=>'required|in:' . implode(',',config('common.users.role')),
            'gender'=>'required|in:' . implode(',',config('common.users.gender')),
            'image1' => 'image|max:2048',
            'birthday' => 'required',
        ];
    }

    public function messages(){
        return [
            'required' =>':attribute không được để trống',
            'in' => ':attribute giá trị không đúng',
            'email' => ':attribute không đúng dạng email.',
            'unique' => ':attribute đã tồn tại.',
            'max:2048' => ':atribute có size nhỏ hơn 2MB',
            'mimes'=>':attribute phải là ảnh dạng jpeg,png'
        ];
    }

    public function attributes(){
        return [
            'last_name' =>"Họ",
            'first_name' =>"Tên ",
            'email' =>"Email",
            'address' =>"Address",
            'role' =>"Tài khoản",
            'gender' =>"Giới tính",
            'image1' =>"Ảnh",
            'birthday' =>"Ngày sinh",
        ];
    }
}
