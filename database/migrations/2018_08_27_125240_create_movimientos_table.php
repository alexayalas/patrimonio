<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bien_id')->unsigned(); 
            $table->enum('tipomovimiento',['Registro','Traslado','Baja'])->default('Registro');
            $table->date('fecha_movimiento')->nullable(); 
            $table->integer('ubicacion_id_anterior')->unsigned()->nullable();  
            $table->integer('ubicacion_id_actual')->unsigned()->nullable();              
            $table->integer('encargado_id_anterior')->unsigned()->nullable();   
            $table->integer('encargado_id_actual')->unsigned()->nullable(); 
            $table->integer('autorizado_id')->unsigned()->nullable();
            $table->enum('conservacion_anterior',['Bueno','Malo','Regular'])->default('Bueno');
            $table->enum('en_uso_anterior',['Si','No'])->default('Si');  
            $table->enum('conservacion_actual',['Bueno','Malo','Regular'])->default('Bueno');
            $table->enum('en_uso_actual',['Si','No'])->default('Si');   
            $table->enum('tipo_traslado',['Temporal','Definitivo'])->default('Definitivo')->nullable();    
            $table->string('motivo_baja',250)->nullable();  
            $table->string('numero_resolucion',150)->nullable();
            $table->integer('user_id')->unsigned();  
            $table->boolean('activo')->default(true);              
            
            $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade');  
            $table->foreign('ubicacion_id_anterior')->references('id')->on('ubicacions')->onDelete('cascade');            
            $table->foreign('ubicacion_id_actual')->references('id')->on('ubicacions')->onDelete('cascade');  
            $table->foreign('encargado_id_anterior')->references('id')->on('empleados')->onDelete('cascade');                      
            $table->foreign('encargado_id_actual')->references('id')->on('empleados')->onDelete('cascade'); 
            $table->foreign('autorizado_id')->references('id')->on('empleados')->onDelete('cascade');   
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');                                   
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
}
