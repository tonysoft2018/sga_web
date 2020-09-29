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
 
 
     if($l_Accion=="Ajustar"){
        ?>
                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>
          
        <?php              
        
            switch($l_Modulo){
        
                case "cat_empresas":
         
                        break;
        
                case "cat_centrosdeservicio":
         
                        break;
        
        
                case "cat_almacen":
         
                        break;
        
                case "cat_racks":
                        
                        break;
        
        
                case "cat_pasillos":
                     
                        break;
        
                case "cat_matriz":
                          
                        break;
        
                case "cat_productos":
                         
                        break;
        
                case "cat_tipos":
                         
                        break;     
        
                case "cat_subtipos":
                       
                        break;     
        
        
                case "cat_familias":
                        
                        break;     
        
                case "cat_presentaciones":
                          
                        break;     
        
                case "cat_excepciones":
                        
                        break;  
                       
                case "cat_unidadesdemedida":
                     
                        break;     
        
                case "cat_estados":
                           
                        break;   
                        
                case "cat_motivostraspaso":
                        
                        break;                    
        
                case "cat_conceptosentrada":
                          
                        break;     
        
                case "cat_conceptossalida":
         
                        break;  
        
                case "cat_proveedores":
                        break;    
                        
                case "cat_clientes":
                        break;     
        
             // RECIBO
                case "packinglist":
                 
                        break;     
        
                case "recibo":
      
                        break;
        
                        
                case "ubicaciones":
         
                       break;          
        
                 case "inspeccion":
        
                        break;

             // INVENTARIOS
                case "entradasxcompras":
        
                        break;
                
                case "contenedores":
        
                        break;
        
        
                case "entradadeproductos":
       
                        break;
        
                case "entradaporotrosconceptos":
       
                        break;
        
                case "entradaporotrosconceptos_detalles": // Movil
        
                        break;
        
        
                case "salidaporotrosconceptos":
         
                        break;
        
                case "salidaporotrosconceptos_detalles": // Movil
        
                        break;
        
        
                case "inventarioxarticulo":
        ?>                         
                        <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ajustar_Inventario_Clic()">Realizar Ajustes</button></a>      
                        <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
        <?php
                        break;
        
                case "inventarioxubicacion":
        ?>                         
                        <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ajustar_Inventario_Clic()">Realizar Ajustes</button></a>      
                        <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
        <?php
                        break;
            
                case "ajustes":
        ?>                                                  
                        <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
        <?php
                        break;
             // TRASPASOS
                case "ordendesurtido":
       
                        break;
        
                case "traspasos_envio":
         
                        break;
        
                case "traspasos_envio_detalles": // Movil
        
                        break;
        
                case "traspasos_recepcion":
        
                        break;
        
        
                case "traspasos_recepcion_detalles":  // Movil
        
                        break;
        
             // SEGURIDAD
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
                case "ambiente_imagenapp":
         
                        break;
        
                case "ambiente_logo":
         
                       break;
        
                case "ambiente_modulos":               
         
                       break;
        
                case "ambiente_usuarios":
         
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


