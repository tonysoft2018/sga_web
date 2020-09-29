<?php
// ----------------------------------------------------------------------------------
// packinglist_deta_consultar.php
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
include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php"; 
include_once "../clases/inspeccion.mysql.class_v2.0.0.php"; 
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
$tbl = new  cltbl_PackingList_Deta_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$Campo_Llave=$tbl->get_CampoLlave();

$tbl_inspeccion = new  cltbl_Inspeccion_v2_0_0();
$tbl_Cat_Productos_Serie = new  cltbl_Cat_Productos_Series_v2_0_0();


for($i=0;$i<$l_NumeroDeRegistros;$i++){
    $l_ConsultaR=trim($arreglos[$i]->{"consulta"});
    $l_Condicion=trim($arreglos[$i]->{"condicion"});
    $l_CampoDeOrdenamiento=$arreglos[$i]->{"campodeordenamiento"};
    $l_FormaDeOrdenamiento=trim($arreglos[$i]->{"formadeordenamiento"});
    $l_CantidadRegistros=$arreglos[$i]->{"cantidadregistros"};
    $l_Tipo=$arreglos[$i]->{"tipo"};
    $l_Campos=$arreglos[$i]->{"campos"};

    if(strlen($l_FormaDeOrdenamiento)<=0){
        $l_FormaDeOrdenamiento="Ascendente";
    }

    $l_Consulta="";

    if($l_Tipo=="directa"){

        if(strlen($l_ConsultaR)<=0){   
            $l_ConsultaR=$Campo_Llave . ">0 and bEstado=0";
        }

    } else {

        if(strlen($l_ConsultaR)<=0){   
            $l_ConsultaR=$Campo_Llave . ">0 and bEstado=0";
        } else {
   
            for($h=0;$h<count($tbl->campos_busqueda);$h=$h+1){
                switch($tbl->campos_busqueda_tipo[$h]){
                    case "CADENA": 
                        if(strlen($l_Consulta)>0){                        
                            $l_Consulta=$l_Consulta . " or " . $tbl->campos_busqueda[$h] . " like '%" . $l_ConsultaR . "%'";
                        } else {
                            $l_Consulta=$l_Consulta . $tbl->campos_busqueda[$h] . " like '%" . $l_ConsultaR . "%'";
                        }                  
    
                        break;
                
                    case "NUMERO":
                        if(strlen($l_Consulta)>0){                        
                            $l_Consulta=$l_Consulta . " or " . $tbl->campos_busqueda[$h] . "=" . $l_ConsultaR;
                        } else {
                            $l_Consulta=$l_Consulta . $tbl->campos_busqueda[$h] . "=" . $l_ConsultaR;
                        }                  

                        break;
                    case "FECHA":
                        break;
                }
            }
     
            if(strlen($l_Consulta)>0){
                $l_ConsultaR="(" . $l_Consulta . ") and bEstado=0";            
            } else {
                $l_ConsultaR=$Campo_Llave . ">0 and bEstado=0";
            }                  
        }
    }

    // Condicion externa
    if(strlen($l_ConsultaR)>0){
 
        if(strlen($l_Condicion)>0){
            $l_Condicion="(" . $l_ConsultaR . ") and (" . $l_Condicion . ")";
        } else {
            $l_Condicion=$l_ConsultaR;
        }

    } else {
 
        if(strlen($l_Condicion)<=0){
            $l_Condicion=$Campo_Llave . ">0 and bEstado=0";
        } 
    }

     

    if(strlen($l_Condicion)>0){
        $tbl->Inicializacion();
        $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl->Leer($l_Condicion);

        if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
            
            $registros=$tbl->dtBase();

            $l_nIDPackingList_Deta=0;
            $l_nIDPackingList=0;
            $l_nIDProducto=0;
            $l_Producto="";
            $l_Codigo="";
            $l_CodigoQR="";
            $l_Descripcion="";
            $l_Cantidad=0;
            $l_CantidadCaja=0;
            $l_Cajas=0;
            $l_PesoBruto=0.0;
            $l_PesoNeto=0.0;
            $l_TotalM3=0.0;
            $l_Estatus="";
            $l_Carton="";
            $l_Estado="";

            for($j=0;$j<$tbl->CualEsElNumeroDeRegistrosCargados();$j=$j+1){
                $l_nIDPackingList_Deta=0;
                $l_nIDPackingList=0;
                $l_nIDProducto=0;
                $l_Producto="";
                $l_Codigo="";
                $l_CodigoQR="";
                $l_Descripcion="";
                $l_Cantidad=0;
                $l_CantidadCaja=0;
                $l_Cajas=0;
                $l_PesoBruto=0.0;
                $l_PesoNeto=0.0;
                $l_TotalM3=0.0;
                $l_Estatus="";
                $l_Carton="";
                $l_Estado="INDEFINIDO";

                
                $especiales=array();
                $combo=array();
                 

                
 
                // Carga los datos del detalle
                $l_nIDPackingList_Deta=$registros[$j]["nIDPackingList_Deta"];
                $l_nIDPackingList=$registros[$j]["nIDPackingList"];
                $l_nIDProducto=$registros[$j]["nIDProducto"];
                $l_Producto=$registros[$j]["Producto"];
                $l_Codigo=$registros[$j]["Codigo"];
                $l_CodigoQR=$registros[$j]["CodigoQR"];
                $l_Descripcion=$registros[$j]["Descripcion"];
                $l_Cantidad=$registros[$j]["Cantidad"];
                $l_CantidadCaja=$registros[$j]["CantidadCaja"];
                $l_Cajas=$registros[$j]["Cajas"];
                $l_PesoBruto=$registros[$j]["PesoBruto"];
                $l_PesoNeto=$registros[$j]["PesoNeto"];
                $l_TotalM3=$registros[$j]["TotalM3"];                
                $l_Carton=$registros[$j]["Carton"];

                // Carga la serie de los productos
                $l_TotalLeer=0;            
                $l_Estatus="SIN INSPECCION";
                $l_Estado="";

                $tbl_Cat_Productos_Serie->Inicializacion();
                $tbl_Cat_Productos_Serie->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $l_Condicion="nIDPackingList=" .$l_nIDPackingList ." and bEstado=0 and nIDProducto=" . $l_nIDProducto;

                //echo "Condicion:" .$l_Condicion; 
                $tbl_Cat_Productos_Serie->Leer($l_Condicion);
                if($tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados()>0){
                    // Tiene seriales
                    $l_TotalLeer=$tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados();

                    $registros_seriales=$tbl_Cat_Productos_Serie->dtBase();

                    for($k=0;$k<$tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados();$k=$k+1){
                        //echo "Leidos:" . $tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados();
                        $l_nIDProducto_Serie=$registros_seriales[$k]["nIDProducto_Serie"];

                        $datos=array();
                        $datos=$datos + ["retorno"=>"TRUE"];
                        $datos=$datos + ["msg"=>""];
                        $datos=$datos + ["llave"=>$Campo_Llave];
                        $datos=$datos + ["nIDPackingList_Deta"=>$l_nIDPackingList_Deta];
                        $datos=$datos + ["nIDPackingList"=>$l_nIDPackingList];
                        $datos=$datos + ["nIDProducto"=>$l_nIDProducto];
                        $datos=$datos + ["Producto"=>$l_Producto];
                        $datos=$datos + ["Codigo"=>$l_Codigo];
                        $datos=$datos + ["CodigoQR"=>$l_CodigoQR];
                        $datos=$datos + ["Descripcion"=>$l_Descripcion];
                        $datos=$datos + ["Cantidad"=>$l_Cantidad];
                        $datos=$datos + ["CantidadCaja"=>$l_CantidadCaja];
                        $datos=$datos + ["Cajas"=>$l_Cajas];
                        $datos=$datos + ["PesoBruto"=>$l_PesoBruto];
                        $datos=$datos + ["PesoNeto"=>$l_PesoNeto];
                        $datos=$datos + ["TotalM3"=>$l_TotalM3];
                        $datos=$datos + ["Estatus"=>$l_Estatus];
                        $datos=$datos + ["Carton"=>$l_Carton];
                        $datos=$datos + ["nIDProducto_Serie"=>$l_nIDProducto_Serie];          
                        $datos=$datos + ["TotalLeer"=>$l_TotalLeer];

                        // Buscar la serie
                        $l_CodigoDeBarras="";
                        $tbl_inspeccion->Inicializacion();
                        $tbl_inspeccion->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);    
                        $l_Condicion="nIDProducto_Serie=" . $l_nIDProducto_Serie ." and bEstado=0";
                        $tbl_inspeccion->Leer($l_Condicion);
                        if($tbl_inspeccion->CualEsElNumeroDeRegistrosCargados()>0){
                           
                            $registros_inspeccion=$tbl_inspeccion->dtBase();

                            $l_CodigoDeBarras=$registros_inspeccion[0]["CodigoDeBarras"]; 
                            $l_nIDCat_Estado=$registros_inspeccion[0]["nIDCat_Estado"]; 

                            if(strlen($l_Estado)<=0){                                
                                $l_Estado=$registros_inspeccion[0]["Estado"];                              
                            }
         
                        } 

                        if(strlen($l_Estado)<=0){
                            $l_Estado="INDEFINIDO";
                        }

                        $datos=$datos + ["CodigoDeBarras"=>$l_CodigoDeBarras];
                        $datos=$datos + ["Estado"=>$l_Estado];
                        $datos=$datos + ["nIDCat_Estado"=>0];
                        array_push($retorno,$datos);  
                        unset($datos); 
                    }

                } else {
                    // No tiene seriales.
                    $l_Estado="INDEFINIDO";

                    // Carga la informacion a retornar
                    $datos=array();
                    $datos=$datos + ["retorno"=>"TRUE"];
                    $datos=$datos + ["msg"=>""];
                    $datos=$datos + ["llave"=>$Campo_Llave];
                    $datos=$datos + ["nIDPackingList_Deta"=>$l_nIDPackingList_Deta];
                    $datos=$datos + ["nIDPackingList"=>$l_nIDPackingList];
                    $datos=$datos + ["nIDProducto"=>$l_nIDProducto];
                    $datos=$datos + ["Producto"=>$l_Producto];
                    $datos=$datos + ["Codigo"=>$l_Codigo];
                    $datos=$datos + ["CodigoQR"=>$l_CodigoQR];
                    $datos=$datos + ["Descripcion"=>$l_Descripcion];
                    $datos=$datos + ["Cantidad"=>$l_Cantidad];
                    $datos=$datos + ["CantidadCaja"=>$l_CantidadCaja];
                    $datos=$datos + ["Cajas"=>$l_Cajas];
                    $datos=$datos + ["PesoBruto"=>$l_PesoBruto];
                    $datos=$datos + ["PesoNeto"=>$l_PesoNeto];
                    $datos=$datos + ["TotalM3"=>$l_TotalM3];
                    $datos=$datos + ["Estatus"=>$l_Estatus];
                    $datos=$datos + ["Carton"=>$l_Carton];
                    $datos=$datos + ["nIDProducto_Serie"=>0];     
                    $datos=$datos + ["TotalLeer"=>$l_TotalLeer];
                    $datos=$datos + ["CodigoDeBarras"=>""];
                    $datos=$datos + ["Estado"=>$l_Estado];
                    $datos=$datos + ["nIDCat_Estado"=>0];
                    
                    array_push($retorno,$datos);  
                    unset($datos); 
                }

                

                
                
            }
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
  