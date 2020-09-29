<?php
// ----------------------------------------------------------------------------------
// salidasporotrosconceptos_grabar.ctrl.php
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
include_once "../clases/salidas.mysql.class_v2.0.0.php";   
include_once "../clases/cat_productos.mysql.class_v2.0.0.php";   
include_once "../clases/salidasporotrosconceptos.mysql.class_v2.0.0.php";   
include_once "../clases/salidasporotrosconceptos_deta.mysql.class_v2.0.0.php"; 
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
$tbl = new  cltbl_Salidas_v2_0_0();  
$tbl_Cat_Productos = new  cltbl_Cat_Productos_v2_0_0();  
$tbl_SalidasPorOtrosConceptos = new  cltbl_SalidasPorOtrosConceptos_v2_0_0();  
$tbl_SalidasPorOtrosConceptos_Deta = new  cltbl_SalidasPorOtrosConceptos_Deta_v2_0_0();

$l_Contador=0;

for($i=0;$i<$l_NumeroDeRegistros;$i++){

    // Crea el Folio
    $l_Folio=0;          
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("LEER");
    $Campo_Llave=$tbl->get_CampoLlave();   
    $l_Folio=$tbl->getSiguienteFolio();
  

    $l_nIDSalidaPorOtrosConceptos=$arreglos[$i]->{"nidsalidaporotrosconceptos"};
    $l_nIDUsuario=$arreglos[$i]->{"nidusuario"};
    $l_nIDPackingList=0;
    $l_nIDProducto=$arreglos[$i]->{"nidproducto"};
    $l_Codigo=$arreglos[$i]->{"codigo"};
    $l_Cantidad=$arreglos[$i]->{"cantidad"};
    $l_NoFactura="";
    $l_nIDCat_Proveedor=0;
    $l_TipoSalida="OTROS CONCEPTOS";
    $l_Estatus="NO ACTUALIZADO";      
 
    
     // Verificacion
     if(strlen($l_nIDSalidaPorOtrosConceptos)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO ID CONCEPTO DE ENTRADA POR OTROS CONCEPTOS"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }

    if(strlen($l_nIDProducto)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ID PRODUCTO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }

    // Busca el concepto de Salida
    $l_nIDCat_Almacen=0;
    $l_nIDCat_ConceptoSalida=0;
    $l_Comentarios="";
   
    $tbl_SalidasPorOtrosConceptos->Inicializacion();
    $tbl_SalidasPorOtrosConceptos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_SalidasPorOtrosConceptos->CargarCampos("LEER");        
    $tbl_SalidasPorOtrosConceptos->Leer("nIDSalidaPorOtrosConceptos=" . $l_nIDSalidaPorOtrosConceptos . " and bEstado=0"); 
    if($tbl_SalidasPorOtrosConceptos->CualEsElNumeroDeRegistrosCargados()>0){                 
        $registros=$tbl_SalidasPorOtrosConceptos->dtBase();

        $l_nIDCat_Almacen=$registros[0]["nIDCat_Almacen"];
        $l_nIDCat_ConceptoSalida=$registros[0]["nIDCat_ConceptoSalida"];
        $l_Comentarios=$registros[0]["Comentarios"];
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"ID CONCEPTO DE SALIDA NO ENCONTRADO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }

   

    // Buscar el Codigo IZeta
    $l_Codigo_IZeta="";
    $l_nIDCat_UnidadDeMedida=0; 
    $tbl_Cat_Productos->Inicializacion();
    $tbl_Cat_Productos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Cat_Productos->CargarCampos("LEER");        
    $tbl_Cat_Productos->Leer("nIDProducto=" . $l_nIDProducto . " and bEstado=0"); 
    
    if($tbl_Cat_Productos->CualEsElNumeroDeRegistrosCargados()>0){                 
        $registros=$tbl_Cat_Productos->dtBase();
         
        $l_Codigo_IZeta=$registros[0]["Codigo_IZeta"];
        $l_nIDCat_UnidadDeMedida=$registros[0]["nIDCat_UnidadDeMedida"];
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"ID PRODUCTO NO ENCONTRADO"];
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

    // Graba los detalles del Concepto
    $datos_grabar = array();

    array_push($datos_grabar,0);
    array_push($datos_grabar,$l_nIDSalidaPorOtrosConceptos);   
    array_push($datos_grabar,$l_nIDProducto);    
    array_push($datos_grabar,$l_Codigo);     
    array_push($datos_grabar,$l_Cantidad);
      
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

 
    $tbl_SalidasPorOtrosConceptos_Deta->Inicializacion();
    $tbl_SalidasPorOtrosConceptos_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_SalidasPorOtrosConceptos_Deta->CargarCampos("GRABAR");
    $tbl_SalidasPorOtrosConceptos_Deta->setInformacion_Grabar($registro_datos);

    if($tbl_SalidasPorOtrosConceptos_Deta->Ejecutar()){
        if($tbl_SalidasPorOtrosConceptos->CambiarEstatus($l_nIDSalidaPorOtrosConceptos, "PROCESADO",$l_Observaciones)){
           // echo "Cambiado";
        }
         
    } else {
        
    }

    unset($datos_grabar);
    unset($registro_datos);


    // Graba la entrada
    $datos_grabar = array();
                    
    array_push($datos_grabar,0);
    array_push($datos_grabar,$l_Folio);
    array_push($datos_grabar,$l_FechaLocal);
    array_push($datos_grabar,$l_nIDProducto);    
    array_push($datos_grabar,$l_Codigo);
    array_push($datos_grabar,"");
    array_push($datos_grabar,$l_Cantidad);
    array_push($datos_grabar,$l_nIDCat_UnidadDeMedida);
    array_push($datos_grabar,$l_nIDUsuario);
    array_push($datos_grabar,$l_nIDCat_Almacen);
    array_push($datos_grabar,$l_Estatus);
    array_push($datos_grabar,$l_TipoSalida);
    array_push($datos_grabar,$l_nIDSalidaPorOtrosConceptos);
    array_push($datos_grabar,$l_nIDCat_ConceptoSalida);
    array_push($datos_grabar,$l_Comentarios);

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

    //echo "Salida:" . $l_nIDSalidaPorOtrosConceptos;
    //print_r($registro_datos);

    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("GRABAR");
    $tbl->setInformacion_Grabar($registro_datos);
               
    if($tbl->Ejecutar()){
        $l_Contador=$l_Contador+1;
    }  else {
        //echo "NO grabado";
    }
}

if($l_Contador==$l_NumeroDeRegistros){
    // Actualiza el Estatus de la entrada
    $tbl_SalidasPorOtrosConceptos->Inicializacion();
    $tbl_SalidasPorOtrosConceptos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    if($tbl_SalidasPorOtrosConceptos->CambiarEstatus($l_nIDSalidaPorOtrosConceptos, "PROCESADO",$l_Observaciones)){
       $datos=array();
       $datos=$datos + ["retorno"=>"TRUE"];
       $datos=$datos + ["msg"=>"GRABADO CON EXITO"];            
       array_push($retorno,$datos);    
       $retorno=json_encode($retorno);	 
       echo $retorno;    
       exit(1);
    } else {
       $tbl->Inicializacion();
       $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
       $tbl->EliminarConCondicion("Folio=" . $l_Folio);

       $datos=array();
       $datos=$datos + ["retorno"=>"FALSE"];
       $datos=$datos + ["msg"=>"FALLA EN LA GRABACION"];
       array_push($retorno,$datos);    
       $retorno=json_encode($retorno);	 
       echo $retorno;    
       exit(1);

    }
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
  