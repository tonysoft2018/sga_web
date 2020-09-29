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


require('../fpdf181/fpdf.php');
include_once "../clases/clHerramientas_v2011.php"; 
include_once "../clases/packinglist_deta.mysql.class_v2.0.0.php"; 
include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
include_once "../clases/packinglist.mysql.class_v2.0.0.php"; 
include_once "../clases/productos_series.mysql.class_v2.0.0.php"; 
include_once "../bd/conexion.php";

$UtileriasDatos = new clHerramientasv2011();
$l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
$l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);

class PDF extends FPDF
{     
     public $l_Titulo1;
     public $l_Titulo2;
     public $l_Titulo3;
     public $l_Imagen;
     public $l_bandFechaPieDePagina;
     protected $col = 0;

     // Cabecera de página
     function Header()
     {
         
         // Logo
         if(strlen($this->l_Imagen)>0){
            // $this->Image($this->l_Imagen,10,8,33);
         }
                          
         // Salto de línea
         $this->Ln(20);
      
     }

     function SetCol($col)
     {
          // Establecer la posición de una columna dada
         $this->col = $col;
         $x = 90+$col*0;
         $this->SetLeftMargin($x);
         $this->SetX($col);
    }
    
}

class PDF_Code39 extends FPDF
{
function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5, $datos, $l_Cantidad){

    $wide = $baseline;
    $narrow = $baseline / 3 ; 
    $gap = $narrow;

    $barChar['0'] = 'nnnwwnwnn';
    $barChar['1'] = 'wnnwnnnnw';
    $barChar['2'] = 'nnwwnnnnw';
    $barChar['3'] = 'wnwwnnnnn';
    $barChar['4'] = 'nnnwwnnnw';
    $barChar['5'] = 'wnnwwnnnn';
    $barChar['6'] = 'nnwwwnnnn';
    $barChar['7'] = 'nnnwnnwnw';
    $barChar['8'] = 'wnnwnnwnn';
    $barChar['9'] = 'nnwwnnwnn';
    $barChar['A'] = 'wnnnnwnnw';
    $barChar['B'] = 'nnwnnwnnw';
    $barChar['C'] = 'wnwnnwnnn';
    $barChar['D'] = 'nnnnwwnnw';
    $barChar['E'] = 'wnnnwwnnn';
    $barChar['F'] = 'nnwnwwnnn';
    $barChar['G'] = 'nnnnnwwnw';
    $barChar['H'] = 'wnnnnwwnn';
    $barChar['I'] = 'nnwnnwwnn';
    $barChar['J'] = 'nnnnwwwnn';
    $barChar['K'] = 'wnnnnnnww';
    $barChar['L'] = 'nnwnnnnww';
    $barChar['M'] = 'wnwnnnnwn';
    $barChar['N'] = 'nnnnwnnww';
    $barChar['O'] = 'wnnnwnnwn'; 
    $barChar['P'] = 'nnwnwnnwn';
    $barChar['Q'] = 'nnnnnnwww';
    $barChar['R'] = 'wnnnnnwwn';
    $barChar['S'] = 'nnwnnnwwn';
    $barChar['T'] = 'nnnnwnwwn';
    $barChar['U'] = 'wwnnnnnnw';
    $barChar['V'] = 'nwwnnnnnw';
    $barChar['W'] = 'wwwnnnnnn';
    $barChar['X'] = 'nwnnwnnnw';
    $barChar['Y'] = 'wwnnwnnnn';
    $barChar['Z'] = 'nwwnwnnnn';
    $barChar['-'] = 'nwnnnnwnw';
    $barChar['.'] = 'wwnnnnwnn';
    $barChar[' '] = 'nwwnnnwnn';
    $barChar['*'] = 'nwnnwnwnn';
    $barChar['$'] = 'nwnwnwnnn';
    $barChar['/'] = 'nwnwnnnwn';
    $barChar['+'] = 'nwnnnwnwn';
    $barChar['%'] = 'nnnwnwnwn';

    $this->SetFont('Arial','',6);
    $this->Text($xpos, $ypos + $height, $code);
    $this->Text($xpos, $ypos + $height + 2, $datos . "," . $l_Cantidad);
    $this->SetFillColor(0);

    $code = '*'.strtoupper($code).'*';
    for($i=0; $i<strlen($code); $i++){
        $char = $code[$i];
        if(!isset($barChar[$char])){
            $this->Error('Invalid character in barcode: '.$char);
        }
        $seq = $barChar[$char];
        for($bar=0; $bar<7; $bar++){
            if($seq[$bar] == 'n'){
                $lineWidth = $narrow;
            }else{
                $lineWidth = $wide;
            }
            if($bar % 2 == 0){
                $this->Rect($xpos, $ypos, $lineWidth, $height-5, 'F');
            }
            $xpos += $lineWidth;
        }
        $xpos += $gap;
    }
}
}
 

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
 
            $pdf = new PDF_CODE39();
			 
            $tamaxopagina= array(90,30);
            $pdf->AliasNbPages();
            
            for($j=0;$j<$tbl_Cat_Productos_Serie->CualEsElNumeroDeRegistrosCargados();$j=$j+1){
                $l_Serie=$registros_serie[$j]["Serie"];

                $pdf->AddPage("L",$tamaxopagina);
                $pdf->SetFont('Times','B',12);
                $l_CodigoDeBarras=$l_nIDPackingList . "/" . $l_nIDProducto. "/". $l_Serie; 
				$l_CodigoDeBarras=$l_nIDPackingList;
                $pdf->Code39(5,5,"*" . $l_CodigoDeBarras . "*",1,20,$l_Descripcion,$l_Cantidad);   
				
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
