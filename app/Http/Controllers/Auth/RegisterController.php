<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use \App\Mail\VertifyMail;
use Mail;
use App\Models\UserVertify;
use App\Jobs\SendWelcomeEmail;

class RegisterController extends Controller
{
    public function register(){
        return view('auth/register');
    }

    public function store(RegisterRequest $request){
        $data = $request->except('_token');
        $user = User::create($data);

        Auth::login($user);

        $userVertify = UserVertify::createVerifyCode($user->id);

        // Mail::to($user->email)->send(
        //     new VertifyMail($user, $userVertify)
        // );

        // SendWelcomeEmail::dispatch($podcast);
        // This job is sent to the default connection's "emails" queue...
        SendWelcomeEmail::dispatch($user,$userVertify)->onQueue('emails');
        // Tương đương với câu lệnh này như sau:
        // $emailJob = new SendWelcomeEmail($user,$userVertify);
        // dispatch($emailJob);
        // dd($emailJob);


        return redirect()->route('admin.users.index')->with('message','Đăng nhập thành công');

        // Mail::send('mails/vertical',$data1,function($message) use ($user){
        //     $message->to($user['to']);
        //     $message->subject('Xác thực tài khoản email ?');
        // });

    }

    public function verify($code)
    {
        // check ở đây
        // dd($code);

        $userVertify = UserVertify::with('user')->where('code',$code)->first();
        // dd($userVertify->user);

        if($userVertify) {
            // check nếu code hết hạn
            // thông báo là code hết hạn rồi gửi mail mới
            if($userVertify->expiry_date < now()){
                // thông báo code hết hạn rồi return back
                \Session::flash('error', 'The verification code is incorrect or has expired');
            } else {
                $userVertify->user->email_verified_at = now()->toDatetimeString();
                $userVertify->push();
                \Session::flash('message', 'Your email has been successfully verified');
            }

            // set email_vertified_at

            // tương đương
            // $user = User::where('user_id', $userVerify->user_id)->first();
            // $user->email_vertified_at = now()->toDatetimeString();
            // $user->save();


            // login và
            // redirect về trang chủ

            // return redirect()->route('auth.getLoginForm')->with('message',"Đăng ký thành công!! Mời bạn đăng nhập bằng cách xác thực trong email.");

        } else {
            // thông báo code sai
            \Session::flash('warning', 'The verification code is incorrect or has expired');
        }
        return redirect()->route('admin.users.index');
    }

}
