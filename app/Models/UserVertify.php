<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class UserVertify extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'expiry_date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function createVerifyCode($user_id) {
        $now = now()->toDateTimeString();
        $expiry_date = now()->addDay()->toDateTimeString();
        $code =  Str::random(64);

        // set hết hạn mấy cái cũ
        UserVertify::where('user_id', $user_id)
            ->where('expiry_date', '>', $now)
            ->update(
                [
                    'expiry_date'=> $now
                ]
            );

        // tạo user verify
        $userVertify = UserVertify::create([
            'code' => $code,
            'user_id' => $user_id,
            'expiry_date' => $expiry_date
        ]);

        return $userVertify;
    }
}
