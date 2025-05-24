<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetsType;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Support\Str;

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

     /**
     * @dataProvider providerValidations
     */
    public function testStoreFailsValidation(
        $key1,
        $value1,
        $key2,
        $value2,
        $failed
    ) {
        $this->login();
        $data = [
            $key1 => $value1,
            $key2 => $value2,
        ];

        $response = $this->post("/assets", $data);

        $response->assertSessionHasErrors([$failed]);
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

    public function testUpdate()
    {
        $this->login();
        $type = AssetsType::factory()->create();
        $asset = Asset::factory()->create();

        $response = $this->post("/assets/update/{$asset->uuid}", [
            "codigo" => "test",
            "descricao" => "desc",
            "id_assets_type" => $type->uuid,
        ]);
        
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/assets");
        $this->assertDatabaseHas("assets", [
            'id' => $asset->id,
            'uuid' => $asset->uuid,
            'codigo' => 'test',
            'descricao'=> 'desc',
            "uuid_assets_type" => $type->uuid,
        ]);
    }

    public function testActivate()
    {
        $this->login();
        $uuid = (string) Str::uuid();
        AssetsType::factory()->create();
        $asset = Asset::factory()->create([
            "uuid" => $uuid,
            "deleted_at" => now(),
        ]);

        $response = $this->get("/assets/enable/{$asset->uuid}/1");        
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/assets");
        $this->assertDatabaseHas("assets", [
            "uuid" => $asset->uuid,
            "deleted_at" => null,
        ]);
    }

    public function testDisable()
    {
        $this->login();
        AssetsType::factory()->create();
        $asset = Asset::factory()->create();

        $this->assertDatabaseHas("assets", [
            "uuid" => $asset->uuid,
            "deleted_at" => null,
        ]);
        $response = $this->get("/assets/enable/{$asset->uuid}/0");
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/assets");
        $this->assertDatabaseMissing("assets", [
            "uuid" => $asset->uuid,
            "deleted_at" => null,
        ]);
    }

    /**
     * @dataProvider providerValidations
     */
    public function testUpdateFailsValidation(
        $key1,
        $value1,
        $key2,
        $value2,
        $failed
    ) {
        $this->login();
        AssetsType::factory()->create();
        $asset = Asset::factory()->create();

        $response = $this->post("/assets/update/{$asset->uuid}", [
            $key1 => $value1,
            $key2 => $value2,
        ]);

        $response->assertSessionHasErrors([$failed]);
    }

    protected function providerValidations()
    {
        return [
            "codigoMissing" => ["descricao", "desc", "id_assets_type", "uuid", "codigo"],
            "descricaoMissing" => ["codigo", "test", "id_assets_type", "uuid", "descricao"],
            "idAssetsTypeMissing" => ["codigo", "test", "descricao", "desc", "id_assets_type"],
        ];
    }
}
