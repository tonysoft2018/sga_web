<?php   
        // ----------------------------------------------------------------------------------
        // encabezado.php
        // ----------------------------------------------------------------------------------
        // Autor. Ing. Antonio Barajas del Castillo
        // ----------------------------------------------------------------------------------
        // Empresa. Softernium SA de CV        
        // ----------------------------------------------------------------------------------
        // Fecha Ultima Modificación
        // 26/11/2019
        // ----------------------------------------------------------------------------------
        // V2.0.0
        // ----------------------------------------------------------------------------------

        //ob_start();
        //session_start();

        // ***********************************************************************************
        // ----------------------------------------------
        // SEGURIDAD
        $l_UbicacionImagenes="../adjuntos/";
        $l_nIDUsuario=0;  
        $l_nIDSesion=0;
        $l_Usuario="";
        $l_Imagen="";    
        $l_ImagenMostrar="";   
        include_once "../clases/relauxs.mysql.class_v2.0.0.php";  
        include_once "../clases/usuarios.mysql.class_v2.0.0.php";   
        include_once "../clases/ambiente_logo.mysql.class_v2.0.0.php";
        include_once "../bd/conexion.php";         
        include_once "../utilerias/utilerias.php";
         
        // Conexion con la base de Datos
        $l_Regreso=RegresaConexion();
        $CONEXION=json_decode($l_Regreso,true);  
 
 
        if(isset($_SESSION['NUMERODESESION'])){
            // Extrae el ID de la Sesion
            
            
            $l_Condicion="bEstado=0 and IDSesion='" . $_SESSION['NUMERODESESION'] . "'";      
            $tbl_RelaUxS = new  cltbl_RelaUxS_v2_0_0();
            $tbl_RelaUxS->Inicializacion();
             
            $tbl_RelaUxS->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_RelaUxS->Leer($l_Condicion);
            if($tbl_RelaUxS->CualEsElNumeroDeRegistrosCargados()>0){
               
                $registros=$tbl_RelaUxS->dtBase();
                $l_nIDSesion=$registros[0]["nIDSesion"];
                $l_nIDUsuario=$registros[0]["nIDUsuario"];

                if($l_nIDSesion>0){
                    // Si se encontro la sesion
                     
                    if($l_nIDUsuario>0){
                        // Si se encontro el usuario

                        // Buscar el usuario
                        $tbl_Usuario = new  cltbl_Usuarios_v2_0_0();                       
                        $tbl_Usuario->Inicializacion();
                        $tbl_Usuario->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                        $tbl_Usuario->CargarCampos("LEER");
                        $l_Condicion="nIDUsuario=" . $l_nIDUsuario . " and Activo='SI' and bEstado=0 and (Web='SI' or App='SI')";
                        $tbl_Usuario->Leer($l_Condicion);
                        if($tbl_Usuario->CualEsElNumeroDeRegistrosCargados()>0){
                            $registros=$tbl_Usuario->dtBase();
                            $l_Imagen=$registros[0]["Imagen"];
                            $l_Usuario=$registros[0]["Usuario"];
                        } else {
                            // No se encontro el usuario
                                                     
                        }
                    } else {
                        // No se encontro el usuario
                        
                    }
                } else {
                    // No se encontro la sesion
                     
                }
            } else {
                // No encontrado 
                
            }
            
             	   	  
        } else {
            //echo "NO TIENE SESION";
         

        }

        if(strlen($l_Imagen)>0){
            $l_ImagenMostrar=$l_UbicacionImagenes . $l_Imagen;
        } else {
            $l_ImagenMostrar="../iconos/sinfoto.png";
        }
   
        // ----------------------------------------------
        // ***********************************************************************************

        // ----------------------------------------------
        // Carga el Logo
        $l_LOGOAPP="";
        $l_Condicion="bEstado=0";
        $tbl_logo = new  cltbl_Ambiente_Logo_v2_0_0();
        $tbl_logo->Inicializacion();
        $tbl_logo->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
        $tbl_logo->Leer($l_Condicion);
        if($tbl_logo->CualEsElNumeroDeRegistrosCargados()>0){
	        $registros=$tbl_logo->dtBase();
	        $l_LOGOAPP=$registros[0]["Logo"];
        }    
        // ----------------------------------------------
?>

<div class="container" >
	<div class="row align-item-end h-50" style='background-color:#DFE1E1;'>
		<div class="col-10">
        <?php if(strlen($l_LOGOAPP)>0){ ?>
            <a href="#" class="navbar-brand"><img src="<?php echo $l_UbicacionImagenes . $l_LOGOAPP ?>" style="width: 55px; height: 45px;"></a>					  
        <?php } ?>
        </div>      
             
        <div class="col-2 align-middle align-items-center  float-xs-right d-none d-lg-block" style='vertical-aling:middle;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
             <?php echo $l_Usuario ?>
             <a href="#" class="navbar-brand"><img src="<?php echo $l_ImagenMostrar ?>" style="width: 35px; height: 35px;margin-left:10px;"></a>	                                                   			  
        </div>            
    </div>
</div>
	 
 