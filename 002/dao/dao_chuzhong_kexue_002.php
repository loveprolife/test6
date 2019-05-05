<?php
ini_set('memory_limit','1024M');
require_once  "PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";

//需要读取的execl文件
$filename = './xiaotu/chuzhong_kexue/七下期中/002.xlsx';

//加载excel文件
$excel = \PHPExcel_IOFactory::load($filename);

$ttt = array();
//循环读取sheets
foreach ($excel->getWorksheetIterator() as $sheet){
    foreach ($sheet->getRowIterator() as $row){
        $tmp = array();
        $tag = 0;
        foreach ($row->getCellIterator() as $cell){
//            print($tag . "||" . $cell->getValue() . "\r\n");
            if($tag == 1){
                $data = $cell->getValue();
            }elseif($tag == 3){
                $data = $cell->getValue();
            }elseif($tag == 5){
                $data = $cell->getValue();
            }elseif($tag == 7){
                $data = $cell->getValue();
            }elseif($tag == 68){
                $data = $cell->getCalculatedValue();
            }elseif($tag == 69){
                $data = $cell->getCalculatedValue();
            }elseif($tag == 70){
                $data = $cell->getCalculatedValue();
            }else{
                $data = $cell->getValue();
            }
            if($tag == 1 || $tag == 3 || $tag == 5 || $tag == 7 || $tag == 68 || $tag == 69 || $tag == 70){
                array_push($tmp, $data);
            }
            ++$tag;
        }
        array_push($ttt, $tmp);
    }
}

$connect = mysqli_connect('10.2.1.13','wenba','szc0219','oneone_recommend','3306');
mysqli_query($connect,'set names utf8');
mysqli_query($connect, "truncate chuzhong_kexue_002");
for($i = 0; $i < count($ttt); $i++){
    $sql = "INSERT INTO chuzhong_kexue_002 SET yi_name = '".$ttt[$i][0]."', er_name = '".$ttt[$i][1]."', san_name = '".$ttt[$i][2]."', si_name = '".$ttt[$i][3]."', zhi_hangzhou = '".$ttt[$i][4]."', zhi_wenzhou = '".$ttt[$i][6]."', zhi_jinhua = '".$ttt[$i][5]."', zhi_ningbo = '0'";
//    print_r($sql . "\r\n");
    $result = mysqli_query($connect,$sql);
}
mysqli_close($connect);
