<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\User;

trait ControllerTrait
{
    private function login()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }
}
