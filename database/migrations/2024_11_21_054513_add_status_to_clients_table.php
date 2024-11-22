<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            // Agregar el campo 'status' con un valor predeterminado de 1 (activo)
            $table->tinyInteger('status')->default(1)->after('ciNit'); // Ajusta la posición según lo necesites
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            // Eliminar el campo 'status' si se revierte la migración
            $table->dropColumn('status');
        });
    }
}
