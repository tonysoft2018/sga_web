<?php
// ----------------------------------------------------------------------------------
// reporte_inventario_todos.php
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
include_once "../clases/salidas.mysql.class_v2.0.0.php";  
include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
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
$tbl_Entradas = new  cltbl_Entradas_v2_0_0();  
$tbl_Salidas = new  cltbl_Salidas_v2_0_0();
$tbl_Productos = new  cltbl_Cat_Productos_v2_0_0();


for($i=0;$i<$l_NumeroDeRegistros;$i++){ 
    $l_FechaInicio=$arreglos[$i]->{"fecha_inicio"};
    $l_FechaFin=$arreglos[$i]->{"fecha_fin"};
    
    if(strlen($l_FechaInicio)<0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE FECHA DE INICIO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }

    $l_FechaInicio=$l_FechaInicio . " 00:00:01";
    $l_FechaFin=$l_FechaFin . " 23:59:00";
    

    // Busca el codigoQR en el packinglist
    $l_Condicion="Fecha>='" . $l_FechaInicio . "' and Fecha<='" . $l_FechaFin ."'";
    
    //echo "Condicion:" . $l_Condicion;
    if(strlen($l_Condicion)>0){
        $l_nIDProducto=0;
        $l_Codigo="";
        $l_Producto="";
        $l_UnidadDeMedida="";

        $l_Almacen="";
        $l_Tipo="";


        $l_Entradas=0;
        $l_Salidas=0;
        $l_Existencias=0;

        $tbl_Entradas->Inicializacion();
        $tbl_Entradas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Entradas->Leer($l_Condicion);
        if($tbl_Entradas->CualEsElNumeroDeRegistrosCargados()>0){

            $registros_entradas=$tbl_Entradas->dtBase();

            // Entradas
            for($j=0;$j<$tbl_Entradas->CualEsElNumeroDeRegistrosCargados();$j=$j+1){

                // Datos de Entrada
                $l_nIDProducto=$registros_entradas[$j]["nIDProducto"];
                $l_Codigo="";
                $l_Producto="";
                $l_UnidadDeMedida="";  
                
                $l_Almacen="";
                $l_Tipo="";
                
                $l_Entradas=$registros_entradas[$j]["Cantidad"];
                $l_Tipo="ENTRADA-" . $registros_entradas[$j]["TipoEntrada"];
                $l_Almacen=$registros_entradas[$j]["Almacen"];
               
                // Buscar datos del producto
                $l_Condicion_Producto="nIDProducto=" . $l_nIDProducto;
                $tbl_Productos->Inicializacion();
                $tbl_Productos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Productos->Leer($l_Condicion_Producto);
                if($tbl_Productos->CualEsElNumeroDeRegistrosCargados()>0){
                    $registros_productos=$tbl_Productos->dtBase();

                    $l_Codigo=$registros_productos[0]["Codigo_IZeta"];
                    $l_Producto=$registros_productos[0]["Producto"];
                    $l_UnidadDeMedida=$registros_productos[0]["UnidadDeMedida"];
                }
 
                $datos=array();
                $datos=$datos + ["retorno"=>"TRUE"];
                $datos=$datos + ["msg"=>""];   
     
                $datos=$datos + ["Almacen"=>$l_Almacen];
                $datos=$datos + ["nIDProducto"=>$l_nIDProducto];
                $datos=$datos + ["Codigo_IZeta"=>$l_Codigo];
                $datos=$datos + ["Producto"=>$l_Producto];
                $datos=$datos + ["UnidadDeMedida"=>$l_UnidadDeMedida];
                $datos=$datos + ["Entradas"=>$l_Entradas];
                $datos=$datos + ["Tipo"=>$l_Tipo];
                $datos=$datos + ["Cantidad"=>$l_Entradas];
                       
                array_push($retorno,$datos);   
            }

        } 

      
        //Salidas
        $tbl_Salidas->Inicializacion();
        $tbl_Salidas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Salidas->Leer($l_Condicion);
          if($tbl_Salidas->CualEsElNumeroDeRegistrosCargados()>0){

            $registros_entradas=$tbl_Salidas->dtBase();

            // Entradas
            for($j=0;$j<$tbl_Salidas->CualEsElNumeroDeRegistrosCargados();$j=$j+1){

                // Datos de Entrada
                $l_nIDProducto=$registros_entradas[$j]["nIDProducto"];
                $l_Codigo="";
                $l_Producto="";
                $l_UnidadDeMedida="";  
                
                $l_Almacen="";
                $l_Tipo="";
                
                $l_Salidas=$registros_entradas[$j]["Cantidad"];
                $l_Tipo="SALIDA-" . $registros_entradas[$j]["TipoSalida"];
                $l_Almacen=$registros_entradas[$j]["Almacen"];
               
                // Buscar datos del producto
                $l_Condicion_Producto="nIDProducto=" . $l_nIDProducto;
                $tbl_Productos->Inicializacion();
                $tbl_Productos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Productos->Leer($l_Condicion_Producto);
                if($tbl_Productos->CualEsElNumeroDeRegistrosCargados()>0){
                    $registros_productos=$tbl_Productos->dtBase();

                    $l_Codigo=$registros_productos[0]["Codigo_IZeta"];
                    $l_Producto=$registros_productos[0]["Producto"];
                    $l_UnidadDeMedida=$registros_productos[0]["UnidadDeMedida"];
                }
 
                $datos=array();
                $datos=$datos + ["retorno"=>"TRUE"];
                $datos=$datos + ["msg"=>""];   
     
                $datos=$datos + ["Almacen"=>$l_Almacen];
                $datos=$datos + ["nIDProducto"=>$l_nIDProducto];
                $datos=$datos + ["Codigo_IZeta"=>$l_Codigo];
                $datos=$datos + ["Producto"=>$l_Producto];
                $datos=$datos + ["UnidadDeMedida"=>$l_UnidadDeMedida];
                $datos=$datos + ["Entradas"=>$l_Salidas];
                $datos=$datos + ["Tipo"=>$l_Tipo];
                $datos=$datos + ["Cantidad"=>$l_Salidas];
                       
                array_push($retorno,$datos);   
            }

        } 
  

        if(count($retorno)>0){
            $retorno=json_encode($retorno);	 
            echo $retorno;    
        } else {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"NO TIENE EXISTENCIAS"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
        }


    } else {
        // No tiene codigo qr
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE SELECCIONADO EL ALMACEN"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }
}
 
 
?> 
  