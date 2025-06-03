<?php

namespace Database\Factories;

use Core\Domain\ValueObject\Cnpj;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brokerage>
 */
class BrokerageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $now = now();
        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->name(),
            'web_page' => $this->faker->url(),
            'cnpj' => Cnpj::random(),
            'created_at' => $now,
            'updated_at' => $now,
            'deleted_at' => null,
        ];
    }
}
