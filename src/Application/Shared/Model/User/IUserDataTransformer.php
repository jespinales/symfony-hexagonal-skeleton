<?php

namespace App\Application\Shared\Model\User;

use App\Domain\User\User;

interface IUserDataTransformer
{
    public function write(User $user): self;

    public function read(): mixed;
}