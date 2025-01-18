<?php

namespace App\Const;

class TaxConst
{
    public const TAX_RATE = 0.10;

    public static function getTaxRate(): float
    {
        return self::TAX_RATE;
    }
}