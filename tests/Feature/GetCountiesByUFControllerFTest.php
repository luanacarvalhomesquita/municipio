<?php

namespace Tests\Feature;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetCountiesByUFControllerFTest extends TestCase
{
    public function testGetCountiesByUFSuccess(): void
    {
        $apiResponse = [
            ['nome' => 'Aracaju', 'codigo_ibge' => 2800308],
            ['nome' => 'Araua', 'codigo_ibge' => 2800407],
        ];

        Http::fake([
            '*/SE' => Http::response($apiResponse, 200)
        ]);

        $response = $this->get("api/municipios/SE");

        $response->assertStatus(HttpResponse::HTTP_OK);

        $this->assertNotEmpty($response->json());
    }

    public function testGetCountiesByUFFailure(): void
    {
        $apiResponse = [
            ['nome' => 'Aracaju', 'codigo_ibge' => 2800308],
            ['nome' => 'Araua', 'codigo_ibge' => 2800407],
        ];

        Http::fake([
            '*/SE' => Http::response($apiResponse, 400)
        ]);

        $response = $this->get("api/municipios/SE");
        $response->assertStatus(400);
    }
}
