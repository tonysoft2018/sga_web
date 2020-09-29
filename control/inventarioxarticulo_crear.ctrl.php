<?php
// ----------------------------------------------------------------------------------
// entradasporotrosconceptos_crear.ctrl.php
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
include_once "../clases/inventarioxarticulo.mysql.class_v2.0.0.php"; 
include_once "../clases/inventarioxarticulo_deta.mysql.class_v2.0.0.php"; 
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
$tbl_Deta = new  cltbl_InventarioXArticulo_Deta_v2_0_0();

$tbl = new  cltbl_InventarioXArticulo_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
 
for($i=0;$i<$l_NumeroDeRegistros;$i++){          
    $l_Folio=0;          
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->CargarCampos("LEER");
    $Campo_Llave=$tbl->get_CampoLlave();  

    $l_Folio=$tbl->getSiguienteFolio();

    $l_nIDCat_Almacen=$arreglos[$i]->{"nidcat_almacen"};
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

    // Crear el encabezado
    $datos_grabar = array();
                    
    array_push($datos_grabar,0);
    array_push($datos_grabar,$l_Folio);
    array_push($datos_grabar,$l_FechaLocal);
    array_push($datos_grabar,$l_nIDCat_Almacen); 
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

    //print_r($registro_datos);

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
             
            $l_nIDIxA=$registros[0]["nIDIxA"];

            if($l_nIDIxA>0){

                $l_Condicion="nIDCat_Almacen=" . $l_nIDCat_Almacen . " and bEstado=0";
                $tbl_Entradas = new  cltbl_Entradas_v2_0_0();
                $tbl_Salidas = new  cltbl_Salidas_v2_0_0();
                $tbl_Entradas->Inicializacion();
                $tbl_Entradas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Entradas->Leer($l_Condicion);
                if($tbl_Entradas->CualEsElNumeroDeRegistrosCargados()>0){     
                    $registros_ent=$tbl_Entradas->dtBase();

                    for($j=0;$j<$tbl_Entradas->CualEsElNumeroDeRegistrosCargados();$j=$j+1){

                        $l_nIDProducto=$registros_ent[$j]["nIDProducto"];
                        $l_Entradas=0;

                        $l_bandEncontrado=0;
                        //echo "producto:" . $l_nIDProducto;
                      
                        for($k=0;$k<count($productos);$k=$k+1){

                            if($productos[$k]==$l_nIDProducto){
                                $l_bandEncontrado=1;
                                break;
                            }
                        }
                   

                        if($l_bandEncontrado==0){
                            array_push($productos,$l_nIDProducto);
                            $l_Condicion="nIDCat_Almacen=" . $l_nIDCat_Almacen . " and bEstado=0 and nIDProducto=" . $l_nIDProducto;
                            $tbl_Entradas->Existencias($l_Condicion);
                            $l_Entradas=$tbl_Entradas->dtexistencias[0]["Cantidad"];
 
                            // Busca las salidas 
                            $tbl_Salidas->Inicializacion();
                            $tbl_Salidas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                            $tbl_Salidas->Existencias($l_Condicion);
                            $l_Salidas=$tbl_Salidas->dtexistencias[0]["Cantidad"];
 
                            $l_Existencias=$l_Entradas-$l_Salidas;

                            if($l_Existencias<0){
                                $l_Existencias=0;
                            }

                            //echo "Lectura:" . $l_nIDProducto . ":E=" . $l_Entradas . ":S=" . $l_Salidas;
                                             
                            // Graba el detalle
                            $datos_grabar = array();
                    
                            array_push($datos_grabar,0);
                            array_push($datos_grabar,$l_nIDIxA);
                            array_push($datos_grabar,$l_nIDProducto);
                            array_push($datos_grabar,0); 
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

                    // Elimina el inventario x artciulo
                    $tbl->Inicializacion();
                    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                    $tbl->EliminarConCondicion("nIDIxA=" . $l_nIDIxA);

                    $datos=array();
                    $datos=$datos + ["retorno"=>"FALSE"];
                    $datos=$datos + ["msg"=>"ALMACEN SIN PRODUCTOS PARA INVENTARIAR"];
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
} 
 
/*
if($registros_grabados==$l_NumeroDeRegistros){   
    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>"PROCESO FINALIZADO CON EXITO"];
    $datos=$datos + ["FOLIO"=>$FOLIO];
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
 */
 
?> 
  