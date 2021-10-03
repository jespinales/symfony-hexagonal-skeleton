<?php

namespace App\Application\RegisterUser;

use App\Domain\User\User;

class RegisterUserResponse
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function user(): array
    {
        return [
            'id' => $this->user->getId()->id(),
            'name' => $this->user->getName()->name(),
            'email' => $this->user->getEmail()->email(),
        ];
    }
}