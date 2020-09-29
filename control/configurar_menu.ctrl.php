<?php
// ----------------------------------------------------------------------------------
// configurar_menu.ctrl.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 04/06/2020
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
include_once "../clases/relauxs.mysql.class_v2.0.0.php";  
include_once "../clases/usuarios.mysql.class_v2.0.0.php"; 
include_once "../clases/perfiles.mysql.class_v2.0.0.php"; 
include_once "../clases/ambiente_clasificaciones_deta.mysql.class_v2.0.0.php"; 
include_once "../clases/ambiente_modulos.mysql.class_v2.0.0.php"; 
include_once "../utilerias/utilerias.php";
include_once "../bd/conexion.php";

$l_Regresar="";
$retorno= array();
$arreglos = array();
 
$arreglos=json_decode(stripslashes(file_get_contents("php://input")));
 
$l_NumeroDeRegistros=count($arreglos);

 
if($l_NumeroDeRegistros<=0){ 
    $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
    $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
    $l_Regresar.="<span class='navbar-toggler-icon'></span>";
    $l_Regresar.="</button>";

    $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";

    $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
    $l_Regresar.= "<li id='id_0' class='nav-item active'>";
    $l_Regresar.="<a class='nav-link' href='menu.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'>(current)</span>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Inicio	</label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";

    // -------------------         
    $l_Regresar.="<li id='id_1' class='nav-item dropdown'>";
    $l_Regresar.="<a class='nav-link' href='salir.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;'>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Salir </label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";
    // -------------------
    
    $l_Regresar.="</ul>";

    $l_Regresar.="</div>";
    $l_Regresar.="</nav>";

    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE CONDICION DE CONSULTA"];
    $datos=$datos + ["regresar"=>$l_Regresar];
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

$l_Tipo=$arreglos[0]->{"tipo"};
$l_Sesion=$arreglos[0]->{"sesion"};



if(strlen($l_Sesion)<=0){ 
    $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
    $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
    $l_Regresar.="<span class='navbar-toggler-icon'></span>";
    $l_Regresar.="</button>";

    $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";

    $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
    $l_Regresar.= "<li id='id_0' class='nav-item active'>";
    $l_Regresar.="<a class='nav-link' href='menu.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'></span>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Inicio	</label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";

    // -------------------         
    $l_Regresar.="<li id='id_1' class='nav-item dropdown'>";
    $l_Regresar.="<a class='nav-link' href='salir.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;'>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Salir </label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";
    // -------------------
    
    $l_Regresar.="</ul>";

    $l_Regresar.="</div>";
    $l_Regresar.="</nav>";

    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE SESION"];
    $datos=$datos + ["regresar"=>$l_Regresar];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}

if(strlen($l_Tipo)<=0){
    $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
    $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
    $l_Regresar.="<span class='navbar-toggler-icon'></span>";
    $l_Regresar.="</button>";

    $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";

    $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
    $l_Regresar.= "<li id='id_0' class='nav-item active'>";
    $l_Regresar.="<a class='nav-link' href='menu.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'>(current)</span>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Inicio	</label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";

    // -------------------         
    $l_Regresar.="<li id='id_1' class='nav-item dropdown'>";
    $l_Regresar.="<a class='nav-link' href='salir.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;'>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Salir </label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";
    // -------------------

    $l_Regresar.="</ul>";

    $l_Regresar.="</div>";
    $l_Regresar.="</nav>";

    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE TIPO"];
    $datos=$datos + ["regresar"=>$l_Regresar];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);
}
  
 // ----------------------------------------------
 // SESION
 $l_nIDUsuario=0;  
 $l_nIDSesion=0;

 $l_Condicion="bEstado=0 and IDSesion='" . $l_Sesion . "'";      
 $tbl_RelaUxS = new  cltbl_RelaUxS_v2_0_0();
 $tbl_RelaUxS->Inicializacion();
 $tbl_RelaUxS->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
 $tbl_RelaUxS->Leer($l_Condicion);
 if($tbl_RelaUxS->CualEsElNumeroDeRegistrosCargados()>0){
    $registros=$tbl_RelaUxS->dtBase();
    $l_nIDSesion=$registros[0]["nIDSesion"];
    $l_nIDUsuario=$registros[0]["nIDUsuario"];

    if($l_nIDUsuario<=0){
        $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
        $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
        $l_Regresar.="<span class='navbar-toggler-icon'></span>";
        $l_Regresar.="</button>";

        $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";

        $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
        $l_Regresar.= "<li id='id_0' class='nav-item active'>";
        $l_Regresar.="<a class='nav-link' href='menu.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'>(current)</span>";
        $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Inicio	</label>";
        $l_Regresar.="</a>";
        $l_Regresar.="</li>";

        // -------------------         
        $l_Regresar.="<li id='id_1' class='nav-item dropdown'>";
        $l_Regresar.="<a class='nav-link' href='salir.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;'>";
        $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Salir </label>";
        $l_Regresar.="</a>";
        $l_Regresar.="</li>";
        // -------------------

        $l_Regresar.="</ul>";

        $l_Regresar.="</div>";
        $l_Regresar.="</nav>";

        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"NO TIENE SESION ACTIVA"];
        $datos=$datos + ["regresar"=>$l_Regresar];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }


 } else {
    $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
    $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
    $l_Regresar.="<span class='navbar-toggler-icon'></span>";
    $l_Regresar.="</button>";

    $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";

    $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
    $l_Regresar.= "<li id='id_0' class='nav-item active'>";
    $l_Regresar.="<a class='nav-link' href='menu.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'>(current)</span>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Inicio	</label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";

    // -------------------         
    $l_Regresar.="<li id='id_1' class='nav-item dropdown'>";
    $l_Regresar.="<a class='nav-link' href='salir.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;'>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Salir </label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";
    // -------------------

    $l_Regresar.="</ul>";

    $l_Regresar.="</div>";
    $l_Regresar.="</nav>";

    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"NO TIENE SESION ACTIVA"];
    $datos=$datos + ["regresar"=>$l_Regresar];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);

 }
 // ----------------------------------------------

 // ----------------------------------------------
 // USUARIO
 $l_nIDPerfil=0;  
 $tbl_Usuario = new  cltbl_Usuarios_v2_0_0();                       
 $tbl_Usuario->Inicializacion();
 $tbl_Usuario->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
 $tbl_Usuario->CargarCampos("LEER");
 $l_Condicion="nIDUsuario=" . $l_nIDUsuario . " and Activo='SI' and bEstado=0 and (Web='SI' or App='SI')";
 $tbl_Usuario->Leer($l_Condicion);
 if($tbl_Usuario->CualEsElNumeroDeRegistrosCargados()>0){
    $registros_usuario=$tbl_Usuario->dtBase();
    $l_nIDPerfil=$registros_usuario[0]["nIDPerfil"];        

    if($l_nIDPerfil<=0){
        $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
        $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
        $l_Regresar.="<span class='navbar-toggler-icon'></span>";
        $l_Regresar.="</button>";

        $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";

        $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
        $l_Regresar.= "<li id='id_0' class='nav-item active'>";
        $l_Regresar.="<a class='nav-link' href='menu.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'>(current)</span>";
        $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Inicio	</label>";
        $l_Regresar.="</a>";
        $l_Regresar.="</li>";

        // -------------------         
        $l_Regresar.="<li id='id_1' class='nav-item dropdown'>";
        $l_Regresar.="<a class='nav-link' href='salir.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;'>";
        $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Salir </label>";
        $l_Regresar.="</a>";
        $l_Regresar.="</li>";
        // -------------------

        $l_Regresar.="</ul>";

        $l_Regresar.="</div>";
        $l_Regresar.="</nav>";

        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"USUARIO NO ENCONTRADO"];
        $datos=$datos + ["regresar"=>$l_Regresar];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }
 
 } else {
    $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
    $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
    $l_Regresar.="<span class='navbar-toggler-icon'></span>";
    $l_Regresar.="</button>";

    $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";

    $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
    $l_Regresar.= "<li id='id_0' class='nav-item active'>";
    $l_Regresar.="<a class='nav-link' href='menu.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'>(current)</span>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Inicio	</label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";

    // -------------------         
    $l_Regresar.="<li id='id_1' class='nav-item dropdown'>";
    $l_Regresar.="<a class='nav-link' href='salir.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;'>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Salir </label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";
    // -------------------

    $l_Regresar.="</ul>";

    $l_Regresar.="</div>";
    $l_Regresar.="</nav>";

    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"USUARIO NO ENCONTRADO"];
    $datos=$datos + ["regresar"=>$l_Regresar];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);

 }
 // ----------------------------------------------

 // ----------------------------------------------
 // PERFIL
 $l_nIDAmbiente_Clasificacion=0;  
 $tbl_Perfil = new  cltbl_Perfiles_v2_0_0();                       
 $tbl_Perfil->Inicializacion();
 $tbl_Perfil->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
 $tbl_Perfil->CargarCampos("LEER");
 $l_Condicion="nIDPerfil=" . $l_nIDPerfil . " and  bEstado=0";
 $tbl_Perfil->Leer($l_Condicion);
 if($tbl_Perfil->CualEsElNumeroDeRegistrosCargados()>0){
    $registros_perfil=$tbl_Perfil->dtBase();
    $l_nIDAmbiente_Clasificacion=$registros_perfil[0]["nIDAmbiente_Clasificacion"];  
    
    if($l_nIDAmbiente_Clasificacion<=0){
        $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
        $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
        $l_Regresar.="<span class='navbar-toggler-icon'></span>";
        $l_Regresar.="</button>";
    
        $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";
    
        $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
        $l_Regresar.= "<li id='id_0' class='nav-item active'>";
        $l_Regresar.="<a class='nav-link' href='menu.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'>(current)</span>";
        $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Inicio	</label>";
        $l_Regresar.="</a>";
        $l_Regresar.="</li>";
    
        // -------------------         
        $l_Regresar.="<li id='id_1' class='nav-item dropdown'>";
        $l_Regresar.="<a class='nav-link' href='salir.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;'>";
        $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Salir </label>";
        $l_Regresar.="</a>";
        $l_Regresar.="</li>";
        // -------------------
    
        $l_Regresar.="</ul>";
    
        $l_Regresar.="</div>";
        $l_Regresar.="</nav>";
    
        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"PERFIL NO ECONTRADO"];
        $datos=$datos + ["regresar"=>$l_Regresar];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1); 
    }

 } else {
    $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
    $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
    $l_Regresar.="<span class='navbar-toggler-icon'></span>";
    $l_Regresar.="</button>";

    $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";

    $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
    $l_Regresar.= "<li id='id_0' class='nav-item active'>";
    $l_Regresar.="<a class='nav-link' href='menu.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'>(current)</span>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Inicio	</label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";

    // -------------------         
    $l_Regresar.="<li id='id_1' class='nav-item dropdown'>";
    $l_Regresar.="<a class='nav-link' href='salir.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;'>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Salir </label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";
    // -------------------

    $l_Regresar.="</ul>";

    $l_Regresar.="</div>";
    $l_Regresar.="</nav>";

    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"PERFIL NO ECONTRADO"];
    $datos=$datos + ["regresar"=>$l_Regresar];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1); 
 }
 // ----------------------------------------------


 // ----------------------------------------------
 // DETALLES DE LA CLASIFICACION 
 $tbl_Clasificaciones_Deta = new  cltbl_Ambiente_Clasificaciones_Deta_v2_0_0();                       
 $tbl_Clasificaciones_Deta->Inicializacion();
 $tbl_Clasificaciones_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
 $tbl_Clasificaciones_Deta->CargarCampos("LEER");
 $tbl_Clasificaciones_Deta->CampoDeOrdenamientoDeLaTabla("Orden");
 $l_Condicion="nIDAmbiente_Clasificacion=" . $l_nIDAmbiente_Clasificacion . " and  bEstado=0";
 $tbl_Clasificaciones_Deta->Leer($l_Condicion);
 if($tbl_Clasificaciones_Deta->CualEsElNumeroDeRegistrosCargados()<=0){
    $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
    $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
    $l_Regresar.="<span class='navbar-toggler-icon'></span>";
    $l_Regresar.="</button>";

    $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";

    $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
    $l_Regresar.= "<li id='id_0' class='nav-item active'>";
    $l_Regresar.="<a class='nav-link' href='menu.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'>(current)</span>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Inicio	</label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";

    // -------------------         
    $l_Regresar.="<li id='id_1' class='nav-item dropdown'>";
    $l_Regresar.="<a class='nav-link' href='salir.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;'>";
    $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Salir </label>";
    $l_Regresar.="</a>";
    $l_Regresar.="</li>";
    // -------------------

    $l_Regresar.="</ul>";

    $l_Regresar.="</div>";
    $l_Regresar.="</nav>";

    $datos=array();
    $datos=$datos + ["retorno"=>"FALSE"];
    $datos=$datos + ["msg"=>"PLANTILLA NO ENCONTRADA"];
    $datos=$datos + ["regresar"=>$l_Regresar];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1); 
 }  
 // ----------------------------------------------

 $tbl_Modulos = new  cltbl_Ambiente_Modulos_v2_0_0();
 $tbl_Modulos1 = new  cltbl_Ambiente_Modulos_v2_0_0();
 $tbl_Modulos2 = new  cltbl_Ambiente_Modulos_v2_0_0();


if($l_Tipo=="MOVIL"){
    $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
    $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
    $l_Regresar.="<span class='navbar-toggler-icon'></span>";
    $l_Regresar.="</button>";

    $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";
    $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";

    $l_nIDModulo=0;
    $l_NombreDelModulo="";
    $l_Mostrar="NO";
    $registros_deta=$tbl_Clasificaciones_Deta->dtBase();

    for($i=0;$i<$tbl_Clasificaciones_Deta->CualEsElNumeroDeRegistrosCargados();$i++){
        $l_nIDModulo=$registros_deta[$i]["nIDModulo"];  
        $l_NombreDelModulo=$registros_deta[$i]["NombreDelModulo"];  
        $l_Mostrar=$registros_deta[$i]["Mostrar"];  
        $l_Orden=$registros_deta[$i]["Orden"];  
        $l_nIDModulo_Padre=$registros_deta[$i]["nIDModulo_Padre"];  
        $l_Nivel=$registros_deta[$i]["Nivel"];  
        $l_Menu=$registros_deta[$i]["Menu"];  
        $l_URL=$registros_deta[$i]["URL"]; 
        $l_App=$registros_deta[$i]["App"];  
        $l_Web=$registros_deta[$i]["Web"];

        if($l_App=="SI"){

            if($l_nIDModulo>0){

                if($l_Nivel=="Menu"){
                 
                    $tbl_Modulos->Inicializacion();
                    $tbl_Modulos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                    $tbl_Modulos->CargarCampos("LEER");
                    $tbl_Modulos->CampoDeOrdenamientoDeLaTabla("Orden");
                
                    $l_Condicion="nIDModulo_Padre=" . $l_nIDModulo . " and  bEstado=0";
                    $tbl_Modulos->Leer($l_Condicion);
                    if($tbl_Modulos->CualEsElNumeroDeRegistrosCargados()>0){

                        if($l_Mostrar=="SI"){
                            // -------------------
                            // Menus
                            $l_Regresar.="<li id='id_" .$i ."' class='nav-item dropdown'>";
                            $l_Regresar.="<a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;z-index:20;'>";
                            $l_Regresar.="<label style='font-size:12px;cursor:pointer;'>" .$l_Menu ." </label>";
                            $l_Regresar.="</a>";
                            // -------------------

                            // --- SubMenu
                            $l_Regresar.="<ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>";

                            $registros_modulos=$tbl_Modulos->dtBase();

                            for($j=0;$j<$tbl_Modulos->CualEsElNumeroDeRegistrosCargados();$j++){
                                $l_SubNivel1_nIDModulo=$registros_modulos[$j]["nIDModulo"];  
                                $l_SubNivel1_NombreDelModulo=$registros_modulos[$j]["NombreDelModulo"];  
                                $l_SubNivel1_Mostrar=$registros_modulos[$j]["Mostrar"];  
                                $l_SubNivel1_Orden=$registros_modulos[$j]["Orden"];  
                                $l_SubNivel1_nIDModulo_Padre=$registros_modulos[$j]["nIDModulo_Padre"];  
                                $l_SubNivel1_Nivel=$registros_modulos[$j]["Nivel"];  
                                $l_SubNivel1_Menu=$registros_modulos[$j]["Menu"];  
                                $l_SubNivel1_URL=$registros_modulos[$j]["URL"];  
                                $l_SubNivel1_Web=$registros_modulos[$j]["Web"]; 
                                $l_SubNivel1_App=$registros_modulos[$j]["App"]; 

                                if($l_SubNivel1_App=="SI"){
                                    
                                    if($l_SubNivel1_nIDModulo>0){

                                        if($l_SubNivel1_Nivel=="SubMenu1"){

                                            $tbl_Modulos1->Inicializacion();
                                            $tbl_Modulos1->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                                            $tbl_Modulos1->CargarCampos("LEER");
                                            $tbl_Modulos1->CampoDeOrdenamientoDeLaTabla("Orden");
                                    
                                            $l_Condicion="nIDModulo_Padre=" . $l_SubNivel1_nIDModulo . " and  bEstado=0";
                                            $tbl_Modulos1->Leer($l_Condicion);
                                            if($tbl_Modulos1->CualEsElNumeroDeRegistrosCargados()>0){
                                            
                                                if($l_SubNivel1_Mostrar=="SI"){
                                                    $l_Regresar.="<li  class='dropdown-submenu'><a class='dropdown-item dropdown-toggle' href='#' style='text-aling:center;font-family:Arial Black, Gadget, sans-serif; font-size:12px;' onclick=\"fn_Abrir('id_" .$l_SubNivel1_nIDModulo ."')\" onmouseover=\"fn_Abrir('id_" .$l_SubNivel1_nIDModulo . "');\"' >" .$l_SubNivel1_Menu  . "</a>";
                                                    $l_Regresar.="<ul id='id_" .$l_SubNivel1_nIDModulo ."' class='dropdown-menu'>";
    
                                                    $registros_modulos1=$tbl_Modulos1->dtBase();
                                            
                                                    for($k=0;$k<$tbl_Modulos1->CualEsElNumeroDeRegistrosCargados();$k++){
    
                                                        $l_SubNivel2_nIDModulo=$registros_modulos1[$k]["nIDModulo"];  
                                                        $l_SubNivel2_NombreDelModulo=$registros_modulos1[$k]["NombreDelModulo"];  
                                                        $l_SubNivel2_Mostrar=$registros_modulos1[$k]["Mostrar"];  
                                                        $l_SubNivel2_Orden=$registros_modulos1[$k]["Orden"];  
                                                        $l_SubNivel2_nIDModulo_Padre=$registros_modulos1[$k]["nIDModulo_Padre"];  
                                                        $l_SubNivel2_Nivel=$registros_modulos1[$k]["Nivel"];  
                                                        $l_SubNivel2_Menu=$registros_modulos1[$k]["Menu"];  
                                                        $l_SubNivel2_URL=$registros_modulos1[$k]["URL"];  
                                                        $l_SubNivel2_Web=$registros_modulos1[$k]["Web"]; 
                                                        $l_SubNivel2_App=$registros_modulos1[$k]["App"]; 

                                                        if($l_SubNivel2_App=="SI"){

                                                            if($l_SubNivel2_nIDModulo>0){
    
                                                                if($l_SubNivel2_Nivel=="SubMenu1_1"){
                                                                    $tbl_Modulos2->Inicializacion();
                                                                    $tbl_Modulos2->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                                                                    $tbl_Modulos2->CargarCampos("LEER");
                                                                    $tbl_Modulos2->CampoDeOrdenamientoDeLaTabla("Orden");
                                                            
                                                                    $l_Condicion="nIDModulo_Padre=" . $l_SubNivel2_nIDModulo . " and  bEstado=0";
                                                                    $tbl_Modulos2->Leer($l_Condicion);
        
                                                                    if($tbl_Modulos2->CualEsElNumeroDeRegistrosCargados()>0){
        
                                                                    } else {
                                                                        $l_Regresar.="<li><a class='dropdown-item' href='" .$l_SubNivel2_URL . "' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;' >" .$l_SubNivel2_Menu . "</a></li>";
                                                                    }
                                                                } else {
        
                                                                }
                                                            } else {
                                                                if($l_SubNivel2_Mostrar=="SI"){
                                                                    $l_Regresar.="<li><a class='dropdown-item' href='" .$l_SubNivel2_URL . "' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;' >" .$l_SubNivel2_Menu . " </a></li>";
                                                                }
                                                            }

                                                        }
                                                        
                                                    }
                                            
                                                    $l_Regresar.="</ul>";
                                                    $l_Regresar.="</li>";
                                                }
                                        
                                            } else {
                                                if($l_SubNivel1_Mostrar=="SI"){
                                                    $l_Regresar.="<li><a class='dropdown-item' href='" . $l_SubNivel1_URL ."' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;' >" .$l_SubNivel1_Menu ."</a></li>";
                                                }
                                            }   
                                        }

                                    }

                                }   

                            }   
                            $l_Regresar.="</ul>";
                            $l_Regresar.="</li>";
                        }            
                    } else {
                        if($l_Mostrar=="SI"){
                            // -------------------
                            // Menus
                            $l_Regresar.="<li id='id_" .$i ."' class='nav-item active'>";
                            $l_Regresar.="<a class='nav-link' href='" .$l_URL ."' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'> </span>";
                            $l_Regresar.="<label style='font-size:12px;cursor:pointer;'>" .$l_Menu . "</label>";
                            $l_Regresar.="</a>";
                            $l_Regresar.="</li>";
                            // -------------------
                        }                        
                    }                     
                }
            }
        }

    }

    $l_Regresar.="</ul>";
    $l_Regresar.="</div>";
    $l_Regresar.="</nav>";

    $datos=array();
    $datos=$datos + ["retorno"=>"TRUE"];
    $datos=$datos + ["msg"=>""];
    $datos=$datos + ["regresar"=>$l_Regresar];
    array_push($retorno,$datos);    
    $retorno=json_encode($retorno);	 
    echo $retorno;    
    exit(1);

} else {
    if($l_Tipo=="PC"){
        $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
        $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
        $l_Regresar.="<span class='navbar-toggler-icon'></span>";
        $l_Regresar.="</button>";

        $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";
        $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";

        $l_nIDModulo=0;
        $l_NombreDelModulo="";
        $l_Mostrar="NO";
        $registros_deta=$tbl_Clasificaciones_Deta->dtBase();

        for($i=0;$i<$tbl_Clasificaciones_Deta->CualEsElNumeroDeRegistrosCargados();$i++){
            $l_nIDModulo=$registros_deta[$i]["nIDModulo"];  
            $l_NombreDelModulo=$registros_deta[$i]["NombreDelModulo"];  
            $l_Mostrar=$registros_deta[$i]["Mostrar"];  
            $l_Orden=$registros_deta[$i]["Orden"];  
            $l_nIDModulo_Padre=$registros_deta[$i]["nIDModulo_Padre"];  
            $l_Nivel=$registros_deta[$i]["Nivel"];  
            $l_Menu=$registros_deta[$i]["Menu"];  
            $l_URL=$registros_deta[$i]["URL"]; 
            $l_App=$registros_deta[$i]["App"];  
            $l_Web=$registros_deta[$i]["Web"];

            if($l_Web=="SI"){

                if($l_nIDModulo>0){

                    if($l_Nivel=="Menu"){
                     
                        $tbl_Modulos->Inicializacion();
                        $tbl_Modulos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                        $tbl_Modulos->CargarCampos("LEER");
                        $tbl_Modulos->CampoDeOrdenamientoDeLaTabla("Orden");
                    
                        $l_Condicion="nIDModulo_Padre=" . $l_nIDModulo . " and  bEstado=0";
                        $tbl_Modulos->Leer($l_Condicion);
                        if($tbl_Modulos->CualEsElNumeroDeRegistrosCargados()>0){

                            if($l_Mostrar=="SI"){
                                // -------------------
                                // Menus
                                $l_Regresar.="<li id='id_" .$i ."' class='nav-item dropdown'>";
                                $l_Regresar.="<a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;z-index:20;'>";
                                $l_Regresar.="<label style='font-size:12px;cursor:pointer;'>" .$l_Menu ." </label>";
                                $l_Regresar.="</a>";
                                // -------------------

                                // --- SubMenu
                                $l_Regresar.="<ul class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>";

                                $registros_modulos=$tbl_Modulos->dtBase();

                                for($j=0;$j<$tbl_Modulos->CualEsElNumeroDeRegistrosCargados();$j++){
                                    $l_SubNivel1_nIDModulo=$registros_modulos[$j]["nIDModulo"];  
                                    $l_SubNivel1_NombreDelModulo=$registros_modulos[$j]["NombreDelModulo"];  
                                    $l_SubNivel1_Mostrar=$registros_modulos[$j]["Mostrar"];  
                                    $l_SubNivel1_Orden=$registros_modulos[$j]["Orden"];  
                                    $l_SubNivel1_nIDModulo_Padre=$registros_modulos[$j]["nIDModulo_Padre"];  
                                    $l_SubNivel1_Nivel=$registros_modulos[$j]["Nivel"];  
                                    $l_SubNivel1_Menu=$registros_modulos[$j]["Menu"];  
                                    $l_SubNivel1_URL=$registros_modulos[$j]["URL"];  
                                    $l_SubNivel1_Web=$registros_modulos[$j]["Web"]; 
                                    $l_SubNivel1_App=$registros_modulos[$j]["App"]; 

                                    if($l_SubNivel1_Web=="SI"){
                                        
                                        if($l_SubNivel1_nIDModulo>0){

                                            if($l_SubNivel1_Nivel=="SubMenu1"){
    
                                                $tbl_Modulos1->Inicializacion();
                                                $tbl_Modulos1->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                                                $tbl_Modulos1->CargarCampos("LEER");
                                                $tbl_Modulos1->CampoDeOrdenamientoDeLaTabla("Orden");
                                        
                                                $l_Condicion="nIDModulo_Padre=" . $l_SubNivel1_nIDModulo . " and  bEstado=0";
                                                $tbl_Modulos1->Leer($l_Condicion);
                                                if($tbl_Modulos1->CualEsElNumeroDeRegistrosCargados()>0){
                                                
                                                    if($l_SubNivel1_Mostrar=="SI"){
                                                        $l_Regresar.="<li  class='dropdown-submenu'><a class='dropdown-item dropdown-toggle' href='#' style='text-aling:center;font-family:Arial Black, Gadget, sans-serif; font-size:12px;' onclick=\"fn_Abrir('id_" .$l_SubNivel1_nIDModulo ."')\" onmouseover=\"fn_Abrir('id_" .$l_SubNivel1_nIDModulo . "');\"' >" .$l_SubNivel1_Menu  . "</a>";
                                                        $l_Regresar.="<ul id='id_" .$l_SubNivel1_nIDModulo ."' class='dropdown-menu'>";
        
                                                        $registros_modulos1=$tbl_Modulos1->dtBase();
                                                
                                                        for($k=0;$k<$tbl_Modulos1->CualEsElNumeroDeRegistrosCargados();$k++){
        
                                                            $l_SubNivel2_nIDModulo=$registros_modulos1[$k]["nIDModulo"];  
                                                            $l_SubNivel2_NombreDelModulo=$registros_modulos1[$k]["NombreDelModulo"];  
                                                            $l_SubNivel2_Mostrar=$registros_modulos1[$k]["Mostrar"];  
                                                            $l_SubNivel2_Orden=$registros_modulos1[$k]["Orden"];  
                                                            $l_SubNivel2_nIDModulo_Padre=$registros_modulos1[$k]["nIDModulo_Padre"];  
                                                            $l_SubNivel2_Nivel=$registros_modulos1[$k]["Nivel"];  
                                                            $l_SubNivel2_Menu=$registros_modulos1[$k]["Menu"];  
                                                            $l_SubNivel2_URL=$registros_modulos1[$k]["URL"];  
                                                            $l_SubNivel2_Web=$registros_modulos1[$k]["Web"]; 
                                                            $l_SubNivel2_App=$registros_modulos1[$k]["App"]; 

                                                            if($l_SubNivel2_Web=="SI"){

                                                                if($l_SubNivel2_nIDModulo>0){
        
                                                                    if($l_SubNivel2_Nivel=="SubMenu1_1"){
                                                                        $tbl_Modulos2->Inicializacion();
                                                                        $tbl_Modulos2->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                                                                        $tbl_Modulos2->CargarCampos("LEER");
                                                                        $tbl_Modulos2->CampoDeOrdenamientoDeLaTabla("Orden");
                                                                
                                                                        $l_Condicion="nIDModulo_Padre=" . $l_SubNivel2_nIDModulo . " and  bEstado=0";
                                                                        $tbl_Modulos2->Leer($l_Condicion);
            
                                                                        if($tbl_Modulos2->CualEsElNumeroDeRegistrosCargados()>0){
            
                                                                        } else {
                                                                            $l_Regresar.="<li><a class='dropdown-item' href='" .$l_SubNivel2_URL . "' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;' >" .$l_SubNivel2_Menu . "</a></li>";
                                                                        }
                                                                    } else {
            
                                                                    }
                                                                } else {
                                                                    if($l_SubNivel2_Mostrar=="SI"){
                                                                        $l_Regresar.="<li><a class='dropdown-item' href='" .$l_SubNivel2_URL . "' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;' >" .$l_SubNivel2_Menu . " </a></li>";
                                                                    }
                                                                }

                                                            }
                                                            
                                                        }
                                                
                                                        $l_Regresar.="</ul>";
                                                        $l_Regresar.="</li>";
                                                    }
                                            
                                                } else {
                                                    if($l_SubNivel1_Mostrar=="SI"){
                                                        $l_Regresar.="<li><a class='dropdown-item' href='" . $l_SubNivel1_URL ."' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;' >" .$l_SubNivel1_Menu ."</a></li>";
                                                    }
                                                }   
                                            }

                                        }

                                    }   

                                }   
                                $l_Regresar.="</ul>";
                                $l_Regresar.="</li>";
                            }            
                        } else {
                            if($l_Mostrar=="SI"){
                                // -------------------
                                // Menus
                                $l_Regresar.="<li id='id_" .$i ."' class='nav-item active'>";
                                $l_Regresar.="<a class='nav-link' href='" .$l_URL ."' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'> </span>";
                                $l_Regresar.="<label style='font-size:12px;cursor:pointer;'>" .$l_Menu . "</label>";
                                $l_Regresar.="</a>";
                                $l_Regresar.="</li>";
                                // -------------------
                            }                        
                        }                     
                    }
                }
            }

        }

        $l_Regresar.="</ul>";
        $l_Regresar.="</div>";
        $l_Regresar.="</nav>";

        $datos=array();
        $datos=$datos + ["retorno"=>"TRUE"];
        $datos=$datos + ["msg"=>""];
        $datos=$datos + ["regresar"=>$l_Regresar];
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);

    } else {
        $l_Regresar="<nav class='navbar navbar-expand-lg navbar-light bg-light'>";
        $l_Regresar.="<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarTogglerDemo01' aria-controls='navbarTogglerDemo01' aria-expanded='false' aria-label='Toggle navigation'>";
        $l_Regresar.="<span class='navbar-toggler-icon'></span>";
        $l_Regresar.="</button>";

        $l_Regresar.="<div class='collapse navbar-collapse' id='navbarTogglerDemo01'>";

        $l_Regresar.="<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
        $l_Regresar.= "<li id='id_0' class='nav-item active'>";
        $l_Regresar.="<a class='nav-link' href='menu.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:10px;'> <span class='sr-only'>(current)</span>";
        $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Inicio	</label>";
        $l_Regresar.="</a>";
        $l_Regresar.="</li>";

         // -------------------         
         $l_Regresar.="<li id='id_1' class='nav-item dropdown'>";
         $l_Regresar.="<a class='nav-link' href='salir.php' style='text-aling:center;font-family:Arial, Gadget, sans-serif; font-size:12px;'>";
         $l_Regresar.="<label style='font-size:12px;cursor:pointer;'> Salir </label>";
         $l_Regresar.="</a>";
         $l_Regresar.="</li>";
         // -------------------

        $l_Regresar.="</ul>";

        $l_Regresar.="</div>";
        $l_Regresar.="</nav>";

        $datos=array();
        $datos=$datos + ["retorno"=>"FALSE"];
        $datos=$datos + ["msg"=>"TIPO INVALIDO"];
        $datos=$datos + ["regresar"=>$l_Regresar];
        
        array_push($retorno,$datos);    
        $retorno=json_encode($retorno);	 
        echo $retorno;    
        exit(1);
    }
}

 
 
?> 
  