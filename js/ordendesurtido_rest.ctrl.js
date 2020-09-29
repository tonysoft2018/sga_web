// ----------------------------------------------------------------------------------
// ordendesurtido_rest.ctrl.js
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
                  l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('Folio')\">";
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
                  l_Linea=l_Linea + "<div class='col-md-3  justify-content-left align-items-start w-3' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;'>";
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
                    l_Fecha=obResultado[i]["Fecha"];
                    l_Folio=obResultado[i]["Folio"];
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
 

                    l_Linea=l_Linea + "<div class='col-md-3 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
                    l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
                    l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  l_Estatus + "</a>";
                    l_Linea=l_Linea  + "</label>";
                    l_Linea=l_Linea + "</div>"; 

                    l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block  ' >";
                    l_Linea=l_Linea  + "<label style='display:inline-flex' >";                       
                    l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar.php?id=" + obResultado[i][l_Llave] +"&accion=Detalles' style='color: #53BEFE;cursor:pointer; margin-right: -20px;  font-family:Arial black, Gadget, sans-serif; '> Detalles </a>"
                    if(l_Estatus=="NO PROCESADO" || l_Estatus=="ORDEN SURTIDA - PENDIENTE EMBARCAR"){
                     l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar.php?id=" + obResultado[i][l_Llave] +"&accion=Cancelar' style='color: #53BEFE;cursor:pointer; margin-right: -20px; font-family:Arial black, Gadget, sans-serif; '> Cancelar </a>"
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
               // ----------------------------------------------------------------       

               document.getElementById("contenido").innerHTML=l_Linea;  
               $("#modal_espera").modal("hide");    
               
               obVerificar=setInterval(Ocultar_Espera,500);                
                     
           
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
       var url = UBICACION_CONTROL + "/ordendesurtido_grabar.ctrl.php";
      
       document.getElementById("bt_Grabar").style.visibility="hidden";
       $("#modal_espera").modal("show");

       xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;     
               console.log(l_Resultado);
                             
            
               var obResultado=JSON.parse(l_Resultado);  
               
               $("#modal_espera").modal("hide");

               if(obResultado[0]["retorno"]=="TRUE"){
                   console.log("FOLIO:" + obResultado[0]["FOLIO"] );
                   $("#modal_espera").modal("hide");      
                   $("#modal_exitoso").modal("show");                    

               } else {        
                   console.log(obResultado[0]["msg"]);   
                   console.log(obResultado);                          
                   document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];                   
                   $("#modal_falla").modal("show");
                   document.getElementById("bt_Grabar").style.visibility="visible";
                   $("#modal_espera").modal("hide");
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
                    $("#modal_espera").modal("hide");
                    obVerificar=setInterval(Ocultar_Espera,500);                        
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
        $("#modal_espera").modal("show");

        var l_Accion=datos[0]["accion"];

        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/" + MODULO + "_consultar_todos.ctrl.php";
      
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
function Ocultar_Espera(){
    $("#modal_espera").modal("hide");       
}

function Anexar_Producto(datos){    
    if(datos.length>0){
        var l_Codigo=datos[0]["codigo_izeta"];
        var l_nIDUsuario=datos[0]["nidusuario"];
        var l_nIDCat_Almacen_Origen=datos[0]["nidcat_almacen_origen"];
        var l_nIDCat_Almacen_Destino=datos[0]["nidcat_almacen_destino"];
        var l_Comentarios=datos[0]["comentarios"];
     
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/cat_productos_consultar_datos.ctrl.php";
 
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  
               console.log(l_Resultado);  

               var obResultado=JSON.parse(l_Resultado);
                              
               var contador=obResultado.length;
               var i=0;    
               var l_nIDProducto=0;               
               var l_Producto="";
               var l_UnidadDeMedida="";
               var l_Cantidad=0;



               // ----------------------------------------------------------------
               // Construye la respuesta de la consulta
               // Campos          
              if(contador>0){
                  for(i=0;i<contador;i++){     
                    l_Registros="";
                    
 
                    if(obResultado[i]["retorno"]=="TRUE"){ 
                         l_nIDProducto=obResultado[i]["nidproducto"];
                         l_Producto=obResultado[i]["producto"];
                         l_Descripcion=obResultado[i]["descripcion"];
                         l_UnidadDeMedida=obResultado[i]["unidaddemedida"];


                         fn_Agregar(l_nIDProducto, l_Codigo, l_Producto, l_UnidadDeMedida, l_Cantidad, l_nIDCat_Almacen_Origen, l_Comentarios, l_nIDCat_Almacen_Destino, l_nIDUsuario);                          

                    } else {
                        document.getElementById("lbl_mensaje_falla").innerHTML="Codigo NO encontrado";             
                        $("#modal_falla").modal("show");
                         break;
                    }
                     
                  }     
             } else {
                   

             }   
              
             // ----------------------------------------------------------------                        
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}

function fn_Agregar(l_nIDProducto, l_Codigo, l_Producto, l_UnidadDeMedida, l_Cantidad, l_nIDCat_Almacen_Origen, l_Comentarios, l_nIDCat_Almacen_Destino, l_nIDUsuario){

    // Lee los valores capturados    
    l_Cant=0;
    for(i=0;i<listadodeproductos.length;i++){
        l_Cant=document.getElementById("txt_Cantidad_"+i).value;
        if (isNaN(l_Cant)) {
            document.getElementById("lbl_mensaje_falla").innerHTML="Cantidad Invalida";             
            $("#modal_falla").modal("show");
            
            return;
        } else {
            listadodeproductos[i]["cantidad"]=l_Cant
        }
    }
    
    l_Codigo=l_Codigo.trim();
    l_Producto=l_Producto.trim();
    l_UnidadDeMedida=l_UnidadDeMedida.trim();
    
 
    // Anexa los datos al listado de productos
    var bandEncontrado=0;
    var i=0;
    for(i=0;i<listadodeproductos.length;i++){
        if(listadodeproductos[i]["nidproducto"]==l_nIDProducto){
            bandEncontrado=1;
            break;
        }
    }

    if(bandEncontrado==0){
        listadodeproductos.push( { "nidproducto":l_nIDProducto,"codigo": l_Codigo, "producto":l_Producto, "unidaddemedida":l_UnidadDeMedida, "cantidad":l_Cantidad, "nidusuario":l_nIDUsuario, "nidcat_almacen_origen":l_nIDCat_Almacen_Origen, "nidcat_almacen_destino":l_nIDCat_Almacen_Destino, "comentarios":l_Comentarios } );     
    } else {
        document.getElementById("lbl_mensaje_falla").innerHTML="Codigo Repetido";             
        $("#modal_falla").modal("show");
        
        return;
    }    

    // Presenta la inforamción en la pantalla   
    var l_Linea="<div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;padding-bottom:10px;'>";
    l_Linea=l_Linea + "<div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>";
    l_Linea=l_Linea + "<label style='cursor:pointer;' > Codigo</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>";
    l_Linea=l_Linea + "    <label style='cursor:pointer;' > Producto </label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>";
    l_Linea=l_Linea + "   <label style='cursor:pointer;' > Unidad de Medida </label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>";
    l_Linea=l_Linea + "   <label style='cursor:pointer;' > Cantidad </label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>";
    l_Linea=l_Linea + "   <label style='cursor:pointer;' > Acciones </label>";
    l_Linea=l_Linea + "</div>";
 

    l_Linea=l_Linea + "</div>";
    for(i=0;i<listadodeproductos.length;i++){
        l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>";

        l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>";
        l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["codigo"] + "</label>";
        l_Linea=l_Linea + "</div>";  

        l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>";
        l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["producto"] + "</label>";
        l_Linea=l_Linea + "</div>";  

        l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>";
        l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["unidaddemedida"] + "</label>";
        l_Linea=l_Linea + "</div>";  

        l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>"; 
        l_Linea=l_Linea + "<input type='text' name='cantidad_+" + i + "' id='txt_Cantidad_" + i + "' class='form-control' value='" + listadodeproductos[i]["cantidad"] + "' style='height: 30px;width:100px;font-size:10px; font-family:Arial, Gadget, sans-serif; margin-left:-10px;' >";   
        l_Linea=l_Linea + "</div>";   

        l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>"; 
        l_Linea=l_Linea + "<a class='nav-link' style='color: #53BEFE;cursor:pointer;margin-right: -20px;' onclick=\"fn_Eliminar_Producto("+ i + ")\">Eliminar</a>";
        l_Linea=l_Linea + "</div>";   

 
        l_Linea=l_Linea + "</div>";
    }

    document.getElementById("contenido_productos").innerHTML=l_Linea;  
    document.getElementById("txt_Codigo").value="";
}

function fn_Eliminar_Producto(indice){
    var listadodeproductos_tmp=[];

    l_Cant=0;
    for(i=0;i<listadodeproductos.length;i++){
        l_Cant=document.getElementById("txt_Cantidad_"+i).value;
        listadodeproductos[i]["cantidad"]=l_Cant
    }

    var contador=0;
    for(i=0;i<listadodeproductos.length;i++){
        if(i!=indice){
            listadodeproductos_tmp[contador]=listadodeproductos[i];         
            contador++;
        }          
    }

    for(i=0;i<listadodeproductos.length;i++){
        listadodeproductos.pop();
    }

    for(i=0;i<listadodeproductos_tmp.length;i++){
        listadodeproductos[i]=listadodeproductos_tmp[i];
    }

    fn_Mostrar_ListadoDeProductos();

}

function fn_Mostrar_ListadoDeProductos(){

     
    // Presenta la inforamción en la pantalla   
    var l_Linea="<div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;padding-bottom:10px;'>";
    l_Linea=l_Linea + "<div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>";
    l_Linea=l_Linea + "<label style='cursor:pointer;' > Codigo</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>";
    l_Linea=l_Linea + "    <label style='cursor:pointer;' > Producto </label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>";
    l_Linea=l_Linea + "   <label style='cursor:pointer;' > Unidad de Medida </label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>";
    l_Linea=l_Linea + "   <label style='cursor:pointer;' > Cantidad </label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col d-flex justify-content-left align-items-center' style='text-align:center; font-size:10px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F5;'>";
    l_Linea=l_Linea + "   <label style='cursor:pointer;' > Acciones </label>";
    l_Linea=l_Linea + "</div>";
 

    l_Linea=l_Linea + "</div>";
    for(i=0;i<listadodeproductos.length;i++){
        l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>";

        l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>";
        l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["codigo"] + "</label>";
        l_Linea=l_Linea + "</div>";  

        l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>";
        l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["producto"] + "</label>";
        l_Linea=l_Linea + "</div>";  

        l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>";
        l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["unidaddemedida"] + "</label>";
        l_Linea=l_Linea + "</div>";  

        l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>"; 
        l_Linea=l_Linea + "<input type='text' name='cantidad_+" + i + "' id='txt_Cantidad_" + i + "' class='form-control' value='" + listadodeproductos[i]["cantidad"] + "' style='height: 30px;width:100px;font-size:10px; font-family:Arial, Gadget, sans-serif; margin-left:-10px;' >";   
        l_Linea=l_Linea + "</div>";   

        l_Linea=l_Linea + "<div class='col d-flex justify-content-start align-items-left' style='text-align:center; font-size:8px; vertical-aling:middle;display:block; cursor:pointer;'>"; 
        l_Linea=l_Linea + "<a class='nav-link' style='color: #53BEFE;cursor:pointer;margin-right: -20px;' onclick=\"fn_Eliminar_Producto("+ i + ")\">Eliminar</a>";
        l_Linea=l_Linea + "</div>";   

 
        l_Linea=l_Linea + "</div>";
    }

    document.getElementById("contenido_productos").innerHTML=l_Linea;  
}


// ------
function Listado_Detalles(datos){    
    
    if(datos.length>0){
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/ordendesurtido_deta_consultar_todos.ctrl.php";
 
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
            for(i=0;i<contador;i++){     
                l_Registros="";
                l_nID=0;

                if(obResultado[i]["retorno"]=="TRUE"){ 
                     // Anexa los datos al listado de productos
                     listadodeproductos.push( { "nidproducto":obResultado[i]["nIDProducto"],"codigo": obResultado[i]["Codigo_IZeta"], "producto":obResultado[i]["Producto"], "unidaddemedida":obResultado[i]["UnidadDeMedida"], "cantidad":obResultado[i]["Cantidad"], "nidusuario":0, "nidcat_almacen_origen":0, "nidcat_almacen_destino":0, "comentarios":"" } );     
                } else {
                 
                }
            }     
            fn_Ver_ListadoDeProductos();
            // ----------------------------------------------------------------                     
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}

function fn_Ver_ListadoDeProductos(){

    var l_Linea="";
    l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center'  style='border-bottom: #D9DADA 2px solid;'>";

    l_Linea=l_Linea + "<div class='col-md-2  w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
    l_Linea=l_Linea + "<label id='campo_" + 0 + "'>";
    l_Linea=l_Linea +  "Código";     
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-4  w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
    l_Linea=l_Linea + "<label id='campo_" + 0 + "'>";
    l_Linea=l_Linea +  "Descripción";     
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-4  w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
    l_Linea=l_Linea + "<label id='campo_" + 0 + "'>";
    l_Linea=l_Linea +  "Unidad de Medida";     
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-2  w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
    l_Linea=l_Linea + "<label id='campo_" + 0 + "'>";
    l_Linea=l_Linea +  "Cantidad";     
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";
  
    l_Linea=l_Linea + "</div>";

    for(i=0;i<listadodeproductos.length;i++){
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

        l_Linea=l_Linea + "</div>";
    }    

    document.getElementById("contenido_productos").innerHTML=l_Linea;  
}




function Cancelar_OrdenDeSurtido(datos){    
    if(datos.length>0){         
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/ordendesurtido_cancelar.ctrl.php";
 
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

function OrdenDeSurtido_Combo(datos){ 

    if(datos.length>0){
        var nID=datos[0]["seleccion"];
        var Accion=datos[0]["accion"];

        if(Accion=="Eliminar" || Accion=="Detalles" || Accion=="Cancelar"){
            return;
        }

        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/ordendesurtido_consultar.ctrl.php";
 
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
 
 
                var formulariop = document.getElementById("frm_Actualizar");   
 
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
                             l_Registros=l_Registros + "[" + registros[i][j] + "]";
                         }
                         l_Registros=l_Registros + "</option>  ";                  
                    }
     
                    console.log("Registros:"+ l_Registros);  
 
                 document.getElementById("cb_nIDOrdenDeSurtido").innerHTML=l_Registros;
                // ----------------------------------------------------------------             
            
            }        
         };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}
// ******************************************************************
 