<?php

namespace App\Application\Login;

class LoginRequest
{
    private string $password;
    private string $email;

    public function __construct(string $password, string $email)
    {
        $this->password = $password;
        $this->email = $email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function email(): string
    {
        return $this->email;
    }
}