<?php
// ----------------------------------------------------------------------------------
// entradas_cancelar.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Controlador para consultar la base de datos.
//              - Recibe una condición en JSON con el método de acceso POST.
//                { condicion:[info consulta], 
//                  campodeordenamiento:[campo], 
//                  formadeordenamiento:[forma], 
//                  cantidadregistros:[cantidad]
//                  tipo:[directa/general] 
//                      ** directa-> Se envia la consulta completa
//                      ** general-> Se envia el valor
//                  campos:[definidos/todos]
//                      ** definidos -> Son los que estan definidos en la clase
//                      ** todos -> Todos los campos
//                }
//              - Devuelve el resultado en JSON.  
//                {
//                    retorno=>TRUE/FALSE, msg=>"MENSAJE",[REGISTROS] 
//                } 
// ----------------------------------------------------------------------------------
// Empresa. IDEATECH
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 24/07/2020
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
include_once "../clases/contenedores.mysql.class_v2.0.0.php"; 
include_once "../clases/contenedores_deta.mysql.class_v2.0.0.php"; 
include_once "../clases/packinglist.mysql.class_v2.0.0.php";   
   
include_once "../bd/conexion.php";
 
$retorno= array();
$arreglos = array();
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));
 
$l_NumeroDeRegistros=count($arreglos);

if($l_NumeroDeRegistros<=0){ 
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE CONDICION DE CONSULTA"];
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
$tbl_PackingList = new  cltbl_Packinglist_v2_0_0();
$tbl_Contenedor = new  cltbl_Contenedores_v2_0_0(); 
$tbl_Contenedor_Deta = new  cltbl_Contenedor_Deta_v2_0_0();  

$contador=0;
$l_nIDPackingList=0; 

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
 
for($i=0;$i<$l_NumeroDeRegistros;$i++){

    $l_nIDPackingList=$arreglos[$i]->{"nidpackinglist"};

    if($l_nIDPackingList>0){

        $tbl_Contenedor->Inicializacion();
        $tbl_Contenedor->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Contenedor->CargarCampos("LEER");        
        $tbl_Contenedor->Leer("nIDPackingList=" . $l_nIDPackingList . " and bEstado=0"); 
        
        if($tbl_Contenedor->CualEsElNumeroDeRegistrosCargados()>0){ 

            $registros=$tbl_Contenedor->dtBase();
             
            $l_nIDContenedor=$registros[0]["nIDContenedor"];
            
            if($l_nIDContenedor>0){
                // Eliminar el contenedor
                $tbl_Contenedor->EliminarConCondicion("nIDContenedor=" . $l_nIDContenedor);

                // Eliminar el detalle del contenedor
                $tbl_Contenedor_Deta->Inicializacion();
                $tbl_Contenedor_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Contenedor_Deta->EliminarConCondicion("nIDContenedor=" . $l_nIDContenedor);

                // Cambiar el estatus del packinglist
                $tbl_PackingList->Inicializacion();
                $tbl_PackingList->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_PackingList->CambiarEstatus($l_nIDPackingList,"SIN INSPECCION",$l_Observaciones);
             
                $datos=array();
                $datos=$datos + ["retorno"=>"TRUE"];
                $datos=$datos + ["msg"=>"CANCELADO CON EXITO"];            
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;    
                exit(1);



            } else {
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"CONTENEDOR NO ENCONTRADO"];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno;   
                exit(1); 
            }

        } else {

            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"NO TIENE CONTENEDOR EL PACKINGLIST"];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;   
            exit(1); 
        }

    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE ID EL PACKINGLIST"];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;   
        exit(1); 
    } 
   
}
 

?> 
  