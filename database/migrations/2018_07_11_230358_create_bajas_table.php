<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bajas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bien_id')->unsigned();  
            $table->string('motivo',250); 
            $table->string('numero_resolucion',50);
            $table->date('fecha_baja')->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('responsable_id')->unsigned();
            $table->boolean('activo')->default(true);  
            
            $table->foreign('bien_id')->references('id')->on('biens')->onDelete('cascade');  
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('responsable_id')->references('id')->on('empleados')->onDelete('cascade');

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
        Schema::dropIfExists('bajas');
    }
}
