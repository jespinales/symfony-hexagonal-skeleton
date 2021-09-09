<?php

namespace App\Infrastructure\Model\User\Doctrine;

use App\Domain\User\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DoctrineUserIdType extends Type
{
    const NAME = 'user_id';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): UserId
    {
        return new UserId($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}