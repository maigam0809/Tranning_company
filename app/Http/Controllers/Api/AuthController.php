<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

use App\Traits\TraitResponse;

class AuthController extends Controller
{
    use TraitResponse;
    public function __construct() {
        // chỉ cần dùng ở 1 chỗ thôi.
        // 1 là dùng trong đây 2 là dùng ngoài file api.php
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return $this->responseApi($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return $this->responseApi([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);

    }

    public function changePassword(Request $request) {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return $this->responseApi($validator->errors()->toJson(), 400);
        }
        
        $userId = auth()->user()->id;

        $user = User::where('id',$userId)->update(
                    ['password' => bcrypt($request->new_password)]
                );

        return $this->responseApi([
            'message' => 'Đổi mật khẩu thành công',
            'user' => $user
        ], 201);
    }

    public function login(Request $request){
        
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            // 'avatar' => 'required',
            // 'password' => 'required|string|min:6',
            // 'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->responseApi($validator->errors(), 422);
        }

        $credentials = $validator->validated();
        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return $this->responseApi(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }


    public function logout() {
        auth()->logout();
        return $this->responseApi(['message' => 'Logout thành công']);
    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    public function userProfile() {
        //https://jwt-auth.readthedocs.io/en/develop/auth-guard/

        // nhớ mấy cái auth() phải là auth('api') nhé. như thế thì nó mới lấy user từ token được
        return $this->responseApi(auth('api')->user());
    }

    protected function createNewToken($token){
        return $this->responseApi([
            'access_token' => $token,
            'token_type' => 'bearer',
            // cai này tý e tìm hiểu sau nhs
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
}
