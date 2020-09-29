<!DOCTYPE html>
<html>
    <?php
        // ----------------------------------------------------------------------------------
        // ordendesurtido_editar.php
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

        $l_Modulo="traspasos_recepcion"; 
        $l_Accion="Crear";   //Listado/Crear/Editar/Eliminar/Consultar/Imprimir/Detalles  
        include_once "../parametros/modulos.php";
    ?>
<head>    
    <title>
        <?php echo $l_Titulo ?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=dev-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

    <script type="text/javascript" src="../lib/jquery-3.3.1.slim.min.js"></script>
    <script type='text/javascript' src="../lib/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="../lib/popper.min.js"></script>
    <script type="text/javascript" src="../lib/bootstrap.min.js"></script>

    <script>
        var CAMPO_ORDENAMIENTO="<?php echo $CAMPO_ORDENAMIENTO ?>";
        var FORMA_ORDENAMIENTO="<?php echo $FORMA_ORDENAMIENTOO ?>";
        var ULTIMA_CONSULTA="<?php echo $ULTIMA_CONSULTA ?>";

        var UBICACION_CONTROL="<?php echo $UBICACION_CONTROL ?>";

        var MODULO="<?php echo $l_Modulo ?>";
      
    </script>
    
    <script type="text/javascript" src="../js/usuarios_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/usuarios.vista.js"></script>

    <script type="text/javascript" src="../js/cat_almacen_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_almacen.vista.js"></script>

    <script type="text/javascript" src="../js/cat_motivostraspaso_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_motivostraspaso.vista.js"></script>

    <script type="text/javascript" src="../js/ordendesurtido_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/ordendesurtido.vista.js"></script>
  
    <script type="text/javascript" src="../js/traspasos_recepcion_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/traspasos_recepcion.vista.js"></script>
 
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>
    
     <?php
      
      include_once "../clases/clHerramientas_v2011.php"; 
      include_once "../clases/traspasos.mysql.class_v2.0.0.php";        
      include_once "../clases/usuarios.mysql.class_v2.0.0.php"; 
      include_once "../bd/conexion.php";


      $UtileriasDatos = new clHerramientasv2011();
      $l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
      $l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);

       // Extrae el id
       $l_nID=0;
       $l_nIDContenedor=0;
       $l_Folio=0;

       if(!empty($_GET)){ 
           if (isset($_GET['id'])){
               $l_nID=$_GET['id']; 
           }   

           if (isset($_GET['folio'])){
                $l_Folio=$_GET['folio']; 
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

       $l_Estatus="";
       $l_Folio=0;
       $l_Condicion="";
       $l_nIDOrdenDeSurtido=0;
       $l_OrdenDeSurtido_Folio=0;
       $l_OrdenDeSurtido_Fecha="";
       $l_nIDCat_Almacen_Origen=0;
       $l_Almacen_Origen="";
 
       // Extrae la información de la Orden de Surtido
       $tbl = new  cltbl_Traspasos_v2_0_0();
       $tbl->Inicializacion();
       $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
       $tbl->CargarCampos("LEER");
       $Campo_Llave=$tbl->get_CampoLlave();   
       if($l_nID>0){
            $l_Condicion=$Campo_Llave . "=" . $l_nID;
            $tbl->Leer($l_Condicion);

            if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
                $registros=$tbl->dtBase();

                $l_Estatus=$registros[0]["Estatus"];
                $l_nIDOrdenDeSurtido=$registros[0]["nIDOrdenDeSurtido"];
                $l_OrdenDeSurtido_Folio=$registros[0]["OrdenDeSurtido_Folio"];
                $l_OrdenDeSurtido_Fecha=$registros[0]["OrdenDeSurtido_Fecha"];

                $l_nIDCat_Almacen_Origen=$registros[0]["nIDCat_Almacen_Origen"];
                $l_Almacen_Origen=$registros[0]["Almacen_Origen"];

                //echo "nid:" . $l_nIDCat_Almacen_Origen;
            }
       }
       

       if($l_Accion=="Crear"){
            $l_Folio=$tbl->getSiguienteFolio();
            $l_Estatus="NO PROCESADO";

       }

 
       // ---------------------------------------------
       // AREA DE SEGURIDAD
       $NIDUSUARIO=4;

       // ---------------------------------------------
     ?>
</head>

<body>
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

         <?php               
                include_once "../parametros/barra_navegacion.php" ;                
         ?>       

        </div>       
         <!-- FIN BARRA DE NAVEGACION --> 
  
         <!-- BOTONES -->
         <div class="row align-item-end h-20 align-items-center" style='border-bottom: #DDE0E1 2px solid;'>			 
            <?php include_once "../parametros/barra_botones_crear.php" ?>         
            <?php include_once "../parametros/barra_botones_detalles.php" ?>         
         </div>
         <!-- FIN BOTONES -->
 
         <div class="row align-item-end h-20 align-items-center" style='border-bottom: #fff 1px solid;'>			 
                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>                    
                </div>
         </div>

         <input type="hidden" name="nIDTraspaso" id="txt_nIDTraspaso" class="form-control" value='<?php echo $l_nID ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>                                   
         <input type="hidden" name="nIDUsuario" id="txt_nIDUsuario" class="form-control" value='<?php echo $NIDUSUARIO ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '> 
         <input type="hidden" name="nIDOrdenDeSurtido" id="txt_nIDOrdenDeSurtido" class="form-control" value='<?php echo $l_nIDOrdenDeSurtido ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>              
          
         <?php if($l_Accion!='Crear') { ?>
          <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-2 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Folio</label> 
            </div>
            <div class="col-md-8">	      
                <?php if($l_Accion!="Crear"){ ?>
                    <input type="text" name="Folio" id="txt_Folio" class="form-control" value='' style='height: 30px;width:100px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' readonly>                
                <?php } ?>                                        
            </div>
            <div class="d-xs-block col-md-2">	
                
            </div>
          </div>
         <?php } ?>


         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-2 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Fecha</label> 
            </div>
            <div class="col-md-8">	      
                <?php if($l_Accion=="Crear"){ ?>
                    <input type="text" name="Fecha" id="txt_Fecha" class="form-control" value='<?php echo $l_FechaLocal ?>' style='height: 30px;width:150px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly>     
                <?php } else {  ?>
                    <input type="text" name="Fecha" id="txt_Fecha" class="form-control" style='height: 30px;width:150px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' readonly>     
                <?php } ?>                                        
            </div>
            <div class="d-xs-block col-md-2">	
                
            </div>
         </div>  


         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-2 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Folio orden de Surtido </label> 
            </div>
            <div class="col-md-8">	      
                <?php if($l_Accion=="Crear"){ ?>
                    <input type="text" name="OrdenDeSurtido_Folio" id="txt_OrdenDeSurtido_Folio" class="form-control" value='<?php echo $l_OrdenDeSurtido_Folio ?>' style='height: 30px;width:150px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly>     
                <?php } else {  ?>
                    <input type="text" name="OrdenDeSurtido_Folio" id="txt_OrdenDeSurtido_Folio" class="form-control" style='height: 30px;width:150px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' readonly>     
                <?php } ?>                                        
            </div>
            <div class="d-xs-block col-md-2">	
                
            </div>
         </div>  


         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-2 col-lg-2">	               
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Almacen Origen</label> 
                 </div>
                 <div class="col-md-8">	 
                        <input type="text" name="Almacen_Origen" id="txt_Almacen_Origen" value='<?php echo $l_Almacen_Origen ?>' class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' readonly >
                        <input type="hidden" name="nIDCat_Almacen_Origen" id="txt_IDCat_Almacen_Origen" value='<?php echo $l_nIDCat_Almacen_Origen ?>' class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                 </div>
                 <div class="d-xs-block col-md-2">	
                    
                </div>
         </div>            

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-2 col-lg-2">	               
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Almacen Destino</label> 
                 </div>
                 <div class="col-md-8">	 
                     <?php 
                        if($l_Accion!="Eliminar" && $l_Accion!="Ver" && $l_Accion!="Imprimir"){
                     ?>                       
                            <select name="nIDCat_Almacen_Destino" id="cb_nIDCat_Almacen_Destino" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                                    
                            </select>
                     <?php
                        } else {
                     ?>
                            <input type="text" name="Almacen_Destino" id="txt_Almacen_Destino" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDCat_Almacen_Destino" id="txt_IDCat_Almacen_Destino" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                     <?php
                        }
                     ?>
                 </div>
                 <div class="d-xs-block col-md-2">	
                             
                </div>
         </div>     

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-2 col-lg-2">	                          
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Observaciones</label> 
                </div>
                <div class="col-md-8">	       	      
                <?php 
                        if($l_Accion!="Eliminar" && $l_Accion!="Ver" && $l_Accion!="Imprimir"){
                     ?>                                         
                            <textarea class="form-control" rows="5" name="Comentarios" id="txt_Comentarios" style='height: 100px;width:450px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; resize: none; '  >   </textarea>        
                     <?php
                        } else {
                     ?>
                            <textarea class="form-control" rows="5" name="Comentarios" id="txt_Comentarios" style='height: 100px;width:450px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; resize: none; ' readonly >   </textarea>        


                     <?php
                        }
                     ?>

                </div>
                <div class="d-none d-sm-block col-md-2">	                   
                </div>
         </div>
     
          
         <?php if($l_Accion=="Eliminar" || $l_Accion=="Ver" || $l_Accion=="Imprimir" ){ 
         ?>
            <div class="row" style='margin-bottom:2px;'>
                <div class="col-2">	                        
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Tipo</label> 
                </div>
                <div class="col-md-8">       
                <input type="text" name="Tipo" id="txt_Tipo" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' readonly >

                </div>
            </div>


            <div class="row" style='margin-bottom:2px;'>
                <div class="col-2">	                        
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Estatus</label> 
                </div>
                <div class="col-md-8">       
                <input type="text" name="Estatus" id="txt_Estatus" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' readonly >

                </div>
            </div>

            <div class="row" style='margin-bottom:2px;'>
                <div class="col-2">	                        
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Usuario</label> 
                </div>
                <div class="col-md-8">       
                <input type="text" name="Nombre" id="txt_Nombre" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' readonly >

                </div>
            </div>
         <?php } ?> 

         
         <br>
         <br>


       
    </div>    
 
 </form>    
 <!-- FIN -->

 <!-- REGISTROS -->
 <?php if($l_Accion=="Eliminar" || $l_Accion=="Ver"){ ?>
 <form id='frm_Detalles2'>
 <div class="container" >
    <div id='contenido'> 
        <div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>
            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' >Listado de Productos </label>
            </div>

        </div>        
    </div>    
 </div>    
 <!-- </form> -->


 <form id='frm_Detalles'>
  <div class="container" >
    <div id='contenido_productos'>    
         <div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;padding-bottom:10px;'>
            <div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' > Codigo</label>
            </div>
               
            <div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' > Producto</label>
            </div>
   
            <div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' > Unidad de Medida </label>
            </div>
   
            <div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' > Cantidad</label>
            </div>        

            <div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' > Estatus</label>
            </div>                   
         </div>
    </div>
     
 </div>    
 </form>
 <?php } ?>
 
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
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                             <center><label id='lbl_mensaje_exitoso'> GRABACION EXITOSA </label></center>
                     <?php
                        } else {
                     ?>
                             <center><label id='lbl_mensaje_exitoso'> CANCELACION EXITOSA </label></center>
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
            if($l_Accion!="Eliminar" && $l_Accion!="Ver"){
        ?>
                     fn_Cat_Almacen_Origen_Clic('');  
                     fn_Cat_Almacen_Destino_Clic('');          
                     fn_Cat_MotivosTraspaso_Clic('');     
                     fn_OrdenDeSurtido_Clic('');                         
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
            
             fn_Consultar_Detalles_OrdenDeSurtido_Clic('<?php echo  $l_nIDOrdenDeSurtido ?>');
         </script>
 <?php
     } else {
 ?>
        
 <?php        
     }   
?>           
 <!-- FIN PROCESAR --->

</body>
</html>