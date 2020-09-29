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
   
switch($l_Modulo){
    case "ambiente_interfaces":
?>
        <div class='row align-item-end h-20 align-items-center'  style='cursor:pointer;'>
            <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                <a class="nav-link" href="#" style='margin-left:-30px;'><button id='bt_Grabar' type="button" class="btn btn-warning" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_AbrirExito()">Grabar</button></a>
                <a class="nav-link" href="app_listado.php" style='margin-left:-30px;'><button id='bt_Regresar' type="button" class="btn btn-warning" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;' onclick="fn_AbrirFalla()" >Regresar</button></a>                                                                                                  			  
            </div>
        </div>
<?php
        break;
    default:

}   
?>