<?php

namespace App\Application\Login;

use App\Application\ApplicationException;

class UserDoesntExistException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(
            "User doesn't exist.",
            409
        );
    }
}