<?php

namespace app\interfaces\deals;

interface iDeals
{
    public static function getColumns($dataProvider);

    public static function getCountByStatus();

    public static function getTopLocation($limit);

    public static function getTopAgent($limit);

    public static function getTopCategories($limit);

    public static function getTopRegions($limit);

    public static function getByPriceInRange($minPrice, $maxPrice);
}