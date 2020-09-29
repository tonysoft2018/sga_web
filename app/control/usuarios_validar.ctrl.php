<?php
// ----------------------------------------------------------------------------------
// usuarios_validar.ctrl..php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe usuario y password
//              - Devuelve el resultado en JSON.  
//                {
//                    retorno=>TRUE/FALSE, msg=>"MENSAJE",[REGISTROS] 
//                } 
// ----------------------------------------------------------------------------------
// Empresa. IDEATECH
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 05/11/2019
// ----------------------------------------------------------------------------------

// ----------------------------------------------
date_default_timezone_set("America/Mexico_City");
// ----------------------------------------------

ob_start();
session_start();

$l_Usuario="";
$l_Pass="";
if(!empty($_GET)){ 
    if (isset($_GET['usuario'])){
        $l_Usuario=$_GET['usuario']; 
    }   

    if (isset($_GET['pass'])){
        $l_Pass=$_GET['pass'];
    }
 } 

 if(strlen($l_Usuario)<=0){
    echo "INCORRECTO";
    exit(1);
 }

 if(strlen($l_Pass)<=0){
    echo "INCORRECTO";
    exit(1);
 }
 
include_once "../../clases/clHerramientas_v2011.php"; 
include_once "../../clases/usuarios.mysql.class_v2.0.0.php"; 
include_once "../../clases/relauxs.mysql.class_v2.0.0.php";
include_once "../../clases/sesion.mysql.class_v2.0.0.php";

include_once "../../bd/conexion_app.php";
 // ----------------------------------------------

 // ----------------------------------------------
$hoy=getdate();
$token = sha1(rand(0,999).rand(999,9999).rand(1,300));
$l_GUID=uniqid();
$navegador="";
$browser_type = getenv("HTTP_USER_AGENT");
if (preg_match("/MSIE/i", "$browser_type")) {
	$navegador="Microsoft Internet Explorer";
} else if (preg_match("/Mozilla/i", "browser_type")) {
	$navegador="Netscape Comunicato";
} else {
	$navegador="$browser_type";
}
$_SESSION['NUMERODESESION']=$hoy[0];

$valor_sesion_codificada=base64_encode($_SESSION['NUMERODESESION']);
$_SESSION['token'] = $token;
$_SESSION['navegador'] = $navegador;
$_SESSION['guid'] = $l_GUID;
$_SESSION['NUMERODESESION']=$valor_sesion_codificada;
    
// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true); 
 
// ----------------------------------------------
 
// ----------------------------------------------   
// Leer la info para procesar
$tbl = new  cltbl_Usuarios_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$Campo_Llave=$tbl->get_CampoLlave();

$l_Condicion="Usuario='" . $l_Usuario . "' and Password='" . $l_Pass . "' and App='SI' and Activo='SI' and bEstado=0";
 
if(strlen($l_Condicion)>0){
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->Leer($l_Condicion);

    if($tbl->CualEsElNumeroDeRegistrosCargados()>0){     

        $registros=$tbl->dtBase();
		$l_nIDUsuario=$registros[0]["nIDUsuario"];

        // ----------------------------------------------
        // Carga datos generales
        $UtileriasDatos = new clHerramientasv2011();
        $l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
        $l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);
        $NombrePC = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $Fecha = date('Y-m-d');
        $Hora = date('H:i:s');
        $l_FechaModificacion=$Fecha." ".$Hora;
        $l_FechaCreacion=$Fecha." ".$Hora;
        $l_Observaciones="Nueva captura - Creado por  - ".$NombrePC." - ".get_current_user()." - ".$l_FechaModificacion;
        $l_bEstado=0;
        // ----------------------------------------------

        // ----------------------------------------------
        // Graba la sesion
        $tbl_Sesion = new  cltbl_Sesion_v2_0_0();
        $tbl_Sesion->Inicializacion();
	    $tbl_Sesion->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
	    $tbl_Sesion->CargarCampos("GRABAR");
 
	    $datos_grabar = array();
	    array_push($datos_grabar,0);
	    array_push($datos_grabar,$valor_sesion_codificada);
	    array_push($datos_grabar,$navegador);
	    array_push($datos_grabar,$l_GUID);
	    array_push($datos_grabar,$token);
	 
	    array_push($datos_grabar,$l_FechaLocal);
	    array_push($datos_grabar,$l_FechaLocal);
	    array_push($datos_grabar,$l_Observaciones);
	    array_push($datos_grabar,0);
 
	    $registro_datos=array($datos_grabar[0]);
	    for ($j=1;$j<count($datos_grabar);$j++){
        	array_push($registro_datos,$datos_grabar[$j]);
	    }
	    array_push($registro_datos,1); // Crear 
	    array_push($registro_datos,0); // Cambiar
	    array_push($registro_datos,0); // Eliminar
 
        $tbl_Sesion->setInformacion_Grabar($registro_datos);

        
	    $l_nIDSesion=0;
	    if($tbl_Sesion->Ejecutar()){		
		    $l_Condicion="bEstado=0 and IDSesion='" . $valor_sesion_codificada . "'";
		    $tbl_Sesion = new  cltbl_Sesion_v2_0_0();
		    $tbl_Sesion->Inicializacion();
		    $tbl_Sesion->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
		    $tbl_Sesion->Leer($l_Condicion);
		    if($tbl_Sesion->CualEsElNumeroDeRegistrosCargados()>0){
			    $registros=$tbl_Sesion->dtBase();
                $l_nIDSesion=$registros[0]["nIDSesion"];			 
                
                $tbl_RelaUxS = new  cltbl_RelaUxS_v2_0_0();
                $tbl_RelaUxS->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_RelaUxS->CargarCampos("GRABAR");
                
                $datos_grabar = array();
                                    
                array_push($datos_grabar,0);
                array_push($datos_grabar,$l_nIDUsuario);
                array_push($datos_grabar,$l_nIDSesion);
                 
                array_push($datos_grabar,$l_FechaLocal);
                array_push($datos_grabar,$l_FechaLocal);
                array_push($datos_grabar,$l_Observaciones);
                array_push($datos_grabar,0);
                
                $registro_datos=array($datos_grabar[0]);
                for($j=1;$j<count($datos_grabar);$j++){
                    array_push($registro_datos,$datos_grabar[$j]);
                }
                array_push($registro_datos,1); // Crear 
                array_push($registro_datos,0); // Cambiar
                array_push($registro_datos,0); // Eliminar
                
                $tbl_RelaUxS->setInformacion_Grabar($registro_datos);

                if($tbl_RelaUxS->Ejecutar()){
                    echo "TRUE";
                } else {
                    echo "ERROR AL GRABAR LA RELACION";
                }
		    } else {
                echo "ERROR SESION NO ENCONTRADA";
		    }
        } else {
            echo "ERROR AL GRABAR LA SESION";
        }    
        // ----------------------------------------------
        
    } else {
        echo "USUARIO/CONTRASENA INVALIDOS";
    }      
} else {
   echo "NO TIENE CONDICION";
}

?>