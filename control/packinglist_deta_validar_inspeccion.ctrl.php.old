<?php
// ----------------------------------------------------------------------------------
// packinglist_deta_validar.ctrl.php
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
$tbl_Enca = new   cltbl_Packinglist_v2_0_0();
$tbl = new   cltbl_Packinglist_Deta_v2_0_0();
$tbl_inspeccion = new  cltbl_Inspeccion_v2_0_0();

for($i=0;$i<$l_NumeroDeRegistros;$i++){
    $l_nIDEnca=trim($arreglos[$i]->{"nid"});     
    $l_Codigo=trim($arreglos[$i]->{"codigo"});
    $l_nIDCat_Estado=trim($arreglos[$i]->{"nidcat_estado"});
    $l_nIDUsuario=trim($arreglos[$i]->{"nidusuario"});
     
    if(strlen($l_nIDEnca)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN ID"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);       
    }

    if(strlen($l_Codigo)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN ESTATUS"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }
 
    // Validación
    if(strlen($l_nIDEnca)>0){ 
        if(!is_numeric($l_nIDEnca)) {
            if($l_nID<=0){
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"ID INVALIDO DEBE DE SER NUMERICO"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }            
        }   
    }    
 
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

    // Busca el codigo en el packinglist
    $l_nIDDeta=0;
    $l_Estatus="INSPECCIONADO";
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->Leer("nIDPackingList=". $l_nIDEnca . " and (Codigo='" .$l_Codigo . "' or CodigoQR='" .$l_Codigo ."') and Estatus='RECIBO'");
    if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
        $registros=$tbl->dtBase();
        $l_nIDDeta=$registros[0]["nIDPackingList_Deta"];

        if($l_nIDDeta>0){
            if($tbl->CambiarEstatus($l_nIDDeta,$l_Estatus, $l_Observaciones)){
                 $tbl_Enca->Inicializacion();
                 $tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                 $tbl_Enca->CambiarEstatus($l_nIDEnca,"INSPECCION", $l_Observaciones);

                // Graba los detalles del Concepto
                $datos_grabar = array();

                array_push($datos_grabar,0);
                array_push($datos_grabar,$l_nIDEnca);   
                array_push($datos_grabar,$l_nIDDeta);    
                array_push($datos_grabar,$l_FechaLocal);     
                array_push($datos_grabar,$l_nIDUsuario);
                array_push($datos_grabar,$l_nIDCat_Estado);
                array_push($datos_grabar,"");
                array_push($datos_grabar,"");
   
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

                $tbl_inspeccion->Inicializacion();
                $tbl_inspeccion->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_inspeccion->CargarCampos("GRABAR");
                $tbl_inspeccion->setInformacion_Grabar($registro_datos);
                if($tbl_inspeccion->Ejecutar()){

                }

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
                $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE GRABACION"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }

        } else {
            // No encontrado
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"CODIGO NO ENCONTRADO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);

        }
    } else {
        // No encontrado
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"CODIGO NO ENCONTRADO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }
} 
?> 
  