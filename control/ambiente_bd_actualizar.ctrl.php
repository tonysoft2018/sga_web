<?php
// ----------------------------------------------------------------------------------
// ambiente_bd_actualizar.ctrl.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { 
//                     info
//                } 
//              - Devuelve el resultado en JSON.
//                {
//                    retorno=>TRUE/FALSE, msg=>"MENSAJE"
//                } 
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 12/12/2019
// ----------------------------------------------------------------------------------

class ArrayValue implements JsonSerializable {
    public function __construct(array $array) {
        $this->array = $array;
    }

    public function jsonSerialize() {
        return $this->array;
    }
}

// Datos generales
include_once "../parametros/env.php";  
$NOMBRE_ARCHIVO="conexion.txt";
$opciones = [
    'cost' => 12,
];


// Librerias
include_once "../utilerias/security.php";
include_once "../clases/clHerramientas_v2011.php";  
include_once "../bd/conexion.php";
include_once "../utilerias/utilerias.php";

$retorno= array();
$arreglos = array();
$datos_grabar = array();

$registros_grabados=0;
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));
 
$l_NumeroDeRegistros=count($arreglos);

if($l_NumeroDeRegistros<=0){ 
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE DATOS PARA GRABAR"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
// ----------------------------------------------

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true);  
// ----------------------------------------------
 
 
// ----------------------------------------------   
// Leer la info para procesar
 
for($i=0;$i<$l_NumeroDeRegistros;$i++){   
    // Extraer la información
    $l_Servidor=$arreglos[$i]->{"servidor"};
    $l_Usuario=$arreglos[$i]->{"usuario"};
    $l_Password=$arreglos[$i]->{"password"};
    $l_BD=$arreglos[$i]->{"bd"};

    // Limpia la información leida
    $l_Servidor=trim($l_Servidor);
    $l_Usuario=trim($l_Usuario);
    $l_Password=trim($l_Password);
    $l_BD=trim($l_BD);

    // -------------------------------------------------------------------------
    // VALIDACION
    if(strlen($l_Servidor)<=0){
       $datos=array();
       $datos=$datos + ["retorno"=>"FALSE"];
       $datos=$datos + ["msg"=>"Debe de Capturar el campo de Servidor"];
       array_push($retorno,$datos);    
       $retorno=json_encode($retorno);	 
       echo $retorno;    
       exit(1);
    }

    if(strlen($l_Usuario)<=0){
       $datos=array();
       $datos=$datos + ["retorno"=>"FALSE"];
       $datos=$datos + ["msg"=>"Debe de Capturar el campo de Usuario"];
       array_push($retorno,$datos);    
       $retorno=json_encode($retorno);	 
       echo $retorno;    
       exit(1);
    }

    if(strlen($l_Password)<=0){
       $datos=array();
       $datos=$datos + ["retorno"=>"FALSE"];
       $datos=$datos + ["msg"=>"Debe de Capturar el campo de Password"];
       array_push($retorno,$datos);    
       $retorno=json_encode($retorno);	 
       echo $retorno;    
       exit(1);
    }

    if(strlen($l_BD)<=0){
       $datos=array();
       $datos=$datos + ["retorno"=>"FALSE"];
       $datos=$datos + ["msg"=>"Debe de Capturar el campo de Base de datos"];
       array_push($retorno,$datos);    
       $retorno=json_encode($retorno);	 
       echo $retorno;    
       exit(1);
    }
    // -------------------------------------------------------------------------

     // -------------------------------------------------------------------------       
     // Genera los datos a grabar
     $server_text="[" . $l_Servidor . "]";
     $usu_text="[" . $l_Usuario . "]";
     $pass_text = "[" . $l_Password . "]";
     $bd_text="[" . $l_BD . "]"; 

     //echo "Datos:" . $server_text . "," . $usu_text . "," . $pass_text . "," . $bd_text;
     // -------------------------------------------------------------------------

     // -------------------------------------------------------------------------       
     // Encripta la información
     $server_text_encriptado="";
     $usu_text_encriptado="";
     $pass_text_encriptado="";
     $bd_text_encriptado="";

      //$server_text_encriptado=MyCrypt($server_text,$PASSWORD_ENCRIPTAR);
      $server_text_encriptado = openssl_encrypt($server_text, "AES-128-ECB", SECRETKEY);
      //$usu_text_encriptado=MyCrypt($usu_text,$PASSWORD_ENCRIPTAR);
      $usu_text_encriptado = openssl_encrypt($usu_text, "AES-128-ECB", SECRETKEY);
      //$pass_text_encriptado=MyCrypt($pass_text,$PASSWORD_ENCRIPTAR);
      $pass_text_encriptado = openssl_encrypt($pass_text, "AES-128-ECB", SECRETKEY);
      //$bd_text_encriptado=MyCrypt($bd_text,$PASSWORD_ENCRIPTAR);
      $bd_text_encriptado = openssl_encrypt($bd_text, "AES-128-ECB", SECRETKEY);
     // -------------------------------------------------------------------------       
       
     // -------------------------------------------------------------------------
     // GRABAR     
     $file = fopen($UBICACION_BD . $NOMBRE_ARCHIVO, "w"); 
     fwrite($file, $server_text_encriptado . PHP_EOL); 
     fwrite($file, $usu_text_encriptado . PHP_EOL); 
     fwrite($file, $pass_text_encriptado . PHP_EOL); 
     fwrite($file, $bd_text_encriptado . PHP_EOL);
     fclose($file);
     // -------------------------------------------------------------------------   
} 
 
if (file_exists($UBICACION_BD . $NOMBRE_ARCHIVO)) {	
    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>"PROCESO FINALIZADO CON EXITO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE PROCESAR LOS REGISTROS"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
} 
?> 