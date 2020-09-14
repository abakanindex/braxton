<?php namespace app\widgets;
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 26.10.2017
 * Time: 16:38
 */

class JavascriptConsole {

    public static function send($massage)
    {
        echo '<script>console.log("' . htmlspecialchars($massage) . '")</script>';
    }

}