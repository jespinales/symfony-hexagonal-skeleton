<?php

namespace App\Domain\User;

class UserPassword
{
    const MAX_HASH_LENGTH = 100;
    const MAX_LENGTH = 50;
    const MIN_LENGTH = 4;
    const ATTRIBUTE = 'password';

    private string $hash;

    private function __construct(
        string           $value,
        bool             $isHash,
        IPasswordHashing $passwordHashing = null)
    {
        if ($isHash) {
            $this->assertMaxHashLength($value);
        } else {
            $this->assertMinLength($value);
            $this->assertMaxLength($value);
            $value = $passwordHashing->passwordHashing($value);
        }

        $this->hash = $value;
    }

    public static function fromPlaneText(
        string           $password,
        IPasswordHashing $passwordHashing): self
    {
        return new self($password, false, $passwordHashing);
    }

    public static function fromHash(string $hash): self
    {
        return new self($hash, true);
    }

    public function hash(): string
    {
        return $this->hash;
    }

    public function __toString(): string
    {
        return $this->hash;
    }

    private function assertMaxLength(string $password)
    {
        if (strlen($password) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The %s entered exceeds the length of %u.',
                    self::ATTRIBUTE,
                    self::MAX_LENGTH
                ),
                422
            );
        }
    }

    private function assertMinLength(string $password)
    {
        if (strlen($password) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The entered %s must have a minimum of %u characters.',
                    self::ATTRIBUTE,
                    self::MIN_LENGTH
                ),
                422
            );
        }
    }

    private function assertMaxHashLength(string $hash)
    {
        if (strlen($hash) > self::MAX_HASH_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The hash exceeds the length of %u.',
                    self::MAX_HASH_LENGTH
                ),
                422
            );
        }
    }
}