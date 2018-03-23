<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

$tra = new Login();
$ses = $tra->ExpiraSession();

$reg = $tra->DetallesDevolucionesPorId();

if(isset($_POST['btn-update']))
{
$reg = $tra->ActualizarDetallesDevoluciones();
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
	<link href="assets/img/favicon.png" rel="icon" type="image">

    <title></title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">
	
	<script src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/script/script2.js"></script>
	<!-- Autocompleto -->
	<link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/script/autocompleto.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
	<script type="text/javascript" src="assets/script/script.js"></script>

  </head>

  <body onLoad="muestraReloj()">

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
       <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Menú de Navegación"></div>
              </div>
            <!--logo start-->
            <a href="panel" class="logo"></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- settings start -->
                    <li class="dropdown">
                        <a href="password" class="dropdown-toggle">
                            <i class="fa fa-edit"></i> Cambiar Password
                            <span class="badge bg-theme"><i class="fa fa-edit tooltips" data-placement="right" data-original-title="Cambiar Password"></i></span>
                        </a>
                    </li>
					
					<li class="dropdown">
                        <a href="bloqueo" class="dropdown-toggle">
                            <i class="fa fa-minus-circle"></i> Bloquear Cuenta
                            <span class="badge bg-theme"><i class="fa fa-minus-circle tooltips" data-placement="right" data-original-title="Bloquear Cuenta"></i></span>
                        </a>
                    </li>
					
					<?php  if ($_SESSION['acceso'] == "administrador")  {  ?>	
					<li class="dropdown">
                        <a href="configuracion" class="dropdown-toggle">
                            <i class="fa fa-cog"></i> Configuración
                            <span class="badge bg-theme"><i class="fa fa-cog tooltips" data-placement="right" data-original-title="Configuración"></i></span>
                        </a>
                    </li>
				<?php } ?>	
					
                   <!-- settings end -->
                   
                </ul>
                <!--  notification end -->
            </div>
			
			
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout"><i class="fa fa-power-off"></i> Salir</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
     <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><?php
	if (isset($_SESSION['cedula'])) {
	if (file_exists("fotos/".$_SESSION['cedula'].".jpg")){
    echo "<img src='fotos/".$_SESSION['cedula'].".jpg?' class='img-circle' border='0' width='60'>"; 
}else{
    echo "<img src='fotos/avatar.jpg' class='img-circle' width='60'>"; 
} } else {
	echo "<img src='fotos/avatar.jpg' class='img-circle' width='60'>"; 
}
?></p>
              	  <h5 class="centered"><?php echo estado($_SESSION['acceso']); ?></h5>
             
			  <!----- INICIO DE MENU ----->
			  <?php include('menu.php'); ?>
			  <!----- FIN DE MENU ----->
				  

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-tasks"></i> Módulo Actualización para Detalle de Devolución de Productos</h3><br>
          	
          	<!-- BASIC FORM ELELEMNTS -->
			
			<div class="row">
						    <div class="col-lg-12">
                                <div class="panel panel-border panel-warning widget-s-1">
               <div class="panel-heading"><h4 class="mb"><i class="fa fa-edit"></i> Formulario para Actualización de Detalle de Devolución de Productos</h4> </div>
                                    <div class="panel-body">
<form class="form-horizontal" method="post"  action="#" name="updatedetallesdevoluciones" id="updatedetallesdevoluciones" data-id="<?php echo $reg[0]["coddetalledevolucion"] ?>">

                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                     </div>   
						 <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Rif de Proveedor: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
			 <input type="hidden" name="codproveedor" id="codproveedor" value="<?php echo $reg[0]['codproveedor']; ?>">
                                  <input type="text" class="form-control" name="ritproveedor" id="ritproveedor" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Rif de Poveedor" value="<?php echo $reg[0]['ritproveedor']; ?>" readonly="readonly" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						   <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Nombre de Proveedor: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="nomproveedor" id="nomproveedor" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre de Proveedor" value="<?php echo $reg[0]['nomproveedor']; ?>" readonly="readonly" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						    <div class="form-group has-feedback">
			 <input type="hidden" name="coddetalledevolucion" id="coddetalledevolucion" value="<?php echo $reg[0]['coddetalledevolucion']; ?>">
			 <input type="hidden" name="coddevolucion" id="coddevolucion" value="<?php echo $reg[0]['coddevolucion']; ?>">
         	 <input type="hidden" name="existencia" id="existencia" value="<?php echo $reg[0]['existencia']; ?>" >
                              <label class="col-sm-2 col-sm-2 control-label">Código Producto: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="codproducto" id="codproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo $reg[0]['codproducto']; ?>" readonly="readonly">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						   <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Nombre de Producto: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="producto" id="producto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo $reg[0]['producto']; ?>" readonly="readonly">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Categoria: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomcategoria" id="nomcategoria" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo $reg[0]['nomcategoria']; ?>" readonly="readonly">
                              <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Precio Devolución: <span class="symbol required"></span></label>
                              <div class="col-sm-10"> 
<input class="form-control" type="text" name="preciodevolucion" id="preciodevolucion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo $reg[0]['preciodevolucion']; ?>" readonly="readonly"> <i class="fa fa-money form-control-feedback"></i>
                              </div>
                          </div>
							
						   <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Cantidad Devolución: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                   <input class="form-control calculodevolucion" type="text" name="cantdevolucion" id="cantdevolucion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad de Devolución" value="<?php echo $reg[0]['cantdevolucion']; ?>" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>	
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Lote Devolución: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                   <input class="form-control" type="text" name="lote" id="lote" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Lote de Devolución" value="<?php echo $reg[0]['lotedevolucion']; ?>" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Importe: <span class="symbol required"></span></label>
                              <div class="col-sm-10"> 
<input class="form-control number" type="text" name="importe" id="importe" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Importe" value="<?php echo $reg[0]['importe']; ?>" readonly="readonly"> <i class="fa fa-money form-control-feedback"></i>
                              </div>
                          </div>		 
								
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Fecha Devolución: </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="fechadetalledevolucion" id="fechadetalledevolucion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo date("d-m-Y h:i:s",strtotime($reg[0]['fechadetalledevolucion'])); ?>" readonly="readonly">
                        <i class="fa fa-calendar form-control-feedback"></i>
                              </div>
                          </div>
						                           
						  <div class="modal-footer"> 
                          <button class="btn btn-danger" type="reset"><span class="fa fa-times"></span> Cancelar</button> 
                          <button type="submit" name="btn-update" id="btn-update" class="btn btn-primary"><span class="fa fa-edit"></span> Actualizar</button> 
                          </div>
                      </form>
                                  </div>
                                </div>
                            </div>
						 </div>
						 
          	
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
       <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              © <span class="current-year"></span>
              <a id="scroll-top" href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster 
    <script src="assets/js/jquery.js"></script>-->
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>

	<!--custom switch-->
	<script src="assets/js/bootstrap-switch.js"></script>
	
	<!--custom tagsinput-->
	<script src="assets/js/jquery.tagsinput.js"></script>
	
	<!--custom checkbox & radio-->
	<script type="text/javascript" src="assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>    
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
<?php } else { ?>	
		<script type='text/javascript' language='javascript'>
	    alert('USTED NO TIENE ACCESO A ESTE MODULO, NO ERES EL ADMINISTRADOR DEL SISTEMA')  
		document.location.href='panel.php'	 
        </script> 
<?php } } else { ?>
		<script type='text/javascript' language='javascript'>
	    alert('USTED NO TIENE ACCESO A ESTA PAGINA, DEBERA DE INICIAR SESION')  
		document.location.href='logout.php'	 
        </script> 
<?php } ?>