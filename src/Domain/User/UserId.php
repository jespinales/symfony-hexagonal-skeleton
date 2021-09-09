<?php

namespace App\Domain\User;

use App\Domain\Shared\ValueObjects\Exceptions\InvalidArgumentException;
use App\Domain\Shared\ValueObjects\Exceptions\StringLengthException;

class UserId
{
    const MAX_LENGTH = 36;
    const ATTRIBUTE = 'id';

    protected string $id;

    public function __construct(string $id)
    {
        $id = $this->sanitize( trim($id) );
        $this->validate($id);

        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public static function sanitize(string $value)
    {
        return filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
    }

    public function validate(string $id = null)
    {
        if(strlen($id) > self::MAX_LENGTH){
            throw new StringLengthException(self::ATTRIBUTE, self::MAX_LENGTH);
        }

        if( !preg_match('/\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b/', $id) ){
            throw new InvalidArgumentException(self::ATTRIBUTE);
        }
    }
}