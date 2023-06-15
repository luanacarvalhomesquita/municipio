<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseJson
{
    public function responseJson(
        ?string $errorMessage = null,
        ?int $statusCode = Response::HTTP_OK,
        ?array $data = []
    ): JsonResponse {
        if ($errorMessage) {
            $data['message'] = $errorMessage;
        }

        return response()->json(
            data: $data,
            status: $statusCode,
        );
    }
}
