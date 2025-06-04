<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $table = 'cheques';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function cuenta()
    {
        return $this-belongsTo(CuentaBancaria::class, 'codigo_cuenta');
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'codigo_factura');
    }
}
