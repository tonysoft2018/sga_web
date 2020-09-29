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

include_once "../clases/clHerramientas_v2011.php"; 
include_once "../bd/conexion.php";
 
/*
if($l_Accion=="Listado"){

 

    switch($l_Menu){
        // Interfaces                                
        case "Interfaces":
            include_once "../clases/interfaces.mysql.class_v2.0.0.php";   
            $tbl = new  cltbl_Interfaces_v2_0_0();
            $tbl->Inicializacion();
            $Campo_Llave=$tbl->get_CampoLlave();
            for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                if($tbl->campos_listado[$h]!=$Campo_Llave){
    ?>
                    <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                        <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
    <?php
            break;  
    }


    switch($l_SubMenu1){
// Catalogos


         case "Centros de Servicio":
            
                include_once "../clases/cat_centrosdeservicio.mysql.class_v2.0.0.php"; 
                $tbl = new  cltbl_Cat_CentrosDeServicio_v2_0_0();
                $tbl->Inicializacion();
                $Campo_Llave=$tbl->get_CampoLlave();
                for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                   if($tbl->campos_listado[$h]!=$Campo_Llave){
    ?>
                    <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                        <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
    
    <?php
                 break;

         case "Empresas":
            
                    include_once "../clases/cat_empresas.mysql.class_v2.0.0.php"; 
                    $tbl = new  cltbl_Cat_Empresas_v2_0_0();
                    $tbl->Inicializacion();
                    $Campo_Llave=$tbl->get_CampoLlave();
                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                       if($tbl->campos_listado[$h]!=$Campo_Llave){
        ?>
                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
        
        <?php
                     break;

         case "Almacen":
            
                        include_once "../clases/cat_almacen.mysql.class_v2.0.0.php"; 
                        $tbl = new  cltbl_Cat_Almacen_v2_0_0();
                        $tbl->Inicializacion();
                        $Campo_Llave=$tbl->get_CampoLlave();
                        for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                           if($tbl->campos_listado[$h]!=$Campo_Llave){
            ?>
                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
            
            <?php
                         break;

           case "Racks":
            
                            include_once "../clases/cat_racks.mysql.class_v2.0.0.php"; 
                            $tbl = new  cltbl_Cat_Racks_v2_0_0();
                            $tbl->Inicializacion();
                            $Campo_Llave=$tbl->get_CampoLlave();
                            for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                               if($tbl->campos_listado[$h]!=$Campo_Llave){
                ?>
                                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                    <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                
                <?php
                             break;

             case "Pasillos":
            
                                include_once "../clases/cat_pasillos.mysql.class_v2.0.0.php"; 
                                $tbl = new  cltbl_Cat_Pasillos_v2_0_0();
                                $tbl->Inicializacion();
                                $Campo_Llave=$tbl->get_CampoLlave();
                                for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                   if($tbl->campos_listado[$h]!=$Campo_Llave){
                    ?>
                                    <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                    
                    <?php
                                 break;


             case "Matriz de Ubicaciones":
 
                                    include_once "../clases/cat_matriz.mysql.class_v2.0.0.php"; 
                                    $tbl = new  cltbl_Cat_Matriz_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        
                        <?php
                                     break;

             case "Productos":
 
                                    include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
                                    $tbl = new  cltbl_Cat_Productos_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        
                        <?php
                                     break;


             case "Clasificacion de Productos":
               
                                 switch($l_SubMenu1_1){
                                     case "Tipos":
                                        include_once "../clases/cat_tipos.mysql.class_v2.0.0.php"; 
                                        $tbl = new  cltbl_Cat_Tipos_v2_0_0();
                                        $tbl->Inicializacion();
                                        $Campo_Llave=$tbl->get_CampoLlave();
                                        for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                           if($tbl->campos_listado[$h]!=$Campo_Llave){
                            ?>
                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                            
                            <?php
                                         break;

                                     case "SubTipos":
                                            include_once "../clases/cat_subtipos.mysql.class_v2.0.0.php"; 
                                            $tbl = new  cltbl_Cat_SubTipos_v2_0_0();
                                            $tbl->Inicializacion();
                                            $Campo_Llave=$tbl->get_CampoLlave();
                                            for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                               if($tbl->campos_listado[$h]!=$Campo_Llave){
                                ?>
                                                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                    <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                                
                                <?php
                                             break;
    
                                     case "Familias":
                                        
                                                include_once "../clases/cat_familias.mysql.class_v2.0.0.php"; 
                                                $tbl = new  cltbl_Cat_Familias_v2_0_0();
                                                
                                                $tbl->Inicializacion();
                                                $Campo_Llave=$tbl->get_CampoLlave();
                                                for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                                   if($tbl->campos_listado[$h]!=$Campo_Llave){
                                    ?>
                                                    <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                        <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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

                                                
                                    
                                    <?php
                                    echo "Entre";
                                                 break;

                                     case "Presentaciones":
                                                    include_once "../clases/cat_presentaciones.mysql.class_v2.0.0.php"; 
                                                    $tbl = new  cltbl_Cat_Presentaciones_v2_0_0();
                                                    $tbl->Inicializacion();
                                                    $Campo_Llave=$tbl->get_CampoLlave();
                                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                                        ?>
                                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                                        
                                        <?php
                                                     break;

                                      case "Excepciones":
                                                        include_once "../clases/cat_excepciones.mysql.class_v2.0.0.php"; 
                                                        $tbl = new  cltbl_Cat_Excepciones_v2_0_0();
                                                        $tbl->Inicializacion();
                                                        $Campo_Llave=$tbl->get_CampoLlave();
                                                        for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                                           if($tbl->campos_listado[$h]!=$Campo_Llave){
                                            ?>
                                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                                            
                                            <?php
                                                         break;

                                     case "Unidades de Medida":
                                                        include_once "../clases/cat_unidadesdemedida.mysql.class_v2.0.0.php"; 
                                                        $tbl = new  cltbl_Cat_UnidadesDeMedida_v2_0_0();
                                                        $tbl->Inicializacion();
                                                        $Campo_Llave=$tbl->get_CampoLlave();
                                                        for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                                           if($tbl->campos_listado[$h]!=$Campo_Llave){
                                            ?>
                                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                                            
                                            <?php
                                                         break;



                                 }
                                 break;
            
             case "Estados":
            
                                    include_once "../clases/cat_estados.mysql.class_v2.0.0.php"; 
                                    $tbl = new  cltbl_Cat_Estados_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        
                        <?php
                                     break;                   

            case "Motivos de Traspasos":            
                                    include_once "../clases/cat_motivostraspaso.mysql.class_v2.0.0.php"; 
                                    $tbl = new  cltbl_Cat_MotivosTraspaso_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        
                        <?php
                                     break;                  
                                     
            case "Conceptos Operativos de Entrada":            
                                    include_once "../clases/cat_conceptosentrada.mysql.class_v2.0.0.php"; 
                                    $tbl = new  cltbl_Cat_ConceptosEntrada_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        
                        <?php
                                     break;                                             
            case "Conceptos Operativos de Salida":            
                                    include_once "../clases/cat_conceptossalida.mysql.class_v2.0.0.php"; 
                                    $tbl = new  cltbl_Cat_ConceptosSalida_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        
                        <?php
                                     break;             

            case "Proveedores":            
                                    include_once "../clases/cat_proveedores.mysql.class_v2.0.0.php";
                                    $tbl = new  cltbl_Cat_Proveedores_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        
                        <?php
                                     break;     
                                     
                 case "Clientes":            
                                    include_once "../clases/cat_clientes.mysql.class_v2.0.0.php";
                                    $tbl = new  cltbl_Cat_Clientes_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        
                        <?php
                                     break;  
                 // ----RECIBO
                 case "Importacion":            
                                    include_once "../clases/packinglist.mysql.class_v2.0.0.php";
                                    $tbl = new  cltbl_Packinglist_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        
                        <?php
                                     break;                    


                case "Recibo":            
                                        include_once "../clases/packinglist.mysql.class_v2.0.0.php";
                                        $tbl = new  cltbl_Packinglist_v2_0_0();
                                        $tbl->Inicializacion();
                                        $Campo_Llave=$tbl->get_CampoLlave();
                                        for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                           if($tbl->campos_listado[$h]!=$Campo_Llave){
                            ?>
                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                            
                            <?php
                                         break;      
                                         
                // ----INVENTARIOS
                case "Entradas de Productos por Compras":            
                                        include_once "../clases/packinglist.mysql.class_v2.0.0.php";
                                        $tbl = new  cltbl_Packinglist_v2_0_0();
                                        $tbl->Inicializacion();
                                        $Campo_Llave=$tbl->get_CampoLlave();
                                        for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                           if($tbl->campos_listado[$h]!=$Campo_Llave){
                            ?>
                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                            
                            <?php
                                         break;          
                                         
                 case "Entradas Por Otros Conceptos":            
                                        include_once "../clases/entradasporotrosconceptos.mysql.class_v2.0.0.php";
                                        $tbl = new cltbl_EntradaPorOtrosConceptos_v2_0_0();
                                        $tbl->Inicializacion();
                                        $Campo_Llave=$tbl->get_CampoLlave();
                                        for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                           if($tbl->campos_listado[$h]!=$Campo_Llave){
                            ?>
                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                            
                            <?php
                                         break;        
                                         
                case "Salidas Por Otros Conceptos":            
                                        include_once "../clases/salidasporotrosconceptos.mysql.class_v2.0.0.php";
                                        $tbl = new cltbl_SalidasPorOtrosConceptos_v2_0_0();
                                        $tbl->Inicializacion();
                                        $Campo_Llave=$tbl->get_CampoLlave();
                                        for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                           if($tbl->campos_listado[$h]!=$Campo_Llave){
                            ?>
                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                            
                            <?php
                                         break;    
                                         
                                         


                                         
                // ----TRASPASOS
                case "Orden de Surtido":            
                                        include_once "../clases/ordendesurtido.mysql.class_v2.0.0.php";
                                        $tbl = new cltbl_OrdenDeSurtido_v2_0_0();
                                        $tbl->Inicializacion();
                                        $Campo_Llave=$tbl->get_CampoLlave();
                                        for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                           if($tbl->campos_listado[$h]!=$Campo_Llave){
                            ?>
                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                            
                            <?php
                                         break;            
                   case "Traspasos de Envio":            
                                        include_once "../clases/traspasos.mysql.class_v2.0.0.php";
                                        $tbl = new cltbl_Traspasos_v2_0_0();
                                        $tbl->Inicializacion();
                                        $Campo_Llave=$tbl->get_CampoLlave();
                                        for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                           if($tbl->campos_listado[$h]!=$Campo_Llave){
                            ?>
                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                            
                            <?php
                                         break;                
                                         


                    case "Traspasos de Recepcion":            
                                        include_once "../clases/traspasos.mysql.class_v2.0.0.php";
                                        $tbl = new cltbl_Traspasos_v2_0_0();
                                        $tbl->Inicializacion();
                                        $Campo_Llave=$tbl->get_CampoLlave();
                                        for($h=0;$h<count($tbl->campos_listado_ordenesdesurtido);$h=$h+1){
                                           if($tbl->campos_listado_ordenesdesurtido[$h]!=$Campo_Llave){
                            ?>
                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label id='campo_<?php echo $tbl->campos_listado_ordenesdesurtido[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado_ordenesdesurtido[$h] ?>')"> <?php echo $tbl->campos_listado_ordenesdesurtido[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                            
                            <?php
                                         break;                



                case "Modulos":            
                                    include_once "../clases/ambiente_modulos.mysql.class_v2.0.0.php"; 
                                    $tbl = new  cltbl_Ambiente_Modulos_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        
                        <?php
                                     break;     
                                     
                case "Clasificaciones":            
                                    include_once "../clases/ambiente_clasificaciones.mysql.class_v2.0.0.php"; 
                                    $tbl = new  cltbl_Ambiente_Clasificaciones_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                       if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        
                        <?php
                                     break;  
                                     
                // Seguridad                                     
                 case "Usuarios":
                                    include_once "../clases/usuarios.mysql.class_v2.0.0.php"; 
                                    $tbl = new  cltbl_Usuarios_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                        if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        <?php
                                    break;  

                case "Perfiles":             
                                    include_once "../clases/usuarios.mysql.class_v2.0.0.php"; 
                                    $tbl = new  cltbl_Usuarios_v2_0_0();
                                    $tbl->Inicializacion();
                                    $Campo_Llave=$tbl->get_CampoLlave();
                                    for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                        if($tbl->campos_listado[$h]!=$Campo_Llave){
                        ?>
                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> <?php echo $tbl->campos_listado[$h] ?>  <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> </label>
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
                        <?php
                                    break;  

               

        }
}  


*/


if($l_Accion=="Listado"){
  
     switch($l_Modulo){
    
          case "cat_empresas":
                include_once "../clases/cat_empresas.mysql.class_v2.0.0.php"; 
                $tbl = new  cltbl_Cat_Empresas_v2_0_0();
                $tbl->Inicializacion();
                $Campo_Llave=$tbl->get_CampoLlave();

                $columnas=count($tbl->campos_listado);
                $columnas=$columnas/12;

?>            
                <div class="table-responsive text-nowrap table-hover  " style='margin-left:-10px; width:103%'>	                            
                     <table class="table">
                         <thead>
                                    <tr>
<?php
                            for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                                if($tbl->campos_listado[$h]!=$Campo_Llave){
?>
                                        <th class="th-sm" style='background-color:#F4F5F5;font-size:10px; font-family:"Arial Black'> 
                                            <label id='campo_<?php echo $tbl->campos_listado[$h] ?>'  onclick="fn_Listado_Ordenar_Clic('<?php echo $tbl->campos_listado[$h] ?>')"> 
                                                <?php echo $tbl->campos_listado[$h] ?>   
                                                <img src="../iconos/updown.png" style="width: 10px; height: 10px; margin-left:2px;"> 
                                            </label>
                                        </th>                          
<?php
                                    } 
                                }
?>
                                <!-- ENCABEZADOS LISTADO -->
             
                                <th scope="col" style='background-color:#F4F5F5;font-size:10px; font-family:"Arial Black'> 
                                    <label style='cursor:pointer;'> Acciones </label>
                                </th>
                                <!-- FIN ENCABEZADOS LISTADO -->
                            </tr>
                         </thead>                    
                     </table>    
                </div>
        
              
            
<?php
                          
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
      
                        break;                    
                 }
    
        }   
?>