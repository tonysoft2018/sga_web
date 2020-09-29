<?php
// ----------------------------------------------------------------------------------
// contenedores_deta_grabar.php
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
include_once "../clases/contenedores.mysql.class_v2.0.0.php";  
include_once "../clases/contenedores_deta.mysql.class_v2.0.0.php";  
include_once "../clases/packinglist.mysql.class_v2.0.0.php"; 
include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php";  
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
// Leer la info para procesar 
$tbl = new  cltbl_Contenedores_v2_0_0();  
$tbl_Deta = new  cltbl_Contenedor_Deta_v2_0_0();  
$tbl_Enca_Packinglist=new cltbl_PackingList_v2_0_0();
$tbl_Deta_Packinglist = new cltbl_PackingList_Deta_v2_0_0();

// Extrae el encabezado
$l_nIDPackingList=$arreglos[0]->{"nidpackinglist"};
$l_Folio=$arreglos[0]->{"folio"};

// Extra el ID del contenedor
$l_nIDContenedor=0;
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$tbl->Leer("Folio=" . $l_Folio); 
if($tbl->CualEsElNumeroDeRegistrosCargados()>0){          
    $registros=$tbl->dtBase();

    $l_nIDContenedor=$registros[0]["nIDContenedor"];

    if($l_nIDContenedor<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO SE ENCONTRO EL CONTENEDOR 2"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }
} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO SE ENCONTRO EL CONTENEDOR"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;   
    exit(1); 
}

// Carga el total de items del packinglist
$l_Condicion="nIDPackingList=" . $l_nIDPackingList . " and bEstado=0";
$TotalDeElementos_PackingList=0;
$tbl_Deta_Packinglist->Inicializacion();
$tbl_Deta_Packinglist->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_Deta_Packinglist->CargarCampos("LEER");
$tbl_Deta_Packinglist->Leer($l_Condicion);
$TotalDeElementos_PackingList=$tbl_Deta_Packinglist->CualEsElNumeroDeRegistrosCargados();
//echo "Total:" . $TotalDeElementos_PackingList;
 
// Valida que el contenedor este completo
$bandCompleto=0;
$Contador=0;
for($i=0;$i<$l_NumeroDeRegistros;$i++){
    $l_Codigo_IZeta=$arreglos[$i]->{"codigo_izeta"}; 
 
    if(strlen($l_Codigo_IZeta)>0){
        
        if($l_nIDPackingList>0){
            $l_Condicion="nIDPackingList=" . $l_nIDPackingList . " and Codigo='" . $l_Codigo_IZeta . "' and bEstado=0";

            //echo "Condicion:" .$l_Condicion;
            $tbl_Deta_Packinglist->Inicializacion();
            $tbl_Deta_Packinglist->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Deta_Packinglist->CargarCampos("LEER");
            $tbl_Deta_Packinglist->Leer($l_Condicion);

            if($tbl_Deta_Packinglist->CualEsElNumeroDeRegistrosCargados()>0){
                $Contador=$Contador+1;
            }  
        }        
    }
}

$TotalDeElementos_PackingList=$Contador;
//echo "Encontrador:" .$Contador;
//if($Contador==$TotalDeElementos_PackingList){
if($Contador==$TotalDeElementos_PackingList){

    for($i=0;$i<$l_NumeroDeRegistros;$i++){
         
        $l_Codigo_IZeta=$arreglos[$i]->{"codigo_izeta"};
        $l_Codigo_SAP=$arreglos[$i]->{"codigo_sap"};
        $l_Parts_Name=$arreglos[$i]->{"parts_name"};
        $l_Cantidad=$arreglos[$i]->{"cantidad"};
        $l_PrecioDividido=$arreglos[$i]->{"preciodividido"};
      
        // Verificacion
        if(strlen($l_Codigo_IZeta)<=0){
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"NO TIENE CODIGO IZETA"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;   
            exit(1); 
        }
    
        if(strlen($l_Parts_Name)<=0){
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"NO TIENE PARTS NAME"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;   
            exit(1); 
        }
          
        // Graba la ubicacion
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
    
        
        $datos_grabar = array();
                        
        array_push($datos_grabar,0);
        array_push($datos_grabar,$l_nIDContenedor);
        array_push($datos_grabar,$l_Codigo_IZeta);
        array_push($datos_grabar,$l_Codigo_SAP);
        array_push($datos_grabar,$l_Parts_Name);
        array_push($datos_grabar,$l_Cantidad);
        array_push($datos_grabar,$l_PrecioDividido);
    
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
    
        $tbl_Deta->Inicializacion();
        $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Deta->CargarCampos("GRABAR");
        $tbl_Deta->setInformacion_Grabar($registro_datos);
                   
        if($tbl_Deta->Ejecutar()){
           
        } else {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"FALLA EN LA GRABACION"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        } 
      
    }

    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>"GRABADO CON EXITO"];            
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
    
} else {

    // Elimina el encabezado
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->EliminarConCondicion("nIDContenedor=" .$l_nIDContenedor);

    // Cambiar estatus del packinglist
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
    $tbl_Enca_Packinglist->Inicializacion();
    $tbl_Enca_Packinglist->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Enca_Packinglist->CambiarEstatus($l_nIDPackingList,"SIN INSPECCION",$l_Observaciones);


    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"CONTENEDOR INCOMPLETO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
?> 
  