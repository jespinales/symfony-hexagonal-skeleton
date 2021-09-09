<?php

namespace App\Domain\User;

use App\Domain\Shared\ValueObjects\Exceptions\InvalidArgumentException;
use App\Domain\Shared\ValueObjects\Exceptions\StringLengthException;

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

    private function validate(string $email)
    {
        if(strlen($email) > self::MAX_LENGTH){
            throw new StringLengthException(self::ATTRIBUTE, self::MAX_LENGTH);
        }

        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$email){
            throw new InvalidArgumentException(self::ATTRIBUTE);
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