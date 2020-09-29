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
        
        if(strlen($l_CantidadRegistros)>0){
            if(!is_numeric($l_CantidadRegistros)) {   
                $tbl->setLimiteInferior(0);
                $tbl->setLimiteSuperior($l_CantidadRegistros);
            }
        }

    
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

                $datos=array();
                $especiales=array();
                $combo=array();
                 

                $datos=$datos + ["retorno"=>"TRUE"];
                $datos=$datos + ["msg"=>""];
                $datos=$datos + ["llave"=>$Campo_Llave];

                // Extrae la info de los campos
                for($k=0;$k<$tbl->get_NumCampos();$k=$k+1){
                    $campo=$tbl->get_Estructura($k);
                    $valor=$registros[$j][$tbl->get_Estructura($k)];
                    $l_Estatus="SIN INSPECCION";
                    
                    if($campo=="nIDPackingList_Deta"){
                        $l_nIDPackingList_Deta=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    //Buscar el Detalle en la inspeccion
                    if($l_nIDPackingList_Deta>0){
                        $tbl_inspeccion->Inicializacion();
                        $tbl_inspeccion->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);

                        $l_Condicion="nIDPackingList_Deta=" .$l_nIDPackingList_Deta ." and bEstado=0";
                        $tbl_inspeccion->Leer($l_Condicion);

                        if($tbl_inspeccion->CualEsElNumeroDeRegistrosCargados()>0){
                            $registros_estados=$tbl_inspeccion->dtBase();
                            $l_Estado=$registros_estados[0]["Estado"];
                            $datos=$datos + ["Estado"=>$l_Estado];

                            $l_Estatus="INSPECCIONADO";
                        } else  {
                            $datos=$datos + ["Estado"=>$l_Estado];
                        }
                    }


                    if($campo=="nIDPackingList"){
                        $l_nIDPackingList=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    if($campo=="nIDProducto"){
                        $l_nIDProducto=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }
                    
                    if($campo=="Producto"){
                        $l_Producto=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    if($campo=="Codigo"){
                        $l_Codigo=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    if($campo=="CodigoQR"){
                        $l_CodigoQR=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    if($campo=="Descripcion"){
                        $l_Descripcion=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    if($campo=="Cantidad"){
                        $l_Cantidad=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    if($campo=="CantidadCaja"){
                        $l_CantidadCaja=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    if($campo=="Cajas"){
                        $l_Cajas=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    if($campo=="PesoBruto"){
                        $l_PesoBruto=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    if($campo=="PesoNeto"){
                        $l_PesoNeto=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    if($campo=="TotalM3"){
                        $l_TotalM3=$valor;
                        $datos=$datos + [$campo=>$valor];
                    }

                    if($campo=="Estatus"){                        
                        $datos=$datos + [$campo=>$l_Estatus];
                    }
                    
                }




                array_push($retorno,$datos);   
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
  