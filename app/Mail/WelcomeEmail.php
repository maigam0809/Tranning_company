<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $userVertify;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $userVertify)
    // public function __construct()
    {
        $this->user = $user;
        $this->userVertify = $userVertify;
    }

    public function build()
    {
        
        $link = route('register.vertify',['code'=>$this->userVertify->code]);
        // dd($link);
        return $this->view('mails.hello')
        ->with([
            'link' => $link,
        ])
        ->subject("Xác thực người dùng ?");
    }
}
