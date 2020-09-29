// ----------------------------------------------------------------------------------
// utilerias.js
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 29/08/2019
// ----------------------------------------------------------------------------------

function validarSiNumero(numero){
    if (!/^([0-9])*$/.test(numero)){ 
        return false;
    } else {
        return true;
    }    
  }
 
function fn_Encima(i,actividad){    
    document.getElementById("id_r"+i).style.background="#DEE0E2";
}

function fn_Dejar(i,actividad){     
    document.getElementById("id_r"+i).style.background="#FFF";
}