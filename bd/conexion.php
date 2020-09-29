<?php
// ----------------------------------------------------------------------------------
// conexion.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Permite decodificar el archivo de conexion a la base de datos.
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 06/11/2019
// ----------------------------------------------------------------------------------

//include_once  "../utilerias/security.php";

function RegresaConexion(){
	include_once "../parametros/env.php";    

	$NOMBRE_ARCHIVO="../bd/conexion.txt";
 
	$server_text="";
	$usu_text="";
	$pass_text ="";
	$bd_text=""; 

	$server_text_encriptado="";
	$usu_text_encriptado="";
	$pass_text_encriptado="";
	$bd_text_encriptado="";
 
	$columna=1;

	$linea="";
  
	if (!file_exists($NOMBRE_ARCHIVO)) {		
		echo "NO EXISTE"; 
		return $linea; 
		exit(1);
	}  
 
	$file = fopen($NOMBRE_ARCHIVO, "r"); 
    while(!feof($file)) { 	 
		$leido=fgets($file);
	  
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
		             	$columna=$columna+1;
	             	} else {
		  
		         	}
		     	}
		 	}
	 	}	  
    }
 
	fclose($file); 
	 

	$linea=$server_text_encriptado ."," . $usu_text_encriptado ."," . $pass_text_encriptado ."," . $bd_text_encriptado;	
	//echo $linea;

 
	//$server_text=MyDecrypt($server_text_encriptado,$password_encriptar);
	$server_text = openssl_decrypt($server_text_encriptado, "AES-128-ECB", SECRETKEY);
	//$usu_text=MyDecrypt($usu_text_encriptado,$password_encriptar);
	$usu_text = openssl_decrypt($usu_text_encriptado, "AES-128-ECB", SECRETKEY);
	//$pass_text=MyDecrypt($pass_text_encriptado,$password_encriptar);
	$pass_text = openssl_decrypt($pass_text_encriptado, "AES-128-ECB", SECRETKEY);
	//$bd_text=MyDecrypt($bd_text_encriptado,$password_encriptar);
	$bd_text = openssl_decrypt($bd_text_encriptado, "AES-128-ECB", SECRETKEY);

	//Limpia las cadenas
	$server_text=trim($server_text);
	$server_text=substr($server_text,1,strlen($server_text));
	$server_text=substr($server_text,0,strlen($server_text)-1);

	$usu_text=trim($usu_text);
	$usu_text=substr($usu_text,1,strlen($usu_text));
	$usu_text=substr($usu_text,0,strlen($usu_text)-1);

	$pass_text=trim($pass_text);
	$pass_text=substr($pass_text,1,strlen($pass_text));
	$pass_text=substr($pass_text,0,strlen($pass_text)-1);

	$bd_text=trim($bd_text);
	$bd_text=substr($bd_text,1,strlen($bd_text));
	$bd_text=substr($bd_text,0,strlen($bd_text)-1);

	$linea=$server_text ."," . $usu_text ."," . $pass_text ."," . $bd_text;	
	//echo $linea;
 
 	/*
	$server_text="localhost";
	$usu_text="conexion";
	$pass_text="Kb.204.h32017";
	$bd_text="bd_zgas";
 	*/
 
	
	$retorno= array("servidor"=>$server_text,"usuario"=>$usu_text, "password"=>$pass_text, "bd"=>$bd_text);
	$retorno=json_encode($retorno);	 
	//$linea=$server_text ."," . $usu_text ."," . $pass_text ."," . $bd_text;	
  
 
	return $retorno;   
 
}
?>

 