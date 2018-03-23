<?php
require_once("class/class.php");
$tra = new Login();

if(isset($_POST['btn-login']))
{
	$log = $tra->Logueo();
	exit;
	
}
elseif(isset($_POST["btn-recuperar"]))
{
	$reg = $tra->RecuperarPassword();
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
	
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
		<form class="form-login" name="loginform" id="loginform" method="post" action="">

		        <h2 class="form-login-heading">Login de Acceso</h2>
		        <div class="login-wrap">
                    <div id="error">
              <!-- error will be shown here ! -->
		            </div>
		           
				    <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="Ingrese su Usuario" name="usuario" id="usuario" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" required="" aria-required="true">
                        <i class="fa fa-user form-control-feedback"></i>                  
					</div>
					
					<div class="form-group has-feedback">
              <input class="form-control" type="password" placeholder="Ingrese su Password" name="password" id="password" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" required="" aria-required="true">
                        <i class="fa fa-lock form-control-feedback"></i>                  
					</div>
				  
		           
		            <button class="btn btn-theme btn-block" name="btn-login" id="btn-login" type="submit"><i class="fa fa-sign-in"></i> Acceder</button>
		            <hr>
		            <div class="login-social-link centered">
		      <p><a data-toggle="modal" href="#myModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-lock m-r-5"></i> ¿ Olvidaste tu Password?</a></p>
		            </div>
		        </div>
		</form>
		
		
		        <!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/img/close.png"/></button>
						        <h4 class="modal-title" id="myModalLabel">Recuperar Password ?</h4>
						      </div>
						     <div class="modal-body">
		<form name="recuperarpassword" id="recuperarpassword" method="post" action="#">
                                                  <div id="errorr">
                                                 <!-- error will be shown here ! -->
                                                     </div>
                                              <p>Su nueva clave de Acceso será enviada al Correo Electrónico que ingrese.</p>
		                    
							 <div class="form-group has-feedback">
					 <input type="text" name="email" id="email" placeholder="Ingrese su Correo Electronico" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" required="" aria-required="true"  class="form-control placeholder-no-fix">
                        <i class="fa fa-envelope form-control-feedback"></i>                  
					        </div>
						      <div class="modal-footer">
		    <button class="btn btn-theme" name="btn-recuperar" id="btn-recuperar" type="submit"><span class="fa fa-check-square-o"></span> Recuperar Clave</button>
		                      </div></form>
						      </div>
						    </div>
						  </div>
						</div>   
				<!-- Modal -->
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster 
    <script src="assets/js/jquery.js"></script>-->
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>


  </body>
</html>
