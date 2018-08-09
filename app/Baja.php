<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
    protected $table = "bajas";

    protected $fillable = ['id', 'bien_id', 'motivo','numero_resolucion','fecha_baja','user_id','responsable_id','activo'];

    public function bien()
    {
        return $this->hasOne('App\Bien');
    } 

    public function user()
    {
    	return $this->belongsTo('App\User');
    }    

    public function responsable()
    {
    	return $this->belongsTo('App\Empleado');
    }    
}
