<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'codigo';
    public $timestamps = false;
    
    //Permitir asignacion masiva en estos campos
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'localidad',
        'provincia',
        'fecha_ultima_compra'
    ];

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'codigo_proveedor');
    }
}
