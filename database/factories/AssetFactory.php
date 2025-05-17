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
            'id' => $this->faker->numberBetween(1),
            'uuid' => (string) Str::uuid(),
            'codigo' => $this->faker->lexify('?????'),
            'descricao' => $this->faker->sentence(1),
            'id_assets_type' => AssetsType::inRandomOrder()->value('id'),
            'uuid_assets_type' => AssetsType::inRandomOrder()->value('uuid'),
            'e_excluido' => 0,
            // 'deleted_at' => null,
            'created_at' => now(),
        ];
    }
}
