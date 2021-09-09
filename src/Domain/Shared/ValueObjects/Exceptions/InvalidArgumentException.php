<?php

namespace App\Domain\Shared\ValueObjects\Exceptions;

class InvalidArgumentException extends \InvalidArgumentException
{
    const MESSAGE = "The %s entered is invalid";
    const CODE = 422;

    public function __construct(
        string $attribute,
        string $message = null,
        int $code = null,
        \Throwable $previous = null
    ){
        $message = $message ?? sprintf(self::MESSAGE, $attribute);
        $code = $code ?? self::CODE;

        parent::__construct($message, $code, $previous);
    }
}