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
?>

 <div class="col-12">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>
              
         <div class="collapse navbar-collapse" id="navbarTogglerDemo01">     				 
             <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                 <li class="nav-item active">
                     <a class="nav-link" href="menu.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'> <span class="sr-only">(current)</span>								     
                    
                         <label> Inicio	</label>		 
                     </a>
                 </li>
                                           
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
                         
                         <label> Catalogos </label>	
                     </a>
                                            
                     <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                         <li><a class="dropdown-item" href="cat_empresas.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;' >Empresas**</a></li>
                         <li><a class="dropdown-item" href="cat_centrosdeservicio.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Centros de Servicios**</a></li>
                         <li><a class="dropdown-item" href="cat_almacen.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Almacenes**</a></li>
                         <li><a class="dropdown-item" href="cat_racks.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Racks**</a></li>
                         <li><a class="dropdown-item" href="cat_pasillos.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Pasillos**</a></li>
                         <li><a class="dropdown-item" href="cat_matriz.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;' >Matriz de Ubicaciones*</a></li>
                         <li><a class="dropdown-item" href="cat_productos.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Productos**</a></li>
                         <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" style='text-aling:center;font-family:"Arial Black", Gadget, sans-serif; font-size:10px;'>Clasificacion de Productos</a>
                             <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="cat_tipos.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Tipos de Productos**</a></li>
                                 <li><a class="dropdown-item" href="cat_subtipos.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>SubTipos de Productos**</a></li>
                                 <li><a class="dropdown-item" href="cat_familias.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Familias**</a></li>
                                 <li><a class="dropdown-item" href="cat_presentaciones.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Presentacion**</a></li>
                                 <li><a class="dropdown-item" href="cat_excepciones.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Excepciones de Productos**</a></li>        
                                 <li><a class="dropdown-item" href="cat_unidadesdemedida.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Unidades de Medida**</a></li>                          								  
                             </ul>
                         </li>
                         <li><a class="dropdown-item" href="cat_estados.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Estados de Inspeccion**</a></li>
                         <li><a class="dropdown-item" href="cat_motivostraspaso.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Motivos de Traspasos**</a></li>
                         <li><a class="dropdown-item" href="cat_conceptosentrada.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Conceptos Operativos de Entrada**</a></li>
                         <li><a class="dropdown-item" href="cat_conceptossalida.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Conceptos Operativos de Salida*</a></li>
                         <li><a class="dropdown-item" href="cat_proveedores.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Proveedores**</a></li>
                         <li><a class="dropdown-item" href="cat_clientes.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Clientes**</a></li>
                     </ul>
                 </li>
            
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
                       
                         <label>Recibo </label>
                     </a>
            
                     <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                         <li><a class="dropdown-item" href="importacion.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Importacion de Packing List</a></li>
                         <li><a class="dropdown-item" href="recibo.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Recibo de productos</a></li>
                         <li><a class="dropdown-item" href="ubicacion.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Ubicaciones de productos</a></li>
                     </ul>
                 </li>
                        
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
                        
                         <label>Inventarios </label>
                     </a>
            
                     <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                         <li><a class="dropdown-item" href="entradasxcompras.asp" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Entrada de Productos por Compras</a></li>
                         <li><a class="dropdown-item" href="entradasxotrosconceptos.asp" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Entradas por otros conceptos</a></li>
                         <li><a class="dropdown-item" href="salidasxotrosconceptos.asp" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Salidas por otros conceptos</a></li>
                         <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="" style='text-aling:center;font-family:"Arial Black", Gadget, sans-serif; font-size:10px;'>Inventario Fisico</a>
                             <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Inventario por artículo</a></li>
                                 <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Inventario por ubicación</a></li>
                                 <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Ajustes de Inventario</a></li>											 
                             </ul>
                         </li>
                     </ul>
                 </li>
            
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
                       
                         <label>Traspasos </label>
                     </a>
            
                     <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                         <li><a class="dropdown-item" href="ordensurtido.asp" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Orden de Surtido</a></li>
                         <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Traspaso de Envio</a></li>
                         <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Traspaso de Recepcion</a></li>
                     </ul>
                 </li>
            
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
                        
                         <label>Reportes </label>
                     </a>
            
                     <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                         <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Recepcion de productos</a></li>
                         <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Inventario por almacén</a></li>
                         <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Histórico de productos por entradas, salidas y traspasos</a></li>
                         <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Cortesías de regalo por periodo</a></li>
                         <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Reporte por tipo de salidas</a></li>
                         <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Reporte por tipo de entradas</a></li>
                         <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Reporte de Incidencias</a></li>
                     </ul>
                 </li>
            
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
                         
                         <label>Seguridad </label>
                     </a>
            
                     <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                         <li><a class="dropdown-item" href="usuarios.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Usuarios*</a></li>
                         <li><a class="dropdown-item" href="perfiles.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Perfiles*</a></li>									 
                     </ul>
                 </li>
            
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
                          
                         <label>Parámetros</label>
                     </a>
            
                     <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                         <li><a class="dropdown-item" href="ambiente_bannerapp_editar.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Banner*</a></li>	
                         <li><a class="dropdown-item" href="ambiente_clasificaciones.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Clasificaciones*</a></li>	
                         <li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Configuración de notificaciones y alertas</a></li>	
                         <li><a class="dropdown-item" href="ambiente_bd_editar.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Conexión a la base de datos*</a></li>
                         <li><a class="dropdown-item" href="ambiente_datosdelaempresa_editar.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Datos empresa*</a></li>
                         <li><a class="dropdown-item" href="ambiente_imagenapp_editar.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Imagen*</a></li>	
                         <li><a class="dropdown-item" href="ambiente_logo_editar.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Logo*</a></li>	
                         <li><a class="dropdown-item" href="ambiente_modulos.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Modulos*</a></li>
                         <li><a class="dropdown-item" href="ambiente_usuarios_editar.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Usuarios Configuracion*</a></li>
                         <li><a class="dropdown-item" href="ambiente_servidorcorreos_editar.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Servidor de Correos*</a></li>		
                     </ul>
                 </li>
            
                 <li class="nav-item active">
                     <a class="nav-link" href="interfaces.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
                        
                         <label> Interfaces *</label>
                     </a>
                 </li>
                                          
                 <li class="nav-item active">
                     <a class="nav-link" href="login.asp" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
                       
                         <label> Salir </label>
                     </a>
                 </li>
             </ul>					
         </div>
     </nav>                     	 
 </div>			 
       

		 