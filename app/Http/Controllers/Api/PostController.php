<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Cache;
use App\Traits\TraitResponse;

class PostController extends Controller
{
    use TraitResponse;
    public function index(Request $request) {

        $posts = Cache::tags(['listPosts'])

        ->remember('posts::'.$request->page, 24*60*60, function () {
            return Post::simplePaginate(15);
        });

        return $this->responseApi(
            [
                'success' => true,
                'data'=> PostResource::collection($posts),
                'message'=>'Lấy danh sách dữ liệu thành công'
            ],200
        );
    }

    public function show($post_id){

        $post = Cache::tags(['postOne'])
        ->rememberForever('post::'.$post_id, function () use($post_id) {
            return Post::find($post_id);
        });
        

        if($post != null) {
            return $this->responseApi(
                [
                    'success' => true,
                    'data' => new PostResource($post),
                    'message'=>'Lấy dữ liệu thành công'
                ]);
        }else{
            return $this->responseApi(
                [
                    'success' => false,
                    'message'=>'Dữ liệu này không tồn tại ở bảng này.'
                ],401);
        }

    }

    public function store(Request $request){
        $data = $request->except('_token');
        $result = Post::create($data);

        return $this->responseApi(
            [
                'success' => true,
                'data' => new PostResource($result),
                'message'=>'Thêm dữ liệu thành công'
            ],201
        );
    }

    public function update(Request $request, Post $post) {
        $data = request()->all();
        $post->update($data);
        Cache::forget('post::'.$post->id);

        return $this->responseApi([
            'success' => true,
            'data' =>new PostResource($post),
            'message'=>'Sửa dữ liệu thành công'
        ],200);
    }

    public function update1(Request $request,Post $post) {
        // dd($post);
        $inputs = $request->only(
            'title',
            'content',
            'slug',
            'user_id',
        );

        $post->fill($inputs);
        $post->update();

        Cache::forget('post::'.$post->id);
        return $this->responseApi([
            'success' => true,
            'data' =>  new PostResource($post),
            'message'=>'Sửa dữ liệu thành công'
        ],200
          
        );
    }

    public function delete(Post $post){
        Cache::forget('post::'.$post->id);
        $post->delete();
        return $this->responseApi(
            [
                'success' => true,
                'data' => "Dữ liệu đã được xoá",
                'message' => 'Xoá thành công'
            ],200
        );
    }
}
