// ----------------------------------------------------------------------------------
// recibo_rest.ctrl.js
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------         
// Empresa. IDEATECH
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 07/07/2020
// ----------------------------------------------------------------------------------
// V2.0.2
// ----------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------
// LISTADO PRINCIPAL 
function Listado(datos){    
    if(datos.length>0){
        $("#modal_espera").modal("show");

        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var l_Modulo="packinglist"; // MODULO
        var url = UBICACION_CONTROL + "/" + l_Modulo + "_consultar.ctrl.php";
 
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
               var l_nID=0;
               var l_Fecha="";
               var l_Folio="";               
               var l_Proveedor="";
               var l_Comprador="";
               var l_Estatus="";


               // ----------------------------------------------------------------
               // Construye la respuesta de la consulta
               // Campos
               for (var campo in obResultado[0]) {
                    l_Registros=l_Registros + campo + ",";
               }
         
               // Verifica si fue exitoso
               if(obResultado[0]["retorno"]=="TRUE"){ 
                   l_Llave=obResultado[0]["llave"];
 
                  // Carga los encabezados
                  // Verifica el numero de encabezados
                  l_Encabezados=obResultado[0]["encabezados"];
                  
                   var l_Linea="";   

                   l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center'  style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>";

                   // Fecha
                   l_Linea=l_Linea + "<div class='col-md-2  w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
                   l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('Fecha')\">";
                   l_Linea=l_Linea + "Fecha";
                   l_Linea=l_Linea + "<img src='../iconos/updown.png' style='width: 10px; height: 10px; margin-left:2px;'>";
                   l_Linea=l_Linea + "</label>";
                   l_Linea=l_Linea + "</div>";

                   // Folio
                   l_Linea=l_Linea + "<div class='col-md-1    justify-content-left align-items-start w-3' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;'>";
                   l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('Folio')\">";
                   l_Linea=l_Linea + "Folio";
                   l_Linea=l_Linea + "<img src='../iconos/updown.png' style='width: 10px; height: 10px; margin-left:2px;'>";
                   l_Linea=l_Linea + "</label>";
                   l_Linea=l_Linea + "</div>";
                  
                   // Proveedor
                   l_Linea=l_Linea + "<div class='col-md-5  justify-content-left align-items-start w-3' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;'>";
                   l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('Proveedor')\">";
                   l_Linea=l_Linea + "Proveedor"
                   l_Linea=l_Linea + "<img src='../iconos/updown.png' style='width: 10px; height: 10px; margin-left:2px;'>";
                   l_Linea=l_Linea + "</label>";
                   l_Linea=l_Linea + "</div>";
                   
                   // Estatus
                   l_Linea=l_Linea + "<div class='col-md-2   justify-content-left align-items-start w-3' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;'>";
                   l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('Estatus')\">";
                   l_Linea=l_Linea + "Estatus";
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
                       l_nID=obResultado[i]["nIDPackingList"];
                       l_Fecha=obResultado[i]["Fecha"];
                       l_Folio=obResultado[i]["Folio"];
                       l_Proveedor=obResultado[i]["Proveedor"];
                       l_Comprador=obResultado[i]["Comprador"];                                          
                       l_Estatus=obResultado[i]["Estatus"];

                       l_Linea=l_Linea + "<div id='id_r" + i +"' class='row h-20 aling-middle' style='border-bottom: #D9DADA 2px solid;font-size:12px;' onmouseover=\"fn_Encima("+i+")\" onmouseout=\"fn_Dejar("+i+")\">";

                       l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
                       l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
                       l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  l_Fecha + "</a>";
                       l_Linea=l_Linea  + "</label>";
                       l_Linea=l_Linea + "</div>"; 

                       l_Linea=l_Linea + "<div class='col-md-1 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
                       l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
                       l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  l_Folio + "</a>";
                       l_Linea=l_Linea  + "</label>";
                       l_Linea=l_Linea + "</div>"; 


                       l_Linea=l_Linea + "<div class='col-md-5 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
                       l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
                       l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  l_Proveedor + "</a>";
                       l_Linea=l_Linea  + "</label>";
                       l_Linea=l_Linea + "</div>"; 

                       l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
                       l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
                       l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  l_Estatus + "</a>";
                       l_Linea=l_Linea  + "</label>";
                       l_Linea=l_Linea + "</div>"; 

                       l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-center w-3 d-inline-block  ' >";
                       l_Linea=l_Linea  + "<label style='display:inline-flex' >";                       
                       l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar_recepcion.php?id=" + obResultado[i][l_Llave] +"&accion=Recepcion' style='color: #53BEFE;cursor:pointer; margin-right: -20px; font-family:Arial black, Gadget, sans-serif; '> Recibir </a>"
                       l_Linea=l_Linea  + "</label>";
                       l_Linea=l_Linea + "</div>";  
                      
                       l_Linea=l_Linea + "</div>";
                   }

               } else {
                    l_Llave=obResultado[0]["llave"];

                    // Carga los encabezados
                    // Verifica el numero de encabezados
                    l_Encabezados=obResultado[0]["encabezados"];

                    // Calcula el tamaño de las columnas
                    l_Tamaxo=l_Encabezados.length;
                    l_Tamaxo=103/l_Tamaxo;

                    l_Linea=l_Linea + "<div class='table-responsive text-nowrap table-hover' style='margin-left:-10px; width:103%'>";
                    l_Linea=l_Linea + "<table class='table'>";
                    l_Linea=l_Linea + "<thead>";
                    l_Linea=l_Linea + "<tr>";

                  
                     l_Linea=l_Linea + "<th scope='col' style='background-color:#F4F5F5;font-size:10px; font-family:Arial Black'> ";
                     l_Linea=l_Linea + "<label style='cursor:pointer;'> NO TIENE REGISTROS </label>";
                     l_Linea=l_Linea + "</th>";

                     l_Linea=l_Linea + "</tr>";
                     l_Linea=l_Linea + "</thead>";

                     l_Linea=l_Linea + "<tbody>";
                     l_Linea=l_Linea + "<tr>";
                     l_Linea=l_Linea + "<th scope='col' style='font-size:10px; font-family:Arial Black'> ";
                     
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
// ----------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------
// GENERALES
function fn_Encima(i,actividad){   
    document.getElementById("id_r"+i).style.background="#DEE0E2";
}

function fn_Dejar(i,actividad){    
    document.getElementById("id_r"+i).style.background="#FFF";
}
// ----------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------
// DETALLES
function Consultar_Recibo(datos){    
    if(datos.length>0){
        
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/packinglist_consultar_todos.ctrl.php";
      
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  
               console.log(l_Resultado);  

          
               var obResultado=JSON.parse(l_Resultado);
               var i=0;        
                
               if(obResultado[i]["retorno"]=="TRUE"){ 
                    document.getElementById("txt_Folio").value=obResultado[i]["Folio"];
                    document.getElementById("txt_Fecha").value=obResultado[i]["Fecha"];
                                    
               }            
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}




// ----------------------------------------------------------------------------------








 



function Consultar(datos){    
    if(datos.length>0){
        $("#modal_espera").modal("show");
        var l_Accion=datos[0]["accion"];

        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/packinglist_consultar.ctrl.php";
      
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
              $("#modal_espera").modal("hide");                   
              obVerificar=setInterval(Ocultar_Espera,500);               
           
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}

// Ocultar la espera


function Recibo_CambiarEstatus(datos){	 
    console.log("CTRL");    
    console.log(datos);   
    
 
    if(datos.length>0){
       ob = JSON.stringify(datos);

       var xmlhttp = new XMLHttpRequest();
       var url = UBICACION_CONTROL + "/packinglist_estatus.ctrl.php";
      
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;     
               console.log(l_Resultado);

               var obResultado=JSON.parse(l_Resultado);  
                
               if(obResultado[0]["retorno"]=="TRUE"){
                   console.log("correcto");                          
                   $("#modal_exitoso").modal("show"); 
               } else {        
                   console.log(obResultado[0]["msg"]);   
                   console.log(obResultado);                          
                   document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];                   
                   $("#modal_falla").modal("show");
                   document.getElementById("bt_Recibo").style.visibility="visible";
                    
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



function ValidarParaRecibir(datos){    
    if(datos.length>0){
        var l_nID=datos[0]["nidpackinglist"];
        $("#modal_espera").modal("show");

        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();      
        var url = UBICACION_CONTROL + "/packinglist_deta_consultar_etiquetado.ctrl.php";
 
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  
               console.log(l_Resultado);  

               var obResultado=JSON.parse(l_Resultado);

               $("#modal_espera").modal("hide");    
               
               obVerificar=setInterval(Ocultar_Espera,500); 
                 
               // Verifica si fue exitoso
               if(obResultado[0]["retorno"]=="TRUE"){ 
                    window.open("recibo_editar_recepcion.php?id="+l_nID + "&accion=Recepcion","_self")  
               } else {
                   console.log("ERROR NO TIENE CONSULTA");
                   document.getElementById("lbl_mensaje_falla").innerHTML="PACKINGLIST NO ETIQUETADO";
                   $("#modal_falla").modal("show");
                   return;
               }
               // ----------------------------------------------------------------             
           
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}
// ************************************************************************************************

 