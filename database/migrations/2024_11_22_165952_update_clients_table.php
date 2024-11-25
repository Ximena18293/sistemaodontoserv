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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('last_name')->nullable();  // Agregar apellido
            $table->string('second_last_name')->nullable();  // Agregar segundo apellido
            $table->string('phone')->nullable();  // Agregar teléfono
            $table->timestamp('deleted_at')->nullable();  // Agregar eliminación lógica (soft delete)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('second_last_name');
            $table->dropColumn('phone');
            $table->dropColumn('deleted_at');
        });
    }
};
