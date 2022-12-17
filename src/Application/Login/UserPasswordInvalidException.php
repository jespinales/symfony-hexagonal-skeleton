<?php

namespace App\Application\Login;

use App\Application\ApplicationException;
use Throwable;

class UserPasswordInvalidException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(
            "Invalid user password.",
            409
        );
    }
}