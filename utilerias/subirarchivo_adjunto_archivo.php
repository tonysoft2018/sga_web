<?php
// ----------------------------------------------------------------------------------
// subirarchivo_adjunto_imagen.php
// ----------------------------------------------------------------------------------
// Descripcion:
// Programa utilizado para grabar la sesion del usuario.
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 18/10/2018
// ----------------------------------------------------------------------------------

  $target_path = "../archivos/";

  $Archivo=$_FILES['txt_Archivo_Detalles1']['name'];

  //print_r($_FILES);

  //echo "Archivo:" . $Archivo . "---";

  $i=0;
  $posicion=0;
  $valor="";
  $NuevoNombre="";
  for($i=0;$i<strlen($Archivo);$i++){
	   $valor=substr($Archivo,$i,1);

	   if($valor=="."){
		    $posicion=$i;
		    break;
	   } else {
		    $NuevoNombre=$NuevoNombre .$valor;
	   }
   }


   $posicion=$posicion+1;
   $Extension="";
   for($i=$posicion;$i<strlen($Archivo);$i++){
   	  $valor=substr($Archivo,$i,1);
	    $Extension=$Extension .$valor;
   }

   $Extension=strtolower($Extension);

   if($Extension!="xls" && $Extension!="csv"){
       echo "FALSE";
       exit(1);
   }

   // Elimina
   $valor="";
   $NuevoNombreVacio="";
   for($i=0;$i<strlen($NuevoNombre);$i++){
       $valor=substr($NuevoNombre,$i,1);
	     if($valor!=" ") {
		      $NuevoNombreVacio=$NuevoNombreVacio .$valor;
	     }
   }
   $NuevoNombre=$NuevoNombreVacio;

   $l_Id=rand(1, 10000);

   $NuevoNombre=$l_Id . $NuevoNombre . "." .$Extension;

   //echo "Extension:" . $Extension;

   $Final=$target_path .$NuevoNombre;
 
   $target_path = $target_path . basename( $_FILES['txt_Archivo_Detalles1']['name']);
  
   if(move_uploaded_file($_FILES['txt_Archivo_Detalles1']['tmp_name'], $Final)) {
      echo $NuevoNombre;
   } else{
     echo "FALSE2";
   }
?>
