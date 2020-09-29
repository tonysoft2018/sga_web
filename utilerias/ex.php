<?php
require('code128.php');

$pdf=new PDF_Code128();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);

/*
//A set
$code='CODE 128';
$pdf->Code128(50,20,$code,80,20);
$pdf->SetXY(50,45);
$pdf->Write(5,'A set: "'.$code.'"');

//B set
$code='Code 128';
$pdf->Code128(50,70,$code,80,20);
$pdf->SetXY(50,95);
$pdf->Write(5,'B set: "'.$code.'"');
*/

/*
//C set
$code='12345678901234567890';
$pdf->Code128(50,120,$code,110,20);
$pdf->SetXY(50,145);
$pdf->Write(5,'C set: "'.$code.'"');
*/

//A,C,B sets
$code='12229';
$pdf->Code128(50,10,$code,40,20);
$pdf->SetXY(50,30);
$pdf->Write(5,'COMAL PARA TORTILLA,480.00');

/*
$code='119/12229/Z6448-2';
$pdf->Code128(50,50,$code,125,20);
$pdf->SetXY(50,70);
$pdf->Write(5,'COMAL PARA TORTILLA,480.00');

$code='119/12229/Z6448-3';
$pdf->Code128(50,100,$code,125,20);
$pdf->SetXY(50,120);
$pdf->Write(5,'COMAL PARA TORTILLA,480.00');
*/
$pdf->Output();
?>
