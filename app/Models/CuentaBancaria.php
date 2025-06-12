<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    use HasFactory;

    protected $table = 'cuentas';
    protected $primaryKey = 'codigo';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'numero_banco',
        'numero',
        'alias',
    ];

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'numero_banco');
    }

    public function cheques()
    {
        return $this->hasMany(Cheque::class, 'codigo_cuenta');
    }
}
