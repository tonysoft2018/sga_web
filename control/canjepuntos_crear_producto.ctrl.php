<?php
// ----------------------------------------------------------------------------------
// canjes_pxa_consultar_producto.ctrl.php
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
include_once "../clases/canjes_enca.mysql.class_v2.0.0.php"; 
include_once "../clases/canjes_deta.mysql.class_v2.0.0.php"; 
include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
include_once "../clases/entradas.mysql.class_v2.0.0.php";
include_once "../clases/salidas.mysql.class_v2.0.0.php";  
include_once "../clases/cat_clientes.mysql.class_v2.0.0.php";  
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

/*
    obj["codigo"]=Codigo;
    obj["nidcat_centrodeservicio"]=nIDCat_CentroDeServicio;
    obj["nidcat_almacen"]=nIDCat_Almacen;
    obj["nidcat_cliente"]=nIDCat_Cliente;
    obj["nidusuario"]=nIDUsuario;
    obj["cantidad"]=Cantidad;
    obj["puntos"]=Puntos;
    obj["nid"]=nID;
*/

$tbl_Enca = new  cltbl_Canjes_v2_0_0();
$tbl_Deta = new  cltbl_Canjes_Deta_v2_0_0();
$tbl_Cat_Produtos = new  cltbl_Cat_Productos_v2_0_0();
$tbl_Entradas = new  cltbl_Entradas_v2_0_0();
$tbl_Salidas = new  cltbl_Salidas_v2_0_0();
$tbl_Cat_Clientes = new  cltbl_Cat_Clientes_v2_0_0();

$i=0;
$l_nIDCat_Almacen=trim($arreglos[$i]->{"nidcat_almacen"});
$l_nIDCat_CentroDeServicio=trim($arreglos[$i]->{"nidcat_centrosdeservicio"});   
$l_nIDCat_Cliente=trim($arreglos[$i]->{"nidcat_cliente"});
$l_nIDUsuario=trim($arreglos[$i]->{"nidusuario"});
$l_Estatus = "CERRADO";

// ---------------------------------------------------------------------------------------------------
// Verificación
if(strlen($l_nIDCat_Almacen)<=0){        
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALTAN ID DEL ALMACEN"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);       
}

if(strlen($l_nIDCat_CentroDeServicio)<=0){        
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALTAN ID DEL CENTRO DE SERVICIO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);       
}

if(strlen($l_nIDUsuario)<=0){        
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALTAN ID DEL USUARIO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);       
}

if(strlen($l_nIDCat_Cliente)<=0){        
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALTAN ID DEL CLIENTE"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);       
}
// ---------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------
if(strlen($l_nIDCat_Almacen)>0){        
    if(!is_int($l_nIDCat_Almacen)) {
        $l_nIDCat_Almacen=intval($l_nIDCat_Almacen);
       
        if($l_nIDCat_Almacen<=0){
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ID DEL ALMACEN ES INVALIDO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        }
    }                                 
}  



if(strlen($l_nIDCat_Cliente)>0){        
    if(!is_int($l_nIDCat_Cliente)) {
        $l_nIDCat_Cliente=intval($l_nIDCat_Cliente);
       
        if($l_nIDCat_Cliente<=0){
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ID DEL CLIENTE ES INVALIDO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        }
    }                                 
}  

if(strlen($l_nIDCat_CentroDeServicio)>0){        
    if(!is_int($l_nIDCat_CentroDeServicio)) {
        $l_nIDCat_CentroDeServicio=intval($l_nIDCat_CentroDeServicio);
       
        if($l_nIDCat_CentroDeServicio<=0){
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ID DEL CENTRO DE SERVICIO ES INVALIDO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        }
    }                                 
}  

if(strlen($l_nIDUsuario)>0){        
    if(!is_int($l_nIDUsuario)) {
        $l_nIDUsuario=intval($l_nIDUsuario);
       
        if($l_nIDUsuario<=0){
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ID DEL USUARIO ES INVALIDO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        }
    }                                 
}  
// ---------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------
// BASICOS
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
// ---------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------
// FOLIO
$l_Folio=0;
$tbl = new  cltbl_Canjes_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$Campo_Llave=$tbl->get_CampoLlave();  
$l_Folio=$tbl->getSiguienteFolio(); 
if($l_Folio<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FOLIO INVALIDO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
} 
// ---------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------
// CLIENTE PUNTOS
$l_PuntosCliente=0;
$tbl_Cat_Clientes->Inicializacion();
$tbl_Cat_Clientes->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_Cat_Clientes->Leer("nIDCat_Cliente=". $l_nIDCat_Cliente ." and bEstado=0");
if($tbl_Cat_Clientes->CualEsElNumeroDeRegistrosCargados()>0){
    $registros=$tbl_Cat_Produtos->dtBase();       
    $l_PuntosCliente=$registros[0]["Puntos"];
} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"CLIENTE NO ENCONTRADO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}

if($l_PuntosCliente<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENES PUNTOS SUFICIENTES"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
// ---------------------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------------------
// TOTAL DE PUNTOS DE LOS PRODUCTOS A CANJEAR
$l_TotalDePuntos=0;
for($i=0;$i<$l_NumeroDeRegistros;$i++){    
    $l_Codigo=trim($arreglos[$i]->{"codigo"});
    $l_Cantidad=trim($arreglos[$i]->{"cantidad"});

    // ---------------------------------------------------------------------------------------------------
    // Verificación 
    if(strlen($l_Codigo)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN ESTATUS"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

    if(strlen($l_Cantidad)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN LA CANTIDAD"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);       
    } 
    // ---------------------------------------------------------------------------------------------------
   
 
    // ---------------------------------------------------------------------------------------------------
    // Validación 
    if(strlen($l_Cantidad)>0){        
        if(!is_int($l_Cantidad)) {
            $l_Cantidad=intval($l_Cantidad);
             if($l_Cantidad<=0){
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"LA CANTIDAD DEBE DE SER UN VALOR NUMERICO ENTERO MAYOR A CERO"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }
        }       
    }       
    // ---------------------------------------------------------------------------------------------------
 

    // ---------------------------------------------------------------------------------------------------
    // Verifica la existencia del producto
    $l_nIDProducto=0;
    $l_Producto="";
    $l_Descripcion="";
    $l_Puntos=0;

    $l_Condicion="(Codigo='" .$l_Codigo . "' or Codigo_IZeta='" .$l_Codigo . "') and bEstado=0";

    //echo "Cond:" .$l_Condicion;
    $tbl_Cat_Produtos->Inicializacion();
    $tbl_Cat_Produtos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Cat_Produtos->Leer($l_Condicion);
    if($tbl_Cat_Produtos->CualEsElNumeroDeRegistrosCargados()>0){
        $registros=$tbl_Cat_Produtos->dtBase();
        $l_nIDProducto=$registros[0]["nIDProducto"];
        $l_Producto=$registros[0]["Producto"];
        $l_Descripcion=$registros[0]["Descripcion"];
        $l_Puntos=$registros[0]["Puntos"];
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"CODIGO DE PRODUCTO NO ENCONTRADO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

    $l_TotalDePuntos=$l_TotalDePuntos + ($l_Puntos*$l_Cantidad);
    // ---------------------------------------------------------------------------------------------------
}

if($l_TotalDePuntos>$l_PuntosCliente){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"PUNTOS DEL CLIENTE INSUFICIENTES"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
// ---------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------
// Verifica Existencias
for($i=0;$i<$l_NumeroDeRegistros;$i++){    
    $l_Codigo=trim($arreglos[$i]->{"codigo"});
    $l_Cantidad=trim($arreglos[$i]->{"cantidad"});
   
    // ---------------------------------------------------------------------------------------------------
    // Verificación 
    if(strlen($l_Codigo)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN ESTATUS"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

    if(strlen($l_Cantidad)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN LA CANTIDAD"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);       
    } 
    // ---------------------------------------------------------------------------------------------------   
 
    // ---------------------------------------------------------------------------------------------------
    // Validación 
    if(strlen($l_Cantidad)>0){        
        if(!is_int($l_Cantidad)) {
            $l_Cantidad=intval($l_Cantidad);
             if($l_Cantidad<=0){
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"LA CANTIDAD DEBE DE SER UN VALOR NUMERICO ENTERO MAYOR A CERO"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }
        }       
    }       
    // ---------------------------------------------------------------------------------------------------
 

    // ---------------------------------------------------------------------------------------------------
    // Verifica la existencia del producto
    $l_nIDProducto=0;
    $l_Producto="";
    $l_Descripcion="";
    $l_Puntos=0;

    $l_Condicion="(Codigo='" .$l_Codigo . "' or Codigo_IZeta='" .$l_Codigo . "') and bEstado=0";

    //echo "Cond:" .$l_Condicion;
    $tbl_Cat_Produtos->Inicializacion();
    $tbl_Cat_Produtos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Cat_Produtos->Leer($l_Condicion);
    if($tbl_Cat_Produtos->CualEsElNumeroDeRegistrosCargados()>0){
        $registros=$tbl_Cat_Produtos->dtBase();
        $l_nIDProducto=$registros[0]["nIDProducto"];       
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"CODIGO DE PRODUCTO NO ENCONTRADO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }    
    // ---------------------------------------------------------------------------------------------------

    // ---------------------------------------------------------------------------------------------------
    // Verifica las existencias del producto
    $l_Condicion="nIDProducto=" . $l_nIDProducto . " and nIDCat_Almacen=" . $l_nIDCat_Almacen;    
    $tbl_Entradas->Inicializacion();
    $tbl_Entradas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);    
    $tbl_Entradas->Existencias($l_Condicion);
    $Entradas=$tbl_Entradas->dtexistencias[0]["Cantidad"];

    $tbl_Salidas->Inicializacion();
    $tbl_Salidas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Salidas->Existencias("nIDProducto=" . $l_nIDProducto . " and nIDCat_Almacen=" . $l_nIDCat_Almacen );
    $Salidas=$tbl_Salidas->dtexistencias[0]["Cantidad"];

    $Existencias=$Entradas - $Salidas;
 
    if($l_Cantidad > $Existencias){ 
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"EL PRODUCTO NO TIENE SUFICIENTES EXISTENCIAS"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }
    // ---------------------------------------------------------------------------------------------------
     
} 
// ---------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------
// ENCABEZADO
$l_nIDEnca=0;
$datos_grabar_encabezado = array();

array_push($datos_grabar_encabezado,0);
array_push($datos_grabar_encabezado,$l_Folio);   
array_push($datos_grabar_encabezado,$l_FechaLocal);    
array_push($datos_grabar_encabezado,$l_nIDCat_Cliente);     
array_push($datos_grabar_encabezado,$l_nIDCat_CentroDeServicio);
array_push($datos_grabar_encabezado,$l_nIDCat_Almacen);
array_push($datos_grabar_encabezado,$l_nIDUsuario);  
array_push($datos_grabar_encabezado,$l_Estatus);

array_push($datos_grabar_encabezado,$l_FechaLocal);
array_push($datos_grabar_encabezado,$l_FechaLocal);
array_push($datos_grabar_encabezado,$l_Observaciones);
array_push($datos_grabar_encabezado,0);

$registro_datos_encabezado=array($datos_grabar_encabezado[0]);
for($j=1;$j<count($datos_grabar_encabezado);$j++){
    array_push($registro_datos_encabezado,$datos_grabar_encabezado[$j]);
}
array_push($registro_datos_encabezado,1); // Crear 
array_push($registro_datos_encabezado,0); // Cambiar
array_push($registro_datos_encabezado,0); // Eliminar
 
$tbl_Enca->Inicializacion();
$tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_Enca->CargarCampos("GRABAR");
$tbl_Enca->setInformacion_Grabar($registro_datos_encabezado);

if($tbl_Enca->Ejecutar()){
    $tbl_Enca->Inicializacion();
    $tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Enca->Leer($l_Condicion);
    if($tbl_Enca->CualEsElNumeroDeRegistrosCargados()>0){
        $registros=$tbl_Enca->dtBase();
        $l_nIDEnca=$registros[0]["nIDCanje"];      
        
        if($l_nIDEnca<=0){
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE GRABAR EL ENCABEZADO - INVALIDO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        }
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE GRABAR EL ENCABEZADO - NO ENCONTRADO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }    
         
} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE GRABAR EL ENCABEZADO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}


unset($datos_grabar_encabezado);
unset($registro_datos_encabezado);
// ---------------------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------------------
// DETALLES
$registros_grabados=0;
for($i=0;$i<$l_NumeroDeRegistros;$i++){    
    $l_Codigo=trim($arreglos[$i]->{"codigo"});
    $l_Cantidad=trim($arreglos[$i]->{"cantidad"});
   
    // ---------------------------------------------------------------------------------------------------
    // Verificación 
    if(strlen($l_Codigo)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN ESTATUS"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

    if(strlen($l_Cantidad)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN LA CANTIDAD"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);       
    } 
    // ---------------------------------------------------------------------------------------------------
   
 
    // ---------------------------------------------------------------------------------------------------
    // Validación 
    if(strlen($l_Cantidad)>0){        
        if(!is_int($l_Cantidad)) {
            $l_Cantidad=intval($l_Cantidad);
             if($l_Cantidad<=0){
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"LA CANTIDAD DEBE DE SER UN VALOR NUMERICO ENTERO MAYOR A CERO"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }
        }       
    }       
    // ---------------------------------------------------------------------------------------------------
 

    // ---------------------------------------------------------------------------------------------------
    // Verifica la existencia del producto
    $l_nIDProducto=0;
    $l_Puntos=0;
    $l_Condicion="(Codigo='" .$l_Codigo . "' or Codigo_IZeta='" .$l_Codigo . "') and bEstado=0";

    //echo "Cond:" .$l_Condicion;
    $tbl_Cat_Produtos->Inicializacion();
    $tbl_Cat_Produtos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Cat_Produtos->Leer($l_Condicion);
    if($tbl_Cat_Produtos->CualEsElNumeroDeRegistrosCargados()>0){
        $registros=$tbl_Cat_Produtos->dtBase();
        $l_nIDProducto=$registros[0]["nIDProducto"]; 
        $l_Puntos=$registros[0]["Puntos"]; 
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"CODIGO DE PRODUCTO NO ENCONTRADO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }
   
    // --------------------------------------------------------------------------------------------------    
    
    // --------------------------------------------------------------------------------------------------   
    // GRABA EL DETALLE 
    $datos_grabar_detalles = array();

    array_push($datos_grabar_detalles,0);
    array_push($datos_grabar_detalles,$l_nIDEnca);
    array_push($datos_grabar_detalles,$l_nIDProducto);
    array_push($datos_grabar_detalles,$l_Cantidad);
    array_push($datos_grabar_detalles,$l_Puntos);
 
    array_push($datos_grabar_detalles,$l_FechaLocal);
    array_push($datos_grabar_detalles,$l_FechaLocal);
    array_push($datos_grabar_detalles,$l_Observaciones);
    array_push($datos_grabar_detalles,0);
    
    $registro_datos_detalles=array($datos_grabar_detalles[0]);
    for($j=1;$j<count($datos_grabar_detalles);$j++){
        array_push($registro_datos_detalles,$datos_grabar_detalles[$j]);
    }
    array_push($registro_datos_detalles,1); // Crear 
    array_push($registro_datos_detalles,0); // Cambiar
    array_push($registro_datos_detalles,0); // Eliminar
     

    $tbl_Deta->Inicializacion();
    $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Deta->CargarCampos("GRABAR");
    $tbl_Deta->setInformacion_Grabar($registro_datos_encabezado);
    if($tbl_Deta->Ejecutar()){
        // --------------------------------------------------------------------------------------------------   
        // SALIDA
     
        $l_Folio=0;          
        $tbl_Salidas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Salidas->CargarCampos("LEER");
        $l_Folio=$tbl_Salidas->getSiguienteFolio();

        $l_TipoSalida="CANJES";
        $l_Estatus="NO ACTUALIZADO";      

        $l_nIDPackingList=0;
        $l_nIDCat_Proveedor=0;
        $l_Comentarios="";     
        $l_NoFactura="";

        // Graba la Salida
        $datos_grabar = array();
                    
        array_push($datos_grabar,0);
        array_push($datos_grabar,$l_Folio);
        array_push($datos_grabar,$l_FechaLocal);
        array_push($datos_grabar,$l_nIDProducto);    
        array_push($datos_grabar,$l_Codigo);
        array_push($datos_grabar,"");
        array_push($datos_grabar,$l_Cantidad);
        array_push($datos_grabar,0);
        array_push($datos_grabar,$l_nIDUsuario);
        array_push($datos_grabar,$l_nIDCat_Almacen);
        array_push($datos_grabar,$l_Estatus);
        array_push($datos_grabar,$l_TipoSalida);
        array_push($datos_grabar,$l_nIDEnca);
        array_push($datos_grabar,0);
        array_push($datos_grabar,$l_Comentarios);

        array_push($datos_grabar,$l_FechaLocal);
        array_push($datos_grabar,$l_FechaLocal);
        array_push($datos_grabar,$l_Observaciones);
        array_push($datos_grabar,0);

        $registro_datos=array($datos_grabar[0]);
        for($k=1;$k<count($datos_grabar);$k++){
            array_push($registro_datos,$datos_grabar[$k]);
         }
        array_push($registro_datos,1); // Crear 
        array_push($registro_datos,0); // Cambiar
        array_push($registro_datos,0); // Eliminar

        $tbl_Salidas->Inicializacion();
        $tbl_Salidas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Salidas->CargarCampos("GRABAR");
        $tbl_Salidas->setInformacion_Grabar($registro_datos);
               
        if($tbl_Salidas->Ejecutar()){
            $registros_grabados=$registros_grabados+1;
        } else {
            // Elimina el encabezado   
            $l_Condicion="nIDEnca=" .$l_nIDEnca;

            // Encabezado
            $tbl_Enca->Inicializacion();
            $tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Enca->EliminarConCondicion($l_Condicion);

            // Detalle
            $tbl_Deta->Inicializacion();
            $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Deta->EliminarConCondicion($l_Condicion);
  
            // Salidas
            $l_Condicion="TipoSalida='CANJES' and nIDReferencia=" . $l_nIDEnca;
            $tbl_Salidas->Inicializacion();
            $tbl_Salidas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Salidas->EliminarConCondicion($l_Condicion);

            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE PROCESAR LOS REGISTROS"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        }
     
         unset($registro_datos);
         unset($datos_grabar);
        // --------------------------------------------------------------------------------------------------   

    }

    
    unset($datos_grabar_detalles);
    unset($registro_datos_detalles);
    // -------------------------------------------------------------------------------------------------- 
    
  
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
    // Elimina los detalles
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE PROCESAR LOS REGISTROS"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
?> 
  