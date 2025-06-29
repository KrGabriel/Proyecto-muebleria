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

<<<<<<< Updated upstream
    protected $fillable = ['numero_cuenta',
                            'numero_banco'];
=======
    protected $fillable = [
        'numero_banco',
        'numero_cuenta',
        'alias',
    ];
>>>>>>> Stashed changes

                            
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'numero_banco', 'numero');
    }

    public function cheques()
    {
        return $this->hasMany(Cheque::class, 'codigo_cuenta', 'codigo');
    }
}
