<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

$tra = new Login();
$ses = $tra->ExpiraSession();
$caja = $tra->CajerosSessionPorId();

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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body onLoad="muestraReloj()">
  
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/img/close.png"/></button>
						        <h4 class="modal-title" id="myModalLabel">Datos de Factura de Venta de Productos</h4>
						      </div>
						      <div class="modal-body">
                         <div id="muestraventasmodal"></div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Aceptar</button>
						      </div>
						    </div>
						  </div>
						</div> 
						
						
						<!-- Modal -->
						<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/img/close.png"/></button>
						        <h4 class="modal-title" id="myModalLabel">Datos de Facturas de Servicios</h4>
						      </div>
						      <div class="modal-body">
                         <div id="muestraserviciosmodal"></div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times"></span> Aceptar</button>
						      </div>
						    </div>
						  </div>
						</div>  
  
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
               	<h3><i class="fa fa-tasks"></i> Panel Principal de Ventas Diaria en Caja</h3><br>
	 
	  <?php if ($_SESSION['acceso'] == "administrador") { ?>
	  
          	
          	<!-- BASIC FORM ELELEMNTS -->
			
			<div class="row">
						    <div class="col-lg-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading"><h4><i class="fa fa-search"></i> Consulta General de Ventas Diaria en Caja<span class="pull-right"><a href="reportepdf?tipo=<?php echo base64_encode("VENTASDIARIASADMINISTRADOR") ?>" target="_blank" class="btn btn-primary"><span class="fa fa-print"></span> Imprimir Ventas del Dia</a>&nbsp;<a href="forventas" class="btn btn-info"><span class="fa fa-mail-forward"></span> Procesar Nueva Venta</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></h4> </div>
                                    <div class="panel-body">
						  
						    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                <th>N&deg;</th>
								<th>C&oacute;digo de Venta</th>
								<th>N&deg; de Caja</th>
								<th>Subtotal Con Iva</th>
								 <th>Subtotal Iva 0%</th>
								<th>Iva</th>
								<th>Desc</th>
								<th>Total Pago</th>
								<th>Articulos</th>
								<th>Fecha de Venta</th>
								<th>Acciones</th>
                              </tr>
                              </thead>
                              <tbody>
<?php 
$ve = new Login();
$reg = $ve->ListarVentasDiarias();
$totalarticulos=0;
$Subtotalconiva=0;
$Subtotalsiniva=0;
$Totaliva=0;
$Totaldescuento=0;
$pagoDescuento=0;
$Pagototal=0;
$PagototalCompras=0;
$a=1;

for($i=0;$i<sizeof($reg);$i++){
	
$totalarticulos+=$reg[$i]['articulos'];
$Subtotalconiva+=$reg[$i]['subtotalivasive'];
$Subtotalsiniva+=$reg[$i]['subtotalivanove'];
$Totaliva+=$reg[$i]['totalivave']; 
$Totaldescuento+=$reg[$i]['totaldescuentove']; 
$Pagototal+=$reg[$i]['totalpago'];
$PagototalCompras+=$reg[$i]['totalpago2'];

?>
                              <tr>
                                <td><div align="center"><?php echo $a++; ?></div></td>
                                <td><div align="center"><?php echo $reg[$i]['codventa']; ?></div></td>
                                <td><div align="center"><?php echo $reg[$i]['nrocaja']; ?></div></td>
								<td><div align="center"><?php echo number_format($reg[$i]['subtotalivasive'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($reg[$i]['subtotalivanove'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($reg[$i]['totalivave'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($reg[$i]['totaldescuentove'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></div></td>
							    <td><div align="center"><?php echo $reg[$i]['articulos']; ?></div></td>
								<td><div align="center"><?php echo $reg[$i]['fechaventa']; ?></div></td>
                                <td>
<a href="#" title="Ver Factura de Venta" onClick="VerVentas('<?php echo $reg[$i]['codventa'] ?>')" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-search-plus"></i></a>
								 
<a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKET") ?>" target="_black" class="btn btn-info btn-xs" title="Ticket de Venta" ><i class="fa fa-print"></i></a>

<a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("VENTAS") ?>" target="_black" class="btn btn-warning btn-xs" title="Factura de Venta" ><i class="fa fa-print"></i></a> 
								  </td>
                              </tr>
												<?php  }  ?>
                              </tbody>
                          </table>
					  <?php 
					  $UtilidadBruto= $Pagototal-$PagototalCompras;
					  $MargenBruto = ( $UtilidadBruto == '' ? "0.00" : number_format($UtilidadBruto/$PagototalCompras, 2, '.', ','));
					  	?>
						  <strong>Detalles de Ventas</strong><br>
						  <strong>Monto Subtotal : <?php echo number_format($Subtotalconiva, 2, '.', ','); ?></strong><br>
						  <strong>Monto Subtotal : <?php echo number_format($Subtotalsiniva, 2, '.', ','); ?></strong><br>
						  <strong>Monto Iva : <?php echo number_format($Totaliva, 2, '.', ','); ?></strong><br>
						  <strong>Monto Desc : <?php echo number_format($Totaldescuento, 2, '.', ','); ?></strong><br>
						  <strong>Total General : <?php echo number_format($Pagototal, 2, '.', ','); ?></strong><br>
						  <strong>Total Ganancias : <?php echo number_format($MargenBruto*100, 2, '.', ','); ?></strong>
                                  </div>
                                </div>
                            </div>
		    </div> 
			
			
			<hr>
			
			<!-- BASIC FORM ELELEMNTS -->
			
			<div class="row">
						    <div class="col-lg-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading"><h4><i class="fa fa-search"></i> Consulta General de Servicios Facturados en Caja<span class="pull-right"><a href="reportepdf?tipo=<?php echo base64_encode("SERVICIOSDIARIASADMINISTRADOR") ?>" target="_blank" class="btn btn-primary"><span class="fa fa-print"></span> Imprimir Servicios del Dia</a>&nbsp;<a href="forservicios" class="btn btn-info"><span class="fa fa-mail-forward"></span> Procesar Nuevo Servicio</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></h4> </div>
                                    <div class="panel-body">
								 
	    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                <th>N&deg;</th>
								<th>C&oacute;digo de Servicio</th>
								<th>N&deg; de Caja</th>
								<th>Subtotal</th>
								<th>Iva</th>
								<th>Descuento</th>
								<th>Total Pago</th>
								<th>Articulos</th>
								<th>Fecha de Servicio</th>
								<th>Acciones</th>
                              </tr>
                              </thead>
                              <tbody>
<?php 
$se = new Login();
$se = $se->ListarServiciosDiarias();
$pagoSubtotal=0;
$pagoIva=0;
$pagoDescuento=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($se);$i++){
$pagoSubtotal+=$se[$i]['subtotal']; 
$pagoIva+=$se[$i]['totaliva']; 
$pagoDescuento+=$se[$i]['totaldescuento'];  
$pagoTotal+=$se[$i]['totalpago']; 
?>
                              <tr>
                                <td><div align="center"><?php echo $a++; ?></div></td>
                                <td><div align="center"><?php echo $se[$i]['codservicio']; ?></div></td>
                                <td><div align="center"><?php echo $se[$i]['nrocaja']; ?></div></td>
								<td><div align="center"><?php echo number_format($se[$i]['subtotal'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($se[$i]['totaliva'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($se[$i]['totaldescuento'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($se[$i]['totalpago'], 2, '.', ','); ?></div></td>
							    <td><div align="center"><?php echo $se[$i]['cantidad']; ?></div></td>
								<td><div align="center"><?php echo $se[$i]['fechaservicio']; ?></div></td>
                                <td>
<a href="#" title="Ver Factura de Servicios" onClick="VerServicios('<?php echo $se[$i]['codservicio'] ?>')" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal2" data-backdrop="static" data-keyboard="false"><i class="fa fa-search-plus"></i></a>
								 
<a href="reportepdf.php?codventa=<?php echo base64_encode($se[$i]['codservicio']); ?>&tipo=<?php echo base64_encode("SERVICIOS") ?>" target="_black" class="btn btn-warning btn-xs" title="Factura de Venta" ><i class="fa fa-print"></i></a> 
								  </td>
                              </tr>
												<?php  }  ?>
                              </tbody>
                          </table>
						  
						  <strong>Detalles de Servicios</strong><br>
						  <strong>Monto Subtotal : <?php echo number_format($pagoSubtotal, 2, '.', ','); ?></strong><br>
						  <strong>Monto Iva : <?php echo number_format($pagoIva, 2, '.', ','); ?></strong><br>
						  <strong>Monto Desc : <?php echo number_format($pagoDescuento, 2, '.', ','); ?></strong><br>
						  <strong>Total General : <?php echo number_format($pagoTotal, 2, '.', ','); ?></strong>
                                  </div>
                                </div>
                            </div>
		    </div> 
	  
	  
	  <?php } else{ ?>
	  
	  
          	
          	<!-- BASIC FORM ELELEMNTS -->
			
			<div class="row">
						    <div class="col-lg-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading"><h4><i class="fa fa-search"></i> Consulta General de Ventas Diaria en Caja<span class="pull-right"><a href="reportepdf?caja=<?php echo base64_encode($caja[0]['nrocaja']) ?>&tipo=<?php echo base64_encode("VENTASDIARIASVENDEDOR") ?>" target="_blank" class="btn btn-primary"><span class="fa fa-print"></span> Imprimir Vestas del Dia</a>&nbsp;<a href="forventas" class="btn btn-info"><span class="fa fa-mail-forward"></span> Procesar Nueva Venta</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></h4> </div>
                                    <div class="panel-body">
								 
	     <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                <th>N&deg;</th>
								<th>C&oacute;digo de Venta</th>
								<th>N&deg; de Caja</th>
								<th>Subtotal Con Iva</th>
								 <th>Subtotal Iva 0%</th>
								<th>Iva</th>
								<th>Desc</th>
								<th>Total Pago</th>
								<th>Articulos</th>
								<th>Fecha de Venta</th>
								<th>Acciones</th>
                              </tr>
                              </thead>
                              <tbody>
<?php 
$ve = new Login();
$reg = $ve->ListarVentasDiarias();
$totalarticulos=0;
$Subtotalconiva=0;
$Subtotalsiniva=0;
$Totaliva=0;
$Totaldescuento=0;
$pagoDescuento=0;
$Pagototal=0;
$PagototalCompras=0;
$a=1;

for($i=0;$i<sizeof($reg);$i++){
	
$totalarticulos+=$reg[$i]['articulos'];
$Subtotalconiva+=$reg[$i]['subtotalivasive'];
$Subtotalsiniva+=$reg[$i]['subtotalivanove'];
$Totaliva+=$reg[$i]['totalivave']; 
$Totaldescuento+=$reg[$i]['totaldescuentove']; 
$Pagototal+=$reg[$i]['totalpago'];
$PagototalCompras+=$reg[$i]['totalpago2'];
?>
                              <tr>
                                <td><div align="center"><?php echo $a++; ?></div></td>
                                <td><div align="center"><?php echo $reg[$i]['codventa']; ?></div></td>
                                <td><div align="center"><?php echo $reg[$i]['nrocaja']; ?></div></td>
								<td><div align="center"><?php echo number_format($reg[$i]['subtotalivasive'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($reg[$i]['subtotalivanove'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($reg[$i]['totalivave'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($reg[$i]['totaldescuentove'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></div></td>
							    <td><div align="center"><?php echo $reg[$i]['articulos']; ?></div></td>
								<td><div align="center"><?php echo $reg[$i]['fechaventa']; ?></div></td>
                                <td>
<a href="#" title="Ver Factura de Venta" onClick="VerVentas('<?php echo $reg[$i]['codventa'] ?>')" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-search-plus"></i></a>
								 
<a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKET") ?>" target="_black" class="btn btn-info btn-xs" title="Ticket de Venta" ><i class="fa fa-print"></i></a>

<a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("VENTAS") ?>" target="_black" class="btn btn-warning btn-xs" title="Factura de Venta" ><i class="fa fa-print"></i></a> 
								  </td>
                              </tr>
												<?php  }  ?>
                              </tbody>
                          </table>
					  <?php 
					  $UtilidadBruto= $Pagototal-$PagototalCompras;
					  $MargenBruto = ( $UtilidadBruto == '' ? "0.00" : number_format($UtilidadBruto/$PagototalCompras, 2, '.', ','))
					  	?>
						  <strong>Detalles de Ventas</strong><br>
						  <strong>N° de Caja : <?php echo "<font color='red'>".$caja[0]['nrocaja']."</font color>"; ?></strong><br>
						  <strong>Monto Subtotal : <?php echo number_format($Subtotalconiva, 2, '.', ','); ?></strong><br>
						  <strong>Monto Subtotal : <?php echo number_format($Subtotalsiniva, 2, '.', ','); ?></strong><br>
						  <strong>Monto Iva : <?php echo number_format($Totaliva, 2, '.', ','); ?></strong><br>
						  <strong>Monto Desc : <?php echo number_format($Totaldescuento, 2, '.', ','); ?></strong><br>
						  <strong>Total General : <?php echo number_format($Pagototal, 2, '.', ','); ?></strong><br>
						  <strong>Total Ganancias : <?php echo number_format($MargenBruto*100, 2, '.', ','); ?></strong>
                                  </div>
                                </div>
                            </div>
		    </div> 
			
		     <hr>
			
			<!-- BASIC FORM ELELEMNTS -->
			
			<div class="row">
						    <div class="col-lg-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading"><h4><i class="fa fa-search"></i> Consulta General de Servicios Facturados en Caja<span class="pull-right"><a href="reportepdf?caja=<?php echo base64_encode($caja[0]['nrocaja']) ?>&tipo=<?php echo base64_encode("SERVICIOSDIARIASVENDEDOR") ?>" target="_blank" class="btn btn-primary"><span class="fa fa-print"></span> Imprimir Servicios del Dia</a>&nbsp;<a href="forservicios" class="btn btn-info"><span class="fa fa-mail-forward"></span> Procesar Nuevo Servicio</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></h4> </div>
                                    <div class="panel-body">
								 
	    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                <th>N&deg;</th>
								<th>C&oacute;digo de Servicio</th>
								<th>Subtotal</th>
								<th>Iva</th>
								<th>Descuento</th>
								<th>Total Pago</th>
								<th>Articulos</th>
								<th>Fecha de Servicio</th>
								<th>Acciones</th>
                              </tr>
                              </thead>
                              <tbody>
<?php 
$se = new Login();
$se = $se->ListarServiciosDiarias();
$pagoSubtotal=0;
$pagoIva=0;
$pagoDescuento=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($se);$i++){
$pagoSubtotal+=$se[$i]['subtotal']; 
$pagoIva+=$se[$i]['totaliva']; 
$pagoDescuento+=$se[$i]['totaldescuento'];  
$pagoTotal+=$se[$i]['totalpago']; 
?>
                              <tr>
                                <td><div align="center"><?php echo $a++; ?></div></td>
                                <td><div align="center"><?php echo $se[$i]['codservicio']; ?></div></td>
								<td><div align="center"><?php echo number_format($se[$i]['subtotal'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($se[$i]['totaliva'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($se[$i]['totaldescuento'], 2, '.', ','); ?></div></td>
								<td><div align="center"><?php echo number_format($se[$i]['totalpago'], 2, '.', ','); ?></div></td>
							    <td><div align="center"><?php echo $se[$i]['cantidad']; ?></div></td>
								<td><div align="center"><?php echo $se[$i]['fechaservicio']; ?></div></td>
                                <td>
<a href="#" title="Ver Factura de Servicios" onClick="VerServicios('<?php echo $se[$i]['codservicio'] ?>')" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal2" data-backdrop="static" data-keyboard="false"><i class="fa fa-search-plus"></i></a>
								 
<a href="reportepdf.php?codservicio=<?php echo base64_encode($se[$i]['codservicio']); ?>&tipo=<?php echo base64_encode("SERVICIOS") ?>" target="_black" class="btn btn-warning btn-xs" title="Factura de Venta" ><i class="fa fa-print"></i></a> 
								  </td>
                              </tr>
												<?php  }  ?>
                              </tbody>
                          </table>
						  
						  <strong>Detalles de Servicios</strong><br>
						  <strong>N° de Caja : <?php echo "<font color='red'>".$caja[0]['nrocaja']."</font color>"; ?></strong><br>
						  <strong>Monto Subtotal : <?php echo number_format($pagoSubtotal, 2, '.', ','); ?></strong><br>
						  <strong>Monto Iva : <?php echo number_format($pagoIva, 2, '.', ','); ?></strong><br>
						  <strong>Monto Desc : <?php echo number_format($pagoDescuento, 2, '.', ','); ?></strong><br>
						  <strong>Total Caja : <?php echo number_format($pagoTotal, 2, '.', ','); ?></strong>
                                  </div>
                                </div>
                            </div>
		    </div>
						 
          <?php } ?>	
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->
	  
	  

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              © <span class="current-year"></span>
              <a id="scroll-top" href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>              </a>          </div>
      </footer>
      <!--footer end-->
  </section>


    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
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