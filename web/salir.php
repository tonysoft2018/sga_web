<?php   
        // ----------------------------------------------------------------------------------
        // interfaces.php
        // ----------------------------------------------------------------------------------
        // Autor. Ing. Antonio Barajas del Castillo
        // ----------------------------------------------------------------------------------
        // Empresa. Softernium SA de CV
        // ----------------------------------------------------------------------------------
        // Descripcion. Modulo para editar datos de un perfil.
        // ----------------------------------------------------------------------------------
        // Fecha Ultima Modificación
        // 26/11/2019
        // ----------------------------------------------------------------------------------
        // V2.0.0
        // ----------------------------------------------------------------------------------
        $l_Modulo="Inicio"; 
        $l_Accion="";   //Listado/Crear/Editar/Eliminar/Consultar/Imprimir  
        include_once "../parametros/modulos.php";

        ob_start();
        session_start();
		 
		session_destroy();
        header("Location: ../");
		
		

        // ----------------------------------------------
        // Carga datos generales
        include_once "../clases/clHerramientas_v2011.php";
        include_once "../utilerias/utilerias.php";
        $UtileriasDatos = new clHerramientasv2011();
        $l_FechaLocal = $UtileriasDatos->getFechaYHoraActual_General();
        $l_FechaLocal = $UtileriasDatos->ConvertirFechaYHora($l_FechaLocal);
        $NombrePC = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $Fecha = date('Y-m-d');
        $Hora = date('H:i:s');
        $l_FechaModificacion=$Fecha." ".$Hora;
        $l_FechaCreacion=$Fecha." ".$Hora;
        $l_Observaciones="Nueva captura - Creado por  - ".$NombrePC." - ".get_current_user()." - ".$l_FechaModificacion;
        $l_bEstado=0;
        // ----------------------------------------------

        if(isset($_SESSION['NUMERODESESION'])){
           
 
            // Cancela la sesion             
            // SEGURIDAD           
            $l_nIDSesion=0;             
            include_once "../clases/relauxs.mysql.class_v2.0.0.php";               
            include_once "../bd/conexion.php";         

            // Conexion con la base de Datos
            $l_Regreso=RegresaConexion();
            $CONEXION=json_decode($l_Regreso,true);  

            $l_Condicion="bEstado=0 and IDSesion='" . $_SESSION['NUMERODESESION'] . "'";      
            $tbl_RelaUxS = new  cltbl_RelaUxS_v2_0_0();
            $tbl_RelaUxS->Inicializacion();             
            $tbl_RelaUxS->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
            $tbl_RelaUxS->Leer($l_Condicion);
            if($tbl_RelaUxS->CualEsElNumeroDeRegistrosCargados()>0){

                $registros=$tbl_RelaUxS->dtBase();
                $l_nIDSesion=$registros[0]["nIDSesion"];
               
                $tbl_RelaUxS->Inicializacion();             
                $tbl_RelaUxS->DatosParaConectarse($CONEXION["servidor"],$CONEXION["usuario"],$CONEXION["password"],$CONEXION["bd"]);
                $tbl_RelaUxS->CambiarEstado($l_nIDSesion,$l_Observaciones, 1);

                session_destroy();
                header("Location: ../");

            }  else {
                //echo "SESION NO ENCONTRADA";
                session_destroy();
                header("Location: ../");
            }
 
        } else {
            //echo "NO TIENE SESION";
            session_destroy();
            header("Location: ../");
        } 

?>
	