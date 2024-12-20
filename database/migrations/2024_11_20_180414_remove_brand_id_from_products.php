<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveBrandIdFromProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']); // Elimina la clave foránea
            $table->dropColumn('brand_id');   // Elimina la columna 'brand_id'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('brand_id')->unsigned()->nullable(); // Reagrega la columna
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade'); // Reagrega la clave foránea
        });
    }
}
