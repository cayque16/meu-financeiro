<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Currency;
use Core\Domain\Enum\DividendType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DividendPayment>
 */
class DividendPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randomType = collect(DividendType::cases())->random();
        return [
            'id' => Str::uuid(),
            'asset_id' => Asset::inRandomOrder()->value('uuid'),
            'date' => $this->faker->date(),
            'type' => $randomType,
            'amount' => $this->faker->numberBetween(1,1000),
            'currency_id' => Currency::inRandomOrder()->value('id'),
        ];
    }
}
