<!DOCTYPE html>
<html>
<head>
    <?php   
        // ----------------------------------------------------------------------------------
        // cat_excepciones_cargar.php
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

        $l_Modulo="cat_excepciones"; 
        $l_Accion="Cargar";   //Listado/Crear/Editar/Eliminar/Consultar/Imprimir/Cargar 

        include_once "../parametros/env.php";  
        include_once "../parametros/modulos.php";      
    ?>
	<title>
        <?php echo $TITULO ?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=dev-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

    <script type="text/javascript" src="../lib/jquery-3.3.1.slim.min.js"></script>
    <script type='text/javascript' src="../lib/jquery-1.8.3.min.js"></script>
    <script type='text/javascript' src="../lib/jquery-1.12.2.min.js"></script>

    <script type="text/javascript" src="../lib/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="../lib/popper.min.js"></script>
    <script type="text/javascript" src="../lib/bootstrap.min.js"></script>
 

    <script>
        var CAMPO_ORDENAMIENTO="<?php echo $CAMPO_ORDENAMIENTO ?>";
        var FORMA_ORDENAMIENTO="<?php echo $FORMA_ORDENAMIENTO ?>";
        var ULTIMA_CONSULTA="<?php echo $ULTIMA_CONSULTA ?>";
        var ULTIMA_CONDICION="<?php echo $ULTIMA_CONDICION ?>";
        var NUMERODEREGISTROS="<?php echo $NUMERODEREGISTROS ?>";
        var PAGINA_ACTUAL="<?php echo $PAGINA_ACTUAL ?>";

        var UBICACION_CONTROL="<?php echo $UBICACION_CONTROL ?>";

        var MODULO="<?php echo $l_Modulo ?>";

        var NOMBRE_COMBO="<?php echo $NOMBRE_COMBO ?>";

    </script>
    
    <script type="text/javascript" src="../js/cat_excepciones_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_excepciones.vista.js"></script>
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>
    

</head>
<body>    
 <!-- MENSAJES -->    
 <div class="modal fade" id="modal_espera">
    <center>
     	<div class="modal-dialog">
     	    <div class="modal-content" style='background-color:#CCCCCC;width:50%;margin-left:20px;'>
     	     				
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
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                             <center><label id='lbl_mensaje_exitoso'> GRABACION EXITOSA </label></center>
                     <?php
                        } else {
                     ?>
                             <center><label id='lbl_mensaje_exitoso'> ELIMINACION EXITOSA </label></center>
                     <?php
                        }
                     ?>
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
     	     	   <center><label id='lbl_mensaje_falla'> ERROR </label></center>
     	        </div>

     	        <!-- PIE DE PAGINA -->
     	        <div class="modal-footer">
     	     	    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
     	        </div>
     	     </div>
         </div>     	 
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
        <div class="row align-items-center h-30">
            <?php include_once "../parametros/barra_busqueda.php" ?>         
        </div>
        <!-- FIN BUSQUEDA -->    
    
        <!-- BOTONES -->        
        <div class="row align-items-center h-30">
          <div class="container" >
            <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-8">	    
                <?php if($l_Accion!="Eliminar"){?>                                                                     
                        <form enctype='multipart/form-data' method='POST' class='cl_Formulario_Archivo_1' style='padding-top:10px;margin-left:-12px;'>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                     
                                </div>

                                <div class="custom-file">
                                    <input type="file" id='txt_Archivo_Detalles1' name='txt_Archivo_Detalles1' class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" onchange='fn_Subir_Archivo();'>
                                    <label class="custom-file-label" for="inputGroupFile01">Archivo</label>
                                </div>
                            </div>
                        </form>
                        <input type="hidden" name="Imagen" id="txt_Archivo" class="CampoTexto TamanoCampoTexto7" style='height:35px;width:500px;visibility:visible;' autocomplete="off" value="" readonly  />       
                 <?php } ?>         
                 </div>           
            </div>                  
          </div>
        </div>

        <div class="row align-items-center h-30">
            <?php include_once "../parametros/barra_botones_cargar.php" ?>          
        </div>


  
        <!-- FIN BOTONES -->
          
        <!-- ENCABEZADOS LISTADO -->
        <div class="row align-item-end h-20 align-items-center" style='border-bottom: #DDE0E1 2px solid;'>			 
            <?php include_once "../parametros/encabezados_cargar.php" ?>         
        </div>
        <!-- FIN ENCABEZADOS LISTADO -->

         <!-- REGISTROS -->
         <div id='contenido'> 
         </div>
         <script>
             //fn_Listado_Clic();
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