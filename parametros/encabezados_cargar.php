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

 

if($l_Accion=="Cargar"){
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
         case "Empresas":
            
                    include_once "../clases/cat_empresas.mysql.class_v2.0.0.php"; 
                    $tbl = new  cltbl_Cat_Empresas_v2_0_0();
                    $tbl->Inicializacion();
                    $Campo_Llave=$tbl->get_CampoLlave();
                    for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                       if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
        ?>
                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                            <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                        </div>
        <?php
                       } 
                    }
        ?>
                    <!-- ENCABEZADOS LISTADO -->
         
                     <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                        <label style='cursor:pointer;'> Estatus
                         </label>
                     </div>
                    <!-- FIN ENCABEZADOS LISTADO -->
        
        <?php
               break;

         case "Centros de Servicio":
            
                include_once "../clases/cat_centrosdeservicio.mysql.class_v2.0.0.php"; 
                $tbl = new  cltbl_Cat_CentrosDeServicio_v2_0_0();
                $tbl->Inicializacion();
                $Campo_Llave=$tbl->get_CampoLlave();
                for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                   if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
    ?>
                    <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                        <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                    </div>
    <?php
                   } 
                }
    ?>
                <!-- ENCABEZADOS LISTADO -->
     
                 <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                    <label style='cursor:pointer;'> Estatus
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
                        for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                           if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
            ?>
                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                            </div>
            <?php
                           } 
                        }
            ?>
                        <!-- ENCABEZADOS LISTADO -->
             
                         <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                            <label style='cursor:pointer;'> Estatus
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
                            for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                               if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                ?>
                                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                    <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                </div>
                <?php
                               } 
                            }
                ?>
                            <!-- ENCABEZADOS LISTADO -->
                 
                             <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                <label style='cursor:pointer;'> Estatus
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
                                for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                   if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                    ?>
                                    <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                    </div>
                    <?php
                                   } 
                                }
                    ?>
                                <!-- ENCABEZADOS LISTADO -->
                     
                                 <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                    <label style='cursor:pointer;'> Estatus
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
                                    for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                       if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                        ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                        </div>
                        <?php
                                       } 
                                    }
                        ?>
                                    <!-- ENCABEZADOS LISTADO -->
                         
                                     <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label style='cursor:pointer;'> Estatus
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
                                        for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                           if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                            ?>
                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                            </div>
                            <?php
                                           } 
                                        }
                            ?>
                                        <!-- ENCABEZADOS LISTADO -->
                             
                                         <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label style='cursor:pointer;'> Estatus
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
                                            for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                               if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                                ?>
                                                <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                    <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                                </div>
                                <?php
                                               } 
                                            }
                                ?>
                                            <!-- ENCABEZADOS LISTADO -->
                                 
                                             <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                <label style='cursor:pointer;'> Estatus
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
                                                for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                                   if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                                    ?>
                                                    <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                        <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                                    </div>
                                    <?php
                                                   } 
                                                }
                                    ?>
                                                <!-- ENCABEZADOS LISTADO -->
                                     
                                                 <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                    <label style='cursor:pointer;'> Estatus
                                                     </label>
                                                 </div>
                                                <!-- FIN ENCABEZADOS LISTADO -->
                                    
                                    <?php
                                                 break;

                                     case "Presentaciones":
                                                include_once "../clases/cat_presentaciones.mysql.class_v2.0.0.php"; 
                                                $tbl = new  cltbl_Cat_Presentaciones_v2_0_0();
                                                $tbl->Inicializacion();
                                                $Campo_Llave=$tbl->get_CampoLlave();
                                                for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                                   if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                                        ?>
                                                    <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                        <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                                    </div>
                                        <?php
                                                   } 
                                                }
                                        ?>
                                                <!-- ENCABEZADOS LISTADO -->                                         
                                                <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                    <label style='cursor:pointer;'> Estatus
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
                                                        for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                                           if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                                                ?>
                                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                                <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                                            </div>
                                                <?php
                                                           } 
                                                        }
                                                ?>
                                                        <!-- ENCABEZADOS LISTADO -->                                         
                                                        <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                            <label style='cursor:pointer;'> Estatus
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
                                                        for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                                           if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                                                ?>
                                                            <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                                <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                                            </div>
                                                <?php
                                                           } 
                                                        }
                                                ?>
                                                        <!-- ENCABEZADOS LISTADO -->                                         
                                                        <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                                            <label style='cursor:pointer;'> Estatus
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
                                    for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                       if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                            ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                        </div>
                            <?php
                                       } 
                                    }
                            ?>
                                    <!-- ENCABEZADOS LISTADO -->                                         
                                    <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label style='cursor:pointer;'> Estatus
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
                                    for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                       if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                            ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                        </div>
                            <?php
                                       } 
                                    }
                            ?>
                                    <!-- ENCABEZADOS LISTADO -->                                         
                                    <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label style='cursor:pointer;'> Estatus
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
                                    for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                       if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                            ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                        </div>
                            <?php
                                       } 
                                    }
                            ?>
                                    <!-- ENCABEZADOS LISTADO -->                                         
                                    <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label style='cursor:pointer;'> Estatus
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
                                    for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                       if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                            ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                        </div>
                            <?php
                                       } 
                                    }
                            ?>
                                    <!-- ENCABEZADOS LISTADO -->                                         
                                    <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label style='cursor:pointer;'> Estatus
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
                                    for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                       if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                            ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                        </div>
                            <?php
                                       } 
                                    }
                            ?>
                                    <!-- ENCABEZADOS LISTADO -->                                         
                                    <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label style='cursor:pointer;'> Estatus
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
                                    for($h=0;$h<count($tbl->campos_listado_importacion);$h=$h+1){
                                       if($tbl->campos_listado_importacion[$h]!=$Campo_Llave){
                            ?>
                                        <div class="col d-flex justify-content-left align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                            <label id='campo_<?php echo $tbl->campos_listado_importacion[$h] ?>'> <?php echo $tbl->campos_listado_importacion[$h] ?> </label>
                                        </div>
                            <?php
                                       } 
                                    }
                            ?>
                                    <!-- ENCABEZADOS LISTADO -->                                         
                                    <div class="col d-flex justify-content-center align-items-center" style='text-align:center; font-size:10px; font-family:"Arial black", Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>
                                        <label style='cursor:pointer;'> Estatus
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
} else {
    if($l_Accion=="Crear"){
        switch($l_SubMenu1){
            case "Usuarios":


                        break;
        }
    }

    if($l_Accion=="Editar"){
    }

    if($l_Accion=="Eliminar"){
    }

    if($l_Accion=="Consultar"){
    }

    if($l_Accion=="Imprimir"){
    }

}
?>
         
      