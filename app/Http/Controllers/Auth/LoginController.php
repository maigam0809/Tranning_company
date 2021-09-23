<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function getLoginForm(){
        return view('auth/login');
    }

    public function login(Request $request){
        $data = $request->only([
            'email',
            'password',
            'remember_token',
        ]);

        $a = User::where('email',$data['email'])->first();
        $b = $a->email_verified_at;

        if($b !== null){
            $result = Auth::attempt($data);

            if($result === false){
                session()->flash('error','Sai email or mật khẩu');
                return back();
            }

            $user = Auth::user();

            return redirect()->route('admin.users.index')->with('Đăng nhập thành công');

        }else{
            session()->flash('error','Tài khoản này chưa kích hoạt.');
            return back();
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('auth.getLoginForm');

    }

    // Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
        ->redirect();
        // ->route('admin.users.index')->with('message','Đăng nhập thành công')
    }
    // Google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $this->_registerOrLoginUser($user);
        return \redirect()->route('admin.users.index')->with('message','Đăng nhập thành công');

    }

    // facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    // Facebook callback
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $this->_registerOrLoginUser($user);
        return \redirect()->route('auth.getLoginForm');

    }

    // github login
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }
    // Github callback
    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->user();
        $this->_registerOrLoginUser($user);
        return \redirect()->route('admin.users.index')->with('message','Đăng nhập thành công');

    }

    protected function _registerOrLoginUser($data){
        $user = User::where('email','=',$data->email)->first();
        if(!$user){
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $arrName = explode(" ", $data->name);
            $user->first_name = array_shift($arrName);
            $user->last_name = array_pop($arrName);
            $middleName = implode(" ", $arrName);
            $user->password = Str::random(32);
            $user->save();
        }
        Auth::login($user);
        // dd( Auth::login($user));
        // $user = Auth::user();

        // return redirect()->route('admin.users.index')->with('Đăng nhập thành công');
    }



}
