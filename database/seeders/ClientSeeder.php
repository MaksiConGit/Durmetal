<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Client;
use App\Models\Cliente;
use App\Models\ClientQualification;
use App\Models\ClientType;
use App\Models\DocumentType;
use App\Models\Email;
use App\Models\IvaCondition;
use App\Models\Province;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => '$2y$12$RfmcqnawgVnwBH4voQSaau3RPNW.OPq8FAuSXIcWlhTRKYfSr0emq',
            'SuperUsuario' => 1,
            'NotificarErroresPorEmail' => 0,
            'EnviarReportePlanillaTurno' => 0,
            'UtilizarTurnoEntorno' => 1,
            'ArticuloShopPorDefecto' => '1',
            'NroTablero' => '1',
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'Firma' => null,
            'CobraPremio' => 1,
            'IndiceBasePremio' => 1.0,
        ]);

        Province::create([
            'Nombre' => 'Buenos Aires',
        ]);

        City::create([
            'Nombre' => 'San Nicolás de los Arroyos',
            'CP' => 'B2900',
            'IdProvincia' => '1',
        ]);

        IvaCondition::create([
            'Nombre' => 'Responsable inscripto',
        ]);

        ClientQualification::create([
            'Nombre' => 'Sin calificar',
        ]);

        ClientType::create([
            'Nombre' => 'General',
            'FechaCreacion' => null,
            'CreadoPor' => '1',
            'FechaActualizacion' => null,
            'ActualizadoPor' => '1',
            'Activo' => '1',
        ]);
        ClientType::create([
            'Nombre' => 'Agropecuario',
            'FechaCreacion' => null,
            'CreadoPor' => '1',
            'FechaActualizacion' => null,
            'ActualizadoPor' => '1',
            'Activo' => '1',
        ]);
        ClientType::create([
            'Nombre' => 'Tranportista',
            'FechaCreacion' => null,
            'CreadoPor' => '1',
            'FechaActualizacion' => null,
            'ActualizadoPor' => '1',
            'Activo' => '1',
        ]);

        Client::create([
            'Nombre' => 'DESARROLLOS INDUSTRIALES',
            'Domicilio' => 'CHACO 74 SAN NICOLÁS',
            'IdLocalidad' => '1',
            'Telefono' => '0341-155-481810',
            'IdCondicionIVA' => '1',
            'TipoDocumento' => 'CUIT',
            'NroDocumento' => '30708681896',
            'LimiteSaldo' => '0',
            'SaldoSistemaAnterior' => '0',
            'Saldo' => '0',
            'CtaCteHabilitada' => '1',
            'CondicionPrecios' => 'A',
            'Categoria' => 'E',
            'FechaUltimoMovimiento' => null,
            'EsCuentaMaestra' => '0',
            'ValidarCuentaPorLimiteSaldo' => '0',
            'ValidarCuentaPorSaldoActual' => '0',
            'IncluirRemitosEnSaldo' => '0',
            'IdTipoCliente' => '1',
            'IdCalificacionCliente' => '1',
            'FechaCreacion' => null,
            'CreadoPor' => '1',
            'FechaActualizacion' => null,
            'ActualizadoPor' => '1',
            'Activo' => '1',
        ]);

        Email::create([
            'Email' => 'cliente@cliente',
            'IdCliente' => '1',
            'FechaCreacion' => null,
            'CreadoPor' => '1',
            'FechaActualizacion' => null,
            'ActualizadoPor' => '1',
            'Activo' => '1',
            'IdClienteEmail' => '1,cliente@cliente',
        ]);

        Email::create([
            'Email' => 'cliente@cliente1',
            'IdCliente' => '1',
            'FechaCreacion' => null,
            'CreadoPor' => '1',
            'FechaActualizacion' => null,
            'ActualizadoPor' => '1',
            'Activo' => '1',
            'IdClienteEmail' => '1,cliente@cliente1',
        ]);
    }
}
