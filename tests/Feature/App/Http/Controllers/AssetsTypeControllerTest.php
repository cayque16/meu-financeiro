<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\AssetsType;
use Tests\TestCase;
use App\Models\User;

class AssetsTypeControllerTest extends TestCase
{
    public function testIndex()
    {
        $user = User::factory()->create();
        AssetsType::factory()->count(3)->create();
        $this->actingAs($user);

        $response = $this->get("/assets_type");
        $response->assertStatus(200);
        $response->assertViewIs("assets_type.index");
    }

    public function testEdit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $type = AssetsType::factory()->create();

        $response = $this->get("/assets_type/edit/{$type->uuid}");
        $response->assertStatus(200);
        $response->assertViewIs("assets_type.create_edit");
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $type = AssetsType::factory()->create();

        $response = $this->post("/assets_type/update/{$type->uuid}", [
            "nome" => "test",
            "descricao" => "desc"
        ]);
        
        $response->assertStatus(302);
        $response->assertRedirect("/assets_type");
        $this->assertDatabaseHas("assets_types", [
            'uuid' => $type->uuid,
            'nome' => 'test',
            'descricao'=> 'desc'
        ]);
    }
}
