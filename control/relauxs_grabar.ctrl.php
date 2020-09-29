<?php
// ----------------------------------------------------------------------------------
// relauxs_grabar.ctrl.php
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
include_once "../clases/usuarios.mysql.class_v2.0.0.php"; 
include_once "../clases/relauxs.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";
include_once "../utilerias/utilerias.php";

$retorno= array();
$arreglos = array();
$datos_grabar = array();

$registros_grabados=0;

$FOLIO=0;
 
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
$l_nIDSesion=$arreglos[0]->{"idsesion"};
$l_Usuario=$arreglos[0]->{"usuario"};
$l_Password=$arreglos[0]->{"password"};
 

if($l_nIDSesion<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE SESION"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;   
    exit(1); 
}

if(strlen($l_Usuario)<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE USUARIO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;   
    exit(1); 
}

if(strlen($l_Password)<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE PASSWORD"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;   
    exit(1); 
}
// ----------------------------------------------   

// ----------------------------------------------   
// Buscar el ID del usuario
$l_nIDUsuario=0;
$tbl_Usuario = new  cltbl_Usuarios_v2_0_0();
$tbl_Usuario->Inicializacion();
$tbl_Usuario->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_Usuario->CargarCampos("LEER");
$l_Condicion="Usuario='" . $l_Usuario . "' and Password='" . $l_Password . "' and Activo='SI' and bEstado=0 and (Web='SI' or App='SI')";
$tbl_Usuario->Leer($l_Condicion);
if($tbl_Usuario->CualEsElNumeroDeRegistrosCargados()>0){
    $registros=$tbl_Usuario->dtBase();
    $l_nIDUsuario=$registros[0]["nIDUsuario"];

    if($l_nIDUsuario<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"USUARIO Y/O PASSWORD INCORRECTOS"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }
} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"USUARIO Y/O PASSWORD INCORRECTOS"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;   
    exit(1); 
}
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

$tbl_RelaUxS = new  cltbl_RelaUxS_v2_0_0();
$tbl_RelaUxS->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_RelaUxS->CargarCampos("GRABAR");

$datos_grabar = array();
                    
array_push($datos_grabar,0);
array_push($datos_grabar,$l_nIDUsuario);
array_push($datos_grabar,$l_nIDSesion);
 
array_push($datos_grabar,$l_FechaLocal);
array_push($datos_grabar,$l_FechaLocal);
array_push($datos_grabar,$l_Observaciones);
array_push($datos_grabar,0);

$registro_datos=array($datos_grabar[0]);
for($j=1;$j<count($datos_grabar);$j++){
    array_push($registro_datos,$datos_grabar[$j]);
}
array_push($registro_datos,1); // Crear 
array_push($registro_datos,0); // Cambiar
array_push($registro_datos,0); // Eliminar

$tbl_RelaUxS->setInformacion_Grabar($registro_datos);

if($tbl_RelaUxS->Ejecutar()){
    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>"GRABADO CON EXITO1"];        
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALLA EN LA GRABACION"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
 
?> 
  