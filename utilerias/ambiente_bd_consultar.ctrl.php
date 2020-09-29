<?php
// ----------------------------------------------------------------------------------
// ambiente_bd_consultar.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { condicion:[info consulta], 
//                  campodeordenamiento:[campo], 
//                  formadeordenamiento:[forma], 
//                  cantidadregistros:[cantidad]
//                  tipo:[directa/general] 
//                      ** directa-> Se envia la consulta completa
//                      ** general-> Se envia el valor
//                  campos:[definidos/todos]
//                      ** definidos -> Son los que estan definidos en la clase
//                      ** todos -> Todos los campos
//                }
//              - Devuelve el resultado en JSON.  
//                {
//                    retorno=>TRUE/FALSE, msg=>"MENSAJE",[REGISTROS] 
//                } 
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 05/11/2019
// ----------------------------------------------------------------------------------

class ArrayValue implements JsonSerializable {
    public function __construct(array $array) {
        $this->array = $array;
    }

    public function jsonSerialize() {
        return $this->array;
    }
}

include_once "../utilerias/security.php";


$PASSWORD_ENCRIPTAR = "Kb.204.h3";
$NOMBRE_ARCHIVO="conexion.txt";
$UBICACION="../bd/";
  
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
 	 
if (!file_exists($UBICACION . $NOMBRE_ARCHIVO)) {		
	$datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE ARCHIVO DE CONEXION"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}  

 
// ----------------------------------------------
// Lee el archivo de conexion
$file = fopen($UBICACION . $NOMBRE_ARCHIVO, "r"); 
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
 
 $server_text=MyDecrypt($server_text_encriptado,$PASSWORD_ENCRIPTAR);
 $usu_text=MyDecrypt($usu_text_encriptado,$PASSWORD_ENCRIPTAR);
 $pass_text=MyDecrypt($pass_text_encriptado,$PASSWORD_ENCRIPTAR);
 $bd_text=MyDecrypt($bd_text_encriptado,$PASSWORD_ENCRIPTAR);

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

 $datos=array();   
 $especiales=array();
 $combo=array();               

 $datos=$datos + ["retorno"=>"TRUE"];
 $datos=$datos + ["msg"=>""];
 $datos=$datos + ["llave"=>""];
 $datos=$datos + ["especiales"=>$especiales];
 $datos=$datos + ["combo"=>$combo ];
 $datos=$datos + ["Servidor"=>$server_text];
 $datos=$datos + ["Usuario"=>$usu_text];
 $datos=$datos + ["Password"=>$pass_text];
 $datos=$datos + ["BD"=>$bd_text];

 array_push($retorno,$datos);    
 $retorno=json_encode($retorno);	 
 echo $retorno;  
 
?> 
  