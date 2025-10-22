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
        Schema::create('productosventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idproducto');       // FK a productos
            $table->unsignedBigInteger('idventa');          // FK a ventas
            $table->foreign('idproducto')->references('idproducto')->on('productos');
            $table->foreign('idventa')->references('id')->on('ventas');
            $table->integer('cantidad');
            $table->decimal('total', 8, 2);
            $table->string('descripcion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productosventas');
    }
};
