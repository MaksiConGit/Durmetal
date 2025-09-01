<?php

namespace Database\Seeders;

use App\Models\ConversorDureza;
use App\Models\MensajeUsuario;
use App\Models\PlantillaCarga;
use App\Models\PlantillaEmail;
use App\Models\PuntoEntrada;
use App\Models\Regla;
use App\Models\Tarjeta;
use App\Models\Terminal;
use App\Models\TipoMensajeUsuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SistemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConversorDureza::create([
            'ValorHB'   => 120,
            'ValorHRC'  => 63,
            'ValorKMM2' => 1176,
            'ValorMPA'  => 1176,
            'ValorKSI'  => 171,
        ]);

        ConversorDureza::create([
            'ValorHB'   => 150,
            'ValorHRC'  => 70,
            'ValorKMM2' => 1470,
            'ValorMPA'  => 1470,
            'ValorKSI'  => 213,
        ]);

        ConversorDureza::create([
            'ValorHB'   => 200,
            'ValorHRC'  => 80,
            'ValorKMM2' => 1960,
            'ValorMPA'  => 1960,
            'ValorKSI'  => 284,
        ]);

        TipoMensajeUsuario::create([
            'Nombre' => 'Info',
            'Color' => 0xFFFFFF,
            'ColorFondo' => 0x0000FF,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'Activo' => 1,
        ]);

        TipoMensajeUsuario::create([
            'Nombre' => 'Alerta',
            'Color' => 0xFF0000,
            'ColorFondo' => 0xFFFF00,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'Activo' => 1,
        ]);

        TipoMensajeUsuario::create([
            'Nombre' => 'Error',
            'Color' => 0xFFFFFF,
            'ColorFondo' => 0xFF0000,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'Activo' => 1,
        ]);

        MensajeUsuario::create([
            'IdUsuario' => 1,
            'IdTipoMensajeUsuario' => 1,
            'FechaHora' => now(),
            'Mensaje' => 'Bienvenido',
            'Observaciones' => '',
            'Visto' => 0,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'Activo' => 1,
        ]);

        MensajeUsuario::create([
            'IdUsuario' => 1,
            'IdTipoMensajeUsuario' => 2,
            'FechaHora' => now(),
            'Mensaje' => 'Revisar documentos',
            'Observaciones' => 'Urgente',
            'Visto' => 0,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'Activo' => 1,
        ]);

        MensajeUsuario::create([
            'IdUsuario' => 1,
            'IdTipoMensajeUsuario' => 3,
            'FechaHora' => now(),
            'Mensaje' => 'Error en sistema',
            'Observaciones' => 'Fallo crítico',
            'Visto' => 0,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'Activo' => 1,
        ]);

        PlantillaEmail::create([
            'Nombre' => 'Bienvenida',
            'Tema' => 'Bienvenida al sistema',
            'Mensaje' => 'Gracias por registrarte',
        ]);

        PlantillaEmail::create([
            'Nombre' => 'Recordatorio',
            'Tema' => 'Recordatorio de pago',
            'Mensaje' => 'No olvides tu pago mensual',
        ]);

        PlantillaEmail::create([
            'Nombre' => 'Aviso',
            'Tema' => 'Actualización del sistema',
            'Mensaje' => 'Se realizarán cambios esta noche',
        ]);

        PuntoEntrada::create([
            'Nombre' => 'Entrada 1',
            'Orden' => 1,
        ]);

        PuntoEntrada::create([
            'Nombre' => 'Entrada 2',
            'Orden' => 2,
        ]);

        PuntoEntrada::create([
            'Nombre' => 'Entrada 3',
            'Orden' => 3,
        ]);

        Regla::create([
            'IdPuntoEntrada' => 1,
            'Nombre' => 'Regla 1',
            'SecuenciaCondiciones' => 'Cond1>Cond2',
            'Orden' => 1,
        ]);

        Regla::create([
            'IdPuntoEntrada' => 2,
            'Nombre' => 'Regla 2',
            'SecuenciaCondiciones' => 'Cond3>Cond4',
            'Orden' => 2,
        ]);

        Regla::create([
            'IdPuntoEntrada' => 3,
            'Nombre' => 'Regla 3',
            'SecuenciaCondiciones' => 'Cond5>Cond6',
            'Orden' => 3,
        ]);

        Terminal::create([
            'NombreHost' => 'Terminal01',
            'IdImpresoraFiscal' => 1,
            'NombreEtiquetadora' => 'Etiq01',
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
        ]);

        Terminal::create([
            'NombreHost' => 'Terminal02',
            'IdImpresoraFiscal' => 1,
            'NombreEtiquetadora' => 'Etiq02',
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
        ]);

        Terminal::create([
            'NombreHost' => 'Terminal03',
            'IdImpresoraFiscal' => 1,
            'NombreEtiquetadora' => 'Etiq03',
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
        ]);

        Tarjeta::create([
            'Nombre' => 'Tarjeta A',
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'Archivado' => 0,
        ]);

        Tarjeta::create([
            'Nombre' => 'Tarjeta B',
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
            'Archivado' => 1,
        ]);

        Tarjeta::create([
            'Nombre' => 'Tarjeta C',
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => 0,
            'Archivado' => 0,
        ]);
    }
}
