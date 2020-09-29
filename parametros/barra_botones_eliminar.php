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
  
 

if($l_Accion=="Eliminar"){
?>
        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>
  
<?php              

    switch($l_Modulo){

        case "cat_empresas":
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>       
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php
                break;

        case "cat_centrosdeservicio":
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php
                break;


        case "cat_almacen":
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php
                break;

        case "cat_racks":
?>                  
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>       
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;


        case "cat_pasillos":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>       
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;

        case "cat_matriz":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>       
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;

        case "cat_productos":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;

        case "cat_tipos":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;     

        case "cat_subtipos":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;     


        case "cat_familias":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;     

        case "cat_presentaciones":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;     

        case "cat_excepciones":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>      
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;  
               
        case "cat_unidadesdemedida":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;     

        case "cat_estados":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>       
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;   
                
        case "cat_motivostraspaso":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>     
<?php                    
                break;                    


        case "cat_conceptosentrada":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;     

        case "cat_conceptossalida":
?>                  
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;  

        case "cat_proveedores":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;    
                
        case "cat_clientes":
?>                   
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php                    
                break;     

     // RECIBO
        case "packinglist":
                     
                break;     

        case "recibo":

                break;

        case "ubicaciones":
 
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
               
                break;


        case "inventarioxarticulo_conteo":

                break;

        case "inventarioxarticulo_lectura":

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
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>    

<?php
                break;


        case "perfiles":
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>       
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  

<?php
                break;


        case "ambiente_bannerapp": 
?>

                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>       
                 <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  

<?php
                break;

        case "ambiente_clasificaciones":
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>      
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php
                break;

        case "notificaciones":
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>      
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php
                break;
        case "ambiente_bd":
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>       
                 <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php
                break;

        case "ambiente_datosdelaempresa":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>       
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php
                break;
        case "ambiente_imagenapp":
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php
                break;

        case "ambiente_logo":
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php
               break;

        case "ambiente_modulos":               
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>       
                 <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php
               break;

        case "ambiente_usuarios":
?>                    
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  

<?php
                break;

        case "ambiente_servidorcorreos":
?>
                 <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
                 <a class="nav-link" href="menu.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Regresar</button></a>  
<?php
               break;


        case "interfaces":
?>    
               <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>     
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