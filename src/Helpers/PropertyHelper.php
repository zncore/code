<?php

namespace ZnCore\Code\Helpers;

use ZnCore\Text\Helpers\Inflector;
use ZnCore\Code\Factories\PropertyAccess;

/**
 * Работа с атрибутами класса
 */
class PropertyHelper
{

    /**
     * Получить значение атрибута.
     * 
     * @param object $enitity
     * @param string $attribute
     * @return mixed
     */
    public static function getValue(object $enitity, string $attribute)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        return $propertyAccessor->getValue($enitity, $attribute);
    }

    /**
     * Установить значение атрибута.
     * 
     * @param object $entity
     * @param string $name
     * @param $value
     */
    public static function setValue(object $entity, string $name, $value): void
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $propertyAccessor->setValue($entity, $name, $value);
    }

    /**
     * Назначить массив атрибутов.
     * 
     * @param object $entity
     * @param array $data
     * @param array $filedsOnly
     */
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

    /**
     * Проверяет, доступен ли атрибут для записи.
     * 
     * @param object $entity
     * @param string $name
     * @return bool
     */
    public static function isWritableAttribute(object $entity, string $name): bool
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        return $propertyAccessor->isWritable($entity, $name);
    }

    /**
     * Проверяет, доступен ли атрибут для чтения.
     * 
     * @param object $entity
     * @param string $name
     * @return bool
     */
    public static function isReadableAttribute(object $entity, string $name): bool
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        return $propertyAccessor->isReadable($entity, $name);
    }
}
