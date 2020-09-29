<?php
// ----------------------------------------------------------------------------------
// ambiente_imagenapp.mysql.class.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV
// ----------------------------------------------------------------------------------
// Descripcion. Almacena los datos de los centros de servicio 
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 12/12/2019
// ----------------------------------------------------------------------------------
// V2.0.0
// ----------------------------------------------------------------------------------

// Clases que manejo de las campanas
include_once "clHerramientas_v2011.php";

class cltbl_Ambiente_ImagenApp_v2_0_0
{
 
	 // --------------------------------------------------------
	 // Constantes
     // Generales
     private $Ascendente="Ascendente";
	 private $Descendente="Descendente";
	 private $TiempoMaximo=2000;
	 private $Tamaxo=1000000;


	 // Base de datos
	 private $NombreDeLaTabla = "tbl_ambiente_imagenapp";
     private $NombreDeLaVista = "tbl_ambiente_imagenapp";
     private $NombreCampoLlave ="nIDImagenApp";
	 private $NombreCampoOrdenamiento="nIDImagenApp";
	 private $NombreCampoParaNoRepetir="Imagen";
	 private $TipoDatoCampoParaNoRepetir="CADENA"; //CADENA,FECHA,NUMERO
	 private $Ordenamiento="Descendente";
     private $LimiteInferior=-1;
     private $LimiteSuperior=-1;
	 // --------------------------------------------------------

	 // --------------------------------------------------------
	 // Atributos
	 // Generales
	 private $contNumDatos=0;
	 private $servidor;
	 private $usuario;
	 private $password;
	 private $basededatos;

	 private $dt;
	 private $dtgrabar;

	 public $estructura;
	 public $tipos;
	 public $campos_obligatorios=array();
	 public $campos_obligatorios_tipo=array();
	 public $campos_obligatorios_leyendas=array();
	 public $campos_obligatorios_rango1=array();
	 public $campos_obligatorios_rango2=array();
	 public $campos_obligatorios_comparativa1=array();
	 public $campos_obligatorios_comparativa2=array();
	 public $campos_obligatorios_mostrarleyenda=array();
	 public $campos_obligatorios_valorescomparar1=array();
	 public $campos_obligatorios_valorescomparar2=array();
	 public $campos_listado=array();
	 public $campos_busqueda=array();
	 public $campos_busqueda_tipo=array();
	 public $campos_especiales=array();
	 public $campos_especiales_tipo=array(); //CHEKCBOX, RADIOBUTTON, IMAGEN
	 public $campos_combo=array();
	 private $contCampos;
	  
	 // Estados
	 private $bandTieneAlgunError=FALSE;
	 private $bandTieneDatosCargados=FALSE;
     private $bandTieneDatosParaConectarse=FALSE;

	 // Mensajes
 
	 // --------------------------------------------------------
	 // Propiedades
	 public function DatosParaConectarse($servidor, $usuario, $password, $basededatos){
	   $this->servidor=$servidor;
	   $this->usuario=$usuario;
	   $this->password=$password;
	   $this->basededatos=$basededatos;

       $this-->$bandTieneDatosParaConectarse=TRUE;
	 }

	 public function setInformacion_Leer($registro) {

		if($this->contCampos<=0){
			$this->contNumDatos=0;
			unset($this->dtgrabar);
			$this->CargarCampos("LEER");
		}

		if($this->contCampos<=0){
			$this->contNumDatos=0;
			unset($this->dtgrabar);

			$this->bandTieneAlgunError=TRUE;
		    $this->ErrorActual="No tiene una SCHEMA cargado";       
		    return FALSE;
		}


		for($i=0;$i<$this->contCampos;$i=$i+1){			
			$this->dtGrabar[$this->contNumDatos][$this->estructura[$i]]=$registro[$i];			 
		}
			
		$this->contNumDatos=$this->contNumDatos+1;
		$this->bandTieneDatosCargados=TRUE; 
 
		return TRUE;
	 }

	 public function setInformacion_Grabar($registro) {

		if($this->contCampos<=0){
			$this->contNumDatos=0;
			unset($this->dtgrabar);
			$this->CargarCampos("GRABAR");
		}

		if($this->contCampos<=0){
			$this->contNumDatos=0;
			unset($this->dtgrabar);

			$this->bandTieneAlgunError=TRUE;
		    $this->ErrorActual="No tiene una SCHEMA cargado";       
		    return FALSE;
		}


		for($i=0;$i<$this->contCampos;$i=$i+1){					 
			$this->dtGrabar[$this->contNumDatos][$this->estructura[$i]]=$registro[$i];			 
		}
			
		$this->contNumDatos=$this->contNumDatos+1;
		$this->bandTieneDatosCargados=TRUE;

		return TRUE;
	 }


	 public function CampoDeOrdenamientoDeLaTabla($Campos){
		$this->NombreCampoOrdenamiento=$Campos;
	 }

	 public function FormaDeOrdenamiento($Forma){
		$this->Ordenamiento=$Forma;
	 }

	 public function dtBase(){
		return $this->dtGrabar;
	 }

	 // FAQ
	 public function CualEsElMensajeDeErrordelObjeto(){
		if($this->bandTieneAlgunError==TRUE){
			return $this->ErrorActual;
		} else {
			return "No tiene";
		}
	 }

	 public function CualEsElNumeroDeRegistrosCargados(){
		return $this->contNumDatos;
	 }

	 public function CualEsLaFormaDeOrdenamiento(){		 
		return $this->Ordenamiento;
	 } 

	 public function setLimiteInferior($Limite){
		$this->LimiteInferior=$Limite;
	 }

	 public function setLimiteSuperior($Limite){
		$this->LimiteSuperior=$Limite;
	 }

	 public function get_Estructura($indice){
		 return $this->estructura[$indice];
	 }

	 public function get_NumCampos(){
		 return $this->contCampos;
	 }

	 public function get_CampoLlave(){

		return $this->NombreCampoLlave;
	 }

	 public function get_CampoIrrepetible(){
		return $this->NombreCampoParaNoRepetir;
	 }

	 public function get_TipoDatoIrrepetible(){
		return $this->TipoDatoCampoParaNoRepetir;
	 }
	 
	 // --------------------------------------------------------

	 // --------------------------------------------------------
	 // CONSTRUCTORES
	 function __construct() {
		$this->Inicializacion();
     }
	 // --------------------------------------------------------

	 // --------------------------------------------------------
	 // INICIALIZACION
	 public function Inicializacion(){
		$this->InicializaAtributos();
		$this->InicializacionContenido();
		$this->Cargar_Campos_Obligatorios();
		$this->Cargar_Campos_Listado();
		$this->Cargar_Campos_Busqueda();
		$this->Cargar_Campos_Especiales();
		$this->Cargar_Campos_Combo();
	 }

	 private function InicializaAtributos(){
		$this->bandTieneAlgunError=FALSE;
		$this->bandTieneDatosCargados=FALSE;
		$this->bandTieneDatosParaConectarse=FALSE;

		$this->ErrorActual="No tiene";
		$this->Ordenamiento=$this->Ascendente;

		$this->contNumDatos=0;	
		
		$this->contCampos=0;
	 }

	 public function InicializacionContenido(){
		$this->contNumDatos=0;
		$this->bandTieneAlgunError=FALSE;
	 }

	 public function Cargar_Campos_Obligatorios(){	 
		//** CAMPOS */
		unset($this->campos_obligatorios);
		$this->campos_obligatorios=array();
		array_push($this->campos_obligatorios,"Imagen");		 
		 
		//** TIPOS */		
		unset($this->campos_obligatorios_tipo);
		$this->campos_obligatorios_tipo=array();
		array_push($this->campos_obligatorios_tipo,"CADENA"); // CADENA/NUMERO/FECHA
		 
		//** RANGO INICIAL */		
		unset($this->campos_obligatorios_rango1);
		$this->campos_obligatorios_rango1=array();
		array_push($this->campos_obligatorios_rango1,"");  
	  
		//** COMPARATIVA INICIAL */				
		unset($this->campos_obligatorios_comparativa1);
		$this->campos_obligatorios_comparativa1=array();
		array_push($this->campos_obligatorios_comparativa1,"SIN COMPARAR");   // SIN COMPARAR, IGUAL, MAYOR, MENOR, MAYORIGUAL, MENORIGUAL, COMPARADOCON
		  
		//** RANGO FINAL */		
		unset($this->campos_obligatorios_rango2);
		$this->campos_obligatorios_rango2=array();
		array_push($this->campos_obligatorios_rango2,"");  
	  
		//** COMPARATIVA FINAL */		
		unset($this->campos_obligatorios_comparativa2);
		$this->campos_obligatorios_comparativa2=array();
		array_push($this->campos_obligatorios_comparativa2,"SIN COMPARAR");   // SIN COMPARAR, IGUAL, MAYOR, MENOR, MAYORIGUAL, MENORIGUAL, COMPARADO CON
	 	 
		//**LEYENDAS */
		unset($this->campos_obligatorios_leyendas);
		$this->campos_obligatorios_leyendas=array();			 
		array_push($this->campos_obligatorios_leyendas,"Banner de la App"); 
		 
		//**REGLAS DE LEYENDAS */
		unset($this->campos_obligatorios_mostrarleyenda);
		$this->campos_obligatorios_mostrarleyenda=array();			 
		array_push($this->campos_obligatorios_mostrarleyenda,"SI");  // SI,NO
	  
		
		//**VALORES DEFINIDOS DE COMPARACION1 */
		unset($this->campos_obligatorios_valorescomparar1);
		$this->campos_obligatorios_valorescomparar1=array();			 
		array_push($this->campos_obligatorios_valorescomparar1,"");  // SI,NO
	  
		//**VALORES DEFINIDOS DE COMPARACION2 */
		unset($this->campos_obligatorios_valorescomparar2);
		$this->campos_obligatorios_valorescomparar2=array();			 
		array_push($this->campos_obligatorios_valorescomparar2,"");  // SI,NO
	 }


	 public function Cargar_Campos_Listado(){	 
		unset($this->campos_listado);
		$this->campos_listado=array();
			 		 		 
		array_push($this->campos_listado,$this->NombreCampoLlave);	 
	 }

	 public function Cargar_Campos_Busqueda(){	 
		unset($this->campos_busqueda);
		$this->campos_busqueda=array();
  
		unset($this->campos_busqueda_tipo);
		$this->campos_busqueda_tipo=array();
		
	 

	 }

	 public function Cargar_Campos_Especiales(){	 
		unset($this->campos_especiales);
		$this->campos_especiales=array();
 
		//array_push($this->campos_especiales,"Activo");

		unset($this->campos_especiales_tipo);
		$this->campos_especiales_tipo=array();
		
		//array_push($this->campos_especiales_tipo,"CHEKCBOX"); //CHEKCBOX, RADIOBUTTON, IMAGEN
	 }

	 public function Cargar_Campos_Combo(){	 
		unset($this->campos_combo);
		$this->campos_combo=array();
		
		array_push($this->campos_combo,$this->NombreCampoLlave);	 		 	 
	 }
	 // --------------------------------------------------------

	 // --------------------------------------------------------
	 // ACTIVIDADES
	 // --------------------------------------------------------

	 // --------------------------------------------------------
	 // MISCELANEO
	 private function vEstado($lbEstado, $l_NombreCampo){
         // Bandera que indica el estado del registro 0-Activo, 1-Eliminado, 2-Cancelado, 3-Cerrado/Finalizado, -1 No definido

         $Cadena="";
	     switch($lbEstado){
		     case 0: // Activo
		         $Cadena="Activo";
		          break;
		     case 1: // Eliminado
		         $Cadena="Eliminado";
		         break;
		     case 2: // Cancelado
		         $Cadena = "Cancelado";
				 break;
		     case 3: // Cerrado/Finalizo
		         $Cadena = "Cerrado/Finalizado";
		         break;
		     default: // Otro
		         $Cadena = "No definido";
				 break;
	      }

	  return $Cadena;
	 }

     public function CONVERTIR_ESPECIALES_HTML($str){
       $str=trim($str);
       $str = mb_convert_encoding($str,  'UTF-8');
       return $str;
     }
	 // --------------------------------------------------------

	 // --------------------------------------------------------
	 // CONSULTAR
	 private function Consultar($condicion){
		// Abrea la conexion         
        $mysqli=mysqli_connect($this->servidor,$this->usuario,$this->password,$this->basededatos);
         
		if(mysqli_connect_errno()){
		   $this->bandTieneAlgunError=TRUE;
		   $this->ErrorActual="Error No se puede conectar a la base de datos";       
		   return FALSE;
		}

		$txtConsulta="";
		$txtConsulta = "SELECT *";
		$txtConsulta = $txtConsulta . " FROM ";
		$txtConsulta = $txtConsulta . $this->NombreDeLaVista;
		$txtConsulta = $txtConsulta . " WHERE ";
		$txtConsulta = $txtConsulta . $condicion;
		$txtConsulta = $txtConsulta . " ORDER BY " . $this->NombreCampoOrdenamiento;

 

		if($this->CualEsLaFormaDeOrdenamiento()==$this->Ascendente){
		   $txtConsulta=$txtConsulta . " ASC";
		} else {
			 $txtConsulta=$txtConsulta . " DESC";
		}

		if($this->LimiteInferior>=0){
			$txtConsulta = $txtConsulta . " LIMIT " . $this->LimiteInferior . "," . $this->LimiteSuperior;
		}

		 //echo "Consulta:" . $txtConsulta;
 
		//' Ejecuta la consulta
		$res=mysqli_query($mysqli,$txtConsulta);

		// Cargar la informacion
		$contador=0;

		// Inicia los datos
		$this->contNumDatos=0;
		unset($this->dtgrabar);

		if($this->contCampos<=0){
			$this->contNumDatos=0;
			unset($this->dtgrabar);
			$this->CargarCampos("LEER");
		}
 
		if($res){
			 
			while($registro=mysqli_fetch_array($res, MYSQLI_ASSOC)){
				$l_Registros=array();
				 
				for($i=0;$i<$this->contCampos;$i=$i+1){					
					 $l_Valor=$registro[$this->estructura[$i]];
					 //echo "<br> Valor:" . $l_Valor;

					 switch($this->tipos[$i]){
						case "CADENA": $l_Valor=stripslashes($l_Valor);		
						               $l_Valor=trim($l_Valor);		
						               $l_Valor=$this->CONVERTIR_ESPECIALES_HTML($l_Valor);			                					 
						               array_push($l_Registros,$l_Valor);
						               break;
						case "FECHA":  $l_Valor=stripslashes($l_Valor);	
						               $l_Valor=trim($l_Valor);	
						               array_push($l_Registros,$l_Valor);					                
						               break;
						case "NUMERO": array_push($l_Registros,$l_Valor);	                
									   break;
									   
						case "DECIMAL": array_push($l_Registros,$l_Valor);	                
									    break;			   			   
					 }

					 
					if(($this->contCampos-1)==$i){
						array_push($l_Registros,0);
					} else {
						if(($this->contCampos-2)==$i){
							array_push($l_Registros,1);
						} else {
							if(($this->contCampos-3)==$i){
								array_push($l_Registros,0);
							}
						}
					}
					
				}

				//print_r($l_Registros);
			             
				$this->setInformacion_Leer($l_Registros);

				unset($l_Registros);				  			 
			}  
	   } else {
           $this->bandTieneDatosCargados=FALSE;
            
	   }

	   mysqli_close($mysqli);
	   return TRUE;
    }
    
    private function Consultar_Directa($consulta){
		// Abrea la conexion         
		$mysqli=mysqli_connect($this->servidor,$this->usuario,$this->password,$this->basededatos);

		if(mysqli_connect_errno()){
		   $this->bandTieneAlgunError=TRUE;
		   $this->ErrorActual="Error No se puede conectar a la base de datos";       
		   return FALSE;
		}

		$txtConsulta=$consulta;		 
 
		//' Ejecuta la consulta
		$res=mysqli_query($mysqli,$txtConsulta);

		// Cargar la informacion
		$contador=0;

		// Inicia los datos
		$this->contNumDatos=0;
		unset($this->dtgrabar);

		if($this->contCampos<=0){
			$this->contNumDatos=0;
			unset($this->dtgrabar);
			$this->CargarCampos("LEER");
		}
 
		if($res){
			 
			while($registro=mysqli_fetch_array($res, MYSQLI_ASSOC)){
				$l_Registros=array();
				 
				for($i=0;$i<$this->contCampos;$i=$i+1){					
					 $l_Valor=$registro[$this->estructura[$i]];
					 //echo "<br> Valor:" . $l_Valor;

					 switch($this->tipos[$i]){
						case "CADENA": $l_Valor=stripslashes($l_Valor);		
						               $l_Valor=trim($l_Valor);		
						               $l_Valor=$this->CONVERTIR_ESPECIALES_HTML($l_Valor);			                					 
						               array_push($l_Registros,$l_Valor);
						               break;
						case "FECHA":  $l_Valor=stripslashes($l_Valor);	
						               $l_Valor=trim($l_Valor);	
						               array_push($l_Registros,$l_Valor);					                
						               break;
						case "NUMERO": array_push($l_Registros,$l_Valor);	                
									   break;
									   
						case "DECIMAL": array_push($l_Registros,$l_Valor);	                
									break;			   
					 }

					 
					if(($this->contCampos-1)==$i){
						array_push($l_Registros,0);
					} else {
						if(($this->contCampos-2)==$i){
							array_push($l_Registros,1);
						} else {
							if(($this->contCampos-3)==$i){
								array_push($l_Registros,0);
							}
						}
					}
					
				}

				//print_r($l_Registros);
			             
				$this->setInformacion_Leer($l_Registros);

				unset($l_Registros);				  			 
			}  
	   } else {
		   $this->bandTieneDatosCargados=FALSE;
	   }

	   mysqli_close($mysqli);
	   return TRUE;
	}

	public function ContarRegistros($condicion){
		 // Declara variables
		 $contador=0;

		 // Abrea la conexion
		 $mysqli=mysqli_connect($this->servidor,$this->usuario,$this->password,$this->basededatos);

	     if(mysqli_connect_errno()){
		   $this->bandTieneAlgunError=TRUE;
		   $this->ErrorActual="Error No se puede conectar a la base de datos";
		   return -1;
		 }
	 
		 $txtConsulta="";
		 $txtConsulta = "SELECT count(" . $this->NombreCampoLlave .") as Total";
		 $txtConsulta = $txtConsulta . " FROM ";
		 $txtConsulta = $txtConsulta . $this->NombreDeLaVista;
		 $txtConsulta = $txtConsulta . " WHERE ";
		 $txtConsulta = $txtConsulta . $condicion;
	 
		 //' Ejecuta la consulta
		 $res=mysqli_query($mysqli,$txtConsulta);

		 //$this->contNumDatos=0;
		 if($res){
			if($registro=mysqli_fetch_array($res, MYSQLI_ASSOC)){
				if($registro['Total']!=NULL){
					$contador=$registro['Total'];
			   }
			}
		 }

		 mysqli_close($mysqli);
		 return $contador;
	 }	  

	 public function CargarCampos($l_Tipo){
		 
	   // Abrea la conexion         
	   $mysqli=mysqli_connect($this->servidor,$this->usuario,$this->password,$this->basededatos);

	   if(mysqli_connect_errno()){
		  $this->bandTieneAlgunError=TRUE;
		  $this->ErrorActual="Error No se puede conectar a la base de datos";       		   
		  return FALSE;
	   }

	   $this->contCampos=0;
	   unset($this->estructura);
	   unset($this->tipos);

	   $l_Tabla=$this->NombreDeLaVista;
	   if($l_Tipo=="GRABAR"){
		    $l_Tabla=$this->NombreDeLaTabla;
	   }
	   
       $l_Retorna=FALSE;
	   $txtConsulta="";
	   $txtConsulta = "SHOW COLUMNS";
	   $txtConsulta = $txtConsulta . " FROM ";
	   $txtConsulta = $txtConsulta . $l_Tabla;
 
	   //' Ejecuta la consulta
	   $res=mysqli_query($mysqli,$txtConsulta);
 
	   if($res){
		 
		     $bandEncontrado=0;
		     while($row = $res->fetch_assoc()){
				$campo = $row['Field'];
				$tipo=$row['Type'];

				$bandEncontrado=0;
				for($i=0;$i<$this->contCampos;$i=$i+1){

					if($this->estructura[$i]==$campo){
						$bandEncontrado=1;
						break;
					}
				}

				if($bandEncontrado==0){
					$this->estructura[$this->contCampos]=$campo;
					$this->tipos[$this->contCampos]=$tipo;
					$this->contCampos=$this->contCampos+1;
				}
			 }
		  
			 if($l_Tipo=="GRABAR"){
				$this->estructura[]="Crear";	 
				$this->estructura[]="Cambiar";			 
				$this->estructura[]="Eliminar";	
			 }
			 		  
 
			 $this->contCampos=count($this->estructura);
 
			 for($i=0;$i<$this->contCampos;$i=$i+1){
				 $tipos=(string)$this->tipos[$i];

				 $pos=strpos($tipos,'var');
				 if($pos===false){					 
				 } else {
					$this->tipos[$i]="CADENA";					 
				 }
				 
				 $pos=strpos($tipos,'int');
				 if($pos===false){
				 } else {
				   $this->tipos[$i]="NUMERO";				    
				 }

				 $pos=strpos($tipos,'dec');
				 if($pos===false){
				 } else {
				   $this->tipos[$i]="DECIMAL";				    
				 }

				 $pos=strpos($tipos,'text');
				 if($pos===false){
				 } else {
				   $this->tipos[$i]="CADENA";				    
				 }

				 $pos=strpos($tipos,'date');
				 if($pos===false){
				 } else {
				   $this->tipos[$i]="FECHA";				    
				 }

			     //echo " <BR> POS:" . $i . " - " . $this->estructura[$i] . " -" . $this->tipos[$i];		  			  
			}
 
		    // echo "<br> Columnas: " . $this->contCampos;

		     $l_Retorna=TRUE;
		 }  
	 

	     mysqli_close($mysqli);
	     return $l_Retorna;
     }

	
	 // --------------------------------------------------------

	 // --------------------------------------------------------
	 // BORRAR
	 private function BorrarPorCondicion($l_Condicion){
		 // Abrea la conexion
		 $mysqli=mysqli_connect($this->servidor,$this->usuario,$this->password,$this->basededatos);

		 if(mysqli_connect_errno()){
			$this->bandTieneAlgunError=TRUE;
			$this->ErrorActual="Error No se puede conectar a la base de datos";
			return -1;
		 }

		 // Declara variables
		 $txtInsercion="";
		 $fechalocal="";
		 $UtileriasDatos = new clHerramientasv2011();

		 $txtInsercion = "DELETE FROM " . $this->NombreDeLaTabla . " WHERE " . $l_Condicion;
		        
		 $res=mysqli_query($mysqli,$txtInsercion);
		 if($res==FALSE){
		   mysqli_close($mysqli);
           return FALSE;
		 }

		 mysqli_close($mysqli);
		 return TRUE;
	 }

     private function BorrarTemporal($l_nID, $l_Observaciones){
         if($this->ActualizarEstado($l_nID,1,$l_Observaciones)==TRUE){
             return TRUE;
         } else {
             return FALSE;
         }
     }
	 // --------------------------------------------------------

	 // --------------------------------------------------------
	 // CAMBIAR
	 private function ActualizarEstado($l_nID, $l_bEstado, $l_Observaciones){
		 // Abrea la conexion
		 $mysqli=mysqli_connect($this->servidor,$this->usuario,$this->password,$this->basededatos);

		 if(mysqli_connect_errno()){
			$this->bandTieneAlgunError=TRUE;
			$this->ErrorActual="Error No se puede conectar a la base de datos";
			return -1;
		 }

		 // Declara variables
		 $txtInsercion="";
		 $fechalocal="";
		 $UtileriasDatos = new clHerramientasv2011();

		 $txtInsercion = "UPDATE " .  $this->NombreDeLaTabla;
         $txtInsercion = $txtInsercion . " SET ";
         $txtInsercion = $txtInsercion . " bEstado=" . $l_bEstado . ",";

	     $l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
         $l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);
         $txtInsercion = $txtInsercion . " FechaModificacion='". $l_FechaLocal . "',";

         $txtInsercion = $txtInsercion . " Observaciones='". $l_Observaciones . "'";
         $txtInsercion = $txtInsercion . " WHERE " . $this->NombreCampoLlave . "=" .$l_nID;

		 $res=mysqli_query($mysqli,$txtInsercion);
		 if($res==FALSE){
		      mysqli_close($mysqli);
             return FALSE;
		 }

		 mysqli_close($mysqli);
		 return TRUE;
	 }     
     // --------------------------------------------------------

     // --------------------------------------------------------
     // Ejecucion
	 private function Grabar($Tabla){				 
		// Abrea la conexion
		$mysqli=mysqli_connect($this->servidor,$this->usuario,$this->password,$this->basededatos);
 
		if(mysqli_connect_errno()){
		   $this->bandTieneAlgunError=TRUE;
		   $this->ErrorActual="Error No se puede conectar a la base de datos";		    
		   return -1;
		}
	 
 
		// Declara variables
		$txtInsercion="";
		$fechalocal="";
		$UtileriasDatos = new clHerramientasv2011();

		// Carga los campos
		 
		$l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
		$l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);

 
		for ($i=0;$i<$this->contNumDatos; $i=$i+1){
			 
			 $l_Campos="";
			 $l_Informacion="";
 
			 if($Tabla[$i]["Crear"]){
		 
			    // Campos
				$l_Campos="";
				$numCampos=$this->contCampos;
				$numCampos=$numCampos-3;				 
		        for($j=1;$j<$numCampos;$j=$j+1){					 
			        $l_Campos=$l_Campos . $this->estructura[$j] . ",";
				} 
				$l_Campos=substr($l_Campos,0,strlen($l_Campos)-1);
			 
				// Información a grabar
				$l_Informacion="";
				for($j=1;$j<$numCampos;$j=$j+1){		
					 	  
			        switch($this->tipos[$j]){
						case "CADENA": $l_Informacion=$l_Informacion . "'" . addslashes($Tabla[$i][$this->estructura[$j]]) . "', ";
						               break;
						case "FECHA":  if( $this->estructura[$j]=="FechaModificacion"   ){
										     //if(strlen($Tabla[$i][$this->estructura[$j]])==0){
										        $Tabla[$i][$this->estructura[$j]]=$l_FechaLocal;
									         //} 
									   } else {
										  if( $this->estructura[$j]=="FechaCreacion"   ){
											 //if(strlen($Tabla[$i][$this->estructura[$j]])==0){
										        $Tabla[$i][$this->estructura[$j]]=$l_FechaLocal;
									         //} 
										  }
									   }
		
						               $l_Informacion=$l_Informacion . "'" . addslashes($Tabla[$i][$this->estructura[$j]]) . "', ";
						               break;
						case "NUMERO": $l_Informacion=$l_Informacion . $Tabla[$i][$this->estructura[$j]] . ", ";
									   break;
						
						case "DECIMAL": $l_Informacion=$l_Informacion . $Tabla[$i][$this->estructura[$j]] . ", ";
										break;

					}
				} 
				$l_Informacion=substr($l_Informacion,0,strlen($l_Informacion)-2);
			 
				$txtInsercion = "INSERT INTO " . $this->NombreDeLaTabla;
				$txtInsercion = " " . $txtInsercion . "(" . $l_Campos . ") VALUES (" . $l_Informacion . ")";

				//echo $txtInsercion; 
			} else {
				
				if($Tabla[$i]["Cambiar"]==TRUE){
					
					 $txtInsercion = "UPDATE " .  $this->NombreDeLaTabla;
					 $txtInsercion = $txtInsercion . " SET ";
					 
                     // Campos
					 $l_Campo="";
					 $l_Datos="";
				     $numCampos=$this->contCampos;
					 $numCampos=$numCampos-3;
					 
		             for($j=1;$j<$numCampos;$j=$j+1){	
						 //echo "CAMPO:" . $this->estructura[$j];
						 $l_Informacion="";									 
						 $l_Campo="";

						 // Campos excluidos
						 if($this->estructura[$j]!="FechaCreacion"){
							if($this->estructura[$j]!="bEstado"){
								$l_Campo=$this->estructura[$j] . "=";		
							}
						 }			
						 
						  
						 switch($this->tipos[$j]){
							case "CADENA": $l_Informacion=$l_Informacion . "'" . addslashes($Tabla[$i][$this->estructura[$j]]) . "', ";										   
										   break;
							case "FECHA":  if( $this->estructura[$j]=="FechaModificacion" ){
												 //if(strlen($Tabla[$i][$this->estructura[$j]])==0){
													$Tabla[$i][$this->estructura[$j]]=$l_FechaLocal;
													$l_Informacion=$l_Informacion . "'" . addslashes($Tabla[$i][$this->estructura[$j]]) . "', ";
												 //} 
										   }  

										   if( $this->estructura[$j]=="FechaCreacion" ){
											     
										   }  
										   

										   break;
							case "NUMERO": if( $this->estructura[$j]!="bEstado" ){
                                                $l_Informacion=$l_Informacion . $Tabla[$i][$this->estructura[$j]] . ", ";										       
										   }							
							
										   break;

							case "DECIMAL":  						
							
										   break;

						 }

						 $l_Campo=$l_Campo . $l_Informacion;
						 $l_Datos=$l_Datos . $l_Campo;						 						 
				     } 
					 $l_Datos=substr($l_Datos,0,strlen($l_Datos)-2);					 
					 $txtInsercion=$txtInsercion . " " . $l_Datos;

					 $txtInsercion=$txtInsercion . " WHERE ";
					 $l_Campo=$this->estructura[0] . "=";
					 $txtInsercion=$txtInsercion . $l_Campo;
					 $txtInsercion=$txtInsercion . $Tabla[$i][$this->estructura[0]];
 
					 //echo $txtInsercion;
			 
				 } else {
					if($Tabla[$i]["Eliminar"]==TRUE){
					 
						$txtInsercion = "DELETE FROM " . $this->NombreDeLaTabla . " WHERE " . $this->NombreCampoLlave . "=" .$Tabla[$i][$this->estructura[0]];
					 
					}
				}
			}
 
	  
			$res=mysqli_query($mysqli,$txtInsercion);

			if($res==FALSE){
				mysqli_close($mysqli);
				return FALSE;
			}
			 
		}

		mysqli_close($mysqli);
		return TRUE;
	}
     // --------------------------------------------------------

     // --------------------------------------------------------
	 // OPERACIONES
	 // ELIMINIAR
	 public function EliminarConCondicion($l_Condicion){
		 if($this->bandTieneAlgunError){
			return FALSE;
		 }

		 if($this->bandTieneDatosParaConectarse){
			 $this->bandTieneAlgunError=TRUE;
			 $this->ErrorActual="Error No tiene los datos para conectarse a la base de datos [Cargar]";
			 return FALSE;
		 }

		 if(strlen($l_Condicion)<=0){
			 $this->bandTieneAlgunError=TRUE;
			 $this->ErrorActual="Error No tiene condicion";
			 return FALSE;
		 }

		 if ($this->BorrarPorCondicion($l_Condicion)==TRUE){
			 return TRUE;
		 } else {
			 return FALSE;
		 }
	 }

	 public function Ocultar($l_nID, $l_Observaciones){
		 if($this->bandTieneAlgunError){
			 return FALSE;
		 }

		 if($this->bandTieneDatosParaConectarse){
			 $this->bandTieneAlgunError=TRUE;
			 $this->ErrorActual="Error No tiene los datos para conectarse a la base de datos [Cargar]";
			 return FALSE;
		 }

		 if ($this->BorrarTemporal($l_nID,$l_Observaciones)==TRUE){
			 return TRUE;
		 } else {
			 return FALSE;
		 }
	 }

	 // CAMBIAR
	 public function CambiarEstado($l_nID, $l_Observaciones, $l_bEstado){
		 if($this->bandTieneAlgunError){
			return FALSE;
		 }

		 if($this->bandTieneDatosParaConectarse){
			$this->bandTieneAlgunError=TRUE;
			$this->ErrorActual="Error No tiene los datos para conectarse a la base de datos [Cargar]";
			return FALSE;
		 }

		 if ($this->ActualizarEstado($l_nID,$l_bEstado,$l_Observaciones)==TRUE){
			 return TRUE;
		 } else {
			 return FALSE;
		 }
	 } 

	 // CARGAR
	 public function Leer($condicion){
		 if($this->bandTieneAlgunError){
			return FALSE;
		 }

		 if($this->bandTieneDatosParaConectarse){
			$this->bandTieneAlgunError=TRUE;
			$this->ErrorActual="Error No tiene los datos para conectarse a la base de datos [Cargar]";
			return FALSE;
		 }

		 if(strlen($condicion)<=0){
			$this->bandTieneAlgunError=TRUE;
			$this->ErrorActual="Error No tiene Condicion";
			return FALSE;
		 }

		 if($this->Consultar($condicion)==TRUE){
			return TRUE;
		 } else {
			return FALSE;
		 }
     }
     
     public function Leer_Directo($consulta){
        if($this->bandTieneAlgunError){
           return FALSE;
        }

        if($this->bandTieneDatosParaConectarse){
           $this->bandTieneAlgunError=TRUE;
           $this->ErrorActual="Error No tiene los datos para conectarse a la base de datos [Cargar]";
           return FALSE;
        }

        if(strlen($consulta)<=0){
           $this->bandTieneAlgunError=TRUE;
           $this->ErrorActual="Error No tiene Condicion";
           return FALSE;
        }

        if($this->Consultar_Directa($consulta)==TRUE){
           return TRUE;
        } else {
           return FALSE;
        }
    }
 

	 // EJECUCION
	 public function Ejecutar(){
		 if($this->bandTieneAlgunError){
			return FALSE;
		 }
 
		 if($this->bandTieneDatosParaConectarse){
			$this->bandTieneAlgunError=TRUE;
			$this->ErrorActual="Error No tiene los datos para conectarse a la base de datos [Cargar]";
			return FALSE;
		 }

		 if($this->contNumDatos<=0){
			return FALSE;
		 }

		 
		 if($this->Grabar($this->dtGrabar)==TRUE){
			return TRUE;
		 } else {
			return FALSE;
		 }
	 }
 
 }
?>
