<?php

namespace App\Infrastructure\Model\User\Doctrine;

use App\Domain\User\UserPassword;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class DoctrineUserPasswordType extends Type
{
    const NAME = 'user_password';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): UserPassword
    {
        return UserPassword::fromHash($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}