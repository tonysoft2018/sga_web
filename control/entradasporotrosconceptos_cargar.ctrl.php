<?php
// ----------------------------------------------------------------------------------
// cat_almacen_cargar.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { 
//                  archivo:[nombre archivo] 
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


function CONVERTIR_ESPECIALES_HTML($str){
    $str = mb_convert_encoding($str,  'UTF-8');
    return $str;
  }

function fn_Extraer_Info($l_Linea, $l_Cadena){
    include_once "../clases/clHerramientas_v2011.php"; 
    include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
    include_once "../bd/conexion.php";

    // ----------------------------------------------
    // Conexion con la base de Datos
    $l_Regreso=RegresaConexion();
    $CONEXION=json_decode($l_Regreso,true); 
    // ----------------------------------------------

    $datos_reg=array();
 
    if($l_Linea>0){

       $l_Cadena=CONVERTIR_ESPECIALES_HTML($l_Cadena);
  
       $l_Columna=0;
       $i=0;
       $l_Valor="";
       
       $l_nIDProducto=0;
       $l_Codigo="";  
       $l_Producto="";
       $l_Descripcion="";       
       $l_CantidadPc="";  
       $l_CantidadCaja="";
       $l_Cajas="";
       $l_PesoBruto="";
       $l_PesoNeto="";
       $l_TotalM3="";
       $l_Estatus="SIN PROCESAR";
          
 
       for($i=0;$i<strlen($l_Cadena);$i++){
           $l_Valor=substr($l_Cadena,$i,1);
           if($l_Valor=="," || $l_Valor==";"){
              if($l_Columna<9){
                 $l_Columna=$l_Columna+1;
              }
           } else {
              switch($l_Columna){
                 case 0:$l_Codigo=$l_Codigo . $l_Valor;
                        break;
                 case 1:$l_Descripcion=$l_Descripcion . $l_Valor;
                        break;                         
                 case 2:$l_CantidadPc=$l_CantidadPc . $l_Valor;
                        break;                
                 case 3:$l_CantidadCaja=$l_CantidadCaja . $l_Valor;
                        break; 
                 case 4:$l_Cajas=$l_Cajas . $l_Valor;
                        break; 
                 case 5:$l_PesoBruto=$l_PesoBruto . $l_Valor;
                        break; 
                 case 6:$l_PesoNeto=$l_PesoNeto . $l_Valor;
                        break; 
                 case 7:$l_TotalM3=$l_TotalM3 . $l_Valor;
                        break; 
              }
           }
        }


        // Busca el codigo
        if(strlen($l_Codigo)>0){
            $retorno= array();
            $tbl = new  cltbl_Cat_Productos_v2_0_0();
            $tbl->Inicializacion();
            $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl->CargarCampos("LEER");
            $Campo_Llave=$tbl->get_CampoLlave();
    
            $l_Condicion="bEstado=0 and Activo='SI' and Codigo='" . $l_Codigo . "'";
            $tbl->Leer($l_Condicion);
            if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
                $registros=$tbl->dtBase();
                $l_nIDProducto=$registros[0]["nIDProducto"];
                $l_Producto=$registros[0]["Producto"];                   
            } else {                
                $l_Estatus="NO ENCONTRADO";
            }
        } else {
            $l_Estatus="NO ENCONTRADO";
        }




        $datos_reg=$datos_reg + ["retorno"=>"TRUE"];
        $datos_reg=$datos_reg + ["msg"=>""]; 
        $datos_reg=$datos_reg + ["nidproducto"=>$l_nIDProducto];
        $datos_reg=$datos_reg + ["codigo"=>$l_Codigo];
        $datos_reg=$datos_reg + ["producto"=>$l_Producto];  
        $datos_reg=$datos_reg + ["descripcion"=>$l_Descripcion];      
        $datos_reg=$datos_reg + ["cantidadpc"=>$l_CantidadPc];
        $datos_reg=$datos_reg + ["cantidadcaja"=>$l_CantidadCaja];
        $datos_reg=$datos_reg + ["cajas"=>$l_Cajas];
        $datos_reg=$datos_reg + ["pesobruto"=>$l_PesoBruto];
        $datos_reg=$datos_reg + ["pesoneto"=>$l_PesoNeto];
        $datos_reg=$datos_reg + ["totalm3"=>$l_TotalM3];
        $datos_reg=$datos_reg + ["estatus"=>$l_Estatus];        
         
        return $datos_reg;
 

    } else {
        $datos_reg=$datos_reg + ["Retorno"=>"FALSE"];
        $datos_reg=$datos_reg + ["msg"=>"NO TIENE ARCHIVO"];
        return $datos_reg;
    }
   
   
}

include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";
 
$target_path = "../archivos/";

$retorno= array();
$arreglos = array();
$info = array();
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));
 
$l_NumeroDeRegistros=count($arreglos);
$l_Archivo="";
 
if($l_NumeroDeRegistros<=0){ 
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE ARCHIVO"];
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


for($i=0;$i<$l_NumeroDeRegistros;$i++){
    $l_Archivo=$arreglos[$i]->{"archivo"};
}


$l_Archivo=trim($l_Archivo);

if(strlen($l_Archivo)<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE ARCHIVO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
 

$l_Archivo=$target_path . $l_Archivo;
$fp=fopen($l_Archivo,"r");

$l_NoLinea=0;
while(!feof($fp)) {
    $l_linea = fgets($fp);
    
    if(strlen($l_linea)>0){
     

       if($l_NoLinea>0){          
         $info=fn_Extraer_Info($l_NoLinea,$l_linea);
 
         if($info["Retorno"]!="FALSE"){
            array_push($retorno,$info);   
         }
 
         $l_NoLinea=$l_NoLinea+1;
         $l_Contador=$l_Contador+1;
         $l_Procesados=$l_Procesados+1;
       } else {
         $l_NoLinea=$l_NoLinea+1;
       }
    } else {

    }
 }
 fclose($fp);
  
 $retorno=json_encode($retorno);	 
 echo $retorno;    

?> 
  