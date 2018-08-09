<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = "mantenimientos";

    protected $fillable = ['id', 'bien_id','fecha_programada','fecha_realizada','estado','empleadoregistro_id','empleadoautorizo_id','empleadosuperviso_id','empleadoconformidad_id','user_id','observaciones','activo'];

    public function bien()
    {
        return $this->belongsTo('App\Bien');
    }     
    
    public function empleadoregistro()
    {
        return $this->belongsTo('App\Empleado');
    }   
    
    public function empleadoautorizo()
    {
        return $this->belongsTo('App\Empleado');
    }     
    
    public function empleadosuperviso()
    {
        return $this->belongsTo('App\Empleado');
    }      

    public function empleadoconformidad()
    {
        return $this->belongsTo('App\Empleado');
    }  
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }      
}
