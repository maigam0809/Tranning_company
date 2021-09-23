<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\WelcomeEmail;
use App\Models\User;


class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $userVertify;

    public function __construct($user, $userVertify)
    // public function __construct()
    {
        $this->user = $user;
        $this->userVertify = $userVertify;
    }



    public function handle()
    {
        $email = new WelcomeEmail($this->user, $this->userVertify);
        Mail::to($this->user->email)->send($email);
        // dd($user);

        // Mail::to($user->email)->send(
        //     new VertifyMail($user, $userVertify)
        // );

        // $email = new WelcomeEmail();
        // Mail::to('maigam0809200@gmail.com')->send($email);
    }
}
