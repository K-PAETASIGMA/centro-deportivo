<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cancha>
 */
class CanchaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'tipo' => 'tenis', // Asegúrate de que coincida EXACTAMENTE con tu migración
            'precio_por_hora' => 15,
        ];
    }
}
