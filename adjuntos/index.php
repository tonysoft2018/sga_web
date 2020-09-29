<!DOCTYPE html>
<html>
<html>
<?php
// ----------------------------------------------------------------------------------
// index.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. Cloud Consulting and Desing SA. de CV
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 20/08/2018
// ----------------------------------------------------------------------------------

// Enviar a otra pagina
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
// Clases 
include_once "bd/conexion_ext.php";
include_once "clases/clHerramientas_v2011.php";
include_once "clases/ambiente_bannerapp.mysql.class_v2.0.0.php";
include_once "clases/relauxs.mysql.class_v2.0.0.php";
include_once "clases/sesion.mysql.class_v2.0.0.php";
include_once "clases/usuarios.mysql.class_v2.0.0.php";
// ----------------------------------------------

// ----------------------------------------------
// Funciones
include_once "utilerias/utilerias.php";
include_once "usuario_verificasesion.php";
// ----------------------------------------------

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true);  
// ----------------------------------------------

// ----------------------------------------------
// Carga la imagen de fondo
$l_IMAGENFONDOAPP="";
$l_UBICACION="adjuntos/";
$l_Condicion="bEstado=0";
$tbl_bannerapp = new  cltbl_Ambiente_BannerApp_v2_0_0();
$tbl_bannerapp->Inicializacion();
$tbl_bannerapp->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_bannerapp->Leer($l_Condicion);
if($tbl_bannerapp->CualEsElNumeroDeRegistrosCargados()>0){
	$registros=$tbl_bannerapp->dtBase();
	$l_IMAGENFONDOAPP=$registros[0]["Imagen"];
}  
// ----------------------------------------------

if(isset($_SESSION['NUMERODESESION'])){
	echo "        <input id='txt_Sesion' type='hidden' name='txt_Sesion' value='" .$_SESSION['NUMERODESESION'] ."' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";
	echo "        <input id='txt_Navegador' type='hidden' name='txt_Navegador' value='" . $_SESSION['navegador'] . "' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";
	echo "        <input id='txt_GUID' type='hidden' name='txt_GUID' value='" . $_SESSION['guid'] . "' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";  	 
	echo "        <input id='txt_Token' type='hidden' name='txt_Token' value='" . $_SESSION['token'] . "' style='visibility:hidden;position:absolute;top:1px;left:1px;'>\n";  	  
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
	 
	if($tbl_Sesion->Ejecutar()){
		 
	}  	 
}
 
?>
<head> 
<title>SGA</title>
<meta charset="utf-8">
<meta name="viewport" content="width=dev-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie-edge">
	
<!-- *************************************************************** -->
<!--FORMA -->
<link href="css/mensajes.css" rel="stylesheet" type="text/css">
<link href="css/login.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<!-- *************************************************************** -->

<!-- *************************************************************** -->
<!--ACCIONES -->
<!-- <script src="js/jquery-1.12.2.min.js" type="text/javascript"></script> -->
<script src="js/acceso.js"></script>
<script type="text/javascript" src="lib/jquery-3.3.1.slim.min.js"></script>
<script type="text/javascript" src="lib/popper.min.js"></script>
<script type="text/javascript" src="lib/bootstrap.min.js"></script>

<script>
     function deshabilitaRetroceso(){

         // -----------------------------------------------
		 // Evita el retroceso
         window.location.hash="no-back-button";
         window.location.hash="Again-No-back-button" //chrome
         window.onhashchange=function(){window.location.hash="no-back-button";}
		 // -----------------------------------------------

		 // -----------------------------------------------
		 // Bloquea q ingrese al sitio desde un dispositivo Movil.
		 fn_Posicionar_Fondo();
	     fn_Posicionar_Fondo_Encabezados();
		 // -----------------------------------------------
     }

     function Resize()
     {
		 fn_Posicionar_Fondo();
         fn_Posicionar_Fondo_Encabezados();
     }
     window.onresize=Resize;
</script>
<!-- *************************************************************** -->

<!-- ****************************************************************************************** -->
</head>

<body onload="deshabilitaRetroceso()" id="idBody" style="background-color:#3982C3; visibility:hidden; ">

<!-- Elementos -->
<?php
if(strlen($l_IMAGENFONDOAPP)>0){
?>
		<img src="<?php echo $l_UBICACION . $l_IMAGENFONDOAPP ?>" id="FondoPrincipal1" alt="" style="position:absolute;top:0px;left:0px;visibility:visible;" > 
<?php
} else {
?>
		<img src="<?php echo $l_IMAGENFONDOAPP ?>" id="FondoPrincipal1" alt="" style="position:absolute;top:0px;left:0px;visibility:hidden;" > 
<?php
}
?>


<img src="iconos/logozgas.png" id="logo_app" alt="" style="position:absolute;top:50px;left:20px;height:50px;width:50px;z-index:20;visibility:visible;">



<label id="lbl_Titulo" style="color:#FFF;font-family:Verdana;font-size:16px;visibility:visible;z-index:10"> Sistema de Gestion de Almacen</label>
<img src="img/logo_app.png" id="Fondo1" alt="" style="position:absolute;top:50px;left:20px;height:400px;width:280px;opacity:0.50;visibility:hidden;" >
<input type="text" id="txt_usuario1" style="position:absolute;left:134px;top:64px;width:470px;height:20px;line-height:20px;z-index:4;border: 1px #D3D3D3 solid; -moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px;
   background-color: #FFFFFF;
   background-image: none;
   color :#000000;
   font-family: Verdana;
   font-weight: normal;
   font-size: 16px;
   padding: 4px 4px 4px 4px;
   text-align: center;
   vertical-align: middle;" name="txt_usuario" value="" placeholder="Usuario">
<input type="password" id="txt_password1" style="position:absolute;left:134px;top:113px;width:470px;height:20px;line-height:20px;z-index:5;border: 1px #D3D3D3 solid;
   -moz-border-radius: 10px;
   -webkit-border-radius: 10px;
   border-radius: 10px;
   background-color: #FFFFFF;
   background-image: none;
   color :#000000;
   font-family: Verdana;
   font-weight: normal;
   font-size: 16px;
   padding: 4px 4px 4px 4px;
   text-align: center;
   vertical-align: middle;" name="txt_password" value="" placeholder="password" onkeypress="fn_Acceso(event);">

<button id='bt_Entrar' style="" onclick="fn_Acceso_Clic();"> ENTRAR </button>
<img src="img/ccd_color.jpg" id="logo_cloud" alt="" style='width:200px;height:45px;'>

<input type="hidden" name="token" id="txt_Token" class="form-control" value='<?php echo $token ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>
<input type="hidden" name="navegador" id="txt_Navegador" class="form-control" value='<?php echo $navegador ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>
<input type="hidden" name="guid" id="txt_Guid" class="form-control" value='<?php echo $l_GUID ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>
<input type="hidden" name="numerosesion" id="txt_NumeroSesion" class="form-control" value='<?php echo $hoy[0] ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>

 

<div id="webheader" style="position:absolute;overflow:hidden;text-align:left;left:0px;top:0px;width:1024px;height:118px;z-index:16;">
     <div id="Layer2" style="position:absolute;text-align:left;left:0px;top:92px;width:100%;height:24px;z-index:1;">
     </div>
     <div id="Layer1" style="position:absolute;text-align:left;left:0px;top:0px;width:100%;height:92px;z-index:2;">
         <div id="wb_Image1" style="position:absolute;left:85px;top:1px;width:161px;height:91px;z-index:0;">

		 </div>
     </div>
</div>

<div id="Layer3" style="position:absolute;text-align:left;left:0px;top:167px;width:990px;height:413px;z-index:14;">
     <div id="wb_Text1" style="position:absolute;left:467px;top:19px;width:95px;height:23px;z-index:7;text-align:left;">
	     <span style="color:#000000;font-family:Verdana;font-size:19px;">INGRESO</span>
	 </div>
     <div id="Layer4" style="position:absolute;text-align:left;left:139px;top:59px;width:748px;height:228px;z-index:8;">
     </div>

	 <div id="wb_Text2" style="position:absolute;left:410px;top:309px;width:208px;height:23px;z-index:9;text-align:left;">
		<span style="color:#000000;font-family:Verdana;font-size:19px;">Descargar aplicaci&oacute;n</span>
	 </div>
	 <div id="wb_Shape1" style="position:absolute;left:348px;top:360px;width:153px;height:38px;z-index:10;">
		 
	 <div id="wb_FontAwesomeIcon1" style="position:absolute;left:358px;top:368px;width:24px;height:22px;text-align:center;z-index:11;">
	 <div id="FontAwesomeIcon1"><i class="fa fa-android">&nbsp;</i></div></div>
	 <div id="wb_Shape2" style="position:absolute;left:518px;top:360px;width:153px;height:38px;z-index:12;">
		<a href=""><div id="Shape2"><div id="Shape2_text"><span style="color:#FFFFFF;font-family:Verdana;font-size:17px;">&nbsp; APPLE</span></div></div></a></div>
	 <div id="wb_FontAwesomeIcon2" style="position:absolute;left:531px;top:368px;width:24px;height:22px;text-align:center;z-index:13;">
	 <div id="FontAwesomeIcon2"><i class="fa fa-apple">&nbsp;</i></div></div>
</div>

<div id="PageFooter11" style="position:absolute;text-align:left;left:0px;top:600px;width:1028px;height:79px;">

</div>
 
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
     	     	    <button type="button" class="close" data-dismiss="modal" onclick="Cerrar_Clic()">&times;</button>
     	        </div>

     	        <!-- CUERPO -->
                 <div class="modal-body justify-content-center align-items-center " style='color:#fff;'>
				 		<center><label id='lbl_mensaje_exitoso'> ACCESO CORRECTO </label></center>
     	         </div>

     	        <!-- PIE DE PAGINA -->
     	        <div class="modal-footer">
     	     	    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="Cerrar_Clic()">Cerrar</button>
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

	  <!-- SEGURIDAD Y PROCESOS --->
 	  <script>
		$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
  			if (!$(this).next().hasClass('show')) {
    			$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
  			}
  			var $subMenu = $(this).next(".dropdown-menu");
  			$subMenu.toggleClass('show');

  			$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
    			$('.dropdown-submenu .show').removeClass("show");
  			});

  			return false;
        });
		</script>     
</body>
</html>
 