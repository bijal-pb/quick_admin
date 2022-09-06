<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('/category/' . $value);
        } else {
            return null;
        }
    }
}
