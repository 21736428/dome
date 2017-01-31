<?php
$arr = [];

for ($i=0; $i < 1000000 ; $i++) {
	$arr[] = $i+1;
}

$stime = microtime(true);

// echo $stime;

foreach ($arr as $key => $value) {

}

$etime = microtime(true);

echo $etime - $stime;


?>