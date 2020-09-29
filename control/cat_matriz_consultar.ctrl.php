<?php
// ----------------------------------------------------------------------------------
// cat_matriz_consultar.php
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
// 21/03/2020
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

    //echo "Condicion:" . $l_Condicion;
     
    if(strlen($l_Condicion)>0){
        $tbl->Inicializacion();
        $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);

        if(strlen($l_CampoDeOrdenamiento)>0){
            $tbl->CampoDeOrdenamientoDeLaTabla($l_CampoDeOrdenamiento);
        }  

        if(strlen($l_FormaDeOrdenamiento)>0){
            $tbl->FormaDeOrdenamiento($l_FormaDeOrdenamiento);        
        } else {
            $tbl->FormaDeOrdenamiento("Ascendente");        
        }

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
                 

                $datos=$datos + ["retorno"=>"TRUE"];
                $datos=$datos + ["msg"=>""];
                $datos=$datos + ["llave"=>$Campo_Llave];

                // Extrae los campos especiales           
                for($k=0;$k<count($tbl->campos_especiales); $k=$k+1){
                    $especiales=$especiales +  [ $tbl->campos_especiales[$k]=>$tbl->campos_especiales_tipo[$k] ];
                }
                $datos=$datos + ["especiales"=>$especiales];

                // Extrae los combos     
                for($k=0;$k<count($tbl->campos_combo); $k=$k+1){
                    $combo=$combo +  [ $tbl->campos_combo[$k]=>"" ];
                }
                $datos=$datos + ["combo"=>$combo ];

                // ----------------------------------------------- 
                // Extrae los encabezados de la lista 21/03/2020
                $encabezados=array();
                for($k=0;$k<count($tbl->campos_listado); $k=$k+1){
                    $encabezados=$encabezados  +  [ $k => $tbl->campos_listado[$k] ];                     
                }
                $datos=$datos + ["encabezados"=>$encabezados];
                // -----------------------------------------------


                // Extrae la info de los campos
                for($k=0;$k<$tbl->get_NumCampos();$k=$k+1){
                    $campo=$tbl->get_Estructura($k);
                    $valor=$registros[$j][$tbl->get_Estructura($k)];

                    if($l_Campos=="definidos"){
                        for($h=0;$h<count($tbl->campos_listado);$h=$h+1){
                            if($campo==$tbl->campos_listado[$h]){
                               
                                $datos=$datos + [$campo=>$valor];
                            }
                        }
                    } else {
                        $datos=$datos + [$campo=>$valor];
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
  