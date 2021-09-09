<?php

namespace App\Application\Shared\Model\User;

use App\Domain\User\User;

interface IUserCollectionDataTransformer
{
    /**
     * @param User[] $users
     */
    public function write(array $users): self;

    public function read(): array;
}