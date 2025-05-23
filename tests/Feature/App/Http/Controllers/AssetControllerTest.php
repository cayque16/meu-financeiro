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

    public function testCreate()
    {
        $this->login();
        $response = $this->get('/assets/create');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("assets.create_edit");
    }

    public function testStore()
    {
        $this->login();
        $type = AssetsType::factory()->create();
        $data = [
            "codigo" => "test",
            "id_assets_type" => $type->uuid,
            "descricao" => "desc",
        ];

        $response = $this->post("/assets", $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/assets");
        $this->assertDatabaseHas("assets", [
            "codigo" => "test",
            "uuid_assets_type" => $type->uuid,
            "descricao" => "desc",
        ]);
    }

    public function testEdit()
    {
        $this->login();
        AssetsType::factory()->create();
        $asset = Asset::factory()->create();

        $response = $this->get("/assets/edit/{$asset->uuid}");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("assets.create_edit");
    }
}
