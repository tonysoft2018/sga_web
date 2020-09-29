<?php
// ----------------------------------------------------------------------------------
// barra_botones.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion.  Es utilizada para indicar la ubicacion del sistema
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 06/11/2019
// ----------------------------------------------------------------------------------
  
if($l_Accion=="Listado"){
?>
     <div class="col-12"  style='vertical-aling:middle;display:block;font-size:14px; font-family:"Arial", Gadget, sans-serif'>
         <form method="" class="form-inline">      

<?php 
             if($l_Modulo!="recibo" && $l_Modulo!="ubicaciones" && $l_Modulo!="entradasxcompras" && $l_Modulo!="entradaporotrosconceptos" && $l_Modulo!="salidaporotrosconceptos" && $l_Modulo!="ordendesurtido"  && $l_Modulo!="traspasos_envio" && $l_Modulo!="traspasos_recepcion"  ){
?>
                 <!-- <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a> -->
                 <!-- <a class="nav-link" href="<?php echo $l_Modulo ?>_excel.php" style='width:65px;margin-right:-5px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Excel</button></a>
                 <a class="nav-link" href="<?php echo $l_Modulo ?>_pdf.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>PDF</button></a> -->
<?php    
             }

             switch($l_Modulo){
                // CATALOGOS
                 case "cat_empresas":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;

                 case "cat_centrosdeservicio":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;

                 case "cat_almacen":
 ?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;

                 case "cat_racks":
?>                  
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;

                 
                 case "cat_pasillos":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;

                 case "cat_matriz":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                      
<?php                    
                     break;


                 case "cat_productos":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>        
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;

                 case "cat_tipos":
 ?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>     
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;     

                 case "cat_subtipos":
 ?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>     
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;     

                 case "cat_familias":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>     
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;     

                 case "cat_presentaciones":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>     
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;     

                 case "cat_excepciones":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>     
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;  
                    
                 case "cat_unidadesdemedida":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>     
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;     

                 case "cat_estados":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a> 
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;   
                     
                 case "cat_motivostraspaso":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a> 
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;                    


                 case "cat_conceptosentrada":
?>                    
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a> 
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;     

                 case "cat_conceptossalida":
?>                  
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a> 
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;  

                 case "cat_proveedores":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>     
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;    
                     
                 case "cat_clientes":
?>                   
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
<?php                    
                     break;     
                     

                 case "packinglist":
?>                   
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:5px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                        
<?php                    
                     break;     


                 case "entradasxcompras":
?>                    
                     
<?php                    
                     break;   
                    
                 case "entradaporotrosconceptos":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:1px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                  
<?php                    
                     break;   

                 case "salidaporotrosconceptos":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:1px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                  
<?php                    
                     break;   

                 case "ordendesurtido":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:1px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                  
<?php                    
                     break;   

                 case "traspasos_envio":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:1px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                  
<?php                    
                     break;   

                 case "usuarios":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:1px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                  
<?php                    
                     break;   

                 case "perfiles":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:1px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                  
<?php                    
                     break;   

                 case "ambiente_clasificaciones":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:1px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                  
<?php                    
                     break;   
                 case "ambiente_modulos":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:1px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                  
<?php                    
                     break;   
                     
                 case "interfaces":
?>                    
                     <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:1px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                  
<?php                    
                     break;   


            }


            
?>            
        </form>
    </div>    
<?php
} else {
    if($l_Accion=="Crear"){
?>
        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>
<?php        
            if($l_Modulo!="ubicaciones" && $l_Modulo!="contenedores" && $l_Modulo!="entradaporotrosconceptos_detalles"  && $l_Modulo!="salidaporotrosconceptos_detalles" && $l_Modulo!="ordendesurtido_detalles" && $l_Modulo!="traspasos_envio_detalles" && $l_Modulo!="traspasos_recepcion_detalles" && $l_Modulo!="inventarioxarticulo" && $l_Modulo!="inventarioxarticulo_conteo" && $l_Modulo!="inventarioxarticulo_lectura" ){
?>                
                <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
<?php                
            } 
?>            
             
<?php
             switch($l_Modulo){
                case "ambiente_bannerapp":
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>             
<?php
                    break;

                 case "ambiente_bannerapp":
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>             
<?php
                    break;

                 case "ambiente_logo":
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>             
<?php
                    break;

                case "ambiente_datosdelaempresa":
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>             
<?php
                    break;    
                                        
                case "ambiente_servidorcorreos":
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;       
                    
                case "ambiente_bd":
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;   
                case "ubicaciones":
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>             
<?php
                    break;
                case "contenedores":
?>
                     <a class="nav-link" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Contenedores_Cancelar()">Regresar</button></a>     
                     <a class="nav-link" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Contenedores_Excel()">Exportar Excel</button></a>     
                     <a class="nav-link" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Contenedores_Continuar()">Continuar</button></a>     
<?php
                    break;
                    
                case "entradaporotrosconceptos_detalles":
?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Detalles_Clic()">Grabar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                 
<?php
                    break;

                case "salidaporotrosconceptos_detalles":
?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Detalles_Clic()">Grabar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                 
<?php
                    break;

                case "traspasos_envio_detalles":
?>
                    <a class="nav-link" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Detalles_Clic()">Grabar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                 
<?php
                    break;

                case "traspasos_recepcion_detalles":
?>
                    <a class="nav-link" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Detalles_Clic()">Grabar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                 
<?php
                    break;

            // INVENTARIOS
                case "inventarioxarticulo":
?>
                    <a class="nav-link" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Crear Inventario</button></a>      
                    <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                 
<?php
                    break;
                case "inventarioxarticulo_conteo":
?>
                    <a class="nav-link" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_IntroducirConteo_Clic()">Introducir el Conteo</button></a>      
                    <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>                                 
<?php
                    break;

                case "inventarioxarticulo_lectura":
?>
                    <a class="nav-link" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Grabar_Conteo_Clic()">Guardar Conteo</button></a>      
                    <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>                                 
<?php
                    break;
                default:
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                 
<?php   
                    break;                    
             }
?>            
 
        </div>
<?php
    }

    if($l_Accion=="Editar"){
?>
        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>
<?php        
            if($l_Modulo!="ubicaciones"){
?>     
             <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Actualizar_Clic()">Grabar</button></a>      
<?php
            } 

             switch($l_Modulo){
                case "ambiente_bannerapp":
?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;

                case "ambiente_imagenapp":
 ?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;

                case "ambiente_logo":
 ?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;

                case "ambiente_datosdelaempresa":
 ?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;

               case "ambiente_servidorcorreos":
 ?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;


                case "ambiente_bd":
 ?>    
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;

                case "ambiente_usuarios":
 ?>                     
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;          
                case "ubicaciones":
?>
                    <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>             
<?php
                    break;          

                default:
?>                
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>                              
<?php
                    break;
             }
?>            
             
        </div>
<?php
    }

    if($l_Accion=="Eliminar"){
?>
        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>
  
<?php
             switch($l_Modulo){
                    case "recibo":
                        break;
                    default:
?>                    
                        <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Cancelar_Clic()">Cancelar</button></a>      
                        <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                        break;
             }
?>
        </div>
<?php
    }

    if($l_Accion=="Cancelar"){
        ?>
                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>
          
        <?php
                     switch($l_Modulo){
                            case "recibo":
                                break;
                            default:
        ?>                    
                                <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Cancelar_Clic()">Cancelar</button></a>      
                                <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
        <?php                    
                                break;
                     }
        ?>
                </div>
        <?php
            }

    if($l_Accion=="Ver"){
?>
        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>              
             
       
        
<?php
        switch($l_Modulo){
            case "recibo":
?>
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
                  <a class="nav-link" style='margin-left:-30px;'><button id='bt_Recibo' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Recibo()">Recibo</button></a>             
<?php
                break;   

            case "entradasxcompras":
?>
                  <a class="nav-link" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_EntradaxCompra_Cancelar()">Cancelar</button></a>     
                  <a class="nav-link" style='margin-left:-30px;'><button id='bt_Recibo' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_EntradaxCompra()">Continuar</button></a>             
<?php
                  break;   

            case "ordendesurtido":
?>
                   <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>       
                      
<?php
                  break;   

            case "traspasos_envio":
?>
                   <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>       
                      
<?php
                  break;   

            case "traspasos_recepcion":
?>
                   <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>       
                      
<?php
                  break;   
            default: 
?>            
            <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                              
<?php
                 break;
         }
?>
         </div>
<?php
    }

    if($l_Accion=="Detalles"){
?>
                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>              
                     
               
                
<?php
                switch($l_Modulo){
                    case "recibo":
        ?>
                         <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
                          <a class="nav-link" style='margin-left:-30px;'><button id='bt_Recibo' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Recibo()">Recibo</button></a>             
        <?php
                        break;   
        
                    case "entradasxcompras":
        ?>
                          <a class="nav-link" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_EntradaxCompra_Cancelar()">Regresar</button></a>     
                          <a class="nav-link" style='margin-left:-30px;'><button id='bt_Recibo' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_EntradaxCompra_Continuar()">Continuar</button></a>             
        <?php
                          break;   

                    case "entradadeproductos":
        ?>
                          <a class="nav-link" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_EntradaProductos_Regresar()">Regresar</button></a>     
                          <a class="nav-link" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_EntradaProductos_Cancelar()">Cancelar</button></a>     
                          <a class="nav-link" style='margin-left:-30px;'><button id='bt_Recibo' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_EntradaProductos_Grabar()">Grabar</button></a>             
        <?php
                          break;  
                 }
        ?>
                 </div>
        <?php
     }



    if($l_Accion=="Recepcion"){
        ?>
                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>              
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
               
                
        <?php
                switch($l_Modulo){
                    case "recibo":
        ?>
                          <a class="nav-link" style='margin-left:-30px;'><button id='bt_Recibo' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Grabar_Recepcion()">Grabar</button></a>             
        <?php
                        break;   
                 }
        ?>
                 </div>
        <?php
    }
    

    if($l_Accion=="Imprimir"){    
?>        
        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>                    
<?php        
        switch($l_Modulo){
            case "recibo":

            break;

            case "ordendesurtido":
?>
                      <a class="nav-link" style='margin-left:-30px;'><button id='bt_Recibo' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Imprimir()">Imprimir</button></a>             
                      <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                                 
                      
<?php
                      break;   
                case "traspasos_envio":
?>
                      <a class="nav-link" style='margin-left:-30px;'><button id='bt_Recibo' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Imprimir()">Imprimir</button></a>             
                      <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                                 
                      
<?php
                      break;   

               case "traspasos_recepcion":
?>
                      <a class="nav-link" style='margin-left:-30px;'><button id='bt_Recibo' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Imprimir()">Imprimir</button></a>             
                      <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                                 
                      
<?php
                      break;   
         }
?>         
         </div>
<?php         
    }

    if($l_Accion=="Cargar"){
?>
        <div class="col-12"  style='vertical-aling:middle;display:block;font-size:14px; font-family:"Arial", Gadget, sans-serif'>
        <form method="" class="form-inline">                                     
            <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
            <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
            <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>        
        </form>
    </div>    
<?php
    }
 
} 
?>