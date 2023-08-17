<?php


declare(strict_types=1);

namespace App\Enum;

class MethodEnum extends AbstractEnum
{
    public const GET = 'GET';
    public const PUT = 'PUT';

    public static function getValues(): array
    {
        return [
        ];
    }

    public static function getTranslationKeys(): array
    {
        return [

        ];
    }
}
