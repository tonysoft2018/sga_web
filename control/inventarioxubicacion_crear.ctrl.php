<?php
// ----------------------------------------------------------------------------------
// inventarioxubicacion_crear.ctrl.php
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
include_once "../clases/inventarioxubicacion.mysql.class_v2.0.0.php"; 
include_once "../clases/inventarioxubicacion_deta.mysql.class_v2.0.0.php";
include_once "../clases/ubicaciones.mysql.class_v2.0.0.php"; 
include_once "../clases/entradas.mysql.class_v2.0.0.php"; 
include_once "../clases/salidas.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";
include_once "../utilerias/utilerias.php";

$retorno= array();
$arreglos = array();
$datos_grabar = array();

$productos = array();

$registros_grabados=0;

$FOLIO=0;
 
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
$tbl_Deta = new  cltbl_InventarioXUbicacion_Deta_v2_0_0();

$tbl_Ubicaciones = new cltbl_Ubicaciones_v2_0_0();

$tbl = new  cltbl_InventarioXUbicacion_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
 
for($i=0;$i<$l_NumeroDeRegistros;$i++){          
    $l_Folio=0;          
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("LEER");
    $Campo_Llave=$tbl->get_CampoLlave();  

    $l_Folio=$tbl->getSiguienteFolio();

    $l_nIDCat_Almacen=$arreglos[$i]->{"nidcat_almacen"};
    $l_nIDCat_Rack=$arreglos[$i]->{"nidcat_rack"};
    $l_nIDUsuario=$arreglos[$i]->{"nidusuario"};
    $l_Estatus="ABIERTO";

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

    // Crea el encabezado del inventario x articulo
    if($l_nIDCat_Almacen<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ALMACEN"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }

     // Crea el encabezado del inventario x articulo
     if($l_nIDCat_Rack<=0){
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE RACK"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    }

    $l_Condicion="nIDCat_Almacen=" . $l_nIDCat_Almacen . " and nIDCat_Rack=" . $l_nIDCat_Rack . " and bEstado=0";
    $tbl_Ubicaciones->Inicializacion();
    $tbl_Ubicaciones->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Ubicaciones->Leer($l_Condicion);

    if($tbl_Ubicaciones->CualEsElNumeroDeRegistrosCargados()>0){   

        // Crear el encabezado
        $datos_grabar = array();
                    
        array_push($datos_grabar,0);
        array_push($datos_grabar,$l_Folio);
        array_push($datos_grabar,$l_FechaLocal);
        array_push($datos_grabar,$l_nIDCat_Almacen); 
        array_push($datos_grabar,$l_nIDCat_Rack); 
        array_push($datos_grabar,$l_nIDUsuario);
        array_push($datos_grabar,$l_Estatus);

        array_push($datos_grabar,$l_FechaLocal);
        array_push($datos_grabar,$l_FechaLocal);
        array_push($datos_grabar,$l_Observaciones);
        array_push($datos_grabar,0);
 
        $registro_datos=array($datos_grabar[0]);
        for($j=1;$j<count($datos_grabar);$j++){
            array_push($registro_datos,$datos_grabar[$j]);
        }
        array_push($registro_datos,1); // Crear 
        array_push($registro_datos,0); // Cambiar
        array_push($registro_datos,0); // Eliminar
 
        $tbl->Inicializacion();
        $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl->CargarCampos("GRABAR");
        $tbl->setInformacion_Grabar($registro_datos);

        if($tbl->Ejecutar()){
            unset($registro_datos);
            unset($datos_grabar);

             // Busca el Id del encabezado
             $l_nIDIxA=0;
             $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
             $tbl->CargarCampos("LEER");
             $Campo_Llave=$tbl->get_CampoLlave();  
             $l_Condicion="Folio=" . $l_Folio . " and bEstado=0";
             $tbl->Leer($l_Condicion); 
             if($tbl->CualEsElNumeroDeRegistrosCargados()>0){         

                $registros=$tbl->dtBase();
             
                $l_nIDIxU=$registros[0]["nIDIxU"];
    
                if($l_nIDIxU>0){        

                    $registros_ubicaciones=$tbl_Ubicaciones->dtBase();

                    for($j=0;$j<$tbl_Ubicaciones->CualEsElNumeroDeRegistrosCargados();$j=$j+1){
                        $l_nIDProducto=$registros_ubicaciones[$j]["nIDProducto"];
                        $l_nIDUbicacion=$registros_ubicaciones[$j]["nIDUbicacion"];
                        $l_Existencias=$registros_ubicaciones[$j]["Cantidad"];
                        $l_bandEncontrado=0;
                       
                        for($k=0;$k<count($productos);$k=$k+1){

                            if($productos[$k]==$l_nIDProducto){
                                $l_bandEncontrado=1;
                                break;
                            }
                        }

                        if($l_bandEncontrado==0){
                            array_push($productos,$l_nIDProducto);

                            //$l_Existencias=1;
                                              
                            // Graba el detalle
                            $datos_grabar = array();
                    
                            array_push($datos_grabar,0);
                            array_push($datos_grabar,$l_nIDIxU);
                            array_push($datos_grabar,$l_nIDProducto);
                            array_push($datos_grabar,0); 
                            array_push($datos_grabar,$l_nIDUbicacion);
                            array_push($datos_grabar,$l_Existencias);
                            array_push($datos_grabar,0);
                            array_push($datos_grabar,0);
                         
                            array_push($datos_grabar,$l_FechaLocal);
                            array_push($datos_grabar,$l_FechaLocal);
                            array_push($datos_grabar,$l_Observaciones);
                            array_push($datos_grabar,0);
                           
                            $registro_datos=array($datos_grabar[0]);
                            for($L=1;$L<count($datos_grabar);$L++){
                                array_push($registro_datos,$datos_grabar[$L]);
                            }
                            array_push($registro_datos,1); // Crear 
                            array_push($registro_datos,0); // Cambiar
                            array_push($registro_datos,0); // Eliminar

                     
                            $tbl_Deta->Inicializacion();
                            $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                            $tbl_Deta->CargarCampos("GRABAR");
                            $tbl_Deta->setInformacion_Grabar($registro_datos);
                                       
                            if($tbl_Deta->Ejecutar()){

                            }

                            unset($registro_datos);
                            unset($datos_grabar);
                    
                        }
                    }

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
                    $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE PROCESAR EL INVENTARIO"];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno;    
                    exit(1);
                }

             } else {
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE PROCESAR EL INVENTARIO"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
             }
    
        } else {

            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"FALLA AL MOMENTO DE PROCESAR EL INVENTARIO"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
            exit(1);


        }
        
    } else {

        // No tiene datos ese rack
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE UBICACIONES REGISTRADAS EL RACK EN EL ALMACEN SELECCIONADO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);

    }
 
} 
 
  
?> 
  