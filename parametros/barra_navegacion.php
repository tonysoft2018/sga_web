<?php
// ----------------------------------------------------------------------------------
// barra_navegacion.ctrl.php
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
?>

<!-- BARRA DE NAVEGACION -->           
 <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
     <label style='margin-top:10px; color:#fff;'>
         <?php  
             $l_Navegacion="";
             if(strlen($l_Menu)>0){
                $l_Navegacion=$l_Menu;   
             }

             if(strlen($l_SubMenu1)>0){
                 if(strlen($l_Navegacion)<=0){
                    $l_Navegacion=$l_SubMenu1;   
                 } else {
                    $l_Navegacion=$l_Navegacion . "/" . $l_SubMenu1;   
                 }                 
             }

             if(strlen($l_SubMenu1_1)>0){
                if(strlen($l_Navegacion)<=0){
                   $l_Navegacion=$l_SubMenu1_1;   
                } else {
                   $l_Navegacion=$l_Navegacion . "/" . $l_SubMenu1_1;   
                }                 
            }

            if(strlen($l_SubMenu1_1_1)>0){
                if(strlen($l_Navegacion)<=0){
                   $l_Navegacion=$l_SubMenu1_1_1;   
                } else {
                   $l_Navegacion=$l_Navegacion . "/" . $l_SubMenu1_1_1;   
                }                 
            }

            if(strlen($l_Accion)>0){
                if(strlen($l_Navegacion)<=0){
                   $l_Navegacion=$l_Accion;   
                } else {
                   $l_Navegacion=$l_Navegacion . "/" . $l_Accion;   
                }                 
            }

            echo $l_Navegacion;
         ?> 
    </label>                                                                        			  
 </div>             
<!-- FIN BARRA DE NAVEGACION -->         
          