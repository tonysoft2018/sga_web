<!DOCTYPE html>
<html>
    <?php
        // ----------------------------------------------------------------------------------
        // packinglist_editar.php
        // ----------------------------------------------------------------------------------
        // Autor. Ing. Antonio Barajas del Castillo
        // ----------------------------------------------------------------------------------
        // Empresa. Softernium SA de CV
        // ----------------------------------------------------------------------------------
        // Descripcion. Modulo para editar datos de un perfil.
        // ----------------------------------------------------------------------------------
        // Fecha Ultima Modificación
        // 25/03/2020
        // ----------------------------------------------------------------------------------
        // V2.0.0
        // ----------------------------------------------------------------------------------

        $l_Modulo="packinglist"; 
        $l_Accion="Crear";   //Listado/Crear/Editar/Eliminar/Consultar/Imprimir  

        include_once "../parametros/env.php";          
        include_once "../parametros/modulos.php";
    ?>
<head>    
    <title>
        <?php echo $TITULO ?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=dev-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie-edge">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

    <script type="text/javascript" src="../lib/jquery-3.3.1.slim.min.js"></script>
    <script type='text/javascript' src="../lib/jquery-1.8.3.min.js"></script>
    <script type='text/javascript' src="../lib/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="../lib/popper.min.js"></script>
    <script type="text/javascript" src="../lib/bootstrap.min.js"></script>

    <script>
        var CAMPO_ORDENAMIENTO="<?php echo $CAMPO_ORDENAMIENTO ?>";
        var FORMA_ORDENAMIENTO="<?php echo $FORMA_ORDENAMIENTOO ?>";
        var ULTIMA_CONSULTA="<?php echo $ULTIMA_CONSULTA ?>";

        var UBICACION_CONTROL="<?php echo $UBICACION_CONTROL ?>";

        var MODULO="<?php echo $l_Modulo ?>";
      
    </script>
    
    <!-- <script type="text/javascript" src="../js/ambiente_clasificaciones_deta_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/ambiente_clasificaciones_deta.vista.js"></script> -->
 
    <script type="text/javascript" src="../js/usuarios_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/usuarios.vista.js"></script>

    <script type="text/javascript" src="../js/cat_proveedores_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/cat_proveedores.vista.js"></script>

    <script type="text/javascript" src="../js/packinglist_deta_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/packinglist_deta.vista.js"></script>

    <script type="text/javascript" src="../js/packinglist_rest.ctrl.js"></script>
    <script type="text/javascript" src="../vistas/packinglist.vista.js"></script>
    
    <script type="text/javascript" src="../utilerias/utilerias.js"></script>
    
   
</head>

<body>
<?php
      
      include_once "../clases/clHerramientas_v2011.php"; 
      include_once "../clases/packinglist.mysql.class_v2.0.0.php"; 
      include_once "../clases/usuarios.mysql.class_v2.0.0.php"; 
      include_once "../bd/conexion.php";
      include "qrlib.php"; 

      $PNG_TEMP_DIR="../archivos/";
      $PNG_WEB_DIR="../archivos/";

      $filename = $PNG_TEMP_DIR.'test.png';
      
      $matrixPointSize = 10;
      $errorCorrectionLevel = 'L';

      $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';

      QRcode::png('información', $filename, $errorCorrectionLevel, $matrixPointSize, 2); 

     ?>
 
</body>
</html>