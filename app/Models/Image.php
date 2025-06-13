<?php

namespace App\Models;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
     protected $fillable = ['image_type', 'filename'];

     public function favorites()
     {
          return $this->hasMany(Favorite::class);
     }
}
