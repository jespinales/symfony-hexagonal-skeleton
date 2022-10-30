<?php

namespace App\Domain\User;


class UserEmail
{
    const MAX_LENGTH = 100;
    const ATTRIBUTE = 'email';

    private string $email;

    public function __construct(string $email)
    {
        $this->assertLength($email);
        $this->assertFormat($email);
        $this->email = $email;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function equals(UserEmail $email): bool
    {
        return $email->email() === $this->email;
    }

    private function assertLength(string $email)
    {
        if(strlen($email) > self::MAX_LENGTH){
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

    private function assertFormat(string $email)
    {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$email){
            throw new \InvalidArgumentException(
                sprintf(
                    "The %s entered hasn't a valid format.",
                    self::ATTRIBUTE
                ),
                422
            );
        }
    }

    public function __toString(): string
    {
        return $this->email;
    }
}