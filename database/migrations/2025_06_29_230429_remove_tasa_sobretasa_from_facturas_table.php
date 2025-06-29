<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn(['tasa', 'sobretasa']);
        });
    }
    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->decimal('tasa', 5, 2)->nullable();
            $table->decimal('sobretasa', 5, 2)->nullable();
        });
    }
};
