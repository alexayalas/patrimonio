<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    protected $table = "clases";

    protected $fillable = ['id', 'grupo_id', 'nombre_clase','activo'];

    public function grupo()
    {
        return $this->belongsTo('App\Grupo');
    }         

    public function biens()
    {
        return $this->hasMany('App\Bien');
    }    

}
