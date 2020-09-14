<?php

namespace app\classes;

/**
 * 
 */
class CountAddedProducts 
{
    /**
     * 
     */
    public function addDateProductsInJsone(string $nameproduct) : void
    {
        $date = date('m');
        $year = date('Y');

        $mounth = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'Jujy',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',           
        ];

        $json   = file_get_contents('../web/json/countdateproducts.json');
        $json   = json_decode($json, true);
        $json[$year][$nameproduct][$mounth[$date]] = $json[$year][$nameproduct][$mounth[$date]] + 1;
        $json   = json_encode($json);
        file_put_contents('../web/json/countdateproducts.json', $json);
        
    }
}
