<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Nombre' => $this->faker->word(),
            'Domicilio' => $this->faker->word(),
            'IdLocalidad' => 1,
            'Telefono' => $this->faker->numberBetween(10000000, 60000000),
            'IdCondicionIVA' => 1,
            'TipoDocumento' => 'CUIT',
            'NroDocumento' => $this->faker->numberBetween(10000000, 60000000),
            'LimiteSaldo' => 1,
            'SaldoSistemaAnterior' => 1,
            'Saldo' => $this->faker->randomDigit(),
            'CtaCteHabilitada' => 1,
            'CondicionPrecios' => 1,
            'Categoria' => 1,
            'FechaUltimoMovimiento' => now(),
            'EsCuentaMaestra' => 1,
            'ValidarCuentaPorLimiteSaldo' => 1,
            'ValidarCuentaPorSaldoActual' => 1,
            'IncluirRemitosEnSaldo' => 1,
            'IdTipoCliente' => 1,
            'IdCalificacionCliente' => 1,
            'FechaCreacion' => now(),
            'CreadoPor' => 1,
            'FechaActualizacion' => now(),
            'ActualizadoPor' => 1,
            'Activo' => 1,
        ];
    }
}
