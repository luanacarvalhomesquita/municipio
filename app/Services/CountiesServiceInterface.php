<?php

namespace App\Services;

use Illuminate\Http\Client\Response;

interface CountiesServiceInterface
{
    /**
     * Retornar uma lista de municípios de uma UF.
     *
     * @param string $uf Sigla da UF.
     * @return array
     */
    public function getCountiesByUF(string $uf): array;

    /**
     * Formatar uma lista de municípios.
     *
     * @param string $uf Sigla da UF.
     * @return Response
     */
    public function fetchCountiesFromAPI(string $uf): Response;

    /**
     * Formatar uma lista de municípios.
     *
     * @param array $counties lista de municipios.
     * @return array
     */
    public function formatCounties(array $counties): array;
}
