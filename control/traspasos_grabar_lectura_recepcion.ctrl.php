<?php
// ----------------------------------------------------------------------------------
// traspasos_grabar_lectura_recepcion.ctrl.php
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
include_once "../clases/entradas.mysql.class_v2.0.0.php";    
include_once "../clases/traspasos.mysql.class_v2.0.0.php";    
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
$tbl = new  cltbl_Traspasos_v2_0_0();   
$tbl_OrdenDeSurtido = new  cltbl_OrdenDeSurtido_v2_0_0();
$tbl_OrdenDeSurtido_Deta = new  cltbl_OrdenDeSurtido_Deta_v2_0_0();
$tbl_Entradas = new cltbl_Entradas_v2_0_0();  
$tbl_Salidas = new  cltbl_Salidas_v2_0_0();

$l_Contador=0;

$l_nIDOrdenDeSurtido=$arreglos[0]->{"nidordendesurtido"};
if($l_nIDOrdenDeSurtido<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NECESITA SELECCIONAR LA ORDEN DE SURTIDO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;   
    exit(1);  
}



 
// ***********************************************************
// Cancela el traspaso
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);

// ***********************************************************

// ***********************************************************
// Verifica si el traspaso fue completo 
$l_Leidos=0;
for($i=0;$i<$l_NumeroDeRegistros;$i=$i+1){
    $l_Estatus=$arreglos[$i]->{"estatus"};

    if($l_Estatus=="LEIDO"){
        $l_Leidos=$l_Leidos+1;
    } 
}

if($l_Leidos==$l_NumeroDeRegistros){
    // Completo

    // ***********************************************************
    // Busca la orden de surtido
    $l_Contador=0;
    $l_Condicion="nIDOrdenDeSurtido=" . $l_nIDOrdenDeSurtido . " and (Estatus='ABIERTO' or Estatus='PROCESO') and Tipo='RECEPCION' AND bEstado=0";
     
    $l_nIDTraspaso=0;
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->Leer($l_Condicion); 
    if($tbl->CualEsElNumeroDeRegistrosCargados()>0){                 
        $registros=$tbl->dtBase();
        $l_nIDTraspaso=$registros[0]["nIDTraspaso"];

        if($l_nIDTraspaso<=0){
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"NECESITA SELECCIONAR EL TRASPASO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;   
            exit(1);  
        
        } else {
            
        }
    }
    // ***********************************************************
 
    if($l_nIDTraspaso<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"LA ORDEN DE EMBARQUE NO FUE ENCONTRADA"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1);  
    
    }  

    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CambiarEstatus($l_nIDTraspaso, "CERRADA", $l_Observaciones);
 
    // Cierra la orden de Surtido
    $tbl_OrdenDeSurtido->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]); 
    $tbl_OrdenDeSurtido->CambiarEstatus($l_nIDOrdenDeSurtido, "TRASPASO DE RECEPCION COMPLETO", $l_Observaciones);

    // Cambia el estatus de los productos en la Salida
    $l_Condicion="nIDReferencia=" . $l_nIDOrdenDeSurtido . " and Estatus='PENDIENTE' and bEstado=0";
    $tbl_Salidas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]); 
    $tbl_Salidas->CambiarEstatus_Condicion($l_Condicion, "NO ACTUALIZADO", $l_Observaciones);

    $tbl_OrdenDeSurtido_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]); 
 
    // Crea la Entrada de los productos de la salida
    for($i=0;$i<$l_NumeroDeRegistros;$i=$i+1){

        $l_Estatus=$arreglos[$i]->{"estatus"};

        if($l_Estatus=="LEIDO"){

            $l_nIDOrdenDeSurtido_Deta=$arreglos[$i]->{"nidordendesurtido_deta"};

            if($l_nIDOrdenDeSurtido_Deta>0){               
                $tbl_OrdenDeSurtido_Deta->CambiarEstatus($l_nIDOrdenDeSurtido_Deta, "LEIDO", $l_Observaciones);
            } else {
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"NO TIENE ID ORDEN DE SURTIDO:" . $l_nIDOrdenDeSurtido_Deta];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;   
                exit(1);  
            }


            $l_nIDProducto=$arreglos[$i]->{"nidproducto"};
            $l_Codigo=$arreglos[$i]->{"codigo"};
            $l_Cantidad=$arreglos[$i]->{"cantidad"};
            $l_nIDCat_Almacen_Destino=$arreglos[$i]->{"nidcat_almacen_destino"};
            
            $l_nIDCat_UnidadDeMedida=$arreglos[$i]->{"nidcat_unidaddemedida"};
            $l_nIDUsuario=$arreglos[$i]->{"nidusuario"};
            $l_Estatus="NO ACTUALIZADO";
            $l_TipoEntrada="TRASPASO";
            $l_nIDEntradaPorOtrosConceptos=0;
            $l_nIDPackingList=0;
            $l_nIDCat_Proveedor=0;
            $l_Comentarios="ORDEN DE SURTIDO:" . $l_nIDOrdenDeSurtido;
            $l_NoFactura="";
            
    
            $l_Folio=0;          
            $tbl_Entradas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Entradas->CargarCampos("LEER");
            $Campo_Llave=$tbl_Entradas->get_CampoLlave();   
            $l_Folio=$tbl->getSiguienteFolio();
    
            unset($datos_grabar);
            unset($registro_datos);
    
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
            array_push($datos_grabar,$l_nIDCat_Almacen_Destino);
            array_push($datos_grabar,$l_Estatus);
            array_push($datos_grabar,$l_TipoEntrada);
            array_push($datos_grabar,$l_nIDTraspaso);
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
    
            $tbl_Entradas->Inicializacion();
            $tbl_Entradas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Entradas->CargarCampos("GRABAR");
            $tbl_Entradas->setInformacion_Grabar($registro_datos);
                   
            if($tbl_Entradas->Ejecutar()){
                $l_Contador=$l_Contador+1;
            } 

        }     
    }
   
 
    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>"GRABADO CON EXITO:" . $l_nIDTraspaso];            
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
    
} else {
    // Parcial

    // ***********************************************************
    // Busca la orden de surtido
    $l_Contador=0;
    $l_Condicion="nIDOrdenDeSurtido=" . $l_nIDOrdenDeSurtido . " and (Estatus='ABIERTO' or Estatus='PROCESO') and Tipo='RECEPCION' AND bEstado=0";
    $l_nIDTraspaso=0;
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->Leer($l_Condicion); 
    if($tbl->CualEsElNumeroDeRegistrosCargados()>0){        
        $registros=$tbl->dtBase();
        $l_nIDTraspaso=$registros[0]["nIDTraspaso"];

        if($l_nIDTraspaso<=0){
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"NECESITA SELECCIONAR EL TRASPASO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;   
            exit(1);  
        
        }
    }
    // ***********************************************************

    // Actualiza el traspaso
    $tbl->CambiarEstatus($l_nIDTraspaso, "PROCESO", $l_Observaciones);
     
    $tbl_OrdenDeSurtido_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]); 
    
    // Actualiza la orde de surtido en detalles de los productos recibidos
    for($i=0;$i<$l_NumeroDeRegistros;$i=$i+1){

        $l_Estatus=$arreglos[$i]->{"estatus"};
         
        if($l_Estatus=="LEIDO"){
            $l_nIDOrdenDeSurtido_Deta=$arreglos[$i]->{"nidordendesurtido_deta"};

            if($l_nIDOrdenDeSurtido_Deta>0){               
                $tbl_OrdenDeSurtido_Deta->CambiarEstatus($l_nIDOrdenDeSurtido_Deta, "LEIDO", $l_Observaciones);
            } else {
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"NO TIENE ID ORDEN DE SURTIDO:" . $l_nIDOrdenDeSurtido_Deta];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;   
                exit(1);  
            }

            
        }

    }
   
    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>"GRABADO CON EXITO"];            
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
 
 
 
// ***********************************************************
    
?> 
  