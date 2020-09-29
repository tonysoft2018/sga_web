// ----------------------------------------------------------------------------------
// ambiente_clasificaciones_rest.ctrl.js
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 25/03/2020
// ----------------------------------------------------------------------------------
 

function Listado(datos){    
    if(datos.length>0){
        $("#modal_espera").modal("show");

        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/" + MODULO + "_consultar.ctrl.php";
 
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  
               console.log(l_Resultado);  

               var obResultado=JSON.parse(l_Resultado);
                              
               var contador=obResultado.length;
               var i=0;
               var l_Registros="";
               var l_Linea="";
               var l_Llave="";
               var l_Encabezados;
               var l_Tamaxo=0;

               // ----------------------------------------------------------------
               // Construye la respuesta de la consulta
               // Campos
               for (var campo in obResultado[0]) {
                    l_Registros=l_Registros + campo + ",";
               }
         
               // Verifica si fue exitoso
               if(obResultado[0]["retorno"]=="TRUE"){ 
                   l_Llave=obResultado[0]["llave"];

                   var l_Linea="";   

                   l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center'  style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>";
                   
                   l_Linea=l_Linea + "<div class='col-md-10 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
                   l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('Clasificacion')\">";
                   l_Linea=l_Linea + "Clasificacion";
                   l_Linea=l_Linea + "<img src='../iconos/updown.png' style='width: 10px; height: 10px; margin-left:2px;'>";
                   l_Linea=l_Linea + "</label>";
                   l_Linea=l_Linea + "</div>";
              
                   l_Linea=l_Linea + "<div class='col-md-2  justify-content-left align-items-start w-3' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;'>";                
                   l_Linea=l_Linea + "<label style='cursor:pointer;'> Acciones </label>";                
                   l_Linea=l_Linea + "</label>";
                   l_Linea=l_Linea + "</div>";
                  

                   l_Linea=l_Linea + "</div>";

                   for(i=0;i<contador;i++){     
                       // Extrae la información                       
                       l_Clasificacion=obResultado[i]["Clasificacion"];
                       
                       l_Linea=l_Linea + "<div id='id_r" + i +"' class='row h-20 aling-middle' style='border-bottom: #D9DADA 2px solid;font-size:12px;' onmouseover=\"fn_Encima("+i+")\" onmouseout=\"fn_Dejar("+i+")\">";

                       l_Linea=l_Linea + "<div class='col-md-10 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
                       l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
                       l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  l_Clasificacion + "</a>";
                       l_Linea=l_Linea  + "</label>";
                       l_Linea=l_Linea + "</div>"; 
 
                      
                       l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block  ' >";
                       l_Linea=l_Linea  + "<label style='display:inline-flex' >";                       
                       l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar.php?id=" + obResultado[i][l_Llave] +"&accion=Editar' style='color: #53BEFE;cursor:pointer; margin-right: -20px;  font-family:Arial black, Gadget, sans-serif; '> Editar </a>";
                       l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar.php?id=" + obResultado[i][l_Llave] +"&accion=Eliminar' style='color: #53BEFE;cursor:pointer; margin-right: -20px;  font-family:Arial black, Gadget, sans-serif; '> Eliminar </a>";      
                      
                       
                       l_Linea=l_Linea  + "</label>";
                       l_Linea=l_Linea + "</div>";  
                      
                       l_Linea=l_Linea + "</div>";
                   }

                   /*
                   // Carga los encabezados
                   // Verifica el numero de encabezados
                   l_Encabezados=obResultado[0]["encabezados"];

                   // Calcula el tamaño de las columnas
                   l_Tamaxo=l_Encabezados.length;
                   l_Tamaxo=103/l_Tamaxo;

                   l_Linea=l_Linea + "<div class='table-responsive table-hover' style='margin-left:-10px; width:103%'>";
                   l_Linea=l_Linea + "<table class='table'>";
                   l_Linea=l_Linea + "<thead>";
                   l_Linea=l_Linea + "<tr>";

                   for(i=0;i<l_Encabezados.length;i++){

                        if(l_Llave!=l_Encabezados[i]){

                            l_Linea=l_Linea + "<th  scope='col' class='th' style='background-color:#F4F5F5;font-size:10px; font-family:Arial Black;width:" + l_Tamaxo + "%'>";
                            l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('" + l_Encabezados[i] + "')\">";
                            l_Linea=l_Linea +  l_Encabezados[i];
                            l_Linea=l_Linea + "<img src='../iconos/updown.png' style='width: 10px; height: 10px; margin-left:2px;'>";
                            l_Linea=l_Linea + "</label>";
                            l_Linea=l_Linea + "</th>";
                        }
                   }

                   l_Linea=l_Linea + "<th scope='col' style='background-color:#F4F5F5;font-size:10px; font-family:Arial Black'> ";
                   l_Linea=l_Linea + "<label style='cursor:pointer;'> Acciones </label>";
                   l_Linea=l_Linea + "</th>";

                   l_Linea=l_Linea + "</tr>";
                   l_Linea=l_Linea + "</thead>";

                   // Carga el listado
                   l_Linea=l_Linea + "<tbody>";
                   for(i=0;i<contador;i++){     

                        l_Estatus=obResultado[i]["Estatus"];

                        l_Linea=l_Linea +  "<tr>";     
                        for (var campo in obResultado[i]) {
                            if(campo!="retorno" && campo!="msg" && campo!="llave" && campo!="especiales" && campo!="combo" && campo!="encabezados" ){
                                if(l_Llave!=campo){
                                    for(l=0;l<l_Encabezados.length;l++){

                                        if(campo==l_Encabezados[l]){
                                            l_Linea=l_Linea + " <td style='font-size:10px; font-family:Arial; width:16%'>" + obResultado[i][campo] + "</td>";       
                                            break;
                                        }
                                    }                            
                                }   
                            } else {
                                if(campo=="llave" ){
                                    l_Llave=obResultado[i]["llave"];                                    
                                }
                            }
                        }

                       
                        // Carga las acciones
                        for (var campo in obResultado[i]) {
                            if(campo!="retorno" && campo!="msg" && campo!="llave" && campo!="especiales" && campo!="combo" && campo!="encabezados" ){
                                if(l_Llave==campo){

                                    l_Linea=l_Linea + " <td style='font-size:10px; font-family:Arial; width:16%'>";  

                                    l_Linea=l_Linea  + "<label style='display:inline-flex' >";
                                    l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar.php?id=" + obResultado[i][campo] +"&accion=Editar' style='color: #53BEFE;cursor:pointer; margin-right: -20px; '>Editar </a>"
                                    l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar.php?id=" + obResultado[i][campo] +"&accion=Eliminar' style='color: #53BEFE;cursor:pointer;margin-right: -20px;' >Eliminar</a>";           

                                    l_Linea=l_Linea + "</td>";    
                                }                                   
                            }  
                        }
              




                        l_Linea=l_Linea +  "</tr>";     
                   }
                   l_Linea=l_Linea + "</tbody>";


                   l_Linea=l_Linea + "</table>";
                   l_Linea=l_Linea + "</div>";
                   */


               } else {
                l_Llave=obResultado[0]["llave"];

                // Carga los encabezados
                // Verifica el numero de encabezados
                l_Encabezados=obResultado[0]["encabezados"];

                // Calcula el tamaño de las columnas                 
                l_Linea=l_Linea + "<div class='table-responsive text-nowrap table-hover' style='margin-left:-10px; width:103%'>";
                l_Linea=l_Linea + "<table class='table'>";
         
                l_Linea=l_Linea + "<tbody>";
                l_Linea=l_Linea + "<tr>";
                l_Linea=l_Linea + "<th scope='col' colspan=12 style='background-color:#F4F5F5;font-size:10px; font-family:Arial Black'> ";
                l_Linea=l_Linea + "<label style='cursor:pointer;'> NO TIENE REGISTROS </label>";
                l_Linea=l_Linea + "</th>";
                l_Linea=l_Linea + "</tr>";
                l_Linea=l_Linea + "</tbody>"; 

                l_Linea=l_Linea + "</table>";
                l_Linea=l_Linea + "</div>";
               }
                  
               document.getElementById("contenido").innerHTML=l_Linea;  
                 $("#modal_espera").modal("hide");    
               
               obVerificar=setInterval(Ocultar_Espera,500);     
               // ----------------------------------------------------------------             
           
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}

function fn_Encima(i,actividad){    
    document.getElementById("id_r"+i).style.background="#DEE0E2";
}

function fn_Dejar(i,actividad){     
    document.getElementById("id_r"+i).style.background="#FFF";
}


function Crear(datos){	     
    console.log(datos);   
    
 
    if(datos.length>0){
       ob = JSON.stringify(datos);

       var xmlhttp = new XMLHttpRequest();
       var url = UBICACION_CONTROL + "/" + MODULO +  "_crear.ctrl.php";
      
       document.getElementById("bt_Grabar").style.visibility="hidden";
       $("#modal_espera").modal("show");

       xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;     
               console.log(l_Resultado);
                             
            
               var obResultado=JSON.parse(l_Resultado);  
             
               if(obResultado[0]["retorno"]=="TRUE"){
                   console.log("ambiente_calificaciones:correcto");  
                   
                   console.log("FOLIO:" + obResultado[0]["FOLIO"] );
                  
                   fn_Crear_Detalles_Clic(obResultado[0]["FOLIO"]);

               } else {        
                   console.log(obResultado[0]["msg"]);   
                   console.log(obResultado);                          
                   document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];   
                   $("#modal_espera").modal("hide");                             
                   $("#modal_falla").modal("show");                     
                   document.getElementById("bt_Grabar").style.visibility="visible";
                   
               }
               return obResultado;                
           }
       };

       xmlhttp.open("POST", url, true);
       xmlhttp.send(ob);
    }  else {
        console.log("NO TIENE INFORMACIÓN PARA PROCESAR");
        return "NO TIENE INFORMACIÓN PARA PROCESAR";
    }  
    
}

function Actualizar(datos){   
    if(datos.length>0){
         console.log(datos);
        ob = JSON.stringify(datos);
        var l_Folio=datos[0]["folio"];
 
        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/" + MODULO + "_actualizar.ctrl.php";
       
        document.getElementById("bt_Grabar").style.visibility="hidden";
        $("#modal_espera").modal("show");
 
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var l_Resultado=this.responseText;     
                console.log(l_Resultado);
                              
             
                var obResultado=JSON.parse(l_Resultado);  
             
                if(obResultado[0]["retorno"]=="TRUE"){
                    console.log("ambiente_calificaciones_actualizar:correcto");  
                   
                    console.log("FOLIO:" + l_Folio );   
                                        
                    fn_Crear_Detalles_Clic(l_Folio);
 
                } else {        
                   console.log(obResultado[0]["msg"]);   
                   console.log(obResultado);      
                   $("#modal_espera").modal("hide");                    
                   document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];                   
                   $("#modal_falla").modal("show");
                   document.getElementById("bt_Grabar").style.visibility="visible";
                }
                return obResultado;                
            }
        };
 
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
     }  else {
         console.log("NO TIENE INFORMACIÓN PARA PROCESAR");
         return "NO TIENE INFORMACIÓN PARA PROCESAR";
     } 
}

function Eliminar(datos){    
    if(datos.length>0){
       ob = JSON.stringify(datos);

       var xmlhttp = new XMLHttpRequest();
       var url = UBICACION_CONTROL + "/" + MODULO + "_eliminar.ctrl.php";
       
       document.getElementById("bt_Eliminar").style.visibility="hidden";
       $("#modal_espera").modal("show");

       xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  

               console.log(l_Resultado);
               var obResultado=JSON.parse(l_Resultado);
   
               if(obResultado[0]["retorno"]=="TRUE"){
                  console.log("correcto");      

                  $("#modal_espera").modal("hide");              
                  $("#modal_exitoso").modal("show");
               } else {                    
                    console.log(obResultado[0]["msg"]);   
                    console.log(obResultado);                          
                    document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];
                    $("#modal_falla").modal("show");
                    document.getElementById("bt_Grabar").style.visibility="visible";         
               }
               return obResultado;
           }
       };

       xmlhttp.open("POST", url, true);
       xmlhttp.send(ob);
    }  
}

function Estado(datos){        
    if(datos.length>0){
       ob = JSON.stringify(datos);

       var xmlhttp = new XMLHttpRequest();
       var url = UBICACION_CONTROL + "/" + MODULO + "_estado.ctrl.php";

       document.getElementById("bt_Eliminar").style.visibility="hidden";
       $("#modal_espera").modal("show");
      
       xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  

               console.log(l_Resultado);
               var obResultado=JSON.parse(l_Resultado);

               $("#modal_espera").modal("hide");
               
               if(obResultado[0]["retorno"]=="TRUE"){
                    console.log("correcto");       
                    $("#modal_espera").modal("hide");
                    $("#modal_exitoso").modal("show");
               } else {                    
                    console.log(obResultado[0]["msg"]);   
                    console.log(obResultado);                          
                    document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];
                    $("#modal_falla").modal("show");
                    document.getElementById("bt_Eliminar").style.visibility="visible";                 
               }

               return obResultado;
           }
       };

       xmlhttp.open("POST", url, true);
       xmlhttp.send(ob);
    }  
}
 
function Consultar(datos){    
    if(datos.length>0){
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/" + MODULO + "_consultar.ctrl.php";
      
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  
               console.log(l_Resultado);  

          
               var obResultado=JSON.parse(l_Resultado);
                              
               var contador=obResultado.length;
               var i=0;
               var h=0;
               var l_Registros="";                
               var l_Llave="";
               var especiales=new Array();           
               var bandEncontrado=0;
               var l_Tipo="";

               var formulariop = document.getElementById("frm_Actualizar");   

               // ----------------------------------------------------------------
               // Construye la respuesta de la consulta
               // Campos
               for (var campo in obResultado[0]) {
                    l_Registros=l_Registros + campo + ",";
               }

               for(i=0;i<contador;i++){     
                   l_Registros="";                    

                   if(obResultado[i]["retorno"]=="TRUE"){ 
                        
                       for (var campo in obResultado[i]) {

                            if(campo!="retorno" && campo!="msg" && campo!="llave" ){
                                if(l_Llave==campo){
                                   // console.log("ENCONTRADO");
                                } else {
                                
                                    if(campo=="especiales"){
                                        for (var campo_e in obResultado[i][campo]) {
                                            //console.log("ESPECIALES:" + campo_e + ":" + obResultado[i][campo][campo_e]);        
                                            especiales.push( { "campo" : campo_e, "tipo": obResultado[i][campo][campo_e] } );                                                   
                                        }                                         
                                    }

                                    //console.log(especiales);

                                    for (k=0;k<formulariop.elements.length;k++){
                                        sCampo=formulariop.elements[k].name;
                                        sCampo=sCampo.trim();
                                        if(sCampo.length>0){
                                            if(sCampo==campo){  
                                                //console.log("campo:" + sCampo);   
                                                //console.log("VALOR:" + obResultado[i][campo]);      
                                                
                                                bandEncontrado=0;
                                                l_Tipo="";
                                                for(h=0;h<especiales.length;h++){
                                                    
                                                    if(especiales[h]["campo"]==campo){
                                                        console.log("especiales:" + especiales[h]["campo"] + ":" + especiales[h]["tipo"]);
                                                        l_Tipo=especiales[h]["tipo"];
                                                        bandEncontrado=1;
                                                        break;
                                                    }
                                                }
                                                
                                                if(bandEncontrado==1){
                                                    //CHEKCBOX, RADIOBUTTON, IMAGEN
                                                    switch(l_Tipo){
                                                        case "CHEKCBOX":
                                                            if(obResultado[i][campo]=="SI"){
                                                                formulariop.elements[k].checked=true;
                                                            }
                                                            
                                                            break;
                                                        case "RADIOBUTTON":
                                                            break;
                                                        case "IMAGEN":
                                                            break;
                                                        
                                                    }

                                                } else {
                                                    formulariop.elements[k].value=obResultado[i][campo];
                                                }                                                
                                            }
                                        }     
                                    }                                                                   
                                }                                
                            } else {
                                if(campo=="llave" ){
                                    l_Llave=obResultado[i]["llave"];                                    
                                }
                            }                            
                       }                     
                   }
               }         
               
               // ----------------------------------------------------------------             
           
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}

function Ver(datos){    
    if(datos.length>0){
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/" + MODULO + "_consultar.ctrl.php";
      
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  
               console.log(l_Resultado);  

          
               var obResultado=JSON.parse(l_Resultado);
                              
               var contador=obResultado.length;
               var i=0;
               var h=0;
               var l_Registros="";
               var l_Linea="";
               var l_Llave="";
               var especiales=new Array();
               var especiales_tipo=new Array();
               var bandEncontrado=0;
               var l_Tipo="";

               var formulariop = document.getElementById("frm_Actualizar");   

               // ----------------------------------------------------------------
               // Construye la respuesta de la consulta
               // Campos
               for (var campo in obResultado[0]) {
                    l_Registros=l_Registros + campo + ",";
               }

               for(i=0;i<contador;i++){     
                   l_Registros="";                    

                   if(obResultado[i]["retorno"]=="TRUE"){ 
                        
                       for (var campo in obResultado[i]) {

                            if(campo!="retorno" && campo!="msg" && campo!="llave" ){
                                if(l_Llave==campo){
                                   // console.log("ENCONTRADO");
                                } else {
                                
                                    if(campo=="especiales"){
                                        for (var campo_e in obResultado[i][campo]) {
                                            //console.log("ESPECIALES:" + campo_e + ":" + obResultado[i][campo][campo_e]);        
                                            especiales.push( { "campo" : campo_e, "tipo": obResultado[i][campo][campo_e] } );                                                   
                                        }                                         
                                    }

                                    //console.log(especiales);

                                    for (k=0;k<formulariop.elements.length;k++){
                                        sCampo=formulariop.elements[k].name;
                                        sCampo=sCampo.trim();
                                        if(sCampo.length>0){
                                            if(sCampo==campo){  
                                                //console.log("campo:" + sCampo);   
                                                //console.log("VALOR:" + obResultado[i][campo]);      
                                                
                                                bandEncontrado=0;
                                                l_Tipo="";
                                                for(h=0;h<especiales.length;h++){
                                                    
                                                    if(especiales[h]["campo"]==campo){
                                                        console.log("especiales:" + especiales[h]["campo"] + ":" + especiales[h]["tipo"]);
                                                        l_Tipo=especiales[h]["tipo"];
                                                        bandEncontrado=1;
                                                        break;
                                                    }
                                                }

                                                formulariop.elements[k].value=obResultado[i][campo];
                                                 
                                            }
                                        }     
                                    }                                                                   
                                }                                
                            } else {
                                if(campo=="llave" ){
                                    l_Llave=obResultado[i]["llave"];                                    
                                }
                            }                            
                       }                     
                   }
               }                    
               // ----------------------------------------------------------------             
           
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}


function Ambiente_Clasificaciones_Combo(datos){ 

    if(datos.length>0){

        var nID=datos[0]["seleccion"];
        var Accion=datos[0]["accion"];

        if(Accion=="Eliminar"){
            return;
        }

        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/ambiente_clasificaciones_consultar.ctrl.php";
      
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var l_Resultado=this.responseText;  
                console.log(l_Resultado);  
            
                var obResultado=JSON.parse(l_Resultado);
                               
                var contador=obResultado.length;
                var i=0;
                var h=0;
                var l_Registros="";              
                var l_Llave="";
                
                var combos=new Array();
                var registros=new Array();
                var valores=new Array();               
                var valor=new Array();
                var registro="";
    
                // ----------------------------------------------------------------
                // Construye la respuesta de la consulta
                // Campos
                
                for(i=0;i<contador;i++){
                    l_Registros="";                    
 
                    if(obResultado[i]["retorno"]=="TRUE"){ 
 
                          // Extrae los campos combos
                          for (var campo in obResultado[i]) {
                              if(campo!="retorno" && campo!="msg" && campo!="llave" ){
                                  if(l_Llave!=campo){
                                     if(campo=="combo"){
                                         for (var campo_c in obResultado[i][campo]) {
                                             console.log("COMBOS:" + campo_c );        
                                             combos.push( { "campo" : campo_c } );                                                   
                                         }                                         
                                     }                                    
                                  }  
                              }
                          }
 
                          //console.log(combos);                      
                          l_Posicion=0;
                          for(h=0;h<combos.length;h=h+1){
 
                             for (var campo in obResultado[i]) {
                                 if(campo!="retorno" && campo!="msg" && campo!="llave" && campo!="especiales" && campo!="combo" ){
 
                                     if(campo==combos[h]["campo"]){
                                         valores.push( obResultado[i][campo]);                                          
                                     }
                                 }
                             }
                          }
 
                          //registros.push( [valores] );  
                          registro=[];
                          registros.push();
                         
                          for(h=0;h<valores.length;h=h+1){                                          
                             valor=valores[h];
                             registro.push(valor);
                              
                             
                          }
                          registros[registros.length]=registro;
               
 
                          while(valores.length > 0) {
                             valores.pop(); 
                          }
 
                          while(combos.length > 0) {
                             combos.pop(); 
                          }
                              
                         
 
                          console.log(registros);
                
                    }
                }    
 
                  // Construye la respuesta
                  l_Registros="<option value='0'>Ninguno</option>";
                  for(i=0;i<registros.length;i=i+1){
                       if(nID==registros[i][0]){
                          l_Registros=l_Registros + "<option selected value='" + registros[i][0] + "'>";                    
                       } else {
                          l_Registros=l_Registros + "<option value='" + registros[i][0] + "'>";                    
                       }
                       
                       for(j=1;j<registros[i].length;j=j+1){
                           l_Registros=l_Registros + "" + registros[i][j] + "";
                       }
                       l_Registros=l_Registros + "</option>  ";                  
                  }
   
                  console.log("Registros:"+ l_Registros);  
 
                document.getElementById("cb_nIDAmbiente_Clasificacion").innerHTML=l_Registros;  
                // ----------------------------------------------------------------             
            
            }        
         };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}

// ----------------------------------------------------------------    



function fn_Checar_Crear(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="Creacion"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}

function fn_Checar_Editar(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="Editar"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}

function fn_Checar_Borrar(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="Borrar"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}

function fn_Checar_Cancelar(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="Cancelar"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}

function fn_Checar_Consultar(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="Consultar"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}

function fn_Checar_Listar(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="Listar"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}

function fn_Checar_Ejecutar(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="Ejecutar"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}

function fn_Checar_Imprimir(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="Imprimir"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}

function fn_Checar_Etiquetas(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="Etiquetas"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}

function fn_Checar_Carga(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="Carga"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}

function fn_Checar_Excel(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="Excel"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}

function fn_Checar_PDF(){
    var formulariop = document.getElementById("frm_Detalles");   

    for (k=0;k<formulariop.elements.length;k++){
        if(formulariop.elements[k].disabled!=true){
            sCampo=formulariop.elements[k].name;
            sCampo=sCampo.trim(); 
    
             if(sCampo.length>0){
    
                l_Pos=sCampo.indexOf("_");
    
                if(l_Pos>=0){
                    l_Campo_Extraido=sCampo.substr(0,l_Pos);
                    l_Pos=l_Pos+1;
                    l_IDModulo_Extraido=sCampo.substr(l_Pos,sCampo.length);                           
                 }
    
                 console.log(l_Campo_Extraido);
    
                 if(l_Campo_Extraido=="PDF"){
                    if(formulariop.elements[k].checked==true){
                        formulariop.elements[k].checked=false;
                     } else {
                        formulariop.elements[k].checked=true;
                     }
                 }       
             }
        }
        
     }
}
 
function fn_Checar_Todos(){
    fn_Checar_Todos_Crear();
    fn_Checar_Todos_Editar();
    fn_Checar_Todos_Eliminacion();
    fn_Checar_Todos_Cancelacion();
    fn_Checar_Todos_Consultar();
    fn_Checar_Todos_Impresion();
}



// *******************************************************
// Ocultar la espera
function Ocultar_Espera(){
    $("#modal_espera").modal("hide");       
}
// *******************************************************
 