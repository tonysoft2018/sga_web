<?php
// ----------------------------------------------------------------------------------
// ordendesurtido_grabar.ctrl.php
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
include_once "../clases/ordendesurtido.mysql.class_v2.0.0.php";   
include_once "../clases/ordendesurtido_deta.mysql.class_v2.0.0.php"; 
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
$tbl = new  cltbl_Salidas_v2_0_0();  
$tbl_Cat_Productos = new  cltbl_Cat_Productos_v2_0_0();  
$tbl_OrdenDeSurtido = new  cltbl_OrdenDeSurtido_v2_0_0();
$tbl_OrdenDeSurtido_Deta = new  cltbl_OrdenDeSurtido_Deta_v2_0_0();

$l_Contador=0;

// ***********************************************************
// Graba la orden de sutrido
$l_Folio=0;    
$i=0;
$tbl_OrdenDeSurtido->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_OrdenDeSurtido->CargarCampos("LEER");
$Campo_Llave=$tbl_OrdenDeSurtido->get_CampoLlave();   
$l_Folio=$tbl_OrdenDeSurtido->getSiguienteFolio();

// Extrae la info
$l_nIDOrdenDeSurtido=0;
$l_nIDCat_Almacen_Origen=$arreglos[$i]->{"nidcat_almacen_origen"};
$l_nIDCat_Almacen_Destino=$arreglos[$i]->{"nidcat_almacen_destino"};
$l_Comentarios=$arreglos[$i]->{"comentarios"};
$l_nIDUsuario=$arreglos[$i]->{"nidusuario"};
$l_Estatus="ORDEN SURTIDA - PENDIENTE EMBARCAR";

if( $l_nIDCat_Almacen_Origen<=0 ){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NECESITA SELECCIONAR EL ALMACEN ORIGEN"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;   
    exit(1);  
}

if( $l_nIDCat_Almacen_Destino<=0 ){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NECESITA SELECCIONAR EL ALMACEN DESTINO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;   
    exit(1);  
}

if( $l_nIDUsuario<=0 ){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALTA EL USUARIO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;   
    exit(1);  
}

 
 // Graba los detalles del Concepto
 $datos_grabar = array();

 array_push($datos_grabar,0);
 array_push($datos_grabar,$l_Folio);   
 array_push($datos_grabar,$l_FechaLocal);    
 array_push($datos_grabar,$l_nIDCat_Almacen_Origen);     
 array_push($datos_grabar,$l_nIDCat_Almacen_Destino);
 array_push($datos_grabar,$l_Comentarios);
 array_push($datos_grabar,$l_nIDUsuario);
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

 
 $tbl_OrdenDeSurtido->Inicializacion();
 $tbl_OrdenDeSurtido->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
 $tbl_OrdenDeSurtido->CargarCampos("GRABAR");
 $tbl_OrdenDeSurtido->setInformacion_Grabar($registro_datos);

 
 if($tbl_OrdenDeSurtido->Ejecutar()){
    
    $tbl_OrdenDeSurtido->Inicializacion();
    $tbl_OrdenDeSurtido->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);

    $tbl_OrdenDeSurtido->Leer("Folio=" . $l_Folio . " and bEstado=0"); 
    if($tbl_OrdenDeSurtido->CualEsElNumeroDeRegistrosCargados()>0){        
        $registros=$tbl_OrdenDeSurtido->dtBase();
        $l_nIDOrdenDeSurtido=$registros[0]["nIDOrdenDeSurtido"];

        if($l_nIDOrdenDeSurtido<=0){
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE GRABAR LA ORDEN DE SURTIDO - ID"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;   
            exit(1);  
        }
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE GRABAR LA ORDEN DE SURTIDO - NO ENCONTRADA"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1);  
    }
          
 } else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE GRABAR LA ORDEN DE SURTIDO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;   
    exit(1);  
 }
 unset($datos_grabar);
 unset($registro_datos); 
// ***********************************************************

 

for($i=0;$i<$l_NumeroDeRegistros;$i++){

    $l_nIDProducto=$arreglos[$i]->{"nidproducto"};
    $l_Codigo=$arreglos[$i]->{"codigo"};
    $l_Cantidad=$arreglos[$i]->{"cantidad"};
    $l_Comentarios=$arreglos[$i]->{"comentarios"};

    // Graba los detalles del Concepto
    $datos_grabar = array();

    array_push($datos_grabar,0);
    array_push($datos_grabar,$l_nIDOrdenDeSurtido);   
    array_push($datos_grabar,$l_nIDProducto);    
    array_push($datos_grabar,$l_Codigo);     
    array_push($datos_grabar,$l_Cantidad);
    array_push($datos_grabar,"NO LEIDO");
    
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


    $tbl_OrdenDeSurtido_Deta->Inicializacion();
    $tbl_OrdenDeSurtido_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_OrdenDeSurtido_Deta->CargarCampos("GRABAR");
    $tbl_OrdenDeSurtido_Deta->setInformacion_Grabar($registro_datos);
    if($tbl_OrdenDeSurtido_Deta->Ejecutar()){
        
    }

    unset($datos_grabar);
    unset($registro_datos); 
     
    // Buscar el Codigo IZeta     
    $l_nIDCat_UnidadDeMedida=0; 
    $tbl_Cat_Productos->Inicializacion();
    $tbl_Cat_Productos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Cat_Productos->CargarCampos("LEER");        
    $tbl_Cat_Productos->Leer("nIDProducto=" . $l_nIDProducto . " and bEstado=0"); 
    
    if($tbl_Cat_Productos->CualEsElNumeroDeRegistrosCargados()>0){                 
        $registros=$tbl_Cat_Productos->dtBase();
                 
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

    // Graba la salida  
    $l_NoFactura="";
    $l_nIDCat_Proveedor=0;
    $l_nIDCat_ConceptoSalida=0;
    $l_TipoSalida="ORDEN DE SURTIDO";
    $l_Estatus="PENDIENTE";       

    $l_Folio=0;          
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("LEER");
    $Campo_Llave=$tbl->get_CampoLlave();   
    $l_Folio=$tbl->getSiguienteFolio();
      
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
    array_push($datos_grabar,$l_nIDCat_Almacen_Origen);
    array_push($datos_grabar,$l_Estatus);
    array_push($datos_grabar,$l_TipoSalida);
    array_push($datos_grabar,$l_nIDOrdenDeSurtido);
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

    
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("GRABAR");
    $tbl->setInformacion_Grabar($registro_datos);
               
    if($tbl->Ejecutar()){
        $l_Contador=$l_Contador+1;
    } 
}
 

if($l_Contador==$l_NumeroDeRegistros){
    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>"GRABADO CON EXITO"];            
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
  