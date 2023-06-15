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
}
