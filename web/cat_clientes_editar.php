<!DOCTYPE html>
<html>
    <?php
        // ----------------------------------------------------------------------------------
        // cat_clientes_editar.php
        // ----------------------------------------------------------------------------------
        // Autor. Ing. Antonio Barajas del Castillo
        // ----------------------------------------------------------------------------------
        // Empresa. IDEATECH
        // ----------------------------------------------------------------------------------
        // Descripcion. Modulo para editar datos de un perfil.
        // ----------------------------------------------------------------------------------
        // Fecha Ultima Modificación
        // 22/07/2020
        // ----------------------------------------------------------------------------------
        // V2.0.3
        // ----------------------------------------------------------------------------------

        ob_start();
        session_start();

        $l_Modulo="cat_clientes"; 
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
 
    <script type="text/javascript" src="../js/cat_clientes_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_clientes.vista.js"></script>
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>
    
     <?php
      
      include_once "../clases/clHerramientas_v2011.php"; 
      include_once "../clases/cat_clientes.mysql.class_v2.0.0.php"; 
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


       $tbl = new  cltbl_Cat_Clientes_v2_0_0();
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
            <div class="col-3">	                        
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >ID(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >ID</label> 
                <?php } ?>
            </div>
            <div class="col-md-9">                                       
                <input type="text" name="IDCliente" id="txt_IDCliente" class="form-control" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;' <?php if($l_Accion=="Eliminar" || $l_Accion=="Editar"){?>  readonly <?php } ?> >                 
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >ID iZeta(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >ID iZeta</label> 
                <?php } ?>
            </div>
            <div class="col-md-9">                             
                 <input type="text" name="IDCliente_IZeta" id="txt_IDCliente_IZeta" class="form-control" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >
            </div>


         </div>
 
         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                                         
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Razón Social(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Razón Social</label> 
                <?php } ?>
            </div>
            <div class="col-md-9">         	                        
                 <input type="text" name="RazonSocial" id="txt_RazonSocial" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                 
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >RFC</label> 
            </div>
            <div class="col-md-9">                            
                 <input type="text" name="RFC" id="txt_RFC" class="form-control" style='height: 30px;width:120px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                 
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Calle</label> 
            </div>
            <div class="col-md-9">                        
                 <input type="text" name="Calle" id="txt_Calle" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                  
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >NoExterior</label> 
            </div>
            <div class="col-md-9">                               
                 <input type="text" name="NoExterior" id="txt_NoExterior" class="form-control" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                  
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >NoInterior</label> 
            </div>
            <div class="col-md-9">                              
                 <input type="text" name="NoInterior" id="txt_NoInterior" class="form-control" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                  
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Colonia</label> 
            </div>
            <div class="col-md-9">                             
                 <input type="text" name="Colonia" id="txt_Colonia" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                           
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Ciudad</label> 
            </div>
            <div class="col-md-9">                            
                 <input type="text" name="Ciudad" id="txt_Ciudad" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                            
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Municipio</label> 
            </div>
            <div class="col-md-9">                          
                 <input type="text" name="Municipio" id="txt_Municipio" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                          
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Estado</label> 
            </div>
            <div class="col-md-9">       	                        
                 <input type="text" name="Estado" id="txt_Estado" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                           
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >País</label> 
            </div>
            <div class="col-md-9">                               
                 <input type="text" name="Pais" id="txt_Pais" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                          
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >CP</label> 
            </div>
            <div class="col-md-9">      	                        
                 <input type="text" name="CP" id="txt_CP" class="form-control" style='height: 30px;width:80px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                        
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Teléfono1</label> 
            </div>
            <div class="col-md-9">                              
                 <input type="text" name="Telefono1" id="txt_Telefono1" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                            
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Teléfono2</label> 
            </div>
            <div class="col-md-9">                             
                 <input type="text" name="Telefono2" id="txt_Telefono2" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                            
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Teléfono3</label> 
            </div>
            <div class="col-md-9">                               
                 <input type="text" name="Telefono3" id="txt_Telefono3" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                         
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Celular1</label> 
            </div>
            <div class="col-md-9">                            
                 <input type="text" name="Celular1" id="txt_Celular1" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Celular2</label> 
            </div>
            <div class="col-md-9">                             
                 <input type="text" name="Celular2" id="txt_Celular2" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Celular3</label> 
            </div>
            <div class="col-md-9">                              
                 <input type="text" name="Celular3" id="txt_Celular3" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                           
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Email1</label> 
            </div>
            <div class="col-md-9">                            
                 <input type="text" name="Email1" id="txt_Email1" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                            
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Email2</label> 
            </div>
            <div class="col-md-9">                          
                 <input type="text" name="Email2" id="txt_Email2" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                           
            </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Email3</label> 
            </div>
            <div class="col-md-9">                           
                 <input type="text" name="Email3" id="txt_Email3" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                         
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
         
         <div class="row" style='margin-bottom:2px;'>
            <div class="col-3">	                                         
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Contacto(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Contacto</label> 
                <?php } ?>

            </div>
            <div class="col-md-9">                            
                 <input type="text" name="Contacto" id="txt_Contacto" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?> >                           
            </div> 
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                                                        
                 <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Puntos</label>                         
            </div>
            <div class="col-md-9">	       	                        
                 <input type="text" name="Puntos" id="txt_Puntos" class="form-control" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>           
         </div>
         
    </div>      
 </form>     
 <!-- FIN -->
<br>
<br>
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