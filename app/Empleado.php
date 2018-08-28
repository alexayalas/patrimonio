<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = "empleados";

    protected $fillable = ['id', 'dni', 'nombres','apellidos','nombre_completo','activo'];

    public function biens()
    {
        return $this->hasMany('App\Bien');
    }    

    public function bajas()
    {
        return $this->hasMany('App\Baja');
    }    
    
    public function mantenimientos()
    {
        return $this->hasMany('App\Mantenimiento');
    }    
    
    public function traslados()
    {
        return $this->hasMany('App\Traslado');
    } 
    
    public function movimientos()
    {
        return $this->hasMany('App\Movimiento');
    }     

}
