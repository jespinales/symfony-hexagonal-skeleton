<?php

namespace App\Application\DeleteUser;

class DeleteUserRequest
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }
}