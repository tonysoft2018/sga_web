<!DOCTYPE html>
<html>
<head>
    <?php   
        // ----------------------------------------------------------------------------------
        // traspaso_envio.php
        // ----------------------------------------------------------------------------------
        // Autor. Ing. Antonio Barajas del Castillo
        // ----------------------------------------------------------------------------------
        // Empresa. IDEATECH
        // ----------------------------------------------------------------------------------
        // Descripcion. Modulo para editar datos de un perfil.
        // ----------------------------------------------------------------------------------
        // Fecha Ultima Modificación
        // 13/07/2020
        // ----------------------------------------------------------------------------------
        // V2.0.2
        // ----------------------------------------------------------------------------------

        ob_start();
        session_start();

        $l_Modulo="traspasos_envio"; 
        $l_Accion="Listado";   //Listado/Crear/Editar/Eliminar/Consultar/Imprimir  

        include_once "../parametros/env.php";          
        include_once "../parametros/modulos.php";

        // ----------------------------------------------
        // Conexion con la base de Datos
        include_once "../bd/conexion.php";
        $l_Regreso=RegresaConexion();
        $CONEXION=json_decode($l_Regreso,true); 
        // ----------------------------------------------

        // ---------------------------------------------
        // AREA DE SEGURIDAD
        // Buscar el usuario
        include_once "../clases/relauxs.mysql.class_v2.0.0.php";  
        $NIDUSUARIO=0;
        if(isset($_SESSION['NUMERODESESION'])){
            $l_Condicion="bEstado=0 and IDSesion='" . $_SESSION['NUMERODESESION'] . "'";      
            $tbl_RelaUxS = new  cltbl_RelaUxS_v2_0_0();
            $tbl_RelaUxS->Inicializacion();
            $tbl_RelaUxS->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_RelaUxS->Leer($l_Condicion);
            if($tbl_RelaUxS->CualEsElNumeroDeRegistrosCargados()>0){
                $registros=$tbl_RelaUxS->dtBase();                
                $NIDUSUARIO=$registros[0]["nIDUsuario"];

                if($NIDUSUARIO<=0){
                   session_destroy();
                   header("Location: ../index.php");
                }
            } else {
                session_destroy();
                header("Location: ../index.php");
            }
        } else {
           //echo "NO TIENE SESION";
           session_destroy();
           header("Location: ../index.php");            
        }        
        // ---------------------------------------------
    ?>
	<title>
        <?php echo $TITULO ?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="../img/favicon.ico"/>
	<meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

    <script type="text/javascript" src="../lib/jquery-3.3.1.slim.min.js"></script>
    <script type='text/javascript' src="../lib/jquery-1.8.3.min.js"></script>     
    <script type='text/javascript' src="../lib/jquery-1.12.2.min.js"></script>
    
	<script type="text/javascript" src="../lib/popper.min.js"></script>
    <script type="text/javascript" src="../lib/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="../js/traspasos_envio_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/traspasos_envio.vista.js"></script>
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>

    <script>
        var CAMPO_ORDENAMIENTO="<?php echo $CAMPO_ORDENAMIENTO ?>";
        var FORMA_ORDENAMIENTO="<?php echo $FORMA_ORDENAMIENTO ?>";
        var ULTIMA_CONSULTA="<?php echo $ULTIMA_CONSULTA ?>";
        var ULTIMA_CONDICION="<?php echo $ULTIMA_CONDICION ?>";
        var NUMERODEREGISTROS="<?php echo $NUMERODEREGISTROS ?>";
        var PAGINA_ACTUAL="<?php echo $PAGINA_ACTUAL ?>";

        var UBICACION_CONTROL="<?php echo $UBICACION_CONTROL ?>";

        var MODULO="<?php echo $l_Modulo ?>";
    </script>

</head>
<body>    
    <!-- MENSAJES -->    
    <div class="modal fade" id="modal_espera">
    <center>
     	<div class="modal-dialog">
     	    <div class="modal-content" style='background-color:#CCCCCC;width:50%;'>
     	     				
	            <!-- CABEZERA -->
     	        <div class="modal-header">
     	     	    <h4 class="modal-title"></h4>
     	     	     
     	        </div>

     	        <!-- CUERPO -->
     	        <div class="modal-body justify-content-center align-items-center " style='color:#fff;'>
     	     	   <center><label id='lbl_mensaje_espera'> ESPERE UN MOMENTO  </label></center>
     	        </div>

     	        <!-- PIE DE PAGINA -->
     	        <div class="modal-footer">
     	     	     
     	        </div>
     	     </div>
         </div>   
         </center>  	 
     </div>   
     <!-- FIN MENSAJES -->      

    <div class="container" >
        <!-- ENCABEZADO -->         
		<div class="row align-item-end h-50" style='background-color:#DFE1E1;'>
			<?php include_once "../parametros/encabezado.php" ?>
        </div>          
        <!-- FIN ENCABEZADO -->         
 
        <!-- MENU -->         
    	<div class="row align-item-end bg-light h-30">
            <?php include_once "../parametros/barra_menu.php" ?>   
            <br>
            <br>
        </div>
         <!-- FIN MENU -->

         <!-- BARRA DE NAVEGACION -->         
		<div class="row align-item-end h-20 bg-dark">			 
            <?php include_once "../parametros/barra_navegacion.php" ?>         
        </div>
         <!-- FIN BARRA DE NAVEGACION -->         
                
         <!-- BUSQUEDA -->
         <?php include_once "../parametros/barra_busqueda.php" ?>         
        <!-- FIN BUSQUEDA -->    
    
        <!-- BOTONES -->
        <?php include_once "../parametros/barra_botones_listado.php" ?>         
        <!-- FIN BOTONES -->
                  
         <!-- REGISTROS -->
         <div id='contenido'>  
           
         </div>

         <script>
             fn_Listado_Clic("Tipo='ENVIO' and (Estatus='ABIERTO' or Estatus='CERRADO')");
         </script>
         <!-- FIN REGISTROS -->  
	</div>
    <!-- FIN -->
  
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
    <!-- FIN PROCESAR --->
</body>
</html>