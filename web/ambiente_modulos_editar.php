<!DOCTYPE html>
<html>
    <?php
        // ----------------------------------------------------------------------------------
        // ambiente_modulos_editar.php
        // ----------------------------------------------------------------------------------
        // Autor. Ing. Antonio Barajas del Castillo
        // ----------------------------------------------------------------------------------
        // Empresa. IDEATECH
        // ----------------------------------------------------------------------------------        
        // Fecha Ultima Modificación
        // 25/03/2020
        // ----------------------------------------------------------------------------------
        // V2.0.0
        // ----------------------------------------------------------------------------------

        ob_start();
        session_start();

        $l_Modulo="ambiente_modulos"; 
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
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>
    
     <?php      
      include_once "../clases/clHerramientas_v2011.php"; 
      include_once "../clases/ambiente_modulos.mysql.class_v2.0.0.php"; 
      include_once "../bd/conexion.php";

       // Extrae el id
       $l_nID=0;
       $l_nIDModulo_Padre=0;
       $l_Padre_NombreDelModulo="";

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

       $tbl = new  cltbl_Ambiente_Modulos_v2_0_0();
       $tbl->Inicializacion();
       $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
       $tbl->CargarCampos("LEER");
       $Campo_Llave=$tbl->get_CampoLlave();   


       if($l_nID>0){
        $l_Condicion="nIDModulo=" . $l_nID;
 
        $tbl->Inicializacion();
        $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);          
        $tbl->Leer($l_Condicion);

        if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
           $registros=$tbl->dtBase();
           $l_nIDModulo_Padre=$registros[0]["nIDModulo_Padre"];
           $l_Padre_NombreDelModulo=$registros[0]["Padre_NombreDelModulo"]; 
        }  
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
            <div class="col-md-3">	                                         
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Nombre del Modulo(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Nombre del Modulo</label> 
                <?php } ?>
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="NombreDelModulo" id="txt_NombreDelModulo" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>
           
         </div>
        
         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	                          
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Descripcion</label> 
                </div>
                <div class="col-md-9">	       	                                     
                        <textarea class="form-control" rows="5" name="Descripcion" id="txt_Descripcion" style='height: 100px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; resize:none; '<?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>   </textarea>        
                </div>              
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Mostrar</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Mostrar" id="ch_Mostrar" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>               
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                                     
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >URL(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >URL</label> 
                <?php } ?>
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="URL" id="txt_URL" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>
           
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Parametros</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Parametros" id="txt_Parametros" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                                         
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >ID del Modulo(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >ID del Modulo</label> 
                <?php } ?>
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Modulo" id="txt_Modulo" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>
             
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                                         
                <?php if($l_Accion!="Eliminar"){ ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;color:#FF0000;' >Nombre para mostrar(*)</label> 
                <?php } else {  ?>
                    <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Nombre para mostrar</label> 
                <?php } ?>
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Menu" id="txt_Menu" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>
             
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Nivel </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="Nivel" id="cb_Nivel" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="Ninguno" selected >Ninguno</option>                                                                               
                                <option value="Menu">Menu</option>
                                <option value="SubMenu1">SubMenu1</option>  
                                <option value="SubMenu1_1">SubMenu1_1</option>  
                                <option value="SubMenu1_1_1">SubMenu1_1_1</option>  
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Nivel" id="cb_Nivel" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >                             
                    <?php
                        }
                     ?>                     
                 </div>
                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Orden</label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="Orden" id="cb_Orden" class="form-control-select" style='height: 30px;width:40px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                     <?php
                            for($i=0;$i<1001;$i++){
                     ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                     <?php
                            }
                     ?>                                 
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Orden" id="cb_Orden" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >                             
                    <?php
                        }
                     ?>                     
                 </div>                 
         </div>
 
         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Campo Ordenamiento</label> 
            </div>
            <div class="col-md-9">	       	                            
                 <input type="text" name="Campo_Ordenamiento" id="txt_Campo_Ordenamiento" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>                                    
            </div>
            
         </div> 

         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Forma de Ordenamiento </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="Forma_Ordenamiento" id="cb_Forma_Ordenamiento" class="form-control-select" style='height: 30px;width:100px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' <?php if($l_Accion=="Eliminar"){?>  readonly <?php } ?>>
                                <option value="Ninguno" selected >Ninguno</option>                                                                               
                                <option value="Ascendente">Ascendente</option>
                                <option value="Descendente">Descendente</option>                                   
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Forma_Ordenamiento" id="cb_Forma_Ordenamiento" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >                             
                    <?php
                        }
                     ?>                     
                 </div>
                 <div class="d-xs-block col-md-2">	                       
                </div>
         </div>
         
 
         <div class="row" style='margin-bottom:2px;'>
                 <div class="col-md-3">	                         
                        <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' > Modulo Padre </label> 
                 </div>
                 <div class="col-md-9">	       
                     <?php 
                        if($l_Accion!="Eliminar"){
                     ?>
                            <select name="nIDModulo_Padre" id="cb_nIDModulo_Padre" class="form-control-select" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; '>
                            
                                <option value="0" >Ninguno</option>    
                      <?php 
                                if($l_nIDModulo_Padre>0){
                     ?>
                                    <option value="<?php echo $l_nIDModulo_Padre ?>" selected > <?php echo $l_Padre_NombreDelModulo ?></option>         
                     <?php
                                } 
                     ?>                                 
                            </select>
                     <?php
                        } else {
                    ?>
                            <input type="text" name="Padre_NombreDelModulo" id="txt_Padre_NombreDelModulo" class="form-control" style='height: 30px;width:450px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >
                            <input type="hidden" name="nIDModulo_Padre" id="txt_nIDModulo_Padre" class="form-control" style='height: 30px;width:500px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; ' readonly >            
                    <?php
                        }
                     ?>                     
                 </div>
                  
         </div>

         <div class="row" style='margin-bottom:2px;background-color:#ccc;'>
            <div class="col-md-3 col-lg-2">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Acciones </label> 
            </div>
            <div class="col-md-9">	       	                            
                                 
            </div>
           
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Crear</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Creacion" id="ch_Creacion" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Editar</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Editar" id="ch_Editar" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Eliminar</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Borrar" id="ch_Borrar" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                
         </div>


         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3 ">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Cancelar</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Cancelar" id="ch_Cancelar" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Consultar</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Consultar" id="ch_Consultar" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                <div class="d-none d-sm-block col-md-2">	                   
                </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Listar</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Listar" id="ch_Listar" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Ejecutar</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Ejecutar" id="ch_Ejecutar" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Imprimir</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Imprimir" id="ch_Imprimir" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Etiquetas</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Etiquetas" id="ch_Etiquetas" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                <div class="d-none d-sm-block col-md-2">	                   
                </div>
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Cargar Masiva</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="CargaMasiva" id="ch_CargaMasiva" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Exportar Excel</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="ExportarExcel" id="ch_ExportarExcel" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Exportar PDF</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="ExportarPDF" id="ch_ExportarPDF" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                 
         </div>

         <div class="row" style='margin-bottom:2px;background-color:#ccc;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Aplicacion </label> 
            </div>
            <div class="col-md-9">	       	                            
                                 
            </div>
            
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Web</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="Web" id="ch_Web" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                
         </div>

         <div class="row" style='margin-bottom:2px;'>
                <div class="col-md-3">	              
                       <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >App</label> 
                </div>
                <div class="col-md-9" >	       	                   
                    <input type="checkbox" name="App" id="ch_App" class="" value="NO" style='height: 30px;width:400px;font-size:10px; font-family:"Arial Black", Gadget, sans-serif; margin-left:-10px; padding-top:30px; '> 
                </div>
                 
         </div>

         <div class="row" style='margin-bottom:2px;'>
            <div class="col-md-3">	                        
                <label for="nombre" style='font-size:12px; font-family:"Arial black", Gadget, sans-serif;margin-left:-10px;' >Icono </label> 
            </div>
            <div class="col-md-9">	       	                            
                                 
            </div>
          
         </div>
 
    </div>      

    <input type="hidden" name="Icono" id="txt_Imagen" class="CampoTexto TamanoCampoTexto7" style='height:35px;width:500px;visibility:visible;' autocomplete="off" value="" readonly  onchange="fn_Presentar_Adjunto_Imagen()"/>       
 </form>    
 
 <div class="container" >
    <div class="row" style='margin-bottom:2px;'>
         <div class="col-md-3">	                        
                 
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

  <BR>
  <BR>
 </div>

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
               fn_Ambiente_Modulos_Padre_Clic('');       
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