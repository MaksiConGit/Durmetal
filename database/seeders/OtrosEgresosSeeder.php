<?php

namespace Database\Seeders;

use App\Models\CuentaOtrosEgresos;
use App\Models\MovimientoCuentaGastos;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OtrosEgresosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CuentaOtrosEgresos::create([
            'IdCuentaOtrosEgresosPadre' => null,
            'Nombre' => 'Egreso de ejemplo',
            'Descripcion' => 'Descripción de ejemplo',
            'FechaCreacion' => Carbon::now()->toDateString(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now()->toDateString(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);

        MovimientoCuentaGastos::create([
            'Fecha' => Carbon::now()->toDateString(),
            'FechaPago' => Carbon::now()->toDateString(),
            'Descripcion' => 'Pago de ejemplo',
            'IdCuentaOtrosEgresos' => 1,
            'Importe' => 1000,
            'FechaCreacion' => Carbon::now()->toDateString(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now()->toDateString(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);
    }
}
