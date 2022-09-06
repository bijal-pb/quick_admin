<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PostLike extends Model
{
    use HasFactory;

    public function like_by()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
