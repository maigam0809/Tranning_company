<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Cache;

class DemoRedisController extends Controller
{

    public function index() {
        // ko cache
        // $posts = Post::simplePaginate(15);
        // Cache::add('dfasjhf', $posts, $ttl);

        // get ko lưu
        // dd("okok");
        $posts = Cache::get('posts', function () {
            // return Post::simplePaginate(15);
            return Post::simplePaginate(15);
        });

        // dung cache lưu và ko hết hạn
        // $posts = Cache::rememberForever('posts', function () {
        //     return Post::simplePaginate(15);
        // });

        // get tu cache

        // if(Cache::has('post1')) {
        //     $posts = Cache::get('post1');

        //     return \response()->json(
        //         [
        //             'data'=> PostResource::collection($posts)
        //         ]
        //     );
        // } else {
        //     // thông báo ko có cái này hoặc xử lý
        // }
        // $posts = Cache::get('post1');

        return \response()->json(
            [
                'data'=> PostResource::collection($posts)
            ]
        );
    }

    public function show($post_id){

        $post = Cache::rememberForever('post'.$post_id, function () use($post_id) {
            return Post::find($post_id);
        });



        return \response()->json(new PostResource($post));
    }

    public function store(Request $request){
        // dd($request);
        $data = $request->except('_token');
        $result = Post::create($data);
        Cache::forever('post'.$result->id, $result);

        // or save db cache trong thời gian nhất định ttl: đại diện cho tg lưu nhất định
        // Cache::add('post'.$result->id, $result, 3600);

        return \response()->json(
            [
            'data' => new PostResource($result),
            'message'=>'Thêm dữ liệu thành công'
            ]
        );
    }

    public function update(Request $request,Post $post) {
        $inputs = $request->only(
            'title',
            'content',
            'slug',
            'user_id',
        );
        $post->fill($inputs);
        $post->save();

        return \response()->json(
            [
            'data' => new PostResource($post)
            ]
        );
    }

    public function delete(Post $post){
        // $posts = Cache::get('post'.$post->id);
        // dd($posts);
        $result = Cache::pull('post'.$post->id);
        // dd($result);
        $post->delete();
        return  \response()->json(['message' => 'Xoa thanh cong']);
    }
}
