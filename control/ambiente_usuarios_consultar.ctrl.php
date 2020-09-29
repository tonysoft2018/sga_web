<?php
// ----------------------------------------------------------------------------------
// ambiente_usuarios_consultar.php
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

//include_once "../utilerias/security.php";
include_once "../parametros/env.php"; 

$retorno= array();
$arreglos = array();
 
$NOMBRE_ARCHIVO="usuarios.txt";
    
$usuario_super_text="";
$pass_super_text ="";
$usu_conf_text ="";
$pass_conf_text ="";
 
$usuario_super_encriptado="";
$pass_super_encriptado="";
$usu_conf_encriptado="";
$pass_conf_encriptado="";
 
$columna=1;

$linea="";
 	 
if (!file_exists($UBICACION_BD . $NOMBRE_ARCHIVO)) {		
	$datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE ARCHIVO DE SEGURIDAD"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}  

 
// ----------------------------------------------
// Lee el archivo de conexion
$file = fopen($UBICACION_BD . $NOMBRE_ARCHIVO, "r"); 
while(!feof($file)) { 	 
    $leido=fgets($file);
     
    if($columna==1){
	    $usuario_super_encriptado=trim($leido);
		$columna=$columna+1;
	} else {
	    if($columna==2){
                $pass_super_encriptado=trim($leido);
		     	$columna=$columna+1;
	    } else {
		     if($columna==3){
                    $usu_conf_encriptado=trim($leido);
		         	$columna=$columna+1;
	         } else {
		         if($columna==4){
                     $pass_conf_encriptado=trim($leido);
		             $columna=$columna+1;
	             } else {
		  
		         }
		     }
		}
	}	  
 } 
 fclose($file); 
 
 $linea=$usuario_super_encriptado ."," . $pass_super_encriptado ."," . $usu_conf_encriptado ."," . $pass_conf_encriptado;	
 
 //$usuario_super_text=MyDecrypt($usuario_super_encriptado,$PASSWORD_ENCRIPTAR);
 $usuario_super_text = openssl_decrypt($usuario_super_encriptado, "AES-128-ECB", SECRETKEY);
 //$pass_super_text=MyDecrypt($pass_super_encriptado,$PASSWORD_ENCRIPTAR);  
 $pass_super_text = openssl_decrypt($pass_super_encriptado, "AES-128-ECB", SECRETKEY);
 //$usu_conf_text=MyDecrypt($usu_conf_encriptado,$PASSWORD_ENCRIPTAR);  
 $usu_conf_text = openssl_decrypt($usu_conf_encriptado, "AES-128-ECB", SECRETKEY);
 //$pass_conf_text=MyDecrypt($pass_conf_encriptado,$PASSWORD_ENCRIPTAR);
 $pass_conf_text = openssl_decrypt($pass_conf_encriptado, "AES-128-ECB", SECRETKEY);
  
 //Limpia las cadenas
 $usuario_super_text=trim($usuario_super_text);  
 $usuario_super_text=substr($usuario_super_text,1,strlen($usuario_super_text));  
 $usuario_super_text=substr($usuario_super_text,0,strlen($usuario_super_text)-1);  

 $pass_super_text=trim($pass_super_text);
 $pass_super_text=substr($pass_super_text,1,strlen($pass_super_text));
 $pass_super_text=substr($pass_super_text,0,strlen($pass_super_text)-1);

 $usu_conf_text=trim($usu_conf_text);
 $usu_conf_text=substr($usu_conf_text,1,strlen($usu_conf_text));
 $usu_conf_text=substr($usu_conf_text,0,strlen($usu_conf_text)-1);

 $pass_conf_text=trim($pass_conf_text);
 $pass_conf_text=substr($pass_conf_text,1,strlen($pass_conf_text));
 $pass_conf_text=substr($pass_conf_text,0,strlen($pass_conf_text)-1);
 
 $datos=array();   
 $especiales=array();
 $combo=array();               

 $datos=$datos + ["retorno"=>"TRUE"];
 $datos=$datos + ["msg"=>""];
 $datos=$datos + ["llave"=>""];
 $datos=$datos + ["especiales"=>$especiales];
 $datos=$datos + ["combo"=>$combo ];
 $datos=$datos + ["Usuario_Super"=>$usuario_super_text];
 $datos=$datos + ["Password_Super"=>$pass_super_text];
 $datos=$datos + ["Usuario_Conf"=>$usu_conf_text];
 $datos=$datos + ["Password_Conf"=>$pass_conf_text];
 
 //print_r($datos);
 array_push($retorno,$datos);    

 //print_r($retorno);
 $retorno=json_encode($retorno);	 

 echo $retorno;  
 
?> 
  