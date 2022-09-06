<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FlavourCategory;

class Flavour extends Model
{
    use HasFactory, SoftDeletes;

    public function flavour_cat()
    {
        return $this->hasOne(FlavourCategory::class,'id','flavour_category_id');
    }
}
