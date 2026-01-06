<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 1. IMPORT THIS: The JWT Contract
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

// 2. IMPLEMENT THIS: Add "implements JWTSubject" to the class definition
class User extends Authenticatable implements JWTSubject
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

    // ------------------------------------------------------
    // JWT AUTHENTICATION METHODS
    // ------------------------------------------------------

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * Usually the user's primary key (ID).
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'user_id' => $this->id,
            'name'    => $this->name,
            'email'   => $this->email,
            'role'    => 'user', 
        ];
    }

    
    
     // A user can have many products.
     
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}