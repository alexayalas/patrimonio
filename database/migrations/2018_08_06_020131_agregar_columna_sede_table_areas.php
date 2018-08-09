<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarColumnaSedeTableAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('areas', function(Blueprint $table)
        {
            $table->integer('sede_id')->unsigned()->nullable();

            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('areas', function(Blueprint $table)
        {
            $table->dropColumn('sede_id');             
        });
    }
}
