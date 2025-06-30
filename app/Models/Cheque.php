<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    use HasFactory;

    protected $table = 'cheques';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'entro',
        'codigo_cuenta',
        'numero_cheque',
        'fecha',
        'debe',
        'haber',
        'codigo_factura',
    ];

    public function cuenta()
    {
        return $this->belongsTo(CuentaBancaria::class, 'codigo_cuenta', 'codigo');
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'codigo_factura');
    }
}
