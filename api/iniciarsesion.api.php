<?php
// ----------------------------------------------------------------------------------
// usuarios_consultar_todos.api.php
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
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 05/11/2019
// ----------------------------------------------------------------------------------

class ArrayValue implements JsonSerializable {
    public function __construct(array $array) {
        $this->array = $array;
    }

    public function jsonSerialize() {
        return $this->array;
    }
}
 
 
// ----------------------------------------------
date_default_timezone_set("America/Mexico_City");
// ----------------------------------------------

include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/usuarios.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";
include_once "../clases/relauxs.mysql.class_v2.0.0.php";
include_once "../clases/sesion.mysql.class_v2.0.0.php";

$retorno= array();
$arreglos = array();
  
$arreglos=json_decode(stripslashes(file_get_contents("php://input"))); 

//$l_NumeroDeRegistros=count($arreglos);
$l_Usuario=trim($arreglos->{"usuario"});
$l_Pass=trim($arreglos->{"pass"});
  
if(strlen($l_Usuario)<=0 && strlen($l_Pass)<=0 ){
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE DATOS"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno; 
    exit(1);
} 

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true); 
// ----------------------------------------------

// ----------------------------------------------
 $hoy=getdate();
 $token = sha1(rand(0,999).rand(999,9999).rand(1,300));
 $l_GUID=uniqid();
 $navegador="";
 $browser_type = getenv("HTTP_USER_AGENT");
 if (preg_match("/MSIE/i", "$browser_type")) {
     $navegador="Microsoft Internet Explorer";
 } else if (preg_match("/Mozilla/i", "browser_type")) {
     $navegador="Netscape Comunicato";
 } else {
     $navegador="$browser_type";
 }
 $_SESSION['NUMERODESESION']=$hoy[0];
 
 $valor_sesion_codificada=base64_encode($_SESSION['NUMERODESESION']);
 $_SESSION['token'] = $token;
 $_SESSION['navegador'] = $navegador;
 $_SESSION['guid'] = $l_GUID;
 $_SESSION['NUMERODESESION']=$valor_sesion_codificada;
// ----------------------------------------------

// ----------------------------------------------   
// Leer la info para procesar
$tbl = new  cltbl_Usuarios_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$Campo_Llave=$tbl->get_CampoLlave();

$l_Condicion="Usuario='" . $l_Usuario . "' and Password='" . $l_Pass . "' and App='SI' and Activo='SI' and bEstado=0";

if(strlen($l_Condicion)>0){
    $tbl->Inicializacion();
    $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl->Leer($l_Condicion);

    if($tbl->CualEsElNumeroDeRegistrosCargados()>0){     

        $registros=$tbl->dtBase();
        $l_nIDUsuario=$registros[0]["nIDUsuario"];

        // ----------------------------------------------
        // Carga datos generales
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
        // ----------------------------------------------

        // ----------------------------------------------
        // Graba la sesion
        $tbl_Sesion = new  cltbl_Sesion_v2_0_0();
        $tbl_Sesion->Inicializacion();
	    $tbl_Sesion->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
	    $tbl_Sesion->CargarCampos("GRABAR");
 
	    $datos_grabar = array();
	    array_push($datos_grabar,0);
	    array_push($datos_grabar,$valor_sesion_codificada);
	    array_push($datos_grabar,$navegador);
	    array_push($datos_grabar,$l_GUID);
	    array_push($datos_grabar,$token);
	 
	    array_push($datos_grabar,$l_FechaLocal);
	    array_push($datos_grabar,$l_FechaLocal);
	    array_push($datos_grabar,$l_Observaciones);
	    array_push($datos_grabar,0);
 
	    $registro_datos=array($datos_grabar[0]);
	    for ($j=1;$j<count($datos_grabar);$j++){
        	array_push($registro_datos,$datos_grabar[$j]);
	    }
	    array_push($registro_datos,1); // Crear 
	    array_push($registro_datos,0); // Cambiar
	    array_push($registro_datos,0); // Eliminar
 
        $tbl_Sesion->setInformacion_Grabar($registro_datos);

        $l_nIDSesion=0;
	    if($tbl_Sesion->Ejecutar()){		
            $l_Condicion="bEstado=0 and IDSesion='" . $valor_sesion_codificada . "'";
		    $tbl_Sesion = new  cltbl_Sesion_v2_0_0();
		    $tbl_Sesion->Inicializacion();
		    $tbl_Sesion->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
		    $tbl_Sesion->Leer($l_Condicion);
		    if($tbl_Sesion->CualEsElNumeroDeRegistrosCargados()>0){

                $registros=$tbl_Sesion->dtBase();
                $l_nIDSesion=$registros[0]["nIDSesion"];			 
                
                $tbl_RelaUxS = new  cltbl_RelaUxS_v2_0_0();
                $tbl_RelaUxS->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_RelaUxS->CargarCampos("GRABAR");
                
                $datos_grabar = array();
                                    
                array_push($datos_grabar,0);
                array_push($datos_grabar,$l_nIDUsuario);
                array_push($datos_grabar,$l_nIDSesion);
                 
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
                
                $tbl_RelaUxS->setInformacion_Grabar($registro_datos);

                if($tbl_RelaUxS->Ejecutar()){

                    $datos=array();
                    $datos=$datos + ["retorno"=>"TRUE"];
                    $datos=$datos + ["msg"=>""];
                    $datos=$datos + ["sesion"=>$valor_sesion_codificada];
                    $datos=$datos + ["nidusuario"=>$l_nIDUsuario];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno; 
                    exit(1);

                } else {
                    $datos=array();
                    $datos=$datos + ["retorno"=>"FALSE"];
                    $datos=$datos + ["msg"=>"ERROR AL GRABAR LA RELACION"];
                    $datos=$datos + ["sesion"=>""];
                    $datos=$datos + ["nidusuario"=>0];
                    array_push($retorno,$datos);    
                    $retorno=json_encode($retorno);	 
                    echo $retorno; 
                    exit(1);
                }

            } else {
                $datos=array();
                $datos=$datos + ["retorno"=>"FALSE"];
                $datos=$datos + ["msg"=>"ERROR SESION NO ENCONTRADA"];
                $datos=$datos + ["sesion"=>""];
                $datos=$datos + ["nidusuario"=>0];
                array_push($retorno,$datos);    
                $retorno=json_encode($retorno);	 
                echo $retorno; 
                exit(1);
            }

        } else {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"ERROR AL GRABAR LA SESION"];
            $datos=$datos + ["sesion"=>""];
            $datos=$datos + ["nidusuario"=>0];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno; 
            exit(1);
        }
        // ----------------------------------------------

    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO ENCONTRADO"];
        $datos=$datos + ["sesion"=>""];
        $datos=$datos + ["nidusuario"=>0];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno; 
        exit(1);
    }

} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE CONDICION"];
    $datos=$datos + ["sesion"=>""];
    $datos=$datos + ["nidusuario"=>0];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno; 
    exit(1);
}
 
 
   







 
 


/*
if(empty($_POST)){ 
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE POST"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno; 
}
*/

/*
if (!empty($_POST['uname'])) {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>$_POST['uname']];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno; 

} else {
    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE POST"];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno; 
}
*/
// ----------------------------------------------

exit(1);
// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true); 
// ----------------------------------------------
 
// ----------------------------------------------   
// Leer la info para procesar
$tbl = new  cltbl_Usuarios_v2_0_0();
$tbl->Inicializacion();
$tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl->CargarCampos("LEER");
$Campo_Llave=$tbl->get_CampoLlave();


for($i=0;$i<$l_NumeroDeRegistros;$i++){
    $l_ConsultaR=trim($arreglos[$i]->{"consulta"});
    $l_Condicion=trim($arreglos[$i]->{"condicion"});
    $l_CampoDeOrdenamiento=$arreglos[$i]->{"campodeordenamiento"};
    $l_FormaDeOrdenamiento=trim($arreglos[$i]->{"formadeordenamiento"});
    $l_CantidadRegistros=$arreglos[$i]->{"cantidadregistros"};
    $l_Tipo=$arreglos[$i]->{"tipo"};
    $l_Campos=$arreglos[$i]->{"campos"};

    if(strlen($l_FormaDeOrdenamiento)<=0){
        $l_FormaDeOrdenamiento="Ascendente";
    }

    $l_Consulta="";

    if($l_Tipo=="directa"){

        if(strlen($l_ConsultaR)<=0){   
            $l_ConsultaR=$Campo_Llave . ">0 and bEstado=0";
        }

    } else {

        if(strlen($l_ConsultaR)<=0){   
            $l_ConsultaR=$Campo_Llave . ">0 and bEstado=0";
        } else {
   
            for($h=0;$h<count($tbl->campos_busqueda);$h=$h+1){
                switch($tbl->campos_busqueda_tipo[$h]){
                    case "CADENA": 
                        if(strlen($l_Consulta)>0){                        
                            $l_Consulta=$l_Consulta . " or " . $tbl->campos_busqueda[$h] . " like '%" . $l_ConsultaR . "%'";
                        } else {
                            $l_Consulta=$l_Consulta . $tbl->campos_busqueda[$h] . " like '%" . $l_ConsultaR . "%'";
                        }                  
    
                        break;
                
                    case "NUMERO":
                        if(strlen($l_Consulta)>0){                        
                            $l_Consulta=$l_Consulta . " or " . $tbl->campos_busqueda[$h] . "=" . $l_ConsultaR;
                        } else {
                            $l_Consulta=$l_Consulta . $tbl->campos_busqueda[$h] . "=" . $l_ConsultaR;
                        }                  

                        break;
                    case "FECHA":
                        break;
                }
            }
     
            if(strlen($l_Consulta)>0){
                $l_ConsultaR="(" . $l_Consulta . ") and bEstado=0";            
            } else {
                $l_ConsultaR=$Campo_Llave . ">0 and bEstado=0";
            }                  
        }
    }

    // Condicion externa
    if(strlen($l_ConsultaR)>0){
 
        if(strlen($l_Condicion)>0){
            $l_Condicion="(" . $l_ConsultaR . ") and (" . $l_Condicion . ")";
        } else {
            $l_Condicion=$l_ConsultaR;
        }

    } else {
 
        if(strlen($l_Condicion)<=0){
            $l_Condicion=$Campo_Llave . ">0 and bEstado=0";
        } 
    }


    if(strlen($l_Condicion)>0){
        $tbl->Inicializacion();
        $tbl->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);

        if(strlen($l_CampoDeOrdenamiento)>0){
            $tbl->CampoDeOrdenamientoDeLaTabla($l_CampoDeOrdenamiento);
        }  

        if(strlen($l_FormaDeOrdenamiento)>0){
            $tbl->FormaDeOrdenamiento($l_FormaDeOrdenamiento);        
        } else {
            $tbl->FormaDeOrdenamiento("Ascendente");        
        }

        if(strlen($l_CantidadRegistros)>0){
            if(!is_numeric($l_CantidadRegistros)) {   
                $tbl->setLimiteInferior(0);
                $tbl->setLimiteSuperior($l_CantidadRegistros);
            }
        }

    
        $tbl->Leer($l_Condicion);

        if($tbl->CualEsElNumeroDeRegistrosCargados()>0){
            
            $registros=$tbl->dtBase();

            for($j=0;$j<$tbl->CualEsElNumeroDeRegistrosCargados();$j=$j+1){
                $datos=array();
                $especiales=array();
                $combo=array();

                $datos=$datos + ["retorno"=>"TRUE"];
                $datos=$datos + ["msg"=>""];
                $datos=$datos + ["llave"=>$Campo_Llave];

                // Extrae los campos especiales           
                for($k=0;$k<count($tbl->campos_especiales); $k=$k+1){
                    $especiales=$especiales +  [ $tbl->campos_especiales[$k]=>$tbl->campos_especiales_tipo[$k] ];
                }
                $datos=$datos + ["especiales"=>$especiales];

                // Extrae los combos     
                for($k=0;$k<count($tbl->campos_combo); $k=$k+1){
                    $combo=$combo +  [ $tbl->campos_combo[$k]=>"" ];
                }
                $datos=$datos + ["combo"=>$combo ];

                // ----------------------------------------------- 
                // Extrae los encabezados de la lista 21/03/2020
                $encabezados=array();
                for($k=0;$k<count($tbl->campos_listado); $k=$k+1){
                    $encabezados=$encabezados  +  [ $k => $tbl->campos_listado[$k] ];                     
                }
                $datos=$datos + ["encabezados"=>$encabezados];
                // -----------------------------------------------

                for($k=0;$k<$tbl->get_NumCampos();$k=$k+1){
                    $campo=$tbl->get_Estructura($k);
                    $valor=$registros[$j][$tbl->get_Estructura($k)];
                    $datos=$datos + [$campo=>$valor];                    
                    
                }
                array_push($retorno,$datos);   
            }
            $retorno=json_encode($retorno);	 
            echo $retorno;    
        } else {
            $datos=array();
            $datos=$datos + ["retorno"=>"FALSE"];
            $datos=$datos + ["msg"=>"NO TIENE REGISTROS"];
            $datos=$datos + ["llave"=>$Campo_Llave];

            // Extrae los encabezados de la lista 
            $encabezados=array();
            for($k=0;$k<count($tbl->campos_listado); $k=$k+1){
                 $encabezados=$encabezados  +  [ $k => $tbl->campos_listado[$k] ];                     
            }

            $datos=$datos + ["encabezados"=>$encabezados];
            array_push($retorno,$datos);    
            $retorno=json_encode($retorno);	 
            echo $retorno;    
        }
    } else {
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE REGISTROS"];
        $datos=$datos + ["llave"=>$Campo_Llave];

        // Extrae los encabezados de la lista 
        $encabezados=array();
        for($k=0;$k<count($tbl->campos_listado); $k=$k+1){
             $encabezados=$encabezados  +  [ $k => $tbl->campos_listado[$k] ];                     
        }
        
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
    }
   
}

?>