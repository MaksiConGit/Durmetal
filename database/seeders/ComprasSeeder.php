<?php

namespace Database\Seeders;

use App\Models\Chequepago;
use App\Models\CuentaGastos;
use App\Models\EmailProveedor;
use App\Models\Facturacompra;
use App\Models\Itemfacturacompra;
use App\Models\ItemMinutaCompra;
use App\Models\ItemNotaCreditoCompra;
use App\Models\MinutaCompra;
use App\Models\NotaCreditoCompra;
use App\Models\Ordenpago;
use App\Models\Pago;
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

        Ordenpago::create([
            'Letra' => 'A',
            'PuntoVenta' => 1,
            'Numero' => 1001,
            'NumeroCompleto' => 'OP-0001-1001',
            'FechaEmision' => now(),
            'IdProveedor' => 1,
            'RazonSocial' => 'Proveedor Ejemplo S.A.',
            'Direccion' => 'Av. Siempre Viva 742',
            'Localidad' => 'Springfield',
            'IdCondicionIva' => 1,
            'NumeroDocumentoProveedor' => '30-12345678-9',
            'Estado' => 'Pendiente',
            'BaseRetencionIIBB' => 1000,
            'AlicuotaRetencionIIBB' => 3,
            'RetencionIIBB' => 30,
            'RetencionIVA' => 50,
            'RetencionGanancias' => 100,
            'RetencionSUSS' => 20,
            'Total' => 5000,
            'Observaciones' => 'Pago correspondiente al mes de julio',
            'NumeroTurno' => 1,
            'ReferenciaTurno' => 2023001,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'CantidadEnviosPorCorreo' => 0,
            'CantidadImpresiones' => 0,
        ]);

        Pago::create([
            'IdOrdenPago' => 1,
            'FormaPago' => 'Cheque',
            'Descripcion' => 'Pago parcial mediante cheque',
            'Total' => 2500,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);

        Chequepago::create([
            'IdPago' => 1,
            'FechaEmision' => now(),
            'FechaAcreditacion' => now()->addDays(30),
            'IdBanco' => 1,
            'Numero' => 12345678,
            'Plaza' => 'CABA',
            'eCheck' => false,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);

        Facturacompra::create([
            'Letra' => 'A',
            'PuntoVenta' => 1,
            'Numero' => 2001,
            'NumeroCompleto' => 'FC-0001-2001',
            'FechaEmision' => Carbon::now(),
            'FechaRegistro' => Carbon::now(),
            'FechaVencimiento' => Carbon::now()->addDays(30),
            'TipoOperacion' => 'Compra',
            'IdProveedor' => 1,
            'IdCondicionIva' => 1,
            'NumeroDocumentoProveedor' => '20-12345678-9',
            'Neto' => 1000,
            'AjusteNeto' => 0,
            'IVA' => 210,
            'AjusteIVA' => 0,
            'ImpuestoInterno' => 0,
            'ImpuestoCombustible' => 0,
            'ImpuestoTV' => 0,
            'ConceptosNoGravados' => 0,
            'PercepcionIIBB' => 0,
            'PercepcionIVA' => 0,
            'PercepcionGanancias' => 0,
            'Sellados' => 0,
            'Bonificacion' => 0,
            'Recargo' => 0,
            'AjustePorRedondeo' => 0,
            'Total' => 1210,
            'Estado' => 'PENDIENTE',
            'CAE' => 12345678,
            'FechaVencimientoCAE' => Carbon::now()->addDays(30),
            'Observaciones' => 'Factura de compra ejemplo',
            'NumeroTurno' => 1,
            'ReferenciaTurno' => 1,
            'EsNotaDeDebito' => false,
            'NroFacturaNotaDebito' => null,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'LetraPuntoVentaNumeroIdProveedor' => 'A-0001-2001-1',
        ]);

        Facturacompra::create([
            'Letra' => 'A',
            'PuntoVenta' => 1,
            'Numero' => 2001,
            'NumeroCompleto' => 'ND-0001-2001',
            'FechaEmision' => Carbon::now(),
            'FechaRegistro' => Carbon::now(),
            'FechaVencimiento' => Carbon::now()->addDays(30),
            'TipoOperacion' => 'Compra',
            'IdProveedor' => 1,
            'IdCondicionIva' => 1,
            'NumeroDocumentoProveedor' => '20-12345678-9',
            'Neto' => 1000,
            'AjusteNeto' => 0,
            'IVA' => 210,
            'AjusteIVA' => 0,
            'ImpuestoInterno' => 0,
            'ImpuestoCombustible' => 0,
            'ImpuestoTV' => 0,
            'ConceptosNoGravados' => 0,
            'PercepcionIIBB' => 0,
            'PercepcionIVA' => 0,
            'PercepcionGanancias' => 0,
            'Sellados' => 0,
            'Bonificacion' => 0,
            'Recargo' => 0,
            'AjustePorRedondeo' => 0,
            'Total' => 1210,
            'Estado' => 'COMPLETO',
            'CAE' => 12345678,
            'FechaVencimientoCAE' => Carbon::now()->addDays(30),
            'Observaciones' => 'Factura de compra ejemplo',
            'NumeroTurno' => 1,
            'ReferenciaTurno' => 1,
            'EsNotaDeDebito' => true,
            'NroFacturaNotaDebito' => null,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'LetraPuntoVentaNumeroIdProveedor' => 'A-0001-2001-1',
        ]);

        Itemfacturacompra::create([
            'IdFacturaCompra' => 1,
            'IdCuentaGastos' => 1,
            'Descripcion' => 'Compra de insumos',
            'NroDeposito' => 1,
            'Cantidad' => 10,
            'PrecioUnitario' => 100,
            'IdImpuestoIva' => 1,
            'AlicuotaIVA' => 21,
            'Total' => 1210,
            'AjusteTotal' => 0,
            'AfectarPlanillaTurno' => false,
            'ControlarStock' => true,
            'Estado' => 'Activo',
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);

        NotaCreditoCompra::create([
            'IdFacturaCompra' => 1,
            'Letra' => 'A',
            'PuntoVenta' => 1,
            'Numero' => 3001,
            'NumeroCompleto' => 'NC-0001-3001',
            'FechaEmision' => Carbon::now(),
            'FechaRegistro' => Carbon::now(),
            'FechaVencimiento' => Carbon::now()->addDays(15),
            'TipoOperacion' => 'Devolución',
            'IdProveedor' => 1,
            'IdCondicionIva' => 1,
            'NumeroDocumentoProveedor' => '20-12345678-9',
            'Neto' => 500,
            'AjusteNeto' => 0,
            'IVA' => 105,
            'AjusteIVA' => 0,
            'ImpuestoInterno' => 0,
            'ImpuestoCombustible' => 0,
            'ImpuestoTV' => 0,
            'ConceptosNoGravados' => 0,
            'PercepcionIIBB' => 0,
            'PercepcionIVA' => 0,
            'PercepcionGanancias' => 0,
            'Sellados' => 0,
            'Bonificacion' => 0,
            'Recargo' => 0,
            'AjustePorRedondeo' => 0,
            'Total' => 605,
            'Estado' => 'Emitida',
            'CAE' => 87654321,
            'FechaVencimientoCAE' => Carbon::now()->addDays(15),
            'Observaciones' => 'Nota de crédito por devolución',
            'NumeroTurno' => 1,
            'ReferenciaTurno' => 1,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'LetraPuntoVentaNumeroIdProveedor2' => 'A-0001-3001-1',
        ]);

        ItemNotaCreditoCompra::create([
            'IdNotaCreditoCompra' => 1,
            'IdCuentaGastos' => 1,
            'Descripcion' => 'Devolución de insumos',
            'NroDeposito' => 1,
            'Cantidad' => 5,
            'PrecioUnitario' => 100,
            'IdImpuestoIva' => 1,
            'AlicuotaIVA' => 21,
            'Total' => 605,
            'AjusteTotal' => 0,
            'AfectarPlanillaTurno' => false,
            'ControlarStock' => true,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);

        MinutaCompra::create([
            'Numero' => 4001,
            'NumeroCompleto' => 'MC-4001',
            'FechaEmision' => Carbon::now(),
            'IdProveedor' => 1,
            'TipoOperacion' => 'Resumen de compra',
            'Total' => 5000,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);

        ItemMinutaCompra::create([
            'IdMinutaCompra' => 1,
            'Descripcion' => 'Resumen de insumos',
            'Total' => 5000,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);
    }
}
