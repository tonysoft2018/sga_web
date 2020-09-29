<?php
// ----------------------------------------------------------------------------------
// barra_botones.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. IDEATECH
// ----------------------------------------------------------------------------------
// Descripcion. Modulo para editar datos de un perfil.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 13/07/2020
// ----------------------------------------------------------------------------------
// V2.0.2
// ----------------------------------------------------------------------------------
  
 
 if($l_Accion=="Crear"){
?>
        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>
<?php        
            if($l_Modulo!="ubicaciones" && $l_Modulo!="contenedores" && $l_Modulo!="entradaporotrosconceptos_detalles"  && $l_Modulo!="salidaporotrosconceptos_detalles" && $l_Modulo!="ordendesurtido_detalles" && $l_Modulo!="traspasos_envio_detalles" && $l_Modulo!="traspasos_recepcion_detalles" && $l_Modulo!="inventarioxarticulo" && $l_Modulo!="inventarioxarticulo_conteo" && $l_Modulo!="inventarioxarticulo_lectura" ){
?>                
                <!-- <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>       -->
<?php                
            } 
?>            
             
<?php
             switch($l_Modulo){

                 case "cat_empresas":
?>
                         <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                         <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>         
<?php
                     break;

                 case "cat_centrosdeservicio":
?>
                         <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                         <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>         
<?php
                     break;


                 case "cat_almacen":
?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>         
<?php
                     break;

                 case "cat_racks":
?>                  
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>         
<?php                    
                     break;

                 case "cat_pasillos":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>         
<?php                    
                     break;

                 case "cat_matriz":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
 <?php                    
                     break;

                 case "cat_productos":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;

                 case "cat_tipos":
 ?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;     

                 case "cat_subtipos":
 ?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;     

                 case "cat_familias":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;     

                 case "cat_presentaciones":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;     

                 case "cat_excepciones":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;  
                    
                 case "cat_unidadesdemedida":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;     

                 case "cat_estados":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;   
                     
                 case "cat_motivostraspaso":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;                    


                 case "cat_conceptosentrada":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;     

                 case "cat_conceptossalida":
?>                  
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;  

                 case "cat_proveedores":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;    
                     
                 case "cat_clientes":
?>                   
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;     

                 case "packinglist":
?>                   
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;     

                 case "recibo":
?>                    
                                             
<?php                    
                     break;   

                 case "ubicaciones":
?>                    
                     <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                 
<?php                    
                     break;   

                 case "contenedores":
?>                     
                     <!-- <a class="nav-link" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Contenedores_Excel()">Exportar Excel</button></a>      -->
                     <a class="nav-link" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Contenedores_Continuar()">Continuar</button></a>     
                     <a class="nav-link" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Contenedores_Cancelar()">Regresar</button></a>     
<?php
                    break;                     

                 case "entradasxcompras":
?>                    
                     
<?php                    
                     break;   

                 case "entradaporotrosconceptos":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>     
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;   


                 case "entradaporotrosconceptos_detalles":
?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Detalles_Clic()">Grabar</button></a>                           
<?php
                    break;

                 case "salidaporotrosconceptos":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>     
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    
<?php                    
                     break;   

                 case "salidaporotrosconceptos_detalles":
?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Detalles_Clic()">Grabar</button></a>                           
<?php
                    break;

                 case "inventarioxarticulo":
?>
                    <a class="nav-link" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Crear Inventario</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                 
<?php
                    break;
                 case "inventarioxarticulo_detalles":
?>
                    <a class="nav-link" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Grabar_Conteo_Clic()">Guardar Conteo</button></a>      
                    <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                
<?php
                    break;

                 case "inventarioxubicacion":
?>
                    <a class="nav-link" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Crear Inventario</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                 
<?php
                    break;
                 case "inventarioxubicacion_detalles":
?>
                    <a class="nav-link" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Grabar_Conteo_Clic()">Guardar Conteo</button></a>      
                    <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                
<?php
                    break;     

                case "ajustes":
?>                       
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                 
<?php
                    break;

                 case "ordendesurtido":   
?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>   
<?php
                    break;

                 case "traspasos_envio":
?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>   

<?php   
                    break;            
                 case "traspasos_envio_detalles":
?>
                    <a class="nav-link" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Detalles_Clic()">Grabar</button></a>                           
<?php
                    break;

                 case "traspasos_recepcion":
?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>   

<?php   
                    break;       

                 case "traspasos_recepcion_detalles":
?>
                    <a class="nav-link" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Detalles_Clic()">Grabar</button></a>                           
<?php
                    break;


                 case "usuarios":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>     
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>         
<?php                    
                     break;   

                 case "perfiles":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>                          
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                     break;   


                 case "ambiente_bannerapp":
?>
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>                 
                     <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>             
<?php
                    break;

                 case "ambiente_clasificaciones":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>                          
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
<?php                    
                     break;   

                 case "notificaciones":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>                          
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
<?php                    
                     break;   

                 case "ambiente_bd":
?>
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>       
                     <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>   
<?php
                    break;   

                 case "ambiente_datosdelaempresa":
?>
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>       
                     <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>           
<?php
                    break;    

                 case "ambiente_logo":
?>
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>  
                     <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>           
<?php
                    break;

                 case "ambiente_modulos":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>  
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>        
<?php                    
                     break;   

                 case "ambiente_usuarios":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>  
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>        
<?php                    
                     break;   
                 case "ambiente_clasificaciones":
?>                    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>  
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>        
<?php                    
                     break;   
                                        
                 case "ambiente_servidorcorreos":
?>
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>  
                     <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                     
<?php
                    break;       

                  case "interfaces":
 ?>    
                     <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                     <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                  
<?php
                    break;    
 
                  case "canjepuntos":   
?>
                    <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
                    <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>   
<?php
                    break;
                 default:
?>
                    <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>                                 
<?php   
                    break;                    
             }
?>            
 
        </div>
<?php
    }   
?>