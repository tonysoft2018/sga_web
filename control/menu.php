<!DOCTYPE html>
<html>
<head>
	 <title>
		Proyecto
	 </title>
	 <meta charset="utf-8">
	 <meta name="viewport" content="width=dev-width, initial-scale=1, shrink-to-fit=no">
	 <meta http-equiv="x-ua-compatible" content="ie-edge">
	 <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

	 <style>
        footer {
	background-color:#1A1A1A;
	height: 50%;
  color: white;
  padding: 15px;
}

.main1 { 
  display:flex;
  margin:0 auto;
}

a img:hover {
    color: #fff;
}

.dropdown-submenu {
  position: relative;
}

.dropdown-submenu a::after {
  transform: rotate(-90deg);
  position: absolute;
  right: 6px;
  top: .8em;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-left: .1rem;
  margin-right: .1rem;
}
	 </style>

	 
		
</head>
<body>
    <!-- inicio -->

    <!-- TAMAÑOS DE DISPOSITIVOS 
        xs (<575)
    	sm (576 - 767 )
    	md (768 - 991)
    	lg (992 - 1199)
    	xl (1200 > )
    -->	

    <!-- MANEJO DE COLORES 
    	primary
    	secondary
    	dark
    	light
    	danger
    	warning
    	success
    	info
    	white
    -->
 

     <div class="container" >
		 <div class="row align-item-end h-50" style='background-color:#DFE1E1;'>
			 <div class="col-10">
                 <a href="#" class="navbar-brand"><img src="iconos/logo-zgas.png" style="width: 55px; height: 45px;"></a>					  
             </div>      
             
             <div class="col-2 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                 Admin      
                 <a href="#" class="navbar-brand"><img src="iconos/sinfoto.png" style="width: 35px; height: 35px;margin-left:10px;"></a>	                                                   			  
             </div>            
         </div>
          
 
    	 <div class="row align-item-end bg-light h-30">
    		 <div class="col-12">
			    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
     					<span class="navbar-toggler-icon"></span>
  					</button>
  
					<div class="collapse navbar-collapse" id="navbarTogglerDemo01">     				 
    					<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      						<li class="nav-item active">
								<a class="nav-link" href="menu.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'> <span class="sr-only">(current)</span>								     
									<img src="iconos/home.png" style="width: 20px; height: 20px; margin-left:2px;">
									<br>
									<label> Inicio	</label>		 
								</a>
      						</li>
	  						 
   							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
									<img src="iconos/catalogos.png" style="width: 20px; height: 20px; margin-left:12px;">
									<br>
									<label> Catalogos </label>	
								</a>
								
        						<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          							<li><a class="dropdown-item" href="cat_empresas.php" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;' >Empresas</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Almacenes</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Racks</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Pasillos</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;' >Matriz de Ubicaciones</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Productos</a></li>
          							<li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" style='text-aling:center;font-family:"Arial Black", Gadget, sans-serif; font-size:10px;'>Clasificacion de Productos</a>
            							<ul class="dropdown-menu">
              								<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Tipos de Productos</a></li>
											<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>SubTipos de Productos</a></li>
											<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Familias</a></li>
											<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Presentacion</a></li>
											<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Excepciones de Productos</a></li>
											<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Estado de Producto</a></li>											  
            							</ul>
									</li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Motivos de Traspasos</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Conceptos Operativos de Entrada-Salida</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Proveedores</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Clientes</a></li>
        						</ul>
							 </li>

							 <li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
								     <img src="iconos/recepcion.png" style="width: 20px; height: 20px; margin-left:2px;">
									 <br>
								     <label>Recibo </label>
								</a>

								<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Importacion de Packing List</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Recibo de productos</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Ubicaciones de productos</a></li>
								</ul>
							 </li>


							 <li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
								    <img src="iconos/inventarios.png" style="width: 20px; height: 20px; margin-left:12px;">
									<br>
								     <label>Inventarios </label>
								</a>

								<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Entrada de Productos por Compras</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Entradas por otros conceptos</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Salidas por otros conceptos</a></li>
									<li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" style='text-aling:center;font-family:"Arial Black", Gadget, sans-serif; font-size:10px;'>Inventario Fisico</a>
            							<ul class="dropdown-menu">
              								<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Inventario por artículo</a></li>
											<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Inventario por ubicación</a></li>
											<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Ajustes de Inventario</a></li>											 
            							</ul>
									</li>
								</ul>
							 </li>

							 <li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
								    <img src="iconos/traspasos.png" style="width: 20px; height: 20px; margin-left:12px;">
									<br>
								     <label>Traspasos </label>
								</a>

								<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Orden de Surtido</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Traspaso de Envio</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Traspaso de Recepcion</a></li>
								</ul>
							 </li>

							 <li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
								    <img src="iconos/reportes.png" style="width: 20px; height: 20px; margin-left:12px;">
									<br>
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
								<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
								    <img src="iconos/seguridad.png" style="width: 20px; height: 20px; margin-left:12px;">
									<br>
									<label>Seguridad </label>
								</a>

								<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Usuarios</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Perfiles</a></li>									 
								</ul>
							 </li>

							 <li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
								    <img src="iconos/parametros.png" style="width: 20px; height: 20px; margin-left:12px;">
									<br>

									<label>Parámetros</label>
								</a>

								<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Datos empresa</a></li>
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Conexión a la base de datos</a></li>		
									<li><a class="dropdown-item" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>Configuración de notificaciones y alertas</a></li>									 
								</ul>
							 </li>

							 <li class="nav-item active">
        						<a class="nav-link" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
								    <img src="iconos/interfaces.png" style="width: 20px; height: 20px; margin-left:12px;">
									<br>
									<label>
										Interfaces
									</label>
								</a>
							  </li>
							  
							  <li class="nav-item active">
								<a class="nav-link" href="#" style='text-aling:center;font-family:"Arial", Gadget, sans-serif; font-size:10px;'>
								   <img src="iconos/salida.png" style="width: 20px; height: 20px; margin-left:2px;">
									<br>
									<label>
									   Salir
									</label>
								</a>
      						</li>
						</ul>					
					  </div>
				 </nav>
			 </div>			 
		 </div>

		 <div class="row align-item-end h-20 bg-dark">			 
             <div class="col-2 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                 <label style='margin-top:10px; color:#fff;'> Inicio / Inicio </label>                                                                        			  
             </div>            
		 </div>
		  

	 
		 <div class="row">
			<div class="col-12  d-none d-lg-block fixed-bottom ">			 
				 <!-- <p class="text-muted small text-right">BLUAX<br> Todos los derechos reservados.</p> -->
				 <img src="iconos/piedepagina.png" style="width: 100%; height:200px;">
			 </div>
		 </div>		 
	</div>
	 

	<!-- FIN -->
	<script type="text/javascript" src="js/jquery-3.3.1.slim.min.js"></script>
	<script type="text/javascript" src="js/popper.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<script>
		$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
  			if (!$(this).next().hasClass('show')) {
    			$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
  			}
  			var $subMenu = $(this).next(".dropdown-menu");
  			$subMenu.toggleClass('show');

  			$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
    			$('.dropdown-submenu .show').removeClass("show");
  			});

  			return false;
		});
	</script>

</body>
</html>