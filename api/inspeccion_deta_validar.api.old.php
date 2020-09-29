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

    if($tbl_Enca->CualEsElNumeroDeRegistrosCargados()>0){
        $registros=$tbl_Enca->dtBase();

        $l_nIDEnca=$registros[0]["nIDPackingList"];

        if($l_nIDEnca>0){

            $pos=strpos($l_Codigo,"/");
            $l_nIDPackingList_Codigo=substr($l_Codigo,0,$pos);
            $l_Resto=substr($l_Codigo,$pos+1,strlen($l_Codigo));
            $pos=strpos($l_Resto,"/");
            $l_nIDProducto_Codigo=substr($l_Resto,0,$pos);
            $l_Serie_Codigo=substr($l_Resto,$pos+1,strlen($l_Resto));

            $l_nIDPackingList_Codigo=trim($l_nIDPackingList_Codigo);
            $l_nIDProducto_Codigo=trim($l_nIDProducto_Codigo);
            $l_Serie_Codigo=trim($l_Serie_Codigo);


            // Validación
            if(strlen($l_nIDPackingList_Codigo)>0){ 
                if(!is_numeric($l_nIDPackingList_Codigo)) {
                    $datos=array();
                    $datos=$datos + ["retorno"=>"FALSE"];
                    $datos=$datos + ["msg"=>"CODIGO DE BARRAS INVALIDO"];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno;    
                    exit(1); 
                }   
            } 

            if(strlen($l_nIDProducto_Codigo)>0){ 
                if(!is_numeric($l_nIDProducto_Codigo)) {
                    $datos=array();
                    $datos=$datos + ["retorno"=>"FALSE"];
                    $datos=$datos + ["msg"=>"CODIGO DE BARRAS INVALIDO"];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno;    
                    exit(1);    
                }   
            }    
        
            if(strlen($l_Serie_Codigo)<=0){ 
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"CODIGO DE BARRAS INVALIDO"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }

            // 106/12982/Z7161-1
            // Valida el serial
            //echo $l_nIDPackingList_Codigo . " " . $l_nIDProducto_Codigo . " " . $l_Serie_Codigo;
            $tbl_Cat_Productos_Serie->Inicializacion();
            $tbl_Cat_Productos_Serie->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Cat_Productos_Serie->Leer("nIDPackingList=" . $l_nIDPackingList_Codigo . " and nIDProducto=" . $l_nIDProducto_Codigo . " and Serie='" . $l_Serie_Codigo . "'");
            if($tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados()>0){
                $registros=$tbl_Cat_Productos_Serie->dtBase();
                $l_nIDProducto_Serie=$registros[0]["nIDProducto_Serie"];

                if($l_nIDProducto_Serie>0){

                    // Busca el id del detalle del packing list 
                    $l_Condicion="nIDPackingList=" .$l_nIDPackingList_Codigo ." and bEstado=0 and nIDProducto=" . $l_nIDProducto_Codigo;
                    $tbl_Deta = new  cltbl_Packinglist_Deta_v2_0_0();
                    $tbl_Deta->Inicializacion();
                    $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                    $tbl_Deta->Leer($l_Condicion);
                    if($tbl_Deta->CualEsElNumeroDeRegistrosCargados()>0){
                 
                        $registros_deta=$tbl_Deta->dtBase();
                        $l_nIDPackingList_Deta=$registros_deta[0]["nIDPackingList_Deta"];

                        if($l_nIDPackingList_Deta>0){

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
 









if(strlen($l_Condicion)<=0){
    $l_Condicion="bEstado=0 and Estatus='PROCESO'";
} else {
    $l_Condicion=$l_Condicion . " and Estatus='PROCESO'";
}
// ----------------------------------------------

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true); 
// ----------------------------------------------
 
// ----------------------------------------------   
// Leer la info para procesar
$tbl = new   cltbl_Packinglist_v2_0_0();
$tbl_Deta = new   cltbl_Packinglist_Deta_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$Campo_Llave=$tbl->get_CampoLlave();
$l_nIDEnca=0;

if(strlen($l_Condicion)>0){
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
     
    $tbl->Leer($l_Condicion);

    if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
            
        $registros=$tbl->dtBase();

        for($j=0;$j<$tbl->CualEsElNumeroDeRegistrosCargados();$j=$j+1){

            $l_nIDEnca=$registros[$j]["nIDPackingList"];

            if($l_nIDEnca>0){
                $l_Condicion_Deta="nIDPackingList=" . $l_nIDEnca . " and (Estatus='ETIQUETA' or Estatus='RECIBO')";
                $tbl_Deta->Inicializacion();
                $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Deta->Leer($l_Condicion_Deta);

                $l_Total1=$tbl_Deta->CualEsElNumeroDeRegistrosCargados();

                $l_Condicion_Deta="nIDPackingList=" . $l_nIDEnca;
                $tbl_Deta->Inicializacion();
                $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Deta->Leer($l_Condicion_Deta);

                $l_Total2=$tbl_Deta->CualEsElNumeroDeRegistrosCargados();

                if($l_Total1==$l_Total2){
                    $datos=array();
      
                    $datos=$datos + ["retorno"=>"TRUE"];
                    $datos=$datos + ["msg"=>""];
                    $datos=$datos + ["llave"=>$Campo_Llave]; 
    
                    // Extrae la info de los campos
                    for($k=0;$k<$tbl->get_NumCampos();$k=$k+1){
                        $campo=$tbl->get_Estructura($k);
                        $valor=$registros[$j][$tbl->get_Estructura($k)];
                        $datos=$datos + [$campo=>$valor];                          
                    }
                    
                    array_push($retorno,$datos);   
                }

            }                
        }
        $retorno=json_encode($retorno);	 
        echo $retorno;    
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE REGISTROS"];

        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
    }
} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE REGISTROS1"];
 
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
}



/*
include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/packinglist.mysql.class_v2.0.0.php";    
include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php";
include_once "../clases/productos_series.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";

$retorno= array();
$arreglos = array();

$registros_grabados=0;
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));
 
$l_NumeroDeRegistros=count($arreglos);

if($l_NumeroDeRegistros<=0){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE INFORMACION PARA PROCESAR"];
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
$tbl_Enca = new   cltbl_Packinglist_v2_0_0(); 
$tbl_Cat_Productos_Serie = new  cltbl_Cat_Productos_Series_v2_0_0();

// La serie esta compuesta por nIDPackingList/nIDProducto/Serie

for($i=0;$i<$l_NumeroDeRegistros;$i++){
    $l_nIDPackingList=trim($arreglos[$i]->{"nid"});     
    $l_Codigo=trim($arreglos[$i]->{"codigo"});

    $pos=strpos($l_Codigo,"/");

    $l_nIDPackingList_Codigo=substr($l_Codigo,0,$pos);
    $l_Resto=substr($l_Codigo,$pos+1,strlen($l_Codigo));
    $pos=strpos($l_Resto,"/");
    $l_nIDProducto_Codigo=substr($l_Resto,0,$pos);
    $l_Serie_Codigo=substr($l_Resto,$pos+1,strlen($l_Resto));

    //echo "NID:" . $l_nIDPackingList_Codigo . "," . $l_nIDProducto_Codigo . "," .  $l_Serie_Codigo;

    $l_nIDPackingList_Codigo=trim($l_nIDPackingList_Codigo);
    $l_nIDProducto_Codigo=trim($l_nIDProducto_Codigo);
    $l_Serie_Codigo=trim($l_Serie_Codigo);

    // Validación
    if(strlen($l_nIDPackingList_Codigo)>0){ 
        if(!is_numeric($l_nIDPackingList_Codigo)) {
            if($l_nID<=0){
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"CODIGO DE BARRAS INVALIDO"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }            
        }   
    }    

    if(strlen($l_nIDProducto_Codigo)>0){ 
        if(!is_numeric($l_nIDProducto_Codigo)) {
            if($l_nID<=0){
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"CODIGO DE BARRAS INVALIDO"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);
            }            
        }   
    }    

    if(strlen($l_Serie_Codigo)<=0){ 
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"CODIGO DE BARRAS INVALIDO"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }

    // 106/12982/Z7161-1
    // Valida el serial
    //echo $l_nIDPackingList_Codigo . " " . $l_nIDProducto_Codigo . " " . $l_Serie_Codigo;
    $tbl_Cat_Productos_Serie->Inicializacion();
    $tbl_Cat_Productos_Serie->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Cat_Productos_Serie->Leer("nIDPackingList=" . $l_nIDPackingList_Codigo . " and nIDProducto=" . $l_nIDProducto_Codigo . " and Serie='" . $l_Serie_Codigo . "'");
    if($tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados()>0){
        $registros=$tbl_Cat_Productos_Serie->dtBase();
        $l_nIDProducto_Serie=$registros[0]["nIDProducto_Serie"];

        if($l_nIDProducto_Serie>0){

            // Busca el id del detalle del packing list 
            $l_Condicion="nIDPackingList=" .$l_nIDPackingList_Codigo ." and bEstado=0 and nIDProducto=" . $l_nIDProducto_Codigo;
            $tbl_Deta = new  cltbl_Packinglist_Deta_v2_0_0();
            $tbl_Deta->Inicializacion();
            $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Deta->Leer($l_Condicion);
            if($tbl_Deta->CualEsElNumeroDeRegistrosCargados()>0){
                 
                $registros_deta=$tbl_Deta->dtBase();
                $l_nIDPackingList_Deta=$registros_deta[0]["nIDPackingList_Deta"];

                if($l_nIDPackingList_Deta>0){

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

} 
*/

?> 
  