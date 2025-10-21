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
    Schema::create('empleados', function (Blueprint $table) {
        $table->id('numerodocumento'); // Primary Key
        $table->string('nombre');
        $table->string('cargo');
        $table->decimal('salario', 10, 2);
        $table->enum('estado', ['activo', 'inactivo']);
        $table->enum('tipodocumento', ['cc', 'ti', 'ce']);
        $table->string('apellidos');
        $table->string('email');
        $table->string('telefono');
        $table->string('direccion');
        $table->date('fechaingreso');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
