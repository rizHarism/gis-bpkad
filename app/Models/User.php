<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
     * @var string[]
     */

    protected $table = 'users';
    protected $fillable = [
        'username',
        'email',
        'password',
        'skpd_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function master_skpd()
    {
        // return $this->belongsTo(\App\Models\Skpd::class, "users.skpd_id", "master_skpd.id_skpd");
        return $this->belongsTo(Skpd::class, "skpd_id", "id_skpd");
        // return $this->belongsTo(Skpd::class, 'users.skpd_id', 'master_skpd.id_skpd');
    }
}
