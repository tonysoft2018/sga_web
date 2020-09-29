<?php
 // ----------------------------------------------------------------------------------
// utilerias.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion. Almacena metodos de utilerias globales para el sistema
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 06/11/2019
// ----------------------------------------------------------------------------------

function EsNumericoEntero($l_Valor){
 
    $bandNumero=1;
    for($i=0;$i<strlen($l_Valor);$i++){
        $l_Dato=substr($l_Valor,$i,1);
 
        if($l_Dato!="1" && $l_Dato!="2" && $l_Dato!="3" && $l_Dato!="4" && $l_Dato!="5" && $l_Dato!="6" && $l_Dato!="7" && $l_Dato!="8" && $l_Dato!="9" && $l_Dato!="0"){
            $bandNumero=0;
        }
    }

    return $bandNumero;
}

function EsNumericoDecimal($l_Valor){
    $bandNumero=1;
    for($i=0;$i<strlen($l_Valor);$i++){
        $l_Dato=substr($l_Valor,$i,1);

        if($l_Dato!="1" && $l_Dato!="2" && $l_Dato!="3" && $l_Dato!="4" && $l_Dato!="5" && $l_Dato!="6" && $l_Dato!="7" && $l_Dato!="8" && $l_Dato!="9" && $l_Dato!="0" && $l_Dato!="." ){
            $bandNumero=0;
        }
    }

    return $bandNumero;
}
 

function ValidarFecha($axo,$mes,$dia){
    $bandFecha=1;

    if(EsNumericoEntero($axo)){
        $iAxo=intval($axo);

        if($iAxo<1980 || $iAxo>2050){
            $bandFecha=0;
        } else {

            // Evaluar el mes
            if(EsNumericoEntero($axo)){
                $iMes=intval($mes);
                 
                if($iMes<1 || $iMes>12){
                    $bandFecha=0;
                } else {

                    // Evaluar el dia
                    if(EsNumericoEntero($dia)){
                        $iDia=intval($dia);

                        if($iMes==2){                                     
                            if($iDia<1 ||  $iDia>29){                                       
                                $bandFecha=0;
                            }
                        } else {
                            if($iMes==4 || $iMes==6 || $iMes==9 || $iMes==11 ) {
                                if($iDia<1 || $iDia>30){
                                    $bandFecha=0;
                                }

                            } else {
                                if($iDia<1 || $iDia>31){
                                    $bandFecha=0;
                                }
                            }
                        }
                    } else {
                        $bandFecha=0;
                    }
                }

            } else {
                $bandFecha=0;
            }
        }
    } else {
        $bandFecha=0;
    }

    return $bandFecha;
}

function EsFecha($l_Valor){
    $bandFecha=1;

    $tamaxo=strlen($l_Valor);

    switch($tamaxo){
        case 8:  // aaaammdd

            $axo=substr($l_Valor,0,4);
            $mes=substr($l_Valor,4,2);
            $dia=substr($l_Valor,6,2);
 
            if(!ValidarFecha($axo,$mes,$dia)){ 
                $bandFecha==0;
            }

            break;
        case 10: // aaaa-mm-dd  

            $axo=substr($l_Valor,0,4);
            $mes=substr($l_Valor,5,2);
            $dia=substr($l_Valor,8,2);
 
            if(!ValidarFecha($axo,$mes,$dia)){ 
                $bandFecha=0;
            }

            break;
        case 19: // aaaa-mm-dd HH:mm:ss 
            $axo=substr($l_Valor,0,4);
            $mes=substr($l_Valor,5,2);
            $dia=substr($l_Valor,8,2);

            $HH=substr($l_Valor,11,2);
            $mm=substr($l_Valor,14,2);
            $ss=substr($l_Valor,17,2);
 
            if(!ValidarFecha($axo,$mes,$dia)){ 
                $bandFecha=0;
            } else {
                // Valida la hora
                if(EsNumericoEntero($HH)){
                    $iHH=intval($HH);

                    if($iHH<0 || $iHH>23){
                        $bandFecha=0;
                    } else {
                        if(EsNumericoEntero($mm)){
                            $imm=intval($mm);
                            if($imm<0 || $imm>59){
                                $bandFecha=0;
                            } else {
                                if(EsNumericoEntero($ss)){
                                    $iss=intval($ss);

                                    if($iss<0 || $iss>59){
                                        $bandFecha=0;
                                    }  
                                } else {
                                    $bandFecha=0;
                                }
                            }
                        } else {
                            $bandFecha=0;
                        }
                    }
                } else {
                    $bandFecha=0;
                }
            }
      
            break;
    }
 

    return $bandFecha;
}


?>

 