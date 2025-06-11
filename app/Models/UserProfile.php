<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    //
    // app/Models/UserProfile.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
