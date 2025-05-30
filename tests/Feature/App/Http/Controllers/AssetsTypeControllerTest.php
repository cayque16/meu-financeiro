<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\AssetsType;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class AssetsTypeControllerTest extends TestCase
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

        $response = $this->get("/assets_type");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("assets_type.index");
    }

    public function testCreate()
    {
        $this->login();
        $response = $this->get('/assets_type/create');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("assets_type.create_edit");
    }

    public function testStore()
    {
        $this->login();
        $data = [
            "nome" => "test",
            "descricao" => "desc",
        ];

        $response = $this->post("/assets_type", $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/assets_type");
        $this->assertDatabaseHas("assets_type", [
            "name" => "test",
            "description" => "desc",
        ]);
    }

    /**
     * @dataProvider providerValidations
     */
    public function testStoreFailsValidation(
        $key1,
        $value1,
        $failed
    ) {
        $this->login();
        $data = [
            $key1 => $value1,
        ];

        $response = $this->post("/assets_type", $data);

        $response->assertSessionHasErrors([$failed]);
    }

    public function testEdit()
    {
        $this->login();
        $type = AssetsType::factory()->create();

        $response = $this->get("/assets_type/edit/{$type->id}");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("assets_type.create_edit");
    }

    public function testUpdate()
    {
        $this->login();
        $type = AssetsType::factory()->create();

        $response = $this->post("/assets_type/update/{$type->id}", [
            "nome" => "test",
            "descricao" => "desc"
        ]);
        
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/assets_type");
        $this->assertDatabaseHas("assets_type", [
            'id' => $type->id,
            'name' => 'test',
            'description'=> 'desc'
        ]);
    }

    /**
     * @dataProvider providerValidations
     */
    public function testUpdateFailsValidation(
        $key1,
        $value1,
        $failed
    ) {
        $this->login();
        $type = AssetsType::factory()->create();

        $response = $this->post("/assets_type/update/{$type->id}", [
            $key1 => $value1,
        ]);

        $response->assertSessionHasErrors([$failed]);
    }

    public function testActivate()
    {
        $this->login();
        $uuid = (string) Str::uuid();
        $type = AssetsType::factory()->create([
            'id' => $uuid,
            'deleted_at' => now(),
        ]);
        
        $response = $this->get("/assets_type/enable/{$type->id}/1");        
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/assets_type");
        $this->assertDatabaseHas("assets_type", [
            "id" => $type->id,
            "deleted_at" => null,
        ]);
    }

    public function testDisable()
    {
        $this->login();
        $type = AssetsType::factory()->create();

        $this->assertDatabaseHas("assets_type", [
            "id" => $type->id,
            "deleted_at" => null,
        ]);
        $response = $this->get("/assets_type/enable/{$type->id}/0");
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/assets_type");
        $this->assertDatabaseMissing("assets_type", [
            "id" => $type->id,
            "deleted_at" => null,
        ]);
    }

    protected function providerValidations()
    {
        return [
            "nomeMissing" => ["descricao", "desc",  "nome"],
            "descricaoMissing" => ["nome", "test",  "descricao"],
        ];
    }
}
