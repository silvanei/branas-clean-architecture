<?php

declare(strict_types=1);

namespace Silvanei\BranasCleanArchitecture\Infra\Database;

use PDOException;
use ReflectionClass;
use ReflectionNamedType;
use RuntimeException;
use Throwable;

final class PDODataMapper
{
    /**
     * @template T of object
     * @param class-string<T> $className
     * @param array<string, string|int|float> $data
     * @return T
     */
    public static function map(string $className, array $data): object
    {
        try {
            $contructorArgs = [];
            $reflectionClass = new ReflectionClass($className);
            $reflectionClassProperties = $reflectionClass->getProperties();
            foreach ($reflectionClassProperties as $property) {
                $propertyName = $property->getName();
                if (array_key_exists($propertyName, $data)) {
                    $reflectionType = $property->getType();
                    if (! $reflectionType instanceof ReflectionNamedType) {
                        throw new RuntimeException('Somente propriedade com um único tipo definido');
                    }
                    $name = $reflectionType->getName();
                    $value = null;
                    if ($name === 'string') {
                        $value = (string)$data[$propertyName];
                    }
                    if ($name === 'int') {
                        $value = (int)$data[$propertyName];
                    }
                    if ($name === 'float') {
                        $value = (float)$data[$propertyName];
                    }
                    $contructorArgs[$propertyName] = $value;
                }
            }

            return $reflectionClass->newInstance(...$contructorArgs);
        } catch (Throwable $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    /**
     * @template T of object
     * @param class-string<T> $className
     * @param array<string, string|int|float>[] $data
     * @return array<T>
     */
    public static function arrayMap(string $className, array $data): array
    {
        return array_map(fn($item) => self::map($className, $item), $data);
    }
}
