<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    protected $table = 'cuentas_bancarias';
    protected $primaryKey = 'codigo';
    public $timestamps = false;

    public function bancos()
    {
        return $this->belongsTo(banco::class, 'numero_banco');
    }

    public function cheques()
    {
        return $this->hasMany(Cheqye::class, 'codigo_cuenta');
    }
}
