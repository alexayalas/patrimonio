<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = "documentos";

    protected $fillable = ['id', 'nombre_documento','activo'];

    public function biens()
    {
        return $this->hasMany('App\Bien');
    }    

}
