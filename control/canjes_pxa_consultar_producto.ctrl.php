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

for($i=0;$i<$l_NumeroDeRegistros;$i++){    
    $l_Codigo=trim($arreglos[$i]->{"codigo"});
    $l_nIDCat_Almacen=trim($arreglos[$i]->{"nidcat_almacen"});
    $l_Cantidad=trim($arreglos[$i]->{"cantidad"});
    $l_Puntos=trim($arreglos[$i]->{"puntos"});
    $l_nIDCat_Cliente=trim($arreglos[$i]->{"nidcat_cliente"});
 
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

    if(strlen($l_nIDCat_Almacen)<=0){        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALTAN ID DEL ALMACEN"];
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


    // ---------------------------------------------------------------------------------------------------
    // Valida los puntos del producto vs cliente
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

    if($l_Puntos>$l_PuntosCliente){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENES PUNTOS SUFICIENTES"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }
    // ---------------------------------------------------------------------------------------------------

    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>"PROCESO FINALIZADO CON EXITO"];
    $datos=$datos + [ "nidproducto"=>$l_nIDProducto ];
    $datos=$datos + [ "codigo"=>$l_Codigo ];
    $datos=$datos + [ "producto"=>$l_Producto ];
    $datos=$datos + [ "descripcion"=>$l_Descripcion ];
    $datos=$datos + [ "puntos"=>$l_Puntos ];

    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);


 
} 
?> 
  