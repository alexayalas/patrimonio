<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    protected $table = "garantias";

    protected $fillable = ['id', 'nombre_garantia', 'activo'];         

    public function bienes()
    {
        return $this->hasMany('App\Bien');
    }    
}
