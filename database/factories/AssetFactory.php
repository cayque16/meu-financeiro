<?php

namespace Database\Factories;

use App\Models\AssetsType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
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
            'code' => $this->faker->lexify('?????'),
            'description' => $this->faker->sentence(1),
            'assets_type_id' => AssetsType::inRandomOrder()->value('id'),
            'deleted_at' => null,
            'created_at' => now(),
        ];
    }
}
