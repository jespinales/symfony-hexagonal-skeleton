<?php

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Types\Type;

final class CustomTypesRegistrar
{
    public static function register(array $dbalCustomTypesClasses): void
    {
        array_walk(
            $dbalCustomTypesClasses,
            self::registerType()
        );
    }

    private static function registerType(): callable
    {
        return static function ($dbalCustomTypesClasses): void {
            Type::addType($dbalCustomTypesClasses::NAME, $dbalCustomTypesClasses);
        };
    }
}