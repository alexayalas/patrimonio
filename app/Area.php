<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "areas";

    protected $fillable = ['id', 'empresa_id','sede_id','nombre_area','activo'];

    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }  

    public function sede()
    {
        return $this->belongsTo('App\Sede');
    } 

    public function ubicaciones()
    {
        return $this->hasMany('App\Ubicacion');
    }     

}
