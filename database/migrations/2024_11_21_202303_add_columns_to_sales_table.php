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
        Schema::table('sales', function (Blueprint $table) {
            $table->string('invoice_number')->unique()->nullable()->after('id'); // Número de factura
            $table->decimal('discount', 8, 2)->default(0)->after('total');       // Descuento
            $table->tinyInteger('status')->default(1)->after('discount');        // Estado de la venta (1 = Activa)
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['invoice_number', 'discount', 'status']);
        });
    }
};
