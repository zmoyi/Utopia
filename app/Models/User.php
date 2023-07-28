<?php

namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
 use Illuminate\Database\Eloquent\Relations\HasOne;
 use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function categories(): HasMany
    {
        return $this->hasMany(Categories::class);
    }

    public function cards(): HasManyThrough
    {
        return $this->hasManyThrough(CardCodes::class, Categories::class);
    }

    public function member(): HasOne
    {
        return $this->hasOne(UserMember::class);
    }

    public function apps(): HasMany
    {
        return $this->hasMany(App::class);
    }

    public function cardCodeActivation(): HasMany
    {
        return $this->hasMany(CardCodeActivation::class);
    }

}
