<?php

declare(strict_types=1);

namespace App\Enum;

abstract class AbstractEnum implements EnumInterface
{
    /**
     * @param mixed $enum
     * @return bool
     */
    public static function isValid($enum): bool
    {
        return in_array($enum, static::getValues(), true);
    }

    /**
     * @param mixed $enum
     * @return string
     */
    public static function getKey($enum): string
    {
        return array_search($enum, static::getValues());
    }

    /**
     * @param array|null $values
     * @return array
     */
    public static function getValuesForForm(?array $values = null): array
    {
        if(null === $values){
            $values = static::getValues();
        }

        $res = [];
        foreach ($values as $value) {
            $res[static::getTranslationKeyBy($value)] = $value;
        }

        return $res;
    }

    /**
     * @param mixed $enum
     * @return string
     */
    public static function getTranslationKeyBy($enum): string
    {
        return (array_key_exists($enum, static::getTranslationKeys())) ? static::getTranslationKeys()[$enum] : '';
    }

    /**
     * @param $enum
     * @return array|string
     */
    public static function getTranslationKeyOfArrayBy($enum)
    {
        return (array_key_exists($enum, static::getTranslationKeys())) ? static::getTranslationKeys()[$enum] : array();
    }

    /**
     * @return string[]
     */
    abstract public static function getValues(): array;

    /**
     * @return string[]
     */
    abstract public static function getTranslationKeys(): array;
}
