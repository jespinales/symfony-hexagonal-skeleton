<?php

namespace App\Domain\User;


class UserName
{
    const MAX_LENGTH = 50;
    const ATTRIBUTE = 'name';

    private string $name;

    public function __construct(string $name)
    {
        $this->assertLength($name);
        $this->assertFormat($name);
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function equals(UserName $userName): bool
    {
        return $this->name === $userName->name();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    private function assertLength(string $name)
    {
        if(strlen($name) > self::MAX_LENGTH){
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

    private function assertFormat(string $name)
    {
        if( !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚ ]+$/', $name) ){
            throw new \InvalidArgumentException(
                sprintf(
                    "The %s entered hasn't a valid format.",
                    self::ATTRIBUTE
                ),
                422
            );
        }
    }
}