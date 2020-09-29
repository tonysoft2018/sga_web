<?php
// ----------------------------------------------------------------------------------
// traspasos_grabar_lectura.ctrl.php
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
include_once "../clases/traspasos.mysql.class_v2.0.0.php";    
include_once "../clases/ordendesurtido.mysql.class_v2.0.0.php";    
include_once "../bd/conexion.php";
 
$retorno= array();
$arreglos = array();

// Basicos
$NombrePC = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$UtileriasDatos = new clHerramientasv2011();
$l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
$l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);
$Fecha = date('Y-m-d');
$Hora = date('H:i:s');
$l_FechaModificacion=$Fecha." ".$Hora;
$l_FechaCreacion=$Fecha." ".$Hora;
$l_Observaciones="Nueva captura - Creado por  - ".$NombrePC." - ".get_current_user()." - ".$l_FechaModificacion;
$l_bEstado=0;
 
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
// Leer la info para procesar 
$tbl = new  cltbl_Traspasos_v2_0_0();   
$tbl_OrdenDeSurtido = new  cltbl_OrdenDeSurtido_v2_0_0();
$l_Contador=0;

$l_nIDOrdenDeSurtido=$arreglos[0]->{"nidordendesurtido"};
if($l_nIDOrdenDeSurtido<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NECESITA SELECCIONAR LA ORDEN DE SURTIDO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;   
    exit(1);  
}

 
// ***********************************************************
// Busca la orden de surtido
$l_Contador=0;
$l_Condicion="nIDOrdenDeSurtido=" . $l_nIDOrdenDeSurtido . " and Estatus='ABIERTO'";
$l_nIDTraspaso=0;
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->Leer($l_Condicion); 
if($tbl->CualEsElNumeroDeRegistrosCargados()>0){        
    $registros=$tbl->dtBase();
    $l_nIDTraspaso=$registros[0]["nIDTraspaso"];

    if($l_nIDTraspaso<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NECESITA SELECCIONAR EL TRASPASO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1);  
        
    }
}
// ***********************************************************

 
// ***********************************************************
// Cancela el traspaso
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CambiarEstatus($l_nIDTraspaso, "CERRADO", $l_Observaciones);
// ***********************************************************

// ***********************************************************
// Cancela la orden de sutrido
$tbl_OrdenDeSurtido->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]); 
$tbl_OrdenDeSurtido->CambiarEstatus($l_nIDOrdenDeSurtido, "ORDEN - EN EMBARQUE", $l_Observaciones);
// ***********************************************************
 
$datos=array();
$datos=$datos + ["retorno"=>"TRUE"];
$datos=$datos + ["msg"=>"GRABADO CON EXITO"];            
array_push($retorno,$datos);    
$retorno=json_encode($retorno);	 
echo $retorno;    
exit(1);

 
// ***********************************************************
    
?> 
  