<?php

namespace App\Http\Controllers;

use App\Services\CountiesServiceInterface;
use Illuminate\Http\JsonResponse;

class GetCountiesByUFController extends Controller
{
    public function __construct(
        protected readonly CountiesServiceInterface $countiesService
    ) {
    }

    public function __invoke(string $uf): JsonResponse
    {
        $counties = $this->countiesService->getCountiesByUF($uf);
        return $this->responseJson(data: $counties);
    }
}
