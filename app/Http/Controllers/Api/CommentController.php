<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use App\Traits\TraitResponse;

class CommentController extends Controller
{
    use TraitResponse;

    public function index(Request $request) {

        $comments = Cache::tags(['listComments'])
        ->remember('comments::'.$request->page, 24*60*60, function () {
            return Comment::simplePaginate(15);
        });

        return $this->responseApi(
            [
                'data'=> CommentResource::collection($comments),
                'message'=>'Lấy danh sách dữ liệu thành công'
            ]
        );
    }

    public function show($comment_id){
        
        $comment = Cache::tags(['commentOne'])
        ->rememberForever('comment'.$comment_id, function () use($comment_id) {
            return Comment::find($comment_id);
        });

        if($comment != null) {
            return $this->responseApi(
                [
                    'data' => new CommentResource($comment),
                    'message'=>'Lấy dữ liệu thành công'
                ]
            );
            
        }else{

            return $this->responseApi(
                [
                    'message'=>'Dữ liệu này không tồn tại ở bảng này.'
            ]);
        }
    }

    public function store(Request $request){
        $data = $request->except('_token');
        $result = Comment::create($data);

        return $this->responseApi(
            [
            'data' => new CommentResource($result),
            'message'=>'Thêm dữ liệu thành công'
            ],201
        );
    }

    public function update(Request $request,Comment $comment) {
        // dd($comment);
        $inputs = $request->only(
            'parent_id',
            'content',
            'post_id',
            'user_id',
        );

        $comment->fill($inputs);
        $comment->save();
        Cache::forget('comment::'.$comment->id);
        return $this->responseApi(
            [
                'data' =>  new CommentResource($comment),
                'message'=>'Sửa dữ liệu thành công'
            ],200
        );
    }

    public function delete(Comment $comment){
        Cache::forget('comment::'.$comment->id);
        $comment->delete();
        return  $this->responseApi(
            [
                'data' => "Dữ liệu đã được xoá",
                'message' => 'Xoá thành công'
            ],200
        );
    }
}
