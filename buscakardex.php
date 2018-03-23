<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

$tra = new Login();
$ses = $tra->ExpiraSession();

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
	<!-- Autocompleto -->
	<link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
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
          	<h3><i class="fa fa-tasks"></i> Módulo Búsqueda de Kardex por Productos</h3><br>
          	
          	<!-- BASIC FORM ELELEMNTS -->
			
			<div class="row">
						    <div class="col-lg-12">
								   <form class="form-horizontal" method="post"  action="#" name="buscakardex" id="buscakardex">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading"><h4 class="mb"><i class="fa fa-edit"></i> Búsqueda de Kardex por Productos</h4> </div>
                                    <div class="panel-body">

                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                     </div>   
					<div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Búsqueda de Producto: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
								  <input type="hidden" class="form-control" name="codproducto" id="codproducto"><input class="form-control" type="text" name="producto" id="producto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descripción del Producto para tu busqueda" required="required">
                        <i class="fa fa-search form-control-feedback"></i>
                              </div>
                          </div>
						                           
						  <div class="modal-footer"> 
<button type="button" onClick="BuscaKardexProductos()" class="btn btn-primary"><span class="fa fa-search"></span> Realizar Búsqueda</button> 
                          </div>
                                  </div>
                                </div>	
						  
						<div id="muestrakardexproducto"></div>	
                      </form>
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
	<!-- Datatables-->
        <script src="assets/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/datatables/dataTables.bootstrap.js"></script>
        <script src="assets/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/datatables/buttons.bootstrap.min.js"></script>
        <script src="assets/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="assets/datatables/dataTables.keyTable.min.js"></script>
        <script src="assets/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/datatables/responsive.bootstrap.min.js"></script>
        <script src="assets/datatables/dataTables.scroller.min.js"></script>

        <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>

        <script src="assets/js/jquery.app.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
                $('#datatable-responsive').DataTable();
                $('#datatable-scroller').DataTable( { ajax: "assets/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
                var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
            } );
            TableManageButtons.init();
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