<?php
// ----------------------------------------------------------------------------------
// ubicaciones_consultar.php
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
include_once "../clases/cat_matriz.mysql.class_v2.0.0.php"; 
include_once "../clases/ubicaciones.mysql.class_v2.0.0.php"; 
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
$tbl = new  cltbl_Cat_Matriz_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$Campo_Llave=$tbl->get_CampoLlave();

$tbl_Ubicaciones = new  cltbl_Ubicaciones_v2_0_0();



for($i=0;$i<$l_NumeroDeRegistros;$i++){
    $l_nIDCat_Almacen=$arreglos[$i]->{"nid"};
    $l_nIDCat_Matriz=0;

    if($l_nIDCat_Almacen<0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ID DEL ALMACEN"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
    }

    $l_Condicion="nIDCat_Almacen=" . $l_nIDCat_Almacen ." and bEstado=0";
  
    if(strlen($l_Condicion)>0){
        $tbl->Inicializacion();
        $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl->Leer($l_Condicion);

        if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
            
           
            $registros=$tbl->dtBase();

            $datos=array();
            $especiales=array();
            $combo=array();

            for($j=0;$j<$tbl->CualEsElNumeroDeRegistrosCargados();$j=$j+1){
                $datos=array();

                $l_nIDCat_Matriz=$registros[$j]["nIDCat_Matriz"];
                $l_IDAlmacen=$registros[$j]["IDAlmacen"];
                $l_Almacen=$registros[$j]["Almacen"];
                $l_Pasillo=$registros[$j]["Pasillo"];
                $l_Rack=$registros[$j]["Rack"];
                $l_Columna=$registros[$j]["Columna"];
                $l_Nivel=$registros[$j]["Nivel"];
                $l_SubNivel=$registros[$j]["SubNivel"];

                //echo "nID:" .$l_nIDCat_Matriz;

              
                if($l_nIDCat_Matriz>0){
                    // Buscar la matirz en las ubicaciones
                    $tbl_Ubicaciones->Inicializacion();
                    $tbl_Ubicaciones->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                    $tbl_Ubicaciones->CargarCampos("LEER");
                    $tbl_Ubicaciones->Leer("nIDCat_Matriz=" . $l_nIDCat_Matriz . " and bEstado=0");

                    if($tbl_Ubicaciones->CualEsElNumeroDeRegistrosCargados()<=0){ 
                        
                        $datos=$datos + ["retorno"=>"TRUE"];
                        $datos=$datos + ["msg"=>""];                         
                        $datos=$datos + ["nIDCat_Matriz"=>$l_nIDCat_Matriz];
                        $datos=$datos + ["IDAlmacen"=>$registros[$j]["IDAlmacen"]];
                        $datos=$datos + ["Almacen"=>$registros[$j]["Almacen"]];
                        $datos=$datos + ["RazonSocial"=>$registros[$j]["RazonSocial"]];
                        $datos=$datos + ["Pasillo"=>$registros[$j]["Pasillo"]];
                        $datos=$datos + ["Rack"=>$registros[$j]["Rack"]];
                        $datos=$datos + ["Columna"=>$registros[$j]["Columna"]];
                        $datos=$datos + ["Nivel"=>$registros[$j]["Nivel"]];
                        $datos=$datos + ["SubNivel"=>$registros[$j]["SubNivel"]];

                        //print_r($datos);
                        array_push($retorno,$datos);   
                    } else {
                        
                    }
                    
                    unset($datos);
                }                                 
            }

            if(count($retorno)>0){
                $retorno=json_encode($retorno);	 
                echo $retorno;    
            } else {
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"NO TIENE UBICACIONES DISPONIBLES"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
            }
            
            
        } else {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ALMACEN NO DISPONIBLE"];
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
  