<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Caffeinated\Shinobi\Models\Role;

class Module extends Model
{
    protected $table = "modules";

    protected $fillable = ['name','idparent','type','icono','name_router','name_template','orden','active'];

    public function roles()
    {
        return $this->belongsToMany('\Caffeinated\Shinobi\Models\Role')->withTimestamps();
    }

}
