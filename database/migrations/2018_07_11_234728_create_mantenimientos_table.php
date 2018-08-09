<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMantenimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bien_id')->unsigned();  
            $table->date('fecha_programada')->nullable();
            $table->date('fecha_realizada')->nullable(); 
            $table->enum('estado',['Registrada','En espera','Ejecutada','Cancelada'])->default('Registrada');                                     
            $table->integer('empleadoregistro_id')->unsigned(); 
            $table->integer('empleadoautorizo_id')->unsigned(); 
            $table->integer('empleadosuperviso_id')->unsigned(); 
            $table->integer('empleadoconformidad_id')->unsigned(); 
            $table->integer('user_id')->unsigned();               
            $table->text('observaciones');                                  
            $table->boolean('activo')->default(true);  
            
            $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade');
            $table->foreign('empleadoregistro_id')->references('id')->on('empleados')->onDelete('cascade');            
            $table->foreign('empleadoautorizo_id')->references('id')->on('empleados')->onDelete('cascade');               
            $table->foreign('empleadosuperviso_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('empleadoconformidad_id')->references('id')->on('empleados')->onDelete('cascade');            
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
        Schema::dropIfExists('mantenimientos');
    }
}
