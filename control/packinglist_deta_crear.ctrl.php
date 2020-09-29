<?php
// ----------------------------------------------------------------------------------
// packinglist_deta_crear.ctrl.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { 
//                     datos[]
//                }
//              - Devuelve el resultado en JSON.
//                {
//                    retorno=>TRUE/FALSE, msg=>"MENSAJE"
//                } 
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 12/12/2019
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

  function fn_Extraer_Info($l_Linea, $l_Cadena, $l_nIDPackingList){
    include_once "../clases/clHerramientas_v2011.php"; 
    include_once "../clases/cat_productos.mysql.class_v2.0.0.php";
    include_once "../clases/packinglist.mysql.class_v2.0.0.php";  
    include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php"; 
    include_once "../bd/conexion.php";

    // ----------------------------------------------
    // Conexion con la base de Datos
    $l_Regreso=RegresaConexion();
    $CONEXION=json_decode($l_Regreso,true); 
    // ----------------------------------------------

    // Basicos
    $UtileriasDatos = new clHerramientasv2011();
    $l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
    $l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);
           
    $NombrePC = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $Fecha = date('Y-m-d');
    $Hora = date('H:i:s');
    
    $l_FechaModificacion=$Fecha." ".$Hora;
    $l_FechaCreacion=$Fecha." ".$Hora;
    $l_Observaciones="Nueva captura - Creado por  - ".$NombrePC." - ".get_current_user()." - ".$l_FechaModificacion;
    $l_bEstado=0;
    $l_bCrear=1;
    $l_bCambiar=0;
    $l_bEliminar=0;

    $tbl_Deta = new  cltbl_Packinglist_Deta_v2_0_0();
    $tbl_Deta->Inicializacion();
    $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Deta->CargarCampos("GRABAR");

    $datos_reg=array();
 
    if($l_Linea>0){

       $l_Cadena=CONVERTIR_ESPECIALES_HTML($l_Cadena);
  
       $l_Columna=0;
       $i=0;
       $l_Valor="";
       
       $l_nIDPackingList_Deta=0;       
       $l_nIDProducto=0;
       $l_Codigo="";  
       $l_CodigoQR="";
       $l_Producto="";
       $l_Descripcion="";       
       $l_CantidadPc="";  
       $l_CantidadCaja="";
       $l_Cajas="";
       $l_PesoBruto="";
       $l_PesoNeto="";
       $l_TotalM3="";
       $l_Estatus="SIN PROCESAR";
       $l_Leidos=0;
       $l_Leidos_Barras=0;

       $datos_grabar = array();
           
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

        // Crear la
        if($l_nIDProducto>0){
            $l_Estatus="NO RECIBIDO";
            array_push($datos_grabar,$l_nIDPackingList_Deta);
            array_push($datos_grabar,$l_nIDPackingList);
            array_push($datos_grabar,$l_nIDProducto);
            array_push($datos_grabar,$l_Codigo);
            array_push($datos_grabar,$l_CodigoQR);
            array_push($datos_grabar,$l_Descripcion);
            array_push($datos_grabar,$l_CantidadPc);
            array_push($datos_grabar,$l_CantidadCaja);
            array_push($datos_grabar,$l_Cajas);
            array_push($datos_grabar,$l_PesoBruto);
            array_push($datos_grabar,$l_PesoNeto);
            array_push($datos_grabar,$l_TotalM3);
            array_push($datos_grabar,$l_Estatus);
            array_push($datos_grabar,$l_Leidos);
            array_push($datos_grabar,$l_Leidos);
            array_push($datos_grabar,$l_FechaLocal);
            array_push($datos_grabar,$l_FechaLocal);
            array_push($datos_grabar,$l_Observaciones);
            array_push($datos_grabar,$l_bEstado);
            array_push($datos_grabar,$l_bCrear);
            array_push($datos_grabar,$l_bCambiar);
            array_push($datos_grabar,$l_bEliminar);

            //print_r($datos_grabar);
 
            $tbl_Deta->setInformacion_Grabar($datos_grabar);
            if($tbl_Deta->Ejecutar()){
                $l_Estatus="GRABADO";
            } else {
                $l_Estatus="FALLA";
            }
        } else {
            $l_Estatus="PRODUCTO NO ENCONTRADO";
        }

        if($l_Estatus=="GRABADO"){
            $datos_reg=$datos_reg + ["retorno"=>"TRUE"];
            $datos_reg=$datos_reg + ["msg"=>"GRABADO CON EXITO"]; 
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
        } else {
            $datos_reg=$datos_reg + ["retorno"=>"FALSE"];
            $datos_reg=$datos_reg + ["msg"=>"FALLA EN LA GRABACION DE LOS DETALLES"]; 
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
        }        
                  
        return $datos_reg;
 

    } else {
        $datos_reg=$datos_reg + ["Retorno"=>"FALSE"];
        $datos_reg=$datos_reg + ["msg"=>"NO TIENE ARCHIVO"];
        return $datos_reg;
    }
   
   
}

function fn_Extraer_Excel($l_Archivo,$l_nIDPackingList){
    $retorno= array();
 
    
    include_once "../clases/clHerramientas_v2011.php"; 
    include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
    include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php"; 
    include_once "../bd/conexion.php";

    // ----------------------------------------------
    // Conexion con la base de Datos
    $l_Regreso=RegresaConexion();
    $CONEXION=json_decode($l_Regreso,true); 
    // ----------------------------------------------

    require_once '../Classes/PHPExcel.php';
    $archivo = $l_Archivo;
    $inputFileType = PHPExcel_IOFactory::identify($archivo);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($archivo);
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();

    // Basicos
     $UtileriasDatos = new clHerramientasv2011();
     $l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
     $l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);
                 
     $NombrePC = gethostbyaddr($_SERVER['REMOTE_ADDR']);
     $Fecha = date('Y-m-d');
     $Hora = date('H:i:s');
          
     $l_FechaModificacion=$Fecha." ".$Hora;
     $l_FechaCreacion=$Fecha." ".$Hora;
     $l_Observaciones="Nueva captura - Creado por  - ".$NombrePC." - ".get_current_user()." - ".$l_FechaModificacion;
     $l_bEstado=0;
     $l_bCrear=1;
     $l_bCambiar=0;
     $l_bEliminar=0;

     $l_nIDPackingList_Deta=0;
     $l_CodigoQR="";

     $tbl_Deta = new  cltbl_Packinglist_Deta_v2_0_0();

    for ($row = 2; $row <= $highestRow; $row++){ 
       $datos=array();
       $datos_grabar=array();

       $l_Carton="";
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
       $l_Leidos=0;
       $l_Leidos_Barras=0;

       if($sheet->getCell("A".$row)->getValue()!=null){
            $l_Marca=$sheet->getCell("A".$row)->getValue();
       }

       if($sheet->getCell("B".$row)->getValue()!=null){
           $l_Carton=$sheet->getCell("B".$row)->getValue();
       }

       if($sheet->getCell("C".$row)->getValue()!=null){
           $l_Codigo=$sheet->getCell("C".$row)->getValue();
       }

       if($sheet->getCell("D".$row)->getValue()!=null){
          $l_Descripcion=$sheet->getCell("D".$row)->getValue();
       } 

       if($sheet->getCell("E".$row)->getValue()!=null){
          $l_CantidadPc=$sheet->getCell("E".$row)->getValue();
       }

       if($sheet->getCell("F".$row)->getValue()!=null){
          $l_CantidadCaja=$sheet->getCell("F".$row)->getValue();
       }

       if($sheet->getCell("G".$row)->getValue()!=null){
          $l_Cajas=$sheet->getCell("G".$row)->getValue();
       }

       if($sheet->getCell("H".$row)->getValue()!=null){
          $l_PesoBruto=$sheet->getCell("H".$row)->getValue();
       }

       if($sheet->getCell("I".$row)->getValue()!=null){
          $l_PesoNeto=$sheet->getCell("I".$row)->getValue();
       }

       if($sheet->getCell("J".$row)->getValue()!=null){
           $l_TotalM3=$sheet->getCell("J".$row)->getValue();
       }

       $l_Carton=trim($l_Carton);
       $l_Codigo=trim($l_Codigo);
       $l_Descripcion=trim($l_Descripcion);
       $l_CantidadPc=trim($l_CantidadPc);
       $l_CantidadCaja=trim($l_CantidadCaja);
       $l_Cajas=trim($l_Cajas);
       $l_PesoBruto=trim($l_PesoBruto);
       $l_PesoNeto=trim($l_PesoNeto);
       $l_TotalM3=trim($l_TotalM3);

       // Generar el CodigoQR
       $l_Id=rand(1, 100000);
       $l_Id=$l_Id . $l_FechaModificacion;
       $l_CodigoQR=$l_Codigo . "-" . $l_Id . "," . $l_CantidadCaja;

       // Validacion
       if(!is_numeric($l_CantidadPc)) {
            $l_Estatus="CANTIDAD DE PIEZAS NO ES NUMERICA";           
       }

       if(!is_numeric($l_CantidadCaja)) {
            $l_Estatus="CANTIDAD DE CAJAS NO ES NUMERICA";          
       }

       if(!is_numeric($l_Cajas)) {
            $l_Estatus="LAS CAJAS NO ES NUMERICO";            
       }

       if(!is_numeric($l_PesoBruto)) {
            $l_Estatus="PESO BRUTO NO ES NUMERICO";           
       }

       if(!is_numeric($l_PesoNeto)) {
            $l_Estatus="PESO NETO NO ES NUMERICO";             
       }

       if(!is_numeric($l_TotalM3)) {
            $l_Estatus="M3 NO ES NUMERICO";            
       }
 
       //if(strlen($l_IDProducto)>0 || strlen($l_Codigo)>0 || strlen($l_Codigo_IZeta)>0){
       if(strlen($l_Codigo)>0 ){
             
            $tbl = new  cltbl_Cat_Productos_v2_0_0();
            $tbl->Inicializacion();
            $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl->CargarCampos("LEER");
            $Campo_Llave=$tbl->get_CampoLlave();

            $l_Condicion="bEstado=0 and Activo='SI' and (Codigo='" . $l_Codigo . "' or Codigo_IZeta='" . $l_Codigo . "' or Codigo_SAP='." .$l_Codigo . "')";
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


        if($l_nIDProducto>0){

          if( is_numeric($l_CantidadPc) &&  is_numeric($l_CantidadCaja) && is_numeric($l_Cajas) && is_numeric($l_PesoBruto) &&  is_numeric($l_PesoNeto) &&  is_numeric($l_TotalM3) ) {
                $l_Estatus="NO RECIBIDO";

                array_push($datos_grabar,$l_nIDPackingList_Deta);
                array_push($datos_grabar,$l_nIDPackingList);
                array_push($datos_grabar,$l_nIDProducto);
                array_push($datos_grabar,$l_Codigo);
                array_push($datos_grabar,$l_CodigoQR);
                array_push($datos_grabar,$l_Descripcion);
                array_push($datos_grabar,$l_CantidadPc);
                array_push($datos_grabar,$l_CantidadCaja);
                array_push($datos_grabar,$l_Cajas);
                array_push($datos_grabar,$l_PesoBruto);
                array_push($datos_grabar,$l_PesoNeto);
                array_push($datos_grabar,$l_TotalM3);
                array_push($datos_grabar,$l_Estatus);
                array_push($datos_grabar,$l_Carton);
                array_push($datos_grabar,$l_Leidos);
                array_push($datos_grabar,$l_Leidos_Barras);
                array_push($datos_grabar,$l_FechaLocal);
                array_push($datos_grabar,$l_FechaLocal);
                array_push($datos_grabar,$l_Observaciones);
                array_push($datos_grabar,$l_bEstado);
                array_push($datos_grabar,$l_bCrear);
                array_push($datos_grabar,$l_bCambiar);
                array_push($datos_grabar,$l_bEliminar);

                 
                $tbl_Deta->Inicializacion();
                $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Deta->CargarCampos("GRABAR");
                $tbl_Deta->setInformacion_Grabar($datos_grabar);
                if($tbl_Deta->Ejecutar()){
                    $l_Estatus="GRABADO";
                } else {
                    $l_Estatus="FALLA";
                }
         
             } else {
                $l_Estatus="CAMPOS NO NUMERICOS";
             }
        } else {
            $l_Estatus="NO ENCONTRADO";
        }


        $datos=$datos + ["retorno"=>"TRUE"];
        $datos=$datos + ["msg"=>""]; 
        $datos=$datos + ["nidproducto"=>$l_nIDProducto];
        $datos=$datos + ["carton"=>$l_Carton];
        $datos=$datos + ["codigo"=>$l_Codigo];
        $datos=$datos + ["producto"=>$l_Producto];  
        $datos=$datos + ["descripcion"=>$l_Descripcion];      
        $datos=$datos + ["cantidadpc"=>$l_CantidadPc];
        $datos=$datos + ["cantidadcaja"=>$l_CantidadCaja];
        $datos=$datos + ["cajas"=>$l_Cajas];
        $datos=$datos + ["pesobruto"=>$l_PesoBruto];
        $datos=$datos + ["pesoneto"=>$l_PesoNeto];
        $datos=$datos + ["totalm3"=>$l_TotalM3];
        $datos=$datos + ["estatus"=>$l_Estatus];       
        array_push($retorno,$datos);   
      
        unset($datos);
        unset($datos_grabar);
        
    }
   
    return $retorno;
}



// PROCESO DE INICIO
include_once "../clases/clHerramientas_v2011.php";   
include_once "../clases/packinglist.mysql.class_v2.0.0.php"; 
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
    $datos=$datos + ["msg"=>"NO TIENE REGISTROS"];
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

$l_Folio=0;
$l_nIDPackingList=0;
$l_Folio=$arreglos[0]->{"FOLIO"};
 
if($l_Folio<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE ID DEL ENCABEZADO NO ENCONTRADO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}

$l_Condicion="Folio=" . $l_Folio . " and bEstado=0";

$tbl_Enca = new  cltbl_Packinglist_v2_0_0();
$tbl_Enca->Inicializacion();
$tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_Enca->Leer($l_Condicion);
if($tbl_Enca->CualEsElNumeroDeRegistrosCargados()>0){
    $registros=$tbl_Enca->dtBase();
    $l_nIDPackingList=$registros[0]["nIDPackingList"];
    $l_Archivo=$registros[0]["Archivo"];

    $registros=$tbl_Enca->dtBase();
    $l_nIDPackingList=$registros[0]["nIDPackingList"];
    $l_Archivo=$registros[0]["Archivo"];


    if($l_nIDPackingList<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ID DEL ENCABEZADO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    } 

    if(strlen($l_Archivo)<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ARCHIVO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    } 
} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"ID DEL ENCABEZADO NO ENCONTRADO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
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

    $bandEncontrado=0;
       
    $l_NoLinea=0;
    while(!feof($fp)) {
        $l_linea = fgets($fp);
           
        if(strlen($l_linea)>0){
           if($l_NoLinea>0){          
              $info=fn_Extraer_Info($l_NoLinea,$l_linea, $l_nIDPackingList);
        
              if($info["Retorno"]!="FALSE"){
                 array_push($retorno,$info);  
                 $bandExistoso=1;    
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

    if($bandExistoso==1){
        $datos=array();
        $datos=$datos + ["retorno"=>"TRUE"];
        $datos=$datos + ["msg"=>"PROCESO FINALIZADO CON EXITO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
     } else {
        // Elimina el encabezado
        $l_Condicion="nIDPackingList=" . $l_nIDPackingList;
        $tbl_Enca = new  cltbl_Packinglist_v2_0_0();
        $tbl_Enca->Inicializacion();
        $tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Enca->EliminarConCondicion($l_Condicion);
        
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE PROCESAR LOS REGISTROS"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
     }
 } else {

       if($Extension=="xlsx"){
          $l_Archivo=$target_path . $l_Archivo;
          $info=fn_Extraer_Excel($l_Archivo,$l_nIDPackingList);
           
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
  
  