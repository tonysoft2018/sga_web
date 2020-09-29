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

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true);   
// ----------------------------------------------

// Creación del objeto de la clase heredada
// Extrea la info
$l_Archivo=0;
if(!empty($_GET)){
    if (isset($_GET['l_qr'])){
        $l_Archivo =$_GET['l_qr'];
  }
}

if(strlen($l_Archivo)>0){

    // Extrae la infor del archivo
    $pos=strpos($l_Archivo,"/");
    $ext1=substr($l_Archivo,$pos,strlen($l_Archivo));
     
    $pos1=strpos($ext1,"/");
    $pos1=$pos1+1;
    $ext2=substr($ext1,$pos1,strlen($ext1));
    
    $pos2=strpos($ext2,"/");
    $pos2=$pos2+1;
    $ext3=substr($ext2,$pos2,strlen($ext2));
    
    $pos4=strpos($ext3,".");
    $id=substr($ext3,0,$pos4);
    //echo "id:" .$id;

    // Buscar el packinglist 
    $l_Descripcion="";    
    $l_CodigoQR="";
    $l_Condicion="nIDPackingList_Deta=" .$id ." and bEstado=0";
    $tbl_Deta = new  cltbl_Packinglist_Deta_v2_0_0();
    $tbl_Deta->Inicializacion();
    $tbl_Deta->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Deta->Leer($l_Condicion);
    if($tbl_Deta->CualEsElNumeroDeRegistrosCargados()>0){
        $registros=$tbl_Deta->dtBase();
        $l_Descripcion=$registros[0]["Descripcion"];
        $l_CodigoQR=$registros[0]["CodigoQR"];
    }

 
    $pdf = new PDF();

    $pdf->l_Titulo1="";
    $pdf->l_Titulo2="";
    $pdf->l_Titulo3="";
    $pdf->l_Imagen=$l_Archivo;
   
    $pdf->l_bandFechaPieDePagina="NO";

  
    $tamaxopagina= array(150,150);
    $pdf->AliasNbPages();
    $pdf->AddPage("L",$tamaxopagina);
    $pdf->Image($l_Archivo,20,5,110,110);
 
    $pdf->Ln(75);  
    $pdf->SetFont('Times','B',18);
    //$pdf->Cell(125,10,"SEPARADOR DE ESPECIAS",0,0,"C");   
    $pdf->Cell(125,10,$l_Descripcion,0,0,"C");   
    $pdf->Ln(10);  
    $pdf->Cell(125,10,$l_CodigoQR,0,0,"C");   

    $pdf->Output();
} else {
   echo "<script>
          window.close();
        </script> ";
   exit(1);
}
 
 
?>
