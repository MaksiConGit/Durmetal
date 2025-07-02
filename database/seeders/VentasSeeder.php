<?php

namespace Database\Seeders;

use App\Models\ConfiguracionGlobal;
use App\Models\FactorPremio;
use App\Models\FactorPremioUsuario;
use App\Models\ItemPremio;
use App\Models\Premio;
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
            'NroAgenteEmpresa' => 1010,
            'EsAgenteRetencionGanancias' => true,
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
            'Activo' => true,
            'CuentaEmailCertificados' => 'certificados@empresa.com',
            'ServidorSMTPCertificados' => 'smtp.certificados.com',
            'UsuariosSMTPCertificados' => 'usuarioCert',
            'ClaveSMTPCertificados' => 'claveCert123',
            'TiempoDeEsperaSMTPCertificados' => 25,
            'OpcionSMTPCertificados' => 2,
            'CuentaEmailCCOCertificados' => 'cco_cert@empresa.com',
            'RemitenteCCOCertificados' => true,
            'ValidarProgramacionesSinDatosDurezas' => true,
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
    }
}
