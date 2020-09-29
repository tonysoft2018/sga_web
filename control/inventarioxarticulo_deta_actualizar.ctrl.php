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

$contador=0;
for($i=0;$i<$l_NumeroDeRegistros;$i++){          

    // Extrae los datos 

    $l_nIDIxA_Deta=$arreglos[$i]->{"nidixa_deta"};
    $l_nIDIxA=$arreglos[$i]->{"nidixa"};
    $l_nIDProducto=$arreglos[$i]->{"nidproducto"};
    $l_nIDCat_Estado=$arreglos[$i]->{"nidcat_estado"};
    $l_nIDUsuario=$arreglos[$i]->{"nidusuario"};
    $l_Cantidad=$arreglos[$i]->{"cantidad"};
    $l_Existencias=$arreglos[$i]->{"existencia"};

     // Basicos
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

    // Calcula la diferencia
    $l_Diferencia=$l_Existencias - $l_Cantidad;

    // Graba el detalle
    $datos_grabar = array();
                    
    array_push($datos_grabar,$l_nIDIxA_Deta);
    array_push($datos_grabar,$l_nIDIxA);
    array_push($datos_grabar,$l_nIDProducto);
    array_push($datos_grabar,$l_nIDCat_Estado); 
    array_push($datos_grabar,$l_Existencias);
    array_push($datos_grabar,$l_Cantidad);
    array_push($datos_grabar,$l_Diferencia);
 
    array_push($datos_grabar,$l_FechaLocal);
    array_push($datos_grabar,$l_FechaLocal);
    array_push($datos_grabar,$l_Observaciones);
    array_push($datos_grabar,0);
   
    $registro_datos=array($datos_grabar[0]);
    for($j=1;$j<count($datos_grabar);$j++){
        array_push($registro_datos,$datos_grabar[$j]);
    }
    array_push($registro_datos,0); // Crear 
    array_push($registro_datos,1); // Cambiar
    array_push($registro_datos,0); // Eliminar

    //print_r($registro_datos);

    $tbl_Deta->Inicializacion();
    $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Deta->CargarCampos("GRABAR");
    $tbl_Deta->setInformacion_Grabar($registro_datos);
               
    if($tbl_Deta->Ejecutar()){
        $registros_grabados=$registros_grabados+1;

        $tbl_Enca->Inicializacion();
        $tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);        
        $tbl_Enca->CambiarEstatus($l_nIDIxA,"PROCESO", $l_Observaciones);
    }


    unset($registro_datos);
    unset($datos_grabar);

 
} 
 
 
if($registros_grabados==$l_NumeroDeRegistros){   
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
  