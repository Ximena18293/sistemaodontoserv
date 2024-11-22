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
        Schema::table('brands', function (Blueprint $table) {
            if (!Schema::hasColumn('brands', 'description')) {
                $table->string('description')->nullable(); // Agregar la columna de descripción
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
        $table->dropColumn('description'); // Eliminar la columna en caso de revertir la migración
        });
    }
};
