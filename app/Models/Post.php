<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PostLike;
use App\Models\PostReview;
use App\Models\FlavourCategory;
use App\Models\Flavour;



class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('/post/' . $value);
        } else {
            return null;
        }
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id')->where('like',1)->with('like_by');
    }

    public function reviews()
    {
        return $this->hasMany(PostReview::class, 'post_id')->with('review_by');
    }

    public function flavour_category()
    {
        return $this->hasOne(FlavourCategory::class,'id','flavour_category_id');
    }

    public function flavour()
    {
        return $this->hasOne(Flavour::class,'id','flavour_id');
    }
}
