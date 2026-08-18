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
use Spatie\Permission\Models\Role;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);

        Role::firstOrCreate(['name' => 'produccion']);

        $users = [
            ['id' => 3, 'Nombre' => 'Karbiche Marcelo Alejandro', 'Usuario' => 'marcelo.karbiche', 'SuperUsuario' => false, 'CobraPremio' => 1, 'IndiceBasePremio' => 1.0],
            ['id' => 4, 'Nombre' => 'Caruana Miguel Angel', 'Usuario' => 'miguel.caruana', 'SuperUsuario' => true,  'CobraPremio' => 0, 'IndiceBasePremio' => 1.0],
            ['id' => 5, 'Nombre' => 'Perezutti Jose Carlos', 'Usuario' => 'jose.perezutti', 'SuperUsuario' => false, 'CobraPremio' => 1, 'IndiceBasePremio' => 1.0],
            ['id' => 6, 'Nombre' => 'Silva Rolando German', 'Usuario' => 'rolando.silva', 'SuperUsuario' => false, 'CobraPremio' => 1, 'IndiceBasePremio' => 0.35],
            ['id' => 7, 'Nombre' => 'operador1', 'Usuario' => 'operador1', 'SuperUsuario' => false, 'CobraPremio' => 0, 'IndiceBasePremio' => 1.0],
            ['id' => 8, 'Nombre' => 'Karcher Lautaro', 'Usuario' => 'lautaro.karcher', 'SuperUsuario' => false, 'CobraPremio' => 1, 'IndiceBasePremio' => 0.15],
            ['id' => 9, 'Nombre' => 'Sistema Anterior', 'Usuario' => 'sistema.anterior', 'SuperUsuario' => false, 'CobraPremio' => 0, 'IndiceBasePremio' => 1.0],
            ['id' => 10, 'Nombre' => 'Marta Aladro', 'Usuario' => 'marta.aladro', 'SuperUsuario' => true,  'CobraPremio' => 0, 'IndiceBasePremio' => 1.0],
            ['id' => 11, 'Nombre' => 'Silva Rolando German', 'Usuario' => 'taller', 'SuperUsuario' => false, 'CobraPremio' => 0, 'IndiceBasePremio' => 1.0],
            ['id' => 12, 'Nombre' => 'Andres Freytes', 'Usuario' => 'andres.freytes', 'SuperUsuario' => false, 'CobraPremio' => 1, 'IndiceBasePremio' => 0.9],
        ];

        foreach ($users as $data) {

            $user = User::create([
                'id' => $data['id'],
                'Nombre' => $data['Nombre'],
                'Usuario' => $data['Usuario'],
                'Activo' => 1,
                'Firma' => 'firmas/firma' . $data['id'] . '.jpg',
                'CobraPremio' => $data['CobraPremio'],
                'IndiceBasePremio' => $data['IndiceBasePremio'],
                'FechaCreacion' => now(),
                'CreadoPor' => 1,
                'FechaActualizacion' => now(),
                'ActualizadoPor' => 1,
                'Contraseña' => '$2y$12$RfmcqnawgVnwBH4voQSaau3RPNW.OPq8FAuSXIcWlhTRKYfSr0emq',
            ]);

            $rol = $data['SuperUsuario'] ? 'admin' : 'produccion';
            $user->assignRole($rol);
        }

        // $user_admin = User::create([
        //     'id' => '1',
        //     'Nombre' => 'Usuario Administrador',
        //     'Usuario' => 'admin@admin',
        //     'FechaCreacion' => now(),
        //     'CreadoPor' => 1,
        //     'FechaActualizacion' => now(),
        //     'ActualizadoPor' => 1,
        //     'Activo' => 1,
        //     'Firma' => 'firmas/firma2.jpg',
        //     'CobraPremio' => 1,
        //     'IndiceBasePremio' => 1.0,
        //     'Contraseña' => '$2y$12$RfmcqnawgVnwBH4voQSaau3RPNW.OPq8FAuSXIcWlhTRKYfSr0emq',
        // ]);

        // $user_admin->assignRole('admin');

        // $user_produccion = User::create([
        //     'id' => '2',
        //     'Nombre' => 'Usuario Producción',
        //     'Usuario' => 'usuario@prod',
        //     'FechaCreacion' => now(),
        //     'CreadoPor' => 1,
        //     'FechaActualizacion' => now(),
        //     'ActualizadoPor' => 1,
        //     'Activo' => 1,
        //     'Firma' => 'firmas/firma3.jpg',
        //     'CobraPremio' => 1,
        //     'IndiceBasePremio' => 1.0,
        //     'Contraseña' => '$2y$12$RfmcqnawgVnwBH4voQSaau3RPNW.OPq8FAuSXIcWlhTRKYfSr0emq',
        // ]);

        // $user_produccion->assignRole('produccion');

        // Province::create([
        //     'id' => '1',
        //     'Nombre' => 'Buenos Aires',
        // ]);

        // City::create([
        //     'id' => '1',
        //     'Nombre' => 'San Nicolás de los Arroyos',
        //     'CP' => 'B2900',
        //     'IdProvincia' => '1',
        // ]);

        // $condiciones_iva = [
        //     'Exento',
        //     'Resp. inscripto',
        //     'Resp. no inscripto',
        //     'Cons. final',
        //     'Resp. monotributo',
        //     'Resp. no identificado',
        // ];

        // foreach ($condiciones_iva as $index => $nombre) {
        //     IvaCondition::create([
        //         'Nombre' => $nombre,
        //     ]);
        // }

        // ClientQualification::create([
        //     'id' => '1',
        //     'Nombre' => 'Sin calificar',
        // ]);

        // ClientType::create([
        //     'id' => '1',
        //     'Nombre' => 'General',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        // ]);
        // ClientType::create([
        //     'Nombre' => 'Agropecuario',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        // ]);
        // ClientType::create([
        //     'Nombre' => 'Tranportista',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        // ]);

        // Client::create([
        //     'Nombre' => 'DESARROLLOS INSDUSTRIALES',
        //     'Domicilio' => 'CHACO 74 SAN NICOLÁS',
        //     'IdLocalidad' => '1',
        //     'Telefono' => '0341-155-481810',
        //     'IdCondicionIVA' => '1',
        //     'TipoDocumento' => 'CUIT',
        //     'NroDocumento' => '30708681896',
        //     'LimiteSaldo' => '0',
        //     'SaldoSistemaAnterior' => '0',
        //     'Saldo' => '0',
        //     'CtaCteHabilitada' => '1',
        //     'CondicionPrecios' => 'A',
        //     'Categoria' => 'E',
        //     'FechaUltimoMovimiento' => null,
        //     'EsCuentaMaestra' => '0',
        //     'ValidarCuentaPorLimiteSaldo' => '0',
        //     'ValidarCuentaPorSaldoActual' => '0',
        //     'IncluirRemitosEnSaldo' => '0',
        //     'IdTipoCliente' => '1',
        //     'IdCalificacionCliente' => '1',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        // ]);

        // Client::create([
        //     'Nombre' => 'EXENTO',
        //     'Domicilio' => 'CHACO 74 SAN NICOLÁS',
        //     'IdLocalidad' => '1',
        //     'Telefono' => '0341-155-481810',
        //     'IdCondicionIVA' => '1',
        //     'TipoDocumento' => 'CUIT',
        //     'NroDocumento' => '30708681896',
        //     'LimiteSaldo' => '0',
        //     'SaldoSistemaAnterior' => '0',
        //     'Saldo' => '0',
        //     'CtaCteHabilitada' => '1',
        //     'CondicionPrecios' => 'A',
        //     'Categoria' => 'E',
        //     'FechaUltimoMovimiento' => null,
        //     'EsCuentaMaestra' => '0',
        //     'ValidarCuentaPorLimiteSaldo' => '0',
        //     'ValidarCuentaPorSaldoActual' => '0',
        //     'IncluirRemitosEnSaldo' => '0',
        //     'IdTipoCliente' => '1',
        //     'IdCalificacionCliente' => '1',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        // ]);

        // Client::create([
        //     'Nombre' => 'RESP. INSCRIPTO',
        //     'Domicilio' => 'CHACO 74 SAN NICOLÁS',
        //     'IdLocalidad' => '1',
        //     'Telefono' => '0341-155-481810',
        //     'IdCondicionIVA' => '2',
        //     'TipoDocumento' => 'CUIT',
        //     'NroDocumento' => '30708681896',
        //     'LimiteSaldo' => '0',
        //     'SaldoSistemaAnterior' => '0',
        //     'Saldo' => '0',
        //     'CtaCteHabilitada' => '1',
        //     'CondicionPrecios' => 'A',
        //     'Categoria' => 'E',
        //     'FechaUltimoMovimiento' => null,
        //     'EsCuentaMaestra' => '0',
        //     'ValidarCuentaPorLimiteSaldo' => '0',
        //     'ValidarCuentaPorSaldoActual' => '0',
        //     'IncluirRemitosEnSaldo' => '0',
        //     'IdTipoCliente' => '1',
        //     'IdCalificacionCliente' => '1',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        // ]);

        // Client::create([
        //     'Nombre' => 'RESP. NO INSCRIPTO',
        //     'Domicilio' => 'CHACO 74 SAN NICOLÁS',
        //     'IdLocalidad' => '1',
        //     'Telefono' => '0341-155-481810',
        //     'IdCondicionIVA' => '3',
        //     'TipoDocumento' => 'CUIT',
        //     'NroDocumento' => '30708681896',
        //     'LimiteSaldo' => '0',
        //     'SaldoSistemaAnterior' => '0',
        //     'Saldo' => '0',
        //     'CtaCteHabilitada' => '1',
        //     'CondicionPrecios' => 'A',
        //     'Categoria' => 'E',
        //     'FechaUltimoMovimiento' => null,
        //     'EsCuentaMaestra' => '0',
        //     'ValidarCuentaPorLimiteSaldo' => '0',
        //     'ValidarCuentaPorSaldoActual' => '0',
        //     'IncluirRemitosEnSaldo' => '0',
        //     'IdTipoCliente' => '1',
        //     'IdCalificacionCliente' => '1',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        // ]);

        // Client::create([
        //     'Nombre' => 'CONS. FINAL',
        //     'Domicilio' => 'CHACO 74 SAN NICOLÁS',
        //     'IdLocalidad' => '1',
        //     'Telefono' => '0341-155-481810',
        //     'IdCondicionIVA' => '4',
        //     'TipoDocumento' => 'CUIT',
        //     'NroDocumento' => '30708681896',
        //     'LimiteSaldo' => '0',
        //     'SaldoSistemaAnterior' => '0',
        //     'Saldo' => '0',
        //     'CtaCteHabilitada' => '1',
        //     'CondicionPrecios' => 'A',
        //     'Categoria' => 'E',
        //     'FechaUltimoMovimiento' => null,
        //     'EsCuentaMaestra' => '0',
        //     'ValidarCuentaPorLimiteSaldo' => '0',
        //     'ValidarCuentaPorSaldoActual' => '0',
        //     'IncluirRemitosEnSaldo' => '0',
        //     'IdTipoCliente' => '1',
        //     'IdCalificacionCliente' => '1',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        // ]);

        // Client::create([
        //     'Nombre' => 'RESP. MONOTRIBUTO',
        //     'Domicilio' => 'CHACO 74 SAN NICOLÁS',
        //     'IdLocalidad' => '1',
        //     'Telefono' => '0341-155-481810',
        //     'IdCondicionIVA' => '5',
        //     'TipoDocumento' => 'CUIT',
        //     'NroDocumento' => '30708681896',
        //     'LimiteSaldo' => '0',
        //     'SaldoSistemaAnterior' => '0',
        //     'Saldo' => '0',
        //     'CtaCteHabilitada' => '1',
        //     'CondicionPrecios' => 'A',
        //     'Categoria' => 'E',
        //     'FechaUltimoMovimiento' => null,
        //     'EsCuentaMaestra' => '0',
        //     'ValidarCuentaPorLimiteSaldo' => '0',
        //     'ValidarCuentaPorSaldoActual' => '0',
        //     'IncluirRemitosEnSaldo' => '0',
        //     'IdTipoCliente' => '1',
        //     'IdCalificacionCliente' => '1',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        // ]);

        // Client::create([
        //     'Nombre' => 'RESP. NO IDENTIFICADO',
        //     'Domicilio' => 'CHACO 74 SAN NICOLÁS',
        //     'IdLocalidad' => '1',
        //     'Telefono' => '0341-155-481810',
        //     'IdCondicionIVA' => '6',
        //     'TipoDocumento' => 'CUIT',
        //     'NroDocumento' => '30708681896',
        //     'LimiteSaldo' => '0',
        //     'SaldoSistemaAnterior' => '0',
        //     'Saldo' => '0',
        //     'CtaCteHabilitada' => '1',
        //     'CondicionPrecios' => 'A',
        //     'Categoria' => 'E',
        //     'FechaUltimoMovimiento' => null,
        //     'EsCuentaMaestra' => '0',
        //     'ValidarCuentaPorLimiteSaldo' => '0',
        //     'ValidarCuentaPorSaldoActual' => '0',
        //     'IncluirRemitosEnSaldo' => '0',
        //     'IdTipoCliente' => '1',
        //     'IdCalificacionCliente' => '1',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        // ]);

        // Email::create([
        //     'Email' => 'macaruana@durmetal.com.ar',
        //     'IdCliente' => '1',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        //     'IdClienteEmail' => '1,macaruana@durmetal.com.ar',
        // ]);
        
        // Email::create([
        //     'Email' => 'cliente@cliente',
        //     'IdCliente' => '1',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        //     'IdClienteEmail' => '1,cliente@cliente',
        // ]);

        // Email::create([
        //     'Email' => 'cliente@cliente1',
        //     'IdCliente' => '1',
        //     'FechaCreacion' => null,
        //     'CreadoPor' => '1',
        //     'FechaActualizacion' => null,
        //     'ActualizadoPor' => '1',
        //     'Activo' => '1',
        //     'IdClienteEmail' => '1,cliente@cliente1',
        // ]);
    }
}
