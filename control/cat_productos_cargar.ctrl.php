<?php
// ----------------------------------------------------------------------------------
// cat_productos_cargar.php
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
// 30/03/2020
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
    $datos=array();
    if($l_Linea>0){
 
       $l_Cadena=CONVERTIR_ESPECIALES_HTML($l_Cadena);
  
       $l_Columna=0;
       $i=0;
       $l_Valor="";
 
       $l_No=0;
       $l_IDProducto="";
       $l_Codigo="";  
       $l_Codigo_SAP="";  
       $l_Codigo_IZeta="";  
       $l_Producto="";
       $l_Descripcion="";
       $l_Tipo="";
       $l_SubTipo="";
       $l_Familia="";
       $l_Presentacion="";
       $l_Excepcion="";
       $l_UnidadDeMedida="";
       $l_Proveedor="";

  
       for($i=0;$i<strlen($l_Cadena);$i++){
           $l_Valor=substr($l_Cadena,$i,1);
           if($l_Valor=="," || $l_Valor==";"){
              if($l_Columna<13){
                 $l_Columna=$l_Columna+1;
              }
           } else {
              switch($l_Columna){
                 case 0:$l_IDProducto=$l_IDProducto . $l_Valor;
                        break;
                 case 1:$l_Codigo=$l_Codigo . $l_Valor;
                        break;
                 case 2:$l_Codigo_SAP=$l_Codigo_SAP . $l_Valor;
                        break;
                 case 3:$l_Codigo_IZeta=$l_Codigo_IZeta . $l_Valor;
                        break;                
                 case 4:$l_Producto=$l_Producto . $l_Valor;
                        break;        
                 case 5:$l_Descripcion=$l_Descripcion . $l_Valor;
                        break; 
                 case 6:$l_Tipo=$l_Tipo . $l_Valor;
                        break;         
                 case 7:$l_SubTipo=$l_SubTipo . $l_Valor;
                        break;                        
                 case 8:$l_Familia=$l_Familia . $l_Valor;
                        break;        
                 case 9:$l_Presentacion=$l_Presentacion . $l_Valor;
                        break;    
                 case 10:$l_Excepcion=$l_Excepcion . $l_Valor;
                        break;    
                 case 11:$l_UnidadDeMedida=$l_UnidadDeMedida . $l_Valor;
                        break;    
                 case 12:$l_Proveedor=$l_Proveedor . $l_Valor;
                        break;    
               
              }
           }
        }
 
        $datos=$datos + ["retorno"=>"TRUE"];
        $datos=$datos + ["msg"=>""]; 
        $datos=$datos + ["idproducto"=>$l_IDProducto];
        $datos=$datos + ["codigo"=>$l_Codigo];
        $datos=$datos + ["codigo_sap"=>$l_Codigo_SAP];
        $datos=$datos + ["codigo_izeta"=>$l_Codigo_IZeta];
        $datos=$datos + ["producto"=>$l_Producto];
        $datos=$datos + ["descripcion"=>$l_Descripcion];
        $datos=$datos + ["tipo"=>$l_Tipo];
        $datos=$datos + ["subtipo"=>$l_SubTipo];
        $datos=$datos + ["familia"=>$l_Familia];
        $datos=$datos + ["presentacion"=>$l_Presentacion];
        $datos=$datos + ["excepcion"=>$l_Excepcion];
        $datos=$datos + ["unidaddemedida"=>$l_UnidadDeMedida];
        $datos=$datos + ["proveedor"=>$l_Proveedor];
      
        return $datos;
 
    } else {
        $datos=$datos + ["Retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ARCHIVO"];
        return $datos;
    }   
}

function fn_Extraer_Excel($l_Archivo){
       $retorno= array();
       
       require_once '../Classes/PHPExcel.php';
       $archivo = $l_Archivo;
       $inputFileType = PHPExcel_IOFactory::identify($archivo);
       $objReader = PHPExcel_IOFactory::createReader($inputFileType);
       $objPHPExcel = $objReader->load($archivo);
       $sheet = $objPHPExcel->getSheet(0); 
       $highestRow = $sheet->getHighestRow(); 
       $highestColumn = $sheet->getHighestColumn();
   
       for ($row = 2; $row <= $highestRow; $row++){ 
          $datos=array();
   
          $l_IDProducto="";
          $l_Codigo="";  
          $l_Codigo_SAP="";  
          $l_Codigo_IZeta="";  
          $l_Producto="";
          $l_Descripcion="";
          $l_Tipo="";
          $l_SubTipo="";
          $l_Familia="";
          $l_Presentacion="";
          $l_Excepcion="";
          $l_UnidadDeMedida="";
          $l_Proveedor="";
   
          if($sheet->getCell("A".$row)->getValue()!=null){
              $l_IDProducto=$sheet->getCell("A".$row)->getValue();
          }

          if($sheet->getCell("B".$row)->getValue()!=null){
              $l_Codigo=$sheet->getCell("B".$row)->getValue();
          } 

          if($sheet->getCell("C".$row)->getValue()!=null){
              $l_Codigo_SAP=$sheet->getCell("C".$row)->getValue();
          }

          if($sheet->getCell("D".$row)->getValue()!=null){
              $l_Codigo_IZeta=$sheet->getCell("D".$row)->getValue();
          }

          if($sheet->getCell("E".$row)->getValue()!=null){
              $l_Producto=$sheet->getCell("E".$row)->getValue();
          }

          if($sheet->getCell("F".$row)->getValue()!=null){
              $l_Descripcion=$sheet->getCell("F".$row)->getValue();
          }

          if($sheet->getCell("G".$row)->getValue()!=null){
              $l_Tipo=$sheet->getCell("G".$row)->getValue();
          }

          if($sheet->getCell("H".$row)->getValue()!=null){
              $l_SubTipo=$sheet->getCell("H".$row)->getValue();
          }

          if($sheet->getCell("I".$row)->getValue()!=null){
              $l_Familia=$sheet->getCell("I".$row)->getValue();
          }

          if($sheet->getCell("J".$row)->getValue()!=null){
              $l_Presentacion=$sheet->getCell("J".$row)->getValue();
          }

          if($sheet->getCell("K".$row)->getValue()!=null){
              $l_Excepcion=$sheet->getCell("K".$row)->getValue();
          }

          if($sheet->getCell("L".$row)->getValue()!=null){
              $l_UnidadDeMedida=$sheet->getCell("L".$row)->getValue();
          }

          if($sheet->getCell("M".$row)->getValue()!=null){
              $l_Proveedor=$sheet->getCell("M".$row)->getValue();
          }

          // Validacion para dar de alta un producto

          //if(strlen($l_IDProducto)>0 || strlen($l_Codigo)>0 || strlen($l_Codigo_IZeta)>0){
          if(strlen($l_IDProducto)>0 || strlen($l_Codigo)>0  || strlen($l_Codigo_IZeta)>0 ){
                 if(strlen($l_Producto)>0){

                     $datos=$datos + ["retorno"=>"TRUE"];
                     $datos=$datos + ["msg"=>""]; 
                     $datos=$datos + ["idproducto"=>$l_IDProducto];
                     $datos=$datos + ["codigo"=>$l_Codigo];
                     $datos=$datos + ["codigo_sap"=>$l_Codigo_SAP];
                     $datos=$datos + ["codigo_izeta"=>$l_Codigo_IZeta];
                     $datos=$datos + ["producto"=>$l_Producto];
                     $datos=$datos + ["descripcion"=>$l_Descripcion];
                     $datos=$datos + ["tipo"=>$l_Tipo];
                     $datos=$datos + ["subtipo"=>$l_SubTipo];
                     $datos=$datos + ["familia"=>$l_Familia];
                     $datos=$datos + ["presentacion"=>$l_Presentacion];
                     $datos=$datos + ["excepcion"=>$l_Excepcion];
                     $datos=$datos + ["unidaddemedida"=>$l_UnidadDeMedida];
                     $datos=$datos + ["proveedor"=>$l_Proveedor];
              
                     array_push($retorno,$datos);   
                 }

          }


          
         
          unset($datos);
       }
   
       return $retorno;
   }
 
include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
require_once '../Classes/PHPExcel.php';
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
 

// ------------------------------------
// Extraer el nombre y la csv
$j=0;
$posicion=0;
$valor="";
$NuevoNombre="";
for($j=0;$j<strlen($l_Archivo);$j++){
        $valor=substr($l_Archivo,$j,1);

        if($valor=="."){
                $posicion=$j;
                break;
        } else {
                $NuevoNombre=$NuevoNombre .$valor;
        }
 }


 $posicion=$posicion+1;
 $Extension="";
 for($j=$posicion;$j<strlen($l_Archivo);$j++){
        $valor=substr($l_Archivo,$j,1);
        $Extension=$Extension .$valor;
 }

 
 if($Extension=="csv"){

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

 } else {

       if($Extension=="xlsx"){
          $l_Archivo=$target_path . $l_Archivo;
          $info=fn_Extraer_Excel($l_Archivo);
           
          $info=json_encode($info);	
          echo $info;  
       } else {
          $datos=array();
          $datos=$datos + ["retorno"=>"FALSE"];
          $datos=$datos + ["msg"=>"NO TIENE ARCHIVO2"];
          array_push($retorno,$datos);    
          $retorno=json_encode($retorno);	 
          echo $retorno;    
          exit(1);
       }
 }
// ------------------------------------
?> 
  
  