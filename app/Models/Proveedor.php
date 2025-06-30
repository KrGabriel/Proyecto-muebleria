<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $primaryKey = 'codigo';
    public $timestamps = false;
    
    //Permitir asignacion masiva en estos campos
    protected $fillable = [
        'numero_proveedor',
        'nombre',
        'direccion',
        'telefono',
        'localidad',
        'provincia',
        'fecha_ultima_compra',
        'activo'
    ];

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'codigo_proveedor');
    }
}
