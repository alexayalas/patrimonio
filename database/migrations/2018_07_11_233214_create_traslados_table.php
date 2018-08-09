<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrasladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traslados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bien_id')->unsigned();  
            $table->integer('ubicacionorigen_id')->unsigned();  
            $table->integer('ubicaciondestino_id')->unsigned(); 
            $table->integer('empleadoorigen_id')->unsigned(); 
            $table->integer('empleadodestino_id')->unsigned(); 
            $table->enum('conservacion',['Bueno','Malo','Regular'])->default('Bueno');  
            $table->enum('en_uso',['Si','No'])->default('Si');                                                                          
            $table->date('fecha_traslado')->nullable();
            $table->integer('user_id')->unsigned();
            $table->enum('tipotraslado',['Temporal','Definitivo'])->default('Definitivo');               
            $table->boolean('activo')->default(true);  
            
            $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade');
            $table->foreign('ubicacionorigen_id')->references('id')->on('ubicacions')->onDelete('cascade');            
            $table->foreign('ubicaciondestino_id')->references('id')->on('ubicacions')->onDelete('cascade');               
            $table->foreign('empleadoorigen_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('empleadodestino_id')->references('id')->on('empleados')->onDelete('cascade');            
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
        Schema::dropIfExists('traslados');
    }
}
