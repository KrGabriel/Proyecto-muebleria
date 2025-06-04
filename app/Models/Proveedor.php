<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'codigo';
    public $timestamps = false;

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'codigo_proveedor');
    }
}
