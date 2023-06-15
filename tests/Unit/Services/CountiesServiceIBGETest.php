<?php

namespace Tests\Unit\Services;

use App\Exceptions\Services\CountiesServiceIBGEException;
use App\Services\CountiesServiceIBGE;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CountiesServiceIBGETest extends TestCase
{
    public function testGetCountiesByIBGEUfThanSuccessful(): void
    {
        $uf = 'SE';
        $apiResponse = [
            ['nome' => 'Aracaju', 'id' => 2800308],
            ['nome' => 'Araua', 'id' => 2800407],
        ];

        Http::fake([
            '*' => Http::response($apiResponse, 200)
        ]);

        $service = $this->createCountiesServiceIBGEInstance();
        $counties = $service->getCountiesByUF($uf);

        $this->assertEquals(2, count($counties));
        $this->assertEquals('Aracaju', $counties[0]['name']);
        $this->assertEquals(2800308, $counties[0]['ibge_code']);
        $this->assertEquals('Araua', $counties[1]['name']);
        $this->assertEquals(2800407, $counties[1]['ibge_code']);
    }

    public function testGetCountiesByIBGEUfThanFailure(): void
    {
        $uf = 'SE';
        $apiResponse = [];

        Http::fake([
            '*' => Http::response($apiResponse, 400)
        ]);

        $this->expectException(CountiesServiceIBGEException::class);

        $service = $this->createCountiesServiceIBGEInstance();
        $service->getCountiesByUF($uf);
    }

    private function createCountiesServiceIBGEInstance(): CountiesServiceIBGE
    {
        return new CountiesServiceIBGE();
    }
}
