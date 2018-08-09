<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traslado extends Model
{
    protected $table = "traslados";

    protected $fillable = ['id', 'bien_id','ubicacionorigen_id','ubicaciondestino_id','empleadoorigen_id','empleadodestino_id','conservacion','en_uso','fecha_traslado','user_id','tipotraslado','activo'];

    public function bien()
    {
        return $this->belongsTo('App\Bien');
    }    
    
    public function ubicacionorigen()
    {
        return $this->belongsTo('App\Ubicacion');
    } 

    public function ubicaciondestino()
    {
        return $this->belongsTo('App\Ubicacion');
    } 
    
    public function empleadoorigen()
    {
        return $this->belongsTo('App\Empleado');
    }   
    
    public function empleadodestino()
    {
        return $this->belongsTo('App\Empleado');
    }  
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }      
}
