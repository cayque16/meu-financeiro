<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Brokerage;
use Core\Domain\ValueObject\Cnpj;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Support\Str;

class BrokeragesControllerTest extends TestCase
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
        Brokerage::factory()->count(3)->create();

        $response = $this->get("/brokerages");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("brokerages.index");
    }

    public function testCreate()
    {
        $this->login();
        $response = $this->get('/brokerages/create');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("brokerages.create_edit");
    }

    public function testStore()
    {
        $this->login();
        $cnpj = Cnpj::random();
        $data = [
            'nome' => "test",
            'site' => "http://ohwu.mn/vecro",
            'cnpj' => $cnpj
        ];

        $response = $this->post("/brokerages", $data);
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/brokerages");
        $this->assertDatabaseHas("brokerages", [
            "name" => "test",
            "web_page" => "http://ohwu.mn/vecro",
            "cnpj" => $cnpj
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

        $response = $this->post("/brokerages", $data);

        $response->assertSessionHasErrors([$failed]);
    }

    public function testEdit()
    {
        $this->login();
        $brokerage = Brokerage::factory()->create();

        $response = $this->get("/brokerages/edit/{$brokerage->id}");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs("brokerages.create_edit");
    }

    public function testUpdate()
    {
        $this->login();
        $brokerage = Brokerage::factory()->create();

        $cnpj = Cnpj::random();
        $response = $this->post("/brokerages/update/{$brokerage->id}", [
            "nome" => "test",
            "site" => "http://raptu.ug/moh",
            "cnpj" => $cnpj
        ]);
        
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/brokerages");
        $this->assertDatabaseHas("brokerages", [
            'id' => $brokerage->id,
            'name' => 'test',
            'web_page'=> 'http://raptu.ug/moh',
            'cnpj' => $cnpj
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
        $brokerage = Brokerage::factory()->create();

        $response = $this->post("/brokerages/update/{$brokerage->id}", [
            $key1 => $value1,
            $key2 => $value2,
        ]);

        $response->assertSessionHasErrors([$failed]);
    }

    public function testActivate()
    {
        $this->login();
        $uuid = (string) Str::uuid();
        $brokerage = Brokerage::factory()->create([
            'id' => $uuid,
            'deleted_at' => now(),
        ]);
        
        $response = $this->get("/brokerages/enable/{$brokerage->id}/1");        
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/brokerages");
        $this->assertDatabaseHas("brokerages", [
            "id" => $brokerage->id,
            "deleted_at" => null,
        ]);
    }

    public function testDisable()
    {
        $this->login();
        $brokerage = Brokerage::factory()->create();

        $this->assertDatabaseHas("brokerages", [
            "id" => $brokerage->id,
            "deleted_at" => null,
        ]);
        $response = $this->get("/brokerages/enable/{$brokerage->id}/0");
        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("/brokerages");
        $this->assertDatabaseMissing("brokerages", [
            "id" => $brokerage->id,
            "deleted_at" => null,
        ]);
    }

    protected function providerValidations()
    {
        $cnpj = Cnpj::random();
        $webPage = "http://tir.gh/dajo";
        return [
            "nomeMissing" => ["site", $webPage, "cnpj", $cnpj, "nome"],
            "siteMissing" => ["nome", "name", "cnpj", $cnpj, "site"],
            "cnpjMissing" => ["nome", "name", "site", $webPage, "cnpj"],
        ];
    }
}
