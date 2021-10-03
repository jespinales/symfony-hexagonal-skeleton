<?php

namespace App\Domain\User;


class UserEmail
{
    const MAX_LENGTH = 100;
    const ATTRIBUTE = 'email';

    private string $email;

    public function __construct(string $email)
    {
        $email = $this->sanitize( trim($email) );
        $this->validate($email);
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

    private function validate(string $email)
    {
        if(strlen($email) > self::MAX_LENGTH){
            throw new \InvalidArgumentException(
                printf(
                    'The %s entered exceeds the length of %n',
                    self::ATTRIBUTE,
                    self::MAX_LENGTH
                ),
                422
            );
        }

        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$email){
            throw new \InvalidArgumentException(
                printf(
                    'The %s entered is invalid',
                    self::ATTRIBUTE
                ),
                422
            );
        }
    }

    private function sanitize(string $name): string
    {
        return filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    }

    public function __toString(): string
    {
        return $this->email;
    }
}