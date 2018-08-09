<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipoingreso extends Model
{
    protected $table = "tipoingresos";

    protected $fillable = ['id', 'nombre_tipoingreso', 'activo'];

    public function biens()
    {
        return $this->hasMany('App\Bien');
    }    

}
