<?php
// ----------------------------------------------------------------------------------
// ordendesurtido_consultar_folio.ctrl.php
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
include_once "../clases/ordendesurtido.mysql.class_v2.0.0.php"; 
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
$tbl = new   cltbl_OrdenDeSurtido_v2_0_0();
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

                $datos=$datos + ["nIDOrdenDeSurtido"=>$registros[$j]["nIDOrdenDeSurtido"]];

                $datos=$datos + ["Folio"=>$registros[$j]["Folio"]];
                $datos=$datos + ["Fecha"=>$registros[$j]["Fecha"]];
                $datos=$datos + ["Almacen_Origen"=>$registros[$j]["Almacen_Origen"]];
                $datos=$datos + ["Almacen_Destino"=>$registros[$j]["Almacen_Destino"]];                
                $datos=$datos + ["Nombre"=>$registros[$j]["Nombre"]];
                $datos=$datos + ["Comentarios"=>$registros[$j]["Comentarios"]];
                $datos=$datos + ["Estatus"=>$registros[$j]["Estatus"]];
                
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
  