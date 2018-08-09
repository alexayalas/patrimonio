<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = "proveedors";

    protected $fillable = ['id', 'nombre_proveedor','direccion','ruc','telefono','celular','email','activo'];

    public function biens()
    {
        return $this->hasMany('App\Bien');
    }    

}
