<!DOCTYPE html>
<html>
    <?php
        // ----------------------------------------------------------------------------------
        // ambiente_clasificaciones_editar.php
        // ----------------------------------------------------------------------------------
        // Autor. Ing. Antonio Barajas del Castillo
        // ----------------------------------------------------------------------------------
        // Empresa. IDEATECH
        // ----------------------------------------------------------------------------------        
        // Fecha Ultima Modificación
        // 13/07/2020
        // ----------------------------------------------------------------------------------
        // V2.0.2
        // ----------------------------------------------------------------------------------

        ob_start();
        session_start();
        
        $l_Modulo="ambiente_clasificaciones"; 
        $l_Accion="Crear";   //Listado/Crear/Editar/Eliminar/Consultar/Imprimir  

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

    <script type="text/javascript" src="../js/ambiente_modulos_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/ambiente_modulos.vista.js"></script>

    <script type="text/javascript" src="../js/ambiente_clasificaciones_deta_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/ambiente_clasificaciones_deta.vista.js"></script>
 
    <script type="text/javascript" src="../js/ambiente_clasificaciones_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/ambiente_clasificaciones.vista.js"></script>
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>

     <?php
      
      include_once "../clases/clHerramientas_v2011.php"; 
      include_once "../clases/ambiente_clasificaciones.mysql.class_v2.0.0.php"; 
      include_once "../bd/conexion.php";

       // Extrae el id
       $l_nID=0;
       $l_Condicion="";

       if(!empty($_GET)){ 
           if (isset($_GET['id'])){
               $l_nID=$_GET['id']; 
           }   

           if (isset($_GET['accion'])){
               $l_Accion=$_GET['accion'];
           }
       }

       // ----------------------------------------------
       // Conexion con la base de Datos
       $l_Regreso=RegresaConexion();
       $CONEXION=json_decode($l_Regreso,true); 
       // ----------------------------------------------

       $l_Folio=0;
       $tbl = new  cltbl_Ambiente_Clasificaciones_v2_0_0();
       $tbl->Inicializacion();
       $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
       $tbl->CargarCampos("LEER");
       $Campo_Llave=$tbl->get_CampoLlave();   

       if($l_Accion=="Crear"){
            $l_Folio=$tbl->getSiguienteFolio();
       }
     
       if($l_nID>0){    
            $l_Condicion=$Campo_Llave . "=" . $l_nID;           
        }
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

        var CONDICION="<?php echo $l_Condicion ?>";
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

    <div class="modal fade" id="modal_exitoso">
    <center>
     	<div class="modal-dialog">
     	    <div class="modal-content" style='background-color:#009900;width:50%;'>
     	     				
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
     </center>  	 
     </div>
      
     <div class="modal fade" id="modal_falla">
     <center>
     	<div class="modal-dialog">
     	    <div class="modal-content" style='background-color:#FF0000;width:50%;'>
     	     				
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
     </center>   	 
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
            <?php include_once "../parametros/barra_botones_crear.php" ?>   
            <?php include_once "../parametros/barra_botones_editar.php" ?>    
            <?php include_once "../parametros/barra_botones_eliminar.php" ?>      
         </div>
         <!-- FIN BOTONES -->
 
         <div class="row align-item-end h-20 align-items-center" style='border-bottom: #fff 1px solid;'>			 
                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>                    
                </div>
         </div>

         <input type="hidden" name="<?php echo $Campo_Llave ?>" id="txt_nID" class="form-control" value='<?php echo $l_nID ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>      
         <input type="hidden" name="Folio" id="txt_Folio" class="form-control" value='<?php echo $l_Folio ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>      


         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	      
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Clasificación(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Clasificación</label> 
                <?php } ?>                                   
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Clasificacion" id="txt_Clasificacion" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>
             
         </div>
        
         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	                          
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Descripción</label> 
                </div>
                <div class="col-md-9">	       	                                     
                        <textarea class="form-control" rows="5" name="Descripcion" id="txt_Descripcion" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none '<?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>   </textarea>        
                </div>               
         </div>
 
         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Activo</label> 
                </div>
                <div class="col-md-9" >	    
                <?php 
                    if($l_Accion!="Eliminar"){
                ?> 
                        <input type="checkbox" name="Activo" id="ch_Activo" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                <?php
                    } else {
                ?>
                        <input type="checkbox" name="Activo" id="ch_Activo" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px;' disabled> 
                <?php        
                    }
                ?>
                </div>
                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-2 col-lg-2">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Modulos Asociados</label> 
                </div>
                <div class="col-md-6" >	       	                                       
                </div>
                <div class="d-none d-sm-block col-md-2">	                   
                </div>
         </div>
        
    </div>      
 </form>    

 <!-- REGISTROS -->
 <form id='frm_Detalles'>
 <div class="container" >
 <div id='contenido'> 
  
 </div>
 </div>
 </form>
 <script> 
        fn_Ambiente_Modulos_Listado_Clic(CONDICION);
 </script>
 <!-- FIN REGISTROS -->  
 
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
                //fn_Ambiente_Modulos_Clic('');                   
        <?php
            } 
        ?>        
 </script>	

 <?php 
    if($l_nID>0){    
        $l_Condicion=$Campo_Llave . "=" . $l_nID;                     
 ?>
         <script>
             fn_Consultar_Clic('<?php echo $l_Condicion ?>');                         
         </script>
 <?php
     }    
?>           
 <!-- FIN PROCESAR --->

 
</body>
</html>