<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = "movimientos";

    protected $fillable = ['id', 'bien_id','tipomovimiento','fecha_movimiento','ubicacion_id_anterior','ubicacion_id_actual','encargado_id_anterior','encargado_id_actual','autorizado_id','conservacion_anterior','conservacion_actual','en_uso_anterior','en_uso_actual','tipo_traslado','motivo_baja','numero_resolucion','user_id','activo'];

    public function bien()
    {
        return $this->belongsTo('App\Bien');
    }     
    
    public function ubicacion_anterior()
    {
        return $this->belongsTo('App\Ubicacion','ubicacion_id_anterior');
    } 

    public function ubicacion_actual()
    {
        return $this->belongsTo('App\Ubicacion','ubicacion_id_actual');
    } 

    public function encargado_anterior()
    {
        return $this->belongsTo('App\Empleado','encargado_id_anterior');
    } 

    public function encargado_actual()
    {
        return $this->belongsTo('App\Empleado','encargado_id_actual');
    }    
    
    public function autorizado()
    {
        return $this->belongsTo('App\Empleado','autorizado_id');
    } 
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }       
}
