<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class CountiesServiceIBGE implements CountiesServiceInterface
{
    private const GET_CONTRIES_URL = "/localidades/estados/%s/municipios";
    private const VERSION_API = "/v1";

    public function getCountiesByUF(string $uf): array
    {
        $response = $this->fetchCountiesFromAPI($uf);

        if ($response->ok()) {
            return $this->formatCounties($response->json());
        }

        throw new \Exception('Não foi possível obter os municípios da API do IBGE.');
    }

    public function fetchCountiesFromAPI(string $uf): Response
    {
        try {
            $baseUrlApi = $this->getBaseUrlBasilApi();
            return Http::get(sprintf($baseUrlApi . self::VERSION_API . self::GET_CONTRIES_URL , $uf));
        } catch (\Exception $e) {
            throw new \Exception('Não foi possível obter os municípios da API IBGE. Tente novamente!');
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
