<?php

namespace App\Infrastructure\Auth\Hashing;

use App\Domain\User\IPasswordHashing;

class Md5PasswordHashing implements IPasswordHashing
{
    const SALT = '3x4mP|3S4|+';

    /**
     * @inheritDoc
     */
    public function verify(string $password, string $hash): bool
    {
        return $hash === $this->calculateHash($password);
    }

    public function passwordHashing(string $password): string
    {
        return $this->calculateHash($password);
    }

    private function calculateHash(string $password): string
    {
        return md5($password . '_' .$this->salt());
    }

    private function salt(): string
    {
        return md5(self::SALT);
    }
}