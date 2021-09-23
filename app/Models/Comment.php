<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Comment extends Model
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'content',
    ];

    protected $table = 'comments';
    protected $primaryKey = 'id';
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }


}
