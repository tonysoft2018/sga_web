<!DOCTYPE html>
<html>
    <?php
        // ----------------------------------------------------------------------------------
        // cat_productos_editar.php
        // ----------------------------------------------------------------------------------
        // Autor. Ing. Antonio Barajas del Castillo
        // ----------------------------------------------------------------------------------
        // Empresa. IDEATECH
        // ----------------------------------------------------------------------------------
        // Descripcion. Modulo para editar datos de un perfil.
        // ----------------------------------------------------------------------------------
        // Fecha Ultima Modificación
        // 19/08/2020
        // ----------------------------------------------------------------------------------
        // V2.0.2
        // ----------------------------------------------------------------------------------

        ob_start();
        session_start();

        $l_Modulo="cat_productos"; 
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
 

    <script type="text/javascript" src="../js/cat_tipos_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_tipos.vista.js"></script>

    <script type="text/javascript" src="../js/cat_subtipos_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_subtipos.vista.js"></script>

    <script type="text/javascript" src="../js/cat_familias_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_familias.vista.js"></script>

    <script type="text/javascript" src="../js/cat_presentaciones_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_presentaciones.vista.js"></script>
 
    <script type="text/javascript" src="../js/cat_excepciones_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_excepciones.vista.js"></script>
 
    <script type="text/javascript" src="../js/cat_unidadesdemedida_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_unidadesdemedida.vista.js"></script>
 
    <script type="text/javascript" src="../js/cat_proveedores_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_proveedores.vista.js"></script>

    <script type="text/javascript" src="../js/cat_productos_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_productos.vista.js"></script>
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>
  
     <?php
      
      include_once "../clases/clHerramientas_v2011.php"; 
      include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
      include_once "../bd/conexion.php";

      // ----------------------------------------------
      // Conexion con la base de Datos
      $l_Regreso=RegresaConexion();
      $CONEXION=json_decode($l_Regreso,true); 
      // ----------------------------------------------

       // Extrae el id
       $l_nID=0;
       $l_IdProducto=rand(1, 100000);

       if(!empty($_GET)){ 
           if (isset($_GET['id'])){
               $l_nID=$_GET['id']; 
           }   

           if (isset($_GET['accion'])){
               $l_Accion=$_GET['accion'];
           }
       }

       $tbl = new  cltbl_Cat_Productos_v2_0_0();
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
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >ID Producto(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >ID Producto</label> 
                <?php } ?>                  
            </div>
            <div class="col-md-9">	      
            <?php if($l_Accion=="Eliminar" || $l_Accion=="Editar"){ ?> 	                        
                 <input type="text" name="IDProducto1" id="txt_IDProducto" class="form-control" value='<?php echo $l_nID ?>' style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >                                    
            <?php
                } else {
            ?>
                <input type="text" name="IDProducto" id="txt_IDProducto" class="form-control" value='Por Asignar' style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                 
            <?php
                }
            ?>
            </div>             
         </div>



         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                         
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Código SAP </label> 
            </div>
            <div class="col-md-9">	       	                        
                 <input type="text" name="Codigo_SAP" id="txt_Codigo_SAP" class="form-control" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>            
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                                          
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Código iZeta(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Código iZeta</label> 
                <?php } ?>        
            </div>
            <div class="col-md-9">	       	                        
                 <input type="text" name="Codigo_IZeta" id="txt_Codigo_IZeta" class="form-control" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>           
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	         
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Producto(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Producto</label> 
                <?php } ?>                         
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Producto" id="txt_Producto" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
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
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Tipo </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="nIDCat_Tipo" id="cb_nIDCat_Tipo" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                               
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Tipo" id="txt_Tipo" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDCat_Tipo" id="txt_nIDCat_Tipo" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >            
                    <?php
                        }
                     ?>                     
                 </div>                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > SubTipo </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="nIDCat_SubTipo" id="cb_nIDCat_SubTipo" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                               
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="SubTipo" id="txt_SubTipo" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDCat_SubTipo" id="txt_nIDCat_SubTipo" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >            
                    <?php
                        }
                     ?>                     
                 </div>                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Familia </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="nIDCat_Familia" id="cb_nIDCat_Familia" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                               
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Familia" id="txt_Familia" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDCat_Familia" id="txt_nIDCat_Familia" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >            
                    <?php
                        }
                     ?>                     
                 </div>
                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Presentación </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="nIDCat_Presentacion" id="cb_nIDCat_Presentacion" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                               
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Presentacion" id="txt_Presentacion" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDCat_Presentacion" id="txt_nIDCat_Presentacion" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >            
                    <?php
                        }
                     ?>                     
                 </div>                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Excepción </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="nIDCat_Excepcion" id="cb_nIDCat_Excepcion" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                               
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Excepcion" id="txt_Excepcion" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDCat_Excepcion" id="txt_nIDCat_Excepcion" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >            
                    <?php
                        }
                     ?>                     
                 </div>              
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Unidades de Medida </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="nIDCat_UnidadDeMedida" id="cb_nIDCat_UnidadDeMedida" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                               
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="UnidadDeMedida" id="txt_UnidadDeMedida" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDCat_UnidadDeMedida" id="txt_nIDCat_UnidadDeMedida" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >            
                    <?php
                        }
                     ?>                     
                 </div>               
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Proveedor </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="nIDCat_Proveedor" id="cb_nIDCat_Proveedor" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" selected >Ninguno</option>                                                                               
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="RazonSocial" id="txt_Proveedor" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDCat_Proveedor" id="txt_nIDCat_Proveedor" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >            
                    <?php
                        }
                     ?>                     
                 </div>                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                                                        
                 <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Puntos</label>                         
            </div>
            <div class="col-md-9">	       	                        
                 <input type="text" name="Puntos" id="txt_Puntos" class="form-control" style='height: 30px;width:50px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>           
         </div>

 
         <div class="row bg-light" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Activo</label> 
                </div>
                <div class="col-md-2" >	      
                <?php if($l_Accion!="Eliminar"){ ?>                  
                    <input type="checkbox" name="Activo" id="ch_Activo" class="" value="NO" style='height: 30px;width:20px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif;  padding-top:30px; position:relative; left:-10px;'> 
                <?php } else {  ?>
                    <input type="checkbox" name="Activo" id="ch_Activo" class="" value="NO" style='height: 30px;width:20px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif;  padding-top:30px; position:relative; left:-10px;' disabled> 
                <?php } ?>    
                </div>                    
         </div>
     
    </div>      

    <input type="hidden" name="Imagen" id="txt_Imagen" class="CampoTexto TamanoCampoTexto7" style='height:35px;width:500px;visibility:visible;' autocomplete="off" value="" readonly  onchange="fn_Presentar_Adjunto_Imagen()"/>       
 </form>    
 
 <div class="container" >
    <div class="row" style='margin-bottom:2px;'>
         <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Imagenes</label> 
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
                fn_Cat_Tipos_Clic('');  
                fn_Cat_SubTipos_Clic(''); 
                fn_Cat_Familias_Clic('');  
                fn_Cat_Presentaciones_Clic('');  
                fn_Cat_Excepciones_Clic('');      
                fn_Cat_UnidadesDeMedida_Clic('');       
                fn_Cat_Proveedores_Clic('');             
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