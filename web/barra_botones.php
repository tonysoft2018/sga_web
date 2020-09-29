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
            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px; margin-right:1px; width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
            <a class="nav-link" href="<?php echo $l_Modulo ?>_excel.php" style='width:65px;margin-right:-5px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Excel</button></a>
            <a class="nav-link" href="<?php echo $l_Modulo ?>_pdf.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>PDF</button></a>

<?php
            switch($l_Modulo){
                case "cat_pasillos":
?>                    
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;margin-right:-10px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
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
             <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Crear_Clic()">Grabar</button></a>      
<?php
             switch($l_Modulo){
                case "ambiente_bannerapp":
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;

                 case "ambiente_bannerapp":
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;

                 case "ambiente_logo":
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
<?php
                    break;

                case "ambiente_datosdelaempresa":
?>
                    <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
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

    if($l_Accion=="Editar"){
?>
        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; background-color:#F4F5F5; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block;border: #D9DADA 1px solid;'>
             <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Actualizar_Clic()">Grabar</button></a>      
<?php
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
             <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Eliminar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Ocultar_Clic()">Eliminar</button></a>      
             <a class="nav-link" href="<?php echo $l_Modulo ?>.php" style='margin-left:-30px;'><button id='bt_Cancelar' type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cancelar</button></a>             
        </div>
<?php
    }

    if($l_Accion=="Consultar"){
    }

    if($l_Accion=="Imprimir"){
    }

    if($l_Accion=="Cargar"){
?>
        <div class="col-12"  style='vertical-aling:middle;display:block;font-size:14px; font-family:"Arial", Gadget, sans-serif'>
        <form method="" class="form-inline">                        
            <button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_Cargar_Clic()">Cargar</button>
            <a class="nav-link" href="<?php echo $l_Modulo ?>_grabar.php" style='width:65px;margin-right:-5px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Grabar</button></a>               
        </form>
    </div>    
<?php
    }
 
} 
?>