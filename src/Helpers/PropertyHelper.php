<?php

namespace ZnCore\Code\Helpers;

use ReflectionClass;
use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\Collection\Interfaces\Enumerable;
use ZnDomain\Entity\Factories\PropertyAccess;
use ZnCore\Instance\Helpers\ClassHelper;
use ZnCore\Text\Helpers\Inflector;
use ZnLib\Components\DynamicEntity\Interfaces\DynamicEntityAttributesInterface;

/**
 * Работа с атрибутами класса
 */
class PropertyHelper
{

    public static function getValue(object $enitity, string $attribute)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        return $propertyAccessor->getValue($enitity, $attribute);
    }

    public static function setAttributes(object $entity, $data, array $filedsOnly = []): void
    {
        if (empty($data)) {
            return;
        }
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($data as $name => $value) {
            $name = Inflector::variablize($name);
            $isAllow = empty($filedsOnly) || in_array($name, $filedsOnly);
            if ($isAllow) {
                $isWritable = $propertyAccessor->isWritable($entity, $name);
                if ($isWritable) {
                    $propertyAccessor->setValue($entity, $name, $value);
                }
            }
        }
    }

    public static function setAttribute(object $entity, string $name, $value): void
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $propertyAccessor->setValue($entity, $name, $value);
    }

    public static function isWritableAttribute(object $entity, string $name): bool
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        return $propertyAccessor->isWritable($entity, $name);
    }

    public static function isReadableAttribute(object $entity, string $name): bool
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        return $propertyAccessor->isReadable($entity, $name);
    }
}
