// ----------------------------------------------------------------------------------
// entradaporotrosconceptos_deta_rest.ctrl.js
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. IDEATECH
// ----------------------------------------------------------------------------------
// Descripcion. Modulo para editar datos de un perfil.
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 13/07/2020
// ----------------------------------------------------------------------------------
// V2.0.2
// ----------------------------------------------------------------------------------
 
function Listado_Detalles(datos){        
    if(datos.length>0){
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/entradaporotrosconceptos_deta_consultar_todos.ctrl.php";
 
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
                    fn_Ver_Detalles(obResultado[i]["nIDProducto"], obResultado[i]["Codigo"], obResultado[i]["Producto"], obResultado[i]["UnidadDeMedida"], 1, obResultado[i]["nIDEntradaPorOtrosConceptos"], 0);
                }  
            }     
            // ----------------------------------------------------------------             
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}

 
function fn_Ver_Detalles(l_nIDProducto, l_Codigo, l_Producto, l_UnidadDeMedida, l_Cantidad, nIDEntradaPorOtrosConceptos, nIDUsuario){
     
    l_Codigo=l_Codigo.trim();
    l_Producto=l_Producto.trim();
    l_UnidadDeMedida=l_UnidadDeMedida.trim();
    
    listadodeproductos.push( { "nidentradaporotrosconceptos_deta":0,"nidentradaporotrosconceptos":nIDEntradaPorOtrosConceptos, "nidproducto":l_nIDProducto,"codigo": l_Codigo, "producto":l_Producto, "unidaddemedida":l_UnidadDeMedida, "cantidad":l_Cantidad, "nidusuario":nIDUsuario } );     

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

// **************************************************************************
 

var NIDENTRADAPOROTROSCONCEPTOS=0;

function Anexar_Detalles(datos) {

    if(datos.length>0){
        var nIDEntradaPorOtrosConceptos=datos[0]["nidentradaporotrosconceptos"];
        var nIDUsuario=datos[0]["nidusuario"];

        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/entradasporotrosconceptos_consultar_producto.ctrl.php";
 
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
                   
                   l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center' style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>";

                   if(obResultado[i]["retorno"]=="TRUE"){ 
                        fn_Agregar(obResultado[i]["nIDProducto"], obResultado[i]["Codigo"], obResultado[i]["Producto"], obResultado[i]["UnidadDeMedida"], 1, nIDEntradaPorOtrosConceptos, nIDUsuario);
 
                   } else {
                    document.getElementById("lbl_mensaje_falla").innerHTML="CODIGO NO ENCONTRADO";             
                    $("#modal_falla").modal("show");
            
                    document.getElementById("txt_Etiqueta").select();
                    return;
                   }
               }     
 
               
               // ----------------------------------------------------------------             
           
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}

// **************************************************************************

// **************************************************************************

function Listado_Grabar_Entrada(datos){    
    if(datos.length>0){         
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/entradasporotrosconceptos_grabar.ctrl.php";
 
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

function fn_Agregar(l_nIDProducto, l_Codigo, l_Producto, l_UnidadDeMedida, l_Cantidad, nIDEntradaPorOtrosConceptos, nIDUsuario){
     
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

    listadodeproductos.push( { "nidentradaporotrosconceptos_deta":0,"nidentradaporotrosconceptos":nIDEntradaPorOtrosConceptos, "nidproducto":l_nIDProducto,"codigo": l_Codigo, "producto":l_Producto, "unidaddemedida":l_UnidadDeMedida, "cantidad":l_Cantidad, "nidusuario":nIDUsuario } );     

    // Presenta la inforamción en la pantalla   
    var l_Linea="";

    l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center'  style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>";
     
    l_Linea=l_Linea + "<div class='col-md-2 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";   
    l_Linea=l_Linea + "<label id='campo_0'>";
    l_Linea=l_Linea + "Código";    
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-5 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";   
    l_Linea=l_Linea + "<label id='campo_0'>";
    l_Linea=l_Linea + "Descripción";    
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-3 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";   
    l_Linea=l_Linea + "<label id='campo_0'>";
    l_Linea=l_Linea + "Unidad de Medida";    
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-2 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";   
    l_Linea=l_Linea + "<label id='campo_0'>";
    l_Linea=l_Linea + "Cantidad";    
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";


    l_Linea=l_Linea + "</div>";
 
    for(i=0;i<listadodeproductos.length;i++){
        l_Linea=l_Linea + "<div id='id_r" + i +"' class='row h-20 aling-middle' style='border-bottom: #D9DADA 2px solid;font-size:12px;' onmouseover=\"fn_Encima("+i+")\" onmouseout=\"fn_Dejar("+i+")\">";

        l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
        l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
        l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  listadodeproductos[i]["codigo"] + "</a>";
        l_Linea=l_Linea  + "</label>";
        l_Linea=l_Linea + "</div>"; 

        l_Linea=l_Linea + "<div class='col-md-5 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
        l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
        l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  listadodeproductos[i]["producto"] + "</a>";
        l_Linea=l_Linea  + "</label>";
        l_Linea=l_Linea + "</div>"; 

        l_Linea=l_Linea + "<div class='col-md-3 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
        l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
        l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +   listadodeproductos[i]["unidaddemedida"] + "</a>";
        l_Linea=l_Linea  + "</label>";
        l_Linea=l_Linea + "</div>"; 

        l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
        l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
        l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +   listadodeproductos[i]["cantidad"] + "</a>";
        l_Linea=l_Linea  + "</label>";
        l_Linea=l_Linea + "</div>"; 

        l_Linea=l_Linea + "</div>";

 
    }

    document.getElementById("contenido_productos").innerHTML=l_Linea;  

    document.getElementById("txt_Etiqueta").value="";     
    document.getElementById("txt_Etiqueta").select();
}

function Listado_Folio(datos){    
    if(datos.length>0){
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/entradaporotrosconceptos_consultar_todos.ctrl.php";
 
        xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var l_Resultado=this.responseText;  
               console.log(l_Resultado);  

               var obResultado=JSON.parse(l_Resultado);
               var l_nID=0;
              

               if(obResultado[0]["retorno"]=="TRUE"){ 
                    l_nID=obResultado[0]["nIDEntradaPorOtrosConceptos"];
                    NIDENTRADAPOROTROSCONCEPTOS=l_nID;
                    
                    var l_Resumen=obResultado[0]["Folio"] + "," + obResultado[0]["Fecha"] + "," + obResultado[0]["Almacen"] + "," + obResultado[0]["ConceptoEntrada"];    
                    document.getElementById("lbl_Entrada").innerHTML=l_Resumen;

                    document.getElementById("bt_Buscar").style.visibility="hidden";
                    document.getElementById("bt_Cancelars").style.visibility="visible";
                    document.getElementById("txt_Entrada").readOnly = true;

                    document.getElementById("txt_Etiqueta").select();

               }

               if( l_nID<=0){
                    console.log(obResultado[0]["msg"]);   
                    console.log(obResultado);                          
                    document.getElementById("lbl_mensaje_falla").innerHTML="Folio NO Encontrado";                  
                    $("#modal_falla").modal("show");
                    document.getElementById("bt_Grabar").style.visibility="visible";
               }
                         
               document.getElementById("txt_nIDEntradaPorOtrosConceptos").value=l_nID;                 
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

    listadodeproductos.pop();
 
    fn_Ver_ListadoDeProductos_Estatus();

}

function fn_Ver_ListadoDeProductos_Estatus(){
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
      l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   listadodeproductos[i]["cantidad"] + "</label>";
      l_Linea=l_Linea + "</div>";   
 
      l_Linea=l_Linea + "</div>";
  }

  document.getElementById("contenido_productos").innerHTML=l_Linea;  
}

// ******************************************************************