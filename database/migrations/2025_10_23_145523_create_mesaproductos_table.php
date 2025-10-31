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
        Schema::create('mesaproductos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idmesa');      // mesa asociada
            $table->unsignedBigInteger('idproducto');  // producto agregado
            $table->integer('cantidad')->default(1);   // cantidad
            $table->decimal('precio', 10,2);          // precio unitario al momento
            $table->timestamps();

            $table->foreign('idmesa')->references('idmesa')->on('mesas')->onDelete('cascade');
            $table->foreign('idproducto')->references('idproducto')->on('productos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mesaproductos');
    }
    /**
     * Reverse the migrations.
     */
   
};
