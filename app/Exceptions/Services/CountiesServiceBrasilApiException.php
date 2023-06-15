<?php

namespace App\Exceptions\Services;

use App\Exceptions\GenericException;
use Illuminate\Http\Response;

class CountiesServiceBrasilApiException extends GenericException
{
    private const ERROR_MESSAGE = 'Não foi possível obter os municípios da API BrasilAPI.';

    public function __construct()
    {
        parent::__construct(
            status: Response::HTTP_BAD_REQUEST,
            error: self::ERROR_MESSAGE
        );
    }
}
