<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Agregamos la columna brand_id
            $table->unsignedBigInteger('brand_id')->nullable()->after('id');
            
            // Definimos la relación foránea con la tabla brands
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Eliminamos la relación foránea y la columna
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });
    }
};
