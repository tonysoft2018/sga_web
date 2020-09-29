<?php
// ----------------------------------------------------------------------------------
// cat_estados_consultar_todos.api.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//             - Recibe una condición en JSON con el método de acceso POST.
//                { 
//                  condicion:[info consulta], 
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
include_once "../clases/cat_estados.mysql.class_v2.0.0.php";  
include_once "../bd/conexion.php";

 
$retorno= array();
$arreglos = array();
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));

$l_Condicion=trim($arreglos->{"condicion"});
  
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
 

// Busca el ID del packinglist
$l_nIDEnca=0;
$tbl = new  cltbl_Cat_Estados_v2_0_0(); 
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$Campo_Llave=$tbl->get_CampoLlave();
$tbl->Leer($l_Condicion);

if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
        
    $registros=$tbl->dtBase();

    for($j=0;$j<$tbl->CualEsElNumeroDeRegistrosCargados();$j=$j+1){
        $datos=array();
      
        $datos=$datos + ["retorno"=>"TRUE"];
        $datos=$datos + ["msg"=>""];
        $datos=$datos + ["llave"=>$Campo_Llave]; 

        // Extrae la info de los campos
        for($k=0;$k<$tbl->get_NumCampos();$k=$k+1){
            $campo=$tbl->get_Estructura($k);
            $valor=$registros[$j][$tbl->get_Estructura($k)];
            $datos=$datos + [$campo=>$valor];                          
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
 
 
?> 
  