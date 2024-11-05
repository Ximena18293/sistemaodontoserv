<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con la tabla users
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('second_last_name', 50)->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('position', 100)->nullable();
            $table->tinyInteger('status')->default(1); // 1 para activo, 0 para inactivo
            $table->timestamps(); // Para fecha de creación y actualización
            $table->softDeletes(); // Para eliminación lógica
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        
    }
};

