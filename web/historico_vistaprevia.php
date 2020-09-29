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
include_once "../clases/entradas.mysql.class_v2.0.0.php"; 
include_once "../clases/salidas.mysql.class_v2.0.0.php";  
include_once "../clases/cat_productos.mysql.class_v2.0.0.php"; 
include_once "../clases/ambiente_logo.mysql.class_v2.0.0.php";
include_once "../clases/cat_almacen.mysql.class_v2.0.0.php"; 
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
             $this->Image($this->l_Imagen,10,8,33);
         }
                 
         if(strlen($this->l_Titulo1)>0){
            $this->SetFont('Arial','B',16);
            $this->Cell(80);
            $this->Cell(30,10,$this->l_Titulo1,0,0,'C');
         }

         if(strlen($this->l_Titulo2)>0){
            $this->SetFont('Arial','B',14);
            $this->Ln(7);
            $this->Cell(80);         
            $this->Cell(30,10,$this->l_Titulo2,0,0,'C');
         }

         if(strlen($this->l_Titulo3)>0){
            $this->SetFont('Arial','B',12);
            $this->Ln(7);
            $this->Cell(80);
            $this->Cell(30,10,$this->l_Titulo3,0,0,'C');
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

     // Pie de página
     function Footer()
     {
         $UtileriasDatos = new clHerramientasv2011();
         $l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
         $l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);

         // Posición: a 1,5 cm del final
         $this->SetY(-15);
         // Arial italic 8
         $this->SetFont('Arial','I',8);
         // Número de página

         if($this->l_bandFechaPieDePagina=="SI"){
            $this->Cell(30,10,$l_FechaLocal,0,0,'C');
            $this->Cell(300,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
         } else {           
            $this->Cell(350,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
         }
         
     }
}

// ----------------------------------------------
// Conexion con la base de Datos
$l_Regreso=RegresaConexion();
$CONEXION=json_decode($l_Regreso,true);   
// ----------------------------------------------

$l_UBICACION="../adjuntos/";

$l_LOGOAPP="";
$l_Condicion="bEstado=0";
$tbl_logo = new  cltbl_Ambiente_Logo_v2_0_0();
$tbl_logo->Inicializacion();
$tbl_logo->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
$tbl_logo->Leer($l_Condicion);
if($tbl_logo->CualEsElNumeroDeRegistrosCargados()>0){
	$registros=$tbl_logo->dtBase();
	$l_LOGOAPP=$registros[0]["Logo"];
}  

 
// Creación del objeto de la clase heredada
// Extrea la info
$l_FechaInicio="";
$l_FechaFin="";
if(!empty($_GET)){
    if (isset($_GET['fechainicio'])){
        $l_FechaInicio =$_GET['fechainicio'];
    }
    if (isset($_GET['fechafin'])){
        $l_FechaFin =$_GET['fechafin'];
    }
}

$tbl_Entradas = new  cltbl_Entradas_v2_0_0();  
$tbl_Salidas = new  cltbl_Salidas_v2_0_0();
$tbl_Productos = new  cltbl_Cat_Productos_v2_0_0();
$tbl_Almacen = new  cltbl_Cat_Almacen_v2_0_0();
 
if(strlen($l_FechaInicio)<0){
    // No tiene id del almacen
    echo "<script>
        window.close();
    </script> ";
    exit(1);
}

if(strlen($l_FechaFin)<0){
    // No tiene id del almacen
    echo "<script>
        window.close();
    </script> ";
    exit(1);
}

$l_FechaInicio=$l_FechaInicio . " 00:00:01";
$l_FechaFin=$l_FechaFin . " 23:59:00";

 $l_Condicion="Fecha>='" . $l_FechaInicio . "' and Fecha<='" . $l_FechaFin ."'";


 if(strlen($l_Condicion)>0){

    $pdf = new PDF();

    $pdf->l_Titulo1="Reporte Historico de Productos";
    $pdf->l_Titulo2=$l_FechaInicio . " - " . $l_FechaFin;
    $pdf->l_Titulo3="";
    $pdf->l_Imagen=$l_UBICACION . $l_LOGOAPP;

    $pdf->l_bandFechaPieDePagina="SI";


    $l_nIDProducto=0;
    $l_Codigo="";
    $l_Producto="";
    $l_UnidadDeMedida="";

    
    $l_Almacen="";
    $l_Tipo="";


    $l_Entradas=0;
    $l_Salidas=0;
    $l_Existencias=0;

    //echo "Condicion: " .$l_Condicion;

    $tbl_Entradas->Inicializacion();
    $tbl_Entradas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Entradas->Leer($l_Condicion);
    if($tbl_Entradas->CualEsElNumeroDeRegistrosCargados()>0){

            $registros_entradas=$tbl_Entradas->dtBase();
   
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Times','',12);
   
            $pdf->Ln(10);  
            
            $pdf->Ln(5);    
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(34,3,"Almacen",0); 
            $pdf->Cell(40,3,"Tipo",0); 

            $pdf->Cell(20,3,"Codigo",0);        
            $pdf->Cell(60,3,"Producto",0);   
          
            $pdf->Cell(60,3,"Cantidad",0);     
            
            $pdf->SetDrawColor(128,0,0);
            $pdf->SetLineWidth(.3);

            for($j=0;$j<$tbl_Entradas->CualEsElNumeroDeRegistrosCargados();$j=$j+1){

                 // Datos de Entrada
                 $l_nIDProducto=$registros_entradas[$j]["nIDProducto"];
                 $l_Codigo="";
                 $l_Producto="";
                 $l_UnidadDeMedida="";  
                 
                 $l_Almacen="";
                 $l_Tipo="";
                 
                 $l_Entradas=$registros_entradas[$j]["Cantidad"];
                 $l_Tipo="ENTRADA-" . $registros_entradas[$j]["TipoEntrada"];
                 $l_Almacen=$registros_entradas[$j]["Almacen"];

                // Buscar datos del producto
                $l_Condicion_Producto="nIDProducto=" . $l_nIDProducto;
                $tbl_Productos->Inicializacion();
                $tbl_Productos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_Productos->Leer($l_Condicion_Producto);
                if($tbl_Productos->CualEsElNumeroDeRegistrosCargados()>0){
                    $registros_productos=$tbl_Productos->dtBase();

                    $l_Codigo=$registros_productos[0]["Codigo_IZeta"];
                    $l_Producto=$registros_productos[0]["Producto"];
                    $l_UnidadDeMedida=$registros_productos[0]["UnidadDeMedida"];
                }

               
                $pdf->Ln(5);    
                $pdf->SetFont('Arial','',6);
                $pdf->Cell(34,3,$l_Almacen,0);
                $pdf->Cell(40,3,$l_Tipo,0);
                $pdf->Cell(20,3,$l_Codigo,0);        
                $pdf->Cell(60,3,$l_Producto,0);                    
                $pdf->Cell(30,3,$l_Entradas,0);         
 
            }
    }

    //Salidas
    $tbl_Salidas->Inicializacion();
    $tbl_Salidas->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
    $tbl_Salidas->Leer($l_Condicion);
      if($tbl_Salidas->CualEsElNumeroDeRegistrosCargados()>0){

        $registros_entradas=$tbl_Salidas->dtBase();

        // Entradas
        for($j=0;$j<$tbl_Salidas->CualEsElNumeroDeRegistrosCargados();$j=$j+1){

            // Datos de Entrada
            $l_nIDProducto=$registros_entradas[$j]["nIDProducto"];
            $l_Codigo="";
            $l_Producto="";
            $l_UnidadDeMedida="";  
            
            $l_Almacen="";
            $l_Tipo="";
            
            $l_Salidas=$registros_entradas[$j]["Cantidad"];
            $l_Tipo="SALIDA-" . $registros_entradas[$j]["TipoSalida"];
            $l_Almacen=$registros_entradas[$j]["Almacen"];
           
            // Buscar datos del producto
            $l_Condicion_Producto="nIDProducto=" . $l_nIDProducto;
            $tbl_Productos->Inicializacion();
            $tbl_Productos->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_Productos->Leer($l_Condicion_Producto);
            if($tbl_Productos->CualEsElNumeroDeRegistrosCargados()>0){
                $registros_productos=$tbl_Productos->dtBase();

                $l_Codigo=$registros_productos[0]["Codigo_IZeta"];
                $l_Producto=$registros_productos[0]["Producto"];
                $l_UnidadDeMedida=$registros_productos[0]["UnidadDeMedida"];
            }

            $pdf->Ln(5);    
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(34,3,$l_Almacen,0);
            $pdf->Cell(40,3,$l_Tipo,0);
            $pdf->Cell(20,3,$l_Codigo,0);        
            $pdf->Cell(60,3,$l_Producto,0);                    
            $pdf->Cell(30,3,$l_Salidas,0);         
        }

    } 




  
    $pdf->Output();

}  

/*

 
// ---------------------------------------------- 
// Declaración de objetos
$tbl_Formato = new  cltbl_Formato_v2_0_0();
$tbl_Documento = new  cltbl_Documentos_v2_0_0();
$tbl_Documento_Captura = new  cltbl_Documentos_Captura_v2_0_0();
$tbl_Documento_Captura_Datos = new  cltbl_Documentos_Captura_Datos_v2_0_0();
// ---------------------------------------------- 

$l_nIDDocumento=0;
$l_Documento="";
$l_nIDFormato=0;
$l_Formato="";
$l_Folio=0;
$l_Fecha="";

if($l_nID_formulario>0){

    $tbl_Documento_Captura->DatosParaConectarse($l_DatosParaConexion_Servidor,$l_DatosParaConexion_Usuario,$l_DatosParaConexion_Password,$l_DatosParaConexion_BaseDatos);	 
    $tbl_Documento_Captura->Leer("bEstado=0 and nIDDocumento_Captura=" .$l_nID_formulario);   
    
    if($tbl_Documento_Captura->CualEsElNumeroDeRegistrosCargados()>0){
       
         $pdf = new PDF();
            
         $i=0;
                   
         $registros=$tbl_Documento_Captura->dtBase();

         $l_nIDDocumento=$registros[$i][$tbl_Documento_Captura->get_Estructura(1)];
         $l_Documento=$registros[$i][$tbl_Documento_Captura->get_Estructura(2)];
         $l_nIDFormato=$registros[$i][$tbl_Documento_Captura->get_Estructura(3)];
         $l_Formato=$registros[$i][$tbl_Documento_Captura->get_Estructura(4)];
         $l_Folio=$registros[$i][$tbl_Documento_Captura->get_Estructura(5)];
         $l_Fecha=$registros[$i][$tbl_Documento_Captura->get_Estructura(6)]; 
         
         $l_FechaModificacion=$registros[$i][$tbl_Documento_Captura->get_Estructura(11)]; 

        
         // Carga el encabezado del formato                
         $l_Formato="";			  
         $l_Descripcion="";			  
         $l_Titulo1="";
         $l_Titulo2="";			  
         $l_Titulo3="";
         $l_FechaPiePagina="";
         $l_Logo="";	
         $tbl_Formato->Inicializacion();
         $tbl_Formato->DatosParaConectarse($l_DatosParaConexion_Servidor,$l_DatosParaConexion_Usuario,$l_DatosParaConexion_Password,$l_DatosParaConexion_BaseDatos);	 
         $tbl_Formato->Leer("nIDFormato=" . $l_nIDFormato);
         if($tbl_Formato->CualEsElNumeroDeRegistrosCargados()>0){ 
             $registros=$tbl_Formato->dtBase();

             $i=0;

             $l_nIDFormato=$registros[$i][$tbl_Formato->get_Estructura(0)];
             $l_Folio=$registros[$i][$tbl_Formato->get_Estructura(1)];
             $l_Formato=utf8_encode($registros[$i][$tbl_Formato->get_Estructura(2)]);
             $l_Descripcion=utf8_encode($registros[$i][$tbl_Formato->get_Estructura(3)]);
             $l_Titulo1=utf8_encode($registros[$i][$tbl_Formato->get_Estructura(4)]);          
             $l_Titulo2=utf8_encode($registros[$i][$tbl_Formato->get_Estructura(5)]);
             $l_Titulo3=utf8_encode($registros[$i][$tbl_Formato->get_Estructura(6)]);
             $l_FechaPiePagina=utf8_encode($registros[$i][$tbl_Formato->get_Estructura(7)]);		 
             $l_Logo=utf8_encode($registros[$i][$tbl_Formato->get_Estructura(8)]);
             $l_Logo=trim($l_Logo);
             $l_LogoI=$l_Logo;
             if(strlen($l_Logo)>0){
                 $l_Logo=$l_Ubicacion . $l_Logo;
             }
         } 

         // Carga los campos
         $tbl_Formato_Configuracion = new  cltbl_formato_configuracion_v2_0_0();
         $tbl_Formato_Configuracion_Busqueda = new  cltbl_formato_configuracion_v2_0_0();
         $tbl_Formato_Configuracion->DatosParaConectarse($l_DatosParaConexion_Servidor,$l_DatosParaConexion_Usuario,$l_DatosParaConexion_Password,$l_DatosParaConexion_BaseDatos);
         $tbl_Formato_Configuracion->CampoDeOrdenamientoDeLaTabla("Fila,Columna");
         $l_Consulta="nIDFormato=" . $l_nIDFormato;
         $tbl_Formato_Configuracion->Leer($l_Consulta);
         if($tbl_Formato_Configuracion->CualEsElNumeroDeRegistrosCargados()<=0){ 
            echo "<script>
                     window.close();
                 </script> ";
                 exit(1);
         }       

         $pdf->l_Titulo1=$l_Titulo1;
         $pdf->l_Titulo2=$l_Titulo2;
         $pdf->l_Titulo3=$l_Titulo3;
         $pdf->l_Imagen=$l_Logo;

         $pdf->l_bandFechaPieDePagina=$l_FechaPiePagina;

         $pdf->AliasNbPages();
         $pdf->AddPage();
         $pdf->SetFont('Times','',12);

         $pdf->Ln(10);  
         $lineasEntre="Fecha Revision:" . substr($l_FechaModificacion,0,10);   
         $pdf->SetFont('Arial','B',10);                              
         $pdf->Cell(24,3,$lineasEntre,0);     
         $pdf->Ln(10);   

         // -------------------------------------------------------------------------------

         $LINEAS=array(0);	
         $cont_Lineas=0;

         $columnas=array(0);	
         $filas=array(0);	 
         $NIDS=array(0);
         $campos=array("");
          
         $cont_Columnas=count($columnas);
         $cont_Filas=count($filas); 
         $cont_NIDS=count($NIDS);
         $cont_Campos=0;
          
         $bandEncontrado=0;
         $bandEncontrado2=0;

         $posiciones[]=0;         
         $encabezados[]="";          
         $tamaxo[]=12;
         $ancho[]=0;
         $grueso[]="";
         $cont_Posicion=0;
         $INFERIOR[]=0;
         $TIPO[]="";

         $l_LineaAnterior=0;
         
         

         
         $registros=$tbl_Formato_Configuracion->dtBase();
         for($i=0;$i<$tbl_Formato_Configuracion->CualEsElNumeroDeRegistrosCargados();$i++){
         
             $bandEncontrado=0;
             for($j=0;$j<$cont_Filas;$j=$j+1){
                 if($filas[$j]==$registros[$i][$tbl_Formato_Configuracion->get_Estructura(5)]){
                     $bandEncontrado=1;
                     break;
                 }
             }
         
             if($bandEncontrado==0){
                 // No encontrado la fila de la configuración
                

                 // Extrae la fila
                 array_push($filas,$registros[$i][$tbl_Formato_Configuracion->get_Estructura(5)]);
                                  
                 // Busca la columna
                 for ($j=1;$j<13;$j=$j+1){
                     $bandEncontrado2=0;
         
                     for($k=0;$k<$tbl_Formato_Configuracion->CualEsElNumeroDeRegistrosCargados();$k++ ){    
                        

                         if($registros[$i][$tbl_Formato_Configuracion->get_Estructura(5)]==$registros[$k][$tbl_Formato_Configuracion->get_Estructura(5)]){ 
                             
                             // Busca la columna
                             if($j==$registros[$k][$tbl_Formato_Configuracion->get_Estructura(4)]){
                                 $bandEncontrado2=1;
                                 
                             
                                 // Verifica el tipo
                                 //echo "<BR> " . $registros[$k][$tbl_Formato_Configuracion->get_Estructura(3)];
                                 switch($registros[$k][$tbl_Formato_Configuracion->get_Estructura(3)]){                                                                    
                                     case "Grupo":      
                                                       $l_Posicion=4*$j;
                                                       $l_Posicion=$l_Posicion-4;

                                                       if($l_Posicion<=0){
                                                           $l_Posicion=1;
                                                       }

                                                       $posiciones[$cont_Posicion]=$registros[$k][$tbl_Formato_Configuracion->get_Estructura(4)];
                                                       $encabezados[$cont_Posicion]=$registros[$k][$tbl_Formato_Configuracion->get_Estructura(2)];
                                                       $ancho[$cont_Posicion]=strlen($registros[$k][$tbl_Formato_Configuracion->get_Estructura(2)]);
                                                       $grueso[$cont_Posicion]="B";
                                                       $tamaxo[$cont_Posicion]=8;
                                                       $INFERIOR[$cont_Posicion]=0;
                                                       $TIPO[$cont_Posicion]="GRUPO";
 
                                                       $cont_Posicion=$cont_Posicion+1;
                                                        
                                                       break;
                                      
                                     case "ETIQUETA":   
                                                      $l_Posicion=4*$j;
                                                      $l_Posicion=$l_Posicion-4;

                                                      if($l_Posicion<=0){
                                                          $l_Posicion=1;
                                                      }

                                                      $posiciones[$cont_Posicion]=$registros[$k][$tbl_Formato_Configuracion->get_Estructura(4)];
                                                      $encabezados[$cont_Posicion]=$registros[$k][$tbl_Formato_Configuracion->get_Estructura(2)];
                                                      $ancho[$cont_Posicion]=strlen($registros[$k][$tbl_Formato_Configuracion->get_Estructura(2)]);
                                                      $grueso[$cont_Posicion]="B";
                                                      $tamaxo[$cont_Posicion]=6;
                                                      $INFERIOR[$cont_Posicion]=1;
                                                      $TIPO[$cont_Posicion]="ETIQUETA";
 
                                                      $cont_Posicion=$cont_Posicion+1;
                                                    
                                                       break;
         
                                     case "CAMPO":   
                                                        
                                                       // Busca el valor
                                                       $l_Informacion="";
                                                       $l_nIDDocumento_Datos=0;
                                                       $tbl_Documento_Captura_Datos->Inicializacion();
                                                       $tbl_Documento_Captura_Datos->DatosParaConectarse($l_DatosParaConexion_Servidor,$l_DatosParaConexion_Usuario,$l_DatosParaConexion_Password,$l_DatosParaConexion_BaseDatos);
                                                       $l_Consulta="bEstado=0 and nIDDocumento_Captura=" .$l_nID_formulario . " and nIDFormato_Conf=" . $registros[$k][$tbl_Formato_Configuracion->get_Estructura(0)];
                                                       //echo "Consulta:" . $l_Consulta;
                                                       $tbl_Documento_Captura_Datos->Leer($l_Consulta); 
                                                       if($tbl_Documento_Captura_Datos->CualEsElNumeroDeRegistrosCargados()>0){ 
                                                         $registros_captura=$tbl_Documento_Captura_Datos->dtBase();
                                                         $l_Informacion=$registros_captura[0][$tbl_Documento_Captura_Datos->get_Estructura(13)];
                                                       } else {
                                                           //echo "No encontrado";
                                                       }

                                                       $l_Posicion=4*$j;
                                                       $l_Posicion=$l_Posicion-4;

                                                       if($l_Posicion<=0){
                                                          $l_Posicion=1;
                                                       }

                                                       $posiciones[$cont_Posicion]=$registros[$k][$tbl_Formato_Configuracion->get_Estructura(4)];
                                                       $encabezados[$cont_Posicion]=$l_Informacion;
                                                       $ancho[$cont_Posicion]=strlen($l_Informacion);
                                                       $grueso[$cont_Posicion]="";
                                                       $tamaxo[$cont_Posicion]=6;
                                                       $INFERIOR[$cont_Posicion]=1;
                                                       $TIPO[$cont_Posicion]="CAMPO";

                                                      
                                                       $cont_Posicion=$cont_Posicion+1;

                                                    
        
                                                       break;
         
                                 }                        
                                  
                                 break;
                             }                     
                         }
                     }
                      
                      if($bandEncontrado2==0){                             
                         
                     }             
                 }
             
                 $columna=1;
                 $bandEncontrado=0;
                 $posicionamiento=0;
                 $posicion[]=array(0,0,0,0,0,0,0,0,0);                                                  
                 $cont_Pos=0;
                 $posicion1=0;
                 $posicion2=0;
                 $posicion3=0;
                 $posicion4=0;
                 $posicion5=0;
                 $posicion6=0;
                 $posicion7=0;
                 $posicion8=0;

                $valor1="";
                $valor2="";
                $valor3="";
                $valor4="";
                $valor5="";
                $valor6="";
                $valor7="";
                $valor8="";

                $propiedad1="";
                $propiedad2="";
                $propiedad3="";
                $propiedad4="";
                $propiedad5="";
                $propiedad6="";
                $propiedad7="";
                $propiedad8="";

                $Tamaxos1=0;
                $Tamaxos2=0;
                $Tamaxos3=0;
                $Tamaxos4=0;
                $Tamaxos5=0;
                $Tamaxos6=0;
                $Tamaxos7=0;
                $Tamaxos8=0;

                $INFERIOR1=0;
                $INFERIOR2=0;
                $INFERIOR3=0;
                $INFERIOR4=0;
                $INFERIOR5=0;
                $INFERIOR6=0;
                $INFERIOR7=0;
                $INFERIOR8=0;

                $TIPO1="";
                $TIPO2="";
                $TIPO3="";
                $TIPO4="";
                $TIPO5="";
                $TIPO6="";
                $TIPO7="";
                $TIPO8="";    
                
                
                
                

                for($m=0;$m<$cont_Posicion;$m=$m+1){                   
                    $bandEncontrado=0;
                    
                    $posicionamiento=1;
                    for($n=0;$n<9;$n=$n+1){
                        
                        if($posiciones[$m]==$n){                           
                            $bandEncontrado=1;

                            switch($n){
                                case 1:  $posicion1=1;                                       
                                         $valor1=$encabezados[$m];
                                         $propiedad1=$grueso[$m];
                                         $Tamaxos1=$tamaxo[$m];
                                         $INFERIOR1=$INFERIOR[$m];
                                         $TIPO1=$TIPO[$m];
                                         break;
                                case 2:  $posicion2=1;
                                         $valor2=$encabezados[$m];
                                         $propiedad2=$grueso[$m];
                                         $Tamaxos2=$tamaxo[$m];
                                         $INFERIOR2=$INFERIOR[$m];
                                         $TIPO2=$TIPO[$m];
                                         break;
                                case 3:  $posicion3=1;
                                         $valor3=$encabezados[$m];
                                         $propiedad3=$grueso[$m];
                                         $Tamaxos3=$tamaxo[$m];
                                         $INFERIOR3=$INFERIOR[$m];
                                         $TIPO3=$TIPO[$m];
                                         break;
                                case 4:  $posicion4=1;
                                         $valor4=$encabezados[$m];
                                         $propiedad4=$grueso[$m];
                                         $Tamaxos4=$tamaxo[$m];
                                         $INFERIOR4=$INFERIOR[$m];
                                         $TIPO4=$TIPO[$m];
                                         break;
                                case 5:  $posicion5=1;
                                         $valor5=$encabezados[$m];
                                         $propiedad5=$grueso[$m];
                                         $Tamaxos5=$tamaxo[$m];
                                         $INFERIOR5=$INFERIOR[$m];
                                         $TIPO5=$TIPO[$m];
                                         break;
                                case 6:  $posicion6=1;
                                         $valor6=$encabezados[$m];
                                         $propiedad6=$grueso[$m];
                                         $Tamaxos6=$tamaxo[$m];
                                         $INFERIOR6=$INFERIOR[$m];
                                         $TIPO6=$TIPO[$m];
                                         break;
                                case 7:  $posicion7=1;
                                         $valor7=$encabezados[$m];
                                         $propiedad7=$grueso[$m];
                                         $Tamaxos7=$tamaxo[$m];
                                         $INFERIOR7=$INFERIOR[$m];
                                         $TIPO7=$TIPO[$m];
                                         break;
                                case 8:  $posicion8=1;
                                         $valor8=$encabezados[$m];
                                         $propiedad8=$grueso[$m];
                                         $Tamaxos8=$tamaxo[$m];
                                         $INFERIOR8=$INFERIOR[$m];
                                         $TIPO8=$TIPO[$m];
                                         break;
                            }
 
                            break;
                        } else {
                            $posicionamiento=$posicionamiento+24;
                        }
                    }
                 }

                 $lineasEntre=$registros[$i][$tbl_Formato_Configuracion->get_Estructura(5)] - $l_LineaAnterior;
                 //echo "LineaEntre:" . $lineasEntre;
                 $l_LineaAnterior=$registros[$i][$tbl_Formato_Configuracion->get_Estructura(5)];

                 if($lineasEntre>1){
                     for($x=0;$x<$lineasEntre;$x=$x+1){
                         //echo "<br> Linea:" . $x;
                         $pdf->Ln(10);    
                     }
                 }
 

                 // Definir la linea
                 $BANDERA_LINEA_GRUPO=0;
                 if($TIPO1=="GRUPO" || $TIPO2=="GRUPO" || $TIPO3=="GRUPO" || $TIPO4=="GRUPO" || $TIPO5=="GRUPO" || $TIPO6=="GRUPO" || $TIPO7=="GRUPO" || $TIPO8=="GRUPO" ){
                    $BANDERA_LINEA_GRUPO=1;
                 }

                 $BANDERA_LINEA_ETIQUETA=0;
                 if($TIPO1=="ETIQUETA" || $TIPO2=="ETIQUETA" || $TIPO3=="ETIQUETA" || $TIPO4=="ETIQUETA" || $TIPO5=="ETIQUETA" || $TIPO6=="ETIQUETA" || $TIPO7=="ETIQUETA" || $TIPO8=="ETIQUETA" ){
                     $BANDERA_LINEA_ETIQUETA=1;
                 }

 
                if($posicion1==1){
                    $pdf->SetFont('Arial',$propiedad1,$Tamaxos1);          
                  
                   if($BANDERA_LINEA_GRUPO==0){
                      if($BANDERA_LINEA_ETIQUETA==0){
                         if($INFERIOR1==1){
                            $pdf->Cell(24,3,$valor1,'B');     
                         } else {
                            $pdf->Cell(24,3,$valor1,0);     
                         }
                      } else {
                         $pdf->Cell(24,3,$valor1,'B');     
                      }                       
                   } else {
                      $pdf->Cell(24,3,$valor1,0);     
                   } 
                  
               } else {
                    if($BANDERA_LINEA_GRUPO==0){
                      if($BANDERA_LINEA_ETIQUETA==0){
                         if($INFERIOR1==1){
                            $pdf->Cell(24,3,"",'B');    
                         } else {
                            $pdf->Cell(24,3,"",0);    
                         }                    
                      } else {
                         $pdf->Cell(24,3,"",'B');    
                      }                        
                   } else {
                      $pdf->Cell(24,3,"",0);    
                   }
               }

 
                if($posicion2==1){
                    $pdf->SetFont('Arial',$propiedad2,$Tamaxos2);

                    if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR2==1){
                              $pdf->Cell(24,3,$valor2,'B');     
                           } else {
                              $pdf->Cell(24,3,$valor2,0);     
                           }                    
                        } else {
                           $pdf->Cell(24,3,$valor2,'B');     
                        }                        
                    } else {
                        $pdf->Cell(24,3,$valor2,0);     
                    }
                 } else {
                     if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR2==1){
                              $pdf->Cell(24,3,"",'B'); 
                           } else {
                              $pdf->Cell(24,3,"",0); 
                           }
                        } else {
                           $pdf->Cell(24,3,"",'B'); 
                        }                        
                     } else {
                        $pdf->Cell(24,3,"",0); 
                     }                      
                 }

 
                if($posicion3==1){
                    $pdf->SetFont('Arial',$propiedad3,$Tamaxos3);
                    if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR3==1){
                              $pdf->Cell(24,3,$valor3,'B');     
                           } else {
                              $pdf->Cell(24,3,$valor3,0);     
                           }
                        } else {
                           $pdf->Cell(24,3,$valor3,'B');     
                        }                        
                    } else {
                        $pdf->Cell(24,3,$valor3,0);  
                    }
                 } else {
                     if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR3==1){
                              $pdf->Cell(24,3,"",'B'); 
                           } else {
                              $pdf->Cell(24,3,"",0); 
                           }
                        } else {
                           $pdf->Cell(24,3,"",'B'); 
                        }                        
                     } else {
                        $pdf->Cell(24,3,"",0); 
                     }
                    
                 }

 
                if($posicion4==1){
                    $pdf->SetFont('Arial',$propiedad4,$Tamaxos4);

                    if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR4==1){
                              $pdf->Cell(24,3,$valor4,'B');     
                           } else {
                              $pdf->Cell(24,3,$valor4,0);     
                           }
                        } else {
                           $pdf->Cell(24,3,$valor4,'B');     
                        }                        
                    } else {
                        $pdf->Cell(24,3,$valor4,0);     
                    }
                 } else {
                     if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR4==1){
                              $pdf->Cell(24,3,"",'B'); 
                           } else {
                              $pdf->Cell(24,3,"",0); 
                           }
                        } else {
                           $pdf->Cell(24,3,"",'B'); 
                        }                        
                     } else {
                        $pdf->Cell(24,3,"",0); 
                     }                     
                 }
 
                if($posicion5==1){
                    $pdf->SetFont('Arial',$propiedad5,$Tamaxos5);
                    if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR5==1){
                              $pdf->Cell(24,3,$valor5,'B');     
                           } else {
                              $pdf->Cell(24,3,$valor5,0);     
                           }                     
                        } else {
                           $pdf->Cell(24,3,$valor5,'B');     
                        }                        
                    } else {
                        $pdf->Cell(24,3,$valor5,0);     
                    }                    
                 } else {
                     if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR5==1){
                              $pdf->Cell(24,3,"",'B'); 
                           } else {
                              $pdf->Cell(24,3,"",0); 
                           }
                        } else {
                           $pdf->Cell(24,3,"",'B'); 
                        }                        
                     } else {
                        $pdf->Cell(24,3,"",0); 
                     }                    
                 }

 

                if($posicion6==1){
                    $pdf->SetFont('Arial',$propiedad6,$Tamaxos6);
                    if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR6==1){
                              $pdf->Cell(24,3,$valor6,'B');     
                           } else {
                              $pdf->Cell(24,3,$valor6,0);     
                           }
                        } else {
                           $pdf->Cell(24,3,$valor6,'B');     
                        }                        
                    } else {
                        $pdf->Cell(24,3,$valor6,0);     
                    }
                 } else {
                     if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR6==1){
                              $pdf->Cell(24,3,"",'B'); 
                           } else {
                              $pdf->Cell(24,3,"",0); 
                           }                    
                        } else {
                           $pdf->Cell(24,3,"",'B'); 
                        }                        
                     } else {
                        $pdf->Cell(24,3,"",0); 
                     }
                 }

 
                if($posicion7==1){
                    $pdf->SetFont('Arial',$propiedad7,$Tamaxos7);

                    if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR7==1){
                              $pdf->Cell(24,3,$valor7,'B');     
                           } else {
                              $pdf->Cell(24,3,$valor7,0);       
                           }
                        } else {
                           $pdf->Cell(24,3,$valor7,'B');     
                        }                        
                    } else {
                        $pdf->Cell(24,3,$valor7,0);  
                    }                    
                 } else {
                     if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR7==1){
                              $pdf->Cell(24,3,"",'B'); 
                           } else {
                              $pdf->Cell(24,3,"",0); 
                           }                    
                        } else {
                           $pdf->Cell(24,3,"",'B'); 
                        }                        
                     } else {
                        $pdf->Cell(24,3,"",0); 
                     }                      
                 }

 

                if($posicion8==1){
                    $pdf->SetFont('Arial',$propiedad8,$Tamaxos8);

                    if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR8==1){
                              $pdf->Cell(24,3,$valor8,'B');     
                           } else {
                              $pdf->Cell(24,3,$valor8,0);   
                           }                    
                        } else {
                           $pdf->Cell(24,3,$valor8,'B');     
                        }                        
                    } else {
                        $pdf->Cell(24,3,$valor8,0);   
                    }                    
                 } else {
                     if($BANDERA_LINEA_GRUPO==0){
                        if($BANDERA_LINEA_ETIQUETA==0){
                           if($INFERIOR8==1){
                              $pdf->Cell(24,3,"",'B'); 
                           } else {
                              $pdf->Cell(24,3,"",0);
                           }                    
                        } else {
                           $pdf->Cell(24,3,"",'B'); 
                        }                        
                     } else {
                        $pdf->Cell(24,3,"",0);
                     }                     
                 }





                 $pdf->Ln(5);    
                 

 
                  
                 $cont_Posicion=0;
                   
         
                 // Aumenta el numero de filas.
                 $cont_Filas=$cont_Filas+1;
              }     
         }

         // -------------------------------------------------------------------------------
         
         
  
         $pdf->Output();
   

    } 
}
*/
?>