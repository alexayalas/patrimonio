<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = "ubicacions";

    protected $fillable = ['id', 'area_id', 'nombre_ubicacion','activo'];
    
    public function area()
    {
        return $this->belongsTo('App\Area');
    }    

    public function biens()
    {
        return $this->hasMany('App\Bien');
    }     
    
    public function traslados()
    {
        return $this->hasMany('App\Traslado');
    }        
}
