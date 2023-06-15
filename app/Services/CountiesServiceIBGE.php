<?php

namespace App\Services;

use App\Exceptions\Services\CountiesServiceIBGEException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class CountiesServiceIBGE implements CountiesServiceInterface
{
    private const GET_CONTRIES_URL = "/v1/localidades/estados/%s/municipios";

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

        throw new CountiesServiceIBGEException();
    }

    /**
     * Buscar uma lista de municípios via API.
     *
     * @param string $uf Sigla da UF.
     * @return Response
     */
    public function fetchCountiesFromAPI(string $uf): Response
    {
        try {
            $baseUrlApi = $this->getBaseUrlBasilApi();
            return Http::get(sprintf($baseUrlApi . self::GET_CONTRIES_URL, $uf));
        } catch (\Exception $e) {
            throw new CountiesServiceIBGEException();
        }
    }

    /**
     * Formatar uma lista de municípios.
     *
     * @param array $counties lista de municipios.
     * @return array
     */
    public function formatCounties(array $counties): array
    {
        return array_map(fn ($county) => [
            'name' => $county['nome'],
            'ibge_code' => $county['id']
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
        return env('BASE_URL_IBGE_API');
    }
}
