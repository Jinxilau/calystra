<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'fullname', // Optional full name
        'phone', // Optional phone number
        // 'profile_picture', // Optional profile picture URL
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // // app/Models/User.php
    // public function roles()
    // {
    //     return $this->belongsTo(Role::class);
    // }

    // public function profile()
    // {
    //     return $this->hasOne(UserProfile::class);
    // }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function photographerAssignments()
    {
        return $this->hasMany(BookingPhotographer::class, 'assigned_by');
    }
}
