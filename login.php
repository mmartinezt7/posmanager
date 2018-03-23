<?php
require_once("class/class.php");
if(isset($_SESSION['usuario'])) { 
if ($_SESSION['usuario'] != "") {
$tra = new Login();

if(isset($_POST['btn-login']))
	{
	$log = $tra->Logueo();
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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body onLoad="getTime()">

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  	<div class="container">
	  	
	  		<div id="showtime"></div>
	  			<div class="col-lg-4 col-lg-offset-4">
	  				<div class="lock-screen">
		  			<h2><a data-toggle="modal" href="#myModal" data-backdrop="static" data-keyboard="false" title="Desbloquear Sesi�n"><i class="fa fa-lock"></i></a>
			&nbsp;&nbsp;&nbsp;<a href="logout" title="Cerrar Sesi�n"><i class="fa fa-power-off"></i></a></h2>
		  				<p>DESBLOQUEAR CUENTA / CERRAR SESI�N</p>
		  				
						  <!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/img/close.png"/></button>
						        <h4 class="modal-title" id="myModalLabel">Bienvenido <?php echo $_SESSION['nivel'] ?></h4>
						      </div>
						     <div class="modal-body">
					 <form  method="post" name="desbloquear" id="desbloquear" action="#"> 
                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                     </div>
                                              <p class="centered"><?php
	if (isset($_SESSION['cedula'])) {
	if (file_exists("fotos/".$_SESSION['cedula'].".jpg")){
    echo "<img src='fotos/".$_SESSION['cedula'].".jpg?' class='img-circle' width='80'>"; 
}else{
    echo "<img src='fotos/avatar.jpg' class='img-circle' width='80'>"; 
} } else {
	echo "<img src='fotos/avatar.jpg' class='img-circle' width='80'>"; 
}
?></p>
			<input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario'] ?>">
					
	<input type="password" placeholder="Ingrese su Password" name="password" id="password" class="form-control placeholder-no-fix" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" required="" aria-required="true">
						      <div class="modal-footer">
				 <button class="btn btn-theme btn-block" name="btn-login" id="btn-login" type="submit"><span class="fa fa-sign-in"></span> Acceder</button>
						      </div></form>
						      </div>
						    </div>
						  </div>
						</div>    
		  				
		  				
	  				</div><!--lock-screen -->
	  			</div><!-- /col-lg-4 -->
	  	
	  	</div><!-- /container -->

    <!-- js placed at the end of the document so the pages load faster 
    <script src="assets/js/jquery.js"></script>-->
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>

    <script>
        function getTime()
        {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            // add a zero in front of numbers<10
            m=checkTime(m);
            s=checkTime(s);
            document.getElementById('showtime').innerHTML=h+":"+m+":"+s;
            t=setTimeout(function(){getTime()},500);
        }

        function checkTime(i)
        {
            if (i<10)
            {
                i="0" + i;
            }
            return i;
        }
    </script>

  </body>
</html>
<?php } else { ?>	
		<script type='text/javascript' language='javascript'>
	    alert('USTED NO TIENE ACCESO A ESTA PARTE DE LA PAGINA, NO ERES EL ADMINISTRADOR')  
		document.location.href='panel.php'	 
        </script> 
<?php } } else { ?>
		<script type='text/javascript' language='javascript'>
	    alert('USTED NO TIENE ACCESO A ESTA PAGINA, DEBERA DE INICIAR SESION')  
		document.location.href='logout.php'	 
        </script> 
<?php } ?>