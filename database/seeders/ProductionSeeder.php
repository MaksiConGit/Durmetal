<?php

namespace Database\Seeders;

use App\Models\CodigoComplejidad;
use App\Models\Dureza;
use App\Models\ImpresoraFiscal;
use App\Models\ItemOrdenTrabajo;
use App\Models\Material;
use App\Models\MedioEnfriamiento;
use App\Models\OrdenTrabajo;
use App\Models\Programacion;
use App\Models\PuntoDeVenta;
use App\Models\SecuenciaPtoVenta;
use App\Models\TipoCbte;
use App\Models\TipoProgramacion;
use App\Models\Tratamiento;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImpresoraFiscal::create([
            'Nombre' => 'EPSON Pr Fiscal PLAYA',
            'Modelo' => 'EPSON TMU220AF',
            'PuertoCOM' => '0',
            'VelocidadPrEpson' => '3',
            'TipoProtocoloPrEpson' => '0',
            'FechaUltimoCierreZ' => '2017-05-10 14:00:00',
            'PuertoComOcxIFEpson' => '1',
            'VelocidadOcxIFEpson' => '9600',
        ]);

        PuntoDeVenta::create([
            'Nombre' => '5 - AFIP WS',
            'Numero' => '5',
            'Tipo' => 'ELECTRONICO',   
            'NotaCreditoComparteTalonario' => '0',
            'NotaDebitoComparteTalonario' => '0',
            'IdTipoRemitoVentaPorDefecto' => '0',
            'IdImpresoraFiscal' => '1',
            'UtilizarDomicilioConfiguracionGlobal' => '1',
            'DomicilioEmpresa' => null,
            'TelefonoEmpresa' => null,
            'LocalidadEmpresa' => null,
            'ProvinciaEmpresa' => null,
            'CodigoSucursal' => null,
            'FechaCreacion' => null,
            'CreadoPor' => '1',
            'FechaActualizacion' => null,
            'ActualizadoPor' => '1',
            'Activo' => '1',
        ]);

        TipoCbte::create([
            'Nombre' => 'FC A',
        ]);

        SecuenciaPtoVenta::create([
            'IdPtoVenta' => '1',
            'IdTipoCbte' => '1',
            'Secuencia' => '1',
            'ImprimirNumero' => '0',
            'ImprimirNumeroCompleto' => '0',
            'ImprimirTipoCbte' => '0',
            'NombreTipoCbte' => null,
        ]);

        Dureza::create([
            'Nombre' => 'HB',
            'Descripcion' => 'DUREZA BRINELL 3000/10',
            'Predeterminado' => '0',
        ]);

        Material::create([
            'Nombre' => '16CrMn5',
            'Descripcion' => 'AC.CEMENTACION',
            'Predeterminado' => '0',
        ]);
        
        Tratamiento::create([
            'Nombre' => 'REC2',
            'Descripcion' => 'RECOCIDO FUNDICIONES,OTROS',
            'Coeficiente' => '0.00',
            'Orden' => '10',
            'Predeterminado' => '0',
            'Archivado' => '0',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'ARENADO',
            'Precio' => 150.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 10.0,
            'Coeficiente' => 1.1,
            'CC' => 1,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-001',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'CONSTITUCION',
            'Precio' => 250.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 20.0,
            'Coeficiente' => 1.2,
            'CC' => 2,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-002',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'REVENIDO',
            'Precio' => 350.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 30.0,
            'Coeficiente' => 1.3,
            'CC' => 3,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => false,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-003',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'ARENADO',
            'Precio' => 150.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 10.0,
            'Coeficiente' => 1.1,
            'CC' => 1,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-001',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'CONSTITUCION',
            'Precio' => 250.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 20.0,
            'Coeficiente' => 1.2,
            'CC' => 2,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-002',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'REVENIDO',
            'Precio' => 350.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 30.0,
            'Coeficiente' => 1.3,
            'CC' => 3,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => false,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-003',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'ARENADO',
            'Precio' => 150.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 10.0,
            'Coeficiente' => 1.1,
            'CC' => 1,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-001',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'CONSTITUCION',
            'Precio' => 250.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 20.0,
            'Coeficiente' => 1.2,
            'CC' => 2,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-002',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'REVENIDO',
            'Precio' => 350.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 30.0,
            'Coeficiente' => 1.3,
            'CC' => 3,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => false,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-003',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'ARENADO',
            'Precio' => 150.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 10.0,
            'Coeficiente' => 1.1,
            'CC' => 1,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-001',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'CONSTITUCION',
            'Precio' => 250.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 20.0,
            'Coeficiente' => 1.2,
            'CC' => 2,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => true,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-002',
        ]);

        CodigoComplejidad::create([
            'IdTratamiento' => 1,
            'Descripcion' => 'REVENIDO',
            'Precio' => 350.00,
            'Divisa' => 'ARS',
            'PorcentajeCoeficiente' => 30.0,
            'Coeficiente' => 1.3,
            'CC' => 3,
            'FechaCreacion' => Carbon::now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => Carbon::now(),
            'ActualizadoPor' => 1,
            'Activo' => false,
            'IdTratamientoCodigoComplejidad' => 'TRT-CC-003',
        ]);

        OrdenTrabajo::create([
            'Letra' => 'X',
            'PuntoVenta' => '1',
            'Numero' => '64196',
            'NumeroCompleto' => 'OT X 0001-00064196',
            'NumeroRemitoCliente' => '4558',
            'FechaEmision' => '2017-05-10 14:00:00',
            'FechaVencimiento' => '2017-05-10 14:00:00',
            'AfectarPlanillaTurno' => '1',
            'CondicionPrecios' => 'A',
            'IdCliente' => '1',
            'RazonSocial' => 'MECANIZAR -LUIS FERRONI-',
            'IdCondicionIva' => '1',
            'TipoDocumentoCliente' => 'CUIT',
            'NumeroDocumentoCliente' => '20060801577',
            'Direccion' => 'DORREGO 140',
            'Localidad' => 'VILLA CONSTITUCION',
            'Provincia' => 'Santa Fe',
            'Estado' => 'PENDIENTE',
            'Total' => '0.00',
            'Observaciones' => null,
            'NumeroTurno' => '0',
            'ReferenciaTurno' => '2020',
            'AjusteCtaCtePlanillaTurno' => '0.00',
            'FechaCreacion' => '2017-05-10 14:00:00',
            'CreadoPor' => '1',
            'FechaActualizacion' => null,
            'ActualizadoPor' => '1',
            'Activo' => '1',
            'PuntoVentaNumero' => '1.64196',
            'IdClienteEstado' => '38,PENDIENTE',
            'IdClienteFechaEmisionPuntoVentaNumero' => '38,20241105,1,64196',
            'CantidadImpresiones' => '0',
            'CantidadEnviosPorCorreo' => '0',
            'Archivado' => '0',
        ]);

        ItemOrdenTrabajo::create([
            'IdOrdenTrabajo' => '1',
            'IdMaterial' => '1',
            'IdTratamiento' => '1',
            'IdDureza' => '1',
            'ItemNumero' => '1',
            'Descripcion' => 'CUBETA OT:7835',
            'NroDeposito' => '1',
            'Cantidad' => '3.000',
            'Peso' => '19.50',
            'CodigoComplejidad' => '0',
            'Coeficiente' => '0.000',
            'DurezaSolicitadaMinima' => '60',
            'DurezaSolicitadaMaxima' => '64',
            'PrecioUnitario' => '0.000',
            'Total' => '0.00',
            'AfectaPlanillaTurno' => '0',
            'ControlarStock' => '0',
            'Estado' => 'APROBADO',
            'FechaActualizacionEstado' => now(),
            'FechaCreacion' => now(),
            'CreadoPor' => '1',
            'FechaActualizacion' => now(),
            'ActualizadoPor' => '1',
            'Activo' => '1',
            'CertificadoEmitido' => '0',
            'CantidadCertificadosImpresos' => '1',
            'CantidadCertificadosEnviadosPorCorreo' => '1',
            'Observaciones' => null,
            'CantidadProgramaciones' => '2',
            'ConNotaEnvio' => '0',
            'IDEstadoConNotaEnvio' => '93494,APROBADO,0s',
            'IDIdOrdenTrabajoIdMaterialIdTratamientoCodigoComplejidadEstado' => '93494,55217,179,40.0.APROBADO',
        ]);

        MedioEnfriamiento::create([
            'Nombre' => 'AF',
            'Orden' => '5',
            'Predeterminado' => '1',
        ]);

        TipoProgramacion::create([
            'Nombre' => 'TEMPLADO',
            'Tipo' => 'PCO',
            'Orden' => '1',
            'Predeterminado' => '1',
            'RequiereNumeracionSiempre' => '0',
            'NombreTipo' => 'TEMPLADO,PCO',
        ]);

        Programacion::create([
            'IdItemOrdenTrabajo' => '1',
            'NumeroProgramacion' => '1',
            'DurezaMinima' => '62',
            'DurezaMaxima' => '63',
            'IdTipoProgramacion' => '1',
            'Cantidad' => '2.000',
            'Apto' => 'SI',
            'Reproceso' => '0',
            'FechaCreacion' => '2025-05-27 20:16:17',
            'FechaCarga' => now(),
            'FechaDescarga' => now(),
            'Temperatura' => '150',
            'IdMedioEnfriamiento' => '1',
            'NumeroHorno' => '1',
            'EjecutadoPorOperador' => '1',
            'CreadoPor' => '1',
            'FechaActualizacion' => '2025-05-27 20:16:17',
            'ActualizadoPor' => '1',
            'Activo' => '1',
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
            'id' => '1',
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
