<?php

namespace Database\Factories;

use App\Models\AssetsType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssetsType>
 */
class AssetsTypeFactory extends Factory
{
    protected $model = AssetsType::class;
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
            'description' => $this->faker->sentence(1),
            'deleted_at' => null,
            'created_at' => now(),
        ];
    }
}
