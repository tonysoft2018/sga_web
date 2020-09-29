 <?php
// ----------------------------------------------------------------------------------
// inventarios_vistaprevia.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 25/03/2020
// ----------------------------------------------------------------------------------


//require('../fpdf181/fpdf.php');
require('../utilerias/code128.php');

include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php"; 
include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
include_once "../clases/packinglist.mysql.class_v2.0.0.php"; 
include_once "../clases/productos_series.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";

$UtileriasDatos = new clHerramientasv2011();
$l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
$l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);
 
// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true);   
// ----------------------------------------------

// Creación del objeto de la clase heredada
// Extrea la info
$l_Id=0;
if(!empty($_GET)){
    if (isset($_GET['l_id'])){
        $l_Id =$_GET['l_id'];
  }
}

if(strlen($l_Id)>0){
 
    // Buscar el packinglist 
    $l_nIDPackingList=0;
    $l_Folio=0;
    
    $l_Descripcion="";    
    $l_CodigoQR="";
    $l_nIDProducto=0;
    $l_Codigo_SAP="";
    $l_Cantidad=0;
    $l_Caja=0;
    $l_Pieza=0;
    $l_Cantidad=0;
    $l_CantidadCaja=0;

    $l_Condicion="nIDPackingList_Deta=" .$l_Id ." and bEstado=0";
    $tbl_Deta = new  cltbl_Packinglist_Deta_v2_0_0();
    $tbl_Deta->Inicializacion();
    $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Deta->Leer($l_Condicion);
    if($tbl_Deta->CualEsElNumeroDeRegistrosCargados()>0){
         
        $registros=$tbl_Deta->dtBase();
        $l_nIDPackingList=$registros[0]["nIDPackingList"];
        $l_nIDProducto=$registros[0]["nIDProducto"];        
        $l_Descripcion=$registros[0]["Descripcion"];
        $l_Cantidad=$registros[0]["Cantidad"];
    }

  
    if($l_nIDPackingList>0 && $l_nIDProducto>0 ){
        
        $l_Condicion="nIDProducto=" . $l_nIDProducto . " and nIDPackingList=" . $l_nIDPackingList; 
        //echo "Condicion:" .$l_Condicion;
        $tbl_Cat_Productos_Serie = new  cltbl_Cat_Productos_Series_v2_0_0();
        $tbl_Cat_Productos_Serie->Inicializacion();
        $tbl_Cat_Productos_Serie->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_Cat_Productos_Serie->Leer($l_Condicion);
        if($tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados()>0){
            $registros_serie=$tbl_Cat_Productos_Serie->dtBase();
 
       
            $pdf = new PDF_Code128();
			 
            $tamaxopagina= array(70,30);
            $pdf->AliasNbPages();
            
            for($j=0;$j<$tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados();$j=$j+1){
                $l_Serie=$registros_serie[$j]["Serie"];

                $pdf->AddPage("L",$tamaxopagina);
                $pdf->SetFont('Arial','',6);
                //$l_CodigoDeBarras=$l_nIDPackingList . "/" . $l_nIDProducto. "/". $l_Serie; 
                //$l_CodigoDeBarras=$l_nIDProducto ."/" . $l_Serie . "999"; 
				$l_CodigoDeBarras=$l_Serie;
                //$pdf->Code39(5,5,"*" . $l_CodigoDeBarras . "*",1,20,$l_Descripcion,$l_Cantidad);   
                $pdf->Code128(5,9,$l_CodigoDeBarras,60,15);
                $pdf->SetXY(5,5);
                $pdf->Write(0, $l_CodigoDeBarras);
                $pdf->Write(0, "," . $l_Descripcion . ", " . $l_Cantidad);
				
            }
            $pdf->Output(); 
                  
        }
    }  
} else {
   echo "<script>
          window.close();
        </script> ";
   exit(1);
}
 
 
?>
