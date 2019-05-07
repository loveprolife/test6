<?php
ini_set('memory_limit','1024M');
require_once  "PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";

//需要读取的execl文件
$filename = './datu/chuzhong_kexue/001.xlsx';

//加载excel文件
$excel = \PHPExcel_IOFactory::load($filename);

$ttt = array();
//循环读取sheets
foreach ($excel->getWorksheetIterator() as $sheet){
    foreach ($sheet->getRowIterator() as $row){
        $tmp = array();
        $tag = 0;
        foreach ($row->getCellIterator() as $cell){
//            print $tag . "||" . $cell->getValue() . "\r\n";
            if($tag == 159){
                $data = $cell->getCalculatedValue();
            }else{
                $data = $cell->getValue();
            }
            array_push($tmp, $data);
            ++$tag;
        }
        array_push($ttt, $tmp);
    }
}

$connect = mysqli_connect('10.2.1.13','wenba','szc0219','oneone_recommend','3306');
mysqli_query($connect,'set names utf8');
mysqli_query($connect, "truncate chuzhong_kexue_001");
for($i = 0; $i < count($ttt); $i++){
    $sql = 'INSERT INTO chuzhong_kexue_001 SET yi_name = "'.$ttt[$i][3].'", er_name = "'.$ttt[$i][5].'", san_name = "'.$ttt[$i][7].'", si_name = "'.$ttt[$i][10].'", zhi = "'.$ttt[$i][159].'"';
//    print $sql . "\r\n";
    $result = mysqli_query($connect,$sql);
}
mysqli_close($connect);
