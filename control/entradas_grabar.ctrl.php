<?php
// ----------------------------------------------------------------------------------
// entradas_grabar.php
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
include_once "../clases/packinglist.mysql.class_v2.0.0.php";   
include_once "../clases/productos_series.mysql.class_v2.0.0.php";   
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
$tbl_PackingList = new  cltbl_Packinglist_v2_0_0();
$tbl_Series = new  cltbl_Cat_Productos_Series_v2_0_0();

$contador=0;
$l_nIDPackingList=0; 

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
 
for($i=0;$i<$l_NumeroDeRegistros;$i++){

    // Crea el Folio
    $l_Folio=0;          
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("LEER");
    $Campo_Llave=$tbl->get_CampoLlave();   
    $l_Folio=$tbl->getSiguienteFolio();
  
    $l_nIDPackingList=$arreglos[$i]->{"nidpackinglist"};
    $l_nIDUsuario=$arreglos[$i]->{"nidusuario"};
    $l_nIDCat_Almacen=$arreglos[$i]->{"nidcat_almacen"};
    $l_nIDCat_Proveedor=$arreglos[$i]->{"nidcat_proveedor"};
    $l_Comentarios=$arreglos[$i]->{"comentarios"};
    $l_NoFactura=$arreglos[$i]->{"nofactura"};
 
    $l_Codigo_IZeta=$arreglos[$i]->{"codigo_izeta"}; 
    $l_Serie=$arreglos[$i]->{"serie"};          
    $l_Cantidad=$arreglos[$i]->{"cantidad"};
    $l_Pedimento=$arreglos[$i]->{"pedimento"};
    $l_TipoEntrada="ENTRADA POR COMPRA";
    
    $l_Estatus="NO ACTUALIZADO";

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

    if(strlen($l_Serie)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE SERIAL"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }

     
     if($l_nIDCat_Almacen<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ALMACEN"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }

    if($l_nIDCat_Proveedor<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE PROVEEDOR"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }

    // Buscar el Producto
    $l_nIDCat_Producto=0;
    $l_nIDCat_UnidadDeMedida=0;
    if(strlen($l_Codigo_IZeta)>0){
    
        $tbl_Cat_Productos->Inicializacion();
        $tbl_Cat_Productos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Cat_Productos->CargarCampos("LEER");        
        $tbl_Cat_Productos->Leer("Codigo_IZeta='" . $l_Codigo_IZeta . "' and bEstado=0"); 
        
        if($tbl_Cat_Productos->CualEsElNumeroDeRegistrosCargados()>0){                 
            $registros=$tbl_Cat_Productos->dtBase();
             
            $l_nIDCat_Producto=$registros[0]["nIDProducto"];
            $l_nIDCat_UnidadDeMedida=$registros[0]["nIDCat_UnidadDeMedida"];

            if($l_nIDCat_Producto<=0){
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"CODIGO IZETA NO LOCALIZADO:" . $l_Codigo_IZeta];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;   
                exit(1); 
            }          
        } else {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"CODIGO IZETA NO LOCALIZADO_:" . $l_Codigo_IZeta];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;   
            exit(1); 
        }
        
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE CODIGO IZETAs:" . $l_Codigo_IZeta];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }
 
    // Graba la ubicacion
    $datos_grabar = array();
                    
    array_push($datos_grabar,0);
    array_push($datos_grabar,$l_Folio);
    array_push($datos_grabar,$l_FechaLocal);
    array_push($datos_grabar,$l_nIDCat_Producto);    
    array_push($datos_grabar,$l_Codigo_IZeta);
    array_push($datos_grabar,"");
    array_push($datos_grabar,$l_Cantidad);
    array_push($datos_grabar,$l_nIDCat_UnidadDeMedida);
    array_push($datos_grabar,$l_nIDUsuario);
    array_push($datos_grabar,$l_nIDCat_Almacen);
    array_push($datos_grabar,$l_Estatus);
    array_push($datos_grabar,$l_TipoEntrada);
    array_push($datos_grabar,0);
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

    //print_r($registro_datos);

    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("GRABAR");
    $tbl->setInformacion_Grabar($registro_datos);
               
    if($tbl->Ejecutar()){
       $contador=$contador+1;

       // Graba los seriales
       unset($datos_grabar);
       unset($registro_datos);

       $datos_grabar = array();
                    
        array_push($datos_grabar,0);
        array_push($datos_grabar,$l_nIDCat_Producto);
        array_push($datos_grabar,$l_nIDPackingList);
        array_push($datos_grabar,$l_Serie);    
        array_push($datos_grabar,"NO");    

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

        $tbl_Series->Inicializacion();
        $tbl_Series->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Series->CargarCampos("GRABAR");
        $tbl_Series->setInformacion_Grabar($registro_datos);
        if($tbl_Series->Ejecutar()){

        }
    }   
    
    unset($datos_grabar);
    unset($registro_datos);
}

if($contador==$l_NumeroDeRegistros){
    $tbl_PackingList->Inicializacion();
    $tbl_PackingList->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_PackingList->CambiarEstatus($l_nIDPackingList,"CERRADA",$l_Observaciones);
 
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
  