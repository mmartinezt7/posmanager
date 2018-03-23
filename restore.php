<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador") {

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
	<!-- DataTables -->
    <link href="assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">
	
	<script src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function()
		{
		$(".validacion").validate();
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
          	<h3><i class="fa fa-tasks"></i> Módulo Restauración de Base de Datos</h3><br>
          	
          	<!-- BASIC FORM ELELEMNTS -->
			
			<div class="row">
						    <div class="col-lg-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading"><h4 class="mb"><i class="fa fa-edit"></i> Formulario para Restaurar Base de Datos</h4> </div>
                                    <div class="panel-body">
								   
	   <?php
error_reporting(E_ALL - E_NOTICE);
ini_set('upload_max_filesize', '80M');
ini_set('post_max_size', '80M');
ini_set('memory_limit', '-1'); //evita el error Fatal error: Allowed memory size of X bytes exhausted (tried to allocate Y bytes)...
ini_set('max_execution_time', 300); // es lo mismo que set_time_limit(300) ;
ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);
//En MYSQL archivo "my.ini" ==> max_allowed_packet = 22M
//"SET GLOBAL max_allowed_packet = 22M;"
//"SET GLOBAL connect_timeout = 20;"
//"SET GLOBAL net_read_timeout=50;"
//esto no se si solo es modificable en php.ini
ini_set('file_uploads','On'); 
ini_set('upload_tmp_dir','upload');

function run_split_sql($uploadfile, $host, $usuario,$passwd){
    $strSQLs = file_get_contents($uploadfile);
    unlink($uploadfile);
    //  Elimina lineas vacias o que empiezan por -- #   //   o entre /* y */
    // Elimna los espacios en blanco entre ; y \r\n
    // handle DOS and Mac encoded linebreaks
                    $strSQLs=preg_replace("/\r\n$/","\n",$strSQLs);
                    $strSQLs=preg_replace("/\r$/","\n",$strSQLs);
    $strSQLs = trim(preg_replace('/ {2,}/', ' ', $strSQLs));    // ----- remove multiple spaces ----- 
    $strSQLs = str_replace("\r","",$strSQLs);                     //los \r\n los dejamos solo en \n
    $lines=explode("\n",$strSQLs);
    $strSQLs = array();
    $in_comment = false;
    foreach ($lines as $key => $line){
        $line=trim($line); //preg_replace("#.*/#","",$line)
        $ignoralinea=(( "#" == $line[0] ) || ("--" == substr($line,0,2)) || (!$line) || ($line==""));
        if (!$ignoralinea){
            //Eliminar comentarios que empiezan por /* y terminan por */    
            if( preg_match("/^\/\*/", ($line)) )       $in_comment = true;
            if( !$in_comment )     $strSQLs[] = $line ;
            if( preg_match("/\*\//", ($line)) )      $in_comment = false;
        }
    }
    unset($lines);
    // Particionar en sentencias
    $IncludeDelimiter=false;
    $delimiter=";";
    $delimiterLen= 1;
    $sql="";
    // CONEXION 
    $conexion = new mysqli('localhost','root','','ventas',3306) or die ("No se puede conectar con el servidor MySQL: %s\n". $conexion->connect_error);
	
    $NumLin=0;
    foreach ($strSQLs as $key => $line){
        
        if ("DELIMITER" == substr($line,0,9)){  //empieza por DELIMITER
            $D=explode(" ",$line);
            $delimiter= $D[1];
            $delimiterLen= strlen($delimiter);
            $sql=($IncludeDelimiter)? $line ."\n" : "";
        }elseif (substr($line,-1*$delimiterLen) == $delimiter) { //hemos alcanzado el  Delimiter
                if (($NumLinea++ % 100)==0) {// ver con que base de datos estamos para poder reconectar caso de error
                        $respuesta = $conexion->query("select database() as db");
                        $row = $respuesta->fetch_array(MYSQLI_NUM);
                        $db=$row[0];
                }
                $sql .= ($IncludeDelimiter)? $line : substr($line,0,-1*$delimiterLen);
                $respuesta = $conexion->query($sql);
                if ($respuesta) echo "";
				
                    else {
     echo "";
                        if (!$conexion->ping() ){ 
							
							$conexion = new mysqli('localhost','root','','ventas',3306) or die ("No se puede conectar con el servidor MySQL: %s\n". $conexion->connect_error);
                            $respuesta = $conexion->query($sql);
                            if ($respuesta) echo "<br>$NumLinea REEJECUTADO:  ". str_replace("\n"," ",substr($sql,0,130))."...";
                                else echo "<br><b><u>$NumLinea REPITE-E R R O R: ".$conexion->errno." :</u></b>". $conexion->error ." ====> ". substr($sql,0,1022)."...";
                        }
                    }    
                        
                $sql="";
        } else { 
                $sql .= $line ."\n";
        }
    }
    $conexion->close();    
}

if (isset($_POST['upload'])) {
    $uploadfile = "./" . basename($_FILES['userfile']['name']);
    print '';
    switch ($_FILES['userfile']['error']){
        case 0:
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		
		echo"<br><div align='center' class='alert alert-success'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='icon-ok-sign'></span> LA COPIA DE SEGURIDAD <b> $uploadfile </b> SE HA RESTAURADO CORRECTAMENTE </div>";
		
	   // echo" LA COPIA DE SEGURIDAD <b> $uploadfile </b> SE HA RESTAURADO CORRECTAMENTE</div>";
                    run_split_sql($uploadfile, $host, $usuario,$passwd );
             } else     echo "<br>¡Posible error en carga de archivos!";
            break;
        case 1: // UPLOAD_ERR_INI_SIZE
            echo "<br>El archivo sobrepasa el limite autorizado por el servidor(archivo php.ini) !";
            break;
        case 2: // UPLOAD_ERR_FORM_SIZE
            echo "<br>El archivo sobrepasa el limite autorizado en el formulario HTML !";
            break;
        case 3: // UPLOAD_ERR_PARTIAL
            echo "<br>El envio del archivo ha sido suspendido durante la transferencia!";
            break;
        case 4: // UPLOAD_ERR_NO_FILE
			echo "<br><font color='red'> Por Favor seleccione el backup de la base de datos para restaurar !</font>";
            break;
        default: 
            echo "<br>ERROR DESCONOCIDO !"; 
            break;
    }
    print "";
    unset($_POST['upload']);
    $_POST[]=array();
}
?>
 <FORM action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" class='form-horizontal style-form form-validate validacion' enctype="multipart/form-data">

    <INPUT type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAXFILESIZE; ?>">
	
                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                     </div>   
						 <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Buscar Copia: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
                                 <input type="file" class="span6 m-wrap" size="10" data-original-title="Subir Archivo" data-rel="tooltip" title="Por favor realice la búsqueda del archivo a restaurar" placeholder="Suba su Backup" name="userfile" id="userfile" required="required"/>
                       <small>Realice la búsqueda del backup para restaurar la base de datos.</small> 
                              </div>
                          </div>   
                         
						  <div class="modal-footer"> 
                          <button class="btn btn-danger" type="reset"><span class="fa fa-times"></span> Cancelar</button> 
                <button type="submit" name="upload" id="upload" class="btn btn-primary"><span class="fa fa-cloud-upload"></span> Restaurar</button> 
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
	    alert('USTED NO TIENE ACCESO A ESTA PARTE DE LA PAGINA, NO ERES EL ADMINISTRADOR')  
		document.location.href='logout.php'	 
        </script> 
<?php } } else { ?>
		<script type='text/javascript' language='javascript'>
	    alert('USTED NO TIENE ACCESO A ESTA PAGINA, DEBERA DE INICIAR SESION')  
		document.location.href='logout.php'	 
        </script> 
<?php } ?>