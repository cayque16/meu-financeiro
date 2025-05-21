<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\AssetsType;
use Tests\TestCase;
use Illuminate\Http\Response;

class AssetsTypeControllerTest extends TestCase
{
    use ControllerTrait;    
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
        $this->assertDatabaseHas("assets_types", $data);
    }

    public function testEdit()
    {
        $this->login();
        $type = AssetsType::factory()->create();

        $response = $this->get("/assets_type/edit/{$type->uuid}");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("assets_type.create_edit");
    }

    public function testUpdate()
    {
        $this->login();
        $type = AssetsType::factory()->create();

        $response = $this->post("/assets_type/update/{$type->uuid}", [
            "nome" => "test",
            "descricao" => "desc"
        ]);
        
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/assets_type");
        $this->assertDatabaseHas("assets_types", [
            'uuid' => $type->uuid,
            'nome' => 'test',
            'descricao'=> 'desc'
        ]);
    }

}
