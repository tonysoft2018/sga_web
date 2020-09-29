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
    $l_nIDPackingList=trim($arreglos[$i]->{"nidpackinglist"});     
    $l_nIDPackingList_Deta=trim($arreglos[$i]->{"nidpackinglist_deta"});   
    $l_nIDProducto=trim($arreglos[$i]->{"nidproducto"});   
    $l_CodigoDeBarras=trim($arreglos[$i]->{"codigo"});   
    $l_nIDProducto_Serie=trim($arreglos[$i]->{"nidproducto_serie"});   
    $l_Serie=trim($arreglos[$i]->{"serie"}); 
    $l_nIDCat_Estado=trim($arreglos[$i]->{"nidcat_estado"}); 
    $l_nIDUsuario=trim($arreglos[$i]->{"nidusuario"}); 


    // Verificacion 
    if(strlen($l_nIDPackingList)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN ID DEL PACKINGLIST"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);       
    }

    if(strlen($l_nIDPackingList_Deta)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN ID DEL PACKINGLIST DETALLE"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);       
    }

    if(strlen($l_nIDProducto)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN ID DEL PRODUCTO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);       
    }

    if(strlen($l_CodigoDeBarras)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE CODIGO DE BARRAS"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);       
    }

    if(strlen($l_nIDProducto_Serie)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE DE LA SERIE"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);       
    }

    if(strlen($l_nIDCat_Estado)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ID DEL ESTADO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);       
    }

    if(strlen($l_nIDUsuario)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ID DEL USUARIO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);       
    }

    // Validación
    if(strlen($l_nIDPackingList)>0){ 
        if(!is_numeric($l_nIDPackingList)) {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ID PACKINGLIST INVALIDO DEBE DE SER NUMERICO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);   
        }   
    }  

    if(strlen($l_nIDPackingList_Deta)>0){ 
        if(!is_numeric($l_nIDPackingList_Deta)) {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ID PACKINGLIST DETA INVALIDO DEBE DE SER NUMERICO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);   
        }   
    }  

    if(strlen($l_nIDUsuario)>0){ 
        if(!is_numeric($l_nIDUsuario)) {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ID USUARIO INVALIDO DEBE DE SER NUMERICO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);   
        }   
    }  

    if(strlen($l_nIDCat_Estado)>0){ 
        if(!is_numeric($l_nIDCat_Estado)) {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ID ESTADO INVALIDO DEBE DE SER NUMERICO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);   
        }   
    }  

    if(strlen($l_nIDProducto_Serie)>0){ 
        if(!is_numeric($l_nIDProducto_Serie)) {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ID SERIE INVALIDO DEBE DE SER NUMERICO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);   
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


    // Verifica que el Codigo de Barras no haya sido dado de alta.
    $tbl_inspeccion->Inicializacion();
    $tbl_inspeccion->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_inspeccion->Leer("nIDProducto_Serie=" . $l_nIDProducto_Serie . " and bEstado=0");
    if($tbl_inspeccion->CualEsElNumeroDeRegistrosCargados()<=0){
        // Graba los detalles del Concepto
        $datos_grabar = array();

        array_push($datos_grabar,0);
        array_push($datos_grabar,$l_nIDPackingList);   
        array_push($datos_grabar,$l_nIDPackingList_Deta);    
        array_push($datos_grabar,$l_FechaLocal);     
        array_push($datos_grabar,$l_nIDUsuario);
        array_push($datos_grabar,$l_nIDCat_Estado);
        array_push($datos_grabar,"");
        array_push($datos_grabar,$l_CodigoDeBarras);
        array_push($datos_grabar,$l_nIDProducto_Serie);
   
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
            $tbl->Inicializacion();
            $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl->CambiarEstatus($l_nIDPackingList_Deta,"INSPECCIONADO", $l_Observaciones);

            $tbl_Enca->Inicializacion();
            $tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Enca->CambiarEstatus($l_nIDPackingList,"INSPECCION", $l_Observaciones);
        }
    }
} 

 


$datos=array();
$datos=$datos + ["retorno"=>"TRUE"];
$datos=$datos + ["msg"=>"PROCESO FINALIZADO CON EXITO"];
array_push($retorno,$datos);    
$retorno=json_encode($retorno);	 
echo $retorno;    
exit(1);
 
?> 
  