<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function l_domains() 
    {
        return $this->hasMany(\App\LDomain::class);
    }

    public function m_domains()
    {
        return $this->belongsToMany(\App\LDomain::class,'l_domain_users','l_domain_id');
    }
}
