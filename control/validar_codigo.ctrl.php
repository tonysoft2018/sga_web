<?php
// ----------------------------------------------------------------------------------
// validar_codigo.ctrl.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion.  Oculta la información de registros.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { 
//                     nid:[info], estado:[info]
//                }
//              - Devuelve el resultado en JSON.
//                {
//                    retorno=>TRUE/FALSE, msg=>"MENSAJE"
//                } 
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 06/11/2019
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
include_once "../clases/packinglist.mysql.class_v2.0.0.php";    
include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php";
include_once "../clases/productos_series.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";

$retorno= array();
$arreglos = array();

$registros_grabados=0;
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));
 
$l_NumeroDeRegistros=count($arreglos);

if($l_NumeroDeRegistros<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE INFORMACION PARA PROCESAR"];
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
$tbl_Enca = new   cltbl_Packinglist_v2_0_0(); 
$tbl_Cat_Productos_Serie = new  cltbl_Cat_Productos_Series_v2_0_0();

// La serie esta compuesta por nIDPackingList/nIDProducto/Serie

for($i=0;$i<$l_NumeroDeRegistros;$i++){
    $l_nIDPackingList=trim($arreglos[$i]->{"nid"});     
    $l_Codigo=trim($arreglos[$i]->{"codigo"});

    
 
    // Validación  
    if(strlen($l_Codigo)<=0){ 
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"CODIGO DE BARRAS INVALIDO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

    // Extrae el codigo
    $pos=strpos($l_Codigo,",");
    
    if($pos>0){         
        $l_Codigo=substr($l_Codigo,0,$pos);
    }


  if(strlen($l_Codigo)<=0){ 
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"CODIGO DE BARRAS INVALIDO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }
 

    // 106/12982/Z7161-1
    // Valida el serial
    //echo $l_nIDPackingList_Codigo . " " . $l_nIDProducto_Codigo . " " . $l_Serie_Codigo;
    $tbl_Cat_Productos_Serie->Inicializacion();
    $tbl_Cat_Productos_Serie->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Cat_Productos_Serie->Leer("nIDPackingList=" . $l_nIDPackingList . " and Serie='" . $l_Codigo . "'");
    if($tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados()>0){
        $registros=$tbl_Cat_Productos_Serie->dtBase();
        $l_nIDProducto_Serie=$registros[0]["nIDProducto_Serie"];
        $l_nIDProducto_Codigo=$registros[0]["nIDProducto"];

        if($l_nIDProducto_Serie>0 && $l_nIDProducto_Codigo>0){

            // Busca el id del detalle del packing list 
            $l_Condicion="nIDPackingList=" .$l_nIDPackingList ." and bEstado=0 and nIDProducto=" . $l_nIDProducto_Codigo;
            $tbl_Deta = new  cltbl_Packinglist_Deta_v2_0_0();
            $tbl_Deta->Inicializacion();
            $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Deta->Leer($l_Condicion);
            if($tbl_Deta->CualEsElNumeroDeRegistrosCargados()>0){
                 
                $registros_deta=$tbl_Deta->dtBase();
                $l_nIDPackingList_Deta=$registros_deta[0]["nIDPackingList_Deta"];

                if($l_nIDPackingList_Deta>0){

                    $datos=array();
                    $datos=$datos + ["retorno"=>"TRUE"];
                    $datos=$datos + ["msg"=>"PROCESO FINALIZADO CON EXITO"];
                    $datos=$datos + ["nidpackinglist_deta"=>$l_nIDPackingList_Deta];
                    $datos=$datos + ["nidproducto_serie"=>$l_nIDProducto_Serie];
                    $datos=$datos + ["nidproducto"=>$l_nIDProducto_Codigo];
                    $datos=$datos + ["serie"=>$l_Codigo];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno;    
                    exit(1);

                } else {

                    $datos=array();
                    $datos=$datos + ["retorno"=>"FALSE"];
                    $datos=$datos + ["msg"=>"CODIGO NO EXISTE EN EL PACKING LIST"];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno;    
                    exit(1);

                }
            } else {
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"CODIGO NO EXISTE EN EL PACKING LIST"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }
        } else {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"CODIGO DE BARRAS INEXISTENTE"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        }
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"CODIGO DE BARRAS INEXISTENTE"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

} 
?> 
  