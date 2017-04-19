<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 17-4-19
 * Time: 下午6:35
 */
//缓存数字
echo str_repeat("<br/>",5);
echo "缓存数字";
echo "<hr>";
$a=0;
if(apcu_exists("aa")){
    print_r("走缓存了");
    $a = apcu_fetch("aa");
    $a++;
    apcu_store("aa",$a,600);
}
else{
    print_r("没有走缓存");
    $a++;
    apcu_add("aa",$a,600);
}

echo "<br>";
print_r($a);


echo str_repeat("<br/>",5);
echo "缓存对象";
echo "<hr>";
//缓存对象
$abc = new abc();

if(apcu_exists("obj")){
    print_r("走缓存了");
    $abc = apcu_fetch("obj");
    $abc->inc();
    apcu_store("obj",$abc,600);
}
else{
    print_r("没有走缓存");
    $abc->inc();
    apcu_add("obj",$abc,600);
}

echo "<pre>";
print_r($abc);


echo str_repeat("<br/>",5);
echo "缓存数组";
echo "<hr>";

$arr = [0];

if(apcu_exists("arr")){
    print_r("走缓存了");
    $arr = apcu_fetch("arr");
    $arr[0] +=1;
    apcu_store("arr",$arr,600);
}
else{
    print_r("没有走缓存");
    $arr[0] +=1;
    apcu_add("arr",$arr,600);
}

echo "<pre>";
print_r($arr);







echo str_repeat("<br/>",10);
echo "<pre>";
echo "缓存信息";
echo "<hr>";
print_r(apcu_cache_info());



class abc{

    public $a=0;

    public function inc(){
        $this->a++;
    }
}