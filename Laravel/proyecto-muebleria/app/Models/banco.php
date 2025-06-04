<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class banco extends Model
{
    protected $table = 'bancos';
    protected $primaryKey = 'numero';
    public $timestamps = false;

    public function cuentas()
    {
        return $this->hasMany(CuentaBancaria::class, 'numero_banco');
    }
}
