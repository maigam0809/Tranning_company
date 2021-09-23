<?php

namespace App\Http\Requests\Api\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use  App\Http\Requests\Api\BaseApiRequest;

class StoreRequest extends FormRequest
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
            // 'address' =>'required|min:8|regex:/([- ,\/0-9a-zA-Z]+)/',
            // 'role'=>'required|in:' . implode(',',config('common.users.role')),
            // 'gender'=>'required|in:' . implode(',',config('common.users.gender')),
            // 'avatar' => 'required',
            // 'birthday' => 'required',
        ];
    }

    public function messages(){
        return [
            'required' =>':attribute không được để trống.',
            'max' => ':attribute tối đa gồm 50 ký tự.',
            'min:3' => ':attribute tối thiểu là 3 ký tự.',
            'min:2' => ':attribute tối thiểu là 2 ký tự.',
            // 'in' => ':attribute giá trị không đúng.',
            'email' => ':attribute không đúng dạng email.',
            'unique' => ':attribute đã tồn tại.',
            // 'max:2048' => ':atribute có size nhỏ hơn 2MB',
            // 'avatar'=>':attribute phải là ảnh dạng ảnh.'

        ];
    }

    public function attributes(){
        return [
            'last_name' =>"Họ",
            'first_name' =>"Tên ",
            'name' =>"Họ và tên đầy đủ ",
            'email' =>"Email",
            'password' =>"Password",
            // 'address' =>"Address",
            // 'role' =>"Tài khoản",
            // 'gender' =>"Giới tính",
            // 'avatar' =>"Ảnh",
            // 'birthday' =>"Ngày sinh",

        ];
    }
}
