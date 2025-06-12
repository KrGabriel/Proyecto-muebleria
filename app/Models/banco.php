<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;

    protected $table = 'bancos';
    protected $primaryKey = 'numero';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'comentario',
    ];

    public function cuentas()
    {
        return $this->hasMany(CuentaBancaria::class, 'numero_banco', 'numero');
    }
}
