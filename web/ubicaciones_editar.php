<!DOCTYPE html>
<html>
    <?php
        // ----------------------------------------------------------------------------------
        // cat_almacen_editar.php
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

        $l_Modulo="ubicaciones"; 
        $l_Accion="Editar";   //Listado/Crear/Editar/Eliminar/Consultar/Imprimir  

        include_once "../parametros/env.php";          
        include_once "../parametros/modulos.php";
    ?>
<head>    
    <title>
    <?php echo $TITULO . $VERSION ?>
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

    <script type="text/javascript" src="../js/cat_almacen_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_almacen.vista.js"></script>
  
    <script type="text/javascript" src="../js/ubicaciones_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/ubicaciones.vista.js"></script>
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>
    
     <?php
      
      include_once "../clases/clHerramientas_v2011.php"; 
      include_once "../clases/ubicaciones.mysql.class_v2.0.0.php"; 
      include_once "../bd/conexion.php"; 

      // ----------------------------------------------
      // Conexion con la base de Datos
      $l_Regreso=RegresaConexion();
      $CONEXION=json_decode($l_Regreso,true); 
      // ----------------------------------------------

     ?>

    <script>
        var CAMPO_ORDENAMIENTO="<?php echo $CAMPO_ORDENAMIENTO ?>";
        var FORMA_ORDENAMIENTO="<?php echo $FORMA_ORDENAMIENTO ?>";
        var ULTIMA_CONSULTA="<?php echo $ULTIMA_CONSULTA ?>";
        var ULTIMA_CONDICION="<?php echo $ULTIMA_CONDICION ?>";
        var NUMERODEREGISTROS="<?php echo $NUMERODEREGISTROS ?>";
        var PAGINA_ACTUAL="<?php echo $PAGINA_ACTUAL ?>";

        var UBICACION_CONTROL="<?php echo $UBICACION_CONTROL ?>";

        var MODULO="<?php echo $l_Modulo ?>"; 

        var ACCION="<?php echo $l_Accion ?>";
     </script>

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
     	     	    <button type="button" class="close" data-dismiss="modal" onclick="Ocultar_Espera()">&times;</button>
     	        </div>

     	        <!-- CUERPO -->
     	        <div class="modal-body justify-content-center align-items-center " style='color:#fff;'>
     	     	   <center><label id='lbl_mensaje_falla'> ERROR </label></center>
     	        </div>

     	        <!-- PIE DE PAGINA -->
     	        <div class="modal-footer">
     	     	    
     	        </div>
     	     </div>
         </div>     	 
     </div>
<!-- FIN MENSAJES -->           

 <form id='frm_Actualizar'>
     <div class="container" >
		<!-- ENCABEZADO -->         
		<div class="row align-item-end h-50" style='background-color:#DFE1E1;'>
			<?php include_once "../parametros/encabezado.php" ?>
        </div>          
        <!-- FIN ENCABEZADO -->         
 
        <!-- MENU -->         
    	<div class="row align-item-end bg-light h-30">
            <?php include_once "../parametros/barra_menu.php" ?>   
        </div>
         <!-- BARRA DE NAVEGACION -->         
		<div class="row align-item-end h-20 bg-dark">			 
            <?php include_once "../parametros/barra_navegacion.php" ?>                     
        </div>
         <!-- FIN BARRA DE NAVEGACION --> 
  
         <!-- BOTONES -->
         <div class="row align-item-end h-20 align-items-center" style='border-bottom: #DDE0E1 2px solid;'>			 
                 <?php include_once "../parametros/barra_botones_editar.php" ?>    
         </div>
         <!-- FIN BOTONES -->
 
         <div class="row align-item-end h-20 align-items-center" style='border-bottom: #fff 1px solid;'>			 
                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>                    
                </div>
         </div>

         <input type="hidden" name="<?php echo $Campo_Llave ?>" id="txt_nID" class="form-control" value='<?php echo $l_nID ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>            


         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-4">	   

                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;'  Almacen </label> 

                <div class="row" style='margin-bottom:2px;'>
                    <div class="col-md-6">	   
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;' >Almacen </label> 
                    </div>                    
                    <div class="col-md-6">                         
                         
                    </div>
                 </div>

                 <div class="row" style='margin-bottom:2px;'>
                    <!-- <form method="" class="form-inline"> -->
                        <div class="col-6">	   
                            <a class="nav-link" href="#" style='margin-left:-20px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Anterior_Clic()">Anterior</button></a>      
                         </div>                    

                        <div class="col-6">                         
                            <a class="nav-link" href="#" style='margin-left:10px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Siguiente_Clic()">Siguiente</button></a>     
                        </div>
                    <!-- </form> -->
                 </div>


                 <div class="row" style='margin-bottom:2px;'>
                    <div class="col-12">	   
                    <select name="nIDCat_Almacen" id="cb_nIDCat_Almacen" class="form-control-select border border-primary" style='max-width:300px; height: 30px;width:100%;font-size:10px; font-family:Arial, Gadget, sans-serif; ' onchange="fn_Cargar_Ubicaciones_Disponibles();">
                             <option value="0" selected >Ninguno</option>                                                                               
                         </select> </label> 
                    </div>                                         
                 </div>


                   <!-- REGISTROS -->
                   <br>
                   <form id='frm_UbicacionesDisponibles'>
                       <div class="container" >
                           <div id='contenido' > 
                                <div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;width:100%;'>
                                   <div class="col-12 d-flex justify-content-left align-items-center" style='width:320px;text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label style='cursor:pointer;' >Ubicaciones Disponibles</label>
                                   </div>
                                </div>        
                            </div>    
                        </div>    
                    </form>

                    <form id='frm_UbicacionesDisponibles_Detalles' style='margin-right:10px;padding-right:10px;'>
                        <div class="container" >
                            <div id='contenido_ubicaciones' style='max-width:350px;'>    
                            </div>                             
                        </div>    
                    </form>
                    <!-- FIN REGISTROS -->  
            </div>


            <!-- Ubicaciones por Producto -->
            <div class="col-md-4">	       	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Ubicaciones por Productos </label>        

                 <div class="row" style='margin-bottom:2px;'>
                    <!-- <form method="" class="form-inline">      -->
                        <div class="col-6">	   
                            <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Cancelar_Clic()">Cancelar</button></a>      
                         </div>                    

                        <div class="col-6">                         
                            <a class="nav-link" href="#" style='margin-left:5px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Guardar_Clic()">Guardar</button></a>     
                        </div>
                    <!-- </form>     -->
                 </div>


                 <div class="row" style='margin-bottom:2px;'>
                    <div class="col-md-12">	   
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Producto</label> 
                        <form id='frm_Consultar' class="form-inline"> 
                            <input id='txt_Codigo' name='Codigo' type="text" placeholder="Codigo QR" class="form-control mr-sm-2 border border-primary" style='height: 30px;width:100%;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-15px;  width:80%'>
                            <a class="nav-link" href="#" style='margin-left:-30px;'>
                                <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Agregar_Clic()">Agregar</button>
                            </a>                         
                        </form>
                    </div>                    
                     
                 </div>

                  <!-- REGISTROS -->                 
                   <form id='frm_Posiciones' style='margin-left:-20px;'>
                       <div class="container" >
                           <div id='contenido'> 
                                <div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>
                                   <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label style='cursor:pointer;' >Posicion</label>
                                   </div>
                                </div>        
                            </div>    
                        </div>    
                    </form>

                    <form id='frm_Posiciones_Detalles'>
                        <div class="container" >
                            <div id='contenido_posiciones'>    
                            </div>                             
                        </div>    
                    </form>
                    <!-- FIN REGISTROS -->  
            </div>

            <!-- Almacen -->
            <div class="col-md-4">	       	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Contenido por Ubicacion </label>   

                 <div class="row" style='margin-bottom:2px;'>
                    <div class="col-md-12">	   
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Producto</label> 
                        <form id='frm_Consultar' class="form-inline"> 
                            <input id='txt_Buscar' name='Buscar' type="text" placeholder="Buscar" class="form-control mr-sm-2 border border-primary" style='height: 30px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-15px;width:80% '>
                            <a class="nav-link" href="#" style='margin-left:-30px;'>
                                <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Buscar_Clic()">Buscar</button>
                            </a>                         
                        </form>
                    </div>                                         
                 </div>

                  <!-- REGISTROS -->
                   
                   <form id='frm_UbicacionesDisponibles' style='margin-left:-20px;'>
                       <div class="container" >
                           <div id='contenido'> 
                                <div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>
                                   <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label style='cursor:pointer;' >Ubicacion del producto</label>
                                   </div>
                                </div>        
                            </div>    
                        </div>    
                    </form>

                    <form id='frm_UbicacionProducto_Detalles'>
                        <div class="container" >
                            <div id='contenido_productos'>    
                            </div>                             
                        </div>    
                    </form>
                    <!-- FIN REGISTROS -->  





            </div>        
         </div>

         
         
    </div>      
 </form>     
 <!-- FIN -->
 
  <!-- MENSAJES -->    
  <div class="modal fade" id="modal_espera">
    <center>
     	<div class="modal-dialog">
     	    <div class="modal-content" style='background-color:#CCCCCC;width:40%;margin-left:20px;'>
     	     				
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
     	     	    <button type="button" class="close" data-dismiss="modal" >&times;</button>
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
        
        <?php 
            if($l_Accion!="Eliminar"){
        ?>
                fn_Cat_Almacen_Clic('');                  
        <?php
            } 
        ?>        
 </script>	
 
 <!-- FIN PROCESAR --->

 
</body>
</html>