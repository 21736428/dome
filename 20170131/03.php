<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2017/2/22
 * Time: 19:29
 */

function getb($a)
{
    if($a>100)
    {
        return $a;
    }
    else
    {
        return flase;
    }
}

$a=[1,2,3,4];
$b = getb(mt_rand(50,150));
$c = array_merge($a,(array)$b);

print_r($c);