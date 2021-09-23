<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\User;
class CreateUserCommand extends Command
{
    protected $signature = 'user:create';

    protected $description = 'Create a new user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = Str::random(8);
        $password = Str::random(12);
        User::create([
            'name' => $name,
            'email' => Str::random(8).'gmail.com',
            'password' => bcrypt($password),
        ]);
        $this->info('Successfully created.Email: '.$name.'@gmail.com; pass: '. $password);
        // return 0;
    }
}
