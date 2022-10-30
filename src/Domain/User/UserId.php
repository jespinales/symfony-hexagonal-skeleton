<?php

namespace App\Domain\User;


class UserId
{
    const MAX_LENGTH = 36;
    const ATTRIBUTE = 'id';

    protected string $id;

    public function __construct(string $id)
    {
        $this->validate($id);

        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function equals(UserId $userId): bool
    {
        return $this->id == $userId->id();
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function validate(string $id = null)
    {
        if(strlen($id) > self::MAX_LENGTH){
            throw new \InvalidArgumentException(
                sprintf(
                    'The %s entered exceeds the length of %u',
                    self::ATTRIBUTE,
                    self::MAX_LENGTH
                ),
                422
            );
        }

        if( !preg_match('/\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b/', $id) ){
            throw new \InvalidArgumentException(
                sprintf(
                    'The %s entered is invalid',
                    self::ATTRIBUTE
                ),
                422
            );
        }
    }
}