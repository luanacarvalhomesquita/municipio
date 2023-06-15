<?php

namespace App\Services;

use App\Exceptions\Services\CountiesServiceBrasilApiException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CountiesServiceBrasilAPI implements CountiesServiceInterface
{
    private const GET_CONTRIES_URL = '/ibge/municipios/v1/';

    public function getCountiesByUF(string $uf): array
    {
        $response = $this->fetchCountiesFromAPI($uf);

        if ($response->ok()) {
            return $this->formatCounties($response->json());
        }

        throw new CountiesServiceBrasilApiException();
    }

    public function fetchCountiesFromAPI(string $uf): Response
    {
        try {
            $baseUrlApi = $this->getBaseUrlBasilApi();
            return Http::get(sprintf($baseUrlApi . self::GET_CONTRIES_URL . $uf));
        } catch (\Exception $e) {
            throw new CountiesServiceBrasilApiException();
        }
    }

    public function formatCounties(array $counties): array
    {
        return array_map(fn ($county) => [
            'name' => $county['nome'],
            'ibge_code' => $county['codigo_ibge'],
        ], $counties);
    }

    private function getBaseUrlBasilApi(): string
    {
        return env('BASE_URL_BRASIL_API');
    }
}
