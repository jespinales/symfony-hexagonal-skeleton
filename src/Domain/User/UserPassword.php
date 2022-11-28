<?php

namespace App\Domain\User;

class UserPassword
{
    const MAX_HASH_LENGTH = 100;
    const MAX_LENGTH = 50;
    const MIN_LENGTH = 4;
    const ATTRIBUTE = 'password';

    private string $hash;

    private function __construct(string $value, bool $isHash = false)
    {
        if($isHash){
            $this->assertMaxHashLength($value);
        } else {
            $this->assertMinLength($value);
            $this->assertMaxLength($value);
            $value = self::passwordHashing($value);
        }

        $this->hash = $value;
    }

    public static function fromPassword(string $password): self
    {
        return new self($password);
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
        if(strlen($password) > self::MAX_LENGTH){
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
        if(strlen($password) < self::MIN_LENGTH){
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
        if(strlen($hash) > self::MAX_HASH_LENGTH){
            throw new \InvalidArgumentException(
                sprintf(
                    'The hash exceeds the length of %u.',
                    self::MAX_HASH_LENGTH
                ),
                422
            );
        }
    }

    private static function passwordHashing(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}