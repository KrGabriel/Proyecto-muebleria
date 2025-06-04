<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'codigo_proveedor');
    }

    public function cheque()
    {
        return $this->hasOne(Cheque::class, 'codigo_factura');
    }
}
