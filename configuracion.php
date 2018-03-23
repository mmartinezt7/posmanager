<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador") {

$tra = new Login();
$ses = $tra->ExpiraSession();

$reg = $tra->ConfiguracionPorId();

if(isset($_POST['btn-update']))
{
$reg = $tra->ActualizarConfiguracion();
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
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
	<script src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script> 
	<script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
	<script type="text/javascript" src="assets/script/script.js"></script>
		<script type="text/javascript">
    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
    }, "Ingrese solo letras para Nombre de Responsable");
  </script>
	<script type="text/javascript">
	$(document).ready(function() {
	$("#tlfempresa").mask("(9999) 9999999"); 
	$("#tlfresponsable").mask("(9999) 999-9999");
	});
	</script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
					
					<li class="dropdown">
                        <a href="configuracion" class="dropdown-toggle">
                            <i class="fa fa-cog"></i> Configuración
                            <span class="badge bg-theme"><i class="fa fa-cog tooltips" data-placement="right" data-original-title="Configuración"></i></span>
                        </a>
                    </li>
					
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
          	<h3><i class="fa fa-tasks"></i> Módulo de Configuración General</h3><br>
          	
          	<!-- BASIC FORM ELELEMNTS -->
			
			<div class="row">
						    <div class="col-lg-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading"><h4 class="mb"><i class="fa fa-edit"></i> Formulario de Configuración General</h4> </div>
                                    <div class="panel-body">
                    <form class="form-horizontal" method="post" data-id="<?php echo $reg[0]["id"] ?>" action="#" name="configuracion" id="configuracion">

                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                     </div>   
						 <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Rif de Empresa: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                  <input type="hidden" name="id" id="id" value="<?php echo $reg[0]['id']; ?>">
                                  <input type="text" class="form-control" name="rifempresa" id="rifempresa" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Rif de Empresa" value="<?php echo $reg[0]['rifempresa']; ?>" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						   <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Nombre de Empresa: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="nomempresa" id="nomempresa" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre de Empresa" value="<?php echo $reg[0]['nomempresa']; ?>" required="" aria-required="true">
                        <i class="fa fa-bank form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Dirección Empresa: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="direcempresa" id="direcempresa" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Dirección de Empresa" value="<?php echo $reg[0]['direcempresa']; ?>" required="" aria-required="true">
                        <i class="fa fa-map-marker form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Teléfono de Empresa: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="tlfempresa" id="tlfempresa" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Telefono de Empresa" value="<?php echo $reg[0]['tlfempresa']; ?>" required="" aria-required="true">
                        <i class="fa fa-phone form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Cédula Responsable: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="cedresponsable" id="cedresponsable" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cédula de Responsable" value="<?php echo $reg[0]['cedresponsable']; ?>" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Nombre Responsable: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="nomresponsable" id="nomresponsable" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre Completo de Responsable" value="<?php echo $reg[0]['nomresponsable']; ?>" required="" aria-required="true">
                        <i class="fa fa-user form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Correo Responsable: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="correoresponsable" id="correoresponsable" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Correo de Responsable" value="<?php echo $reg[0]['correoresponsable']; ?>" required="" aria-required="true">
                        <i class="fa fa-envelope-o form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Teléfono Responsable: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="tlfresponsable" id="tlfresponsable" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Telefono de Responsable" value="<?php echo $reg[0]['tlfresponsable']; ?>" required="" aria-required="true">
                        <i class="fa fa-phone form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Iva de Ventas: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control number" name="ivav" id="ivav" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Iva de Ventas" value="<?php echo $reg[0]['ivav']; ?>" required="" aria-required="true">
                        <i class="fa fa-usd form-control-feedback"></i>
                              </div>
                          </div>  
						  
						   <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Iva de Servicios: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control number" name="ivas" id="ivas" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Iva de Servicios" value="<?php echo $reg[0]['ivas']; ?>" required="" aria-required="true">
                        <i class="fa fa-usd form-control-feedback"></i>
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
          	</div><!-- /row -->
          	
          	
          	
          	
          
          		
          
          	
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