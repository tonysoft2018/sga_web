<?php
// ----------------------------------------------------------------------------------
// entradasporotrosconceptos_grabar.ctrl.php
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
include_once "../clases/entradas.mysql.class_v2.0.0.php";   
include_once "../clases/cat_productos.mysql.class_v2.0.0.php";   
include_once "../clases/entradasporotrosconceptos.mysql.class_v2.0.0.php";   
include_once "../clases/entradasporotrosconceptos_deta.mysql.class_v2.0.0.php"; 
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
$tbl = new  cltbl_Entradas_v2_0_0();  
$tbl_Cat_Productos = new  cltbl_Cat_Productos_v2_0_0();  
$tbl_EntradasPorOtrosConceptos = new  cltbl_EntradaPorOtrosConceptos_v2_0_0();  
$tbl_EntradasPorOtrosConceptos_Deta = new  cltbl_EntradaPorOtrosConceptos_Deta_v2_0_0();

$l_Contador=0;

for($i=0;$i<$l_NumeroDeRegistros;$i++){

    // Crea el Folio
    $l_Folio=0;          
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("LEER");
    $Campo_Llave=$tbl->get_CampoLlave();   
    $l_Folio=$tbl->getSiguienteFolio();
  

    $l_nIDEntradaPorOtrosConceptos=$arreglos[$i]->{"nidentradaporotrosconceptos"};
    $l_nIDUsuario=$arreglos[$i]->{"nidusuario"};
    $l_nIDPackingList=0;
    $l_nIDProducto=$arreglos[$i]->{"nidproducto"};
    $l_Codigo=$arreglos[$i]->{"codigo"};
    $l_Cantidad=$arreglos[$i]->{"cantidad"};
    $l_NoFactura="";
    $l_nIDCat_Proveedor=0;
    $l_TipoEntrada="OTRO CONCEPTOS";
    $l_Estatus="NO ACTUALIZADO"; 
    $l_Pedimento="";
 
    
     // Verificacion
     if(strlen($l_nIDEntradaPorOtrosConceptos)<=0){
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

    // Busca el concepto de Entrada    
    $l_nIDCat_Almacen=0;
    $l_Comentarios="";
    $tbl_EntradasPorOtrosConceptos->Inicializacion();
    $tbl_EntradasPorOtrosConceptos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_EntradasPorOtrosConceptos->CargarCampos("LEER");        
    $tbl_EntradasPorOtrosConceptos->Leer("nIDEntradaPorOtrosConceptos=" . $l_nIDEntradaPorOtrosConceptos . " and bEstado=0"); 
    if($tbl_EntradasPorOtrosConceptos->CualEsElNumeroDeRegistrosCargados()>0){                 
        $registros=$tbl_EntradasPorOtrosConceptos->dtBase();

        $l_nIDCat_Almacen=$registros[0]["nIDCat_Almacen"];
        $l_Comentarios=$registros[0]["Comentarios"];
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"ID CONCEPTO DE ENTRADA NO ENCONTRADO"];
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
    array_push($datos_grabar,$l_nIDEntradaPorOtrosConceptos);   
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

    $tbl_EntradasPorOtrosConceptos_Deta->Inicializacion();
    $tbl_EntradasPorOtrosConceptos_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_EntradasPorOtrosConceptos_Deta->CargarCampos("GRABAR");
    $tbl_EntradasPorOtrosConceptos_Deta->setInformacion_Grabar($registro_datos);

    if($tbl_EntradasPorOtrosConceptos_Deta->Ejecutar()){
      
         
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
    array_push($datos_grabar,$l_TipoEntrada);
    array_push($datos_grabar,$l_nIDEntradaPorOtrosConceptos);
    array_push($datos_grabar,0);
    array_push($datos_grabar,$l_nIDPackingList);
    array_push($datos_grabar,$l_nIDCat_Proveedor);
    array_push($datos_grabar,$l_Comentarios);
    array_push($datos_grabar,$l_NoFactura);
     
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

    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("GRABAR");
    $tbl->setInformacion_Grabar($registro_datos);
               
    if($tbl->Ejecutar()){
        $l_Contador=$l_Contador+1;
    } 
}

if($l_Contador==$l_NumeroDeRegistros){
    // Actualiza el Estatus de la entrada
    $tbl_EntradasPorOtrosConceptos->Inicializacion();
    $tbl_EntradasPorOtrosConceptos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    if($tbl_EntradasPorOtrosConceptos->CambiarEstatus($l_nIDEntradaPorOtrosConceptos, "PROCESADO",$l_Observaciones)){
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
  