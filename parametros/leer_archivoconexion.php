<?php
// ----------------------------------------------------------------------------------
// leer_archivoconexion.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Programa utilizado para leer el archivo de conexión para la 
//              base de datos
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 29/08/2019
// ----------------------------------------------------------------------------------
include_once "security.php";

$password_encriptar = "Kb.204.h3";

$l_Archivo="";

if(!empty($_GET)){ 
    if (isset($_GET['archivo'])){
      $l_Archivo=$_GET['archivo']; 
    }       
}

if(strlen($l_Archivo)<=0){
    echo "NO TIENE ARCHIVO";
    exit(1);
}
 
$server_text="";
$usu_text="";
$pass_text ="";
$bd_text=""; 

$server_text_encriptado="";
$usu_text_encriptado="";
$pass_text_encriptado="";
$bd_text_encriptado="";

$columna=1;

$file = fopen($l_Archivo, "r");
while(!feof($file)) { 
     $leido=fgets($file);
	 //echo "***LEIDO:" .$leido;  
	 
     if($columna==1){
         $server_text_encriptado=trim($leido);
         
		 $columna=$columna+1;
	 } else {
	     if($columna==2){
	         $usu_text_encriptado=trim($leido);
		     $columna=$columna+1;
	     } else {
		     if($columna==3){
	             $pass_text_encriptado=trim($leido);
		         $columna=$columna+1;
	         } else {
		         if($columna==4){
                     $bd_text_encriptado=trim($leido);                     
                     $bd_text=MyDecrypt($bd_text_encriptado,$password_encriptar);                      
		             $columna=$columna+1;
	             } else {
		  
		         }
		     }
		 }
	 }	  
}
fclose($file);  
 
$server_text=MyDecrypt($server_text_encriptado,$password_encriptar);
$usu_text=MyDecrypt($usu_text_encriptado,$password_encriptar);
$pass_text=MyDecrypt($pass_text_encriptado,$password_encriptar);
$bd_text=MyDecrypt($bd_text_encriptado,$password_encriptar);

$linea=$server_text ."," . $usu_text ."," . $pass_text ."," . $bd_text;	
 
echo "<br> Cadena de conxion:" . $linea;    
	  
?>

 