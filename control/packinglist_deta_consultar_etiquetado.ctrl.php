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
$contador=0;

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

            for($j=0;$j<$tbl->CualEsElNumeroDeRegistrosCargados();$j=$j+1){
                $datos=array();
                $especiales=array();
                $combo=array();
                 

                for($k=0;$k<$tbl->get_NumCampos();$k=$k+1){
                    $campo=$tbl->get_Estructura($k);
                    $valor=$registros[$j][$tbl->get_Estructura($k)];
                    
                    if($campo=="Estatus"){
                        if($valor=="ETIQUETA"){
                            $contador++;
                            break;
                        }
                    }
                } 
 
            }

            if($contador==$tbl->CualEsElNumeroDeRegistrosCargados()){
                $datos=$datos + ["retorno"=>"TRUE"];
            } else {
                $datos=$datos + ["retorno"=>"FALSE"];
            }
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
  