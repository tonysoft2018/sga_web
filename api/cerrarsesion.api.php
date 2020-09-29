<?php
// ----------------------------------------------------------------------------------
// cerrarsesion.api.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { sesion:[sesion], 
//                  nidusuario:[nidusuario]
 //               }
//              - Devuelve el resultado en JSON.  
//                {
//                    retorno=>TRUE/FALSE, msg=>"MENSAJE",[REGISTROS] 
//                } 
// ----------------------------------------------------------------------------------
// Empresa. IDEATECH
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
 
 
// ----------------------------------------------
date_default_timezone_set("America/Mexico_City");
// ----------------------------------------------

include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/usuarios.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";
include_once "../clases/relauxs.mysql.class_v2.0.0.php";
include_once "../clases/sesion.mysql.class_v2.0.0.php";

$retorno= array();
$arreglos = array();
  
$arreglos=json_decode(stripslashes(file_get_contents("php://input"))); 

//$l_NumeroDeRegistros=count($arreglos);
$l_Sesion=trim($arreglos->{"sesion"});
$l_nIDUsuario=trim($arreglos->{"nidusuario"});
  
if(strlen($l_Sesion)<=0 && $l_nIDUsuario<=0 ){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE DATOS"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno; 
    exit(1);
} 

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true); 
// ----------------------------------------------

// ----------------------------------------------
// Carga datos generales         
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
// ----------------------------------------------


$l_Condicion="bEstado=0 and IDSesion='" . $l_Sesion . "'";      
$tbl_RelaUxS = new  cltbl_RelaUxS_v2_0_0();
$tbl_RelaUxS->Inicializacion();             
$tbl_RelaUxS->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_RelaUxS->Leer($l_Condicion);
if($tbl_RelaUxS->CualEsElNumeroDeRegistrosCargados()>0){

    $registros=$tbl_RelaUxS->dtBase();
    $l_nIDSesion=$registros[0]["nIDSesion"];

    $tbl_RelaUxS->Inicializacion();             
    $tbl_RelaUxS->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_RelaUxS->CambiarEstado($l_nIDSesion,$l_Observaciones, 1);

    //session_destroy();

    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>""];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno; 
    exit(1);

} else {

    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO EXISTE LA SESION"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno; 
    exit(1);

}

 
 
?>