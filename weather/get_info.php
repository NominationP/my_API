<?php
require( '../html-parser/vendor/autoload.php');
include_once "/var/www/html/my_API/common/get_content.php";

$par = new Get_proxy;
$url ='http://www.weather.com.cn/weather/101020100.shtml';

$dom = $par->get_html($url);

$dom = $dom->find("div.c7d ul li");

$count = 0;
$arr = array();
foreach ($dom as $each) {
    # code...
    $count++;
    $date = $each->find("h1",0)->getPlainText();
    if($count != 1){
        $high = $each->find("p.tem span",0)->getPlainText();
        $low = $each->find("p.tem i",0)->getPlainText();
        $tem = $high."/".$low;
    }else{
        $tem = $each->find("p.tem i",0)->getPlainText();
    }
    $wine = $each->find("p.win i",0)->getPlainText();

    array_push($arr, array( 'date'=>$date,
                            'tem'=>$tem,
                            'wine'=>$wine));
}

print_r(json_encode($arr,JSON_UNESCAPED_UNICODE));
