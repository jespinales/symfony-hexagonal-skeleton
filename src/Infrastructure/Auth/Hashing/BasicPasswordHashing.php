<?php

namespace App\Infrastructure\Auth\Hashing;

use App\Domain\User\IPasswordHashing;

class BasicPasswordHashing implements IPasswordHashing
{
    /**
     * @inheritDoc
     */
    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function passwordHashing(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}