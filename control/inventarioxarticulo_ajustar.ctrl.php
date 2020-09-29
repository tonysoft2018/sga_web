<?php
// ----------------------------------------------------------------------------------
// inventarioxarticulo_deta_actualizar.ctrl.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { 
//                     datos[]
//                }
//              - Devuelve el resultado en JSON.
//                {
//                    retorno=>TRUE/FALSE, msg=>"MENSAJE"
//                } 
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 12/12/2019
// ----------------------------------------------------------------------------------

class ArrayValue implements JsonSerializable {
    public function __construct(array $array) {
        $this->array = $array;
    }

    public function jsonSerialize() {
        return $this->array;
    }
}

include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/inventarioxarticulo.mysql.class_v2.0.0.php"; 
include_once "../clases/inventarioxarticulo_deta.mysql.class_v2.0.0.php";  
include_once "../clases/entradas.mysql.class_v2.0.0.php"; 
include_once "../clases/salidas.mysql.class_v2.0.0.php";
include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";
include_once "../utilerias/utilerias.php";

$retorno= array();
$arreglos = array();
$datos_grabar = array();

$productos = array();

$registros_grabados=0;
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));
 
$l_NumeroDeRegistros=count($arreglos);

if($l_NumeroDeRegistros<=0){ 
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE DATOS PARA GRABAR"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
// ----------------------------------------------

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true);  
// ----------------------------------------------
 
 
// ----------------------------------------------   
// Leer la info para procesar
$tbl_Enca = new  cltbl_InventarioXArticulo_v2_0_0();
$tbl_Deta = new  cltbl_InventarioXArticulo_Deta_v2_0_0();
$tbl_Entradas = new  cltbl_Entradas_v2_0_0();
$tbl_Salidas = new  cltbl_Salidas_v2_0_0();
$tbl_Cat_Productos = new  cltbl_Cat_Productos_v2_0_0();  

$l_nIDIxA=0;
$contador=0;

$NombrePC = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$Fecha = date('Y-m-d');
$Hora = date('H:i:s');
$l_FechaModificacion=$Fecha." ".$Hora;
$l_FechaCreacion=$Fecha." ".$Hora;
$l_Observaciones="Nueva captura - Creado por  - ".$NombrePC." - ".get_current_user()." - ".$l_FechaModificacion;
$l_bEstado=0;

$l_Detalles=0;

for($i=0;$i<$l_NumeroDeRegistros;$i++){          

    // Extrae los datos      
    $l_nIDIxA=$arreglos[$i]->{"nidixa"};
    $l_nIDUsuario=$arreglos[$i]->{"nidusuario"};

    // Basicos 
     $UtileriasDatos = new clHerramientasv2011();
     $l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
     $l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);
 
    
  

     // Carga la información del encabezado
     $l_nIDCat_Almacen=0;
     $FOLIO=0;
     $l_Condicion="nIDIxA=" . $l_nIDIxA . " and bEstado=0";
     $tbl_Enca->Inicializacion();
     $tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
     $tbl_Enca->Leer($l_Condicion);
     if($tbl_Enca->CualEsElNumeroDeRegistrosCargados()>0){  
        $registros_enca=$tbl_Enca->dtBase();
        $l_nIDCat_Almacen=$registros_enca[0]["nIDCat_Almacen"];
        $FOLIO=$registros_enca[0]["Folio"];
     }

     // Carga la informacion del detalle 
     $l_Condicion="nIDIxA=" . $l_nIDIxA . " and bEstado=0";
     $tbl_Deta->Inicializacion();
     $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
     $tbl_Deta->Leer($l_Condicion);
     if($tbl_Deta->CualEsElNumeroDeRegistrosCargados()>0){

        $l_Detalles=$tbl_Deta->CualEsElNumeroDeRegistrosCargados();

        $registros_deta=$tbl_Deta->dtBase();

        for($j=0;$j<$tbl_Deta->CualEsElNumeroDeRegistrosCargados();$j=$j+1){

            $l_nIDProducto=$registros_deta[$j]["nIDProducto"];
            $l_Codigo_IZeta=$registros_deta[$j]["Codigo_IZeta"];
            $l_nIDCat_Estado=$registros_deta[$j]["nIDCat_Estado"];
            $l_Existencia=$registros_deta[$j]["Existencia"];
            $l_Conteo=$registros_deta[$j]["Conteo"];
            $l_Diferencia=$registros_deta[$j]["Diferencia"];

            // Carga la unidad de medida del producto Leido
            $l_nIDCat_UnidadDeMedida=0;
            $l_UnidadDeMedida="";
            $l_Condicion="nIDProducto=" . $l_nIDProducto . " and bEstado=0";
            $tbl_Cat_Productos->Inicializacion();
            $tbl_Cat_Productos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Cat_Productos->Leer($l_Condicion);
            if($tbl_Cat_Productos->CualEsElNumeroDeRegistrosCargados()>0){  
                $registros_producto=$tbl_Cat_Productos->dtBase();
                $l_nIDCat_UnidadDeMedida=$registros_producto[0]["nIDCat_UnidadDeMedida"];
                $l_UnidadDeMedida=$registros_producto[0]["UnidadDeMedida"];
            }

            if($l_Diferencia<0){
                // Entrada de productos por Ajuste de inventario

                //echo "Entrada";
                
                // Genera el Folio.
                $l_Folio=0;          
                $tbl_Entradas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Entradas->CargarCampos("LEER");
                $l_Folio=$tbl_Entradas->getSiguienteFolio();

                $l_Estatus="NO ACTUALIZADO"; 
                $l_TipoEntrada="AJUSTES DE INVENTARIO";     
                $l_nIDPackingList=0;
                $l_nIDCat_Proveedor=0;
                $l_Comentarios="AJUSTE:" . $FOLIO;        
                $l_NoFactura="";

                $l_Cantidad=abs($l_Diferencia);

                $datos_grabar = array();
                    
                array_push($datos_grabar,0);
                array_push($datos_grabar,$l_Folio);
                array_push($datos_grabar,$l_FechaLocal);
                array_push($datos_grabar,$l_nIDProducto);    
                array_push($datos_grabar,$l_Codigo_IZeta);
                array_push($datos_grabar,"");
                array_push($datos_grabar,$l_Cantidad);
                array_push($datos_grabar,$l_nIDCat_UnidadDeMedida);
                array_push($datos_grabar,$l_nIDUsuario);
                array_push($datos_grabar,$l_nIDCat_Almacen);
                array_push($datos_grabar,$l_Estatus);
                array_push($datos_grabar,$l_TipoEntrada);
                array_push($datos_grabar,$l_nIDIxA);
                array_push($datos_grabar,0);
                array_push($datos_grabar,$l_nIDPackingList);
                array_push($datos_grabar,$l_nIDCat_Proveedor);
                array_push($datos_grabar,$l_Comentarios);
                array_push($datos_grabar,$l_NoFactura);
     
                array_push($datos_grabar,$l_FechaLocal);
                array_push($datos_grabar,$l_FechaLocal);
                array_push($datos_grabar,$l_Observaciones);
                array_push($datos_grabar,0);
   
                $registro_datos=array($datos_grabar[0]);
                for($k=1;$k<count($datos_grabar);$k++){
                    array_push($registro_datos,$datos_grabar[$k]);
                }
                array_push($registro_datos,1); // Crear 
                array_push($registro_datos,0); // Cambiar
                array_push($registro_datos,0); // Eliminar

                $tbl_Entradas->Inicializacion();
                $tbl_Entradas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Entradas->CargarCampos("GRABAR");
                $tbl_Entradas->setInformacion_Grabar($registro_datos);
                           
                if($tbl_Entradas->Ejecutar()){
                    $registros_grabados=$registros_grabados+1;
                }   

                unset($registro_datos);
                unset($datos_grabar);

            } else {
                if($l_Diferencia>0){
                    // Salida de productos por ajuste de inventario.

                    //echo "Salida";

                    // Genera el Folio.
                    $l_Folio=0;          
                    $tbl_Salidas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                    $tbl_Salidas->CargarCampos("LEER");
                    $l_Folio=$tbl_Salidas->getSiguienteFolio();

                    $l_TipoSalida="AJUSTES DE INVENTARIO";
                    $l_Estatus="NO ACTUALIZADO";      
                   
                    $l_nIDPackingList=0;
                    $l_nIDCat_Proveedor=0;
                    $l_Comentarios="AJUSTE:" . $FOLIO;        
                    $l_NoFactura="";

                    $l_Cantidad=abs($l_Diferencia);

                    // Graba la Salida
                    $datos_grabar = array();
                    
                    array_push($datos_grabar,0);
                    array_push($datos_grabar,$l_Folio);
                    array_push($datos_grabar,$l_FechaLocal);
                    array_push($datos_grabar,$l_nIDProducto);    
                    array_push($datos_grabar,$l_Codigo_IZeta);
                    array_push($datos_grabar,"");
                    array_push($datos_grabar,$l_Cantidad);
                    array_push($datos_grabar,$l_nIDCat_UnidadDeMedida);
                    array_push($datos_grabar,$l_nIDUsuario);
                    array_push($datos_grabar,$l_nIDCat_Almacen);
                    array_push($datos_grabar,$l_Estatus);
                    array_push($datos_grabar,$l_TipoSalida);
                    array_push($datos_grabar,$l_nIDIxA);
                    array_push($datos_grabar,0);
                    array_push($datos_grabar,$l_Comentarios);

                    array_push($datos_grabar,$l_FechaLocal);
                    array_push($datos_grabar,$l_FechaLocal);
                    array_push($datos_grabar,$l_Observaciones);
                    array_push($datos_grabar,0);
   
                    $registro_datos=array($datos_grabar[0]);
                    for($k=1;$k<count($datos_grabar);$k++){
                        array_push($registro_datos,$datos_grabar[$k]);
                    }
                    array_push($registro_datos,1); // Crear 
                    array_push($registro_datos,0); // Cambiar
                    array_push($registro_datos,0); // Eliminar

                    //echo "Salida:" . $l_nIDSalidaPorOtrosConceptos;
                    //print_r($registro_datos);

                    $tbl_Salidas->Inicializacion();
                    $tbl_Salidas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                    $tbl_Salidas->CargarCampos("GRABAR");
                    $tbl_Salidas->setInformacion_Grabar($registro_datos);
               
                    if($tbl_Salidas->Ejecutar()){
                        $registros_grabados=$registros_grabados+1;
                    }  else {
                        //echo "NO grabado";
                    }

                    unset($registro_datos);
                    unset($datos_grabar);
                } else {
                    //echo "otro";
                    $registros_grabados=$registros_grabados+1;
                }
            }
        }

    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE DATOS PARA REALIZAR EL AJUSTE"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);

    }
} 
 
 
if($registros_grabados==$l_Detalles){   

    // Cambia el estatus a cerrado
     $tbl_Enca->Inicializacion();
     $tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
     $tbl_Enca->CambiarEstatus($l_nIDIxA,"CERRADO", $l_Observaciones);

    
    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>"PROCESO FINALIZADO CON EXITO"];     
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
} else {     
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE PROCESAR LOS REGISTROS"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
  
 
?> 
  