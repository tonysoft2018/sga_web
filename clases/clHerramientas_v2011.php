<?php
// ----------------------------------------------------------------------------------
// clHerramientas_v2011.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. IDEATECH
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 24/06/2020
// ----------------------------------------------------------------------------------
// V2.0.1
// ----------------------------------------------------------------------------------

// ----------------------------------------------
date_default_timezone_set("America/Mexico_City");
// ----------------------------------------------

class clHerramientasv2011 {
    
 public function RegresarConDiagonales($Valor){
	$dato="";
	$resultado="";
	 
	for($i=0;$i<strlen($Valor);$i=$i+1){
		$dato=substr($Valor,$i,1); 
		if($dato=="\\"){ 
		   $resultado=$resultado . $dato . "\\";  
		} else {
			$resultado=$resultado . $dato;
			 
		}
	}
	
	return $resultado;
 }
 
 
 public function EsFecha($cadena){
	$dato="";
	$idato=0;
	$bandera=TRUE;
	$dia="";
	$idia=0;
	$mes="";
	$imes=0;
	$axo="";
	$iaxo=0;
	$fecha=""; 	
		
    $fecha=$cadena;
    
	if (strlen($fecha)>0){
	   if(strlen($fecha)>10){		   		 
           return FALSE;
	   } else {
		   $dia=substr($fecha,0,2); 
		   for($i=0;$i<strlen($dia)-1;$i=$i+1){
			   $dato=substr($dia,$i,1); 
			   if(!(is_numeric($dato)==1)){
				   return FALSE;
			   }  
		   } 
		   $idia=(int) $dia;
		   
		   $mes=substr($fecha,3,2); 
		   for($i=0;$i<strlen($mes)-1;$i=$i+1){
			   $dato=substr($mes,$i,1); 
			   if(!(is_numeric($dato)==1)){
				   return FALSE;
			   }  
		   }
		   $imes=(int) $mes;

           $axo=substr($fecha,6,4); 
		   for($i=0;$i<strlen($axo)-1;$i=$i+1){
			   $dato=substr($axo,$i,1); 
			   if(!(is_numeric($dato)==1)){
				   return FALSE;
			   }  
		   }
		   $iaxo=(int) $axo;
		   
		   if ($idia<1 || $idia>31){
			   return FALSE;
		   }
		   
		   if($imes<1 || $imes>12){
			   return FALSE;
		   }
		   
		   if($iaxo<1980 || $iaxo>2050){
			   return FALSE;
		   }
		   
		   for($i=0;$i<strlen($fecha);$i=$i+1){
			   $dato=substr($fecha,$i,1); 
			   if(!(is_numeric($dato)==1)){
				   if(!(strcmp($dato,"/")==0)){					   
					   return FALSE;
				   }
			   }  			   
		   }
 
		   return TRUE;
	   }		
	} else { 
		return FALSE;
	}		 
 }

 function CrearFechaYHoraParaCrearCadenaOriginal($l_Fecha, $l_Tiempo) {	
   // Recibe una cadena de 10 caracteres en el formato dd/mm/aaaa y tiempo en el formato hh:mm:ss a.m./p.m.
   // Regresa una cadena en el formato aaaa-mm-ddTHH:mm:00        
        If (!(strlen($l_Fecha) == 10)) {			 
			   return "";
		}  
		
        $l_Hora = "";
        $l_iHora = 0;
        $l_Minutos = "";
        $l_Segundos = "";
        $l_FormaHoraria = "";
        $l_Dia = "";
        $l_Mes = "";
        $l_Axo = "";
        $l_FechaYHoraFinal = "";
		 

        // Separar el tiempo 
        $l_Hora = substr($l_Tiempo, 0, 2);
        $l_Minutos = substr($l_Tiempo, 3, 2);
        $l_Segundos = substr($l_Tiempo, 6, 2);
        $l_FormaHoraria = substr($l_Tiempo, 9, 4); 

        if (strcmp($l_FormaHoraria,"p.m.")==0){ 
            $l_iHora = (int) $l_Hora;
            $l_iHora = $l_iHora + 12;
            $l_Hora = (string) $l_iHora;

            if (strlen($l_Hora)<2){ 
                $l_Hora = "0" & $l_Hora;
			}
		}

        // Separar fecha
        $l_Dia = substr($l_Fecha, 0, 2);
        $l_Mes = substr($l_Fecha, 3, 2);
        $l_Axo = substr($l_Fecha, 6, 4);

        $l_FechaYHoraFinal = $l_Axo . "-" . $l_Mes . "-" . $l_Dia . "T" . $l_Hora . ":" . $l_Minutos . ":00";

        return $l_FechaYHoraFinal;
 }
 
 function ConvertirFecha($l_Fecha){
 // Regresa una fecha con el formato aaaammdd
 
   $Dia = "";
   $Mes = "";
   $Anio = "";
   $Fecha = "";
   
  if (strlen($l_Fecha) > 0){ 
      if (strlen($l_Fecha) == 10){ 
         if ($this->EsFecha($l_Fecha)==1){ 
             $Dia = substr($l_Fecha,0, 2);
             $Mes = substr($l_Fecha,3, 2);
             $Anio = substr($l_Fecha,6, 4);
             if(strlen($Dia)< 2){ 
                $Dia = "0" . $Dia;
			 }
             if (strlen($Mes)< 2){
                 $Mes = "0" . $Mes;
			 }

             $Fecha = $Anio . $Mes . $Dia;
		 }
         else {
			 return "";
		 }
	  }
      else {
         if (strlen($l_Fecha) == 8) { 
             $Fecha = $l_Fecha;
		 }
         else{
             $Fecha = "";
		 }
	  } 
   }
   else {
    $Fecha = "";
   }

   return $Fecha;
 }

 
 function ConvertirFecha_General($l_Fecha){
	//Regresa una fecha con el formato dd/mm/aaaa
   $Dia = "";
   $Mes = "";
   $Anio = "";
   $Fecha = "";  
    if (strlen($l_Fecha) > 0){ 
		 if (strlen($l_Fecha) == 10){ 
   		     if ($this->EsFecha($l_Fecha)==1){ 
			    $Dia = substr($l_Fecha,0, 2);
                $Mes = substr($l_Fecha, 3, 2);
                $Anio = substr($l_Fecha,6, 4);
                if (strlen($Dia) < 2){ 
                    $Dia = "0" . $Dia;
			    }
                if (strlen($Mes) < 2){ 
                    $Mes = "0" . $Mes;
			    }
 
                $Fecha = $Dia . "/" . $Mes . "/" . $Anio;
			 } else {
				$Fecha = "";
			 }
		 } else {
			if (strlen($l_Fecha) == 8){ 
			   if ($this->EsFecha($l_Fecha)==1){ 
			      $Dia = substr($l_Fecha,0, 2);
                  $Mes = substr($l_Fecha, 3, 2);
                  $Anio = substr($l_Fecha,6, 4);
                  if (strlen($Dia) < 2){ 
                      $Dia = "0" . $Dia;
			      }
                  if (strlen($Mes) < 2){ 
                      $Mes = "0" . $Mes;
			      }
 
                  $Fecha = $Dia . "/" . $Mes . "/" . $Anio;
			 } else {
				$Fecha = "";
			 }
			} else {
			}
			$Fecha = "";
			
		 }
	} else {		
		$Fecha = "";
	}
	 
    return $Fecha;	 
 }
 
 function ConvertirFechaYHora($l_Fecha){
  // Funcion utilizada para convertir una fecha que se pueda grabar en la base de datos

        $Dia= "";
        $iDia = 0;
        $Mes = "";
        $iMes = 0;
        $Anio = "";
        $iAnio = 0;
        $Hora = "";
        $iHora = 0;
        $Minutos = "";
        $iMinutos = 0;
        $Segundos = "";
        $iSegundos = 0;
        $FormaHoraria = "";
        $Dato = "";

        $Fecha = "";
        $HoraCompleta = "";
        $FechaYHora = "";
        $i = 0;
 
        if (!strlen($l_Fecha) > 0){ 
           return "";
		}

        $l_Fecha = trim($l_Fecha);

       // Verifica que tipo de fecha se recibio
       switch(strlen($l_Fecha)){
        case 8: //'--Fecha Simple con formato aaaammdd sin hora
		      
               if (is_numeric($l_Fecha)==TRUE){
				  
                  //No tiene hora agregarsela
                 date_default_timezone_set('America/Mexico_City');
				 $HoraCompleta = localtime(time(),1);										 
					
                 $Hora = $HoraCompleta['tm_hour'];
                 $Minutos = $HoraCompleta['tm_min'];
                 $Segundos = $HoraCompleta['tm_sec'];
  
                 if (strlen($Hora) < 2){ 
                     $Hora = "0" . $Hora;
				 }

                 if (strlen($Minutos) < 2){ 
                    $Minutos = "0" . $Minutos;
				 }

                 if (strlen($Segundos) < 2){
                    $Segundos = "0" . $Segundos;
				 }

                 $Anio = substr($l_Fecha, 0, 4);
                 $Mes = substr($l_Fecha, 4, 2);
                 $Dia = substr($l_Fecha, 6, 2);

                 if (strlen($Dia) < 2) { 
                      $Dia = "0" . $Dia;
				 }

                 if (strlen($Mes) < 2){ 
                     $Mes = "0" . $Mes;
				 }

                 // Valida la fecha				 
                 if($this->EsFecha($Dia . "/" . $Mes . "/" . $Anio)==TRUE){
                    return $Anio . "-" . $Mes . "-" . $Dia . " " . $Hora . ":" . $Minutos . ":" . $Segundos;
				 }else{
                   return "";
				 }
			    }else{
				  return ""; 
			    }
			    break;
				
        case 10: // '--Fecha Simple sin formato dd/mm/aaaa sin hora                     
                if ($this->EsFecha($l_Fecha)==1){ 
				    // ' Extrae los datos de la fecha
				    $Dia = substr($l_Fecha, 0, 2);
					$Mes = substr($l_Fecha, 3, 2);
                    $Anio = substr($l_Fecha, 6, 4);							
			
						
					date_default_timezone_set('America/Mexico_City');
					$HoraCompleta = localtime(time(),1);										 
					
                    $Hora = $HoraCompleta['tm_hour'];
                    $Minutos = $HoraCompleta['tm_min'];
                    $Segundos = $HoraCompleta['tm_sec'];
 
					$iHora = (int) $Hora;                   
                    $Hora = (string) $iHora;

                    if (strlen($Hora)< 2){
                       $Hora = "0" . $Hora;
					}

                    if (strlen($Minutos) < 2){ 
                       $Minutos = "0" . $Minutos;
					}

                    if (strlen($Segundos) < 2) {
                       $Segundos = "0" & $Segundos;
					}

                    return $Anio . "-" . $Mes . "-" . $Dia . " " . $Hora . ":" . $Minutos . ":" . $Segundos;
						
				} else {
					return "";
				}
 
                break;
        case 19: // '--Fecha con hora con formato aaaa-mm-dd hh:mm:ss  forma horaria de 24 horas                     
                $Anio = substr($l_Fecha, 0, 4);
                $Mes = substr($l_Fecha, 5, 2);
                $Dia = substr($l_Fecha, 8, 2);
                $Hora = substr($l_Fecha, 11, 2);
                $Minutos = substr($l_Fecha, 14, 2);
                $Segundos = substr($l_Fecha, 17, 2);

                if (is_numeric($Anio)==TRUE && is_numeric($Mes)==TRUE && is_numeric($Dia)==TRUE && is_numeric($Hora)==TRUE && is_numeric($Minutos)==TRUE && is_numeric($Segundos)==TRUE){ 
                    if ($this->EsFecha($Dia . "/" . $Mes . "/" . $Anio)==TRUE){						
                        $iHora = (int) $Hora;
                        $iMinutos = (int) $Minutos;
                        $iSegundos = (int) $Segundos;

                        If ($iHora < 0 || $iHora > 23) { 
                           return "";
						}

                        If ($iMinutos < 0 || $iMinutos > 59){
                           return "";
					    }

                        if ($iSegundos < 0 || $iSegundos > 59){
                           return "";
						}

                            return Trim($l_Fecha);
					} else {
                      return "";
					}					
				} else {
                  return "";
				}

                 break;
	   case 20: // '--Fecha con hora sin formato dd/mm/aaaa h:mm f.h.  formadehorario(a.m./p.m.)
	            $Dia = substr($l_Fecha, 0, 2);
                $Mes = substr($l_Fecha, 3, 2);
                $Anio = substr($l_Fecha, 6, 4);

                $Hora = substr($l_Fecha, 11, 1);
                $Minutos = substr($l_Fecha, 13, 2);

                $FormaHoraria = substr($l_Fecha, 16, 4);
                $FormaHoraria =  strtolower($FormaHoraria);
				 
                
                if (is_numeric($Anio)==TRUE && is_numeric($Mes)==TRUE && is_numeric($Dia)==TRUE && is_numeric($Hora)==TRUE && is_numeric($Minutos)==TRUE){ 				  
                     if (strcmp($FormaHoraria,"a.m.")==0  || strcmp($FormaHoraria, "p.m.")==0) {
                         if ($this->EsFecha($Dia . "/" . $Mes . "/" . $Anio)==TRUE){  
                             $iHora = (int) $Hora; 
                             $iMinutos = (int) $Minutos;

                             if ($iHora < 0 || $iHora > 12){ 
                                return "";
							 }

                             if ($iMinutos < 0 || $iMinutos > 59){ 
                                return "";
							 }

                             if (strcmp($FormaHoraria, "p.m.")==0) {
                                $iHora = (int) $Hora;

                                if ($iHora < 12){ 
                                    $iHora = $iHora + 12;
								} 
                                if ($iHora == 24){ 
                                   $iHora = 0;
								}
							  }
                              $Hora = (string) $iHora;

                              if (strlen($Hora)< 2){ 
                                  $Hora = "0" . $Hora;
							  }

                              if (strlen($Minutos) < 2){ 
                                  $Minutos = "0" . $Minutos;
							  }

                              if (strlen($Mes) < 2){ 
                                 $Mes = "0" . $Mes;
							  }

                              if (strlen($Dia) < 2){ 
                                  $Dia = "0" . $Dia;
							  }

                              return $Anio . "-" . $Mes . "-" . $Dia . " " . $Hora . ":" . $Minutos . ":00";
						 } else {
                            return "";
						 }
					 } else {
                         return "";
					 }
				  } else {
                     return "";
				 }

                 break;
	   
       case 21: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)
 	           
                $Dia = substr($l_Fecha, 0, 2);
                $Mes = substr($l_Fecha, 3, 2);
                $Anio = substr($l_Fecha, 6, 4);

                $Hora = substr($l_Fecha, 11, 2);
                $Minutos = substr($l_Fecha, 14, 2);

                $FormaHoraria = substr($l_Fecha, 17, 4);
                $FormaHoraria =  strtolower($FormaHoraria);

                
                if (is_numeric($Anio)==TRUE && is_numeric($Mes)==TRUE && is_numeric($Dia)==TRUE && is_numeric($Hora)==TRUE && is_numeric($Minutos)==TRUE){ 				  
                     if (strcmp($FormaHoraria,"a.m.")==0  || strcmp($FormaHoraria, "p.m.")==0) {
                         if ($this->EsFecha($Dia . "/" . $Mes . "/" . $Anio)==TRUE){  
                             $iHora = (int) $Hora; 
                             $iMinutos = (int) $Minutos;

                             if ($iHora < 0 || $iHora > 12){ 
                                return "";
							 }

                             if ($iMinutos < 0 || $iMinutos > 59){ 
                                return "";
							 }

                             if (strcmp($FormaHoraria, "p.m.")==0) {
                                $iHora = (int) $Hora;

                                if ($iHora < 12){ 
                                    $iHora = $iHora + 12;
								} 
                                if ($iHora == 24){ 
                                   $iHora = 0;
								}
							  }
                              $Hora = (string) $iHora;

                              if (strlen($Hora)< 2){ 
                                  $Hora = "0" . $Hora;
							  }

                              if (strlen($Minutos) < 2){ 
                                  $Minutos = "0" . $Minutos;
							  }

                              if (strlen($Mes) < 2){ 
                                 $Mes = "0" . $Mes;
							  }

                              if (strlen($Dia) < 2){ 
                                  $Dia = "0" . $Dia;
							  }

                              return $Anio . "-" . $Mes . "-" . $Dia . " " . $Hora . ":" . $Minutos . ":00";
						 } else {
                            return "";
						 }
					 } else {
                         return "";
					 }
				  } else {
                     return "";
				 }

                 break;

     case 24: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm:ss f.h.   formadehorario(a.m./p.m.)
              $Dia = substr($l_Fecha, 0, 2);
              $Mes = substr($l_Fecha, 3, 2);
              $Anio = substr($l_Fecha, 6, 4);

              $Hora = substr($l_Fecha, 11, 2);
              $Minutos = substr($l_Fecha, 14, 2);
              $Segundos = substr($l_Fecha, 17, 2);

              $FormaHoraria = substr($l_Fecha, 20, 4);
              $FormaHoraria =  strtolower($FormaHoraria);
			  
			   if (is_numeric($Anio)==TRUE && is_numeric($Mes)==TRUE && is_numeric($Dia)==TRUE && is_numeric($Hora)==TRUE && is_numeric($Minutos)==TRUE && is_numeric($Segundos)==TRUE){  	
			       if (strcmp($FormaHoraria,"a.m.")==0  || strcmp($FormaHoraria,"p.m.")==0){ 
				       if ($this->EsFecha($Dia . "/" . $Mes . "/" . $Anio)==TRUE){ 
					   	   $iHora = (int) $Hora;
                           $iMinutos = (int) $Minutos;
                           $iSegundos = (int) $Segundos;
						   
						   if ($iHora < 0 || $iHora > 12) {     
					           return "";							
				           }
					 
					       if ($iMinutos < 0 || $iMinutos > 59){
					          return "";							
					       }
						   
						   if (strcmp($FormaHoraria, "p.m.")==0){	
						      $iHora = (int) $Hora;
							  
							  if ($iHora < 12){ 
                                 $iHora = $iHora + 12;
						      }
							  
							  if ($iHora == 24){ 
                                  $iHora = 0;
						      }  
						   }  
						   
						   $Hora = (string) $iHora;
						   
						   if (strlen($Hora) < 2){ 
                               $Hora = "0" . $Hora;
					       }
						   
						   if (strlen($Minutos) < 2){ 
                              $Minutos = "0" . $Minutos;
					       }
						   
						   if (strlen($Segundos) < 2){ 
                               $Minutos = "0" . $Segundos;					       
						   }
						   
						   if (strlen($Mes) < 2){ 
                               $Mes = "0" . $Mes;
					       }

                           if (strlen($Dia) < 2){ 
                              $Dia = "0" . $Dia;
					       }
						   
						   return $Anio . "-" . $Mes . "-" . $Dia . " " . $Hora . ":" . $Minutos . ":" . $Segundos;
					   } else {
						   return "";
					   }				   
				   } else {
					 return "";
				   }			   
			   } else {
				 return "";
			   }
	  default:  
          return "";
    }
}
 

function ConvertirFechaYHora_General($l_Fecha){
  // Funcion utilizada para convertir una fecha que se pueda grabar en la base de datos
  // La fecha regresada por parte de la base de datos tiene el formato
  // dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)

  $Dia = "";
  $iDia = 0;
  $Mes = "";
  $iMes = 0;
  $Anio = "";
  $iAnio = 0;
  $Hora = "";
  $iHora = 0;
  $Minutos = "";
  $iMinutos = 0;
  $Segundos = "";
  $iSegundos = 0;
  $FormaHoraria = "";
  $Dato = "";

  $Fecha = "";
  $HoraCompleta = ""; 
  $FechaYHora = "";
  $i = 0;
  
  if (!strlen($l_Fecha) > 0){ 
      return "";
  }
    
  $l_Fecha = trim($l_Fecha);

   //Verifica que tipo de fecha se recibio    
  switch(strlen($l_Fecha)){
	     case 8: // '--Fecha Simple con formato aaaammdd sin hora
		         if (is_numeric($l_Fecha)==TRUE){ 
                   //No tiene hora agregarsela
                   date_default_timezone_set('America/Mexico_City');
					$HoraCompleta = localtime(time(),1);										 
					
                    $Hora = $HoraCompleta['tm_hour'];
                    $Minutos = $HoraCompleta['tm_min'];
                    $Segundos = $HoraCompleta['tm_sec']; 
					
					$iHora=(int) $Hora;
					if ($iHora>=12){
						$FormaHoraria="p.m.";
						if($iHora>12){
							$iHora=$iHora-12;
						}						
					} else {
						$FormaHoraria="a.m.";
					}
					$Hora=(string) $iHora;

                    if (strlen($Hora) < 2){ 
                       $Hora = "0" . $Hora;
				    }

                    if (strlen($Minutos) < 2){ 
                       $Minutos = "0" . $Minutos;
				    }

                    if (strlen($Segundos) < 2){ 
                       $Segundos = "0" & $Segundos;
				    }  

                    $Anio = substr($l_Fecha, 0, 4);
                    $Mes = substr($l_Fecha, 4, 2);
                    $Dia = substr($l_Fecha, 6, 2);

                    if (strlen($Dia) < 2){
                        $Dia = "0" . $Dia;
				    }

                    if (strlen($Mes) < 2){ 
                        $Mes = "0" . $Mes;
				    }

                    //' -- Valida la fecha
                    // dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)
                    if ($this->EsFecha($Dia . "/" . $Mes . "/" . $Anio)==TRUE){
                        return $Dia . "/" . $Mes . "/" . $Anio . " " . $Hora . ":" . $Minutos . " " . $FormaHoraria;
				    } else {
                        return "";
				    }
			     } else {
                   return "";
			     }
		         break;
	     case 10: // '--Fecha Simple sin formato dd/mm/aaaa sin hora    
		         if ($this->EsFecha($l_Fecha)==TRUE){  
                    // ' Extrae los datos de la fecha
                    $Dia = substr($l_Fecha, 0, 2);
                    $Mes = substr($l_Fecha, 3, 2);
                    $Anio = substr($l_Fecha, 6, 4);

                      date_default_timezone_set('America/Mexico_City');
					$HoraCompleta = localtime(time(),1);										 
					
                    $Hora = $HoraCompleta['tm_hour'];
                    $Minutos = $HoraCompleta['tm_min'];
                    $Segundos = $HoraCompleta['tm_sec']; 
					
					$iHora=(int) $Hora;
					if ($iHora>=12){
						$FormaHoraria="p.m.";
						if($iHora>12){
							$iHora=$iHora-12;
						}						
					} else {
						$FormaHoraria="a.m.";
					}
					$Hora=(string) $iHora;

                    if (strlen($Hora) < 2){ 
                       $Hora = "0" . $Hora;
			        }

                    if (strlen($Minutos) < 2){ 
                       $Minutos = "0" . $Minutos;
			        }

                    if (strlen($Segundos) < 2){ 
                       $Segundos = "0" . $Segundos;
			        }

                    // 'dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)
                    return $Dia . "/" . $Mes . "/" . $Anio . " " . $Hora . ":" . $Minutos . " " . $FormaHoraria;
			     } else { 
                   return "";
			     }
			
		         break;
		 case 19: // '--Fecha con hora con formato aaaa-mm-dd hh:mm:ss  forma horaria de 24 horas  
		         $Anio = substr($l_Fecha, 0, 4);
                 $Mes = substr($l_Fecha, 5, 2);
                 $Dia = substr($l_Fecha, 8, 2);
                 $Hora = substr($l_Fecha, 11, 2);
                 $Minutos = substr($l_Fecha, 14, 2);
                 $Segundos = substr($l_Fecha, 17, 2);
				 
                 if (is_numeric($Anio)==TRUE && is_numeric($Mes)==TRUE && is_numeric($Dia)==TRUE && is_numeric($Hora)==TRUE && is_numeric($Minutos)==TRUE && is_numeric($Segundos)==TRUE){  	
                     
				     if ($this->EsFecha($Dia . "/" . $Mes . "/" . $Anio)==TRUE){ 
					
					    $iHora = (int) $Hora;
                        $iMinutos = (int) $Minutos;
                        $iSegundos = (int) $Segundos;

                        if ($iHora < 0 || $iHora > 23){ 
                            return "";
				        }
						
					    if ($iMinutos < 0 || $iMinutos > 59){
                            return "";
				        }

                        if ($iSegundos < 0 || $iSegundos > 59){ 
                            return "";
				        }
					    
						
					    if ($iHora > 12){ 
						    $iHora = $iHora - 12;
                            $FormaHoraria = "p.m.";
						} else {
							$FormaHoraria = "a.m.";
						}		
						
						$Hora = (string) $iHora; 
	
                        if (strlen($Hora) < 2){ 
                           $Hora = "0" . $Hora;
				        }

						//'dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)                         
                        return $Dia . "/" . $Mes . "/" . $Anio . " " . $Hora . ":" . $Minutos . " " . $FormaHoraria;		 
					 } else {
						 return "";
					 }
				 } else {
					 return "";
				 }
            
		         break;
		 case 21: //'--Fecha con hora sin formato dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)
		         $Dia = substr($l_Fecha, 0, 2);
                 $Mes = substr($l_Fecha, 3, 2);
                 $Anio = substr($l_Fecha, 6, 4);

                 $Hora = substr($l_Fecha, 11, 2);
                 $Minutos = substr($l_Fecha, 14, 2);

                 $FormaHoraria = substr($l_Fecha, 17, 4);
                 $FormaHoraria =  strtolower($FormaHoraria);		 
		 
		         if (is_numeric($Anio)==TRUE && is_numeric($Mes)==TRUE && is_numeric($Dia)==TRUE && is_numeric($Hora)==TRUE && is_numeric($Minutos)==TRUE){ 
				 
				     if (strcmp($FormaHoraria,"a.m.")==0 || strcmp($FormaHoraria,"p.m.")==0){ 
					     if ($this->EsFecha($Dia . "/" . $Mes . "/" . $Anio)==TRUE){
							 $iHora = (int) $Hora;
                             $iMinutos = (int) $Minutos;

                             if ($iHora < 0 || $iHora > 12){ 
                                 return "";
					         }
							 
							 if ($iMinutos < 0 || $iMinutos > 59){
                                 return "";
					         }

                             if (strlen($Hora) < 2){ 
                                 $Hora = "0" . $Hora;
					         }

                             if (strlen($Minutos) < 2){ 
                                 $Minutos = "0" . $Minutos;
					         }

                             if (strlen($Mes) < 2){ 
                                 $Mes = "0" . $Mes;
					         }

                             if (strlen($Dia) < 2) { 
                                 $Dia = "0" . $Dia;
					         }

                             //dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.) 
                             return $Dia . "/" . $Mes . "/" . $Anio . " " . $Hora . ":" . $Minutos . " " . $FormaHoraria;

						 } else {
							 return "";
						 }
					 } else {
						 return "";
					 }				 				  	
				 } else {
					return ""; 
				 }
		 
		         break;
         case 24: //'--Fecha con hora sin formato dd/mm/aaaa hh:mm:ss f.h.   formadehorario(a.m./p.m.)	
		         $Dia = substr($l_Fecha, 0, 2);
                 $Mes = substr($l_Fecha, 3, 2);
                 $Anio = substr($l_Fecha, 6, 4);

                 $Hora = substr($l_Fecha, 11, 2);
                 $Minutos = substr($l_Fecha, 14, 2);
                 $Segundos = substr($l_Fecha, 17, 2);

                 $FormaHoraria = substr($l_Fecha, 20, 4);
                 $FormaHoraria =  strtolower($FormaHoraria);

		         if (is_numeric($Anio)==TRUE && is_numeric($Mes)==TRUE && is_numeric($Dia)==TRUE && is_numeric($Hora)==TRUE && is_numeric($Minutos)==TRUE && is_numeric($Segundos)==TRUE){
					 if (strcmp($FormaHoraria,"a.m.")==0 || strcmp($FormaHoraria,"p.m.")==0){ 
					    if ($this->EsFecha($Dia . "/" . $Mes . "/" . $Anio)==1){ 
						    $iHora = (int) $Hora;
                            $iMinutos = (int) $Minutos;
                            $iSegundos = (int) $Segundos;

                            if ($iHora < 0 || $iHora > 12){ 
                               return "";
					        }
						
						    if ($iMinutos < 0 || $iMinutos > 59){ 
                               return "";
					        }

                            if ($iSegundos < 0 || $iSegundos > 59){ 
                               return "";
					        }

                            if (strlen($Hora) < 2){ 
                                $Hora = "0" . $Hora;
					        }

                            if (strlen($Minutos) < 2){ 
                                $Minutos = "0" . $Minutos;
					        }
						
						    if (strlen($Segundos) < 2){ 
                               $Minutos = "0" . $Segundos;
					        }

                            if (strlen($Mes) < 2){ 
                               $Mes = "0" . $Mes;
					        }
						
						    if (strlen($Dia) < 2){ 
							   $Dia = "0" . $Dia;
							}  
							
						    // dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.) 
                            return $Dia . "/" . $Mes . "/" . $Anio . " " . $Hora . ":" . $Minutos . " " . $FormaHoraria;												
						} else {
							return "";
						}					 
					 } else {
						 return "";
					 }
				 } else {
					 return "";
				 }
		         break;
		 default:
                 return "";
		         break;
				 
  }
}


function getFechaActual(){
  // funcion que extrae la fecha actual y regresa una cadena
  // con la fecha formateada aaaammdd sin hora.
  $fecha=date("d-m-Y H:i:s");
  $Dia = "";
  $Mes = "";
  $Anio = "";

  $Dia = "";
  $Mes = "";
  $Anio = "";
  

  //05-06-2006 13:23:42
  $Dia = substr($fecha,0,2);  
  $Mes = substr($fecha,3,2);  
  $Anio = substr($fecha,6,4);
   
  if (strlen($Dia)< 2){ 
      $Dia = "0" . $Dia;
  }
  
  if (strlen($Mes) < 2){ 
      $Mes = "0" . $Mes;
  }

  return $Anio . $Mes . $Dia;
}


function getFechaActual_General(){
  // funcion que extrae la fecha actual y regresa una cadena
  // con la fecha formateada dd/mm/aaaa sin hora.

  $fecha=date("d-m-Y H:i:s");
  $Dia  = "";
  $Mes  = "";
  $Anio = "";

  $Dia = "";
  $Mes = "";
  $Anio = "";
  
  $Dia = substr($fecha,0,2);  
  $Mes = substr($fecha,3,2);  
  $Anio = substr($fecha,6,4);  
	
  if (strlen($Dia) < 2){ 
     $Dia = "0" . $Dia;
  } 
  if (strlen($Mes) < 2){ 
     $Mes = "0" . $Mes;
  }

  return $Dia . "/" . $Mes . "/" . $Anio;
}


function getFechaYHoraActual() {
  // funcion que extrae la fecha y hora actual y regresa una cadena
  // con la fecha formateada aaaa-mm-dd HH:mm:ss con horario de 24 Hrs.
  $fecha=date("d-m-Y H:i:s");
  $Dia = "";
  $iDia = 0;
  $Mes = "";
  $iMes = 0;
  $Anio = "";
  $iAnio = 0;
  $Hora = "";
  $iHora = 0;
  $Minutos = "";
  $iMinutos = 0;
  $Segundos= "";
  $iSegundos = 0;
  $FormaHoraria = "";
  $HoraCompleta = "";

  $Dia = "";
  $Mes = "";
  $Anio = "";
  $Dia = substr($fecha,0,2);  
  $Mes = substr($fecha,3,2);  
  $Anio = substr($fecha,6,4);  
    
  if (strlen($Dia) < 2){ 
     $Dia = "0" . $Dia;
  }
  
  if (strlen($Mes) < 2){ 
     $Mes = "0" . $Mes;
  } 
 
  $Hora = substr($fecha, 11, 2);
  $Minutos = substr($fecha, 14, 2);
  $Segundos = substr($fecha, 17, 2);
   
  return $Anio . "-" . $Mes . "-" . $Dia . " " . $Hora . ":" . $Minutos . ":" . $Segundos;
}


function getFechaYHoraActual_General(){
  //Funcion que extrae la fecha y hora actual y regresa una cadena
  // con la fecha formateada dd/mm/aaaa hh:mm forma horaria con horario de 12 Hrs.
  $fecha=date("d-m-Y H:i:s");
  $Dia = "";
  $iDia = 0;
  $Mes = "";
  $iMes = 0;
  $Anio  = "";
  $iAnio = 0;
  $Hora = "";
  $iHora = 0;
  $Minutos = "";
  $iMinutos = 0;
  $Segundos = "";
  $iSegundos = 0;
  $FormaHoraria = "";
  $HoraCompleta = "";

  $Dia = "";
  $Mes = "";
  $Anio = "";
  
  $Dia = substr($fecha,0,2);  
  $Mes = substr($fecha,3,2);  
  $Anio = substr($fecha,6,4);
		
  if (strlen($Dia) < 2){ 
      $Dia = "0" . $Dia;
  }
  if (strlen($Mes) < 2){ 
     $Mes = "0" . $Mes;
  }
    
  $Hora = substr($fecha, 11, 2);
  $Minutos = substr($fecha, 14, 2);
  $Segundos = substr($fecha, 17, 2);
       
  if (strlen($Hora) < 2){ 
     $Hora = "0" . $Hora;
  }

  if (strlen($Minutos) < 2){ 
     $Minutos = "0" . $Minutos;
  }

  if (strlen($Segundos) < 2){ 
     $Segundos = "0" . $Segundos;
  }

  $iHora=(int) $Hora;
  
  if ($iHora>12){ 
     $FormaHoraria = "p.m.";
	 $iHora=$iHora-12;
  } else {
	 $FormaHoraria = "a.m.";
  }
  
  $Hora=(string) $iHora;
   
  return $Dia . "/" . $Mes . "/" . $Anio . " " . $Hora . ":" . $Minutos . " " . $FormaHoraria;
}


function getValorValidadoCadena($l_Valor,$Tamaxo){
 if (strlen($l_Valor) > 0){ 
     return substr($l_Valor, 1, $Tamaxo);
 } else {
   return "";
 }
}


function getValorValidadoNumericoEntero($l_Valor){
 if (strlen($l_Valor)> 0){ 
    $Signo="";
	$Valor="";
    $Signo = substr($l_Valor,0, 1);
    $Valor = substr($l_Valor,1,strlen($l_Valor)-1);

    if (!(strcmp($Signo, "-")==0)){ 
       $Valor = $l_Valor;
       $Signo = "";
	}

    if(is_numeric($Valor)==TRUE){
		$Valor=$Signo . $Valor;
		return (int) $Valor;
	} else {
		return 0;
	}
 } else {
   return 0;
 } 
}
	
function getValorValidadoNumerico($l_Valor){
  if (strlen($l_Valor) > 0){ 
     $Signo="";
	 $Valor="";
                
	 $Signo = substr($l_Valor,0, 1);
     $Valor = substr($l_Valor,1, strlen($l_Valor) - 1);

     if (!strcmp($Signo,"-")==0){ 
        $Valor = $l_Valor;
        $Signo = "";
	 }

     if(is_numeric($Valor)==TRUE){
        $Valor = $Signo . $Valor;
        return  (double) $Valor;
	 } else {
       return 0;
	 }
 } else {
	 return 0;
 }
}

function getDia($l_Fecha){
  // Funcion utilizada para convertir una fecha que se pueda grabar en la base de datos
  // La fecha regresada por parte de la base de datos tiene el formato
  // dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)

  $Dia = "";
  $iDia = 0;
  $Mes = "";
  $iMes = 0;
  $Anio = "";
  $iAnio = 0;

  $Fecha = "";
  $HoraCompleta = "";  
  $FechaYHora = "";
  $i = 0;

  if (!(strlen($l_Fecha) > 0)){ 
      return "";
  }

  $l_Fecha = trim($l_Fecha);

  // Verifica que tipo de fecha se recibio
  switch(strlen($l_Fecha)) {	  
    case 8: // '--Fecha Simple con formato aaaammdd sin hora
            if (is_int($l_Fecha)==TRUE){ 
               // No tiene hora agregarsela                        
               $Anio = substr($l_Fecha, 0, 4);
               $Mes = substr($l_Fecha, 4, 2);
               $Dia = substr($l_Fecha, 6, 2);

               if (strlen($Dia) < 2){ 
                  $Dia = "0" . $Dia;
			   }

               if (strlen($Mes) < 2){ 
                  $Mes = "0" . $Mes;
			   }

               return $Dia;
			} else {
              return "";
			}
			
            break;

    case 10: // '--Fecha Simple sin formato dd/mm/aaaa sin hora                     
            if (EsFecha($l_Fecha)==1){ 
               //' Extrae los datos de la fecha
                $Dia = substr($l_Fecha, 0, 2);
                $Mes = substr($l_Fecha, 3, 2);
                $Anio = substr($l_Fecha, 6, 4);

                //dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)
                return $Dia;
			} else {
              return "";
			}
			
			break;

    case 19: //'--Fecha con hora con formato aaaa-mm-dd hh:mm:ss  forma horaria de 24 horas                     
             $Anio = substr($l_Fecha, 0, 4);
             $Mes = substr($l_Fecha, 5, 2);
             $Dia = substr($l_Fecha, 8, 2);

             if (is_int($Anio)==TRUE && is_int($Mes)==TRUE && is_int($Dia)==TRUE){ 
                 if (EsFecha($Dia . "/" . $Mes . "/" . $Anio)==1){ 
                    return $Dia;
				 } else {
                    return "";
				 }
			 } else {
               return "";
			 }
			 
			 break;

   case 21: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)
            $Dia = substr($l_Fecha, 0, 2);
            $Mes = substr($l_Fecha, 3, 2);
            $Anio = substr($l_Fecha, 6, 4);

            if (is_int($Dia)==TRUE && is_int($Mes)==TRUE && is_int($Anio)==TRUE){ 
               If (EsFecha($Dia . "/" . $Mes . "/" . $Anio)==1){
                   if (strlen(Mes) < 2){ 
                       $Mes = "0" . $Mes;
				   }

                   if (strlen($Dia) < 2){ 
                       $Dia = "0" . $Dia;
				   }

                   return $Dia;

			   } else{ 
                 return "";
			   }
			} else {
              return "";
			}


   case 24: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm:ss f.h.   formadehorario(a.m./p.m.)
            $Dia = substr($l_Fecha, 0, 2);
            $Mes = substr($l_Fecha, 3, 2);
            $Anio = substr($l_Fecha, 6, 4);

            if (is_int($Dia)==TRUE && is_int($Mes)==TRUE && is_int($Anio)==TRUE) {
                if (EsFecha($Dia . "/" . $Mes . "/" . $Anio)==1){ 
                    if (strlen($Mes) < 2){ 
                        $Mes = "0" . $Mes;
					}

                   if (strlen($Dia) < 2){ 
                       $Dia = "0" & $Dia;
				   }

                    return $Dia;
				} else {
                  return "";
				}
			} else {
              return "";
			}
			
			break;

    default: 
           return "";
  }
}

function getMes($l_Fecha){
  // Funcion utilizada para convertir una fecha que se pueda grabar en la base de datos
  // La fecha regresada por parte de la base de datos tiene el formato
  // dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)

  $Dia = "";
  $iDia = 0;
  $Mes = "";
  $iMes = 0;
  $Anio = "";
  $iAnio = 0;

  $Fecha = "";
  $HoraCompleta = "";  
  $FechaYHora = "";
  $i = 0;

  if (!(strlen($l_Fecha) > 0)){ 
      return "";
  }

  $l_Fecha = trim($l_Fecha);

  // Verifica que tipo de fecha se recibio
  switch(strlen($l_Fecha)) {	  
    case 8: // '--Fecha Simple con formato aaaammdd sin hora
            if (is_int($l_Fecha)==TRUE){ 
               // No tiene hora agregarsela                        
               $Anio = substr($l_Fecha, 0, 4);
               $Mes = substr($l_Fecha, 4, 2);
               $Dia = substr($l_Fecha, 6, 2);

               if (strlen($Dia) < 2){ 
                  $Dia = "0" . $Dia;
			   }

               if (strlen($Mes) < 2){ 
                  $Mes = "0" . $Mes;
			   }

               return $Mes;
			} else {
              return "";
			}
			
            break;

    case 10: // '--Fecha Simple sin formato dd/mm/aaaa sin hora                     
            if (EsFecha($l_Fecha)==1){ 
               //' Extrae los datos de la fecha
                $Dia = substr($l_Fecha, 0, 2);
                $Mes = substr($l_Fecha, 3, 2);
                $Anio = substr($l_Fecha, 6, 4);

                //dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)
                return $Mes;
			} else {
              return "";
			}
			
			break;

    case 19: //'--Fecha con hora con formato aaaa-mm-dd hh:mm:ss  forma horaria de 24 horas                     
             $Anio = substr($l_Fecha, 0, 4);
             $Mes = substr($l_Fecha, 5, 2);
             $Dia = substr($l_Fecha, 8, 2);

             if (is_int($Anio)==TRUE && is_int($Mes)==TRUE && is_int($Dia)==TRUE){ 
                 if (EsFecha($Dia . "/" . $Mes . "/" . $Anio)==1){ 
                    return $Mes;
				 } else {
                    return "";
				 }
			 } else {
               return "";
			 }
			 
			 break;

   case 21: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)
            $Dia = substr($l_Fecha, 0, 2);
            $Mes = substr($l_Fecha, 3, 2);
            $Anio = substr($l_Fecha, 6, 4);

            if (is_int($Dia)==TRUE && is_int($Mes)==TRUE && is_int($Anio)==TRUE){ 
               If (EsFecha($Dia . "/" . $Mes . "/" . $Anio)==1){
                   if (strlen(Mes) < 2){ 
                       $Mes = "0" . $Mes;
				   }

                   if (strlen($Dia) < 2){ 
                       $Dia = "0" . $Dia;
				   }

                   return $Mes;

			   } else{ 
                 return "";
			   }
			} else {
              return "";
			}


   case 24: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm:ss f.h.   formadehorario(a.m./p.m.)
            $Dia = substr($l_Fecha, 0, 2);
            $Mes = substr($l_Fecha, 3, 2);
            $Anio = substr($l_Fecha, 6, 4);

            if (is_int($Dia)==TRUE && is_int($Mes)==TRUE && is_int($Anio)==TRUE) {
                if (EsFecha($Dia . "/" . $Mes . "/" . $Anio)==1){ 
                    if (strlen($Mes) < 2){ 
                        $Mes = "0" . $Mes;
					}

                   if (strlen($Dia) < 2){ 
                       $Dia = "0" & $Dia;
				   }

                    return $Mes;
				} else {
                  return "";
				}
			} else {
              return "";
			}
			
			break;

    default: 
           return "";
  }
}

function getAnio($l_Fecha){
  // Funcion utilizada para convertir una fecha que se pueda grabar en la base de datos
  // La fecha regresada por parte de la base de datos tiene el formato
  // dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)

  $Dia = "";
  $iDia = 0;
  $Mes = "";
  $iMes = 0;
  $Anio = "";
  $iAnio = 0;

  $Fecha = "";
  $HoraCompleta = "";  
  $FechaYHora = "";
  $i = 0;

  if (!(strlen($l_Fecha) > 0)){ 
      return "";
  }

  $l_Fecha = trim($l_Fecha);

  // Verifica que tipo de fecha se recibio
  switch(strlen($l_Fecha)) {	  
    case 8: // '--Fecha Simple con formato aaaammdd sin hora
            if (is_int($l_Fecha)==TRUE){ 
               // No tiene hora agregarsela                        
               $Anio = substr($l_Fecha, 0, 4);
              
               return $Anio;
			} else {
              return "";
			}
			
            break;

    case 10: // '--Fecha Simple sin formato dd/mm/aaaa sin hora                     
            if (EsFecha($l_Fecha)==1){ 
               //' Extrae los datos de la fecha              
                $Anio = substr($l_Fecha, 6, 4);

                //dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)
                return $Anio;
			} else {
              return "";
			}
			
			break;

    case 19: //'--Fecha con hora con formato aaaa-mm-dd hh:mm:ss  forma horaria de 24 horas                     
             $Anio = substr($l_Fecha,0, 4);
             $Mes = substr($l_Fecha, 5, 2);
             $Dia = substr($l_Fecha, 8, 2);

             if (is_int($Anio)==TRUE && is_int($Mes)==TRUE && is_int($Dia)==TRUE){ 
                 if (EsFecha($Dia . "/" . $Mes . "/" . $Anio)==1){ 
                    return $Anio;
				 } else {
                    return "";
				 }
			 } else {
               return "";
			 }
			 
			 break;

   case 21: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)
            $Dia = substr($l_Fecha, 0, 2);
            $Mes = substr($l_Fecha, 3, 2);
            $Anio = substr($l_Fecha, 6, 4);

            if (is_int($Dia)==TRUE && is_int($Mes)==TRUE && is_int($Anio)==TRUE){ 
               If (EsFecha($Dia . "/" . $Mes . "/" . $Anio)==1){
                   if (strlen(Mes) < 2){ 
                       $Mes = "0" . $Mes;
				   }

                   if (strlen($Dia) < 2){ 
                       $Dia = "0" . $Dia;
				   }

                   return $Anio;

			   } else{ 
                 return "";
			   }
			} else {
              return "";
			}


   case 24: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm:ss f.h.   formadehorario(a.m./p.m.)
            $Dia = substr($l_Fecha, 0, 2);
            $Mes = substr($l_Fecha, 3, 2);
            $Anio = substr($l_Fecha, 6, 4);

            if (is_int($Dia)==TRUE && is_int($Mes)==TRUE && is_int($Anio)==TRUE) {
                if (EsFecha($Dia . "/" . $Mes . "/" . $Anio)==1){ 
                    if (strlen($Mes) < 2){ 
                        $Mes = "0" . $Mes;
					}

                   if (strlen($Dia) < 2){ 
                       $Dia = "0" & $Dia;
				   }

                    return $Anio;
				} else {
                  return "";
				}
			} else {
              return "";
			}
			
			break;

    default: 
           return "";
  }
}

function getHora($l_FechaCompletaConHora){ 
  if (!strlen($l_FechaCompletaConHora) > 0){ 
      return "";
  }

  $Hora = "";
  $iHora = 0;
  $Minutos = "";
  $iMinutos = 0;
  $Segundos = "";
  $iSegundos = 0;
  $FormaHoraria = "";
  $Dato = "";

  $Fecha = "";
  $HoraCompleta = ""; 
  $FechaYHora = "";
  $i = 0;
  $l_Fecha = $l_FechaCompletaConHora;

  
  switch(strlen($l_Fecha)) {
    case 8: //'--Fecha Simple con formato aaaammdd sin hora
            return "";
			break;

    case 10: // '--Fecha Simple sin formato dd/mm/aaaa sin hora 
            return "";
			break;

    case 19: //'--Fecha con hora con formato aaaa-mm-dd hh:mm:ss  forma horaria de 24 horas                                     
             $Hora = substr($l_Fecha,11, 2);

             if (is_int($Hora)==TRUE){ 
                 $iHora = (int) $Hora;

                 if ($iHora < 0 || $iHora > 23){ 
                    return "";
				 }

                 return trim($Hora);
			 } else {
               return "";
			 }
			 
			 break;

    case 21: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)

             $Hora = substr($l_Fecha, 11, 2);

             $FormaHoraria = substr($l_Fecha, 17, 4);
             $FormaHoraria =  strtolower($FormaHoraria);

             if (is_int($Hora)==TRUE){ 
               if ($FormaHoraria = "a.m." || $FormaHoraria = "p.m."){ 
                  $iHora = (int) $Hora;
				  
                  if ($iHora < 0 || $iHora > 12){ 
                      return "";
				  }

                  if (strlen($Hora)< 2){  
                     $Hora = "0" . $Hora;
				  }

                  return $Hora;
			   } else {
                 return "";
			   }
			 } else {
               return "";
			 }
			 
			 break;

    case 24: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm:ss f.h.   formadehorario(a.m./p.m.)

            $Hora = substr($l_Fecha, 11, 2);

            $FormaHoraria = substr($l_Fecha, 20, 4);
            $FormaHoraria =  strtolower($FormaHoraria);

            if (is_int($Hora)==TRUE){ 
               if (strcmp($FormaHoraria,"a.m.")==0  || strcmp($FormaHoraria,"p.m.")==0){ 
                   $iHora = (int) $Hora;

                   if ($iHora < 0 || $iHora > 12){ 
                       return "";
				   }

                   if (strlen($Hora) < 2){ 
                      $Hora = "0" . $Hora;
				   }

                   return Trim($Hora);
			   } else {
                 return "";
			   }
			} else {
              return "";
			}

            break;
   default:
            return "";
			break;
  }
} 

function getMinutos($l_FechaCompletaConHora){ 
  if (!strlen($l_FechaCompletaConHora) > 0){ 
      return "";
  }

  $Hora = "";
  $iHora = 0;
  $Minutos = "";
  $iMinutos = 0;
  $Segundos = "";
  $iSegundos = 0;
  $FormaHoraria = "";
  $Dato = "";

  $Fecha = "";
  $HoraCompleta = ""; 
  $FechaYHora = "";
  $i = 0;
  $l_Fecha = $l_FechaCompletaConHora;

  
  switch(strlen($l_Fecha)) {
    case 8: //'--Fecha Simple con formato aaaammdd sin hora
            return "";
			break;

    case 10: // '--Fecha Simple sin formato dd/mm/aaaa sin hora 
            return "";
			break;

    case 19: //'--Fecha con hora con formato aaaa-mm-dd hh:mm:ss  forma horaria de 24 horas                                     
             $Minutos = substr($l_Fecha, 14, 2);
 
             if (is_int($Minutos)==TRUE){ 
                 $iMinutos = (int) $Minutos;
 
                 if ($iMinutos < 0 || $iMinutos > 59){ 
                    return "";
				 }

                 return trim($Minutos);
			 } else {
               return "";
			 }
			 
			 break;

    case 21: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)

             $Minutos = substr($l_Fecha, 14, 2); 

             if (is_int($Minutos)==TRUE){ 
               if ($FormaHoraria = "a.m." || $FormaHoraria = "p.m."){ 
                  $iMinutos = (int) $Minutos;

                 if ($iMinutos < 0 || $iMinutos > 59){ 
                    return "";
				 }

                 if (strlen($Minutos) < 2){ 
                    $Minutos = "0" . $Minutos;
				 }
                   
                  return $Minutos;
			   } else {
                 return "";
			   }
			 } else {
               return "";
			 }
			 
			 break;

    case 24: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm:ss f.h.   formadehorario(a.m./p.m.)

             $Minutos = substr($l_Fecha, 14, 2);
 
            if (is_int($Minutos)==TRUE){ 
               $iMinutos = (int) $Minutos;

               if ($iMinutos < 0 || $iMinutos > 59){ 
                  return "";
			   }

               if (strlen($Minutos) < 2){ 
                   $Minutos = "0" . $Minutos;
			   }

               return Trim($Minutos);
			} else {
              return "";
			}

            break;
   default:
            return "";
			break;
  }
} 

function getSegundos($l_FechaCompletaConHora){ 
  if (!strlen($l_FechaCompletaConHora) > 0){ 
      return "";
  }

  $Hora = "";
  $iHora = 0;
  $Minutos = "";
  $iMinutos = 0;
  $Segundos = "";
  $iSegundos = 0;
  $FormaHoraria = "";
  $Dato = "";

  $Fecha = "";
  $HoraCompleta = ""; 
  $FechaYHora = "";
  $i = 0;
  $l_Fecha = $l_FechaCompletaConHora;

  
  switch(strlen($l_Fecha)) {
    case 8: //'--Fecha Simple con formato aaaammdd sin hora
            return "";
			break;

    case 10: // '--Fecha Simple sin formato dd/mm/aaaa sin hora 
            return "";
			break;

    case 19: //'--Fecha con hora con formato aaaa-mm-dd hh:mm:ss  forma horaria de 24 horas                                     
             $Segundos = substr($l_Fecha, 17, 2);
  
             if (is_int($Segundos)==TRUE){ 
                 $iSegundos = (int) $Segundos;
 
                 if ($iSegundos < 0 || $iSegundos > 59){ 
                    return "";
				 }

                 return trim($Segundos);
			 } else {
               return "";
			 }
			 
			 break;

    case 21: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)

             $Segundos = substr($l_Fecha, 17, 2);

             if (is_int($Segundos)==TRUE){ 
               if ($FormaHoraria = "a.m." || $FormaHoraria = "p.m."){ 
                  $iSegundos = (int) $Segundos;

                 if ($iSegundos < 0 || $iSegundos > 59){ 
                    return "";
				 }

                 if (strlen($Segundos) < 2){ 
                    $Segundos = "0" . $Segundos;
				 }
                   
                  return $Segundos;
			   } else {
                 return "";
			   }
			 } else {
               return "";
			 }
			 
			 break;

    case 24: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm:ss f.h.   formadehorario(a.m./p.m.)

             $Segundos = substr($l_Fecha,17, 2);
 
            if (is_int($Segundos)==TRUE){ 
               $iSegundos = (int) $Segundos;

               if ($iSegundos < 0 || $iSegundos > 59){ 
                  return "";
			   }

               if (strlen($Segundos) < 2){ 
                   $Segundos = "0" . $Segundos;
			   }

               return Trim($Segundos);
			} else {
              return "";
			}

            break;
   default:
            return "";
			break;
  }
} 


function getFormaHoraria($l_FechaCompletaConHora){
  if (!(strlen($l_FechaCompletaConHora) > 0)){
     return "";
  }

  $Dia = "";
  $iDia = 0;
  $Mes = "";
  $iMes = 0;
  $Anio = "";
  $iAnio = 0;
  $Hora = "";
  $iHora = 0;
  $Minutos = "";
  $iMinutos = 0;
  $Segundos = "";
  $iSegundos = 0;
  $FormaHoraria = "";
  $Dato = "";

  $Fecha = "";
  $HoraCompleta = "";        
  $FechaYHora = "";
  $i = 0;
  $l_Fecha = $l_FechaCompletaConHora;


  switch(strlen($l_Fecha)) {
    case 8: // '--Fecha Simple con formato aaaammdd sin hora
            return "";

    case 10: // '--Fecha Simple sin formato dd/mm/aaaa sin hora 
            return "";
			break;

    case 19: // '--Fecha con hora con formato aaaa-mm-dd hh:mm:ss  forma horaria de 24 horas                                     
            return "";
			break;
			
    case 21: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm f.h.  formadehorario(a.m./p.m.)
            $FormaHoraria = substr($l_Fecha, 17, 4);
            $FormaHoraria =  strtolower($FormaHoraria);
            if (strcmp($FormaHoraria,"a.m.")==0  || strcmp($FormaHoraria,"p.m.")==0){ 
               return trim($FormaHoraria);
			} else {
               return "";
			}

            break;
    case 24: // '--Fecha con hora sin formato dd/mm/aaaa hh:mm:ss f.h.   formadehorario(a.m./p.m.)               
             $FormaHoraria = substr($l_Fecha, 20, 4);
             $FormaHoraria =  strtolower($FormaHoraria);
             if (strcmp($FormaHoraria,"a.m.")==0  || strcmp($FormaHoraria,"p.m.")==0){
                return trim($FormaHoraria);
			 } else {
                return "";
			 }
			 
			 break;

     default:
             return "";
			 break;
  }
}
	



function getTiempoTotal($l_DeFechaCompletaConHora,$l_AFechaCompletaConHora){
  $dia="";
  $mes="";
  $axo="";
  $idia=""; 
  $imes=0; 
  $iaxo=0;

  $l_DeDia ="";
  $l_DeMes = "";
  $l_DeAnio = "";
  $l_DeHora = "";
  $l_DeMinutos = "";
  $l_DeSegundos = "";
  $l_DeFormaHoraria = "";
  $l_DeFecha = "";

  $l_ADia = "";
  $l_AMes  = "";
  $l_AAnio = "";
  $l_AHora = "";
  $l_AMinutos = "";
  $l_ASegundos = "";
  $l_AFormaHoraria = "";
  $l_AFecha = "";

  if (strlen($l_DeFechaCompletaConHora) > 0 && strlen($l_AFechaCompletaConHora) > 0){ 
     $l_DeDia = getDia($l_DeFechaCompletaConHora);
     $l_DeMes = getMes($l_DeFechaCompletaConHora);
     $l_DeAnio = getAnio($l_DeFechaCompletaConHora);
     $l_DeHora = getHora($l_DeFechaCompletaConHora);
     $l_DeMinutos = getMinutos($l_DeFechaCompletaConHora);
     $l_DeSegundos = getSegundos($l_DeFechaCompletaConHora);
     $l_DeFormaHoraria = getFormaHoraria($l_DeFechaCompletaConHora);
     $l_DeFecha = $l_DeDia . "/" . $l_DeMes . "/" . $l_DeAnio;

     $l_ADia = getDia($l_AFechaCompletaConHora);
     $l_AMes = getMes($l_AFechaCompletaConHora);
     $l_AAnio = getAnio($l_AFechaCompletaConHora);
     $l_AHora = getHora($l_AFechaCompletaConHora);
     $l_AMinutos = getMinutos($l_AFechaCompletaConHora);
     $l_ASegundos = getSegundos($l_AFechaCompletaConHora);
     $l_AFormaHoraria = getFormaHoraria($l_AFechaCompletaConHora);
     $l_AFecha = $l_ADia . "/" . $l_AMes . "/" . $l_AAnio;
	 
	 
     // ' --------------------------------------------------
     // ' INICIO DE LA VALIDACIÓN
     // ' --------------------------------------------------
     if (!EsFecha($l_DeFecha)==1){ 
        return 0;
	 }

     if (!EsFecha($l_AFecha)==1){ 
         return 0;
	 }

     if (!(strlen($l_DeFecha)==10)){ 
         return 0;
	 }

     if (!(strlen($l_AFecha)==10)){
         return 0;
	 }

     //' --------------------------------------------
     //' Verifica que la fecha de atención es valida
     //' Si es fecha
     $dia = $l_DeDia;
     $mes = $l_DeMes;
     $axo = $l_DeAnio;

     $idia = $dia;
     $imes = $mes;
     $iaxo = $axo;
     if (!(EsValidaLaFecha(idia, imes, iaxo)==1)){ 
        return 0;
	 }
     //' --------------------------------------------

     //' --------------------------------------------
     //' Verifica que la fecha de Terminación es valida
     //' Si es fecha
     $dia = $l_ADia;
     $mes = $l_AMes;
     $axo = $l_AAnio;

     $idia = $dia;
     $imes = $mes;
     $iaxo = $axo;
     if (!EsValidaLaFecha(idia, imes, iaxo)==1){ 
        return 0;
	 }
     // ' --------------------------------------------

     // '---------------------------------------------
	 
     if (!(is_int($l_DeHora)==TRUE)){
         return 0;
	 }

     if (!(is_int($l_DeMinutos)==TRUE)){
         return 0;
	 }

     if (!($l_DeHora >= 0 && $l_DeHora < 13)){ 
        return 0;
	 }

     if (!($l_DeMinutos >= 0 && $l_DeMinutos < 60)){ 
        return 0;
	 }

     if (!(is_int($l_AHora)==TRUE)){
		 return 0;
	 }
      
     if (!(is_int($l_AMinutos)==TRUE)){
         return 0;
	 }

     if (!($l_AHora >= 0 && $l_AHora < 13)){ 
        return 0;
	 }

     if (!($l_AMinutos >= 0 && $l_AMinutos < 60)){ 
        return 0;
	 }

     if (!(strcmp($l_DeFormaHoraria,"a.m.")==0)){ 
        if (!(strcmp($l_DeFormaHoraria,"p.m.")==0)){ 
           return 0;
		}
	 }

     if (!(strcmp($l_AFormaHoraria,"a.m.")==0)){ 
        if (!(strcmp($l_AFormaHoraria,"p.m.")==0)){ 
           return 0;
		}
	 }

     // ' --------------------------------------------------
     // ' FIN DE LA VALIDACIÓN
     // ' --------------------------------------------------

     // ' --------------------------------------------------
     // ' ÁREA DE CALCULO
     // ' --------------------------------------------------
     $diaInicio2="";
     $MesInicio2="";
     $AxoInicio2="";
     $idiaInicio2=0;
     $iMesInicio2=0;
     $iAxoInicio2=0;
     $diaFin2="";
     $MesFin2="";
     $AxoFin2=""; 
     $idiaFin2=0;
     $iMesFin2=0;
     $iAxoFin2=0;
     $H1=0;
     $M1=0;
     $H2=0; 
     $M2=0;
     $Total=0.0;

     //' Fecha de Inicio
     $diaInicio2 = $l_DeDia;
     $MesInicio2 = $l_DeMes;
     $AxoInicio2 = $l_DeAnio;

     $idiaInicio2 = $diaInicio2;
     $iMesInicio2 = $MesInicio2;
     $iAxoInicio2 = $AxoInicio2;

     $H1 = $l_DeHora;
     $M1 = $l_DeMinutos;

     // ' Cargar la fecha
     if (strcmp($l_DeFormaHoraria,"p.m.")==0){ 
         $H1=$H1+12;
	 }  

     // ' Fecha de Fin
     $diaFin2 = $l_ADia;
     $MesFin2 = $l_AMes;
     $AxoFin2 = $l_AAnio;

     $idiaFin2 = $diaFin2;
     $iMesFin2 = $MesFin2;
     $iAxoFin2 = $AxoFin2;

     $H2 = $l_AHora;
     $M2 = $l_AMinutos;

     //' Cargar la fecha
     if (strcmp($l_AFormaHoraria, "p.m.")==0){ 
	     $H2=$H2+12;
	 }
     
	 $timestamp1 = mktime($H1,$M1,0,$MesInicio2,$diaInicio2,$AxoInicio2);
     $timestamp2 = mktime($H2,$M2,0,$MesFin2,$idiaFin2,$iAxoFin2);

     $segundos_diferencia = abs($timestamp1 - $timestamp2);
	 $Total=abs($segundos_diferencia /(60*60));	  
     return $Total;
  } 
}
  
}
?>
