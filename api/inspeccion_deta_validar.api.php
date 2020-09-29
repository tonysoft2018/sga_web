<?php
// ----------------------------------------------------------------------------------
// packinglist_consultar.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { 
//                    sesion:[sesion], 
//                    nidusuario:[nidusuario], 
//                    folio:[folio] 
//                    codigo:[codigo] 
//                  
//                }
//              - Devuelve el resultado en JSON.  
//                {
//                    retorno=>TRUE/FALSE, msg=>"MENSAJE",[REGISTROS] 
//                } 
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 21/03/2020
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
include_once "../clases/packinglist.mysql.class_v2.0.0.php";    
include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php";
include_once "../clases/productos_series.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";

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

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true); 
// ----------------------------------------------

$retorno= array();
$arreglos = array();
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));


$l_Sesion=trim($arreglos->{"sesion"});
$l_nIDUsuario=trim($arreglos->{"nidusuario"});
$l_Folio=trim($arreglos->{"folio"});
$l_Codigo=trim($arreglos->{"codigo"});
 
/*
$l_Sesion="";
$l_nIDUsuario=0;
$l_Folio="";
$l_Codigo="";
*/
if(strlen($l_Sesion)<=0){
    if(!empty($_GET)){ 
        if (isset($_GET['sesion'])){
            $l_Sesion=$_GET['sesion']; 
        }    
    }
}

if(strlen($l_nIDUsuario)<=0){
    if(!empty($_GET)){ 
        if (isset($_GET['nidusuario'])){
            $l_nIDUsuario=$_GET['nidusuario']; 
        }    
    }
}

if(strlen($l_Folio)<=0){
    if(!empty($_GET)){ 
        if (isset($_GET['folio'])){
            $l_Folio=$_GET['folio']; 
        }    
    }
}

if(strlen($l_Codigo)<=0){
    if(!empty($_GET)){ 
        if (isset($_GET['codigo'])){
            $l_Codigo=$_GET['codigo']; 
        }    
    }
}

if(strlen($l_Folio)<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE FOLIO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}

if(strlen($l_Codigo)<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE CODIGO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}


if(is_numeric($l_Folio)){

    $l_Condicion="Folio=" . $l_Folio . " and bEstado=0";
    $l_nIDEnca=0;
    $l_Estatus="RECIBO";
    $tbl_Enca = new   cltbl_Packinglist_v2_0_0();
    $tbl_Deta = new   cltbl_Packinglist_Deta_v2_0_0();
    $tbl_Cat_Productos_Serie = new  cltbl_Cat_Productos_Series_v2_0_0();

    $tbl_Enca->Inicializacion();
    $tbl_Enca->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Enca->CargarCampos("LEER");
    $Campo_Llave=$tbl_Enca->get_CampoLlave();
    $tbl_Enca->Leer($l_Condicion);

    //echo "Condicion:" .$l_Condicion;

    if($tbl_Enca->CualEsElNumeroDeRegistrosCargados()>0){
        $registros=$tbl_Enca->dtBase();

        $l_nIDEnca=$registros[0]["nIDPackingList"];

        if($l_nIDEnca>0){
 
            $pos=strpos($l_Codigo,",");
    
            if($pos>0){         
                $l_Codigo=substr($l_Codigo,0,$pos);
            }

            $l_Serie_Codigo=$l_Codigo;

 
            if(strlen($l_Serie_Codigo)<=0){ 
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"CODIGO DE BARRAS INVALIDO"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }

            $l_nIDPackingList_Codigo=$l_nIDEnca;

            // 106/12982/Z7161-1
            // Valida el serial
            //echo $l_nIDPackingList_Codigo . " " . $l_nIDProducto_Codigo . " " . $l_Serie_Codigo;
            $tbl_Cat_Productos_Serie->Inicializacion();
            $tbl_Cat_Productos_Serie->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Cat_Productos_Serie->Leer("nIDPackingList=" . $l_nIDPackingList_Codigo . " and Serie='" . $l_Serie_Codigo . "'");
            if($tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados()>0){
                $registros=$tbl_Cat_Productos_Serie->dtBase();

                $l_nIDProducto_Serie=$registros[0]["nIDProducto_Serie"];
                $l_nIDProducto_Codigo=$registros[0]["nIDProducto"];
                $l_sLeido=$registros[0]["Leido"];

                if($l_nIDProducto_Serie>0){

                    if($l_sLeido=="SI"){
                        $datos=array();
                        $datos=$datos + ["retorno"=>"FALSE"];
                        $datos=$datos + ["msg"=>"CODIGO DE BARRAS LEIDO"];
                        array_push($retorno,$datos);    
                        $retorno=json_encode($retorno);	 
                        echo $retorno;    
                        exit(1);
                    }

                    // Extrae el total a escanear 
                    $tbl_Cat_Productos_Serie->Inicializacion();
                    $tbl_Cat_Productos_Serie->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                    $tbl_Cat_Productos_Serie->Leer("nIDPackingList=" . $l_nIDEnca . " and nIDProducto=" . $l_nIDProducto_Codigo);
                    $l_Escanear=$tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados();


                    // Busca el id del detalle del packing list 
                    $l_Condicion="nIDPackingList=" .$l_nIDPackingList_Codigo ." and bEstado=0 and nIDProducto=" . $l_nIDProducto_Codigo;
                    $tbl_Deta = new  cltbl_Packinglist_Deta_v2_0_0();
                    $tbl_Deta->Inicializacion();
                    $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                    $tbl_Deta->Leer($l_Condicion);
                    if($tbl_Deta->CualEsElNumeroDeRegistrosCargados()>0){
                 
                        $registros_deta=$tbl_Deta->dtBase();
                        $l_nIDPackingList_Deta=$registros_deta[0]["nIDPackingList_Deta"];
                        $l_Leido_Barras=$registros_deta[0]["Leidos_Barras"];

                        if($l_nIDPackingList_Deta>0){
                            $l_Leido_Barras=$l_Leido_Barras + 1;

                            if($l_Leido_Barras==$l_Escanear){

                                // Cambiar el estatus del registro 
                                $l_Estatus="INSPECCIONADO";                                
                                if($tbl_Deta->CambiarEstatus($l_nIDPackingList_Deta,$l_Estatus, $l_Observaciones)){

                                    // Aumenta en uno los leidos en el detalle
                                    $tbl_Deta->CambiarLeidos_Barras($l_nIDPackingList_Deta,$l_Leido_Barras, $l_Observaciones);

                                    // Cambia el estatus del de codigo a leido 
                                    $tbl_Cat_Productos_Serie->CambiarLeido($l_nIDProducto_Serie,"SI",$l_Observaciones);

                                    $datos=array();
                                    $datos=$datos + ["retorno"=>"TRUE"];
                                    $datos=$datos + ["msg"=>"INSPECCIONADO"];
                                    $datos=$datos + ["nidpackinglist_deta"=>$l_nIDPackingList_Deta];
                                    $datos=$datos + ["nidproducto_serie"=>$l_nIDProducto_Serie];
                                    $datos=$datos + ["nidproducto"=>$l_nIDProducto_Codigo];
                                    $datos=$datos + ["serie"=>$l_Serie_Codigo];
                                    array_push($retorno,$datos);    
                                    $retorno=json_encode($retorno);	 
                                    echo $retorno;    
                                    exit(1);

                                } else {
                                    $datos=array();
                                    $datos=$datos + ["retorno"=>"FALSE"];
                                    $datos=$datos + ["msg"=>"CODIGO NO IDENTIFICADO"];
                                    array_push($retorno,$datos);    
                                    $retorno=json_encode($retorno);	 
                                    echo $retorno;    
                                    exit(1);
                                }

                               

                            } else {

                                // Aumenta en uno los leidos en el detalle
                                $tbl_Deta->CambiarLeidos_Barras($l_nIDPackingList_Deta,$l_Leido_Barras, $l_Observaciones);

                                // Cambia el estatus del de codigo a leido 
                                $tbl_Cat_Productos_Serie->CambiarLeido($l_nIDProducto_Serie,"SI",$l_Observaciones);

                                $datos=array();
                                $datos=$datos + ["retorno"=>"TRUE"];
                                $datos=$datos + ["msg"=>"AUMENTO:" . $l_Leido_Barras];
                                $datos=$datos + ["nidpackinglist_deta"=>$l_nIDPackingList_Deta];
                                $datos=$datos + ["nidproducto_serie"=>$l_nIDProducto_Serie];
                                $datos=$datos + ["nidproducto"=>$l_nIDProducto_Codigo];
                                $datos=$datos + ["serie"=>$l_Serie_Codigo];
                                array_push($retorno,$datos);    
                                $retorno=json_encode($retorno);	 
                                echo $retorno;    
                                exit(1);

                            }


                            
                            

                           


                            /*
                            // Actualiza el estatus
                            $l_Estatus="INSPECCIONADO";
                            if($tbl_Deta->CambiarEstatus($l_nIDPackingList_Deta,$l_Estatus, $l_Observaciones)){
                                $datos=array();
                                $datos=$datos + ["retorno"=>"TRUE"];
                                $datos=$datos + ["msg"=>"PROCESO FINALIZADO CON EXITO"];
                                $datos=$datos + ["nidpackinglist_deta"=>$l_nIDPackingList_Deta];
                                $datos=$datos + ["nidproducto_serie"=>$l_nIDProducto_Serie];
                                $datos=$datos + ["nidproducto"=>$l_nIDProducto_Codigo];
                                $datos=$datos + ["serie"=>$l_Serie_Codigo];
                                array_push($retorno,$datos);    
                                $retorno=json_encode($retorno);	 
                                echo $retorno;    
                                exit(1);
                            } else {
                                $datos=array();
                                $datos=$datos + ["retorno"=>"FALSE"];
                                $datos=$datos + ["msg"=>"CODIGO NO IDENTIFICADO"];
                                array_push($retorno,$datos);    
                                $retorno=json_encode($retorno);	 
                                echo $retorno;    
                                exit(1);
                            }

                            */

                        } else {

                            $datos=array();
                            $datos=$datos + ["retorno"=>"FALSE"];
                            $datos=$datos + ["msg"=>"CODIGO NO EXISTE EN EL PACKING LIST"];
                            array_push($retorno,$datos);    
                            $retorno=json_encode($retorno);	 
                            echo $retorno;    
                            exit(1);

                        }
                    } else {
                        $datos=array();
                        $datos=$datos + ["retorno"=>"FALSE"];
                        $datos=$datos + ["msg"=>"CODIGO NO EXISTE EN EL PACKING LIST"];
                        array_push($retorno,$datos);    
                        $retorno=json_encode($retorno);	 
                        echo $retorno;    
                        exit(1);
                    }
                } else {
                    $datos=array();
                    $datos=$datos + ["retorno"=>"FALSE"];
                    $datos=$datos + ["msg"=>"CODIGO DE BARRAS INEXISTENTE"];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno;    
                    exit(1);
                }
            } else {
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"CODIGO DE BARRAS INEXISTENTE"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }

        } else {

            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"FOLIO INCORRECTO"];     
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    

        }
        
    } else {

        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"FOLIO NO ENCONTRADO"];     
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    

    }

} else {

    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"FOLIO INVALIDO"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    

}
 

 
 

?> 
  