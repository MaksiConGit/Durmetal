<?php

namespace Database\Seeders;

use App\Models\ConfiguracionGlobal;
use App\Models\FactorPremio;
use App\Models\FactorPremioUsuario;
use App\Models\ItemPremio;
use App\Models\Premio;
use App\Models\FacturaVenta;
use App\Models\ImpuestoIva;
use App\Models\ItemFacturaVenta;
use App\Models\ItemMinutaVenta;
use App\Models\ItemNotaCreditoVenta;
use App\Models\ItemNotaEnvio;
use App\Models\ItemReciboVenta;
use App\Models\MinutaVenta;
use App\Models\NotaCreditoVenta;
use App\Models\NotaEnvio;
use App\Models\ReciboVenta;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConfiguracionGlobal::create([
            'RazonSocialEmpresa' => 'Empresa Ejemplo S.A.',
            'DomicilioEmpresa' => 'Calle Falsa 123',
            'TelefonoEmpresa' => '011-1234-5678',
            'CUITEmpresa' => '30-12345678-9',
            'IIBBEmpresa' => '1234567890',
            'FechaInicioActividadesEmpresa' => '2010-01-15',
            'LocalidadEmpresa' => 'Buenos Aires',
            'ProvinciaEmpresa' => 'Buenos Aires',
            'CodigoSucursal' => 1,
            'ImporteMinimoRetencionIIBB' => 1,
            'CodigoPostalEmpresa' => 1,
            'NroAgenteEmpresa' => 1010,
            'EsAgenteRetencionGanancias' => 1,
            'EsAgenteRetencionIIBB' => false,
            'CuentaEmailMembretes' => 'membretes@empresa.com',
            'CuentaEmail' => 'info@empresa.com',
            'ServidorSMTP' => 'smtp.empresa.com',
            'PuertoSMTP' => '587',
            'UsuarioSMTP' => 'usuarioSMTP',
            'ClaveSMTP' => 'claveSMTP123',
            'TiempoDeEsperaSMTP' => 30,
            'OpcionSMTP' => 1,
            'CuentaEmailCCO' => 'cco@empresa.com',
            'RemitenteCCO' => false,
            'XMLLoginTicketRequest' => 'ruta/al/loginTicketRequest.xml',
            'MofoOperacionFE' => 'mofo123',
            'RutaCertificadoFE' => 'ruta/al/certificado.pfx',
            'ClaveCertificadoFE' => 'claveCert123',
            'ClaveForzarValidacionCtaCteCliente' => 'claveVal123',
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'CuentaEmailCertificados' => 'certificados@empresa.com',
            'ServidorSMTPCertificados' => 'smtp.certificados.com',
            'PuertoSMTPCertificados' => '1234',
            'UsuarioSMTPCertificados' => 'usuarioCert',
            'ClaveSMTPCertificados' => 'claveCert123',
            'TiempoDeEsperaSMTPCertificados' => 25,
            'OpcionSMTPCertificados' => 2,
            'CuentaEmailCCOCertificados' => 'cco_cert@empresa.com',
            'RemitenteCCOCertificados' => 1,
            'ValidarProgramacionesSinDatosDurezas' => 1,
            'NombreLogo' => 'logo_empresa.png',
            'PlazoVencimientoFactura' => 15,
            'USD_ARS' => 1010.25,
            'FechaActualizacionUSD_ARS' => Carbon::now()->subDays(1),
            'FechaEmisionValidaDesde' => 20240101,
            'FechaEmisionValidaHasta' => 20241231,
        ]);

        FactorPremio::create([
            'Nombre' => 'Proactividad',
            'ValorPredeterminado' => '1.00',
            'FechaCreacion' => now(),
            'CreadoPor' => '1',
            'FechaActualizacion' => now(),
            'ActualizadoPor' => '1',
            'Activo' => '1',
        ]);

        FactorPremio::create([
            'Nombre' => 'Presentismo',
            'ValorPredeterminado' => '2.00',
            'FechaCreacion' => now(),
            'CreadoPor' => '1',
            'FechaActualizacion' => now(),
            'ActualizadoPor' => '1',
            'Activo' => '1',
        ]);

        FactorPremio::create([
            'Nombre' => 'Predisposición Trab. en Equipo',
            'ValorPredeterminado' => '1.00',
            'FechaCreacion' => now(),
            'CreadoPor' => '1',
            'FechaActualizacion' => now(),
            'ActualizadoPor' => '1',
            'Activo' => '1',
        ]);

        FactorPremioUsuario::create([
            'IdUsuario' => '1',
            'IdFactorPremio' => '1',
            'Valor' => '2.00',
            'FechaCreacion' => now(),
            'CreadoPor' => '1',
            'FechaActualizacion' => now(),
            'ActualizadoPor' => '1',
            'Activo' => '1',
        ]);

        FactorPremioUsuario::create([
            'IdUsuario' => '1',
            'IdFactorPremio' => '2',
            'Valor' => '1.00',
            'FechaCreacion' => now(),
            'CreadoPor' => '1',
            'FechaActualizacion' => now(),
            'ActualizadoPor' => '1',
            'Activo' => '1',
        ]);

        Premio::create([
            'Nombre' => 'JUNIO 2025',
            'FechaDesde' => now(),
            'FechaHasta' => now(),
            'Premio' => 1000000.22,
            'Estado' => 'COMPLETO',
            'FechaCreacion' => now(),
            'CreadoPor' => '1',
            'FechaActualizacion' => now(),
            'ActualizadoPor' => '1',
        ]);

        ItemPremio::create([
            'IdPremio' => '1',
            'IdUsuario' => 1,
            'PremioBase' => 300000,
            'IndiceBase' => 1,
            'Coeficiente' => 0.9,
            'Premio' => 300000 * 1 * 0.9,
            'FechaCreacion' => now(),
            'CreadoPor' => '1',
            'FechaActualizacion' => now(),
            'ActualizadoPor' => '1',
        ]);

        NotaEnvio::create([
            'Letra' => 'A',
            'PuntoVenta' => 1,
            'Numero' => 1001,
            'NumeroCompleto' => '0001-00001001',
            'FechaEmision' => Carbon::now()->subDays(2)->toDateString(),
            'FechaVencimiento' => Carbon::now()->addDays(30)->toDateString(),
            'AfectarPlanillaTurno' => 1,
            'CondicionPrecios' => 'Contado',
            'IdCliente' => 1,
            'RazonSocial' => 'Cliente Ejemplo S.A.',
            'IdCondicionIva' => 1,
            'TipoDocumento' => 'CUIT',
            'NumeroDocumentoCliente' => '30711222334',
            'Direccion' => 'Calle Falsa 123',
            'Localidad' => 'Ciudad Ejemplo',
            'Provincia' => 'Buenos Aires',
            'Estado' => 'PENDIENTE',
            'TipoOperacion' => 'Normal',
            'PorcentajeDescuento' => 10.00,
            'Neto' => 10000.00,
            'IVA' => 2100.00,
            'Total' => 12100.00,
            'Observaciones' => 'Entrega en 48 hs.',
            'NumeroTurno' => 1234,
            'ReferenciaTurno' => 5678,
            'AjusteCtaCtePlanillaTurno' => 0.00,
            'FechaCreacion' => Carbon::now()->subDays(2)->toDateString(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now()->toDateString(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'PuntoVentaNumero' => '0001',
            'CantidadImpresiones' => 1,
            'CantidadEnviosPorCorreo' => 0,
        ]);

        ItemNotaEnvio::create([
            'IdNotaEnvio' => 1,
            'IdItemOrdenTrabajo' => 1,
            'ItemNumero' => 1,
            'Descripcion' => 'Servicio técnico de impresora',
            'Cantidad' => 2,
            'Peso' => 1.5,
            'CodigoComplejidad' => 3,
            'Coeficiente' => 1.25,
            'PrecioUnitario' => 5000.00,
            'PorcentajeDescuento' => 10.00,
            'Total' => 9000.00,
            'Estado' => 'PENDIENTE',
            'FechaCreacion' => Carbon::now()->subDays(1)->toDateString(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now()->toDateString(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
        ]);

        FacturaVenta::create([
            'Letra' => 'A',
            'PuntoVenta' => 1,
            'Numero' => 1001,
            'NumeroCompleto' => '0001-00001001',
            'FechaEmision' => now(),
            'FechaVencimiento' => '2025-12-31',
            'FechaEstadisticas' => now(),
            'TipoOperacion' => 'Normal',
            'CondicionPrecios' => 'Contado',
            'IdCliente' => 1,
            'RazonSocial' => 'Cliente S.A.',
            'TipoDocumentoCliente' => 'CUIT',
            'Direccion' => 'Av. Siempre Viva 742',
            'Localidad' => 'Springfield',
            'IdCondicionIva' => 1,
            'CondicionVenta' => 'Contado',
            'Neto' => 10000,
            'NetoNoGravado' => 0,
            'Exento' => 0,
            'IVA' => 2100,
            'ImpuestoInterno' => 0,
            'Total' => 12100,
            'AjusteCtaCtePlanillaTurno' => 0,
            'Estado' => 'Emitida',
            'CAE' => '12345678901234',
            'FechaVencimientoCAE' => '2025-12-31',
            'IdSolicitudCAE' => 999,
            'Observaciones' => 'Sin observaciones',
            'NumeroTurno' => 123,
            'ReferenciaTurno' => 456,
            'AfectarPlanillaTurno' => 1,
            'EsNotaDeDebito' => false,
            'NroFacturaNotaDebito' => null,
            'EntregarMercaderiaConRemitos' => 1,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'CantidadImpresiones' => 1,
            'CantidadEnviosPorCorreo' => 0
        ]);

        FacturaVenta::create([
            'Letra' => 'A',
            'PuntoVenta' => 1,
            'Numero' => 1001,
            'NumeroCompleto' => '0001-00001001',
            'FechaEmision' => now(),
            'FechaVencimiento' => '2025-12-31',
            'FechaEstadisticas' => now(),
            'TipoOperacion' => 'Normal',
            'CondicionPrecios' => 'Contado',
            'IdCliente' => 1,
            'RazonSocial' => 'Cliente S.A.',
            'TipoDocumentoCliente' => 'CUIT',
            'Direccion' => 'Av. Siempre Viva 742',
            'Localidad' => 'Springfield',
            'IdCondicionIva' => 1,
            'CondicionVenta' => 'Contado',
            'Neto' => 10000,
            'NetoNoGravado' => 0,
            'Exento' => 0,
            'IVA' => 2100,
            'ImpuestoInterno' => 0,
            'Total' => 12100,
            'AjusteCtaCtePlanillaTurno' => 0,
            'Estado' => 'Emitida',
            'CAE' => '12345678901234',
            'FechaVencimientoCAE' => '2025-12-31',
            'IdSolicitudCAE' => 999,
            'Observaciones' => 'Sin observaciones',
            'NumeroTurno' => 123,
            'ReferenciaTurno' => 456,
            'AfectarPlanillaTurno' => 1,
            'EsNotaDeDebito' => true,
            'NroFacturaNotaDebito' => null,
            'EntregarMercaderiaConRemitos' => 1,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'CantidadImpresiones' => 1,
            'CantidadEnviosPorCorreo' => 0
        ]);

        ImpuestoIva::create([
            'Nombre' => 'IVA 21%',
            'Tasa' => 21.00,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'Observaciones' => 'Tasa general del IVA'
        ]);

        ImpuestoIva::create([
            'Nombre' => 'IVA 10.5%',
            'Tasa' => 10.50,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'Observaciones' => 'Tasa reducida del IVA'
        ]);

        ImpuestoIva::create([
            'Nombre' => 'IVA Exento',
            'Tasa' => 0.00,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'Observaciones' => 'Operaciones exentas del IVA'
        ]);

        ItemFacturaVenta::create([
            'IdFacturaVenta' => 1,
            'ItemNumero' => 1,
            // 'IdArticulo' => null,
            'Descripcion' => 'Servicio de mantenimiento',
            'NroDeposito' => 1,
            'Cantidad' => 2,
            'PrecioCosto' => 4000.00,
            'PrecioUnitarioNeto' => 5000.00,
            'PrecioUnitario' => 6050.00,
            'IdImpuestoIva' => 1,
            'AlicuotaIVA' => 21.00,
            'ImpuestoInterno' => 0,
            'ImpuestoCombustible' => 0,
            'ImpuestoTV' => 0,
            'ImpuestosInternos' => 0,
            'Neto' => 10000.00,
            'IVA' => 2100.00,
            'Total' => 12100.00,
            'AfectarPlanillaTurno' => 1,
            'ControlarStock' => 1,
            'Estado' => 'Activo',
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => 1
        ]);

        NotaCreditoVenta::create([
            'IdFacturaVenta' => 1,
            'Letra' => 'A',
            'PuntoVenta' => 1,
            'Numero' => 2001,
            'NumeroCompleto' => '0001-00002001',
            'FechaEmision' => Carbon::now()->subDays(1),
            'FechaVencimiento' => Carbon::now()->addDays(30),
            'FechaEstadisticas' => Carbon::now(),
            'TipoOperacion' => 'Devolucion',
            'CondicionPrecios' => 'Contado',
            'IdCliente' => 1,
            'RazonSocial' => 'Cliente S.A.',
            'IdCondicionIva' => 1,
            'TipoDocumentoCliente' => 'CUIT',
            'NumeroDocumentoCliente' => '30711222334',
            'Direccion' => 'Av. Siempre Viva 742',
            'Localidad' => 'Springfield',
            'Neto' => 5000.00,
            'NetoNoGravado' => 0.00,
            'IVA' => 1050.00,
            'Exento' => 0.00,
            'ImpuestoInterno' => 0.00,
            'Total' => 6050.00,
            'AjusteCtaCtePlanillaTurno' => 0.00,
            'Estado' => 'Emitida',
            'CAE' => '45678901234567',
            'FechaVencimientoCAE' => Carbon::now()->addDays(15),
            'IdSolicitudCAE' => 123456,
            'Observaciones' => 'Devolución de servicio',
            'NumeroTurno' => 321,
            'ReferenciaTurno' => 654,
            'AfectarPlanillaTurno' => false,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'CantidadImpresiones' => 1,
            'CantidadEnviosPorCorreo' => 0
        ]);

        ItemNotaCreditoVenta::create([
            'IdNotaCreditoVenta' => 1,
            'ItemNumero' => 1,
            'Descripcion' => 'Devolución por servicio no realizado',
            'NroDeposito' => 1,
            'Cantidad' => 1,
            'PrecioCosto' => 4000.00,
            'PrecioUnitarioNeto' => 5000.00,
            'PrecioUnitario' => 6050.00,
            'AlicuotaIVA' => 21.00,
            'ImpuestoInterno' => 0.00,
            'ImpuestoCombustible' => 0.00,
            'ImpuestoTV' => 0.00,
            'ImpuestosInternos' => 0.00,
            'Neto' => 5000.00,
            'IdImpuestoIva' => 1,
            'IVA' => 1050.00,
            'Total' => 6050.00,
            'AfectarPlanillaTurno' => false,
            'ControlarStock' => false,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => 1
        ]);

        ReciboVenta::create([
            'Letra' => 'A',
            'PuntoVenta' => 1,
            'Numero' => 3001,
            'NumeroCompleto' => '0001-00003001',
            'FechaEmision' => Carbon::now(),
            'IdCliente' => 1,
            'RazonSocial' => 'Cliente S.A.',
            'IdCondicionIva' => 1,
            'TipoDocumentoCliente' => 'CUIT',
            'NumeroDocumentoCliente' => '30711222334',
            'Direccion' => 'Av. Siempre Viva 742',
            'Localidad' => 'Springfield',
            'RetencionDREI' => 0,
            'RetencionIIBB' => 0,
            'RetencionIVA' => 0,
            'RetencionGanancias' => 0,
            'RetencionSUSS' => 0,
            'Estado' => 'Emitido',
            'Total' => 15000.00,
            'Observaciones' => 'Pago recibido',
            'NumeroTurno' => 789,
            'ReferenciaTurno' => 987,
            'AfectarPlanillaTurno' => 1,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'LetraNumeroCompleto' => 'A-0001-00003001',
            'CantidadImpresiones' => 1,
            'CantidadEnviosPorCorreo' => 0,
            'DescripcionSaldoTransportado' => 'Saldo a favor anterior',
            'ImporteSaldoTransportado' => 0.00
        ]);
        
        ItemReciboVenta::create([
            'IdReciboVenta' => 1,
            'IdFacturaVenta' => 1,
            'Descripcion' => 'Pago parcial factura 1001',
            'Total' => 5000.00,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => 1
        ]);

        MinutaVenta::create([
            'Numero' => 1,
            'NumeroCompleto' => 'MV-2025-' . str_pad(1, 4, '0', STR_PAD_LEFT),
            'FechaEmision' => Carbon::now()->subDays(rand(1, 30)),
            'IdCliente' => 1,
            'TipoOperacion' => 'Venta',
            'Estado' => 'Emitido',
            'Total' => rand(1000, 5000),
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);

        ItemMinutaVenta::create([
            'IdMinutaVenta' => 1,
            'Descripcion' => 'Producto o servicio',
            'Total' => rand(200, 1000),
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
        ]);
    }
}
