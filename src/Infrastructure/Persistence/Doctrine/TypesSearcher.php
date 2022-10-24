<?php

namespace App\Infrastructure\Persistence\Doctrine;

class TypesSearcher
{
    private const MAPPINGS_PATH = 'Doctrine';

    public static function inPath(string $path): array
    {
        $possibleDbalDirectories = self::possiblePaths($path);
        $dbalDirectories = array_filter($possibleDbalDirectories, self::isExistingPath());

        return array_reduce($dbalDirectories, self::classesSearcher(), []);
    }

    private static function modulesInPath(string $path): array
    {
        return array_filter(
            scandir($path),
            static function (string $possibleModule) {
                return !in_array($possibleModule, ['.', '..']);
            },
        );
    }

    private static function possiblePaths(string $path): array
    {
        return array_map(
            static function (string $module) use ($path) {
                $mappingsPath = self::MAPPINGS_PATH;
                return realpath("$path/$module/$mappingsPath");
            },
            self::modulesInPath($path)
        );
    }

    private static function isExistingPath(): callable
    {
        return static function (string $path) {
            return !empty($path);
        };
    }

    private static function classesSearcher(): callable
    {
        return static function (array $totalNamespaces, string $path) {
            $possibleFiles = scandir($path);

            $files = array_filter(
                $possibleFiles,
                static function ($file) {
                    return self::endsWith($file);
                },
            );

            $namespaces = array_map(
                static function (string $file) use ($path) {
                    $fullPath     = realpath("$path/$file");
                    $splittedPath = preg_split('/(\/|\\\)src(\/|\\\)/', $fullPath);
                    $classWithoutPrefix = preg_replace(['/\.php/', '/(\/|\\\)/'], ['', '\\'], $splittedPath[1]);

                    return "App\\$classWithoutPrefix";
                },
                $files
            );

            return array_merge($totalNamespaces, $namespaces);
        };
    }

    private static function endsWith(string $haystack): bool
    {
        $length = strlen('Type.php');
        if ($length === 0) {
            return true;
        }

        return (substr($haystack, -$length) === 'Type.php');
    }

}