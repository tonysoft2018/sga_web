<?php
// ----------------------------------------------------------------------------------
// ambiente_calificaciones_deta_crear.ctrl.php
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

include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/ambiente_clasificaciones.mysql.class_v2.0.0.php"; 
include_once "../clases/ambiente_clasificaciones_deta.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";
include_once "../utilerias/utilerias.php";

$retorno= array();
$arreglos = array();
$datos_grabar = array();
$ids_leidos=array();

$datos_leidos = array();

$registros_grabados=0;

$bandEncontrado=0;
 
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
// Obtener el nID del encabezado
$l_Folio=0;
$l_nIDAmbiente_Clasificacion=0;

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
//echo "Condicion:" . $l_Condicion;

$tbl_Enca = new  cltbl_Ambiente_Clasificaciones_v2_0_0();
$tbl_Enca->Inicializacion();
$tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_Enca->Leer($l_Condicion);
if($tbl_Enca->CualEsElNumeroDeRegistrosCargados()>0){
            
    $registros=$tbl_Enca->dtBase();
    $l_nIDAmbiente_Clasificacion=$registros[0]["nIDAmbiente_Clasificacion"];

    if($l_nIDAmbiente_Clasificacion<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ID DEL ENCABEZADO"];
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

 
//echo "ID ENCA:" . $l_nIDAmbiente_Clasificacion . "\n"; 
// ----------------------------------------------

// print_r($arreglos);

 
$tbl = new  cltbl_Ambiente_Clasificaciones_Deta_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);

 
for($i=0;$i<$l_NumeroDeRegistros;$i++){  
    $tamaxo=count($arreglos);
    //echo "Tamaxo:" . $tamaxo;
   
    foreach($arreglos[$i] as $key => $value){ 
        //echo "Llave:" . $key;

      
        if($key!="FOLIO"){
            // Separación
            //echo "\n Llave:" . $key . "=" . $arreglos[$i]->{$key};
            $Valor=$arreglos[$i]->{$key};
 
          

            //echo "Valor:" . $Valor;
            $pos=-1;
            $pos=strpos($key,"_");
            $Funcion=substr($key,0,$pos);
            $pos=$pos+1;
            $IDModulo=substr($key,$pos,strlen($key));
 
            if($IDModulo>0){
                $bandEncontrado=0;
                for($j=0;$j<count($ids_leidos);$j++){
    
                    if($ids_leidos[$j]==$IDModulo){
                        $bandEncontrado=1;
                        break;
                    }
                }
            } else {
                $bandEncontrado=1;
            }
           
 
            if($bandEncontrado==0){
                array_push($ids_leidos,$IDModulo);
               // echo "\n IDModulo=" . $IDModulo;
               
                $l_IDModulo=$IDModulo;

                $l_Creacion="";
                $l_Editar="";
                $l_Borrar="";
                $l_Cancelar="";
                $l_Consultar="";
                $l_Listar="";
                $l_Ejecutar="";
                $l_Imprimir="";
                $l_Etiquetas="";
                $l_Carga="";
                $l_Excel="";
                $l_Pdf="";

                $l_bandCreacion=0;
                $l_bandEditar=0;
                $l_bandBorrar=0;
                $l_bandCancelar=0;
                $l_bandConsultar=0;
                $l_bandListar=0;
                $l_bandEjecutar=0;                
                $l_bandImprimir=0;
                $l_bandEtiquetas=0;
                $l_bandCarga=0;
                $l_bandExcel=0;
                $l_bandPdf=0;

                for($k=0;$k<$l_NumeroDeRegistros;$k++){ 
                    foreach($arreglos[$k] as $key => $value){ 

                        $Valor=$arreglos[$k]->{$key};
                        $pos=strpos($key,"_");
                        $Funcion=substr($key,0,$pos);
                        $pos=$pos+1;
                        $IDModulo=substr($key,$pos,strlen($key));

                         //echo "\n Llave:" . $key . "=" . $arreglos[$i]->{$key};
                         //echo "\n Funcion:" . $Funcion;

                        if($l_IDModulo==$IDModulo){
                            switch($Funcion){
                                case "creacion":
                                    if($l_bandCreacion==0){
                                        $l_bandCreacion=1;
                                        $l_Creacion=$Valor;
                                    }
                                    break;

                                case "editar":
                                    if($l_bandEditar==0){
                                        $l_bandEditar=1;
                                        $l_Editar=$Valor;
                                    }
                                    break;

                                case "borrar":
                                    if($l_bandBorrar==0){
                                        $l_bandBorrar=1;
                                        $l_Borrar=$Valor;
                                    }

                                    break;
                                case "cancelar":
                                    if($l_bandCancelar==0){
                                        $l_bandCancelar=1;
                                        $l_Cancelar=$Valor;
                                    }

                                    break;


                                case "consultar":
                                    if($l_bandConsultar==0){
                                        $l_bandConsultar=1;
                                        $l_Consultar=$Valor;
                                    }

                                    break;

                                case "listar":
                                    if($l_bandListar==0){
                                        $l_bandListar=1;
                                        $l_Listar=$Valor;
                                    }

                                    break;

                                case "ejecutar":
                                    if($l_bandEjecutar==0){
                                        $l_bandEjecutar=1;
                                        $l_Ejecutar=$Valor;
                                    }

                                    break;

                                case "imprimir":
                                    if($l_bandImprimir==0){
                                        $l_bandImprimir=1;
                                        $l_Imprimir=$Valor;
                                    }

                                    break;

                                case "etiquetas":
                                    if($l_bandEtiquetas==0){
                                        $l_bandEtiquetas=1;
                                        $l_Etiquetas=$Valor;
                                    }

                                    break;

                                case "carga":
                                        if($l_bandCarga==0){
                                            $l_bandCarga=1;
                                            $l_Carga=$Valor;
                                        }
    
                                        break;
                                case "excel":
                                        if($l_bandExcel==0){
                                            $l_bandExcel=1;
                                            $l_Excel=$Valor;
                                        }
    
                                        break;

                                case "pdf":
                                        if($l_bandPdf==0){
                                            $l_bandPdf=1;
                                            $l_Pdf=$Valor;
                                        }
    
                                        break;

                            }

                        }

                    }                    
                }
             

                $datos=array();                 
                
                $datos=$datos + ["nIDAmbiente_Clasificacion"=>$l_nIDAmbiente_Clasificacion];
                $datos=$datos + ["nIDModulo"=>$l_IDModulo];
                $datos=$datos + ["Creacion"=>$l_Creacion];
                $datos=$datos + ["Editar"=>$l_Editar];
                $datos=$datos + ["Borrar"=>$l_Borrar];
                $datos=$datos + ["Cancelar"=>$l_Cancelar];
                $datos=$datos + ["Consultar"=>$l_Consultar];
                $datos=$datos + ["Listar"=>$l_Listar];
                $datos=$datos + ["Ejecutar"=>$l_Ejecutar];
                $datos=$datos + ["Imprimir"=>$l_Imprimir];
                $datos=$datos + ["Etiquetas"=>$l_Etiquetas];
                $datos=$datos + ["CargaMasiva"=>$l_Carga];
                $datos=$datos + ["ExportarExcel"=>$l_Excel];
                $datos=$datos + ["ExportarPDF"=>$l_Pdf];


                array_push($datos_leidos,$datos);  

                //print_r($datos_leidos);
                //exit(1);

            
                // Grabación
                $l_nIDAmbiente_Clasificacion_Deta=0;
                $tbl->Inicializacion();
                $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $l_Condicion="nIDModulo=" .  $l_IDModulo . " and nIDAmbiente_Clasificacion=" . $l_nIDAmbiente_Clasificacion . " and bEstado=0";

                //echo "\n Condicion:" . $l_Condicion;
                $tbl->Leer($l_Condicion);
                if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
                    // Si existe

                    $registros=$tbl->dtBase();
                    $l_nIDAmbiente_Clasificacion_Deta=$registros[0]["nIDAmbiente_Clasificacion_Deta"];

                    //echo "Nidambientte_deta:" .$l_nIDAmbiente_Clasificacion_Deta; 

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


                    $registro_datos=array($l_nIDAmbiente_Clasificacion_Deta);
                    array_push($registro_datos,$l_nIDAmbiente_Clasificacion);  
                    array_push($registro_datos,$l_IDModulo);  // Modulo
                    array_push($registro_datos,$l_Creacion);  
                    array_push($registro_datos,$l_Editar);  
                    array_push($registro_datos,$l_Borrar);  
                    array_push($registro_datos,$l_Cancelar);  
                    array_push($registro_datos,$l_Consultar);  
                    array_push($registro_datos,$l_Listar);  
                    array_push($registro_datos,$l_Ejecutar);  
                    array_push($registro_datos,$l_Imprimir);  
                    array_push($registro_datos,$l_Etiquetas);  
                    array_push($registro_datos,$l_Carga);  
                    array_push($registro_datos,$l_Excel);  
                    array_push($registro_datos,$l_Pdf);  
                    array_push($registro_datos,$l_Pdf);  

                    array_push($registro_datos,$l_FechaLocal);  
                    array_push($registro_datos,$l_FechaLocal);  
                    array_push($registro_datos,$l_Observaciones);  
                    array_push($registro_datos,$l_bEstado);  
                    
                    array_push($registro_datos,0); // Crear 
                    array_push($registro_datos,1); // Cambiar
                    array_push($registro_datos,0); // Eliminar
                    
                    $tbl->Inicializacion();
                    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                    $tbl->setInformacion_Grabar($registro_datos);
                 
                    if($tbl->Ejecutar()){
                        $registros_grabados=$registros_grabados+1;                 
                    }
                  
                    unset($registro_datos);  


                    $l_Creacion="";
                    $l_Editar="";
                    $l_Borrar="";
                    $l_Cancelar="";
                    $l_Consultar="";
                    $l_Listar="";
                    $l_Ejecutar="";
                    $l_Imprimir="";
                    $l_Etiquetas="";
                    $l_Carga="";
                    $l_Excel="";
                    $l_Pdf="";
 
                } else {
                    // No existe

                    //echo "No existe";

                    //echo "Modulo:" . $l_IDModulo; 
                    $NombrePC = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                    $Fecha = date('Y-m-d');
                    $Hora = date('H:i:s');
                    $l_FechaModificacion=$Fecha." ".$Hora;
                    $l_FechaCreacion=$Fecha." ".$Hora;
                    $l_Observaciones="Nueva captura - Creado por  - ".$NombrePC." - ".get_current_user()." - ".$l_FechaModificacion;
                    $l_bEstado=0;

                    $registro_datos=array(0);
                    array_push($registro_datos,$l_nIDAmbiente_Clasificacion);  
                    array_push($registro_datos,$l_IDModulo);  // Modulo
                    array_push($registro_datos,$l_Creacion);  
                    array_push($registro_datos,$l_Editar);  
                    array_push($registro_datos,$l_Borrar);  
                    array_push($registro_datos,$l_Cancelar);  
                    array_push($registro_datos,$l_Consultar);  
                    array_push($registro_datos,$l_Listar);  
                    array_push($registro_datos,$l_Ejecutar);  
                    array_push($registro_datos,$l_Imprimir);  
                    array_push($registro_datos,$l_Etiquetas);  
                    array_push($registro_datos,$l_Carga);  
                    array_push($registro_datos,$l_Excel);  
                    array_push($registro_datos,$l_Pdf);  
                    array_push($registro_datos,$l_Pdf);  

                    array_push($registro_datos,"");  
                    array_push($registro_datos,"");  
                    array_push($registro_datos,$l_Observaciones);  
                    array_push($registro_datos,$l_bEstado);  
                    
                    array_push($registro_datos,1); // Crear 
                    array_push($registro_datos,0); // Cambiar
                    array_push($registro_datos,0); // Eliminar


                    //print_r($registro_datos);
                    
                    $tbl->Inicializacion();
                    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                    $tbl->setInformacion_Grabar($registro_datos);
                 
                    if($tbl->Ejecutar()){
                        $registros_grabados=$registros_grabados+1;                 
                    }
                  
                    unset($registro_datos);  
                }

           
            }
            
        }    
          
    }
     
}

 
// Valida si se efectuo correctamente la grabación 
//echo "Registros grabados:" . $registros_grabados . "- Procesados:" . count($datos_leidos);
if($registros_grabados==count($datos_leidos)){   
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
  