<?php

namespace App\Services;

use App\Exceptions\Services\CountiesServiceBrasilApiException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CountiesServiceBrasilAPI implements CountiesServiceInterface
{
    private const GET_CONTRIES_URL = '/ibge/municipios/v1/';

    /**
     * Listar municípios por UF.
     *
     * @param string $uf Sigla da UF.
     * @return array
     */
    public function getCountiesByUF(string $uf): array
    {
        $response = $this->fetchCountiesFromAPI($uf);

        if ($response->ok()) {
            return $this->formatCounties($response->json());
        }

        throw new CountiesServiceBrasilApiException();
    }

    /**
     * Busca uma lista de municípios via API.
     *
     * @param string $uf Sigla da UF.
     * @return Response
     */
    private function fetchCountiesFromAPI(string $uf): Response
    {
        try {
            $baseUrlApi = $this->getBaseUrlBasilApi();
            return Http::get(sprintf($baseUrlApi . self::GET_CONTRIES_URL . $uf));
        } catch (\Exception $e) {
            throw new CountiesServiceBrasilApiException();
        }
    }

    /**
     * Formatar uma lista de municípios.
     *
     * @param array $counties lista de municipios.
     * @return array
     */
    private function formatCounties(array $counties): array
    {
        return array_map(fn ($county) => [
            'name' => ucwords(strtolower($county['nome'])),
            'ibge_code' => $county['codigo_ibge'],
        ], $counties);
    }

    /**
     * Buscar a BaseUrl da API no .env
     *
     * @param array $counties lista de municipios.
     * @return string
     */
    private function getBaseUrlBasilApi(): string
    {
        return env('BASE_URL_BRASIL_API');
    }
}
