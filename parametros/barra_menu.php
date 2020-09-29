<?php
// ----------------------------------------------------------------------------------
// barra_menu.php
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Descripcion.  Es utilizada para indicar la ubicacion del sistema
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 06/11/2019
// ----------------------------------------------------------------------------------
 
include_once "../parametros/env.php";          

// ----------------------------------------------
date_default_timezone_set("America/Mexico_City");
// ----------------------------------------------

?>

<script>     
    var UBICACION_CONTROL="<?php echo $UBICACION_CONTROL ?>";
    var NUMERODESESION="<?php echo $_SESSION['NUMERODESESION'] ?>";

    function detec() { 
  
        if (navigator.userAgent.match(/Android/i) 
            || navigator.userAgent.match(/webOS/i) 
            || navigator.userAgent.match(/iPhone/i)  
            || navigator.userAgent.match(/iPad/i)  
            || navigator.userAgent.match(/iPod/i) 
            || navigator.userAgent.match(/BlackBerry/i) 
            || navigator.userAgent.match(/Windows Phone/i)) { 
            return true; 
        } else { 
            return false; 
        }    
    }
   
    if(detec()){ 
        // Movil
        fn_Configurar_Menus("MOVIL",NUMERODESESION);
    }  else {
        fn_Configurar_Menus("PC",NUMERODESESION);
    }

    function fn_Configurar_Menus(l_Tipo,l_Sesion){
        
        // Procesar
        l_Linea="";
        var arreglo=new Array();
        arreglo.push( { "tipo":l_Tipo, "sesion":l_Sesion } );     

        if(arreglo.length>0){                  
            ob = JSON.stringify(arreglo);

            var xmlhttp = new XMLHttpRequest();
            var url = UBICACION_CONTROL + "/configurar_menu.ctrl.php";

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var l_Resultado=this.responseText;  
                    console.log(l_Resultado);  

                    var obResultado=JSON.parse(l_Resultado);
                 
                    // Verifica si fue exitoso
                    if(obResultado[0]["retorno"]=="TRUE"){ 
  
                        l_Linea=obResultado[0]["regresar"];
                    } else {
                        l_Linea=obResultado[0]["regresar"];
                    }
          
                    document.getElementById("id_menu").innerHTML=l_Linea;                             
                }        
            };

            xmlhttp.open("POST", url, true);
            xmlhttp.send(ob);
        } else {
            console.log("ERROR NO SE CARGO LA INFORMACIÓN");
        }
    }
</script>

 <div id='id_menu' class="col-12">
 </div>		

  <script>
     function fn_Abrir(l_Indice){
     
        if(document.getElementById(l_Indice).style.display=="block"){
            document.getElementById(l_Indice).style.display="none";
        } else {
            document.getElementById(l_Indice).style.display="block";
        }

    }     
</script>
		 