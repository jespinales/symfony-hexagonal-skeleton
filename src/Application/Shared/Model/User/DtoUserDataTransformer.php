<?php

namespace App\Application\Shared\Model\User;

use App\Domain\User\User;

class DtoUserDataTransformer implements IUserDataTransformer
{
    private array $data;

    public function write(User $user): self
    {
        $this->data = [
            'id' => $user->getId()->id(),
            'name' => $user->getName()->name(),
            'email' => $user->getEmail()->email()
        ];

        return $this;
    }

    public function read(): array
    {
        return $this->data;
    }
}