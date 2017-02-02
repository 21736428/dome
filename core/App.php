<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2017/1/31
 * Time: 19:50
 */
namespace core;
class App{

    public static function Run()
    {
        self::PaserUrl();
    }


    public static function PaserUrl()
    {
        p($_SERVER);
    }
}