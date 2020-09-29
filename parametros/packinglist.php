<!DOCTYPE html>
<html>
<head>
    <?php   
        // ----------------------------------------------------------------------------------
        // packinglist.php
        // ----------------------------------------------------------------------------------
        // Autor. Ing. Antonio Barajas del Castillo
        // ----------------------------------------------------------------------------------
        // Empresa. Softernium SA de CV
        // ----------------------------------------------------------------------------------
        // Descripcion. Modulo para editar datos de un perfil.
        // ----------------------------------------------------------------------------------
        // Fecha Ultima Modificación
        // 26/11/2019
        // ----------------------------------------------------------------------------------
        // V2.0.0
        // ----------------------------------------------------------------------------------
        $l_Modulo="packinglist"; 
        $l_Accion="Listado";   //Listado/Crear/Editar/Eliminar/Consultar/Imprimir  
        include_once "../parametros/modulos.php";
    ?>
	<title>
		<?php echo $l_Titulo ?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=dev-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

    <script type="text/javascript" src="../lib/jquery-3.3.1.slim.min.js"></script>
	<script type="text/javascript" src="../lib/popper.min.js"></script>
    <script type="text/javascript" src="../lib/bootstrap.min.js"></script>

    <script>
        var CAMPO_ORDENAMIENTO="<?php echo $CAMPO_ORDENAMIENTO ?>";
        var FORMA_ORDENAMIENTO="<?php echo $FORMA_ORDENAMIENTOO ?>";
        var ULTIMA_CONSULTA="<?php echo $ULTIMA_CONSULTA ?>";

        var UBICACION_CONTROL="<?php echo $UBICACION_CONTROL ?>";

        var MODULO="<?php echo $l_Modulo ?>";

    </script>
    
    <script type="text/javascript" src="../js/packinglist_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/packinglist.vista.js"></script>
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>

</head>
<body>    
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
        <div class="row align-items-center h-30">
            <?php include_once "../parametros/barra_busqueda.php" ?>         
        </div>
        <!-- FIN BUSQUEDA -->    
    
        <!-- BOTONES -->
        <div class="row align-items-center h-30">
            <?php include_once "../parametros/barra_botones.php" ?>         
        </div>
        <!-- FIN BOTONES -->
          
        <!-- ENCABEZADOS LISTADO -->
        <div class="row align-item-end h-20 align-items-center" style='border-bottom: #DDE0E1 2px solid;'>			 
            <?php include_once "../parametros/encabezados_listado.php" ?>         
        </div>
        <!-- FIN ENCABEZADOS LISTADO -->

         <!-- REGISTROS -->
         <div id='contenido'> 
         </div>
         <script>
             fn_Listado_Clic("");
         </script>
         <!-- FIN REGISTROS -->  
	</div>
    <!-- FIN -->

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
     	     	   <center><label id='lbl_mensaje_falla'> ESPERE UN MOMENTO  </label></center>
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
    <!-- FIN PROCESAR --->
</body>
</html>