<?php
ini_set('memory_limit','1024M');
require_once  "PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";

//需要读取的execl文件
$filename = '002.xlsx';

//加载excel文件
$excel = \PHPExcel_IOFactory::load($filename);

$ttt = array();
//循环读取sheets
foreach ($excel->getWorksheetIterator() as $sheet){
    foreach ($sheet->getRowIterator() as $row){
        $tmp = array();
        $tag = 0;
        foreach ($row->getCellIterator() as $cell){
            if($tag == 3){
                $data = $cell->getValue();
            }elseif($tag == 5){
                $data = $cell->getValue();
            }elseif($tag == 7){
                $data = $cell->getValue();
            }elseif($tag == 9){
                $data = $cell->getValue();
            }elseif($tag == 100){
                $data = $cell->getCalculatedValue();
            }elseif($tag == 101){
                $data = $cell->getCalculatedValue();
            }elseif($tag == 102){
                $data = $cell->getCalculatedValue();
            }elseif($tag == 103){
                $data = $cell->getCalculatedValue();
            }else{
                $data = $cell->getValue();
            }
            if($tag == 3 || $tag == 5 || $tag == 7 || $tag == 9 || $tag == 100 || $tag == 101 || $tag == 102 || $tag == 103){
                array_push($tmp, $data);
            }
            ++$tag;
        }
        array_push($ttt, $tmp);
    }
}

print_r(count($ttt));

$connect = mysqli_connect('10.2.1.13','wenba','szc0219','oneone_recommend','3306');
mysqli_query($connect,'set names utf8');
mysqli_query($connect, "truncate test002");
for($i = 0; $i < count($ttt); $i++){
    $sql = "INSERT INTO test002 SET yi_name = '".$ttt[$i][0]."', er_name = '".$ttt[$i][1]."', san_name = '".$ttt[$i][2]."', si_name = '".$ttt[$i][3]."', zhi_hangzhou = '".$ttt[$i][4]."', zhi_wenzhou = '".$ttt[$i][5]."', zhi_jinhua = '".$ttt[$i][6]."', zhi_ningbo = '".$ttt[$i][7]."'";
    print_r($sql);
    print_r("</br>");
    $result = mysqli_query($connect,$sql);
}
mysqli_close($connect);