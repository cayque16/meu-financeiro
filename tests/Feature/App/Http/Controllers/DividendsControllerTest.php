<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetsType;
use App\Models\Currency;
use App\Models\DividendPayment;
use Illuminate\Http\Response;
use Tests\TestCase;

class DividendsControllerTest extends TestCase
{
    use ControllerTrait;

    public function testIndex()
    {
        $this->login();
        AssetsType::factory()->count(3)->create();
        Asset::factory()->count(3)->create();
        Currency::factory()->count(3)->create();
        $test = DividendPayment::factory()->count(3)->create();

        $response = $this->get("/dividends");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("dividends.index");
    }
}
