<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Banco;
use App\Models\CuentaBancaria;
use App\Models\Proveedor;

class DatosInicialesSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Usuario inicial
        if (!User::where('email', 'Perez@gmail.com')->exists()) {
            User::create([
                'name' => 'Perez',
                'email' => 'Perez@gmail.com',
                'password' => bcrypt('12345'),
            ]);
        }

        // ✅ Bancos
        $bancosData = [
            ['nombre' => 'Nación', 'comentario' => null],
            ['nombre' => 'ICBC', 'comentario' => null],
            ['nombre' => 'Macro', 'comentario' => null],
        ];

        $bancosMap = []; // Para mapear nombre => ID (numero)
        foreach ($bancosData as $data) {
            $banco = Banco::firstOrCreate(
                ['nombre' => $data['nombre']],
                ['comentario' => $data['comentario']]
            );
            $bancosMap[$banco->nombre] = $banco->numero;
        }

        // ✅ Cuentas bancarias
        $cuentasData = [
            ['banco' => 'Nación', 'numero_cuenta' => '41/67'],
            ['banco' => 'Nación', 'numero_cuenta' => '93/18'],
            ['banco' => 'Macro', 'numero_cuenta' => '89/61'],
            ['banco' => 'ICBC',  'numero_cuenta' => '828/56'],
        ];

        foreach ($cuentasData as $cuenta) {
            CuentaBancaria::firstOrCreate(
                [
                    'numero_cuenta' => $cuenta['numero_cuenta'],
                    'numero_banco' => $bancosMap[$cuenta['banco']],
                ]
            );
        }

        // ✅ Proveedores
        $proveedores = [
            [
                'numero_proveedor' => 'P001',
                'nombre' => 'Sancor',
                'direccion' => 'Calle Sancor 123',
                'telefono' => '1111111111',
                'localidad' => 'Capital',
                'provincia' => 'Buenos Aires',
                'fecha_ultima_compra' => now(),
                'activo' => true,
            ],
            [
                'numero_proveedor' => 'P002',
                'nombre' => 'Samsung',
                'direccion' => 'Av. Samsung 456',
                'telefono' => '2222222222',
                'localidad' => 'Capital',
                'provincia' => 'Buenos Aires',
                'fecha_ultima_compra' => now(),
                'activo' => true,
            ],
        ];

        foreach ($proveedores as $prov) {
            Proveedor::firstOrCreate(
                ['numero_proveedor' => $prov['numero_proveedor']],
                $prov
            );
        }
    }
}
