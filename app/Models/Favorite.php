<?php

namespace App\Models;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    protected $fillable = ['user_id', 'image_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function image() {
        return $this->belongsTo(Image::class);
    }
}
