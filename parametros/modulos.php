<?php
// ----------------------------------------------------------------------------------
// modulos.php
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

// ----------------------------------------------
date_default_timezone_set("America/Mexico_City");
// ----------------------------------------------
 
switch($l_Modulo){
     // Catalogos
     case "cat_empresas":
            $l_Menu="Catalogos";
            $l_SubMenu1="Empresas";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";
            
            $CAMPO_ORDENAMIENTO="RazonSocial";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Empresa";

            break;

     case "cat_centrosdeservicio":
            $l_Menu="Catalogos";
            $l_SubMenu1="Centros de Servicio";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="CentroDeServicio";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_CentroDeServicio";

            break;

     case "cat_almacen":
            $l_Menu="Catalogos";
            $l_SubMenu1="Almacen";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="Almacen";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Almacen";
            
            break;

     case "cat_racks":
            $l_Menu="Catalogos";
            $l_SubMenu1="Racks";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";
            $ULTIMA_CONDICION="";

            $CAMPO_ORDENAMIENTO="Rack";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Rack";

            break;

     case "cat_pasillos":
            $l_Menu="Catalogos";
            $l_SubMenu1="Pasillos";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="Pasillo";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Pasillo";

            break;

    case "cat_matriz":
            $l_Menu="Catalogos";
            $l_SubMenu1="Matriz de Ubicaciones";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="Matriz";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Matriz";

            break;

     case "cat_productos":
            $l_Menu="Catalogos";
            $l_SubMenu1="Productos";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="Producto";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Producto";

            break;

    case "cat_tipos":
            $l_Menu="Catalogos";
            $l_SubMenu1="Clasificacion de Productos";
            $l_SubMenu1_1="Tipos";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="Tipo";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Tipo";
 
            break;

    case "cat_subtipos":
            $l_Menu="Catalogos";
            $l_SubMenu1="Clasificacion de Productos";
            $l_SubMenu1_1="SubTipos";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="SubTipo";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_SubTipo";

            break;

    case "cat_familias":
            $l_Menu="Catalogos";
            $l_SubMenu1="Clasificacion de Productos";
            $l_SubMenu1_1="Familias";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="Familia";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Familia";

            break;

    case "cat_presentaciones":
            $l_Menu="Catalogos";
            $l_SubMenu1="Clasificacion de Productos";
            $l_SubMenu1_1="Presentaciones";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="Presentacion";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Presentacion";

            break;

    case "cat_excepciones":
            $l_Menu="Catalogos";
            $l_SubMenu1="Clasificacion de Productos";
            $l_SubMenu1_1="Excepciones";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="Excepcion";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Excepcion";

            break;

     case "cat_unidadesdemedida":
            $l_Menu="Catalogos";
            $l_SubMenu1="Clasificacion de Productos";
            $l_SubMenu1_1="Unidades de Medida";
            $l_SubMenu1_1_1="";
    
            $CAMPO_ORDENAMIENTO="UnidadDeMedida";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;
    
            $NOMBRE_COMBO="cb_nIDCat_UnidadDeMedida";
    
            break;
    

    case "cat_estados":
            $l_Menu="Catalogos";
            $l_SubMenu1="Estados";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="Estado";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Estado";

            break;

    case "cat_motivostraspaso":
            $l_Menu="Catalogos";
            $l_SubMenu1="Motivos de Traspasos";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="Motivo";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_MotivosTraspaso";

            break;

    case "cat_conceptosentrada":
            $l_Menu="Catalogos";
            $l_SubMenu1="Conceptos Operativos de Entrada";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="ConceptoEntrada";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_ConceptoEntrada";

            break;

    case "cat_conceptossalida":
            $l_Menu="Catalogos";
            $l_SubMenu1="Conceptos Operativos de Salida";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="ConceptoSalida";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_ConceptoSalida";

            break;

    case "cat_proveedores":
            $l_Menu="Catalogos";
            $l_SubMenu1="Proveedores";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="RazonSocial";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Proveedor";

            break;

    case "cat_clientes":
            $l_Menu="Catalogos";
            $l_SubMenu1="Clientes";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="RazonSocial";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDCat_Cliente";

            break;


     // Recibo
    case "packinglist":
            $l_Menu="Recibo";
            $l_SubMenu1="Importacion";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="Folio";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="cb_nIDPackingList";

            break;

     case "etiquetado":
            $l_Menu="Recibo";
            $l_SubMenu1="Etiquetado";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";
    
            $CAMPO_ORDENAMIENTO="Folio";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;
    
            $NOMBRE_COMBO="cb_nIDPackingList";
    
            break;

    case "recibo":
            $l_Menu="Recibo";
            $l_SubMenu1="Recibo";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";
    
            $CAMPO_ORDENAMIENTO="Folio";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;
    
            $NOMBRE_COMBO="cb_nIDPackingList";
    
            break;

    case "inspeccion":
            $l_Menu="Inspeccion";
            $l_SubMenu1="Inspeccion";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";
    
            $CAMPO_ORDENAMIENTO="Folio";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;
    
            $NOMBRE_COMBO="cb_nIDPackingList";
    
            break;            

    case "ubicaciones":
            $l_Menu="Recibo";
            $l_SubMenu1="Ubicaciones";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";
    
            $CAMPO_ORDENAMIENTO="Folio";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;
    
            $NOMBRE_COMBO="cb_nIDPackingList";
    
            break;

    // Inventarios
     case "entradasxcompras":
           $l_Menu="Inventarios";
           $l_SubMenu1="Entradas de Productos por Comrpas";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDPackingList";
        
           break;

       case "contenedores":
           $l_Menu="Inventarios";
           $l_SubMenu1="Entradas de Productos por Comrpas";
           $l_SubMenu1_1="Contenedores";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
        
           $NOMBRE_COMBO="cb_nIDPackingList";
        
           break;

       case "entradadeproductos":
           $l_Menu="Inventarios";
           $l_SubMenu1="Entradas de Productos por Compras";
           $l_SubMenu1_1="Entrada de Productos";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDPackingList";
        
           break;


       case "entradaporotrosconceptos":
           $l_Menu="Inventarios";
           $l_SubMenu1="Entradas Por Otros Conceptos";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDPackingList";
        
           break;

      case "entradaporotrosconceptos_detalles":
           $l_Menu="Inventarios";
           $l_SubMenu1="Entradas Por Otros Conceptos - Detalles";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDPackingList";
        
           break;

      case "salidaporotrosconceptos":
           $l_Menu="Inventarios";
           $l_SubMenu1="Salidas Por Otros Conceptos";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDPackingList";
        
           break;

      case "salidaporotrosconceptos_detalles":
           $l_Menu="Inventarios";
           $l_SubMenu1="Salidas Por Otros Conceptos - Detalles";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDPackingList";
        
           break;

       case "inventarioxarticulo":
           $l_Menu="Inventarios";
           $l_SubMenu1="Inventario Fisico";
           $l_SubMenu1_1="Inventario por Articulo";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
                   
           $NOMBRE_COMBO="cb_nIDPackingList";
        
           break;     

        case "inventarioxarticulo_detalles":
           $l_Menu="Inventarios";
           $l_SubMenu1="Inventario Fisico";
           $l_SubMenu1_1="Inventario por Articulo - Detalles";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDPackingList";
        
           break;     

      

       case "inventarioxubicacion":
           $l_Menu="Inventarios";
           $l_SubMenu1="Inventario Fisico";
           $l_SubMenu1_1="Inventario por Ubicacion";
           $l_SubMenu1_1_1="";
             
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
             
           $NOMBRE_COMBO="cb_nIDPackingList";
             
           break;     

        case "inventarioxubicacion_detalles":
           $l_Menu="Inventarios";
           $l_SubMenu1="Inventario Fisico";
           $l_SubMenu1_1="Inventario por Ubicacion - Detalles";
           $l_SubMenu1_1_1="";
             
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
             
           $NOMBRE_COMBO="cb_nIDPackingList";
             
           break;     

        case "ajustes":
           $l_Menu="Inventarios";
           $l_SubMenu1="Inventario Fisico";
           $l_SubMenu1_1="Ajustes";
           $l_SubMenu1_1_1="";
                     
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
                     
           $NOMBRE_COMBO="cb_nIDPackingList";
                     
           break;     
      // Traspasos
      case "ordendesurtido":
           $l_Menu="Traspasos";
           $l_SubMenu1="Orden de Surtido";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDOrdenDeSurtido";
        
           break;

      case "traspasos_envio":
           $l_Menu="Traspasos";
           $l_SubMenu1="Traspasos de Envio";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDOrdenDeSurtido";
        
           break;

      case "traspasos_envio_detalles":
           $l_Menu="Traspasos";
           $l_SubMenu1="Traspaso de Envio - Movil";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDPackingList";
        
           break;

      case "traspasos_recepcion":
           $l_Menu="Traspasos";
           $l_SubMenu1="Traspasos de Recepcion";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDOrdenDeSurtido";
        
           break;


      case "traspasos_recepcion_detalles":
           $l_Menu="Traspasos";
           $l_SubMenu1="Traspaso de Recepcion - Movil";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="cb_nIDPackingList";
        
           break;

      case "reporte_inventarios":
           $l_Menu="Reportes";
           $l_SubMenu1="Inventario por almacen";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="";
        
           break;

     case "reportes_tiposalida":
           $l_Menu="Reportes";
           $l_SubMenu1="Reportes por Tipos de Salida";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="";
        
           break;

      case "reportes_historico":
           $l_Menu="Reportes";
           $l_SubMenu1="Historico de Productos por Entradas, Salidas y Traspasos";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
        
           $CAMPO_ORDENAMIENTO="Folio";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
        
           $NOMBRE_COMBO="";
        
           break;


     // Parametros
     case "ambiente_bannerapp":
            $l_Menu="Parametros";
            $l_SubMenu1="Banner";
            $l_SubMenu1_1="";
            $l_SubMenu1_1_1="";

            $CAMPO_ORDENAMIENTO="nIDBannerApp";
            $FORMA_ORDENAMIENTO="Ascendente";
            $ULTIMA_CONSULTA="";
            $ULTIMA_CONDICION="";
            $NUMERODEREGISTROS=0;
            $PAGINA_ACTUAL=1;

            $NOMBRE_COMBO="";

            break;

     case "ambiente_imagenapp":
           $l_Menu="Parametros";
           $l_SubMenu1="Imagen";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
    
           $CAMPO_ORDENAMIENTO="nIDImagenApp";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
    
           $NOMBRE_COMBO="";
    
           break;

     case "ambiente_logo":
           $l_Menu="Parametros";
           $l_SubMenu1="Logo";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
    
           $CAMPO_ORDENAMIENTO="nIDLogo";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
    
           $NOMBRE_COMBO="";
    
           break;

     case "ambiente_datosdelaempresa":
           $l_Menu="Parametros";
           $l_SubMenu1="Datos empresa";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
    
           $CAMPO_ORDENAMIENTO="nIDDatosDeLaEmpresa";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
    
           $NOMBRE_COMBO="";
    
           break;

     case "ambiente_servidorcorreos":
           $l_Menu="Parametros";
           $l_SubMenu1="Servidor de Correos";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
    
           $CAMPO_ORDENAMIENTO="nIDCorreo";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
    
           $NOMBRE_COMBO="";
    
           break;        
                
     case "ambiente_bd":
           $l_Menu="Parametros";
           $l_SubMenu1="Conexión a la base de datos";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
    
           $CAMPO_ORDENAMIENTO="";
           $FORMA_ORDENAMIENTO="";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
    
           $NOMBRE_COMBO="";
    
           break;       
                
    case "ambiente_usuarios":
           $l_Menu="Parametros";
           $l_SubMenu1="Usuarios Configuracion";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
    
           $CAMPO_ORDENAMIENTO="";
           $FORMA_ORDENAMIENTO="";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
    
           $NOMBRE_COMBO="";
    
           break;     
                
    case "ambiente_modulos":
           $l_Menu="Parametros";
           $l_SubMenu1="Modulos";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
    
           $CAMPO_ORDENAMIENTO="";
           $FORMA_ORDENAMIENTO="";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
    
           $NOMBRE_COMBO="";
    
           break;    
                
    case "ambiente_clasificaciones":
           $l_Menu="Parametros";
           $l_SubMenu1="Clasificaciones";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
    
           $CAMPO_ORDENAMIENTO="Clasificacion";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
    
           $NOMBRE_COMBO="";
    
           break;      
           
      case "notificaciones":
           $l_Menu="Parametros";
           $l_SubMenu1="Notificaciones";
           $l_SubMenu1_1="";
           $l_SubMenu1_1_1="";
    
           $CAMPO_ORDENAMIENTO="Notificacion";
           $FORMA_ORDENAMIENTO="Ascendente";
           $ULTIMA_CONSULTA="";
           $ULTIMA_CONDICION="";
           $NUMERODEREGISTROS=0;
           $PAGINA_ACTUAL=1;
    
           $NOMBRE_COMBO="";
    
           break;      
                
    // Seguridad     
    case "usuarios":
          $l_Menu="Seguridad";
          $l_SubMenu1="Usuarios";
          $l_SubMenu1_1="";
          $l_SubMenu1_1_1="";

          $CAMPO_ORDENAMIENTO="Usuario";
          $FORMA_ORDENAMIENTO="Ascendente";
          $ULTIMA_CONSULTA="";
          $ULTIMA_CONDICION="";
          $NUMERODEREGISTROS=0;
          $PAGINA_ACTUAL=1;

          $NOMBRE_COMBO="";

          break;      

    case "perfiles":
          $l_Menu="Seguridad";
          $l_SubMenu1="Perfiles";
          $l_SubMenu1_1="";
          $l_SubMenu1_1_1="";

          $CAMPO_ORDENAMIENTO="Perfil";
          $FORMA_ORDENAMIENTO="Ascendente";
          $ULTIMA_CONSULTA="";
          $ULTIMA_CONDICION="";
          $NUMERODEREGISTROS=0;
          $PAGINA_ACTUAL=1;

          $NOMBRE_COMBO="";

          break;       

    // Interfaces
    case "interfaces":
          $l_Menu="Interfaces";
          $l_SubMenu1="";
          $l_SubMenu1_1="";
          $l_SubMenu1_1_1="";

          $CAMPO_ORDENAMIENTO="Interfaz";
          $FORMA_ORDENAMIENTO="Ascendente";
          $ULTIMA_CONSULTA="";
          $ULTIMA_CONDICION="";
          $NUMERODEREGISTROS=0;
          $PAGINA_ACTUAL=1;

          $NOMBRE_COMBO="";

          break;    
          
    case "canjepuntos":
          $l_Menu="Canjes";
          $l_SubMenu1="Canje de Puntos";
          $l_SubMenu1_1="";
          $l_SubMenu1_1_1="";

          $CAMPO_ORDENAMIENTO="Fecha";
          $FORMA_ORDENAMIENTO="Ascendente";
          $ULTIMA_CONSULTA="";
          $ULTIMA_CONDICION="";
          $NUMERODEREGISTROS=0;
          $PAGINA_ACTUAL=1;

          $NOMBRE_COMBO="cb_nIDCanje";

          break;
}

?>
 