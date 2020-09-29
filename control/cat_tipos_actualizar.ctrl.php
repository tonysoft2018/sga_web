<?php
// ----------------------------------------------------------------------------------
// cat_tipos_actualizar.ctrl.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { 
//                     info
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

include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/cat_tipos.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";
include_once "../utilerias/utilerias.php";

$retorno= array();
$arreglos = array();
$datos_grabar = array();

$registros_grabados=0;
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));
 
$l_NumeroDeRegistros=count($arreglos);

if($l_NumeroDeRegistros<=0){ 
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE DATOS PARA GRABAR"];
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
$tbl = new  cltbl_Cat_Tipos_v2_0_0();

for($i=0;$i<$l_NumeroDeRegistros;$i++){          
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
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

    // -------------------------------------------------------------------------
    // LEER INFO
    $bandEncontrado=0;
    if($tbl->get_NumCampos()>0){
        for($j=0;$j<$tbl->get_NumCampos();$j++){
            
            $campo=strtolower($tbl->estructura[$j]);
            $bandEncontrado=0;
            
            foreach($arreglos[$i] as $key => $value)
            {
                $mykey = $key;
                $CampoNoRepetir=strtolower(trim($Campo_NoRepetir));
                $CampoLlave=strtolower(trim($Campo_Llave));
                 
                
                if($mykey==$campo){
                    $bandEncontrado=1;
                     
                    array_push($datos_grabar,trim($arreglos[$i]->{$campo}));   
                    
                    if($mykey==$CampoLlave){
                        $Valor_Llave=(int)trim($arreglos[$i]->{$campo});
                    }

                    if($mykey==$CampoNoRepetir){
                        $Valor_NoRepetir=trim($arreglos[$i]->{$campo});                        
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
     for($j=0;$j<count($tbl->tipos);$j++){
        
        if($tbl->tipos[$j]=="CADENA"){
            $datos_grabar[$j]=trim($datos_grabar[$j]);
        }
   
        if($tbl->tipos[$j]=="FECHA"){
            $datos_grabar[$j]=trim($datos_grabar[$j]);   
            
            if(strlen($datos_grabar[$j])>0){
                 if(!EsFecha($datos_grabar[$j])){
                 
                    $campo=$tbl->estructura[$j];
 
                    $datos=array();
                    $datos=$datos + ["retorno"=>"FALSE"];
                    $datos=$datos + ["msg"=>"El Campo " . $campo . ", No es una fecha valida (aaaa-mm-aa o aaaa-mm-aa HH:mm:ss"];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno;    
                    exit(1);                     
                } 
            } else {
                $datos_grabar[$j]="19800101";
            }
        }

        if($tbl->tipos[$j]=="NUMERO"){             
            
            if(strlen($datos_grabar[$j])>0){

                if(!EsNumericoEntero($datos_grabar[$j])){
                    $campo=$tbl->estructura[$j];
 
                    $datos=array();
                    $datos=$datos + ["retorno"=>"FALSE"];
                    $datos=$datos + ["msg"=>"El Campo " . $campo . ", No es numerico entero"];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno;    
                    exit(1);
                }
           } else {
                $datos_grabar[$j]=0;
           }      
        }  

        if($tbl->tipos[$j]=="DECIMAL"){             
            
            if(strlen($datos_grabar[$j])>0){

                if(!EsNumericoDecimal($datos_grabar[$j])){

                    $campo=$tbl->estructura[$j];
 
                    $datos=array();
                    $datos=$datos + ["retorno"=>"FALSE"];
                    $datos=$datos + ["msg"=>"El Campo " . $campo . ", No es numerico decimal"];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno;    
                    exit(1);                     
                }
           } else {
                $datos_grabar[$j]=0;
           }       
        }  
    }
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Obligatorios
    for($j=0;$j<$tbl->get_NumCampos();$j++){
        

        $campo=$tbl->estructura[$j];
        $bandEncontrado=0;
   
        for($k=0;$k<count($tbl->campos_obligatorios);$k++){      
             
            if($campo==$tbl->campos_obligatorios[$k]){
                //echo "\n Campo Leido:" . $campo . "-" . $tbl->campos_obligatorios[$k] . "-Iguales";
     
                if(strlen($datos_grabar[$j])>0){
                 
                    // Rango INICIO
                     switch($tbl->campos_obligatorios_comparativa1[$k]){
                        case "SIN COMPARAR":
                            break;
                        case "COMPARADO CON":
                            $bandLocalizado=0;
                            for($h=0;$h<count($tbl->campos_obligatorios_valorescomparar1);$h++){
                                if($tbl->campos_obligatorios_valorescomparar1[$h]==$datos_grabar[$j]){
                                    $bandLocalizado=1;
                                    break;
                                }
                            }

                            if($bandLocalizado==0){
                                $campo=$tbl->estructura[$j];
 
                                $datos=array();
                                $datos=$datos + ["retorno"=>"FALSE"];                                
                                $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . ", valor " . $datos_grabar[$j] ." Invalido(a)"];                                
                                array_push($retorno,$datos);    
                                $retorno=json_encode($retorno);	 
                                echo $retorno;    
                                exit(1);        
                            }

                            break;
                        case "IGUAL":
                            if($datos_grabar[$j]!=$tbl->campos_obligatorios_rango1[$k]){
                                $campo=$tbl->estructura[$j];
 
                                $datos=array();
                                $datos=$datos + ["retorno"=>"FALSE"];

                                if($tbl->campos_obligatorios_mostrarleyenda[$k]=="SI"){
                                    $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a), debe der ser igual a " .$tbl->campos_obligatorios_rango1[$k] ];                                    
                                } else {
                                    $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a)"];
                                }
                                
                                array_push($retorno,$datos);    
                                $retorno=json_encode($retorno);	 
                                echo $retorno;    
                                exit(1);        
                            } 
                            break;

                        case "MAYOR":
                                if($datos_grabar[$j]<=$tbl->campos_obligatorios_rango1[$k]){
                                    $campo=$tbl->estructura[$j];
 
                                    $datos=array();
                                    $datos=$datos + ["retorno"=>"FALSE"];
                                    if($tbl->campos_obligatorios_mostrarleyenda[$k]=="SI"){
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a), debe der ser mayor a " .$tbl->campos_obligatorios_rango1[$k] ];
                                    } else {
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a)"];
                                    }
                                    
                                    array_push($retorno,$datos);    
                                    $retorno=json_encode($retorno);	 
                                    echo $retorno;    
                                    exit(1);        
                                } 
                                break;

                        case "MENOR":
                                if($datos_grabar[$j]>=$tbl->campos_obligatorios_rango1[$k]){
                                    $campo=$tbl->estructura[$j];
 
                                    $datos=array();
                                    $datos=$datos + ["retorno"=>"FALSE"];
                                    if($tbl->campos_obligatorios_mostrarleyenda[$k]=="SI"){
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a), debe der ser menor a " .$tbl->campos_obligatorios_rango1[$k] ];
                                    } else {
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a)"];
                                    }
                                    array_push($retorno,$datos);    
                                    $retorno=json_encode($retorno);	 
                                    echo $retorno;    
                                    exit(1);        
                                } 
                                break;

                        case "MAYORIGUAL":
                                if($datos_grabar[$j]<$tbl->campos_obligatorios_rango1[$k]){
                                    $campo=$tbl->estructura[$j];
 
                                    $datos=array();
                                    $datos=$datos + ["retorno"=>"FALSE"];                                    
                                    if($tbl->campos_obligatorios_mostrarleyenda[$k]=="SI"){
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a), debe der ser mayor o igual a " .$tbl->campos_obligatorios_rango1[$k] ];
                                    } else {
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a)"];
                                    }
                                    array_push($retorno,$datos);    
                                    $retorno=json_encode($retorno);	 
                                    echo $retorno;    
                                    exit(1);        
                                } 
                                break;

                        case "MENORIGUAL":
                                if($datos_grabar[$j]>$tbl->campos_obligatorios_rango1[$k]){
                                    $campo=$tbl->estructura[$j];
 
                                    $datos=array();
                                    $datos=$datos + ["retorno"=>"FALSE"];                                    
                                    if($tbl->campos_obligatorios_mostrarleyenda[$k]=="SI"){
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a), debe der ser menor o igual a " .$tbl->campos_obligatorios_rango1[$k] ];
                                    } else {
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a)"];
                                    }
                                    array_push($retorno,$datos);    
                                    $retorno=json_encode($retorno);	 
                                    echo $retorno;    
                                    exit(1);        
                                } 
                                break;       
                     }

                     // Rango FIN
                     switch($tbl->campos_obligatorios_comparativa2[$k]){
                        case "SIN COMPARAR":
                            break;
                        case "COMPARADO CON": 
                            $bandLocalizado=0;
                            for($h=0;$h<count($tbl->campos_obligatorios_valorescomparar2);$h++){
                                if($tbl->campos_obligatorios_valorescomparar2[$h]==$datos_grabar[$j]){
                                    $bandLocalizado=1;
                                    break;
                                }
                            }

                            if($bandLocalizado==0){
                                $campo=$tbl->estructura[$j];
 
                                $datos=array();
                                $datos=$datos + ["retorno"=>"FALSE"];                                
                                $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . ", valor " . $datos_grabar[$j] ." Invalido(a)"];                                
                                array_push($retorno,$datos);    
                                $retorno=json_encode($retorno);	 
                                echo $retorno;    
                                exit(1);        
                            }

                            break;
                        case "IGUAL":
                            if($datos_grabar[$j]!=$tbl->campos_obligatorios_rango2[$k]){
                                $campo=$tbl->estructura[$j];
 
                                $datos=array();
                                $datos=$datos + ["retorno"=>"FALSE"];

                                if($tbl->campos_obligatorios_mostrarleyenda[$k]=="SI"){
                                    $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a), debe der ser igual a " .$tbl->campos_obligatorios_rango2[$k] ];                                    
                                } else {
                                    $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a)"];
                                }
                                
                                array_push($retorno,$datos);    
                                $retorno=json_encode($retorno);	 
                                echo $retorno;    
                                exit(1);        
                            } 
                            break;

                        case "MAYOR":
                                if($datos_grabar[$j]<=$tbl->campos_obligatorios_rango2[$k]){
                                    $campo=$tbl->estructura[$j];
 
                                    $datos=array();
                                    $datos=$datos + ["retorno"=>"FALSE"];
                                    if($tbl->campos_obligatorios_mostrarleyenda[$k]=="SI"){
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a), debe der ser mayor a " .$tbl->campos_obligatorios_rango2[$k] ];
                                    } else {
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a)"];
                                    }
                                    
                                    array_push($retorno,$datos);    
                                    $retorno=json_encode($retorno);	 
                                    echo $retorno;    
                                    exit(1);        
                                } 
                                break;

                        case "MENOR":
                                if($datos_grabar[$j]>=$tbl->campos_obligatorios_rango2[$k]){
                                    $campo=$tbl->estructura[$j];
 
                                    $datos=array();
                                    $datos=$datos + ["retorno"=>"FALSE"];
                                    if($tbl->campos_obligatorios_mostrarleyenda[$k]=="SI"){
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a), debe der ser menor a " .$tbl->campos_obligatorios_rango2[$k] ];
                                    } else {
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a)"];
                                    }
                                    array_push($retorno,$datos);    
                                    $retorno=json_encode($retorno);	 
                                    echo $retorno;    
                                    exit(1);        
                                } 
                                break;

                        case "MAYORIGUAL":
                                if($datos_grabar[$j]<$tbl->campos_obligatorios_rango2[$k]){
                                    $campo=$tbl->estructura[$j];
 
                                    $datos=array();
                                    $datos=$datos + ["retorno"=>"FALSE"];                                    
                                    if($tbl->campos_obligatorios_mostrarleyenda[$k]=="SI"){
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a), debe der ser mayor o igual a " .$tbl->campos_obligatorios_rango2[$k] ];
                                    } else {
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a)"];
                                    }
                                    array_push($retorno,$datos);    
                                    $retorno=json_encode($retorno);	 
                                    echo $retorno;    
                                    exit(1);        
                                } 
                                break;

                        case "MENORIGUAL":
                                if($datos_grabar[$j]>$tbl->campos_obligatorios_rango2[$k]){
                                    $campo=$tbl->estructura[$j];
 
                                    $datos=array();
                                    $datos=$datos + ["retorno"=>"FALSE"];                                    
                                    if($tbl->campos_obligatorios_mostrarleyenda[$k]=="SI"){
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a), debe der ser menor o igual a " .$tbl->campos_obligatorios_rango2[$k] ];
                                    } else {
                                        $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Invalido(a)"];
                                    }
                                    array_push($retorno,$datos);    
                                    $retorno=json_encode($retorno);	 
                                    echo $retorno;    
                                    exit(1);        
                                } 
                                break;       
                     }
 

                } else {
                    $campo=$tbl->estructura[$j];
 
                    $datos=array();
                    $datos=$datos + ["retorno"=>"FALSE"];
                    $datos=$datos + ["msg"=>$tbl->campos_obligatorios_leyendas[$k] . " Obligatorio"];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno;    
                    exit(1);        
                }
            }              
        }
    }     
    // -------------------------------------------------------------------------
 
    // -------------------------------------------------------------------------
    // VALIDAR SI ESTA REPETIDO
    if($TipoDato_NoRepetir=="CADENA" || $TipoDato_NoRepetir=="FECHA"){
        $l_Condicion=$Campo_NoRepetir . "='" . $Valor_NoRepetir . "' and not " . $Campo_Llave . "=" . $Valor_Llave;
    } else {
        $l_Condicion=$Campo_NoRepetir . "=" . $Valor_NoRepetir . " and not " . $Campo_Llave . "=" . $Valor_Llave;
    }
 
    if(strlen($l_Condicion)>0){
        $l_Condicion=$l_Condicion . " and bEstado=0";
        
        $tbl->Inicializacion();
        $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl->Leer($l_Condicion);
        if($tbl->CualEsElNumeroDeRegistrosCargados()>0){     
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"REGISTRO REPETIDO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);
        }
    }
    // -------------------------------------------------------------------------
 
    // -------------------------------------------------------------------------
    // GRABAR 
    $registro_datos=array($datos_grabar[0]);
    for($j=1;$j<count($datos_grabar);$j++){
        array_push($registro_datos,$datos_grabar[$j]);
    }
    $registro_datos[count($datos_grabar)-3]=0;             
    $registro_datos[count($datos_grabar)-2]=1;
    $registro_datos[count($datos_grabar)-1]=0;             


    //print_r($registro_datos);

    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->setInformacion_Grabar($registro_datos);
     
    if($tbl->Ejecutar()){
        $registros_grabados=$registros_grabados+1;                 
    }  
    unset($registro_datos);  
    unset($datos_grabar);  
    unset($datos_grabar);   
    // -------------------------------------------------------------------------
} 
 
if($registros_grabados==$l_NumeroDeRegistros){   
    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>"PROCESO FINALIZADO CON EXITO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
} else {     
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE PROCESAR LOS REGISTROS"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
 
?> 
  
  