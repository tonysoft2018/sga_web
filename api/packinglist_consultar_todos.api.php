<?php
// ----------------------------------------------------------------------------------
// packinglist_consultar.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
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
include_once "../clases/packinglist.mysql.class_v2.0.0.php"; 
include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";

 
$retorno= array();
$arreglos = array();
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));

$l_Sesion=trim($arreglos->{"sesion"});
$l_nIDUsuario=trim($arreglos->{"nidusuario"});
$l_Condicion=trim($arreglos->{"condicion"});

if(strlen($l_Condicion)<=0){
    $l_Condicion="bEstado=0 and (Estatus='ETIQUETADO' or Estatus='ABIERTO')";
} else {
    $l_Condicion=$l_Condicion . " and (Estatus='ETIQUETADO' or Estatus='ABIERTO')";
}
// ----------------------------------------------

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true); 
// ----------------------------------------------
 
// ----------------------------------------------   
// Leer la info para procesar
$tbl = new   cltbl_Packinglist_v2_0_0();
$tbl_Deta = new   cltbl_Packinglist_Deta_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$Campo_Llave=$tbl->get_CampoLlave();
$l_nIDEnca=0;

if(strlen($l_Condicion)>0){
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
     
    $tbl->Leer($l_Condicion);

    if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
            
        $registros=$tbl->dtBase();

        for($j=0;$j<$tbl->CualEsElNumeroDeRegistrosCargados();$j=$j+1){

            $l_nIDEnca=$registros[$j]["nIDPackingList"];

            if($l_nIDEnca>0){
                $l_Condicion_Deta="nIDPackingList=" . $l_nIDEnca . " and (Estatus='ETIQUETA' or Estatus='RECIBO')";
                $tbl_Deta->Inicializacion();
                $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Deta->Leer($l_Condicion_Deta);

                $l_Total1=$tbl_Deta->CualEsElNumeroDeRegistrosCargados();

                $l_Condicion_Deta="nIDPackingList=" . $l_nIDEnca;
                $tbl_Deta->Inicializacion();
                $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Deta->Leer($l_Condicion_Deta);

                $l_Total2=$tbl_Deta->CualEsElNumeroDeRegistrosCargados();

                if($l_Total1==$l_Total2){
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
    $datos=$datos + ["msg"=>"NO TIENE REGISTROS1"];
 
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
}
 
?> 
  