<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DataHiveDevelopment\PassportIntrospectionClient\HasIntrospectedToken;

class User extends Authenticatable
{
    use HasIntrospectedToken, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'name', 'access_token', 'refresh_token', 'expires_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'access_token', 'refresh_token', 'expires_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Find the user by the given introspection user_id.
     *
     * @param  string  $id
     * @return \App\User
     */
    public function findForIntrospection($id)
    {
        return $this->where('uuid', $id)->first();
    }
}
