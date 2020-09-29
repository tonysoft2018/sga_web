<?php
// ----------------------------------------------------------------------------------
// encabezado_listado_entradasxcompras.php
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

include_once "../clases/clHerramientas_v2011.php"; 
include_once "../bd/conexion.php";
 

include_once "../clases/packinglist.mysql.class_v2.0.0.php";
    $tbl = new  cltbl_Packinglist_v2_0_0();
    $tbl->Inicializacion();
    $Campo_Llave=$tbl->get_CampoLlave();
    for($h=0;$h<count($tbl->campos_listado_entradasxcompras);$h=$h+1){
       if($tbl->campos_listado_entradasxcompras[$h]!=$Campo_Llave){
?>
        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
            <label id='campo_<?php echo $tbl->campos_listado_entradasxcompras[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado_entradasxcompras[$h] ?>')"> <?php echo $tbl->campos_listado_entradasxcompras[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
        </div>
<?php
       } 
    }
?>
    <!-- ENCABEZADOS LISTADO -->

     <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
        <label style='cursor:pointer;'> Acciones
         </label>
     </div>
    <!-- FIN ENCABEZADOS LISTADO -->
          
      