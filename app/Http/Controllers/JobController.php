<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendMailJob;

class JobController extends Controller
{
    public function processQueue()
    {
        SendMailJob::dispatch()
        // ->delay(now()->addSeconds(30))
        // ->onConnection('database')
        ->onQueue('emails');
        // php artisan queue:work tên_connection --queue=tên_queue
        // ví dụ: php artisan queue:work database --queue=emails

    }
}
