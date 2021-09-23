<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

use App\Http\Requests\Api\Users\StoreRequest;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Traits\TraitResponse;

class UserController extends Controller
{
    use TraitResponse;

    public function index(Request $request) {

        $users = Cache::tags(['listUsers'])
        ->remember('users::'.$request->page, 24*60*60, function () {
            return User::simplePaginate(15);
        });

        try {
            if(is_null($users)){

                return $this->responseApi([
                    'success' => false,
                    'data' => $users,
                    'message' => 'Data is not avaiable'
                ],404);

            }else{

                return $this->responseApi(
                    [
                        'success' => true,
                        'data'=> UserResource::collection($users),
                        'message'=>'Lấy dữ liệu thành công'
                    ]
                );
            }

        } catch (\Exception $e) {

            return $this->responseApi(
                [
                    'message'=>$e->getMessage(),
                    'success' => false,
                ]
    
            ,406);

        }

    }

    public function show($user_id){

        $user = Cache::tags(['userOne'])
        ->rememberForever('user::'.$user_id, function () use($user_id) {
            return User::find($user_id);
        });


        if(is_null($user)){

            return $this->responseApi([
                'success' => true,
                'data' => $user,
                'message' => 'Data is not avaiable'
            ],404);

        }else{
            return $this->responseApi(
                [
                    'success' => false,
                    'data' =>  new UserResource($user),
            ],200);
        }

      
       
    }

    
    public function store(StoreRequest $request){

        try {
            $data = $request->all();
            $result = User::create($data);

            return $this->responseApi([
                'success' => true,
                'data' => new UserResource($result),
                'message'=>'Thêm dữ liệu thành công'
            ],201);

        } catch (\Exception $e) {

            return $this->responseApi(
                [
                    'success' => false,
                    'message'=>$e->getMessage()
                ]
            ,406);
        }
    }

    public function update(Request $request, $user_id) {

        $user = auth('api')->user();


        if($user->id !==$user_id) {
            // show loi

        }

        $inputs = $request->only(
            'name',
            'first_name',
            'last_name',
            'email',
            'avatar',
        );

        $user->fill($inputs);

        if(is_null($user)){
            
            return $this->responseApi([
                'success' => false,
                'data' => $user,
                'message' => 'Data is not avaiable'
            ],404);
            
        }else{
            $user->save();

            Cache::forget('user::'.$user->id);
            return $this->responseApi([
                'success' => true,
                'data' =>new UserResource($user),
                'message'=>'Sửa dữ liệu thành công'
            ],200);
        }
    }
    
    public function update2(Request $request, User $user) {
        try {
            $inputs = $request->only(
                'name',
                'first_name',
                'last_name',
                'email',
                'avatar',
            );
            $user->fill($inputs);
            $user->update();
            if(is_null($user)){

                return $this->responseApi([
                    'success' => false,
                    'data' => $user,
                    'message' => 'Data is not avaiable'
                ],404);

            }else{

                Cache::forget('user::'.$user->id);
        
                return $this->responseApi([
                    'success' => true,
                    'data' =>new UserResource($user),
                    'message'=>'Sửa dữ liệu thành công'
                ]);
            }

        } catch (\Exception $e) {
            return $this->responseApi(
                [
                    'success' => false,
                    'message'=>$e->getMessage()
                ]
            ,406);
        }
        
    }

    public function update1(Request $request, User $user) {
        $data = request()->except('_token');
        $user->update($data);

        Cache::forget('user::'.$user->id);

        return $this->responseApi([
            'success' => true,
            'data' =>new UserResource($user),
            'message'=>'Sửa dữ liệu thành công'
        ]);
    }

    public function delete(User $user){
        try {
            if(is_null($user)){

                return $this->responseApi([
                    'message' => 'Data is not avaiable'
                ],404);
            }else{
                Cache::forget('user::'.$user->id);
                $user->delete();
                return  $this->responseApi(
                    [
                        'success' => true,
                        'message' => 'Xoa thanh cong'
                    ],200
                );
            }
        } catch (\Exception $e) {
            return $this->responseApi(
                [
                    'success' => false,
                    'message'=>$e->getMessage()
                ]
    
            ,406);
        }
    }
}
