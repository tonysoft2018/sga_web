<!DOCTYPE html>
<html>
    <?php
        // ----------------------------------------------------------------------------------
        // usuarios_editar.php
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
        
        $l_Modulo="usuarios"; 
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

    <script type="text/javascript" src="../js/perfiles_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/perfiles.vista.js"></script>
 
    <script type="text/javascript" src="../js/usuarios_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/usuarios.vista.js"></script>
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>
    
     <?php
      
      include_once "../clases/clHerramientas_v2011.php"; 
      include_once "../clases/usuarios.mysql.class_v2.0.0.php"; 
      include_once "../bd/conexion.php";

       // ----------------------------------------------
      // Conexion con la base de Datos
      $l_Regreso=RegresaConexion();
      $CONEXION=json_decode($l_Regreso,true); 
      // ----------------------------------------------


       // Extrae el id
       $l_nID=0;

       if(!empty($_GET)){ 
           if (isset($_GET['id'])){
               $l_nID=$_GET['id']; 
           }   

           if (isset($_GET['accion'])){
               $l_Accion=$_GET['accion'];
           }
       }

       $tbl = new  cltbl_Usuarios_v2_0_0();
       $tbl->Inicializacion();
       $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
       $tbl->CargarCampos("LEER");
       $Campo_Llave=$tbl->get_CampoLlave();   
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

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                                         
                <?php if($l_Accion!="Eliminar"){ ?>                    
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Usuario(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Usuario</label> 
                <?php } ?>
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Usuario" id="txt_Usuario" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>            
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	       
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Password(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Password</label> 
                <?php } ?>                
            </div>
            <div class="col-md-9">	       	                            
                 <input type="password" name="Password" id="txt_Password" class="form-control" style='height: 30px;width:150px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Clave</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Clave" id="txt_Clave" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                                         
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Nombre(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Nombre</label> 
                <?php } ?>
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Nombre" id="txt_Nombre" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>
        
         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	                          
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Direccion</label> 
                </div>
                <div class="col-md-9">	       	                                     
                        <textarea class="form-control" rows="5" name="Direccion" id="txt_Direccion" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none '<?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>   </textarea>        
                </div>                
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Telefono</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Telefono" id="txt_Telefono" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>           
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Celular</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Celular" id="txt_Celular" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>            
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Email</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Email" id="txt_Email" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Activo</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Activo" id="ch_Activo" class="" value="NO" style='height: 20px;width:20px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; padding-top:30px; margin-left:-10px;' > 
                </div>                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >App</label> 
                </div>
                <div class="col-md-2" >	       	                   
                    <input type="checkbox" name="App" id="ch_App" class="" value="NO" style='height: 20px;width:20px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; padding-top:30px; margin-left:-10px;' > 
                </div>      
                           
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Web</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Web" id="ch_Web" class="" value="NO" style='height: 20px;width:20px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; padding-top:30px; margin-left:-10px;' > 
                </div>                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                                                  
                        <?php if($l_Accion!="Eliminar"){ ?>
                            <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Perfil(*)</label> 
                        <?php } else {  ?>
                            <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Perfil</label> 
                        <?php } ?>
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="nIDPerfil" id="cb_nIDPerfil" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                               
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Perfil" id="txt_Perfil" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDPerfil" id="txt_nIDPerfil" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >            
                    <?php
                        }
                     ?>                     
                 </div>                  
         </div>


        <input type="hidden" name="Imagen" id="txt_Imagen" class="CampoTexto TamanoCampoTexto7" style='height:35px;width:500px;visibility:visible;' autocomplete="off" value="" readonly  onchange="fn_Presentar_Adjunto_Imagen()"/>       
                         
    </div>      
 </form>    
 
 <div class="container" >
    <div class="row" style='margin-bottom:2px;'>
         <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Imagen</label> 
         </div>
         <div class="col-md-9">	    
            <?php if($l_Accion!="Eliminar"){?>                                                                     
            <form enctype='multipart/form-data' method='POST' class='cl_Formulario_Archivo_1'>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">Cargar</span>
                    </div>

                    <div class="custom-file">
                        <input type="file" id='txt_Archivo_Detalles1' name='txt_Archivo_Detalles1' class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" onchange='fn_Cargar_Adjunto_Imagen();'>
                        <label class="custom-file-label" for="inputGroupFile01">Archivo</label>
                    </div>
                </div>
             </form>
             <?php } ?>         
             
         </div>
 
    </div>

    <div class="row" style='margin-bottom:2px;'>
         <div class="col-md-3">	                        
                 
         </div>
         <div class="col-md-9">	       	                                                                      
            <img id='img_imagen' src="" class="img-fluid" style="margin-left:2px;">
         </div> 
    </div>
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
        
        <?php 
            if($l_Accion!="Eliminar"){
        ?>
                fn_Perfiles_Clic('',0,ACCION );                
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