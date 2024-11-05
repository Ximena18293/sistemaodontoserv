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
        Schema::table('employees', function (Blueprint $table) {
            // Eliminar columnas redundantes de nombres y apellidos
            $table->dropColumn(['first_name', 'last_name', 'second_last_name']);
            
            // Cambiar 'position' a un tipo ENUM con las opciones específicas
            $table->enum('position', ['Vendedor', 'Gerente', 'Asistente'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Restaurar las columnas de nombres en caso de deshacer la migración
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('second_last_name', 50)->nullable();

            // Cambiar 'position' de vuelta a VARCHAR en caso de rollback
            $table->string('position', 100)->nullable()->change();
        });
    }
};
