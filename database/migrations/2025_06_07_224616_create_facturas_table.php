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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id(); // Clave primaria: id
            $table->unsignedBigInteger('codigo_proveedor'); // FK a proveedores
            $table->date('fecha');
            $table->string('numero', 50);
            $table->decimal('neto', 12, 2);
            $table->decimal('tasa', 5, 2);
            $table->decimal('sobretasa', 5, 2)->nullable();
            $table->decimal('total', 12, 2);

            // Clave foránea
            $table->foreign('codigo_proveedor')->references('codigo')->on('proveedores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
