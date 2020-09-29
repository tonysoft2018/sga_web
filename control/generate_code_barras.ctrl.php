<?php 
// ----------------------------------------------------------------------------------
// generate_code.ctrl.php
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

// Constantes
$l_Calidad="H";
$l_Tamaxo="1000";

$retorno= array();
$arreglos = array();
$info = array();
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));
 
$l_NumeroDeRegistros=count($arreglos);
$l_Archivo="";
 
if($l_NumeroDeRegistros<=0){ 
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE REGISTROS"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}  

include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php"; 
include_once "../clases/productos_series.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true);  
// ----------------------------------------------

$l_nIDPackingList_Deta=$arreglos[0]->{"id"};

if($l_nIDPackingList_Deta<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE ID DETALLE DEL PACKINGLIST"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}

// Carga los datos del packinglist
$l_CodigoQR="";
$l_Condicion="nIDPackingList_Deta=" . $l_nIDPackingList_Deta ." and bEstado=0";
$tbl_Deta = new  cltbl_Packinglist_Deta_v2_0_0();
$tbl_Deta->Inicializacion();
$tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_Deta->Leer($l_Condicion);
if($tbl_Deta->CualEsElNumeroDeRegistrosCargados()>0){
    $registros=$tbl_Deta->dtBase();
  
    $l_nIDPackingList=$registros[0]["nIDPackingList"];
    $l_nIDProducto=$registros[0]["nIDProducto"];        
    $l_Descripcion=$registros[0]["Descripcion"];
    $l_Cantidad=$registros[0]["Cantidad"];

    if($l_nIDPackingList>0 && $l_nIDProducto>0 ){
        $l_Condicion="nIDProducto=" . $l_nIDProducto . " and nIDPackingList=" . $l_nIDPackingList; 
       
        $tbl_Cat_Productos_Serie = new  cltbl_Cat_Productos_Series_v2_0_0();
        $tbl_Cat_Productos_Serie->Inicializacion();
        $tbl_Cat_Productos_Serie->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Cat_Productos_Serie->Leer($l_Condicion);
        if($tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados()>0){
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
            $datos=$datos + ["msg"=>"NO TIENE SERIALES DADOS DE ALTA"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        }
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE CODIGOS PARA IMPRIMIR"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);

    }
 
} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO EXISTE EL ID DEL DETALLE"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
} 
?>