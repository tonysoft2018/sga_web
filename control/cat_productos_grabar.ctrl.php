<?php
// ----------------------------------------------------------------------------------
// cat_productos_grabar.php
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
    include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_tipos.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_subtipos.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_familias.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_excepciones.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_presentaciones.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_unidadesdemedida.mysql.class_v2.0.0.php";
    include_once "../clases/cat_proveedores.mysql.class_v2.0.0.php";
    include_once "../utilerias/utilerias.php";

    $datos_grabar = array();

    $tbl = new  cltbl_Cat_Productos_v2_0_0();
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



   
        $l_nIDCat_Tipo=0;
        //Buscar el Id de la empresa
        if(strlen($l_Tipo)>0){
            $tb2 = new  cltbl_Cat_Tipos_v2_0_0();          
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
      
            $l_Condicion="Tipo='". trim($l_Tipo) . "'";
            $l_Condicion=$l_Condicion . " and bEstado=0"; 
            
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
            $l_nIDCat_Tipo=$tb2->get_Id($l_Condicion);
       
            if($l_nIDCat_Tipo<0){                                                                 
                $l_Mensaje="TIPO NO ENCONTRADA";        
            }
          
        } else {            
            $l_Mensaje="NO TIENE TIPO";       
        }
        //echo "nIDTipo:" . $l_nIDCat_Tipo;

  
     
        $l_nIDCat_SubTipo=0;
        //Buscar el Id de la empresa
        if(strlen($l_SubTipo)>0){
        
            $tb2 = new  cltbl_Cat_SubTipos_v2_0_0();          
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
 
            $l_Condicion="SubTipo='". trim($l_SubTipo) . "'";
            $l_Condicion=$l_Condicion . " and bEstado=0"; 
            
     
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
            $l_nIDCat_SubTipo=$tb2->get_Id($l_Condicion);
      
            if($l_nIDCat_SubTipo<0){                                                                   
                $l_Mensaje="SUBTIPO NO ENCONTRADA";        
            }
           
          
        } else {
            $l_Mensaje="NO TIENE SUBTIPO";       
        }

        //echo "nIDSubTipo:" . $l_nIDCat_SubTipo;

 

        $l_nIDCat_Familia=0;
        //Buscar el Id de la empresa
        if(strlen($l_Familia)>0){
            $tb2 = new  cltbl_Cat_Familias_v2_0_0();          
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
      
            $l_Condicion="Familia='". trim($l_SubTipo) . "'";
            $l_Condicion=$l_Condicion . " and bEstado=0"; 
            
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
            $l_nIDCat_Familia=$tb2->get_Id($l_Condicion);
       
            if($l_nIDCat_Familia<0){                                                                   
                $l_Mensaje="FAMILIA NO ENCONTRADA";        
            }
          
        } else {
            $l_Mensaje="NO TIENE FAMILIA";       
        }
       
     
        $l_nIDCat_Presentacion=0;
        //Buscar el Id de la empresa
        if(strlen($l_Presentacion)>0){
            $tb2 = new  cltbl_Cat_Presentaciones_v2_0_0();          
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
      
            $l_Condicion="Presentacion='". trim($l_Presentacion) . "'";
            $l_Condicion=$l_Condicion . " and bEstado=0"; 
            
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
            $l_nIDCat_Presentacion=$tb2->get_Id($l_Condicion);
       
            if($l_nIDCat_Presentacion<0){                                                                   
                $l_Mensaje="PRESENTACION NO ENCONTRADA";        
            }
          
        } else {
            $l_Mensaje="NO TIENE PRESENTACION";       
        }

 
        $l_nIDCat_Excepcion=0;
        //Buscar el Id de la empresa
        if(strlen($l_Excepcion)>0){
          
            $tb2 = new  cltbl_Cat_Excepciones_v2_0_0();          
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
  
            $l_Condicion="Excepcion='". trim($l_Excepcion) . "'";
            $l_Condicion=$l_Condicion . " and bEstado=0"; 
                   
      
            $l_nIDCat_Excepcion=$tb2->get_Id($l_Condicion);
       
            if($l_nIDCat_Excepcion<0){                                                                   
                $l_Mensaje="EXCEPCION NO ENCONTRADA";        
            }
            
          
        } else {
            $l_Mensaje="NO TIENE EXCEPCION";       
        }

   
        $l_nIDCat_UnidadDeMedida=0;
        //Buscar el Id de la empresa
        if(strlen($l_UnidadDeMedida)>0){
            $tb2 = new  cltbl_Cat_UnidadesDeMedida_v2_0_0();          
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
      
            $l_Condicion="UnidadDeMedida='". trim($l_UnidadDeMedida) . "'";
            $l_Condicion=$l_Condicion . " and bEstado=0"; 
            
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
            $l_nIDCat_UnidadDeMedida=$tb2->get_Id($l_Condicion);
       
            if($l_nIDCat_UnidadDeMedida<0){                                                                   
                $l_Mensaje="UNIDAD DE MEDIDA NO ENCONTRADA";        
            }
          
        } else {
            $l_Mensaje="NO TIENE UNIDAD DE MEDIDA";       
        }
       
        $l_nIDCat_Proveedor=0;
        //Buscar el Id de la empresa
        if(strlen($l_Proveedor)>0){
            $tb2 = new  cltbl_Cat_Proveedores_v2_0_0();          
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
      
            $l_Condicion="RazonSocial='". trim($l_Proveedor) . "'";
            $l_Condicion=$l_Condicion . " and bEstado=0"; 
             
            $tb2->Inicializacion();
            $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
            $l_nIDCat_Proveedor=$tb2->get_Id($l_Condicion);
       
            if($l_nIDCat_Proveedor<0){                                                                   
                $l_Mensaje="PROVEEDOR NO ENCONTRADA";        
            }
          
        } else {
            $l_Mensaje="NO TIENE PROVEEDOR";       
        }
   

        $datos_leidos=$datos_leidos + ["idproducto"=>$l_IDProducto];
        $datos_leidos=$datos_leidos + ["codigo"=>$l_Codigo];
        $datos_leidos=$datos_leidos + ["codigo_sap"=>$l_Codigo_SAP];
        $datos_leidos=$datos_leidos + ["codigo_izeta"=>$l_Codigo_IZeta];
        $datos_leidos=$datos_leidos + ["producto"=>$l_Producto];
        $datos_leidos=$datos_leidos + ["descripcion"=>$l_Descripcion];
        $datos_leidos=$datos_leidos + ["imagen"=>""];
        $datos_leidos=$datos_leidos + ["nidcat_tipo"=>$l_nIDCat_Tipo];
        $datos_leidos=$datos_leidos + ["nidcat_subtipo"=>$l_nIDCat_SubTipo];
        $datos_leidos=$datos_leidos + ["nidcat_familia"=>$l_nIDCat_Familia];
        $datos_leidos=$datos_leidos + ["nidcat_presentacion"=>$l_nIDCat_Presentacion];
        $datos_leidos=$datos_leidos + ["nidcat_excepcion"=>$l_nIDCat_Excepcion];
        $datos_leidos=$datos_leidos + ["nidcat_unidaddemedida"=>$l_nIDCat_UnidadDeMedida];
        $datos_leidos=$datos_leidos + ["nidcat_proveedor"=>$l_nIDCat_Proveedor];      
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
            $registro_datos[count($datos_grabar)-3]=1;             
            $registro_datos[count($datos_grabar)-2]=0;             
            $registro_datos[count($datos_grabar)-1]=0;        
 
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
        $datos=$datos + ["idproducto"=>$l_IDProveedor_IZeta];
        $datos=$datos + ["codigo"=>$l_IDProveedor_IZeta];
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
    include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_tipos.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_subtipos.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_familias.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_excepciones.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_presentaciones.mysql.class_v2.0.0.php"; 
    include_once "../clases/cat_unidadesdemedida.mysql.class_v2.0.0.php";
    include_once "../clases/cat_proveedores.mysql.class_v2.0.0.php";
    include_once "../utilerias/utilerias.php";
 
    
    $tbl = new  cltbl_Cat_Productos_v2_0_0();
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

        if(strlen($l_IDProducto)>0 || strlen($l_Codigo)>0  || strlen($l_Codigo_IZeta)>0 ){
            if(strlen($l_Producto)>0){

                $l_nIDCat_Tipo=0;
                //Buscar el Id de la empresa
                if(strlen($l_Tipo)>0){
                    $tb2 = new  cltbl_Cat_Tipos_v2_0_0();          
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
      
                    $l_Condicion="Tipo='". trim($l_Tipo) . "'";
                    $l_Condicion=$l_Condicion . " and bEstado=0"; 
            
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
                    $l_nIDCat_Tipo=$tb2->get_Id($l_Condicion);
       
                    if($l_nIDCat_Tipo<0){                                                                 
                        $l_Mensaje="TIPO NO ENCONTRADA";        
                    }
          
                } else {            
                    $l_Mensaje="NO TIENE TIPO";       
                }
                //echo "nIDTipo:" . $l_nIDCat_Tipo;


                $l_nIDCat_SubTipo=0;
                //Buscar el Id de la empresa
                if(strlen($l_SubTipo)>0){
                
                    $tb2 = new  cltbl_Cat_SubTipos_v2_0_0();          
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
         
                    $l_Condicion="SubTipo='". trim($l_SubTipo) . "'";
                    $l_Condicion=$l_Condicion . " and bEstado=0"; 
                    
             
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
                    $l_nIDCat_SubTipo=$tb2->get_Id($l_Condicion);
              
                    if($l_nIDCat_SubTipo<0){                                                                   
                        $l_Mensaje="SUBTIPO NO ENCONTRADA";        
                    }
                   
                  
                } else {
                    $l_Mensaje="NO TIENE SUBTIPO";       
                }
        
                //echo "nIDSubTipo:" . $l_nIDCat_SubTipo;

                $l_nIDCat_Familia=0;
                //Buscar el Id de la empresa
                if(strlen($l_Familia)>0){
                    $tb2 = new  cltbl_Cat_Familias_v2_0_0();          
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
              
                    $l_Condicion="Familia='". trim($l_SubTipo) . "'";
                    $l_Condicion=$l_Condicion . " and bEstado=0"; 
                    
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
                    $l_nIDCat_Familia=$tb2->get_Id($l_Condicion);
               
                    if($l_nIDCat_Familia<0){                                                                   
                        $l_Mensaje="FAMILIA NO ENCONTRADA";        
                    }
                  
                } else {
                    $l_Mensaje="NO TIENE FAMILIA";       
                }


                $l_nIDCat_Presentacion=0;
                //Buscar el Id de la empresa
                if(strlen($l_Presentacion)>0){
                    $tb2 = new  cltbl_Cat_Presentaciones_v2_0_0();          
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
              
                    $l_Condicion="Presentacion='". trim($l_Presentacion) . "'";
                    $l_Condicion=$l_Condicion . " and bEstado=0"; 
                    
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
                    $l_nIDCat_Presentacion=$tb2->get_Id($l_Condicion);
               
                    if($l_nIDCat_Presentacion<0){                                                                   
                        $l_Mensaje="PRESENTACION NO ENCONTRADA";        
                    }
                  
                } else {
                    $l_Mensaje="NO TIENE PRESENTACION";       
                }
        
         
                $l_nIDCat_Excepcion=0;
                //Buscar el Id de la empresa
                if(strlen($l_Excepcion)>0){
                  
                    $tb2 = new  cltbl_Cat_Excepciones_v2_0_0();          
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
          
                    $l_Condicion="Excepcion='". trim($l_Excepcion) . "'";
                    $l_Condicion=$l_Condicion . " and bEstado=0"; 
                           
              
                    $l_nIDCat_Excepcion=$tb2->get_Id($l_Condicion);
               
                    if($l_nIDCat_Excepcion<0){                                                                   
                        $l_Mensaje="EXCEPCION NO ENCONTRADA";        
                    }
                    
                  
                } else {
                    $l_Mensaje="NO TIENE EXCEPCION";       
                }


                $l_nIDCat_UnidadDeMedida=0;
                //Buscar el Id de la empresa
                if(strlen($l_UnidadDeMedida)>0){
                    $tb2 = new  cltbl_Cat_UnidadesDeMedida_v2_0_0();          
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
              
                    $l_Condicion="UnidadDeMedida='". trim($l_UnidadDeMedida) . "'";
                    $l_Condicion=$l_Condicion . " and bEstado=0"; 
                    
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
                    $l_nIDCat_UnidadDeMedida=$tb2->get_Id($l_Condicion);
               
                    if($l_nIDCat_UnidadDeMedida<0){                                                                   
                        $l_Mensaje="UNIDAD DE MEDIDA NO ENCONTRADA";        
                    }
                  
                } else {
                    $l_Mensaje="NO TIENE UNIDAD DE MEDIDA";       
                }
               
                $l_nIDCat_Proveedor=0;
                //Buscar el Id de la empresa
                if(strlen($l_Proveedor)>0){
                    $tb2 = new  cltbl_Cat_Proveedores_v2_0_0();          
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
              
                    $l_Condicion="RazonSocial='". trim($l_Proveedor) . "'";
                    $l_Condicion=$l_Condicion . " and bEstado=0"; 
                     
                    $tb2->Inicializacion();
                    $tb2->DatosParaConectarse($l_Servidor,$l_Usuario,$l_Password,$l_Bd);
                    $l_nIDCat_Proveedor=$tb2->get_Id($l_Condicion);
               
                    if($l_nIDCat_Proveedor<0){                                                                   
                        $l_Mensaje="PROVEEDOR NO ENCONTRADA";        
                    }
                  
                } else {
                    $l_Mensaje="NO TIENE PROVEEDOR";       
                }

                $datos_leidos=$datos_leidos + ["idproducto"=>$l_IDProducto];
                $datos_leidos=$datos_leidos + ["codigo"=>$l_Codigo];
                $datos_leidos=$datos_leidos + ["codigo_sap"=>$l_Codigo_SAP];
                $datos_leidos=$datos_leidos + ["codigo_izeta"=>$l_Codigo_IZeta];
                $datos_leidos=$datos_leidos + ["producto"=>$l_Producto];
                $datos_leidos=$datos_leidos + ["descripcion"=>$l_Descripcion];
                $datos_leidos=$datos_leidos + ["imagen"=>""];
                $datos_leidos=$datos_leidos + ["nidcat_tipo"=>$l_nIDCat_Tipo];
                $datos_leidos=$datos_leidos + ["nidcat_subtipo"=>$l_nIDCat_SubTipo];
                $datos_leidos=$datos_leidos + ["nidcat_familia"=>$l_nIDCat_Familia];
                $datos_leidos=$datos_leidos + ["nidcat_presentacion"=>$l_nIDCat_Presentacion];
                $datos_leidos=$datos_leidos + ["nidcat_excepcion"=>$l_nIDCat_Excepcion];
                $datos_leidos=$datos_leidos + ["nidcat_unidaddemedida"=>$l_nIDCat_UnidadDeMedida];
                $datos_leidos=$datos_leidos + ["nidcat_proveedor"=>$l_nIDCat_Proveedor];      
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

                if($bandCorrecto){
                    $datos=$datos + ["estatus"=>"PROCESADO"];
                } else {
                    $datos=$datos + ["estatus"=>$l_Mensaje];
                }

                array_push($retorno,$datos);   
                unset($datos);
                unset($datos_grabar);
                unset($registro_datos);  
                unset($datos_leidos);
                unset($Valor_NoRepetir);  

            } else {
                // Datos incompletos
                
                unset($datos);
                unset($datos_grabar);
                unset($registro_datos);  
                unset($datos_leidos);
                unset($Valor_NoRepetir);  
            }
        } else {
            // Datos incompletos
            
            unset($datos);
            unset($datos_grabar);
            unset($registro_datos);  
            unset($datos_leidos);
            unset($Valor_NoRepetir);  
        }        
    }

    return $retorno;  
    
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
  