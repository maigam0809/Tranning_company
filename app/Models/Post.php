<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'slug',
        'user_id',
    ];

    protected $table = 'posts';
    protected $primaryKey = 'id';

    public function comments(){
        return $this->hasMany(Comment::class);

    }

    public function user(){
        return $this->hasMany(User::class);

    }

}
