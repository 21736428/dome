<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2017/2/16
 * Time: 8:56
 */

define("SMARTY_NAME","XIAOHEHE");
require_once "../vendor/smarty/smarty/libs/Smarty.class.php";

$smarty = new Smarty();


$smarty->template_dir = './html/';
$smarty->compile_dir = './html_c/';
$smarty->config_dir = './configs/';
$smarty->cache_dir = './cache/';


//$smarty->debugging=true;

/**
 * 变量 三种来源
 * 1.assign 复制
 * 2.保留变量
 * 3.配置文件
 *
 */

$zhang = ['name'=>'张磊涛','age'=>27,'height'=>180];

 $smarty->assign($zhang);  //{$name},{$age}

$smarty->assign("zhang",$zhang);


$smarty->display("01.html");