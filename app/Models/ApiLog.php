<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class ApiLog extends Model
{
    //use HasFactory;
    public function scopeSearch($query,$val)
    {
        return $query
        ->where('id','like','%'.$val.'%');
    }

    public function getCreatedAtAttribute($value)
    {
        return (new Carbon($value))->format('Y-m-d h:i:s');
    }
    public function getUpdatedAtAttribute($value)
    {
        return (new Carbon($value))->format('Y-m-d h:i:s');
    }
}
