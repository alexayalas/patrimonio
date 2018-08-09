<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empresa_id')->unsigned();     
            //$table->integer('sede_id')->unsigned();                     
            $table->string('nombre_area',100);  
            $table->boolean('activo')->default(true); 
            
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            //$table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');            

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
        Schema::dropIfExists('areas');
    }
}
