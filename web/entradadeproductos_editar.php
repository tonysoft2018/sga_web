<!DOCTYPE html>
<html>
    <?php
        // ----------------------------------------------------------------------------------
        // entradadeproductos_editar.php
        // ----------------------------------------------------------------------------------
        // Autor. Ing. Antonio Barajas del Castillo
        // ----------------------------------------------------------------------------------
        // Empresa. IDEATECH         
        // ----------------------------------------------------------------------------------
        // Fecha Ultima Modificación
        // 22/07/2020
        // ----------------------------------------------------------------------------------
        // V2.0.3
        // ----------------------------------------------------------------------------------

        ob_start();
        session_start();
    
        $l_Modulo="entradadeproductos"; 
        $l_Accion="Crear";   //Listado/Crear/Editar/Eliminar/Consultar/Imprimir/Detalles  

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
    
    <script type="text/javascript" src="../js/usuarios_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/usuarios.vista.js"></script>

    <script type="text/javascript" src="../js/cat_almacen_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_almacen.vista.js"></script>

    <script type="text/javascript" src="../js/cat_proveedores_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_proveedores.vista.js"></script>

    <script type="text/javascript" src="../js/packinglist_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/packinglist.vista.js"></script>

    <script type="text/javascript" src="../js/contenedores_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/contenedores.vista.js"></script>

    <script type="text/javascript" src="../js/entradadeproductos_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/entradadeproductos.vista.js"></script>
 
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>
    
     <?php
      
      include_once "../clases/clHerramientas_v2011.php"; 
      include_once "../clases/contenedores.mysql.class_v2.0.0.php"; 
      include_once "../clases/contenedores_deta.mysql.class_v2.0.0.php"; 
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
          session_destroy();
          header("Location: ../index.php");
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

        var NIDPACKINGLIST="<?php echo $l_nID ?>";
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
            <div class="modal-content" style='background-color:#009900;width:50%'>
     	     				
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
            <div class="modal-content" style='background-color:#FF0000;width:50%'>
     	     				
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
        <div class="row align-item-end h-20 bg-dark">			 
            <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                <label style='margin-top:10px; color:#fff;'>   PackingList. Código de Contenedores, Entrada de Productos  </label>
            </div>
        </div>

        <div class="row align-item-end h-20 bg-dark">			 
            <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                <label style='margin-top:10px; color:#fff;'>   Entrada de Productos </label>
            </div>
        </div>
         <!-- FIN BARRA DE NAVEGACION --> 
  
         <!-- BOTONES -->
         <div class="row align-item-end h-20 align-items-center" style='border-bottom: #DDE0E1 2px solid;'>			 
            <?php include_once "../parametros/barra_botones_detalles.php" ?>         
         </div>
         <!-- FIN BOTONES -->
 
         <div class="row align-item-end h-20 align-items-center" style='border-bottom: #fff 1px solid;'>			 
                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>                    
                </div>
         </div>

         <input type="hidden" name="nIDPackingList" id="txt_nIDPackingList" class="form-control" value='<?php echo $l_nID ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>                                   
         <input type="hidden" name="nIDUsuario" id="txt_nIDUsuario" class="form-control" value='<?php echo $NIDUSUARIO ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>                         
         <input type="hidden" name="nIDCat_Proveedor" id="txt_nIDCat_Proveedor" class="form-control" value='<?php echo $NIDUSUARIO ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>  
         

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Folio</label> 
            </div>
            <div class="col-md-9">	                  
                 <input type="text" name="Folio" id="txt_Folio" class="form-control border border-primary" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly>                  
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Fecha</label> 
            </div>
            <div class="col-md-9">	                      
                <input type="text" name="Fecha" id="txt_Fecha" class="form-control border border-primary" style='height: 30px;width:150px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly>                                              
            </div>            
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Proveedor</label> 
            </div>
            <div class="col-md-9">	                      
                <input type="text" name="Proveedor" id="txt_Proveedor" class="form-control border border-primary" style='max-width:350px; height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly>                                              
            </div>            
         </div>


         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >NoFactura</label> 
            </div>
            <div class="col-md-9">	                      
                <input type="text" name="NoFactura" id="txt_NoFactura" class="form-control border border-primary" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly>                                              
            </div>            
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Almacen </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="nIDCat_Almacen" id="cb_nIDCat_Almacen" class="form-control-select border border-primary" style='max-width:350px; height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                               
                            </select>
                     <?php
                        }  
                     ?>                     
                 </div>                 
         </div>

        
         <div class="row" style='margin-bottom:2px;'>
                <div class="col-3">	                        
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Observaciones</label> 
                </div>
                <div class="col-md-9">                                                 
                        <textarea class="form-control border border-primary" rows="5" name="Comentarios" id="txt_Comentarios" style='max-width:350px; height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none; '<?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> ></textarea>        
                </div>
         </div>

         <br>

       
 
    </div>    
 
 </form>    

 
  <!-- REGISTROS -->
 <form id='frm_Detalles2'>
 <div class="container" >
    <div id='contenido'> 
        <div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;width:110%'>
            <div class="col-md-12 d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' >Listado de Productos </label>
            </div>

        </div>        
    </div>    
 </div>    
 </form>

 <!-- <form id='frm_Detalles3'> -->
 <div class="container" >
    <div id='contenido'> 
        <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-2">	               
                     <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Codigo iZeta - Maestro </label> 
                 </div>
                 <div class="col-md-4">	                 
                     <input type="text" name="Codigo_IZeta" id="txt_Codigo_IZeta" class="form-control border border-primary" placeholder="Codigo QR/Codigo IZeta" style='height: 30px;width:100%;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' onkeypress="fn_Buscar_Codigo_CLick(event)" >
                 </div>
                 <div class="col-md-2">	               
                 <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Descripcion </label> 
                 </div>
                 <div class="col-md-4">	                 
                 <textarea class="form-control border border-primary" rows="5" name="Descripcion" id="txt_Descripcion" style='height: 50px;width:350px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none ' readonly >  </textarea>
                 </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-2">	                                                             
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Codigo iZeta - Serie </label>              
                 </div>
                 <div class="col-md-4">	                                                                   
                    <input type="text" name="Serie" id="txt_Serie" class="form-control border border-primary" placeholder="Codigo Serie" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' onkeypress="fn_Buscar_Codigo_CLick(event)" >                     
                 </div>
                 <div class="col-md-2">	               
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Pedimento </label>                
                 </div>
                 <div class="col-md-3">	                 
                    <input type="text" name="Pedimento" id="txt_Pedimento" class="form-control border border-primary" style='height: 30px;width:350px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' >                                                
                 </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-2">	    
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Cantidad </label> 
                 </div>
                 <div class="col-md-4">	                                      
                    <input type="hidden" name="Codigo_SAP" id="txt_Codigo_SAP" class="form-control" placeholder="Codigo SAP" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >                                      
                    <input type="text" name="Cantidad" id="txt_Cantidad" class="form-control border border-primary" placeholder="0" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;text-align:right; ' >                                  
                 </div>
                 <div class="col-md-2">	                                      
                 </div>
                 <div class="col-md-3">	 
                 <a class="nav-link" style='margin-left:-30px;'><button id='bt_Anexar' type="button" class="btn btn-primary" style='width:350px;font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_EntradaDeProductos_Agregar()">Agregar</button></a>                
                 </div>
         </div>



         
    </div>    
 </div>    
 <!-- </form> -->

 <form id='frm_Detalles'>
  <div class="container" >
    <div id='contenido_productos'>        
         <div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;padding-bottom:10px;'>
         
        </div>
    </div>    
 </div>    
 </form>
 <br>
 <br>
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
            if($l_Accion!="Eliminar" && $l_Accion!="Ver"){
        ?>
                     fn_Cat_Almacen_Clic('');                                            
        <?php
            } 
        ?>    
        fn_Consultar_PackingList_Clic("nIDPackingList=" + NIDPACKINGLIST);      
        fn_Consultar_Contenedor_Clic("nIDPackingList=" + NIDPACKINGLIST);        
 </script>        
</body>
</html>