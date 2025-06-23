<?php

namespace Database\Factories;

use App\Models\Tratamiento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tratamiento>
 */
class TratamientoFactory extends Factory
{
    protected $model = Tratamiento::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Nombre' => $this->faker->word(),
            'Descripcion' => $this->faker->word(),
            'Coeficiente' => 0,
            'Orden' => 0,
            'Predeterminado' => 0,
            'Archivado' => 0,
        ];
    }
}
