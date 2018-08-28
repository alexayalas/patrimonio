<?php

namespace App;

use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Caffeinated\Shinobi\Models\Role;

class User extends Authenticatable
{
    use Notifiable, ShinobiTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','name_complete','enabled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function mantenimientos()
    {
        return $this->hasMany('App\Mantenimiento');
    } 
    
    public function roles()
    {
        return $this->belongsToMany('\Caffeinated\Shinobi\Models\Role')->withTimestamps();
    }

    public function movimientos()
    {
        return $this->hasMany('App\Movimiento');
    } 

}
