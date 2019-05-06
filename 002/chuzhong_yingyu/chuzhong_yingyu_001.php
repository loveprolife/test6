<?php

header("Access-Control-Allow-Origin: *");

$connect = mysqli_connect('10.2.1.13','wenba','szc0219','oneone_recommend','3306');
mysqli_query($connect,'set names utf8');

$sql_yi = 'SELECT A.id, A.yi_name, SUM(zhi) FROM (SELECT * FROM chuzhong_yingyu_001 WHERE is_show = 1 ORDER BY id ASC) AS A GROUP BY A.yi_name ORDER BY A.id ASC';
$result_yi = mysqli_query($connect, $sql_yi)->fetch_all();


$rrr = array();

$rrr['title']['text'] = '';
$rrr['title']['subtext'] = '';
$rrr['title']['left'] = 'center';
$rrr['title']['textStyle']['color'] = '#fff';
$rrr['title']['textStyle']['fontSize'] = 18;
$rrr['backgroundColor']['x'] = 0;
$rrr['backgroundColor']['y'] = 0;
$rrr['backgroundColor']['r'] = 1;
$rrr['backgroundColor']['type'] = 'radial';
$rrr['backgroundColor']['global'] = false;
$rrr['backgroundColor']['colorStops'][0]['offset'] = 0;
$rrr['backgroundColor']['colorStops'][0]['color'] = '#ffffff';
$rrr['backgroundColor']['colorStops'][1]['offset'] = '1';
$rrr['backgroundColor']['colorStops'][1]['color'] = '#ffffff';
$rrr['tooltip']['trigger'] = 'item';
$rrr['tooltip']['formatter'] = '{a} {b}:({d}%)';

$rrr['series'][0]['name'] = "一级指标";
$rrr['series'][0]['type'] = "pie";
//$rrr['series'][0]['selectedMode'] = "single";
$rrr['series'][0]['radius'][0] = 0;
$rrr['series'][0]['radius'][1] = "10%";
$rrr['series'][0]['label']['normal']['show'] = true;
$rrr['series'][0]['label']['normal']['position'] = "outer";
$rrr['series'][0]['label']['normal']['formatter'] = "{b}{d}%";
$rrr['series'][0]['label']['normal']['textStyle']['fontSize'] = 20;
//$rrr['series'][0]['labelLine']['normal']['show'] = false;
$rrr['series'][0]['data'] = array();

$rrr['series'][1]['name'] = "二级指标";
$rrr['series'][1]['type'] = "pie";
$rrr['series'][1]['radius'][0] = "30%";
$rrr['series'][1]['radius'][1] = "55%";
$rrr['series'][1]['label']['normal']['show'] = true;
$rrr['series'][1]['label']['normal']['position'] = "outer";
$rrr['series'][1]['label']['normal']['formatter'] = "{b}{d}%";
$rrr['series'][1]['label']['normal']['textStyle']['fontSize'] = 20;
$rrr['series'][1]['data'] = array();

$rrr['series'][2]['name'] = "三级指标";
$rrr['series'][2]['type'] = "pie";
$rrr['series'][2]['radius'][0] = "75%";
$rrr['series'][2]['radius'][1] = "85%";
$rrr['series'][2]['label']['normal']['position'] = "outer";
$rrr['series'][2]['label']['normal']['formatter'] = "{b}{d}%";
$rrr['series'][2]['label']['normal']['textStyle']['fontSize'] = 20;
$rrr['series'][2]['data'] = array();


for ($i = 0; $i < count($result_yi); $i++){
    if((float)$result_yi[$i]['2'] > 0){
        $tmp = array();
        $tmp['name'] = $result_yi[$i]['1'];
        $tmp['value'] = $result_yi[$i]['2'];
        array_push($rrr['series'][0]['data'], $tmp);
    }
}

for ($i = 0; $i < count($rrr['series'][0]['data']); $i++){
    $sql_er = "SELECT id, er_name, SUM(zhi) FROM chuzhong_yingyu_001 WHERE is_show = 1 AND yi_name ='".$rrr['series'][0]['data'][$i]['name']."' GROUP BY er_name ORDER BY id ASC";
    $result_er = mysqli_query($connect, $sql_er)->fetch_all();
    for ($j = 0; $j < count($result_er); $j++){
        if((float)$result_er[$j]['2'] > 0){
            $tmp = array();
            $tmp['name'] = $result_er[$j]['1'];
            $tmp['value'] = $result_er[$j]['2'];
            array_push($rrr['series'][1]['data'], $tmp);
        }
    }
}

for ($i = 0; $i < count($rrr['series'][1]['data']); $i++){
    $sql_san = "SELECT id, san_name, SUM(zhi) FROM chuzhong_yingyu_001 WHERE is_show = 1 AND er_name ='".$rrr['series'][1]['data'][$i]['name']."' GROUP BY san_name ORDER BY id ASC";
    $result_san = mysqli_query($connect, $sql_san)->fetch_all();
    for ($j = 0; $j < count($result_san); $j++){
        if((float)$result_san[$j]['2'] > 0){
            $tmp = array();
            $tmp['name'] = $result_san[$j]['1'];
            $tmp['value'] = $result_san[$j]['2'];
            array_push($rrr['series'][2]['data'], $tmp);
        }
    }
}


$connect->close();





print_r(json_encode($rrr));
