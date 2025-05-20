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

        $response = $this->get(route("assets_type.index"));
        $response->assertStatus(200);
    }
}
