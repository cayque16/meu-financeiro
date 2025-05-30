<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Models\Currency;
use App\Models\DividendPayment;
use Core\Domain\Enum\DividendType;
use Illuminate\Http\Response;
use Tests\TestCase;

class DividendsControllerTest extends TestCase
{
    use ControllerTrait;

    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     $this->markTestSkipped("ignored for now");
    // }

    public function testIndex()
    {
        $this->login();
        AssetsType::factory()->count(3)->create();
        Asset::factory()->count(3)->create();
        Currency::factory()->count(3)->create();
        DividendPayment::factory()->count(3)->create();

        $response = $this->get("/dividends");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("dividends.index");
    }

    public function testCreate()
    {
        $this->login();
        $response = $this->get('/dividends/create');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("dividends.create_edit");
    }

    public function testStore()
    {
        $this->login();
        AssetsType::factory()->create();
        $asset = Asset::factory()->create();
        $currency = Currency::factory()->create();

        $amount = 0.15;
        $data = [
            "id_asset" => $asset->id,
            "id_currency" => $currency->id,
            "fiscal_year" => 2025,
            "payment_date" => "15-04-1994",
            "type" => DividendType::DIVIDENDS->value,
            "amount" => $amount,
        ];

        $response = $this->post("/dividends", $data);
        // $response->dd();
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/dividends");
        $this->assertDatabaseHas("dividends_payments", [
            "asset_id" => $asset->id,
            "currency_id" => $currency->id,
            "fiscal_year" => 2025,
            "payment_date" => "1994-04-15 00:00:00",
            "type" => DividendType::DIVIDENDS->value,
            "amount" => $amount * $currency->split,
        ]);
    }

    /**
     * @dataProvider providerValidations
     */
    public function testStoreFailsValidation(array $data, string $failed)
    {
        $this->login();
        
        $response = $this->post("/dividends", $data);

        $response->assertSessionHasErrors([$failed]);
    }

    public static function providerValidations(): array
    {
        return [
            'missing id_asset' => [
                [
                    'id_asset'     => null,
                    'id_currency'  => 'uuid-currency-1',
                    'fiscal_year'  => 2024,
                    'payment_date' => '2024-05-01',
                    'type'         => DividendType::JCP->value,
                    'amount'       => 1000.50,
                ],
                "id_asset",
            ],

            'invalid fiscal_year - too low' => [
                [
                    'id_asset'     => 'uuid-asset-1',
                    'id_currency'  => 'uuid-currency-1',
                    'fiscal_year'  => 1800,
                    'payment_date' => '2024-05-01',
                    'type'         => DividendType::JCP->value,
                    'amount'       => 1000.50,
                ],
                "fiscal_year",
            ],

            'invalid fiscal_year - not int' => [
                [
                    'id_asset'     => 'uuid-asset-1',
                    'id_currency'  => 'uuid-currency-1',
                    'fiscal_year'  => 'dois mil e vinte',
                    'payment_date' => '2024-05-01',
                    'type'         => DividendType::JCP->value,
                    'amount'       => 1000.50,
                ],
                "fiscal_year",
            ],

            'invalid type - not enum' => [
                [
                    'id_asset'     => 'uuid-asset-1',
                    'id_currency'  => 'uuid-currency-1',
                    'fiscal_year'  => 2024,
                    'payment_date' => '2024-05-01',
                    'type'         => 'bonus',
                    'amount'       => 1000.50,
                ],
                "type",
            ],

            'missing amount' => [
                [
                    'id_asset'     => 'uuid-asset-1',
                    'id_currency'  => 'uuid-currency-1',
                    'fiscal_year'  => 2024,
                    'payment_date' => '2024-05-01',
                    'type'         => DividendType::JCP->value,
                    'amount' => null,   
                ],
                "amount",
            ],
        ];
    }
}
