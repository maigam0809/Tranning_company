<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Cache;

class RedisController extends Controller
{
    // mở cái api này cho a
    public function index(Request $request) {
        // lưu trong 1 ngày
        $posts = Cache::tags(['listPosts'])
        ->remember('posts::'.$request->page, 24*60*60, function () {
            return Post::simplePaginate(15);
        });

        return \response()->json(
            [
                'data'=> PostResource::collection($posts)
            ]
        );
    }


    public function show($post_id){
        $post = Cache::tags(['postOne'])
        ->rememberForever('post'.$post_id, function () use($post_id) {
            return Post::find($post_id);
        });
        return \response()->json([
            'data' => new PostResource($post)
        ]);
    }

    public function store(Request $request){
        $data = $request->except('_token');
        $post = Post::create($data);

        // lưu bình thường nhưng chỉ lưu data ko lưu cả model
        // Redis::set('post::'.$post->id, $post);
        // $postGet =json_decode(Redis::get('post::'.$post->id));

        return \response()->json(
            [
                'data' => $post,
                'message'=>'Thêm dữ liệu thành công'
            ]
        );
    }

    // public function addTag(array $tags){
    //     Redis::sAddArray('tags',$tags);

    // }
    // public function addPostTags($postId,$tags){
    //     Redis::sAddArray("products:$postId",$tags);

    // }

    public function update(Request $request,Post $post) {
        $inputs = $request->only(
            'title',
            'content',
            'slug',
            'user_id',
        );
        $post->fill($inputs);
        $post->save();
        // xoá ở đây chỉ cần xoá đi thôi
        Cache::forget('post::'.$post->id);

        return \response()->json(
            [
            'data' => new PostResource($post)

            ]
        );
    }

    public function delete(Post $post){
        Cache::forget('post::'.$post->id);
        $post->delete();
        return  \response()->json(['message' => 'Xoa thanh cong']);
    }
}
