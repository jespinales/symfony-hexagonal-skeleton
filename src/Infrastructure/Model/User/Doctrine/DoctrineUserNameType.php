<?php

namespace App\Infrastructure\Model\User\Doctrine;

use App\Domain\User\UserName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DoctrineUserNameType extends Type
{
    const NAME = 'user_name';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new UserName($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}