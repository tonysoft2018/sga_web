<?php
// ----------------------------------------------------------------------------------
// barra_botones.php
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
  
if($l_Accion=="Listado"){ 
             switch($l_Modulo){
                // ----------------------------------------------------------------------------------
                // CATALOGOS
                 case "cat_empresas":
?>                    
                         <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  

<?php                    
                     break;

                 case "cat_centrosdeservicio":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;

                 case "cat_almacen":
 ?>                    
                     <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;

                 case "cat_racks":
?>                  
                     <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;

                 
                 case "cat_pasillos":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;

                 case "cat_matriz":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                          
<?php                    
                     break;


                 case "cat_productos":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;

                 case "cat_tipos":
 ?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;     

                 case "cat_subtipos":
 ?>                    
                     <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;     

                 case "cat_familias":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;     

                 case "cat_presentaciones":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;     

                 case "cat_excepciones":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;  
                    
                 case "cat_unidadesdemedida":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;     

                 case "cat_estados":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;   
                     
                 case "cat_motivostraspaso":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;                    


                 case "cat_conceptosentrada":
?>                    
                    <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;     

                 case "cat_conceptossalida":
?>                  
                     <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;  

                 case "cat_proveedores":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;    
                     
                 case "cat_clientes":
?>                   
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_cargar.php" style='width:65px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Cargar</button></a>
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;     
                     
                // ----------------------------------------------------------------------------------

                // ----------------------------------------------------------------------------------
                // RECIBO

                 case "packinglist":
?>                                                               
                     <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                  
<?php                    
                     break;     


                 case "entradasxcompras":
?>                    
                     
<?php                    
                     break;   
                    
                 case "entradaporotrosconceptos":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                             
<?php                    
                     break;   

                 case "salidaporotrosconceptos":
?>                    
                     <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                        
<?php                    
                     break;   

                 case "ordendesurtido":
?>                    
                       <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                   
<?php                    
                     break;   

                 case "traspasos_envio":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                   
<?php                    
                     break;   

                case "inventarioxarticulo":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                   
<?php                    
                     break;       
                     
                case "inventarioxubicacion":
?>                    
                      <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                   
<?php                    
                     break;                

                case "ajustes":
 
                     break;                
                 case "usuarios":
                    ?>                    
                    <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                      <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                         <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                           <tr>
                               <td>
                                   <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                       <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>
                                        
                                   </form>
                               </td>                                     
                           </tr>                         
                        </table>        
                     </div>
                    </div>                  

<?php                    
                break;

                 case "perfiles":
?>                    
                     <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                             
<?php                    
                     break;   

                 case "ambiente_clasificaciones":
?>                    
                     <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                    
<?php                    
                     break;   


                    case "notificaciones":
?>                    
                     <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                    
<?php                    
                     break;   

                 case "ambiente_modulos":
?>                    
                     <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                                
<?php                    
                     break;   

                 case "interfaces":
?>                    
                    <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                           <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                              <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                <tr>
                                    <td>
                                        <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                            <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                        </form>
                                    </td>                                     
                                </tr>                         
                             </table>        
                          </div>
                         </div>                   
<?php                    
                     break;   

                 case "canjepuntos":
 ?>                    
                     <div class="row align-item-end h-20 " style='margin-top:-10px;'>	
                         <div class="col-12 align-middle d-flex align-items-center .hidden-md float-xs-right" style='vertical-aling:middle;display:block;font-size:10px; font-family:"Arial Black", Gadget, sans-serif'>
                             <table style='width:100%;text-align:rigth;margin-left:-10px;'>                               
                                 <tr>
                                     <td>
                                         <form id='frm_Consultar' class="form-inline borderless" style='border-style: none;'> 
                                             <a class="nav-link" href="<?php echo $l_Modulo ?>_editar.php" style='width:65px;margin-left:-15px;'><button type="button" class="btn btn-primary" style='font-size:12px; font-family:"Arial", Gadget, sans-serif;'>Nuevo</button></a>                                             
                                         </form>
                                     </td>                                     
                                 </tr>                         
                             </table>        
                         </div>
                     </div>                   
<?php                    
                     break;   
            }            
?>            
       <!-- </form> -->
      
   
<?php
}  
?>