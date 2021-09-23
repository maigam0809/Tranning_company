<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VertifyMail extends Mailable
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
    {
        $this->user = $user;
        $this->userVertify = $userVertify;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = route('register.vertify',['code'=>$this->userVertify->code]);
        // dd($link);
        return $this->view('mails.vertical')
        ->with([
            'link' => $link,
        ])
        ->subject("Xác thực người dùng ?");
    }
}
