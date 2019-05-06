<?php

header("Access-Control-Allow-Origin: *");

$connect = mysqli_connect('10.2.1.13','wenba','szc0219','oneone_recommend','3306');
mysqli_query($connect,'set names utf8');

$sql_san = 'SELECT * FROM gao_zhong_shuxue_002 ORDER BY id ASC';
$result_san = mysqli_query($connect, $sql_san)->fetch_all();



$rrrr = array();
for($i = 0; $i < count($result_san); $i++){
    $result_san[$i][7] = trim(substr($result_san[$i][2],strpos($result_san[$i][2], ' '), 100));
    print_r($result_san[$i]);
    print_r("</br>");
    $update_sql = "UPDATE gao_zhong_shuxue_002 SET er_name='" . $result_san[$i][7] . "' where id = " . $result_san[$i][0];
    mysqli_query($connect,$update_sql);
    echo $update_sql;
    echo "</br>";
}

$connect->close();

print_r(json_encode($rrrr));
