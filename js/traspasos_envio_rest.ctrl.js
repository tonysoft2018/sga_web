// ----------------------------------------------------------------------------------
// traspasos_envio_rest.ctrl.js
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. IDEATECH
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 13/07/2020
// ----------------------------------------------------------------------------------
// V2.0.2
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

                  // Fecha
                  l_Linea=l_Linea + "<div class='col-md-2 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
                  l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('Fecha')\">";
                  l_Linea=l_Linea + "Fecha";
                  l_Linea=l_Linea + "<img src='../iconos/updown.png' style='width: 10px; height: 10px; margin-left:2px;'>";
                  l_Linea=l_Linea + "</label>";
                  l_Linea=l_Linea + "</div>";
                
                  l_Linea=l_Linea + "<div class='col-md-1    justify-content-left align-items-start w-3' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;'>";
                  l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('OrdenDeSurtido_Folio')\">";
                  l_Linea=l_Linea + "Folio";
                  l_Linea=l_Linea + "<img src='../iconos/updown.png' style='width: 10px; height: 10px; margin-left:2px;'>";
                  l_Linea=l_Linea + "</label>";
                  l_Linea=l_Linea + "</div>";
                                  
                  l_Linea=l_Linea + "<div class='col-md-2 justify-content-left align-items-start w-3' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;'>";
                  l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('Almacen_Origen')\">";
                  l_Linea=l_Linea + "Almacén Origen"
                  l_Linea=l_Linea + "<img src='../iconos/updown.png' style='width: 10px; height: 10px; margin-left:2px;'>";
                  l_Linea=l_Linea + "</label>";
                  l_Linea=l_Linea + "</div>";
                 
                  l_Linea=l_Linea + "<div class='col-md-2  justify-content-left align-items-start w-3' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;'>";
                  l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('Almacen_Destino')\">";
                  l_Linea=l_Linea + "Almacén Destino"
                  l_Linea=l_Linea + "<img src='../iconos/updown.png' style='width: 10px; height: 10px; margin-left:2px;'>";
                  l_Linea=l_Linea + "</label>";
                  l_Linea=l_Linea + "</div>";
                  
                  // Estatus
                  l_Linea=l_Linea + "<div class='col-md-2  justify-content-left align-items-start w-3' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;'>";
                  l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('Estatus')\">";
                  l_Linea=l_Linea + "Estatus";
                  l_Linea=l_Linea + "<img src='../iconos/updown.png' style='width: 10px; height: 10px; margin-left:2px;'>";
                  l_Linea=l_Linea + "</label>";
                  l_Linea=l_Linea + "</div>";

                  l_Linea=l_Linea + "<div class='col-md-3  justify-content-left align-items-start w-3' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;'>";                
                  l_Linea=l_Linea + "<label style='cursor:pointer;'> Acciones </label>";                
                  l_Linea=l_Linea + "</label>";
                  l_Linea=l_Linea + "</div>";
                 

                  l_Linea=l_Linea + "</div>";

                  for(i=0;i<contador;i++){     
                    // Extrae la información                       
                    l_Fecha=obResultado[i]["Fecha"];
                    l_Folio=obResultado[i]["OrdenDeSurtido_Folio"];
                    l_Almacen_Origen=obResultado[i]["Almacen_Origen"];
                    l_Almacen_Destino=obResultado[i]["Almacen_Destino"];
                    l_Creador=obResultado[i]["Nombre"];                                          
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


                    l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
                    l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
                    l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  l_Almacen_Origen + "</a>";
                    l_Linea=l_Linea  + "</label>";
                    l_Linea=l_Linea + "</div>"; 

                    l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
                    l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
                    l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " + l_Almacen_Destino + "</a>";
                    l_Linea=l_Linea  + "</label>";
                    l_Linea=l_Linea + "</div>"; 
 

                    l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
                    l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
                    l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  l_Estatus + "</a>";
                    l_Linea=l_Linea  + "</label>";
                    l_Linea=l_Linea + "</div>"; 

                    l_Linea=l_Linea + "<div class='col-md-3 justify-content-start align-items-left w-3 d-inline-block  ' >";
                    l_Linea=l_Linea  + "<label style='display:inline-flex' >";                       
                    l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar.php?id=" + obResultado[i][l_Llave] +"&accion=Detalles' style='color: #53BEFE;cursor:pointer; margin-right: -20px;  font-family:Arial black, Gadget, sans-serif; '> Detalles </a>"
                    if(l_Estatus=="ABIERTO"){
                        l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar.php?id=" + obResultado[i][l_Llave] +"&accion=Cancelar' style='color: #53BEFE;cursor:pointer; margin-right: -20px; font-family:Arial black, Gadget, sans-serif; '> Cancelar </a>"
                    }
                    if(l_Estatus=="CERRADO"){
                        l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar.php?id=" + obResultado[i][l_Llave] +"&accion=Imprimir' style='color: #53BEFE;cursor:pointer; margin-right: -20px; font-family:Arial black, Gadget, sans-serif; '> Cancelar </a>"

                    }
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
       var url = UBICACION_CONTROL + "/" + MODULO +  "_grabar.ctrl.php";
      
       document.getElementById("bt_Grabar").style.visibility="hidden";
       $("#modal_espera").modal("show");

       xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;     
               console.log(l_Resultado);
                             
            
               var obResultado=JSON.parse(l_Resultado);  
               
               $("#modal_espera").modal("hide");

               if(obResultado[0]["retorno"]=="TRUE"){
                    $("#modal_espera").modal("hide");
                    $("#modal_exitoso").modal("show");                    

               } else {        
                   console.log(obResultado[0]["msg"]);   
                   console.log(obResultado);                          
                   document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];                   
                   $("#modal_falla").modal("show");
                   document.getElementById("bt_Grabar").style.visibility="visible";
                   obVerificar=setInterval(Ocultar_Espera,500);  
                    
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


function Cancelar_Traspaso(datos){    
    if(datos.length>0){         
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/traspasos_cancelar.ctrl.php";
 
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  
               console.log(l_Resultado);  

               var obResultado=JSON.parse(l_Resultado);
                              
               var contador=obResultado.length;
               var i=0;    
               var l_Linea="";

               // ----------------------------------------------------------------
               // Construye la respuesta de la consulta
               // Campos          
               if(contador>0){
                  for(i=0;i<contador;i++){     
                    l_Registros="";
                     
 
                    if(obResultado[i]["retorno"]=="TRUE"){ 
                        $("#modal_exitoso").modal("show");

                        // Actividades a realizar
                        
                    } else {
                        // No se guardo la ubicacion
                        console.log(obResultado[0]["msg"]);   
                        console.log(obResultado);                          
                        document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];                   
                        $("#modal_falla").modal("show");                   
                    }
                     
                  }     
               } else {
                    console.log(obResultado[0]["msg"]);   
                    console.log(obResultado);                          
                    document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];                   
                    $("#modal_falla").modal("show");
               }                 
               // ----------------------------------------------------------------                        
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}

// Ocultar la espera
function Ocultar_Espera(){
    $("#modal_espera").modal("hide");       
}

// -----------------------------------------------
// Detalles
function Listado_PorFolio(datos){    
    if(datos.length>0){
         
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/ordendesurtido_deta_consultar_todos.ctrl.php";
 
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  
               //console.log(l_Resultado);  

               var obResultado=JSON.parse(l_Resultado);
                              
               var contador=obResultado.length;
               var i=0;
               var l_Registros="";
               var l_Linea="";               

               // ----------------------------------------------------------------
               // Construye la respuesta de la consulta
               // Campos
               for (var campo in obResultado[0]) {
                    l_Registros=l_Registros + campo + ",";
               }

               if(obResultado[i]["retorno"]=="TRUE"){ 
                    for(i=0;i<contador;i++){     
                        l_Registros="";
                        l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>";
    
                        if(obResultado[i]["retorno"]=="TRUE"){ 
    
                            l_nIDOrdenDeSurtido_Deta=obResultado[i]["nIDOrdenDeSurtido_Deta"];
                            l_nIDOrdenDeSurtido=obResultado[i]["nIDOrdenDeSurtido"];
                            l_nIDProducto=obResultado[i]["nIDProducto"];
                            l_Codigo=obResultado[i]["Codigo_IZeta"];
                            l_Producto=obResultado[i]["Producto"];
                            l_UnidadDeMedida=obResultado[i]["UnidadDeMedida"];
                            l_Cantidad=obResultado[i]["Cantidad"];
                            l_Estatus=obResultado[i]["Estatus"];
                        
                            fn_Agregar(l_nIDOrdenDeSurtido_Deta,l_nIDOrdenDeSurtido, l_nIDProducto, l_Codigo, l_Producto, l_UnidadDeMedida, l_Cantidad, l_Estatus);
                            fn_Ver_ListadoDeProductos_Estatus();
    
                            document.getElementById("txt_nIDOrdenDeSurtido").value=l_nIDOrdenDeSurtido;
                            document.getElementById("txt_Etiqueta").value="";
                            document.getElementById("txt_Etiqueta").select();

                            document.getElementById("bt_BuscarOrden").style.visibility="hidden";
                            document.getElementById("bt_CancelarOrden").style.visibility="visible";
                            document.getElementById("txt_OrdenDeSurtido").readOnly = true;

                            var l_Resumen=obResultado[0]["Folio"] + "," + obResultado[0]["Fecha"];
                            document.getElementById("lbl_Datos").innerHTML=l_Resumen;
                            
                        }                    
                    }    

                } else {
                        // No se guardo la ubicacion
                     console.log(obResultado[0]["msg"]);   
                     console.log(obResultado);                          
                     document.getElementById("lbl_mensaje_falla").innerHTML="ORDEN DE SURTIDO NO EXISTENTE O PROCESADA"              
                     $("#modal_falla").modal("show");    
                     $("#modal_espera").modal("hide");    
               
                     obVerificar=setInterval(Ocultar_Espera,500);      
                }
 
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}

function fn_Agregar(l_nIDOrdenDeSurtido_Deta,l_nIDOrdenDeSurtido,l_nIDProducto, l_Codigo, l_Producto, l_UnidadDeMedida, l_Cantidad, l_Estatus){
  
    l_Codigo=l_Codigo.trim();
    l_Producto=l_Producto.trim();
    l_UnidadDeMedida=l_UnidadDeMedida.trim();
    
    listadodeproductos.push( { "nidordendesurtido_deta":l_nIDOrdenDeSurtido_Deta,"nidordendesurtido":l_nIDOrdenDeSurtido,"nidproducto":l_nIDProducto,"codigo": l_Codigo, "producto":l_Producto, "unidaddemedida":l_UnidadDeMedida, "cantidad":l_Cantidad, "estatus":l_Estatus } );         
}


function fn_Ver_ListadoDeProductos_Estatus(){

     
    // Presenta la inforamción en la pantalla   
    var l_Linea="";
    l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center'  style='border-bottom: #D9DADA 2px solid;'>";

    l_Linea=l_Linea + "<div class='col-md-2  w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
    l_Linea=l_Linea + "<label id='campo_" + 0 + "'>";
    l_Linea=l_Linea +  "Código";     
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-3  w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
    l_Linea=l_Linea + "<label id='campo_" + 0 + "'>";
    l_Linea=l_Linea +  "Descripción";     
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-3  w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
    l_Linea=l_Linea + "<label id='campo_" + 0 + "'>";
    l_Linea=l_Linea +  "Unidad de Medida";     
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-2  w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
    l_Linea=l_Linea + "<label id='campo_" + 0 + "'>";
    l_Linea=l_Linea +  "Cantidad";     
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-2  w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
    l_Linea=l_Linea + "<label id='campo_" + 0 + "'>";
    l_Linea=l_Linea +  "Estatus";     
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";
  
    l_Linea=l_Linea + "</div>";

 
    
    for(i=0;i<listadodeproductos.length;i++){
        if(listadodeproductos[i]["estatus"]=="LEIDO"){
            /*
            l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer; background-color:#2ECC71 '>";

            l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>";
            l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["codigo"] + "</label>";
            l_Linea=l_Linea + "</div>";  
    
            l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:left; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>";
            l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["producto"] + "</label>";
            l_Linea=l_Linea + "</div>";  
    
            l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>";
            l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["unidaddemedida"] + "</label>";
            l_Linea=l_Linea + "</div>";  
    
            l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>";
            l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["cantidad"] + "</label>";
            l_Linea=l_Linea + "</div>";    

            l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>";
            l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["estatus"] + "</label>";
            l_Linea=l_Linea + "</div>";     
     
            l_Linea=l_Linea + "</div>";
            */

            l_Linea=l_Linea + "<div id='id_r" + i +"' class='row align-item-end h-20 align-items-start ' style='border-bottom: #D9DADA 2px solid;font-size:12px;background-color:#2ECC71' onmouseover=\"fn_Encima("+i+")\" onmouseout=\"fn_Dejar("+i+")\">";

            l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
            l_Linea=l_Linea + "<label>" +   listadodeproductos[i]["codigo"] + "</label>";
            l_Linea=l_Linea + "</div>"; 
    
            l_Linea=l_Linea + "<div class='col-md-4 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
            l_Linea=l_Linea + "<label>" +  listadodeproductos[i]["producto"] + "</label>";
            l_Linea=l_Linea + "</div>";  
     
            l_Linea=l_Linea + "<div class='col-md-4 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
            l_Linea=l_Linea + "<label>" +  listadodeproductos[i]["unidaddemedida"] + "</label>";
            l_Linea=l_Linea + "</div>";  
    
            l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
            l_Linea=l_Linea + "<label>" +  listadodeproductos[i]["cantidad"] + "</label>";
            l_Linea=l_Linea + "</div>"; 

            l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
            l_Linea=l_Linea + "<label>" +  listadodeproductos[i]["estatus"] + "</label>";
            l_Linea=l_Linea + "</div>"; 
    
            l_Linea=l_Linea + "</div>";

        } else {
            l_Linea=l_Linea + "<div id='id_r" + i +"' class='row align-item-end h-20 align-items-start ' style='border-bottom: #D9DADA 2px solid;font-size:12px;' onmouseover=\"fn_Encima("+i+")\" onmouseout=\"fn_Dejar("+i+")\">";

            l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
            l_Linea=l_Linea + "<label>" +   listadodeproductos[i]["codigo"] + "</label>";
            l_Linea=l_Linea + "</div>"; 

            l_Linea=l_Linea + "<div class='col-md-4 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
            l_Linea=l_Linea + "<label>" +  listadodeproductos[i]["producto"] + "</label>";
            l_Linea=l_Linea + "</div>";  
 
            l_Linea=l_Linea + "<div class='col-md-4 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
            l_Linea=l_Linea + "<label>" +  listadodeproductos[i]["unidaddemedida"] + "</label>";
            l_Linea=l_Linea + "</div>";  

            l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
            l_Linea=l_Linea + "<label>" +  listadodeproductos[i]["cantidad"] + "</label>";
            l_Linea=l_Linea + "</div>"; 

            l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
            l_Linea=l_Linea + "<label>" +  listadodeproductos[i]["estatus"] + "</label>";
            l_Linea=l_Linea + "</div>"; 

            l_Linea=l_Linea + "</div>";

        }
        
    }

    document.getElementById("contenido_productos").innerHTML=l_Linea;  
}


function Grabar_Traspaso_Lectura(datos){    
    if(datos.length>0){         
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/traspasos_grabar_lectura.ctrl.php";
 
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  
               console.log(l_Resultado);  

               var obResultado=JSON.parse(l_Resultado);
                              
               var contador=obResultado.length;
               var i=0;    
               
               // ----------------------------------------------------------------
               // Construye la respuesta de la consulta
               // Campos          
               if(contador>0){
                  for(i=0;i<contador;i++){     
                    l_Registros="";
                     
 
                    if(obResultado[i]["retorno"]=="TRUE"){ 
                        $("#modal_exitoso").modal("show");

                        // Actividades a realizar
                        
                    } else {
                        // No se guardo la ubicacion
                        console.log(obResultado[0]["msg"]);   
                        console.log(obResultado);                          
                        document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];                   
                        $("#modal_falla").modal("show");                   
                    }
                     
                  }     
               } else {
                    console.log(obResultado[0]["msg"]);   
                    console.log(obResultado);                          
                    document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];                   
                    $("#modal_falla").modal("show");
               }                 
               // ----------------------------------------------------------------                        
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}


function fn_Eliminar_ListadoProductos(){
   
    for(i=0;i<listadodeproductos.length;i++){
        listadodeproductos.pop();
    }
 
    fn_Ver_ListadoDeProductos_Estatus();

}

function Consultar_OrdenDeSurtido(datos){    
    if(datos.length>0){       
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/ordendesurtido_consultar_todos.ctrl.php";
 
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  
               console.log(l_Resultado);  

               var obResultado=JSON.parse(l_Resultado);
                              
               var contador=obResultado.length;
               var i=0;    
               


               // ----------------------------------------------------------------
               // Construye la respuesta de la consulta
               // Campos          
               if(contador>0){
                  for(i=0;i<contador;i++){     
                    l_Registros="";
                     
 
                    if(obResultado[i]["retorno"]=="TRUE"){ 
                        //$("#modal_exitoso").modal("show");

                        document.getElementById("txt_IDCat_Almacen_Origen").value=obResultado[i]["nIDCat_Almacen_Origen"];
                        document.getElementById("txt_Almacen_Origen").value=obResultado[i]["Almacen_Origen"];
                        document.getElementById("txt_IDCat_Almacen_Destino").value=obResultado[i]["nIDCat_Almacen_Destino"];
                        document.getElementById("txt_Almacen_Destino").value=obResultado[i]["Almacen_Destino"];

                        document.getElementById("txt_Entrega").select();
                    } else {
                        // No se guardo la ubicacion
                        console.log(obResultado[0]["msg"]);   
                        console.log(obResultado);                          
                        document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];                   
                        $("#modal_falla").modal("show");                   
                    }
                     
                  }     
               } else {
                    console.log(obResultado[0]["msg"]);   
                    console.log(obResultado);                          
                    document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];                   
                    $("#modal_falla").modal("show");
               }                 
               // ----------------------------------------------------------------                        
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}
// ******************************************************************

 