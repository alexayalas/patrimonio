<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_barra',10);
            $table->string('codBar39',12);
            $table->integer('clase_id')->unsigned();               
            $table->string('descripcion',150);
            $table->integer('ubicacion_id')->unsigned(); 
            $table->integer('empleado_id')->unsigned();  
            $table->integer('encargado_id')->unsigned();                                    
            $table->string('modelo',100);  
            $table->string('marca',100); 
            $table->string('numero_serie',100); 
            $table->string('medidas',100);  
            $table->string('caracteristicas',100);   
            $table->enum('conservacion',['Bueno','Malo','Regular'])->default('Bueno');
            $table->enum('en_uso',['Si','No'])->default('Si');     
            $table->date('fecha_compra')->nullable();  
            $table->integer('tipoingreso_id')->unsigned();   
            $table->integer('documento_id')->unsigned(); 
            $table->string('serie_documento',20);  
            $table->string('numero_documento',100);             
            $table->float('costo'); 
            $table->integer('proveedor_id')->unsigned(); 
            $table->boolean('depresiable')->default(true); 
            $table->integer('cuenta_id')->unsigned(); 
            $table->integer('dias_mantenimiento');                                                                                                               
            $table->boolean('activo')->default(true);

            $table->foreign('clase_id')->references('id')->on('clases')->onDelete('cascade');  
            $table->foreign('ubicacion_id')->references('id')->on('ubicacions')->onDelete('cascade');
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('encargado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('tipoingreso_id')->references('id')->on('tipoingresos')->onDelete('cascade');  
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedors')->onDelete('cascade');
            $table->foreign('cuenta_id')->references('id')->on('cuentas')->onDelete('cascade');            
            
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
        Schema::dropIfExists('biens');
    }
}
