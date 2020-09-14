<?php

namespace app\interfaces\deals;

interface iDealsInt
{
    public static function getCountByStatusInt();

    public static function getTopLocationInt($limit);

    public static function getTopAgentInt($limit);

    public static function getTopCategoriesInt($limit);

    public static function getTopRegionsInt($limit);

    public static function getByPriceInRangeInt($minPrice, $maxPrice);
}