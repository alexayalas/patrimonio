<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = "grupos";

    protected $fillable = ['id', 'nombre_grupo', 'activo'];         

    public function clases()
    {
        return $this->hasMany('App\Clase');
    }    

}
