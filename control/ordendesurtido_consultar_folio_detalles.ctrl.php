<?php
// ----------------------------------------------------------------------------------
// ordendesurtido_consultar_folio_detalles.ctrl.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { condicion:[info consulta], 
//                  campodeordenamiento:[campo], 
//                  formadeordenamiento:[forma], 
//                  cantidadregistros:[cantidad]
//                  tipo:[directa/general] 
//                      ** directa-> Se envia la consulta completa
//                      ** general-> Se envia el valor
//                  campos:[definidos/todos]
//                      ** definidos -> Son los que estan definidos en la clase
//                      ** todos -> Todos los campos
//                }
//              - Devuelve el resultado en JSON.  
//                {
//                    retorno=>TRUE/FALSE, msg=>"MENSAJE",[REGISTROS] 
//                } 
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 05/11/2019
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
include_once "../clases/ordendesurtido.mysql.class_v2.0.0.php"; 
include_once "../clases/ordendesurtido_deta.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";

 
$retorno= array();
$arreglos = array();
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));
 
$l_NumeroDeRegistros=count($arreglos);

 
if($l_NumeroDeRegistros<=0){ 
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE CONDICION DE CONSULTA"];
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
// Busca la orden de surtido
$tbl = new   cltbl_OrdenDeSurtido_v2_0_0();
$tbl_Deta = new   cltbl_OrdenDeSurtido_Deta_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$Campo_Llave=$tbl->get_CampoLlave();
$l_Condicion=$arreglos[0]->{"condicion"} . " and bEstado=0";

 
$tbl->Leer($l_Condicion);
if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
    $registros=$tbl->dtBase();

    $l_nIDOrdenDeSurtido=$registros[0]["nIDOrdenDeSurtido"];

    if($l_nIDOrdenDeSurtido>0){

        $l_Condicion="nIDOrdenDeSurtido=" .$l_nIDOrdenDeSurtido . " and bEstado=0";

        $tbl_Deta->Inicializacion();
        $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Deta->Leer($l_Condicion);

        if($tbl_Deta->CualEsElNumeroDeRegistrosCargados()>0){
            $registros_deta=$tbl_Deta->dtBase();
 
            $especiales=array();
            $combo=array();

            for($i=0;$i<$tbl_Deta->CualEsElNumeroDeRegistrosCargados();$i=$i+1){
                $datos=array();

                $l_nIDOrdenDeSurtido_Deta=$registros_deta[$i]["nIDOrdenDeSurtido_Deta"];
                $l_nIDProducto=$registros_deta[$i]["nIDProducto"];
                $l_Codigo_IZeta=$registros_deta[$i]["Codigo_IZeta"];
                $l_Producto=$registros_deta[$i]["Producto"];
                $l_UnidadDeMedida=$registros_deta[$i]["UnidadDeMedida"];
                $l_Cantidad=$registros_deta[$i]["Cantidad"];
 
                $datos=$datos + ["retorno"=>"TRUE"];
                $datos=$datos + ["msg"=>""];
                $datos=$datos + ["llave"=>$Campo_Llave];

                $datos=$datos + ["nIDOrdenDeSurtido_Deta"=>$l_nIDOrdenDeSurtido_Deta];
                $datos=$datos + ["nIDOrdenDeSurtido"=>$l_nIDOrdenDeSurtido];

                $datos=$datos + ["nIDProducto"=>$l_nIDProducto];
                $datos=$datos + ["Codigo_IZeta"=>$l_Codigo_IZeta ];
                $datos=$datos + ["Producto"=>$l_Producto];
                $datos=$datos + ["UnidadDeMedida"=>$l_UnidadDeMedida];                
                $datos=$datos + ["Cantidad"=>$l_Cantidad];

                $l_nIDOrdenDeSurtido_Deta=0;
                $l_nIDProducto=0;
                $l_Codigo_IZeta="";
                $l_Producto="";
                $l_UnidadDeMedida="";
                $l_Cantidad=0;
                 
                array_push($retorno,$datos);   
                
            }
            
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            
        } else {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ORDEN DE SURTIDO NO ENCONTRADA"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
        }

    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"ORDEN DE SURTIDO NO ENCONTRADA"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
    }
} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"ORDEN DE SURTIDO NO ENCONTRADA"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
}

?> 
  