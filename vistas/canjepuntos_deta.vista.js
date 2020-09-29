// ----------------------------------------------------------------------------------
// canjepuntos_deta.vista.js
// ----------------------------------------------------------------------------------
// Autor. Ing. Antonio Barajas del Castillo
// ----------------------------------------------------------------------------------
// Empresa. Softernium SA de CV
// ----------------------------------------------------------------------------------
// Fecha Ultima Modificación
// 19/08/2020
// ----------------------------------------------------------------------------------
var listadodeproductos=new Array();

function fn_Crear_Detalles_Clic(l_Folio){
    var formulariop = document.getElementById("frm_Detalles");   
    var LECTURA=[];
    var CAMPO=[];      
    var i=0;
    var sCampo="";
 
    // Extrae la información
    for (i=0;i<formulariop.elements.length;i++){        
        sCampo=formulariop.elements[i].name;
        sCampo=sCampo.trim();
        if(sCampo.length>0){
             //console.log("campo:" + sCampo + "=" + formulariop.elements[i].value.trim() + ", " + formulariop.elements[i].type.trim()); 
            
            if(formulariop.elements[i].type.trim()=="checkbox"){
                if(formulariop.elements[i].checked){
                    LECTURA.push("SI");
                } else {
                    LECTURA.push("NO");
                }

            } else {
                LECTURA.push(formulariop.elements[i].value.trim())
            }
            
            CAMPO.push(formulariop.elements[i].name.trim())

        }     
    } 

 
    // Convierte los campos a minusculas
    for (i=0;i<CAMPO.length;i++){
        CAMPO[i]=CAMPO[i].toLowerCase(); 
    }

    var obj={};
    for (i=0;i<LECTURA.length;i++){
        obj[CAMPO[i]]=LECTURA[i];
    }

    obj["FOLIO"]=l_Folio;
     
    var DATOS=new Array();    
    DATOS.push(obj);     

    console.log("DETALLES");     
    console.log(DATOS);

    if(DATOS.length>0){        
        // Enviar para procesdar
        resultado=Crear_Detalles(DATOS);     

    } else {
        console.log("ERROR NO SE CARGO LA INFORMACIÓN");
    }  
}

function fn_Consultar_Detalles_Clic(l_Consulta){     
    // Verificaciones
    if(l_Consulta.length<=0){
        console.log("ERROR NO TIENE CONSULTA");
        //return;
    } 

    // Limpia la información
    l_Consulta=l_Consulta.trim();
    
    // Procesar
    var arreglo=new Array();
    arreglo.push( { "consulta":"","condicion":l_Consulta,"tipo":"general", "campos":"definidos","campodeordenamiento": "nIDCanje_Deta", "formadeordenamiento":FORMA_ORDENAMIENTO, "cantidadregistros":NUMERODEREGISTROS,"modulo":MODULO, "accion":ACCION } );     


    if(arreglo.length>0){       
        // Enviar para procesdar
        resultado=Listado_Detalles(arreglo); 
    } else {
        console.log("ERROR NO SE CARGO LA INFORMACIÓN");
    }
}


function fn_Buscar_Codigo_Clic(){
    Buscar_Codigo()
 
}


function Buscar_Codigo(){
    var Codigo = document.getElementById("txt_Etiqueta").value;
 
    if(Codigo.length>0){
        resultado=fn_Consultar_Descripcion_Clic(Codigo);   
    } else {
        document.getElementById("lbl_mensaje_falla").innerHTML="ESCANEE O CAPTURE EL CODIGO";       
        $("#modal_falla").modal("show");
    }
}



function fn_Anexar_Codigo_CLick(){
    Anexar_Codigo();
}

function Anexar_Codigo(){
    var Codigo = document.getElementById("txt_Etiqueta").value;
    var nIDCat_CentroDeServicio = document.getElementById("cb_nIDCat_CentroDeServicio").value;
    var nIDCat_Almacen = document.getElementById("cb_nIDCat_Almacen").value;
    var nIDCat_Cliente = document.getElementById("cb_nIDCat_Cliente").value;
    var nIDUsuario = document.getElementById("txt_nIDUsuario").value;
    var Cantidad = document.getElementById("txt_Cantidad").value;
    var Puntos = document.getElementById("txt_Puntos").value;
    var nID = document.getElementById("txt_nID").value;

    if(Codigo.length>0){
        if(nIDCat_CentroDeServicio.length > 0){
            if(nIDCat_Cliente.length >0){
                if(nIDUsuario.length >0){
                    if(Cantidad.length >0){
                        if(nIDCat_Almacen.length >0){

                            // Validacion
                            if (isNaN(nIDCat_CentroDeServicio)) {
                                document.getElementById("lbl_mensaje_falla").innerHTML="SELECCIONE EL CENTRO DE SERVICIO";             
                                $("#modal_falla").modal("show");
                                return;
                            }   

                            if (isNaN(nIDCat_Cliente)) {
                                document.getElementById("lbl_mensaje_falla").innerHTML="SELECCIONE EL CLIENTE";             
                                $("#modal_falla").modal("show");
                                return;
                            }   

                            if (isNaN(nIDUsuario)) {
                                document.getElementById("lbl_mensaje_falla").innerHTML="NO TIENE ID DEL CREADOR";             
                                $("#modal_falla").modal("show");
                                return;
                            }   

                            if (isNaN(Cantidad)) {
                                document.getElementById("lbl_mensaje_falla").innerHTML="CANTIDAD DEBE DE SER UN VALOR NUMERICO ENTERO";             
                                $("#modal_falla").modal("show");
                                return;
                            }   

                            if (isNaN(nIDCat_Almacen)) {
                                document.getElementById("lbl_mensaje_falla").innerHTML="SELECCIONE EL ALMACEN";             
                                $("#modal_falla").modal("show");
                                return;
                            }   


                            var obj={}; 
                            obj["codigo"]=Codigo;
                            obj["nidcat_centrodeservicio"]=nIDCat_CentroDeServicio;
                            obj["nidcat_almacen"]=nIDCat_Almacen;
                            obj["nidcat_cliente"]=nIDCat_Cliente;
                            obj["nidusuario"]=nIDUsuario;
                            obj["cantidad"]=Cantidad;
                            obj["puntos"]=Puntos;
                            obj["nid"]=nID;
                
                            var DATOS=new Array();    
                            DATOS.push(obj);    
                            
                            resultado=Anexar_Detalles(DATOS);     
                        } else {
                            document.getElementById("lbl_mensaje_falla").innerHTML="SELECCIONE EL ALMACEN";       
                            $("#modal_falla").modal("show");
                        }
                    } else {
                        document.getElementById("lbl_mensaje_falla").innerHTML="CAPTURE LA CANTIDAD";       
                        $("#modal_falla").modal("show");
                    }
                } else {
                    document.getElementById("lbl_mensaje_falla").innerHTML="NO ID DEL CREADOR DEL CANJE";       
                    $("#modal_falla").modal("show");
                }
            } else {
                document.getElementById("lbl_mensaje_falla").innerHTML="SELECCIONE EL CLIENTE";       
                $("#modal_falla").modal("show");
            }

        } else {
            document.getElementById("lbl_mensaje_falla").innerHTML="SELECCIONE EL CENTRO DE SERVICIO";       
            $("#modal_falla").modal("show");
        } 
      

    } else {
        document.getElementById("lbl_mensaje_falla").innerHTML="ESCANEE O CAPTURE EL CODIGO";       
        $("#modal_falla").modal("show");
    }
}



function fn_Crear_Detalles_Clic(){
    
    if(listadodeproductos.length>0){       
        // Enviar para procesdar
        resultado=Listado_Detalles_Grabar(listadodeproductos); 

    } else {
         console.log("ERROR NO SE CARGO LA INFORMACIÓN");      
        document.getElementById("lbl_mensaje_falla").innerHTML="NO TIENE DATOS PARA GRABAR";          
        $("#modal_falla").modal("show");
    }
   
}
// ************************************************************************************************



 