<?php

namespace App\Domain\User;

use Throwable;

class UserAlreadyExistsException extends \Exception
{
    const MESSAGE = 'User already exists';
    const CODE = 409;

    public function __construct($message = null, $code = null, Throwable $previous = null)
    {
        $message = $message ?? self::MESSAGE;
        $code = $code ?? self::CODE;

        parent::__construct($message, $code, $previous);
    }
}