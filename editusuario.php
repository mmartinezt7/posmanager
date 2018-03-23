<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador") {

$tra = new Login();
$ses = $tra->ExpiraSession();

$reg = $tra->UsuariosPorId();

if(isset($_POST['btn-update']))
{
$reg = $tra->ActualizarUsuarios();
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
	<script src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
	<script type="text/javascript" src="assets/script/script.js"></script>
		<script type="text/javascript">
    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i.test(value);
    }, "Ingrese solo letras para Nombre de Usuario");
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
          	<h3><i class="fa fa-tasks"></i> Módulo Actualización de Usuarios</h3><br>
          	
          	<!-- BASIC FORM ELELEMNTS -->
			
			<div class="row">
						    <div class="col-lg-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading"><h4 class="mb"><i class="fa fa-edit"></i> Formulario para Actualización de Usuarios</h4> </div>
                                    <div class="panel-body">
<form class="form-horizontal" name="updateusuario" id="updateusuario" method="post" data-id="<?php echo $reg[0]["codigo"] ?>" action="#" enctype="multipart/form-data" >
                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                     </div>   
						 <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Cédula de Usuario: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
			 <input type="hidden" name="codigo" id="codigo" value="<?php echo $reg[0]['codigo']; ?>">
             <input type="text" class="form-control" name="cedula" id="cedula" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cédula de Usuario" value="<?php echo $reg[0]['cedula']; ?>" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						   <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Nombre de Usuario: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="nombres" id="nombres" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre de Usuario" value="<?php echo $reg[0]['nombres']; ?>" required="" aria-required="true">
                        <i class="fa fa-user form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Sexo de Usuario: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <select name="sexo" id="sexo" class='form-control' required="" aria-required="true">
												<option value="">SELECCIONE</option>
	<option value="MASCULINO"<?php if (!(strcmp('MASCULINO', $reg[0]['sexo']))) {echo "selected=\"selected\"";} ?>>MASCULINO</option>
    <option value="FEMENINO"<?php if (!(strcmp('FEMENINO', $reg[0]['sexo']))) {echo "selected=\"selected\"";} ?>>FEMENINO</option>
										  </select> 
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Cargo de Usuario: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="cargo" id="cargo" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cargo de Usuario" value="<?php echo $reg[0]['cargo']; ?>" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Correo de Usuario: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="email" id="email" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Correo de Usuario" value="<?php echo $reg[0]['email']; ?>" required="" aria-required="true">
                        <i class="fa fa-envelope-o form-control-feedback"></i>
                              </div>
                          </div>
						  
						    <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Usuario de Acceso: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="usuario" id="usuario" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Usuario de Acceso" value="<?php echo $reg[0]['usuario']; ?>" required="" aria-required="true">
                        <i class="fa fa-user form-control-feedback"></i>
                              </div>
                          </div>
						  
						    <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Password de Acceso: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="password" id="password" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Password de Acceso" required="" aria-required="true">
                        <i class="fa fa-lock form-control-feedback"></i>
                              </div>
                          </div>
						  
						    <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Repita Password: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="password2" id="password2" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Password de Acceso" required="" aria-required="true">
                        <i class="fa fa-lock form-control-feedback"></i>
                              </div>
                          </div>
						  
						 <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Nivel de Acceso: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <select name="nivel" id="nivel" class='form-control' required="" aria-required="true">
												<option value="">SELECCIONE</option>
	<option value="ADMINISTRADOR"<?php if (!(strcmp('ADMINISTRADOR', $reg[0]['nivel']))) {echo "selected=\"selected\"";} ?>>ADMINISTRADOR(A)</option>
	<option value="VENDEDOR"<?php if (!(strcmp('VENDEDOR', $reg[0]['nivel']))) {echo "selected=\"selected\"";} ?>>VENDEDOR(A)</option>
										  </select> 
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Nivel de Acceso: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                  <select name="status" id="status" class='form-control' required="" aria-required="true">
												<option value="">SELECCIONE</option>
	<option value="ACTIVO"<?php if (!(strcmp('ACTIVO', $reg[0]['status']))) {echo "selected=\"selected\"";} ?>>ACTIVO</option>
				 <option value="INACTIVO"<?php if (!(strcmp('INACTIVO', $reg[0]['status']))) {echo "selected=\"selected\"";} ?>>INACTIVO</option>
										  </select> 
                              </div>
                          </div> 
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Foto de Usuario: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
<input type="file" class="file" size="10" data-original-title="Subir Fotografia" data-rel="tooltip" placeholder="Suba su Fotografia" name="imagen" id="imagen"/>
<small><p>Para Subir su Fotografia debe tener en cuenta lo siguiente:<br> * La Imagen debe ser extension.jpg<br> * La imagen no debe ser mayor de 50 KB</p></small> 
                              </div>
                          </div>                 
                         
						  <div class="modal-footer"> 
                          <button class="btn btn-danger" type="reset"><span class="fa fa-times"></span> Cancelar</button> 
                          <button type="submit" name="btn-update" id="btn-update" class="btn btn-primary"><span class="fa fa-edit"></span> Actualizar</button> 
						  <a href="usuarios" class="btn btn-success"><span class="fa fa-mail-reply "></span> Regresar</a>
                          </div>
                      </form>                                  </div>
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