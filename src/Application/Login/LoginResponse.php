<?php

namespace App\Application\Login;

use App\Domain\User\User;

class LoginResponse
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function user()
    {
        return [
            'id' => $this->user->getId()->id(),
            'name' => $this->user->getName()->name(),
            'email' => $this->user->getEmail()->email(),
        ];
    }
}