<!DOCTYPE html>
<html>
    <?php
        // ----------------------------------------------------------------------------------
        // inventarioxarticulo_detalles.php
        // ----------------------------------------------------------------------------------
        // Autor. Ing. Antonio Barajas del Castillo
        // ----------------------------------------------------------------------------------
        // Empresa. Softernium SA de CV
        // ----------------------------------------------------------------------------------
        // Descripcion. Modulo para editar datos de un perfil.
        // ----------------------------------------------------------------------------------
        // Fecha Ultima Modificación
        // 25/03/2020
        // ----------------------------------------------------------------------------------
        // V2.0.0
        // ----------------------------------------------------------------------------------
        ob_start();
        session_start();

        $l_Modulo="inventarioxarticulo_detalles"; 
        $l_Accion="Crear";   //Listado/Crear/Editar/Eliminar/Consultar/Imprimir  

        include_once "../parametros/env.php";  
        include_once "../parametros/modulos.php";
    ?>
<head>    
    <title>
        <?php echo $TITULO ?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1, shrink-to-fit=no">
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

    <script type="text/javascript" src="../js/cat_estados_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_estados.vista.js"></script>

    <script type="text/javascript" src="../js/cat_productos_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_productos.vista.js"></script>
 
    <script type="text/javascript" src="../js/inventarioxarticulo_deta_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/inventarioxarticulo_deta.vista.js"></script>

    <script type="text/javascript" src="../js/inventarioxarticulo_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/inventarioxarticulo.vista.js"></script>
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>
    
     <?php
      
      include_once "../clases/clHerramientas_v2011.php"; 
      include_once "../clases/inventarioxarticulo.mysql.class_v2.0.0.php"; 
      include_once "../clases/usuarios.mysql.class_v2.0.0.php"; 
      include_once "../bd/conexion.php";


      $UtileriasDatos = new clHerramientasv2011();
      $l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
      $l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);

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

       // ----------------------------------------------
       // Conexion con la base de Datos
       $l_Regreso=RegresaConexion();
       $CONEXION=json_decode($l_Regreso,true); 
       // ----------------------------------------------

       $l_Folio=0;
       $tbl = new  cltbl_InventarioXArticulo_v2_0_0();
       $tbl->Inicializacion();
       $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
       $tbl->CargarCampos("LEER");
       $Campo_Llave=$tbl->get_CampoLlave();   

       if($l_Accion=="Crear"){
            $l_Folio=$tbl->getSiguienteFolio();
       }

       // ----------------------------------------------
       // Conexion con la base de Datos
       $l_Regreso=RegresaConexion();
       $CONEXION=json_decode($l_Regreso,true); 
       // ----------------------------------------------
 
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
       //echo "NID:" .$NIDUSUARIO;
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
            <div class="modal-content" style='background-color:#009900;width:80%;margin-top:100px;'>
     	     				
	            <!-- CABEZERA -->
     	        <div class="modal-header">
     	     	    <h4 class="modal-title"></h4>
     	     	    <button type="button" class="close" data-dismiss="modal" onclick="Cerrar_Clic()">&times;</button>
     	        </div>

     	        <!-- CUERPO -->
                 <div class="modal-body justify-content-center align-items-center " style='color:#fff;'>
                    <?php 
                        if($l_Accion!="Cancelar"){
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
            <div class="modal-content" style='background-color:#009900;width:80%;margin-top:100px;'>
     	     				
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


 <!-- <form id='frm_Actualizar'> -->
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
         </div>
         <!-- FIN BOTONES -->
 
         <div class="row align-item-end h-20 align-items-center" style='border-bottom: #fff 1px solid;'>			 
                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>                    
                </div>
         </div>

         <input type="hidden" name="<?php echo $Campo_Llave ?>" id="txt_nID" class="form-control" value='<?php echo $l_nID ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>                         
         <input type="hidden" name="nIDUsuario" id="txt_nIDUsuario" class="form-control" value='<?php echo $NIDUSUARIO ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>    

        

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-2">	
                    <?php if($l_Accion=="Crear"){ ?>
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Inventario en Almacen (*)</label> 
                    <?php } else {  ?>
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Inventario en Almacen</label> 
                    <?php } ?>                         
                 </div>
                 <div class="col-md-9">	 
                     <?php 
                         if($l_Accion=="Crear"){
                     ?>                       
                            <select name="nIDIxA" id="cb_nIDIxA" class="form-control-select border border-primary" style='max-width:300px; height: 30px;width:100%;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                                    
                            </select>
                     <?php
                        } else {
                     ?>
                            <input type="text" name="Estado" id="txt_Estado" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDCat_Estados" id="txt_IDCat_Estado" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                     <?php
                        }
                     ?>
                 </div>
              
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-2">	
                    <?php if($l_Accion=="Crear"){ ?>
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Producto</label> 
                    <?php } else {  ?>
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Producto</label> 
                    <?php } ?>                         
                 </div>
                 <div class="col-md-9">	 
                     <?php 
                         if($l_Accion=="Crear"){
                     ?>                       
                            <select name="nIDCat_Producto" id="cb_nIDCat_Producto" class="form-control-select border border-primary" style='max-width:300px;height: 30px;width:100%;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                                    
                            </select>
                     <?php
                        } else {
                     ?>
                            <input type="text" name="Producto" id="txt_Producto" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDCat_Producto" id="txt_IDCat_Producto" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                     <?php
                        }
                     ?>
                 </div>
              
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-2 col-lg-2">	               
                        
                 </div>
                 <div class="col-md-8">	                          
                        <a class="nav-link" href="#" style='margin-left:-30px;'>
                              <button id='bt_Buscar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Realizar_Conteo_Clic()">Realizar Conteo</button>                               
                              <button id='bt_Cancelars' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;visibility:hidden;' onclick="fn_Cancelar_Conteo_Clic()">Cancelar</button>                               
                        </a>      
                        <label id='lbl_Entrada' style='font-size:12px; font-family:"Arial", Gadget, sans-serif;margin-left:-10px;' >  </label>                      
                 </div>
                 <div class="d-xs-block col-md-2">	
                 <input type="hidden" name="nIDEntradaPorOtrosConceptos" id="txt_nIDEntradaPorOtrosConceptos" class="form-control" value='<?php echo $l_nID ?>' style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>
                </div>
         </div>



       


         <div id='id_Estado' class="row" style='margin-bottom:2px; visibility:hidden'>
                <div class="col-md-2">	
                    <?php if($l_Accion=="Crear"){ ?>
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Estado(*)</label> 
                    <?php } else {  ?>
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Estado</label> 
                    <?php } ?>                         
                 </div>
                 <div class="col-md-9">	 
                     <?php 
                         if($l_Accion=="Crear"){
                     ?>                       
                            <select name="nIDCat_Estado" id="cb_nIDCat_Estado" class="form-control-select border border-primary" style='max-width:300px; height: 30px;width:100%;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                                    
                            </select>
                     <?php
                        } else {
                     ?>
                            <input type="text" name="Estado" id="txt_Estado" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDCat_Estados" id="txt_IDCat_Estado" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                     <?php
                        }
                     ?>
                 </div>
              
         </div>

         <div id='id_Codigo' class="row" style='margin-bottom:2px;visibility:hidden'>
                <div class="col-md-2 col-lg-2">	               
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >   </label> 
                 </div>
                 <div class="col-md-8">	   
                      <input type="text" name="Etiqueta" id="txt_Etiqueta" placeholder="Captura de Etiqueta" class="form-control-select border border-primary" style='max-width:300px; height: 30px;width:100%;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' onkeypress="fn_Anexar_Codigo_CLick(event)" > 
                      <a class="nav-link" href="#" style='margin-left:-30px;'>
                              <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Buscar_Codigo_Clic()">Buscar</button>
                        </a>                                         
                 </div>
                 <div class="d-xs-block col-md-2">	
                     
                </div>
         </div>  
        
    </div>    
 
 </form>    
 

 
  <!-- REGISTROS -->
 
 <div class="container" style='visibility:hidden' id='frm_Detalles2'>
    <div id='contenido'> 
        <div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>
            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' >Listado de Conteo </label>
            </div>

        </div>        
    </div>    
 </div>    
 <!-- </form> -->


 <form id='frm_Detalles' style='visibility:hidden'>
  <div class="container" >
    <div id='contenido_productos'>    
        <div class='row align-item-end h-20 align-items-center ' style='border-bottom: #D9DADA 2px solid;cursor:pointer;padding-bottom:10px;'>

         <div class='col-md-2 d-flex justify-content-left align-items-center w-3' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' > Codigo</label>
            </div>
               
            <div class='col-md-3 d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' > Producto</label>
            </div>
   
            <div class='col-md-3 d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' > Unidad de Medida </label>
            </div>
   
            <div class='col-md-2 d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' > Estado</label>
            </div>                    

            <div class='col-md-2 d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                <label style='cursor:pointer;' > Conteo Fisico</label>
            </div>       
         </div>
    </div>
     
 </div>    
 </form>
 
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
        
        fn_Inventario_Clic('',0,ACCION);    
        fn_Cat_Productos_Clic('',0,ACCION); 
        fn_Cat_Estados_Clic('',0,ACCION);         
 </script>	
 
</body>
</html>