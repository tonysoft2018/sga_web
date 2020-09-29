<?php 
if(isset($_POST) && !empty($_POST)) {
    include('../library/qrlib.php'); 
    $codesDir = "../codes/";   
    $codeFile = date('d-m-Y-h-i-s').'.png';
    QRcode::png($_POST['datos'], $codesDir.$codeFile, $_POST['calidad'], $_POST['tamaxo']); 
    //echo '<img class="img-thumbnail" src="'.$codesDir.$codeFile.'" />';
    echo $codesDir.$codeFile;
} else {
    header('location:./');
}
?>