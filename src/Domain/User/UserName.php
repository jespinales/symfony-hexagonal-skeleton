<?php

namespace App\Domain\User;

use App\Domain\Shared\ValueObjects\Exceptions\StringLengthException;

class UserName
{
    const MAX_LENGTH = 50;
    const ATTRIBUTE = 'name';

    private string $name;

    public function __construct(string $name)
    {
        $name = $this->sanitize( trim($name) );
        $this->validate($name);
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    private function validate(string $name)
    {
        if(strlen($name) > 50){
            throw new StringLengthException(self::ATTRIBUTE, self::MAX_LENGTH);
        }
    }

    private function sanitize(string $name): string
    {
        return filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    }
}