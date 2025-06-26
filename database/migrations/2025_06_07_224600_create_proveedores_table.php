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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id('codigo'); 
            $table->integer('numero_proveedor');
            $table->string('nombre', 100);
            $table->text('direccion')->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('localidad', 50)->nullable();
            $table->string('provincia', 50)->nullable();
            $table->date('fecha_ultima_compra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
