<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser; // <-- Add this
use Filament\Panel;                         // <-- Add this

class User extends Authenticatable implements MustVerifyEmail, FilamentUser // <-- Add FilamentUser
{
    use CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role', // Make sure 'role' is fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Add this method for Filament
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'email', 'email');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function sellerRating()
    {
        return Review::whereHas('product', function ($query) {
            $query->where('user_id', $this->id);
        })->avg('rating');
    }
}
