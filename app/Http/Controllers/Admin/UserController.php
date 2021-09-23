<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function index(){
        $listUsers = User::all();
        // $listUsers = Redis::get('');
        return view('admin/users/index',[
            'users' => $listUsers
        ]);
    }

    public function show($id){
        // $listUsers = User::all();
        // $user = Redis::get('user:profile:'.$id);
        // dd($user);


        return view('admin.users.profile',[
            // 'user' => $user,
            'user' => Redis::get('user:profile:'.$id)
        ]);
    }

    public function delete(User $user){
        $user->delete();
        return redirect()->route('admin.users.index')->with('message',"Xoá Thành công");
    }
}
