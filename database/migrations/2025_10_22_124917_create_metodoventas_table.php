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
        Schema::create('metodoventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ventaid');       // FK a ventas
            $table->unsignedBigInteger('idmetodopago'); // FK a metodos_pago
            $table->decimal('valor', 10, 2);             // valor de pagado con este método
            $table->foreign('ventaid')->references('id')->on('ventas');
            $table->foreign('idmetodopago')->references('idmetodopago')->on('metodopagos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metodoventas');
    }
};
