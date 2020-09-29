<?php
require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel(); 


$objPHPExcel->setActiveSheetIndex(0);

// Renombrar la hoja
$objPHPExcel->getActiveSheet()->setTitle('Tecnologia Simple');

$rowCount = 1; 
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'Nombre');
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'Apellido');
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Trabajo');
$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('0000ff');
 
 
 

$rowCount = 2;
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'Antonio');
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'Barajas');
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Softernium');

$rowCount = 3;
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'Axl');
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'Velarde');
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'UNIMED');


$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFill()->getStartColor()->setARGB('0000ff');
 



$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 

$objWriter->save('../adjuntos/ejemplo.xlsx'); 
 
?>