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
// 26/03/2020
// ----------------------------------------------------------------------------------
 
    if($l_Accion=="Cargar"){
        ?>
                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>       
        <?php
                     switch($l_Modulo){
        
                         case "cat_empresas":
        ?>
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>        
        <?php
                             break;
        
                         case "cat_centrosdeservicio":
        ?>
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>           
        <?php
                             break;
        
        
                         case "cat_almacen":
        ?>
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>        
        <?php
                             break;
        
                         case "cat_racks":
        ?>                  
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;
        
                         case "cat_pasillos":
        ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;
        
                         case "cat_matriz":
        ?>                    
                              
         <?php                    
                             break;
        
                         case "cat_productos":
        ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;
        
                         case "cat_tipos":
         ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;     
        
                         case "cat_subtipos":
         ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;     
        
                         case "cat_familias":
        ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;     
        
                         case "cat_presentaciones":
        ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;     
        
                         case "cat_excepciones":
        ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;  
                            
                         case "cat_unidadesdemedida":
        ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;     
        
                         case "cat_estados":
        ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;   
                             
                         case "cat_motivostraspaso":
        ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;                    
        
        
                         case "cat_conceptosentrada":
        ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;     
        
                         case "cat_conceptossalida":
        ?>                  
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>         
        <?php                    
                             break;  
        
                         case "cat_proveedores":
        ?>                    
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;    
                             
                         case "cat_clientes":
        ?>                   
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:-10px; margin-right:5px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Cargar_Clic()" >Cargar</button>         
                                 <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif; margin-left:0px; margin-right:1px;margin-top:5px;margin-bottom:5px;' onclick="fn_Listado_Grabar_Clic()" >Grabar</button>         
                                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-10px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
        <?php                    
                             break;     
        
                         case "packinglist":
                      
                             break;     
        
                         case "recibo":
                  
                             break;   
        
                         case "ubicaciones":
                       
                             break;   
        
                         case "contenedores":
  
                            break;                     
        
                         case "entradasxcompras":
                      
                             break;   
        
                         case "entradaporotrosconceptos":
                  
                             break;   
        
        
                         case "entradaporotrosconceptos_detalles":
    
                            break;
        
                         case "salidaporotrosconceptos":
                    
                             break;   
        
                         case "salidaporotrosconceptos_detalles":
     
                            break;
        
                         case "inventarioxarticulo":
  
                            break;
                         case "inventarioxarticulo_conteo":
    
                            break;
        
                         case "inventarioxarticulo_lectura":
   
                            break;
        
                         case "ordendesurtido":   
  
                            break;
        
                         case "traspasos_envio":
      
                            break;            
                         case "traspasos_envio_detalles":
  
                            break;
        
                         case "traspasos_recepcion":
   
                            break;       
        
                         case "traspasos_recepcion_detalles":
   
                            break;
        
        
                         case "usuarios":
                    
                             break;   
        
                         case "perfiles":
                      
                             break;   
        
        
                         case "ambiente_bannerapp":
   
                            break;
        
                         case "ambiente_clasificaciones":
                      
                             break;   
        
                         case "ambiente_bd":
   
                            break;   
        
                         case "ambiente_datosdelaempresa":
   
                            break;    
        
                         case "ambiente_logo":
    
                            break;
        
                         case "ambiente_modulos":
                 
                             break;   
        
                         case "ambiente_clasificaciones":
                      
                             break;   
                                                
                         case "ambiente_servidorcorreos":
 
                            break;       
        
                          case "interfaces":
          
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
 