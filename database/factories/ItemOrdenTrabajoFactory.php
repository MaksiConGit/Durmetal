<?php

namespace Database\Factories;

use App\Models\ItemOrdenTrabajo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemOrdenTrabajoFactory extends Factory
{
    protected $model = ItemOrdenTrabajo::class;

    public function definition(): array
    {
        return [
            'IdOrdenTrabajo' => 55257,
            'IdMaterial' => 1,
            'IdTratamiento' => 1,
            'IdDureza' => 1,
            'ItemNumero' => $this->faker->unique()->numberBetween(1, 9999),
            'Descripcion' => 'CUBETA OT:' . $this->faker->numberBetween(7000, 8000),
            'NroDeposito' => 1,
            'Cantidad' => $this->faker->randomFloat(3, 1, 10),
            'Peso' => $this->faker->randomFloat(2, 10, 50),
            'CodigoComplejidad' => '0',
            'Coeficiente' => '0.000',
            'DurezaSolicitadaMinima' => 60,
            'DurezaSolicitadaMaxima' => 64,
            'PrecioUnitario' => 0,
            'Total' => 0,
            'AfectaPlanillaTurno' => 0,
            'ControlarStock' => 0,
            'Estado' => 'APROBADO',
            'FechaActualizacionEstado' => now(),
            'FechaCreacion' => now(),
            'CreadoPor' => 700,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 700,
            'Activo' => 1,
            'CertificadoEmitido' => 0,
            'CantidadCertificadosImpresos' => 1,
            'CantidadCertificadosEnviadosPorCorreo' => 1,
            'Observaciones' => null,
            'CantidadProgramaciones' => 2,
            'ConNotaEnvio' => 0,
            'IDEstadoConNotaEnvio' => '93494,APROBADO,0s',
            'IDIdOrdenTrabajoIdMaterialIdTratamientoCodigoComplejidadEstado' => '93494,55217,179,40.0.APROBADO',
        ];
    }
}
