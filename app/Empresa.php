<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "empresas";

    protected $fillable = ['id', 'nombre_empresa','direccion','ruc','email','activo'];

    public function areas()
    {
        return $this->hasMany('App\Area');
    }       

}
