<?php
// ----------------------------------------------------------------------------------
// generar_archivoconexion.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Programa utilizado para generar el archivo de conexión para la 
//              base de datos
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 29/08/2019
// ----------------------------------------------------------------------------------

include_once "security.php";

$password_encriptar = "Kb.204.h3";

$l_Servidor="";
$l_Usuario="";
$l_Contrasena="";
$l_BD="";

if(!empty($_GET)){ 
    if (isset($_GET['servidor'])){
      $l_Servidor=$_GET['servidor']; 
    }  
    
    if (isset($_GET['usuario'])){
      $l_Usuario=$_GET['usuario']; 
    }
  
    if (isset($_GET['contrasena'])){
        $l_Contrasena=$_GET['contrasena']; 
    }
    
    if (isset($_GET['basedatos'])){
        $l_BD=$_GET['basedatos']; 
    }   
}

if(strlen($l_Servidor)<=0){
    echo "NO TIENE SERVIDOR O HOST";
    exit(1);
}

if(strlen($l_Usuario)<=0){
    echo "NO TIENE USUARIO";
    exit(1);
}

if(strlen($l_Contrasena)<=0){
    echo "NO TIENE CONTRASEÑA";
    exit(1);
}

if(strlen($l_BD)<=0){
    echo "NO TIENE NOMBRE DE LA BASE DE DATOS";
    exit(1);
}

// Limpia la información leida
$l_Servidor=trim($l_Servidor);
$l_Usuario=trim($l_Usuario);
$l_Contrasena=trim($l_Contrasena);
$l_BD=trim($l_BD);

// Genera los datos a grabar
$server_text="[" . $l_Servidor . "]";
$usu_text="[" . $l_Usuario . "]";
$pass_text = "[" . $l_Contrasena . "]";
$bd_text="[" . $l_BD . "]";

echo "Datos para encriptar server:" . $server_text ."<br>";
echo "Datos para encriptar usuario:" . $usu_text ."<br>";
echo "Datos para encriptar pass:" . $pass_text ."<br>";
echo "Datos para encriptar bd:" . $bd_text ."<br>";


// Encripta la información
$server_text_encriptado="";
$usu_text_encriptado="";
$pass_text_encriptado="";
$bd_text_encriptado="";

$server_text_encriptado=MyCrypt($server_text,$password_encriptar);
$usu_text_encriptado=MyCrypt($usu_text,$password_encriptar);
$pass_text_encriptado=MyCrypt($pass_text,$password_encriptar);
$bd_text_encriptado=MyCrypt($bd_text,$password_encriptar);

echo "Datos encriptados server:" .$server_text_encriptado . "<br>";
echo "Datos encriptados usuario:" .$usu_text_encriptado . "<br>";
echo "Datos encriptados pass:" .$pass_text_encriptado . "<br>";
echo "Datos encriptados bd:" .$bd_text_encriptado . "<br>";

// Graba la información encriptada
$file = fopen("conexion.txt", "w"); 
fwrite($file, $server_text_encriptado . PHP_EOL); 
fwrite($file, $usu_text_encriptado . PHP_EOL); 
fwrite($file, $pass_text_encriptado . PHP_EOL); 
fwrite($file, $bd_text_encriptado . PHP_EOL);
fclose($file);


echo "Grabado:conexion.txt";
 
?>