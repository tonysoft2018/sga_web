// ----------------------------------------------------------------------------------
// packinglist_deta_rest.ctrl.js
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
 
function Crear_Detalles(datos){	 
    console.log("CTRL");    
    console.log(datos);   
    
 
    if(datos.length>0){
       ob = JSON.stringify(datos);

       var xmlhttp = new XMLHttpRequest();
       var url = UBICACION_CONTROL + "/canjes_deta_crear.ctrl.php";
      
       document.getElementById("bt_Grabar").style.visibility="hidden";
       //$("#modal_espera").modal("show");

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


function Listado_Detalles(datos){    
    if(datos.length>0){
        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/canjepuntos_deta_consultar_todos.ctrl.php";
 
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

               for(i=0;i<contador;i++){     
                   
                   if(obResultado[i]["retorno"]=="TRUE"){ 
                        fn_Agregar(obResultado[i]["nIDCanje_Deta"], obResultado[i]["nIDCanje"], obResultado[i]["nIDProducto"], obResultado[i]["Codigo_IZeta"], obResultado[i]["Producto"], obResultado[i]["Cantidad"], obResultado[i]["Puntos"], 0, 0, 0, 0,"CERRADO");
                   }                   
               }     

               fn_Ver("DETALLES");              
           }   

        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}


function Anexar_Detalles(datos) {

    if(datos.length>0){
        var nIDCat_CentroDeServicio=datos[0]["nidcat_centrodeservicio"];
        var nIDCat_Almacen=datos[0]["nidcat_almacen"];
        var nIDCat_Cliente=datos[0]["nidcat_cliente"];
        var Cantidad=datos[0]["cantidad"];
       
        var nIDUsuario=datos[0]["nidusuario"]; 
        var nIDCanje=datos[0]["nid"]; 

        ob = JSON.stringify(datos);

        var xmlhttp = new XMLHttpRequest();
        var url = UBICACION_CONTROL + "/canjes_pxa_consultar_producto.ctrl.php";
 
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
               for(i=0;i<contador;i++){     
                   
                   
                   if(obResultado[i]["retorno"]=="TRUE"){ 
                        fn_Agregar(0, nIDCanje, obResultado[i]["nidproducto"], obResultado[i]["codigo"], obResultado[i]["producto"], Cantidad, obResultado[i]["puntos"], nIDCat_CentroDeServicio, nIDCat_Almacen, nIDCat_Cliente, nIDUsuario,"ABIERTO");
                   } else {
                        document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[i]["msg"]             
                        $("#modal_falla").modal("show");
            
                        document.getElementById("txt_Etiqueta").select();
                        return;
                   }
               }     
               
               fn_Ver("CREAR");
    
               document.getElementById("txt_Etiqueta").value="";
               document.getElementById("txt_Cantidad").value="";
               document.getElementById("txt_Puntos").value="";
               document.getElementById("txt_Descripcion").value="";

                    
               document.getElementById("txt_Etiqueta").select();
               // ----------------------------------------------------------------             
           
           }        
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.send(ob);
    }    
}


function fn_Agregar(l_nIDCanje_Deta, l_nIDCanje, l_nIDProducto, l_Codigo, l_Producto, l_Cantidad, l_Puntos, l_nIDCat_CentroDeServicio,  l_nIDCat_Almacen, l_nIDCat_Cliente,  l_nIDUsuario, l_Estatus ){
     
    l_Codigo=l_Codigo.trim();
    l_Producto=l_Producto.trim();
    
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
        listadodeproductos.push( { "nidcanje_deta":l_nIDCanje_Deta,"nidcanje":l_nIDCanje, "nidproducto":l_nIDProducto,"codigo": l_Codigo, "producto":l_Producto, "cantidad":l_Cantidad, "puntos":l_Puntos,
                                   "nidcat_centrodeservicio":l_nIDCat_CentroDeServicio, "nidcat_almacen":l_nIDCat_Almacen, 
                                   "nidcat_cliente":l_nIDCat_Cliente,  "nidusuario":l_nIDUsuario, "estatus":l_Estatus } );     
    }

  


}

function fn_Eliminar_Producto(indice){
    var listadodeproductos_tmp=[];

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

    fn_Ver();

    document.getElementById("txt_Etiqueta")="";
    document.getElementById("txt_Cantidad")="";
    document.getElementById("txt_Puntos")="";
    document.getElementById("txt_Descripcion")="";

}

function fn_Ver(l_Tipo){
      
    // Presenta la inforamción en la pantalla   
    var l_Linea="";

    l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center'  style='border-bottom: #D9DADA 2px solid;cursor:pointer;'>";
     
    l_Linea=l_Linea + "<div class='col-md-2 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";   
    l_Linea=l_Linea + "<label id='campo_0'>";
    l_Linea=l_Linea + "Código";    
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-4 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";   
    l_Linea=l_Linea + "<label id='campo_0'>";
    l_Linea=l_Linea + "Descripción";    
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    l_Linea=l_Linea + "<div class='col-md-2 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";   
    l_Linea=l_Linea + "<label id='campo_0'>";
    l_Linea=l_Linea + "Cantidad";    
    l_Linea=l_Linea + "</label>";
    l_Linea=l_Linea + "</div>";

    if(l_Tipo=="CREAR"){
        l_Linea=l_Linea + "<div class='col-md-2 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";   
        l_Linea=l_Linea + "<label id='campo_0'>";
        l_Linea=l_Linea + "Puntos";    
        l_Linea=l_Linea + "</label>";
        l_Linea=l_Linea + "</div>";
    } else {
        l_Linea=l_Linea + "<div class='col-md-4 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";   
        l_Linea=l_Linea + "<label id='campo_0'>";
        l_Linea=l_Linea + "Puntos";    
        l_Linea=l_Linea + "</label>";
        l_Linea=l_Linea + "</div>";
    }
   

    if(l_Tipo=="CREAR"){
        l_Linea=l_Linea + "<div class='col-md-2 w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";   
        l_Linea=l_Linea + "<label id='campo_0'>";
             
        l_Linea=l_Linea + "</label>";
        l_Linea=l_Linea + "</div>";    
    }
    

    l_Linea=l_Linea + "</div>";
 
    for(i=0;i<listadodeproductos.length;i++){
        l_Linea=l_Linea + "<div id='id_r" + i +"' class='row h-20 aling-middle' style='border-bottom: #D9DADA 2px solid;font-size:12px;' onmouseover=\"fn_Encima("+i+")\" onmouseout=\"fn_Dejar("+i+")\">";

        l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
        l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
        l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  listadodeproductos[i]["codigo"] + "</a>";
        l_Linea=l_Linea  + "</label>";
        l_Linea=l_Linea + "</div>"; 

        l_Linea=l_Linea + "<div class='col-md-4 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
        l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
        l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +  listadodeproductos[i]["producto"] + "</a>";
        l_Linea=l_Linea  + "</label>";
        l_Linea=l_Linea + "</div>"; 

        l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
        l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
        l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +   listadodeproductos[i]["cantidad"] + "</a>";
        l_Linea=l_Linea  + "</label>";
        l_Linea=l_Linea + "</div>"; 

        l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block text-break align-middle' >";
        l_Linea=l_Linea  + "<label style='inline-flex' >";                                              
        l_Linea=l_Linea  + "<a class='nav-link' style='font-family:Arial; margin-left:-15px'> " +   listadodeproductos[i]["puntos"] + "</a>";
        l_Linea=l_Linea  + "</label>";
        l_Linea=l_Linea + "</div>"; 

        
        if(listadodeproductos[i]["estatus"]=="ABIERTO"){
            l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block  ' >";
            l_Linea=l_Linea  + "<label style='display:inline-flex' >";                       
            l_Linea=l_Linea  + "<a class='nav-link' style='color: #53BEFE;cursor:pointer; margin-right: -20px;  font-family:Arial black, Gadget, sans-serif; '  onclick=\"fn_Eliminar_Producto('" + i +"')\"> Eliminar </a>";       
            l_Linea=l_Linea  + "</label>";
            l_Linea=l_Linea + "</div>";  
        }
        
        l_Linea=l_Linea + "</div>";
 
    }

    document.getElementById("contenido_productos").innerHTML=l_Linea;  
 
}
// ************************************************************************************************

 