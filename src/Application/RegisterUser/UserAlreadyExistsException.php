<?php

namespace App\Application\RegisterUser;


use App\Application\ApplicationException;

class UserAlreadyExistsException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct(
            'User already exists.',
            409
        );
    }
}