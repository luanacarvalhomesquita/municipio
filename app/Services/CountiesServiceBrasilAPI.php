<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CountiesServiceBrasilAPI implements CountiesServiceInterface
{
    private const GET_CONTRIES_URL = "/ibge/municipios/";
    private const VERSION_API = "/v1";

    public function getCountiesByUF(string $uf): array
    {
        $response = $this->fetchCountiesFromAPI($uf);

        if ($response->ok()) {
            return $this->formatCounties($response->json());
        }

        throw new \Exception('Não foi possível obter os municípios da API BrasilAPI.');
    }

    public function fetchCountiesFromAPI(string $uf): Response
    {
        try {
            $baseUrlApi = $this->getBaseUrlBasilApi();
            return Http::get(sprintf($baseUrlApi . self::GET_CONTRIES_URL . self::VERSION_API . "/$uf"));
        } catch (\Exception $e) {
            throw new \Exception('Não foi possível obter os municípios da API BrasilAPI. Tente novamente!');
        }
    }

    public function formatCounties(array $counties): array
    {
        return array_map(fn($county) => [
            'name' => $county['nome'],
            'ibge_code' => $county['codigo_ibge'],
        ], $counties);
    }

    private function getBaseUrlBasilApi(): string
    {
        return env('BASE_URL_BRASIL_API');
    }
}
