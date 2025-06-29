<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    //Permitir asignacion masiva a estos campos
    protected $fillable = [
        'fecha',
        'numero',
        'neto',
        'total',
        'codigo_proveedor'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'codigo_proveedor', 'codigo');
    }

    public function cheque()
    {
        return $this->hasOne(Cheque::class, 'codigo_factura');
    }
}
