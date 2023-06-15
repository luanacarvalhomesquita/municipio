<?php

namespace App\Services;

use App\Exceptions\Services\CountiesServiceIBGEException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class CountiesServiceIBGE implements CountiesServiceInterface
{
    private const GET_CONTRIES_URL = "/v1/localidades/estados/%s/municipios";

    public function getCountiesByUF(string $uf): array
    {
        $response = $this->fetchCountiesFromAPI($uf);

        if ($response->ok()) {
            return $this->formatCounties($response->json());
        }

        throw new CountiesServiceIBGEException();
    }

    public function fetchCountiesFromAPI(string $uf): Response
    {
        try {
            $baseUrlApi = $this->getBaseUrlBasilApi();
            return Http::get(sprintf($baseUrlApi . self::GET_CONTRIES_URL, $uf));
        } catch (\Exception $e) {
            throw new CountiesServiceIBGEException();
        }
    }

    public function formatCounties(array $counties): array
    {
        return array_map(fn ($county) => [
            'name' => $county['nome'],
            'ibge_code' => $county['id']
        ], $counties);
    }

    private function getBaseUrlBasilApi(): string
    {
        return env('BASE_URL_IBGE_API');
    }
}
