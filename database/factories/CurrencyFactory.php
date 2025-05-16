<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->name(),
            'symbol' => $this->faker->lexify('?????'),
            'iso_code' => strtoupper($this->faker->lexify('???')),
            'split' => 100,
            'decimals' => 2,
            'description' => $this->faker->sentence(1),
            'deleted_at' => null,
            'created_at' => now(),
        ];
    }
}
