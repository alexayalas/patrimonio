<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->unique();
            $table->integer('idparent')->nullable();
            $table->enum('type',['module','menu','option']);
            $table->string('icono')->nullable();
            $table->string('name_router',100)->unique()->nullable();
            $table->string('name_template',100)->unique()->nullable();
            $table->integer('orden')->default(1);
            $table->boolean('active')->default(true);            
            $table->timestamps();
        });

        Schema::create('module_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('module_id')->unsigned();           

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('module_id')->references('id')->on('modules');

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
        Schema::dropIfExists('modulos');
    }
}
