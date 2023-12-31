<?php


declare(strict_types=1);

namespace App\Enum;

class ShopifyEndpointEnum extends AbstractEnum
{
    public const ORDERS = 'orders';
    public const SHOP = 'shop';
    public const VARIANTS = 'variants';
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
