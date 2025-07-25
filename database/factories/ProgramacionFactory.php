<?php

namespace Database\Factories;

use App\Models\Programacion;
use App\Models\ItemOrdenTrabajo;
use App\Models\TipoProgramacion;
use App\Models\MedioEnfriamiento;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramacionFactory extends Factory
{
    protected $model = Programacion::class;

    public function definition(): array
    {
        $idItemOrdenTrabajo = ItemOrdenTrabajo::whereBetween('id', [93502, 93555])
            ->inRandomOrder()
            ->value('id');

        return [
            'IdItemOrdenTrabajo' => $idItemOrdenTrabajo ?? 93502,
            'NumeroProgramacion' => $this->faker->unique()->numberBetween(1, 999),
            'DurezaMinima' => $this->faker->numberBetween(50, 60),
            'DurezaMaxima' => $this->faker->numberBetween(61, 70),
            'IdTipoProgramacion' => TipoProgramacion::inRandomOrder()->value('id') ?? 1,
            'Cantidad' => $this->faker->randomFloat(3, 1, 10),
            'Apto' => $this->faker->randomElement(['SI', 'NO']),
            'Reproceso' => $this->faker->boolean(),
            'FechaCreacion' => now()->subDays(rand(1, 10)),
            'FechaCarga' => now(),
            'FechaDescarga' => now()->addDays(rand(1, 3)),
            'Temperatura' => $this->faker->numberBetween(100, 300),
            'IdMedioEnfriamiento' => MedioEnfriamiento::inRandomOrder()->value('id') ?? 1,
            'NumeroHorno' => $this->faker->numberBetween(1, 5),
            'EjecutadoPorOperador' => 700,
            'CreadoPor' => 700,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 700,
            'Activo' => 1,
        ];
    }
}
