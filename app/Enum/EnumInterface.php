<?php

declare(strict_types=1);

namespace App\Enum;

interface EnumInterface
{
    public static function isValid(string $enum): bool;

    public static function getKey(string $enum): string;

    public static function getValues(): array;
}
