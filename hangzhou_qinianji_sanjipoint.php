<?php

header("Access-Control-Allow-Origin: *");
//
//$connect = mysqli_connect('39.106.102.214','root','123aliyunwp','test','3306');
//mysqli_query($connect,'set names utf8');
//
//
//$sql_san = 'SELECT id, san_name, SUM(zhi_hangzhou) FROM test002 GROUP BY san_name ORDER BY id ASC';
//$result_san = mysqli_query($connect, $sql_san)->fetch_all();
//
//$connect->close();
//
//



$dbh=new PDO('mysql:host=39.106.102.214;port=3306; dbname=test','root','123aliyunwp',array(PDO::ATTR_PERSISTENT=>true));

$sql_san = 'SELECT id, san_name, SUM(zhi_hangzhou) FROM test002 GROUP BY san_name ORDER BY id ASC';
$result_san = $dbh->query($sql_san)->fetchAll(PDO::FETCH_ASSOC);



$rrrr = array();
for($i = 0; $i < count($result_san); $i++){
    if((float)$result_san[$i]['SUM(zhi_hangzhou)'] > 0){
        $t = array();
        $t['name'] = $result_san[$i]['san_name'];
        $t['value'] = $result_san[$i]['SUM(zhi_hangzhou)'];
        array_push($rrrr, $t);
    }
}


print_r(json_encode($rrrr));

