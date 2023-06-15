<?php

namespace Tests\Unit\Services;

use App\Exceptions\Services\CountiesServiceBrasilApiException;
use App\Services\CountiesServiceBrasilAPI;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CountiesServiceBrasilAPIUTest extends TestCase
{
    public function testGetCountiesBrasilAPIByUfThanSuccessful(): void
    {
        $uf = 'SE';
        $apiResponse = [
            ['nome' => 'Aracaju', 'codigo_ibge' => 2800308],
            ['nome' => 'Araua', 'codigo_ibge' => 2800407],
        ];

        Http::fake([
            '*' => Http::response($apiResponse, 200)
        ]);

        $service = $this->createCountiesServiceBrasilAPIInstance();
        $counties = $service->getCountiesByUF($uf);

        $this->assertEquals(2, count($counties));
        $this->assertEquals('Aracaju', $counties[0]['name']);
        $this->assertEquals(2800308, $counties[0]['ibge_code']);
        $this->assertEquals('Araua', $counties[1]['name']);
        $this->assertEquals(2800407, $counties[1]['ibge_code']);
    }

    public function testGetCountiesBrasilAPIByUfThanFailure(): void
    {
        $uf = 'SE';
        $apiResponse = [];

        Http::fake([
            '*' => Http::response($apiResponse, 400)
        ]);

        $this->expectException(CountiesServiceBrasilApiException::class);

        $service = $this->createCountiesServiceBrasilAPIInstance();
        $service->getCountiesByUF($uf);
    }

    private function createCountiesServiceBrasilAPIInstance(): CountiesServiceBrasilAPI
    {
        return new CountiesServiceBrasilAPI();
    }
}