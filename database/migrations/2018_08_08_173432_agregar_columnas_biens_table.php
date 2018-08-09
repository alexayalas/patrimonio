<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarColumnasBiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biens', function (Blueprint $table) {
            $table->integer('garantia_id')->unsigned()->nullable();

            $table->foreign('garantia_id')->references('id')->on('garantias')->onDelete('cascade');               

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biens', function (Blueprint $table) {
            $table->dropColumn('garantia_id');
        });
    }
}
