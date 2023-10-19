<?php

namespace App\Models;

use Auth;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Trebol\Entrust\Traits\EntrustUserTrait;
use App\Lubus\constStatus;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, EntrustUserTrait;
    const InActive = 0;
    const Active = 1;
    const Archive = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
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

    public function roleUser()
    {
        return $this->hasOne('App\Models\RoleUser');
    }

    public function scopeExcludeArchive($query)
    {
        if (Auth::User()->id != 1) {
            return $query->where('status', '!=', self::Archive)->where('id', '!=', 1);
        }

        return $query->where('status', '!=', self::Archive);
    }

}
