<?php
// ----------------------------------------------------------------------------------
// cat_proveedores_cargar.php
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
       $l_IDProveedor="";
       $l_IDProveedor_IZeta="";  
       $l_RazonSocial="";  
       $l_RFC="";
       $l_Calle="";
       $l_NoExterior="";
       $l_NoInterior="";
       $l_Colonia="";
       $l_Ciudad="";
       $l_Municipio="";
       $l_Estado="";
       $l_Pais="";
       $l_CP="";
       $l_Telefono1="";
       $l_Telefono2="";
       $l_Telefono3="";
       $l_Celular1="";
       $l_Celular2="";
       $l_Celular3="";
       $l_Email1="";
       $l_Email2="";
       $l_Email3="";
       $l_Contacto="";
         
       for($i=0;$i<strlen($l_Cadena);$i++){
           $l_Valor=substr($l_Cadena,$i,1);
           if($l_Valor=="," || $l_Valor==";"){
              if($l_Columna<22){
                 $l_Columna=$l_Columna+1;
              }
           } else {
              switch($l_Columna){
                 case 0:$l_IDProveedor=$l_IDProveedor . $l_Valor;
                        break;
                 case 1:$l_IDProveedor_IZeta=$l_IDProveedor_IZeta . $l_Valor;
                        break;
                 case 2:$l_RazonSocial=$l_RazonSocial . $l_Valor;
                        break;
                 case 3:$l_RFC=$l_RFC . $l_Valor;
                        break;                
                 case 4:$l_Calle=$l_Calle . $l_Valor;
                        break;        
                 case 5:$l_NoExterior=$l_NoExterior . $l_Valor;
                        break; 
                 case 6:$l_NoInterior=$l_NoInterior . $l_Valor;
                        break;         
                 case 7:$l_Colonia=$l_Colonia . $l_Valor;
                        break;                        
                 case 8:$l_Ciudad=$l_Ciudad . $l_Valor;
                        break;        
                 case 9:$l_Municipio=$l_Municipio . $l_Valor;
                        break;    
                 case 10:$l_Estado=$l_Estado . $l_Valor;
                        break;    
                 case 11:$l_Pais=$l_Pais . $l_Valor;
                        break;    
                 case 12:$l_CP=$l_CP . $l_Valor;
                        break;    
                 case 13:$l_Telefono1=$l_Telefono1 . $l_Valor;
                        break;    
                 case 14:$l_Telefono2=$l_Telefono2 . $l_Valor;
                        break;    
                 case 15:$l_Telefono3=$l_Telefono3 . $l_Valor;
                        break;    
                 case 16:$l_Celular1=$l_Celular1 . $l_Valor;
                        break;    
                 case 17:$l_Celular2=$l_Celular2 . $l_Valor;
                        break;    
                 case 18:$l_Celular3=$l_Celular3 . $l_Valor;
                        break;    
                 case 19:$l_Email1=$l_Email1 . $l_Valor;
                        break;    
                 case 20:$l_Email2=$l_Email2 . $l_Valor;
                        break;    
                 case 21:$l_Email3=$l_Email3 . $l_Valor;
                        break;    
                 case 22:$l_Contacto=$l_Contacto . $l_Valor;
                        break;    
              }
           }
        }
    
        
         
        $datos=$datos + ["retorno"=>"TRUE"];
        $datos=$datos + ["msg"=>""]; 
        $datos=$datos + ["idproveedor"=>$l_IDProveedor];
        $datos=$datos + ["idproveedor_izeta"=>$l_IDProveedor_IZeta];
        $datos=$datos + ["razonsocial"=>$l_RazonSocial];
        $datos=$datos + ["rfc"=>$l_RFC];
        $datos=$datos + ["calle"=>$l_Calle];
        $datos=$datos + ["noexterior"=>$l_NoExterior];
        $datos=$datos + ["nointerior"=>$l_NoInterior];
        $datos=$datos + ["colonia"=>$l_Colonia];
        $datos=$datos + ["ciudad"=>$l_Ciudad];
        $datos=$datos + ["municipio"=>$l_Municipio];
        $datos=$datos + ["estado"=>$l_Estado];
        $datos=$datos + ["pais"=>$l_Pais];
        $datos=$datos + ["cp"=>$l_CP];
        $datos=$datos + ["telefono1"=>$l_Telefono1];
        $datos=$datos + ["telefono2"=>$l_Telefono2];
        $datos=$datos + ["telefono3"=>$l_Telefono3];
        $datos=$datos + ["celular1"=>$l_Celular1];
        $datos=$datos + ["celular2"=>$l_Celular2];
        $datos=$datos + ["celular3"=>$l_Celular3];
        $datos=$datos + ["email1"=>$l_Email1];
        $datos=$datos + ["email2"=>$l_Email2];
        $datos=$datos + ["email3"=>$l_Email3];
        $datos=$datos + ["contacto"=>$l_Contacto];

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
   
          $l_IDProveedor="";
          $l_IDProveedor_IZeta="";  
          $l_RazonSocial="";  
          $l_RFC="";
          $l_Calle="";
          $l_NoExterior="";
          $l_NoInterior="";
          $l_Colonia="";
          $l_Ciudad="";
          $l_Municipio="";
          $l_Estado="";
          $l_Pais="";
          $l_CP="";
          $l_Telefono1="";
          $l_Telefono2="";
          $l_Telefono3="";
          $l_Celular1="";
          $l_Celular2="";
          $l_Celular3="";
          $l_Email1="";
          $l_Email2="";
          $l_Email3="";
          $l_Contacto="";
   
          $l_IDProveedor=$sheet->getCell("A".$row)->getValue();     
          $l_IDProveedor_IZeta=$sheet->getCell("B".$row)->getValue();     
          $l_RazonSocial=$sheet->getCell("C".$row)->getValue();        
          $l_RFC=$sheet->getCell("D".$row)->getValue();        
          $l_Calle=$sheet->getCell("E".$row)->getValue();     
          $l_NoExterior=$sheet->getCell("F".$row)->getValue();        
          $l_NoInterior=$sheet->getCell("G".$row)->getValue();        
          $l_Colonia=$sheet->getCell("H".$row)->getValue();        
          $l_Ciudad=$sheet->getCell("I".$row)->getValue();        
          $l_Municipio=$sheet->getCell("J".$row)->getValue();        
          $l_Estado=$sheet->getCell("K".$row)->getValue();        
          $l_Pais=$sheet->getCell("L".$row)->getValue();     
          $l_CP=$sheet->getCell("M".$row)->getValue();     
          $l_Telefono1=$sheet->getCell("N".$row)->getValue();   
          $l_Telefono2=$sheet->getCell("O".$row)->getValue();        
          $l_Telefono3=$sheet->getCell("P".$row)->getValue();        
          $l_Celular1=$sheet->getCell("Q".$row)->getValue();   
          $l_Celular2=$sheet->getCell("R".$row)->getValue();        
          $l_Celular3=$sheet->getCell("S".$row)->getValue();        
          $l_Email1=$sheet->getCell("T".$row)->getValue();   
          $l_Email2=$sheet->getCell("U".$row)->getValue();        
          $l_Email3=$sheet->getCell("V".$row)->getValue();      
          $l_Contacto=$sheet->getCell("W".$row)->getValue();  
          
          if($l_IDProveedor==null){
              $l_IDProveedor="";
          }

          if($l_IDProveedor_IZeta==null){
              $l_IDProveedor_IZeta="";
          }

          if($l_RazonSocial==null){
              $l_RazonSocial="";
          }

          if($l_RFC==null){
              $l_RFC="";
          }

          if($l_Calle==null){
              $l_Calle="";
          }

          if($l_NoExterior==null){
              $l_NoExterior="";
          }

          if($l_NoInterior==null){
              $l_NoInterior="";
          }

          if($l_Colonia==null){
              $l_Colonia="";
          }

          if($l_Ciudad==null){
              $l_Ciudad="";
          }

          if($l_Municipio==null){
              $l_Municipio="";
          }

          if($l_Estado==null){
              $l_Estado="";
          }

          if($l_Pais==null){
              $l_Pais="";
          }

          if($l_CP==null){
              $l_CP="";
          }

          if($l_Telefono1==null){
              $l_Telefono1="";
          }

          if($l_Telefono2==null){
              $l_Telefono2="";
          }

          if($l_Telefono3==null){
              $l_Telefono3="";
          }

          if($l_Celular1==null){
              $l_Celular1="";
          }

          if($l_Celular2==null){
              $l_Celular2="";
          }

          if($l_Celular3==null){
              $l_Celular3="";
          }

          if($l_Email1==null){
              $l_Email1="";
          }

          if($l_Email2==null){
              $l_Email2="";
          }

          if($l_Email3==null){
              $l_Email3="";
          }



          if($l_Contacto==null){
                 $l_Contacto="";
          }
          
          $datos=$datos + ["retorno"=>"TRUE"];
          $datos=$datos + ["msg"=>""]; 
          $datos=$datos + ["idproveedor"=>$l_IDProveedor];
          $datos=$datos + ["idproveedor_izeta"=>$l_IDProveedor_IZeta];
          $datos=$datos + ["razonsocial"=>$l_RazonSocial];
          $datos=$datos + ["rfc"=>$l_RFC];
          $datos=$datos + ["calle"=>$l_Calle];
          $datos=$datos + ["noexterior"=>$l_NoExterior];
          $datos=$datos + ["nointerior"=>$l_NoInterior];
          $datos=$datos + ["colonia"=>$l_Colonia];
          $datos=$datos + ["ciudad"=>$l_Ciudad];
          $datos=$datos + ["municipio"=>$l_Municipio];
          $datos=$datos + ["estado"=>$l_Estado];
          $datos=$datos + ["pais"=>$l_Pais];
          $datos=$datos + ["cp"=>$l_CP];
          $datos=$datos + ["telefono1"=>$l_Telefono1];
          $datos=$datos + ["telefono2"=>$l_Telefono2];
          $datos=$datos + ["telefono3"=>$l_Telefono3];
          $datos=$datos + ["celular1"=>$l_Celular1];
          $datos=$datos + ["celular2"=>$l_Celular2];
          $datos=$datos + ["celular3"=>$l_Celular3];
          $datos=$datos + ["email1"=>$l_Email1];
          $datos=$datos + ["email2"=>$l_Email2];
          $datos=$datos + ["email3"=>$l_Email3];
          $datos=$datos + ["contacto"=>$l_Contacto];
  
   
          array_push($retorno,$datos);   
          unset($datos);
       }
   
       return $retorno;
   } 



 
include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/cat_proveedores.mysql.class_v2.0.0.php"; 
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
  
  