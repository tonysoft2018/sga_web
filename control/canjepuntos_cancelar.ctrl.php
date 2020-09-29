<?php
// ----------------------------------------------------------------------------------
// canjes_canclear.ctrl.php
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
// Empresa. IDEATECH
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 20/08/2020
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
include_once "../clases/canjes_enca.mysql.class_v2.0.0.php"; 
include_once "../clases/canjes_deta.mysql.class_v2.0.0.php"; 
include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
include_once "../clases/entradas.mysql.class_v2.0.0.php";
include_once "../clases/salidas.mysql.class_v2.0.0.php";  
include_once "../clases/cat_clientes.mysql.class_v2.0.0.php";  
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

/*
    {"nid":l_nID, "estado":2}
*/

$tbl_Enca = new  cltbl_Canjes_v2_0_0();
$tbl_Deta = new  cltbl_Canjes_Deta_v2_0_0();
$tbl_Cat_Produtos = new  cltbl_Cat_Productos_v2_0_0();
$tbl_Entradas = new  cltbl_Entradas_v2_0_0();
$tbl_Salidas = new  cltbl_Salidas_v2_0_0();
$tbl_Cat_Clientes = new  cltbl_Cat_Clientes_v2_0_0();

$i=0;
$l_nIDEnca=trim($arreglos[$i]->{"nid"});
$l_Estado=2;
 

// ---------------------------------------------------------------------------------------------------
// Verificación
if(strlen($l_nIDEnca)<=0){        
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALTAN ID DEL ENCABEZADO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);       
} 
 
// ---------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------
if(strlen($l_nIDEnca)>0){        
    if(!is_int($l_nIDEnca)) {
        $l_nIDEnca=intval($l_nIDEnca);
       
        if($l_nIDEnca<=0){
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ID DEL ENCABEZADO ES INVALIDO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        }
    }                                 
}  
  
// ---------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------
// BASICOS
 $UtileriasDatos = new clHerramientasv2011();
 $l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
 $l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);


 $NombrePC = gethostbyaddr($_SERVER['REMOTE_ADDR']);
 $Fecha = date('Y-m-d');
 $Hora = date('H:i:s');
 $l_FechaModificacion=$Fecha." ".$Hora;
 $l_FechaCreacion=$Fecha." ".$Hora;
 $l_Observaciones="Nueva captura - Creado por  - ".$NombrePC." - ".get_current_user()." - ".$l_FechaModificacion;
 $l_bEstado=0;
// ---------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------
// FOLIO
$tbl_Enca->Inicializacion();
$tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
if($tbl_Enca->CambiarEstado($l_nIDEnca, $l_Observaciones, $l_Estado)){

    // Salidas
    $l_Condicion="TipoSalida='CANJES' and nIDReferencia=" . $l_nIDEnca;
    $tbl_Salidas->Inicializacion();
    $tbl_Salidas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Salidas->EliminarConCondicion($l_Condicion);

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
    $datos=$datos + ["msg"=>"FALLA EN LA CANCELACIÓN"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
  
?> 
  