<?php
// ----------------------------------------------------------------------------------
// modulos.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion.  Es utilizada para indicar la ubicacion del sistema
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 06/11/2019
// ----------------------------------------------------------------------------------

// ----------------------------------------------
date_default_timezone_set("America/Mexico_City");
// ----------------------------------------------

$VERSION=" v1.4";
$TITULO="SGA";
$UBICACION_CONTROL="../control";
$UBICACION_ADJUNTOS="../adjuntos";

$UBICACION_BD="../bd/";
$PASSWORD_ENCRIPTAR="Kb.204.h3";
define ("SECRETKEY", $PASSWORD_ENCRIPTAR);

?>
 