<?php
// ----------------------------------------------------------------------------------
// contenedores_grabar.php
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
include_once "../clases/packinglist.mysql.class_v2.0.0.php"; 
include_once "../clases/contenedores.mysql.class_v2.0.0.php"; 

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
$tbl_Enca_Packinglist=new cltbl_PackingList_v2_0_0();
 
for($i=0;$i<$l_NumeroDeRegistros;$i++){
 
    $l_nIDUsuario=$arreglos[$i]->{"nidusuario"};
    $l_nIDProveedor=$arreglos[$i]->{"nidproveedor"};
    $l_NoFactura=$arreglos[$i]->{"nofactura"};
    $l_nIDPackingList=$arreglos[$i]->{"nidpackinglist"};
    $l_Estatus=$arreglos[$i]->{"estatus"};

    if($l_nIDUsuario<0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ID DEL USUARIO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }


    if($l_nIDPackingList<0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ID DEL PACKING LIST"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

    if(strlen($l_nIDProveedor)<0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE PROVEEDOR"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

    if(strlen($l_NoFactura)<0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE FOLIO DE FACTURA"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

     // Verifica si el packinglist no esta dado de alta      
     $l_Condicion="nIDPackingList=" . $l_nIDPackingList;      
     $tbl->Inicializacion();
     $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
     $tbl->Leer($l_Condicion); 
     if($tbl->CualEsElNumeroDeRegistrosCargados()>0){  
         $datos=array();
         $datos=$datos + ["retorno"=>"FALSE"];
         $datos=$datos + ["msg"=>"PACKINGLIST REGISTRADO CON UNA COMPRA "];
         array_push($retorno,$datos);    
         $retorno=json_encode($retorno);	 
         echo $retorno;    
         exit(1);
     }  

    // Crea el Folio
    $l_Folio=0;          
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("LEER");
    $Campo_Llave=$tbl->get_CampoLlave();   
    $l_Folio=$tbl->getSiguienteFolio();
    
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
    array_push($datos_grabar,$l_Folio);
    array_push($datos_grabar,$l_FechaLocal);
    array_push($datos_grabar,$l_nIDUsuario);
    array_push($datos_grabar,$l_nIDProveedor);
    array_push($datos_grabar,$l_NoFactura);
    array_push($datos_grabar,$l_nIDPackingList);
    array_push($datos_grabar,$l_Estatus);

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

    //print_r($registro_datos);
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("GRABAR");
    $tbl->setInformacion_Grabar($registro_datos);
               
    if($tbl->Ejecutar()){
        // Cambiar estatus del packing List
        $tbl_Enca_Packinglist->Inicializacion();
        $tbl_Enca_Packinglist->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Enca_Packinglist->CambiarEstatus($l_nIDPackingList,"SIN INSPECCION - CONTENEDOR",$l_Observaciones);

        $datos=array();
        $datos=$datos + ["retorno"=>"TRUE"];
        $datos=$datos + ["msg"=>"GRABADO CON EXITO"];   
        $datos=$datos + ["folio"=>$l_Folio];   
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
  
}

?> 
  