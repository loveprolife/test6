<?php

header("Access-Control-Allow-Origin: *");

$connect = mysqli_connect('10.2.1.13','wenba','szc0219','oneone_recommend','3306');
mysqli_query($connect,'set names utf8');

$sql_yi = 'SELECT A.id, A.yi_name, SUM(zhi) FROM (SELECT * FROM gao_zhong_shuxue_001 WHERE is_show = 1 ORDER BY id ASC) AS A GROUP BY A.yi_name ORDER BY A.id ASC';
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
    $sql_er = "SELECT id, er_name, SUM(zhi) FROM gao_zhong_shuxue_001 WHERE is_show = 1 AND yi_name ='".$rrr['series'][0]['data'][$i]['name']."' GROUP BY er_name ORDER BY id ASC";
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
    $sql_san = "SELECT id, san_name, SUM(zhi) FROM gao_zhong_shuxue_001 WHERE is_show = 1 AND er_name ='".$rrr['series'][1]['data'][$i]['name']."' GROUP BY san_name ORDER BY id ASC";
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



//echo '{"title":{"text":"","subtext":"","left":"center","textStyle":{"color":"#fff","fontSize":18}},"backgroundColor":{"x":0,"y":0,"r":1,"type":"radial","global":false,"colorStops":[{"offset":0,"color":"#174b78"},{"offset":1,"color":"#174b78"}]},"tooltip":{"trigger":"item","formatter":"{a} <br/>{b}:({d}%)"},"series":[{"name":"一级指标","type":"pie","selectedMode":"single","radius":[0,"30%"],"label":{"normal":{"position":"inner"}},"labelLine":{"normal":{"show":false}},"data":[{"value":2,"name":"应急管理组织指标"},{"value":8,"name":"应急管理对象指标"},{"value":18,"name":"应急管理能力指标"},{"value":16,"name":"应急管理态势指标"},{"value":40,"name":"应急管理效能指标"}]},{"name":"二级指标","type":"pie","radius":["32%","60%"],"label":{"normal":{"position":"inner"}},"data":[{"value":1,"name":"应急机构组成情况"},{"value":1,"name":"应急知识准备情况"},{"value":5,"name":"危险源和风险隐患区情况"},{"value":3,"name":"防护目标情况"},{"value":7,"name":"应急保障资源情况"},{"value":5,"name":"应急管理专家情况"},{"value":3,"name":"应急避险场所情况"},{"value":3,"name":"应急预案情况"},{"value":2,"name":"预警信息上报情况"},{"value":5,"name":"突发事件情况"},{"value":4,"name":"应急事件级别情况"},{"value":5,"name":"应急事件处置情况"},{"value":36,"name":"街道应急管理工作效能情况"},{"value":4,"name":"区级应急管理工作效能情况"}]},{"name":"三级指标","type":"pie","radius":["62%","70%"],"label":{"normal":{"position":"outer"}},"data":[{"value":1,"name":"应急机构数量同比增长"},{"value":1,"name":"应急知识库记录数同比增长"},{"value":1,"name":"自然灾害风险隐患区数量"},{"value":1,"name":"事故灾难危险源数量"},{"value":1,"name":"公共卫生危险源数量"},{"value":1,"name":"社会安全隐患数量"},{"value":1,"name":"其他危险源和风险隐患区数量"},{"value":1,"name":"重要单位防护目标数量"},{"value":1,"name":"关键基础设施防护目标数量"},{"value":1,"name":"其他防护目标数量"},{"value":1,"name":"应急物资与装备资源数量"},{"value":1,"name":"应急通讯资源数量"},{"value":1,"name":"应急运输与物流资源数量"},{"value":1,"name":"医疗卫生单位数量"},{"value":1,"name":"应急避难场所数量"},{"value":1,"name":"应急广播电视资源数量"},{"value":1,"name":"其他应急保障资源数量"},{"value":1,"name":"自然灾害事件应急专家"},{"value":1,"name":"事故灾难事件应急专家"},{"value":1,"name":"公共卫生事件应急专家"},{"value":1,"name":"社会安全事件应急专家"},{"value":1,"name":"其他突发事件应急专家"},{"value":3,"name":"应急避险场所面积同比增长"},{"value":1,"name":"区级应急预案"},{"value":1,"name":"企业级应急预案"},{"value":1,"name":"其他应急预案"},{"value":1,"name":"预警信息上报率同比增长"},{"value":1,"name":"预警信息升级率同比增长"},{"value":1,"name":"自然灾害事件数量"},{"value":1,"name":"事故灾难事件数量"},{"value":1,"name":"公共卫生事件数量"},{"value":1,"name":"社会安全事件数量"},{"value":1,"name":"其他突发事件数量"},{"value":1,"name":"特别重大事件数量"},{"value":1,"name":"重大事件数量"},{"value":1,"name":"较大事件数量"},{"value":1,"name":"一般事件数量"},{"value":1,"name":"上报的事件数量"},{"value":1,"name":"启动中的事件数量"},{"value":1,"name":"处置中的事件数量"},{"value":1,"name":"评估中的绩效数量"},{"value":1,"name":"结束的事件数量"},{"value":6,"name":"南营门街道应急管理评分"},{"value":6,"name":"劝业场街道应急管理评分"},{"value":6,"name":"五大道街道应急管理评分"},{"value":6,"name":"小白楼街道应急管理评分"},{"value":6,"name":"新兴街道应急管理评分"},{"value":6,"name":"南市街道应急管理评分"},{"value":1,"name":"应急值守工作评分"},{"value":1,"name":"应急准备工作评分"},{"value":1,"name":"应急响应工作评分"},{"value":1,"name":"突发事件处置评分"}]}]}';
