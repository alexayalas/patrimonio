<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = "cuentas";

    protected $fillable = ['id', 'nombre_cuenta', 'activo'];

    public function biens()
    {
        return $this->hasMany('App\Bien');
    }    

}
