<?php
// ----------------------------------------------------------------------------------
// packinglist_deta_consultar.api.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//             - Recibe una condición en JSON con el método de acceso POST.
//                { condicion:[info consulta], 
//                  campodeordenamiento:[campo], 
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
include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php"; 
include_once "../clases/productos_series.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";

 
$retorno= array();
$arreglos = array();
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));

$l_Sesion=trim($arreglos->{"sesion"});
$l_nIDUsuario=trim($arreglos->{"nidusuario"});
$l_Condicion=trim($arreglos->{"condicion"});

if(strlen($l_Sesion)<=0){
    if(!empty($_GET)){ 
        if (isset($_GET['sesion'])){
            $l_Sesion=$_GET['sesion']; 
        }    
    }
}

if(strlen($l_nIDUsuario)<=0){
    if(!empty($_GET)){ 
        if (isset($_GET['nidusuario'])){
            $l_nIDUsuario=$_GET['nidusuario']; 
        }    
    }
}

if(strlen($l_Condicion)<=0){
    if(!empty($_GET)){ 
        if (isset($_GET['condicion'])){
            $l_Condicion=$_GET['condicion']; 
        }    
    }
}

if(strlen($l_Condicion)<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE REGISTROS"];
 
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}



// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true); 
// ----------------------------------------------
 

$tbl_Enca = new   cltbl_Packinglist_v2_0_0();
$tbl_Deta = new   cltbl_Packinglist_Deta_v2_0_0();
$tbl_Cat_Productos_Serie = new  cltbl_Cat_Productos_Series_v2_0_0();

// Busca el ID del packinglist
$l_nIDEnca=0;
$tbl_Enca->Inicializacion();
$tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_Enca->CargarCampos("LEER");
$Campo_Llave=$tbl_Enca->get_CampoLlave();
$tbl_Enca->Leer($l_Condicion);

if($tbl_Enca->CualEsElNumeroDeRegistrosCargados()>0){
        
    $registros=$tbl_Enca->dtBase();

    $l_nIDEnca=$registros[0]["nIDPackingList"];

    if($l_nIDEnca>0){
        $tbl_Deta->Inicializacion();
        $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Deta->CargarCampos("LEER");

        $l_Condicion="nIDPackingList=" . $l_nIDEnca . " and bEstado=0";

        $tbl_Deta->Leer($l_Condicion);

        if($tbl_Deta->CualEsElNumeroDeRegistrosCargados()>0){
            $registros=$tbl_Deta->dtBase();

            for($j=0;$j<$tbl_Deta->CualEsElNumeroDeRegistrosCargados();$j=$j+1){
                $datos=array();
      
                $datos=$datos + ["retorno"=>"TRUE"];
                $datos=$datos + ["msg"=>""];
                $datos=$datos + ["llave"=>$Campo_Llave]; 

                $l_Escanear=0;
                $l_nIDProducto=$registros[$j]["nIDProducto"];
                $tbl_Cat_Productos_Serie->Inicializacion();
                $tbl_Cat_Productos_Serie->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Cat_Productos_Serie->Leer("nIDPackingList=" . $l_nIDEnca . " and nIDProducto=" . $l_nIDProducto);
                $l_Escanear=$tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados();
                $datos=$datos + ["Escanear"=>$l_Escanear];  
 
                $l_Codigo=$registros[$j]["Codigo"];
                $datos=$datos + ["Codigo"=>$l_Codigo];  

                $l_Producto=$registros[$j]["Producto"];
                $datos=$datos + ["Producto"=>$l_Producto];  

                $l_Cajas=$registros[$j]["Cajas"];
                $datos=$datos + ["Cajas"=>$l_Cajas];  
   
                $l_CantidadCaja=$registros[$j]["CantidadCaja"];
                $datos=$datos + ["CantidadCaja"=>$l_CantidadCaja];  

                $l_Estatus=$registros[$j]["Estatus"];
                $datos=$datos + ["Estatus"=>$l_Estatus];  

                $l_Leidos_Barras=$registros[$j]["Leidos_Barras"];
                $datos=$datos + ["Leidos"=>$l_Leidos_Barras];
            
                // Extrae la info de los campos
                for($k=0;$k<$tbl_Deta->get_NumCampos();$k=$k+1){
                    $campo=$tbl_Deta->get_Estructura($k);
                    $valor=$registros[$j][$tbl_Deta->get_Estructura($k)];
                    $datos=$datos + [$campo=>$valor];                          
                }
                
                array_push($retorno,$datos);   
            }

            $retorno=json_encode($retorno);	 
            echo $retorno;    

        } else {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"NO TIENE REGISTROS ETIQUETA"];
     
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
        }


    } else {

        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE REGISTROS"];
 
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
    }

} else {

    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE REGISTROS"];
 
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    

}


 
 
?> 
  