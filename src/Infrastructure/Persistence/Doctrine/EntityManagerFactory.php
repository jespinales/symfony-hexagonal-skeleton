<?php

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\MySqlSchemaManager;
use Doctrine\DBAL\Schema\PostgreSqlSchemaManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\Tools\Setup;
use RuntimeException;

class EntityManagerFactory
{
    private static string $schemaFile = __DIR__.'/../Scheme/Database.sql';

    private static bool $initialized = false;

    public static function build( array $parameters, string $environment ): EntityManager
    {
        $isDevMode = $environment !== 'prod';

        if ( !self::$initialized ) {
            if ( $isDevMode ) {
                static::generateDatabaseIfNotExists($parameters, self::$schemaFile);
            }

            $customTypesClasses = TypesSearcher::inPath(__DIR__ . '/../../Model');

            CustomTypesRegistrar::register($customTypesClasses);

            self::$initialized = true;
        }

        $config = Setup::createXMLMetadataConfiguration( [__DIR__."/Mapping/xml"], $isDevMode );

        return EntityManager::create( $parameters, $config );
    }

    private static function generateDatabaseIfNotExists( array $parameters, string $schemaFile ): void
    {
        self::ensureSchemaFileExists( $schemaFile );

        $databaseName = $parameters['dbname'];
        $connection = DriverManager::getConnection($parameters);
        $schemaManager = new PostgreSqlSchemaManager($connection);

        if ( !self::databaseExists( $databaseName, $schemaManager ) ) {
            $schemaManager->createDatabase( $databaseName );
        }

        $connection->executeStatement( file_get_contents( realpath( $schemaFile ) ) );

        $connection->close();
    }

    private static function ensureSchemaFileExists( string $schemaFile ): void
    {
        if ( !file_exists($schemaFile) ) {
            throw new RuntimeException( sprintf('The file <%s> does not exist', $schemaFile ) );
        }
    }

    private static function databaseExists( $databaseName, AbstractSchemaManager $schemaManager ): bool
    {
        return in_array( $databaseName, $schemaManager->listDatabases(), true );
    }
}