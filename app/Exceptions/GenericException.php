<?php

namespace App\Exceptions;

use Exception;

abstract class GenericException extends Exception
{
    function __construct(
        private readonly int $status,
        private readonly string $error,
    ) {
    }

    final public function getStaus(): int
    {
        return $this->status;
    }

    final public function getError(): string
    {
        return $this->error;
    }
}
