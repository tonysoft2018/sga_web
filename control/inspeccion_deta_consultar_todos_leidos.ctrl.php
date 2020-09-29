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
include_once "../clases/inspeccion.mysql.class_v2.0.0.php"; 
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
$tbl_inspeccion = new  cltbl_Inspeccion_v2_0_0();
 
// La serie esta compuesta por nIDPackingList/nIDProducto/Serie
for($i=0;$i<$l_NumeroDeRegistros;$i++){
    $l_nIDPackingList=trim($arreglos[$i]->{"nidpackinglist"}); 
    $l_nIDPackingList_Deta=trim($arreglos[$i]->{"nidpackinglist_deta"}); 

    $tbl_inspeccion->Inicializacion();
    $tbl_inspeccion->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_inspeccion->Leer("nIDPackingList=" . $l_nIDPackingList . " and bEstado=0 and nIDPackingList_Deta=" .$l_nIDPackingList_Deta);
    if($tbl_inspeccion->CualEsElNumeroDeRegistrosCargados()>0){

        $registros=$tbl_inspeccion->dtBase();

        for($j=0;$j<$tbl_inspeccion->CualEsElNumeroDeRegistrosCargados();$j=$j+1){
            $l_nIDInspeccion=$registros[$j]["nIDInspeccion"];
            $l_nIDPackingList_Deta=$registros[$j]["nIDPackingList_Deta"];
            $l_nIDPackingList=$registros[$j]["nIDPackingList"];
            $l_nIDProducto=$registros[$j]["nIDProducto"];
            $l_CodigoDeBarras=$registros[$j]["CodigoDeBarras"];
            $l_nIDProducto_Serie=$registros[$j]["nIDProducto_Serie"];
            $l_Serie=$registros[$j]["Serie"];
            $l_nIDCat_Estado=$registros[$j]["nIDCat_Estado"];
            $l_Estado=$registros[$j]["Estado"];
            $l_nIDUsuario=$registros[$j]["nIDUsuario"];

            $datos=array();
            $datos=$datos + ["retorno"=>"TRUE"];
            $datos=$datos + ["msg"=>""];
            $datos=$datos + ["nidinspeccion"=>$l_nIDInspeccion];
            $datos=$datos + ["nidpackinglist_deta"=>$l_nIDPackingList_Deta];
            $datos=$datos + ["nidpackingList"=>$l_nIDPackingList];
            $datos=$datos + ["nidproducto"=>$l_nIDProducto];
            $datos=$datos + ["codigodebarras"=>$l_CodigoDeBarras];
            $datos=$datos + ["nidproducto_serie"=>$l_nIDProducto_Serie];     
            $datos=$datos + ["serie"=>$l_Serie];     
            $datos=$datos + ["nidcat_estado"=>$l_nIDCat_Estado];    
            $datos=$datos + ["nidusuario"=>$l_nIDUsuario];     
            $datos=$datos + ["estado"=>$l_Estado];   
            array_push($retorno,$datos);  
            unset($datos);  
        }
 
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE INFORMACION PARA PROCESAR"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }
     
}

$retorno=json_encode($retorno);	 
echo $retorno;    
exit(1);


?> 
  