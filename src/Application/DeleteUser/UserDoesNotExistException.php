<?php

namespace App\Application\DeleteUser;

use App\Application\ApplicationException;

class UserDoesNotExistException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(
            "User doesn't exist.",
            409
        );
    }
}