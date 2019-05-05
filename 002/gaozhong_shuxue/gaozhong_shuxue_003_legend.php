<?php

header("Access-Control-Allow-Origin: *");

$connect = mysqli_connect('10.2.1.13','wenba','szc0219','oneone_recommend','3306');
mysqli_query($connect,'set names utf8');

$sql_san = 'SELECT id, san_name, SUM(zhi) FROM gao_zhong_shuxue_003 GROUP BY san_name ORDER BY id ASC';
$result_san = mysqli_query($connect, $sql_san)->fetch_all();

$connect->close();

$rrrr = array();
for($i = 0; $i < count($result_san); $i++){
//    if((float)$result_san[$i][2] > 0){
    $t = array();
    $t['name'] = $result_san[$i][1];
    $t['value'] = $result_san[$i][2];
    array_push($rrrr, $t);
//    }
}


print_r(json_encode($rrrr));

