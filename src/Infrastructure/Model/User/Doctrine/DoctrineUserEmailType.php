<?php

namespace App\Infrastructure\Model\User\Doctrine;

use App\Domain\User\UserEmail;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DoctrineUserEmailType extends Type
{
    const NAME = 'user_email';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): UserEmail
    {
        return new UserEmail($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}