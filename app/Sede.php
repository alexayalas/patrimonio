<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = "sedes";

    protected $fillable = ['id', 'nombre_sede','activo','direccion'];

    public function areas()
    {
        return $this->hasMany('App\Area');
    }       
}
