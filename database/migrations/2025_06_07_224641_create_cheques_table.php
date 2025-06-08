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
        Schema::create('cheques', function (Blueprint $table) {
            $table->id(); 
            $table->boolean('entro');
            $table->foreignId('codigo_cuenta')
                ->constrained('cuentas', 'codigo')
                ->onDelete('cascade');
            $table->string('numero_cheque', 50);
            $table->date('fecha');
            $table->decimal('debe', 12, 2);
            $table->decimal('haber', 12, 2);
            $table->foreignId('codigo_factura')
                ->constrained('facturas', 'id')
                ->onDelete('restrict');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheques');
    }
};
