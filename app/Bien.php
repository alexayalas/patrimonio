<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $table = "biens";

    protected $fillable = ['id', 'codigo_barra', 'codBar39','clase_id','descripcion','ubicacion_id','empleado_id','encargado_id','modelo','marca','numero_serie','medidas','caracteristicas','conservacion','en_uso','fecha_compra','tipoingreso_id','documento_id','numero_documento','costo','proveedor_id','depresiable','cuenta_id','dias_mantenimiento','activo','fecha_registro','serie_documento','garantia_id','dias_garantia','foto'];

    public function clase()
    {
        return $this->belongsTo('App\Clase');
    }  
    
    public function ubicacion()
    {
        return $this->belongsTo('App\Ubicacion');
    } 

    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }  

    public function encargado()
    {
        return $this->belongsTo('App\Empleado');
    }     

    public function tipoingreso()
    {
        return $this->belongsTo('App\Tipoingreso');
    }
    
    public function documento()
    {
        return $this->belongsTo('App\Documento');
    }     

    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }   
    
    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta');
    }    
    
    public function baja()
    {
        return $this->belongsTo('App\Baja');
    }   
       
    public function mantenimientos()
    {
        return $this->hasMany('App\Mantenimiento');
    }  
    
    public function traslados()
    {
        return $this->hasMany('App\Traslado');
    }  
    
    public function garantia()
    {
        return $this->belongsTo('App\Garantia');
    }     
}
