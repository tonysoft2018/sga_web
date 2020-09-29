<?php
// ----------------------------------------------------------------------------------
// cat_pasillos_grabar.php
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

function fn_Extraer_Info($l_Linea, $l_Cadena, $l_Servidor, $l_Usuario, $l_Password, $l_Bd){
  
    include_once "../clases/clHerramientas_v2011.php"; 
    include_once "../clases/cat_tipos.mysql.class_v2.0.0.php"; 
    include_once "../utilerias/utilerias.php";

    $datos_grabar = array();

    $tbl = new  cltbl_Cat_Tipos_v2_0_0();
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
    $tbl->CargarCampos("GRABAR");


    $Campo_Llave=$tbl->get_CampoLlave();
    $Valor_Llave=0;

    $Campo_NoRepetir=$tbl->get_CampoIrrepetible();
    $TipoDato_NoRepetir=$tbl->get_TipoDatoIrrepetible();
    $Valor_NoRepetir="";

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
 
    $campo="";

    $datos=array();
    $datos_leidos=array();
    $arreglos=array();

    $l_Mensaje="";

  
    if($l_Linea>0){

       $l_Cadena=CONVERTIR_ESPECIALES_HTML($l_Cadena);
  
       $l_Columna=0;
       $i=0;
       $l_Valor="";
  
       $l_No=0;
       $l_IDTipo="";  
       $l_Tipo="";  
       $l_Descripcion="";
         
       for($i=0;$i<strlen($l_Cadena);$i++){
           $l_Valor=substr($l_Cadena,$i,1);
           if($l_Valor=="," || $l_Valor==";"){
              if($l_Columna<3){
                 $l_Columna=$l_Columna+1;
              }
           } else {
              switch($l_Columna){
                 case 0:$l_IDTipo=$l_IDTipo . $l_Valor;
                        break;
                 case 1:$l_Tipo=$l_Tipo . $l_Valor;
                        break;
                 case 2:$l_Descripcion=$l_Descripcion . $l_Valor;
                        break;                  
              }
           }
        }

        $datos_leidos=$datos_leidos + ["idtipo"=>$l_IDTipo];
        $datos_leidos=$datos_leidos + ["tipo"=>$l_Tipo];
        $datos_leidos=$datos_leidos + ["descripcion"=>$l_Descripcion];
        $datos_leidos=$datos_leidos + ["activo"=>"SI"];


        $arreglos=$datos_leidos; 
        // ----------------------------------------------------
        // Grabación
        // ----------------------------------------------------


        // -------------------------------------------------------------------------
        // LEER INFO
        $bandEncontrado=0;
        $i=0;
 
        if($tbl->get_NumCampos()>0){
        
            for($j=0;$j<$tbl->get_NumCampos();$j++){

                   
                $campo=strtolower($tbl->estructura[$j]);
                $bandEncontrado=0;
            
                foreach($arreglos as $key => $value)
                {
                    $mykey = $key;
                   
                    $CampoNoRepetir=strtolower(trim($Campo_NoRepetir));

                    if($mykey==$campo){
                        $bandEncontrado=1;
                         
                        array_push($datos_grabar,trim($arreglos[$campo]));   
                    
                        if($mykey==$Campo_Llave){
                            $Valor_Llave=(int)trim($arreglos[$campo]);
                        }

                        if($mykey==$CampoNoRepetir){
                            $Valor_NoRepetir=trim($arreglos[$campo]);                        
                        }                    
                    } 
                }

       
                if($bandEncontrado!=1){

                    if($tbl->tipos[$j]=="CADENA"){
                        if($campo=="observaciones"){
                            array_push($datos_grabar,$l_Observaciones);                           
                        } else {
                            array_push($datos_grabar,"");   
                        }                    
                    }
           
                    if($tbl->tipos[$j]=="FECHA"){
                        if($campo=="fecha"){
                            array_push($datos_grabar,$l_FechaLocal);   
                        } else {
                            array_push($datos_grabar,"19800101");   
                        }                    
                    }

                    if($tbl->tipos[$j]=="NUMERO"){
                        array_push($datos_grabar,0);   
                    }  
                
                    if($tbl->tipos[$j]=="DECIMAL"){
                        array_push($datos_grabar,0);   
                    }         
                }
            }
        }      
        // -------------------------------------------------------------------------

       
        // -------------------------------------------------------------------------
        // Validacion 
        $bandCorrecto=1;
        for($j=0;$j<count($tbl->tipos);$j++){
       
        
            if($tbl->tipos[$j]=="CADENA"){
                $datos_grabar[$j]=trim($datos_grabar[$j]);
            }
   
            if($tbl->tipos[$j]=="FECHA"){
                $datos_grabar[$j]=trim($datos_grabar[$j]);   
            
                if(strlen($datos_grabar[$j])>0){
                    if(!EsFecha($datos_grabar[$j])){
                 
                        $campo=$tbl->estructura[$j];
                           
                        $l_Mensaje="El Campo " . $campo . ", No es una fecha valida (aaaa-mm-aa o aaaa-mm-aa HH:mm:ss";     
                        $bandCorrecto=0;   
                        break;                
                    } 
                } else {
                    $datos_grabar[$j]="19800101";
                }
            }

    
            if($tbl->tipos[$j]=="NUMERO"){             
                
                if(strlen($datos_grabar[$j])>0){

                    if(!EsNumericoEntero($datos_grabar[$j])){

                        $campo=$tbl->estructura[$j];
                         
                        $l_Mensaje="El Campo " . $campo . ", No es numerico entero";
                        $bandCorrecto=0;
                        break;                                  
                    }
                } else {
                    $datos_grabar[$j]=0;
                }          
            }  

            if($tbl->tipos[$j]=="DECIMAL"){             
            
                if(strlen($datos_grabar[$j])>0){

                    if(!EsNumericoDecimal($datos_grabar[$j])){

                        $campo=$tbl->estructura[$j];                                                   
                        $l_Mensaje="El Campo " . $campo . ", No es numerico decimal";
                        $bandCorrecto=0;
                        break;                
                     }
                } else {
                    $datos_grabar[$j]=0;
                }                  
            }  
       
        }
        // -------------------------------------------------------------------------


        // -------------------------------------------------------------------------
        // VALIDAR SI ESTA REPETIDO  
        if($bandCorrecto){
 
            if($TipoDato_NoRepetir=="CADENA" || $TipoDato_NoRepetir=="FECHA"){
                $l_Condicion=$Campo_NoRepetir . "='" . $Valor_NoRepetir . "'";            
            } else {
                $l_Condicion=$Campo_NoRepetir . "=" . $Valor_NoRepetir;
            }

            if(strlen($l_Condicion)>0){

                $l_Condicion=$l_Condicion . " and bEstado=0";            
                $tbl->Inicializacion();
                $tbl->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
                $tbl->Leer($l_Condicion);
                if($tbl->CualEsElNumeroDeRegistrosCargados()>0){                      
                    $bandCorrecto=0;                
                    $l_Mensaje="REGISTRO EXISTENTE";                 
                }
            }            
        }   
        // -------------------------------------------------------------------------

   
        // -------------------------------------------------------------------------
        // GRABAR   
        if($bandCorrecto){
            $registro_datos=array($datos_grabar[0]);
            for($j=1;$j<count($datos_grabar);$j++){
                array_push($registro_datos,$datos_grabar[$j]);
            }
            array_push($registro_datos,1); // Crear 
            array_push($registro_datos,0); // Cambiar
            array_push($registro_datos,0); // Eliminar
 
            $tbl->Inicializacion();
            $tbl->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
            $tbl->setInformacion_Grabar($registro_datos);
     
            if($tbl->Ejecutar()){
                $registros_grabados=$registros_grabados+1;                 
            }  
            unset($registro_datos);  
            unset($datos_grabar);  
            unset($datos_grabar);  

            if($registros_grabados!=$l_NumeroDeRegistros){                   
                $l_Mensaje="GRABADO";
            }  else {
                $bandCorrecto=0;
                $l_Mensaje="NO GRABADO";
            }
        }
        // ------------------------------------------------------------------------- 

        $datos=$datos + ["retorno"=>"TRUE"];
        $datos=$datos + ["msg"=>$l_Mensaje];         
        // ----------------------------------------------------
        // ****************************************************
        // ----------------------------------------------------

        // Regresar        
        $datos=$datos + ["idtipo"=>$l_IDTipo];
        $datos=$datos + ["tipo"=>$l_Tipo];
        $datos=$datos + ["descripcion"=>$l_Descripcion];

        if($bandCorrecto){
            $datos=$datos + ["estatus"=>"PROCESADO"];
        } else {
            $datos=$datos + ["estatus"=>$l_Mensaje];
        }
        



        return $datos;

    } else {
        $datos=$datos + ["Retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ARCHIVO"];
        return $datos;
    }
    
}

function fn_Extraer_Excel($l_Servidor, $l_Usuario, $l_Password, $l_Bd, $l_Archivo){
 
    $retorno= array();
    
    include_once "../clases/clHerramientas_v2011.php"; 
    include_once "../clases/cat_tipos.mysql.class_v2.0.0.php";      
    include_once "../utilerias/utilerias.php";
 
    
    $tbl = new  cltbl_Cat_Tipos_v2_0_0();
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
    $tbl->CargarCampos("GRABAR");

    $Campo_Llave=$tbl->get_CampoLlave();
    $Valor_Llave=0;

    $Campo_NoRepetir=$tbl->get_CampoIrrepetible();
    $TipoDato_NoRepetir=$tbl->get_TipoDatoIrrepetible();
    $Valor_NoRepetir= array();

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
 
    $campo="";

    $datos=array();
    $datos_leidos=array();
    $arreglos=array();

    $l_Mensaje="";

    $registros_grabados=0;
 
 
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
       $datos_grabar = array();
       $datos_leidos=array();
       $Valor_NoRepetir= array();

       $tbl->CargarCampos("GRABAR");


       $l_IDTipo="";  
       $l_Tipo="";  
       $l_Descripcion="";


        if($sheet->getCell("A".$row)->getValue()!=null){
            $l_IDTipo=$sheet->getCell("A".$row)->getValue();
        }

        if($sheet->getCell("B".$row)->getValue()!=null){
            $l_Tipo=$sheet->getCell("B".$row)->getValue();
        } 

        if($sheet->getCell("C".$row)->getValue()!=null){
            $l_Descripcion=$sheet->getCell("C".$row)->getValue();
        }

        if(strlen($l_IDTipo)>0 ){
            if(strlen($l_Tipo)>0){
                
                $datos_leidos=$datos_leidos + ["idtipo"=>$l_IDTipo];
                $datos_leidos=$datos_leidos + ["tipo"=>$l_Tipo];
                $datos_leidos=$datos_leidos + ["descripcion"=>$l_Descripcion];
                $datos_leidos=$datos_leidos + ["activo"=>"SI"];
         
                $arreglos=$datos_leidos; 

                // -------------------------------------------------------------------------
                // LEER INFO
                $bandEncontrado=0;
                $i=0;
 
                //echo "Valores:" . count($tbl->campos_norepetir);
                //print_r($tbl->campos_norepetir);

                if($tbl->get_NumCampos()>0){
        
                    for($j=0;$j<$tbl->get_NumCampos();$j++){
                   
                        $campo=strtolower($tbl->estructura[$j]);
                        $bandEncontrado=0;
            
                        foreach($arreglos as $key => $value)
                        {
                            $mykey = $key;
                   
                            $CampoNoRepetir=strtolower(trim($Campo_NoRepetir));

                            if($mykey==$campo){
                                $bandEncontrado=1;
                         
                                array_push($datos_grabar,trim($arreglos[$campo]));   
                    
                                if($mykey==$Campo_Llave){
                                    $Valor_Llave=(int)trim($arreglos[$campo]);
                                }

                                for($k=0;$k<count($tbl->campos_norepetir);$k++){
                            
                                    if( $mykey==strtolower($tbl->campos_norepetir[$k]) ){                               
                                        array_push($Valor_NoRepetir,trim($arreglos[$campo]) );                                             
                                    }           
                                }                              
                            } 
                        }
       
                        if($bandEncontrado!=1){

                            if($tbl->tipos[$j]=="CADENA"){
                                if($campo=="observaciones"){
                                    array_push($datos_grabar,$l_Observaciones);                           
                                } else {
                                    array_push($datos_grabar,"");   
                                }                    
                            }
           
                            if($tbl->tipos[$j]=="FECHA"){
                                if($campo=="fecha"){
                                    array_push($datos_grabar,$l_FechaLocal);   
                                } else {
                                    array_push($datos_grabar,"19800101");   
                                }                    
                            }

                            if($tbl->tipos[$j]=="NUMERO"){
                                array_push($datos_grabar,0);   
                            }  
                
                            if($tbl->tipos[$j]=="DECIMAL"){
                                array_push($datos_grabar,0);   
                            }         
                        }
                    }
                }        
                //echo "Salida 1\n";
                //print_r($datos_grabar);          
                // -------------------------------------------------------------------------


                // -------------------------------------------------------------------------
                 // Validacion 
                 $bandCorrecto=1;
                 for($j=0;$j<count($tbl->tipos);$j++){
       
        
                    if($tbl->tipos[$j]=="CADENA"){
                        $datos_grabar[$j]=trim($datos_grabar[$j]);
                    }
   
                    if($tbl->tipos[$j]=="FECHA"){
                        $datos_grabar[$j]=trim($datos_grabar[$j]);   
            
                        if(strlen($datos_grabar[$j])>0){
                            if(!EsFecha($datos_grabar[$j])){
                 
                                $campo=$tbl->estructura[$j];
                           
                                $l_Mensaje="El Campo " . $campo . ", No es una fecha valida (aaaa-mm-aa o aaaa-mm-aa HH:mm:ss";     
                                $bandCorrecto=0;   
                                break;                
                            } 
                        } else {
                            $datos_grabar[$j]="19800101";
                        }
                    }

    
                    if($tbl->tipos[$j]=="NUMERO"){             
                
                        if(strlen($datos_grabar[$j])>0){

                            if(!EsNumericoEntero($datos_grabar[$j])){

                                $campo=$tbl->estructura[$j];
                         
                                $l_Mensaje="El Campo " . $campo . ", No es numerico entero";
                                $bandCorrecto=0;
                                break;                                  
                            }
                        } else {
                            $datos_grabar[$j]=0;
                        }          
                    }  

                    if($tbl->tipos[$j]=="DECIMAL"){             
            
                        if(strlen($datos_grabar[$j])>0){

                            if(!EsNumericoDecimal($datos_grabar[$j])){

                                $campo=$tbl->estructura[$j];                                                   
                                $l_Mensaje="El Campo " . $campo . ", No es numerico decimal";
                                $bandCorrecto=0;
                                break;                
                            }
                        } else {
                            $datos_grabar[$j]=0;
                        }                  
                    }         
                }
                // -------------------------------------------------------------------------



                // -------------------------------------------------------------------------
                // VALIDAR SI ESTA REPETIDO  
                if($bandCorrecto){
  
                    $l_Condicion="";
 
                    if(count($Valor_NoRepetir)==count($tbl->campos_norepetir)){

                        for($k=0;$k<count($tbl->campos_norepetir);$k++){

                            if($tbl->campos_norepetir_tipo[$k]=="CADENA"){             
    
                                if(strlen($l_Condicion)>0){
                                    $l_Condicion=$l_Condicion . " or " . $tbl->campos_norepetir[$k] . "='" . $Valor_NoRepetir[$k] . "'";
                                } else {
                                    $l_Condicion=$tbl->campos_norepetir[$k] . "='" . $Valor_NoRepetir[$k] . "'";
                                }
                            }
    
                            if($tbl->campos_norepetir_tipo[$k]=="FECHA"){             
                                if(strlen($l_Condicion)>0){
                                    $l_Condicion=$l_Condicion . " or " . $tbl->campos_norepetir[$k] . "='" . $Valor_NoRepetir[$k] . "'";
                                } else {
                                    $l_Condicion=$tbl->campos_norepetir[$k] . "='" . $Valor_NoRepetir[$k] . "'";
                                }
                            }
    
                            if($tbl->campos_norepetir_tipo[$k]=="NUMERO"){             
                                if(strlen($l_Condicion)>0){
                                    $l_Condicion=$l_Condicion . " or " . $tbl->campos_norepetir[$k] . "=" . $Valor_NoRepetir[$k];
                                } else {
                                    $l_Condicion=$tbl->campos_norepetir[$k] . "=" . $Valor_NoRepetir[$k]; 
                                }
                            }    
                        }
                    }
                       
                    if(strlen($l_Condicion)>0){

                        $l_Condicion=$l_Condicion . " and bEstado=0";            
                        $tbl->Inicializacion();
                        $tbl->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
                        $tbl->Leer($l_Condicion);
                        if($tbl->CualEsElNumeroDeRegistrosCargados()>0){                      
                            $bandCorrecto=0;                
                            $l_Mensaje="REGISTRO EXISTENTE";                          
                        }
                    }            
                }          
                // -------------------------------------------------------------------------


                 // -------------------------------------------------------------------------
                 // GRABAR   
                if($bandCorrecto){
                    $registro_datos=array($datos_grabar[0]);
                    for($j=1;$j<count($datos_grabar);$j++){
                        array_push($registro_datos,$datos_grabar[$j]);
                    }
                    //print_r($datos_grabar);
          
                    $registro_datos[count($datos_grabar)-3]=1;             
                    $registro_datos[count($datos_grabar)-2]=0;             
                    $registro_datos[count($datos_grabar)-1]=0;             

                    //print_r($registro_datos);
            
                    $tbl->Inicializacion();
                    $tbl->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
                    $tbl->CargarCampos("GRABAR");            
                    $tbl->setInformacion_Grabar($registro_datos);
                
                    if($tbl->Ejecutar()){
                        $registros_grabados=$registros_grabados+1;  
                        $l_Mensaje="GRABADO";               
                    } 
            
                    unset($registro_datos);  
                    unset($datos_grabar);  
                }
                // ------------------------------------------------------------------------- 

                $datos=$datos + ["retorno"=>"TRUE"];
                $datos=$datos + ["msg"=>$l_Mensaje];         
                // ----------------------------------------------------
                // ****************************************************
                // ----------------------------------------------------

                // Regresar              
                $datos=$datos + ["IDTipo"=>$l_IDTipo];
                $datos=$datos + ["Tipo"=>$l_Tipo];
                $datos=$datos + ["Descripcion"=>$l_Descripcion];

                if($bandCorrecto){
                    $datos=$datos + ["estatus"=>"PROCESADO"];
                } else {
                    $datos=$datos + ["estatus"=>$l_Mensaje];
                }

                array_push($retorno,$datos);   

                unset($datos);
                unset($datos_grabar);
                unset($datos_leidos);
                unset($registro_datos);  
                unset($Valor_NoRepetir);  

            } else {
                // Datos incompletos
                
               unset($datos);
               unset($datos_grabar);
               unset($datos_leidos);
               unset($registro_datos);  
               unset($Valor_NoRepetir);  
            }
        } else {
            // Datos incompletos
            
            unset($datos);
            unset($datos_grabar);
            unset($datos_leidos);
            unset($registro_datos);  
            unset($Valor_NoRepetir);  
        }        
    }

    return $retorno;  
    
}

 
 
include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/cat_tipos.mysql.class_v2.0.0.php"; 
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
$l_Servidor=$CONEXION["servidor"];
$l_Bd=$CONEXION["bd"];
$l_Usuario=$CONEXION["usuario"];
$l_Password=$CONEXION["password"];

//echo "Usuario:" . $l_Usuario . "-" . $l_Password; 
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
             $info=fn_Extraer_Info($l_NoLinea,$l_linea,$l_Servidor, $l_Usuario, $l_Password, $l_Bd);
     
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
 }  else {
    if($Extension=="xlsx"){
        $l_Archivo=$target_path . $l_Archivo;
        $info=fn_Extraer_Excel($l_Servidor, $l_Usuario, $l_Password, $l_Bd,$l_Archivo);
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
?> 
  