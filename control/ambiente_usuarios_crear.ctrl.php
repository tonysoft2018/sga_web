<?php
// ----------------------------------------------------------------------------------
// ambiente_usuarios_crear.ctrl.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { 
//                     datos[]
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

include_once "../parametros/env.php"; 

// Datos generales 
$NOMBRE_ARCHIVO="usuarios.txt";
$opciones = [
    'cost' => 12,
];

// Librerias
//include_once "../utilerias/security.php";
include_once "../clases/clHerramientas_v2011.php";   
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
// Leer la info para procesar
 
for($i=0;$i<$l_NumeroDeRegistros;$i++){   
     // Extraer la información
     $l_Usuario_Super=$arreglos[$i]->{"usuario_super"};    
     $l_Password_Super=$arreglos[$i]->{"password_super"};
     $l_Usuario_Conf=$arreglos[$i]->{"usuario_conf"};
     $l_Password_Conf=$arreglos[$i]->{"password_conf"};

     // Limpia la información leida
     $l_Usuario_Super=trim($l_Usuario_Super);
     $l_Password_Super=trim($l_Password_Super);
     $l_Usuario_Conf=trim($l_Usuario_Conf);
     $l_Password_Conf=trim($l_Password_Conf);

     // -------------------------------------------------------------------------
     // VALIDACION
     if(strlen($l_Usuario_Super)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"Debe de Capturar el Nombre del Super Usuario"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
     }

     if(strlen($l_Password_Super)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"Debe de Capturar el Password del Super Usuario"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
     }

     if(strlen($l_Usuario_Conf)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"Debe de Capturar el Usuario de Configuracion"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
     }

     if(strlen($l_Password_Conf)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"Debe de Capturar Password del usuario de Configuracion"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
     }
     // -------------------------------------------------------------------------

     // -------------------------------------------------------------------------       
     // Genera los datos a grabar
     $l_Usuario_Super_text="[" . $l_Usuario_Super . "]";
     $l_Password_Super_text="[" . $l_Password_Super . "]";
     $l_Usuario_Conf_text = "[" . $l_Usuario_Conf . "]";
     $l_Password_Conf_text="[" . $l_Password_Conf . "]"; 
     // -------------------------------------------------------------------------

     // -------------------------------------------------------------------------       
     // Encripta la información
     $l_Usuario_Super_encriptado="";
     $l_Password_Super_encriptado="";
     $l_Usuario_Conf_encriptado="";
     $l_Password_Conf_encriptado="";

     //$l_Usuario_Super_encriptado=MyCrypt($l_Usuario_Super_text,$PASSWORD_ENCRIPTAR);
     $l_Usuario_Super_encriptado = openssl_encrypt($l_Usuario_Super_text, "AES-128-ECB", SECRETKEY);
     //$l_Password_Super_encriptado=MyCrypt($l_Password_Super_text,$PASSWORD_ENCRIPTAR);
     $l_Password_Super_encriptado = openssl_encrypt($l_Password_Super_text, "AES-128-ECB", SECRETKEY);
     //$l_Usuario_Conf_encriptado=MyCrypt($l_Usuario_Conf_text,$PASSWORD_ENCRIPTAR);
     $l_Usuario_Conf_encriptado = openssl_encrypt($l_Usuario_Conf_text, "AES-128-ECB", SECRETKEY);
     //$l_Password_Conf_encriptado=MyCrypt($l_Password_Conf_text,$PASSWORD_ENCRIPTAR);
     $l_Password_Conf_encriptado = openssl_encrypt($l_Password_Conf_text, "AES-128-ECB", SECRETKEY);
     // -------------------------------------------------------------------------       
       
     // -------------------------------------------------------------------------
     // GRABAR     
     $file = fopen($UBICACION_BD . $NOMBRE_ARCHIVO, "w"); 
     fwrite($file, $l_Usuario_Super_encriptado . PHP_EOL); 
     fwrite($file, $l_Password_Super_encriptado . PHP_EOL); 
     fwrite($file, $l_Usuario_Conf_encriptado . PHP_EOL); 
     fwrite($file, $l_Password_Conf_encriptado . PHP_EOL);
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
  