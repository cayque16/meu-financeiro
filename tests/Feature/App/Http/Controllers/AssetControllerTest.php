<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetsType;
use Illuminate\Http\Response;
use Tests\TestCase;

class AssetControllerTest extends TestCase
{
    use ControllerTrait;

    public function testIndex()
    {
        $this->login();
        AssetsType::factory()->count(3)->create();
        Asset::factory()->count(3)->create();

        $response = $this->get("/assets");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("assets.index");
    }
}
