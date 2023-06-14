<?php

namespace App\Http\Controllers;

use App\Services\CountiesServiceInterface;
use Illuminate\Http\Response;

class GetCountiesByUFController extends Controller
{
    public function __construct(protected readonly CountiesServiceInterface $countiesService)
    {
    }

    public function __invoke(string $uf): Response
    {
        $counties = $this->countiesService->getCountiesByUF($uf);

        return response($counties);
    }
}
