<?php

namespace Database\Seeders;

use App\Models\CuentaGastos;
use App\Models\EmailProveedor;
use App\Models\Proveedor;
use App\Models\RetencionIIBB;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComprasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RetencionIIBB::create([
            'Nombre' => 'Retención General',
            'Alicuota' => 3.0,
            'BaseIncluyeNeto' => true,
            'BaseIncluyeIVA' => false,
            'BaseIncluyeImpuestosInternos' => false,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);

        CuentaGastos::create([
            'Nombre' => 'Gastos Administrativos',
            'Descripcion' => 'Cuenta para gastos administrativos generales',
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);

        CuentaGastos::create([
            'Nombre' => 'Gastos Operativos',
            'Descripcion' => 'Cuenta para gastos de operación',
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);

        Proveedor::create([
            'IdLocalidad' => 1,
            'IdCuentaGastos' => 1,
            'Nombre' => 'Proveedor Ejemplo S.A.',
            'Direccion' => 'Calle Falsa 123',
            'Localidad' => 'Ciudad Ejemplo',
            'Provincia' => 'Provincia Ejemplo',
            'Telefono' => '123456789',
            'IdCondicionIva' => 1,
            'NumeroDocumento' => '30-12345678-9',
            'SaldoSistemaAnterior' => 0,
            'IdRetencionIIBB' => 1,
            'NumeroIIBB' => 123456,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);

        EmailProveedor::create([
            'IdProveedor' => 1,
            'Email' => 'contacto@proveedor1.com',
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'IdProveedorEmail' => 'PRV001-EMAIL01',
        ]);

        EmailProveedor::create([
            'IdProveedor' => 1,
            'Email' => 'ventas@proveedor1.com',
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'IdProveedorEmail' => 'PRV001-EMAIL02',
        ]);
    }
}
