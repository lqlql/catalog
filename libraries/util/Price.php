<?php
declare(strict_types=1);

namespace Libs\Util;
/**
 * Class Price
 * @package Libs\Util
 * In db money stores in int, and transform to float for clients
 * In this way i solve floating point inaccuracy problem
 */
class Price
{
    private const PRECISION = 100;

    public static function toFloat(int $price): float
    {
        return $price / static::PRECISION;
    }

    public static function toInt(float $price): int
    {
        return intval(round($price * static::PRECISION));
    }

}


