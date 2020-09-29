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
include_once "../clases/packinglist.mysql.class_v2.0.0.php"; 
include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php"; 
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
$tbl_Matriz = new  cltbl_Cat_Matriz_v2_0_0();  
$tbl_Ubicaciones = new  cltbl_Ubicaciones_v2_0_0();
$tbl_PackingList = new  cltbl_Packinglist_v2_0_0();
$tbl_PackingList_Deta = new  cltbl_PackingList_Deta_v2_0_0();


for($i=0;$i<$l_NumeroDeRegistros;$i++){
    $l_CodigoQR=$arreglos[$i]->{"codigoqr"};
    $l_nIDCat_Almacen=$arreglos[$i]->{"nidcat_almacen"};
    $l_nIDCat_Matriz=$arreglos[$i]->{"nidcat_matriz"};
    
    if($l_nIDCat_Almacen<0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ID DEL ALMACEN"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }


    if($l_nIDCat_Matriz<0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ID DE LA MATRIZ DE UBICACIONES"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

    if(strlen($l_CodigoQR)<0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE CODIGO QR"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

    // Busca el codigoQR en el packinglist
    $l_Condicion="CodigoQR='" . $l_CodigoQR ."' and bEstado=0";
    
    if(strlen($l_Condicion)>0){
        $tbl_PackingList_Deta->Inicializacion();
        $tbl_PackingList_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_PackingList_Deta->Leer($l_Condicion);
        if($tbl_PackingList_Deta->CualEsElNumeroDeRegistrosCargados()>0){

            $registros_packing_deta=$tbl_PackingList_Deta->dtBase();

            // Verifica que el codigo QR no haya sido ubicado previamente.
            $tbl_Ubicaciones->Inicializacion();
            $tbl_Ubicaciones->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Ubicaciones->Leer($l_Condicion);
            if($tbl_Ubicaciones->CualEsElNumeroDeRegistrosCargados()<=0){
                // No ubicado

                 
                // Busca la matriz
                $l_Condicion="nIDCat_Matriz=" . $l_nIDCat_Matriz . " and bEstado=0";
                $tbl_Matriz->Inicializacion();
                $tbl_Matriz->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Matriz->Leer($l_Condicion);
                      
                if($tbl_Matriz->CualEsElNumeroDeRegistrosCargados()>0){
       
                    $registros_matriz=$tbl_Matriz->dtBase();

                
                    // Busca los datos de
                    $datos=array();
                    $datos=$datos + ["retorno"=>"TRUE"];
                    $datos=$datos + ["msg"=>""];   
 
                    $datos=$datos + ["nIDCat_Matriz"=>$l_nIDCat_Matriz];

                    $datos=$datos + ["IDAlmacen"=>$registros_matriz[0]["IDAlmacen"]];
                    $datos=$datos + ["Almacen"=>$registros_matriz[0]["Almacen"]];
                    $datos=$datos + ["RazonSocial"=>$registros_matriz[0]["RazonSocial"]];
                    
                    $datos=$datos + ["Pasillo"=>$registros_matriz[0]["Pasillo"]];
                    $datos=$datos + ["Rack"=>$registros_matriz[0]["Rack"]];
                    $datos=$datos + ["Columna"=>$registros_matriz[0]["Columna"]];
                    $datos=$datos + ["Nivel"=>$registros_matriz[0]["Nivel"]];
                    $datos=$datos + ["SubNivel"=>$registros_matriz[0]["SubNivel"]];

                    $datos=$datos + ["Codigo"=>$registros_packing_deta[0]["Codigo"]];
                    $datos=$datos + ["Producto"=>$registros_packing_deta[0]["Producto"]];
                    $datos=$datos + ["CantidadCaja"=>$registros_packing_deta[0]["CantidadCaja"]];

                  
                    array_push($retorno,$datos);   

                    if(count($datos)>0){
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
                    $datos=$datos + ["msg"=>"NO SE ENCONTRO LA MATRIZ DE UBICACIONES"];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno;    
                    exit(1);

                }
              
            } else {
                
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"CODIGO QR SE ENCUENTRA UBICADO"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }
        } else {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"CODIGO QR NO ENCONTRADO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        }
    } else {
        // No tiene codigo qr
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE CODIGO QR"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }
}
 
 
?> 
  