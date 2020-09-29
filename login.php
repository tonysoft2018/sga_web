<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/png" href="img/favicon.ico"/>
<?php
// ----------------------------------------------------------------------------------
// index.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. IDEATECH
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 20/08/2018
// ----------------------------------------------------------------------------------

 


ob_start();
session_start();

function CONVERSION($l_Str){
	$str = $l_Str;
	$decoded = utf8_decode($str);
	if (mb_detect_encoding($decoded , 'UTF-8', true) === false){
		return $str;
	} else{
	  return $decoded;
	}
}

// ----------------------------------------------
date_default_timezone_set("America/Mexico_City");
// ----------------------------------------------

// ----------------------------------------------
// Clases 
include_once "bd/conexion_ext.php";
include_once "clases/clHerramientas_v2011.php";
include_once "clases/ambiente_bannerapp.mysql.class_v2.0.0.php";
include_once "clases/ambiente_logo.mysql.class_v2.0.0.php";
include_once "clases/relauxs.mysql.class_v2.0.0.php";
include_once "clases/sesion.mysql.class_v2.0.0.php";
include_once "clases/usuarios.mysql.class_v2.0.0.php";
// ----------------------------------------------

// ----------------------------------------------
// Funciones
include_once "utilerias/utilerias.php";
include_once "parametros/env.php"; 
// ----------------------------------------------

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true);   
// ----------------------------------------------

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
// Carga el Logo
$l_UBICACION="adjuntos/";
$l_LOGOAPP="";
$l_Condicion="bEstado=0";
$tbl_logo = new  cltbl_Ambiente_Logo_v2_0_0();
$tbl_logo->Inicializacion();
$tbl_logo->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_logo->Leer($l_Condicion);
if($tbl_logo->CualEsElNumeroDeRegistrosCargados()>0){
	$registros=$tbl_logo->dtBase();
	$l_LOGOAPP=$registros[0]["Logo"];
}  
// ----------------------------------------------

if(isset($_SESSION['NUMERODESESION'])){
 
	echo "        <input id='txt_Sesion' type='hidden' name='txt_Sesion' value='" .$_SESSION['NUMERODESESION'] ."' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";
	echo "        <input id='txt_Navegador' type='hidden' name='txt_Navegador' value='" . $_SESSION['navegador'] . "' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";
	echo "        <input id='txt_GUID' type='hidden' name='txt_GUID' value='" . $_SESSION['guid'] . "' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";  	 
	echo "        <input id='txt_Token' type='hidden' name='txt_Token' value='" . $_SESSION['token'] . "' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";  	  

	// Extrae el ID de la Sesion
	$l_nIDSesion=0;
	$l_Condicion="bEstado=0 and IDSesion='" . $_SESSION['NUMERODESESION'] . "'";
	$tbl_Sesion = new  cltbl_Sesion_v2_0_0();
    $tbl_Sesion->Inicializacion();
	$tbl_Sesion->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
	$tbl_Sesion->Leer($l_Condicion);
	if($tbl_Sesion->CualEsElNumeroDeRegistrosCargados()>0){
		$registros=$tbl_Sesion->dtBase();
		$l_nIDSesion=$registros[0]["nIDSesion"];
	} else {
		session_destroy();
		header("Location: web/menu.php");
	}
	echo "        <input id='txt_ID' type='hidden' name='txt_ID' value='" . $l_nIDSesion . "' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";  	  	   	  

	// Verifica si tiene Sesion abierta	
	$l_nIDUsuario=0;
	$l_Condicion="bEstado=0 and nIDSesion=" . $l_nIDSesion;
	$tbl_RelaUxS = new  cltbl_RelaUxS_v2_0_0();
	$tbl_RelaUxS->Inicializacion();
	$tbl_RelaUxS->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
	$tbl_RelaUxS->Leer($l_Condicion);
	if($tbl_RelaUxS->CualEsElNumeroDeRegistrosCargados()>0){
		$registros=$tbl_RelaUxS->dtBase();
		$l_nIDUsuario=$registros[0]["nIDUsuario"];

		if($l_nIDUsuario>0){

			// Enviarlo al menu principal
			header("Location: web/menu.php");

			exit(1);
		} else {
			// Cambia el estatus a eliminado
			$tbl_RelaUxS->CambiarEstado($l_nIDSesion, $l_Observaciones, $l_bEstado);		 
		}
	}

} else {
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

	echo "        <input id='txt_Sesion' type='hidden' name='txt_Sesion' value='" .$valor_sesion_codificada ."' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";
	echo "        <input id='txt_Navegador' type='hidden' name='txt_Navegador' value='" .$navegador. "' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";
	echo "        <input id='txt_GUID' type='hidden' name='txt_GUID' value='" . $l_GUID. "' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";  	 
	echo "        <input id='txt_Token' type='hidden' name='txt_Token' value='" .$token. "' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";  	 	   	  
	
 
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
	for($j=1;$j<count($datos_grabar);$j++){
    	array_push($registro_datos,$datos_grabar[$j]);
	}
	array_push($registro_datos,1); // Crear 
	array_push($registro_datos,0); // Cambiar
	array_push($registro_datos,0); // Eliminar
 
	$tbl_Sesion->setInformacion_Grabar($registro_datos);

	$l_nIDSesion=0;
	if($tbl_Sesion->Ejecutar()){		
		$l_Condicion="bEstado=0 and IDSesion='" . $_SESSION['NUMERODESESION'] . "'";
		$tbl_Sesion = new  cltbl_Sesion_v2_0_0();
		$tbl_Sesion->Inicializacion();
		$tbl_Sesion->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
		$tbl_Sesion->Leer($l_Condicion);
		if($tbl_Sesion->CualEsElNumeroDeRegistrosCargados()>0){
			$registros=$tbl_Sesion->dtBase();
			$l_nIDSesion=$registros[0]["nIDSesion"];
			 
		} else {
			 
		}
	} else {
		 
	}
	
	echo "        <input id='txt_ID' type='hidden' name='txt_ID' value='" . $l_nIDSesion . "' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";  	
}

?>

	<title> <?php echo $TITULO . $VERSION ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="img/favicon.ico"/>
	<meta http-equiv="x-ua-compatible" content="ie-edge">

	<!-- *************************************************************** --> 
	<link href="css/mensajes.css" rel="stylesheet" type="text/css">
	<link href="css/login.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<!-- *************************************************************** -->

	<!-- *************************************************************** -->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>	 
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">	 
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css"> 
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css"> 
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css"> 
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css"> 
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css"> 
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css"> 
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css"> 
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!-- *************************************************************** -->

	<!-- *************************************************************** -->
	<!--ACCIONES -->	 
	<script src="js/acceso.js"></script>
	<script type="text/javascript" src="lib/jquery-3.3.1.slim.min.js"></script>
	<script type='text/javascript' src="lib/jquery-1.8.3.min.js"></script>
	<script type='text/javascript' src="lib/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="lib/popper.min.js"></script>
	<script type="text/javascript" src="lib/bootstrap.min.js"></script>
	<!-- *************************************************************** -->
	<script>
     	function deshabilitaRetroceso(){

        	 // -----------------------------------------------
		 	// Evita el retroceso
         	window.location.hash="no-back-button";
         	window.location.hash="Again-No-back-button" //chrome
         	window.onhashchange=function(){window.location.hash="no-back-button";}
		 	// ----------------------------------------------- 
     	}     	 
	</script>
	<!-- *************************************************************** -->

</head>
<body onload="deshabilitaRetroceso()">

<!-- MENSAJES -->    
<div class="modal fade" id="modal_espera">
     	<div class="modal-dialog">
     	    <div class="modal-content" style='background-color:#CCCCCC;'>
     	     				
	            <!-- CABEZERA -->
     	        <div class="modal-header">
     	     	    <h4 class="modal-title"></h4>
     	     	    <button type="button" class="close" data-dismiss="modal" onclick="">&times;</button>
     	        </div>

     	        <!-- CUERPO -->
     	        <div class="modal-body justify-content-center align-items-center " style='color:#fff;'>
     	     	   <center><label id='lbl_mensaje_espera'> ESPERE UN MOMENTO  </label></center>
     	        </div>

     	        <!-- PIE DE PAGINA -->
     	        <div class="modal-footer">
     	     	    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
     	        </div>
     	     </div>
         </div>     	 
     </div>

    <div class="modal fade" id="modal_exitoso">
     	<div class="modal-dialog">
     	    <div class="modal-content" style='background-color:#009900;'>
     	     				
	            <!-- CABEZERA -->
     	        <div class="modal-header">
     	     	    <h4 class="modal-title"></h4>
     	     	    <button type="button" class="close" data-dismiss="modal" onclick="Ingresar()">&times;</button>
     	        </div>

     	        <!-- CUERPO -->
                 <div class="modal-body justify-content-center align-items-center " style='color:#fff;'>
				 		<center><label id='lbl_mensaje_exitoso'> ACCESO CORRECTO </label></center>
     	         </div>

     	        <!-- PIE DE PAGINA -->
     	        <div class="modal-footer">
     	     	    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="Ingresar()">Cerrar</button>
     	        </div>
     	     </div>
         </div>     	 
     </div>
      
    <div class="modal fade" id="modal_falla">
     	<div class="modal-dialog">
     	    <div class="modal-content" style='background-color:#FF0000;'>
     	     				
	            <!-- CABEZERA -->
     	        <div class="modal-header">
     	     	    <h4 class="modal-title"></h4>
     	     	    <button type="button" class="close" data-dismiss="modal" onclick="">&times;</button>
     	        </div>

     	        <!-- CUERPO -->
     	        <div class="modal-body justify-content-center align-items-center " style='color:#fff;'>
     	     	   <center><label id='lbl_mensaje_falla'> ACCESO DENEGADO </label></center>
     	        </div>

     	        <!-- PIE DE PAGINA -->
     	        <div class="modal-footer">
     	     	    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
     	        </div>
     	     </div>
         </div>     	 
     </div>
     <!-- FIN MENSAJES -->      

	 
	
	<div class="limiter" style='position:absolute; top:20px;'>
		<div class="container-login100">
			<div class="wrap-login100">				 
					<span class="login100-form-title p-b-26">
						Bienvenido
					</span>
					<span class="login100-form-title p-b-48">
						<img src="<?php echo $l_UBICACION . $l_LOGOAPP ?>" id="FondoPrincipal1" alt="" style="height:120px;width:120px;visibility:visible;" >  
					</span>

					<div class="wrap-input100 validate-input"data-validate="Introduce el usuario" >
						<input id='txt_usuario1' class="input100" type="text" name="email1">
						<span class="focus-input100" data-placeholder="Usuario"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Introduce la contraseña">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input id="txt_password1" class="input100" type="password" name="pass1">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login100-form-btn" >
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" onclick="fn_Acceso_Clic();">
								ENTRAR
							</button>
						</div>
					</div>
  
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>