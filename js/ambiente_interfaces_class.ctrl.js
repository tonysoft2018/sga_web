// ----------------------------------------------------------------------------------
// ambiente_interfaces_class.ctrl.js
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. IDEATECH
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 21/08/2020
// ----------------------------------------------------------------------------------
// V2.0.2
// ----------------------------------------------------------------------------------
 class cl_Ambiente_Interfaces{ 
     modulo="ambiente_acercade";
    Listado(datos){
        try{
 
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

                        // Carga los encabezados
                        // Verifica el numero de encabezados
                        l_Encabezados=obResultado[0]["encabezados"];

                        // Calcula el tamaño de las columnas
                        l_Tamaxo=l_Encabezados.length;
                        l_Tamaxo=103/l_Tamaxo;

                        var l_Linea="";   

                        l_Linea=l_Linea + "<div class='row align-item-end h-20 align-items-center'  style='border-bottom: #D9DADA 2px solid;cursor:pointer;padding-bottom:10px;'>";

                        l_Linea=l_Linea + "<div class='col-md-10  w-3 align-bottom align-self-center' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;margin-top: auto;margin-bottom: auto;'>";
                        l_Linea=l_Linea + "<label id='campo_" + i + "'  onclick=\"fn_Listado_Ordenar_Clic('Intefaz')\">";
                        l_Linea=l_Linea +  "Interfaz";
                        l_Linea=l_Linea + "<img src='../iconos/updown.png' style='width: 10px; height: 10px; margin-left:2px;'>";
                        l_Linea=l_Linea + "</label>";
                        l_Linea=l_Linea + "</div>";
                   
                        l_Linea=l_Linea + "<div class='col-md-2  justify-content-left align-items-start w-3' style='height: 40px;text-align:left; font-size:12px; font-family:Arial black, Gadget, sans-serif;vertical-aling:middle;display:block; cursor:pointer;background-color:#F4F5F6;'>";                
                        l_Linea=l_Linea + "<label style='cursor:pointer;'> Acciones </label>";                
                        l_Linea=l_Linea + "</label>";
                        l_Linea=l_Linea + "</div>";                   

                        l_Linea=l_Linea + "</div>";


                        for(i=0;i<contador;i++){     
                            l_Linea=l_Linea + "<div id='id_r" + i +"' class='row align-item-end h-20 align-items-start ' style='border-bottom: #D9DADA 2px solid;cursor:pointer;font-size:12px;' onmouseover=\"fn_Encima("+i+")\" onmouseout=\"fn_Dejar("+i+")\">";

                            l_Linea=l_Linea + "<div class='col-md-10 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
                            l_Linea=l_Linea + "<label style='cursor:pointer;' >" +   obResultado[i]["Interfaces"] + "</label>";
                            l_Linea=l_Linea + "</div>";  

                            l_Linea=l_Linea + "<div class='col-md-2 justify-content-start align-items-left w-3 d-inline-block  text-break' >";
                            l_Linea=l_Linea  + "<label style='display:inline-flex' >";
                            l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar.php?id=" + obResultado[i][l_Llave] +"&accion=Editar' style='color: #53BEFE;cursor:pointer; margin-right: -20px; font-family:Arial black, Gadget, sans-serif; '>Editar </a>"
                            l_Linea=l_Linea  + "<a class='nav-link' href='" + MODULO + "_editar.php?id=" + obResultado[i][l_Llave] +"&accion=Eliminar' style='color: #53BEFE;cursor:pointer;margin-right: -20px; font-family:Arial black, Gadget, sans-serif;' >Eliminar</a>";                                                   
                            l_Linea=l_Linea  + "</label>";
                            l_Linea=l_Linea + "</div>";  

                            l_Linea=l_Linea + "</div>";
                        }
                    } else {
                   
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
               
                    var obVerificar;
                    obVerificar=setInterval(function(){                      
                        $("#modal_espera").modal("hide");       
                        clearInterval(obVerificar);
                    },500);   
                    // ----------------------------------------------------------------                        
                  }        
                };
    
                xmlhttp.open("POST", url, true);
                xmlhttp.send(ob);
            }   
            
        } catch(ex){
            
            console.log(ex.message);                          
            document.getElementById("lbl_mensaje_falla").innerHTML="FALLA EN LA OPERACIÓN"
            $("#modal_falla").modal("show"); 
            $("#modal_espera").modal("hide");
            var obVerificar;
            obVerificar=setInterval(function(){                      
                $("#modal_espera").modal("hide");       
                clearInterval(obVerificar);
            },500);      
        } 
    }

    

    Crear(datos){	   
        try{  
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
                            var obVerificar;
                            obVerificar=setInterval(function(){                      
                                $("#modal_espera").modal("hide");       
                                clearInterval(obVerificar);
                            },500);   
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
        } catch(ex){
         
            console.log(ex.message);                          
            document.getElementById("lbl_mensaje_falla").innerHTML="FALLA EN LA OPERACIÓN"
            $("#modal_falla").modal("show"); 
            document.getElementById("bt_Grabar").style.visibility="visible";
            $("#modal_espera").modal("hide");
            var obVerificar;
                    obVerificar=setInterval(function(){                      
                        $("#modal_espera").modal("hide");       
                        clearInterval(obVerificar);
                    },500);   
        }  
    }

    Actualizar(datos){   
        try{  
            if(datos.length>0){
                ob = JSON.stringify(datos);
 
                var xmlhttp = new XMLHttpRequest();
                var url = UBICACION_CONTROL + "/" + MODULO + "_actualizar.ctrl.php";
       
                document.getElementById("bt_Grabar").style.visibility="hidden";
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
                            document.getElementById("bt_Grabar").style.visibility="visible";
                            var obVerificar;
                            obVerificar=setInterval(function(){                      
                                $("#modal_espera").modal("hide");       
                                clearInterval(obVerificar);
                            },500);   
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
        } catch(ex){
         
            console.log(ex.message);                          
            document.getElementById("lbl_mensaje_falla").innerHTML="FALLA EN LA OPERACIÓN"
            $("#modal_falla").modal("show"); 
            document.getElementById("bt_Grabar").style.visibility="visible";
            $("#modal_espera").modal("hide");
            var obVerificar;
                    obVerificar=setInterval(function(){                      
                        $("#modal_espera").modal("hide");       
                        clearInterval(obVerificar);
                    },500);    
        }           
    }


    Estado(datos){    
        try{      
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
                            var obVerificar;
                            obVerificar=setInterval(function(){                      
                                $("#modal_espera").modal("hide");       
                                clearInterval(obVerificar);
                            },500);      
                        }

                        return obResultado;
                    }
                };

                xmlhttp.open("POST", url, true);
                xmlhttp.send(ob);
            }  

        } catch(ex){
         
            console.log(ex.message);                          
            document.getElementById("lbl_mensaje_falla").innerHTML="FALLA EN LA OPERACIÓN"
            $("#modal_falla").modal("show"); 
            document.getElementById("bt_Eliminar").style.visibility="visible";   
            $("#modal_espera").modal("hide");
            var obVerificar;
                    obVerificar=setInterval(function(){                      
                        $("#modal_espera").modal("hide");       
                        clearInterval(obVerificar);
                    },500);   
        }  
    }
  
    Eliminar(datos){    
        try{
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
                       
                            $("#modal_exitoso").modal("show");
                        } else {                    
                            console.log(obResultado[0]["msg"]);   
                            console.log(obResultado);                          
                            document.getElementById("lbl_mensaje_falla").innerHTML=obResultado[0]["msg"];
                            $("#modal_falla").modal("show");
                            document.getElementById("bt_Eliminar").style.visibility="visible";   
                            $("#modal_espera").modal("hide");
                            var obVerificar;
                            obVerificar=setInterval(function(){                      
                                $("#modal_espera").modal("hide");       
                                clearInterval(obVerificar);
                            },500);        
                        }
     
                        return obResultado;
                    }
                };
     
                xmlhttp.open("POST", url, true);
                xmlhttp.send(ob);
            }  
        } catch(ex){
         
            console.log(ex.message);                          
            document.getElementById("lbl_mensaje_falla").innerHTML="FALLA EN LA OPERACIÓN"
            $("#modal_falla").modal("show");
            document.getElementById("bt_Eliminar").style.visibility="visible";   
            $("#modal_espera").modal("hide");
            var obVerificar;
            obVerificar=setInterval(function(){                      
                $("#modal_espera").modal("hide");       
                clearInterval(obVerificar);
            },500);   
        } 
   
    }

    Interfaces_Combo(datos){ 
        try{  
            if(datos.length>0){
                var nID=datos[0]["seleccion"];
                var Accion=datos[0]["accion"];

                if(Accion=="Eliminar" || Accion=="Detalles" || Accion=="Cancelar"){
                    return;
                }

                ob = JSON.stringify(datos);

                var xmlhttp = new XMLHttpRequest();
                var url = UBICACION_CONTROL + "/interfaces_consultar.ctrl.php";
      
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
                                l_Registros=l_Registros + "" + registros[i][j] + " ";
                            }
                            l_Registros=l_Registros + "</option>  ";                  
                        }
   
                        console.log("Registros:"+ l_Registros);  
 
                        document.getElementById("cb_nIDCat_Almacen").innerHTML=l_Registros;  
                        // ----------------------------------------------------------------                         
                    }        
                };
    
                xmlhttp.open("POST", url, true);
                xmlhttp.send(ob);
            } 
        } catch(ex){         
            console.log(ex.message);                              
        }    
    }
   
    Consultar(datos){   
        try{     
            if(datos.length>0){
                $("#modal_espera").modal("show");
                 
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
                        var l_Llave="";
                        var especiales=new Array();                
                        var bandEncontrado=0;
                        var l_Tipo="";

                        //var l_nIDCat_Empresa=0;
                        //var l_nIDCat_CentroDeServicio=0;

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

                                // l_nIDCat_Empresa=obResultado[i]["nIDCat_Empresa"];
                                // l_nIDCat_CentroDeServicio=obResultado[i]["nIDCat_CentroDeServicio"];
                        
                                for (var campo in obResultado[i]) {

                                    if(campo!="retorno" && campo!="msg" && campo!="llave" ){
                                        if(l_Llave==campo){
                                            // console.log("ENCONTRADO");
                                        } else {
                                
                                            if(campo=="especiales"){
                                                for (var campo_e in obResultado[i][campo]) {                                             
                                                    especiales.push( { "campo" : campo_e, "tipo": obResultado[i][campo][campo_e] } );                                                           
                                                }                                         
                                             }
  
                                            for (k=0;k<formulariop.elements.length;k++){
                                                sCampo=formulariop.elements[k].name;
                                                sCampo=sCampo.trim();
                                                if(sCampo.length>0){
                                                    if(sCampo==campo){  
                                               
                                                        bandEncontrado=0;
                                                        l_Tipo="";
                                                        for(h=0;h<especiales.length;h++){
                                                    
                                                            if(especiales[h]["campo"]==campo){                                                                 
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
                        // Carga la info del combo           
                        //fn_Cat_Empresa_Clic('',l_nIDCat_Empresa,l_Accion);     
                        //fn_Cat_CentrosDeServicio_Clic('',l_nIDCat_CentroDeServicio,l_Accion);  

                        $("#modal_espera").modal("hide");                   
                        var obVerificar;
                         obVerificar=setInterval(function(){                      
                            $("#modal_espera").modal("hide");       
                            clearInterval(obVerificar);
                        },500);     
                    }        
                };
    
                xmlhttp.open("POST", url, true);
                xmlhttp.send(ob);
            }    
        } catch(ex){
         
            console.log(ex.message);                          
            document.getElementById("lbl_mensaje_falla").innerHTML="FALLA EN LA OPERACIÓN"
            $("#modal_falla").modal("show");  
            $("#modal_espera").modal("hide");
            var obVerificar;
            obVerificar=setInterval(function(){                      
                $("#modal_espera").modal("hide");       
                clearInterval(obVerificar);
            },500);   
        } 
    }
 
}