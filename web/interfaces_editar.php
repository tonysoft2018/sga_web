<!DOCTYPE html>
<html>
    <?php
        // ----------------------------------------------------------------------------------
        // interfaces_editar.php
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

        $l_Modulo="interfaces"; 
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
 
    <script type="text/javascript" src="../js/ambiente_modulos_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/ambiente_modulos.vista.js"></script>
 
    <script type="text/javascript" src="../js/interfaces_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/interfaces.vista.js"></script>
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>
    
     <?php      
      include_once "../clases/clHerramientas_v2011.php"; 
      include_once "../clases/interfaces.mysql.class_v2.0.0.php"; 
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

       $tbl = new  cltbl_Interfaces_v2_0_0();
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
            <div class="col-md-3 col-lg-2">	      
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Interfaz(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Interfaz</label> 
                <?php } ?>
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Interfaz" id="txt_Interfaz" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                       
            </div>      
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3 col-lg-2">	                          
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Descripcion</label> 
                </div>
                <div class="col-md-9">	 
                    <?php if($l_Accion!="Eliminar"){ ?>      	                                     
                        <textarea class="form-control" rows="5" name="Descripcion" id="txt_Descripcion" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none; '></textarea>        
                    <?php } else {  ?>
                        <textarea class="form-control" rows="5" name="Descripcion" id="txt_Descripcion" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none; ' readonly>   </textarea>        
                    <?php } ?>      
                </div>                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3 col-lg-2">	                          
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >API</label> 
                </div>
                <div class="col-md-9">	       	                                                              
                        <?php if($l_Accion!="Eliminar"){ ?>      	                                     
                            <textarea class="form-control" rows="5" name="API" id="txt_API" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none; '></textarea>        
                        <?php } else {  ?>
                            <textarea class="form-control" rows="5" name="API" id="txt_API" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none; ' readonly>   </textarea>        
                        <?php } ?>      
                </div>              
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3 col-lg-2">	                          
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Ubicacion</label> 
                </div>
                <div class="col-md-9">	       	                                                              
                        <?php if($l_Accion!="Eliminar"){ ?>      	                                     
                            <textarea class="form-control" rows="5" name="Ubicacion" id="txt_Ubicacion" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none; '></textarea>        
                        <?php } else {  ?>
                            <textarea class="form-control" rows="5" name="Ubicacion" id="txt_Ubicacion" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none; ' readonly>   </textarea>        
                        <?php } ?>      
                </div>                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3 col-lg-2">	                          
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >URL</label> 
                </div>
                <div class="col-md-9">	       	                                                      
                        <?php if($l_Accion!="Eliminar"){ ?>      	                                     
                            <textarea class="form-control" rows="5" name="URL" id="txt_URL" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none; '></textarea>        
                        <?php } else {  ?>
                            <textarea class="form-control" rows="5" name="URL" id="txt_URL" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none; ' readonly>   </textarea>        
                        <?php } ?>      
                </div>                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3 col-lg-2">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Metodo </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="Metodo" id="cb_Metodo" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="Ninguno" selected >Ninguno</option>           
                                <option value="POST">POST</option>
                                <option value="GET">GET</option>
                                <option value="PUT">PUT</option>
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Metodo" id="txt_Metodo" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >                             
                    <?php
                        }
                     ?>                     
                 </div>                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3 col-lg-2">	    
                     <?php if($l_Accion!="Eliminar"){ ?>
                         <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Modulo(*)</label> 
                    <?php } else {  ?>
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Modulo</label> 
                    <?php } ?>
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="nIDModulo" id="cb_nIDModulo" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="0" >Ninguno</option>                                                                               
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="NombreDelModulo" id="txt_NombreDelModulo" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDModulo" id="txt_nIDModulo" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >            
                    <?php
                        }
                     ?>                     
                 </div>
                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3 col-lg-2">	                                                  
                        <?php if($l_Accion!="Eliminar"){ ?>
                         <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Funcion(*)</label> 
                        <?php } else {  ?>
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Funcion</label> 
                        <?php } ?>
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="Funcion" id="cb_Funcion" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="" selected >Ninguno</option>           
                                <option value="ENVIO">Envio</option>
                                <option value="RECEPCION">Recepcion</option>
                                <option value="EJECUCION">Ejecucion</option>
                                <option value="ENVIO/RECEPCION">Envio/Recepcion</option>
                                <option value="TODOS">Todos</option>
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Funcion" id="txt_Funcion" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >                             
                    <?php
                        }
                     ?>                     
                 </div>
                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3 col-lg-2">	                          
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Token</label> 
                </div>
                <div class="col-md-9">	       	                                                              
                        <?php if($l_Accion!="Eliminar"){ ?>      	                                     
                            <textarea class="form-control" rows="5" name="Token" id="txt_Token" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none; '></textarea>        
                        <?php } else {  ?>
                            <textarea class="form-control" rows="5" name="Token" id="txt_Token" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px;resize:none; ' readonly>   </textarea>        
                        <?php } ?>      
                </div>                
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Usuario</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Usuario" id="txt_Usuario" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>
            
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Password</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Password" id="txt_Password" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>
             
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3 col-lg-2">	                         
                        <?php if($l_Accion!="Eliminar"){ ?>
                            <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Tipo(*)</label>   
                        <?php } else {  ?>
                        
                            <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Tipo </label> 
                        <?php } ?>
                       
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="Tipo" id="cb_Tipo" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="" selected >Ninguno</option>           
                                <option value="WEB">Web</option>
                                <option value="APP">App</option>
                                <option value="CLIENTE/SERVIDOR">Cliente/Servidor</option>                             
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Tipo" id="txt_Tipo" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >                             
                    <?php
                        }
                     ?>                     
                 </div>
             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Campo 1</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Campo1" id="txt_Campo1" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>
            
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Parametros 1</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Parametros1" id="txt_Parametros1" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>
     
         </div>


         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Campo 2</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Campo2" id="txt_Campo2" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Parametros 2</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Parametros2" id="txt_Parametros2" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Campo 3</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Campo3" id="txt_Campo3" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>
             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Parametros 3</label> 
            </div>
            <div class="col-md-9">
                 <input type="text" name="Parametros3" id="txt_Parametros3" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Campo 4</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Campo4" id="txt_Campo4" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Parametros 4</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Parametros4" id="txt_Parametros4" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Campo 5</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Campo5" id="txt_Campo5" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Parametros 5</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Parametros5" id="txt_Parametros5" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Campo 6</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Campo6" id="txt_Campo6" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Parametros 6</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Parametros6" id="txt_Parametros6" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Campo 7</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Campo6" id="txt_Campo6" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Parametros 7</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Parametros7" id="txt_Parametros7" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>            
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Campo 8</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Campo8" id="txt_Campo8" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Parametros 8</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Parametros8" id="txt_Parametros8" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Campo 9</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Campo9" id="txt_Campo9" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Parametros 9</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Parametros9" id="txt_Parametros9" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Campo 10</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Campo10" id="txt_Campo10" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Parametros 10</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Parametros10" id="txt_Parametros10" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>         
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3 col-lg-2">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Pasar Datos</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="PasarDatos" id="ch_PasarDatos" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >IP</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="IP" id="txt_IP" class="form-control" style='height: 30px;width:120px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>
                          
    </div>      
 </form>    
  <br>
  <br>
 <!-- FIN -->
 
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
             fn_Consultar_Clic('<?php echo $l_Condicion ?>',ACCION); 
         </script>
 <?php
     } else {
?>
        <script>
            fn_Ambiente_Modulos_Clic('',0,ACCION );                     
        </script>
<?php
     }
?>           
 <!-- FIN PROCESAR ---> 
</body>
</html>