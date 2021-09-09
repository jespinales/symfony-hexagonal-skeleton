<?php

namespace App\Domain\Shared\ValueObjects\Exceptions;

class StringLengthException extends \InvalidArgumentException
{
    const MESSAGE = "The %s entered exceeds the length of %n";
    const CODE = 422;

    public function __construct(
        string $attribute,
        int $maxLength,
        string $message = null,
        int $code = null,
        \Throwable $previous = null
    ){
        $message = $message ?? sprintf(self::MESSAGE, $attribute, $maxLength);
        $code = $code ?? self::CODE;

        parent::__construct($message, $code, $previous);
    }
}