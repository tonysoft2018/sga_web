<?php
// ----------------------------------------------------------------------------------
// cat_productos_consultar_datos.ctrl.php
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
$tbl = new   cltbl_Cat_Productos_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$Campo_Llave=$tbl->get_CampoLlave();


for($i=0;$i<$l_NumeroDeRegistros;$i++){
    $l_Codigo_IZeta=strval($arreglos[$i]->{"codigo_izeta"});
    $l_Condicion="Codigo_IZeta='" . $l_Codigo_IZeta . "' and bEstado=0";

    //echo "Condicion:" . $l_Condicion;
  
    if(strlen($l_Condicion)>0){
 
        $tbl->Inicializacion();
        $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);    
         
        $tbl->Leer($l_Condicion);
 
        if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
            
            $registros=$tbl->dtBase();
            $datos=array();
            $datos=$datos + ["retorno"=>"TRUE"];
            $datos=$datos + ["msg"=>""];
            $datos=$datos + ["llave"=>$Campo_Llave];
            
            $datos=$datos + [ "nidproducto"=>$registros[0]["nIDProducto"] ];
            $datos=$datos + [ "producto"=>$registros[0]["Producto"] ];
            $datos=$datos + [ "descripcion"=>$registros[0]["Descripcion"] ];
            $datos=$datos + [ "unidaddemedida"=>$registros[0]["UnidadDeMedida"] ];   
            $datos=$datos + [ "puntos"=>$registros[0]["Puntos"] ];                     
            array_push($retorno,$datos);   
            
            $retorno=json_encode($retorno);	 
            echo $retorno;    
 
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
   
}
 
 
?> 
  