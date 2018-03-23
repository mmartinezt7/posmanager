<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

$tra = new Login();
$ses = $tra->ExpiraSession();
$caja = $tra->VerificaCaja();

$con = new Login();
$con = $con->ConfiguracionPorId();

if(isset($_POST['btn-submit']))
{
$reg = $tra->RegistrarServicios();
exit;
}  
elseif(isset($_POST['btn-submit2']))
{
$reg = $tra->RegistrarClientes();
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
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script>
	<script type="text/javascript" src="assets/script/script2.js"></script>
	<!-- Autocompleto -->
	<link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/autocompleto.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
	<script type="text/javascript" src="assets/script/script.js"></script>
	<script type="text/javascript">
    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/i.test(value);
    }, "Ingrese solo letras para Nombre de Cliente");
  </script>
	<script type="text/javascript">
	$(document).ready(function() {
	$("#tlfcliente").mask("(9999) 999-9999");
	});
	</script>
	
    <script>
	$(document).ready(function(){
		$("#AgregaProductoServicios").click(function(){
		 	var code = $('input#coditems').val();
		    var prod = $('input#servicio').val();
			var prec = $('input#precio').val();
			var cantp= $('input#cantidad').val();
			var er_num=/^([0-9])*[.]?[0-9]*$/;
			cantp    = cantp;
			
			if(code==""){
				$("#coditems").focus();
				$('#coditems').css('border-color','#2b4049');
				alert("Ingrese Codigo de Servicio");
				return false;
			
			 } else if(prod==""){
				$("#servicio").focus();
				$('#servicio').css('border-color','#2b4049');
				alert("Ingrese Descripcion de Servicio");
				return false;
				
			} else if(prec==""){
				$("#precio").focus();
				$('#precio').css('border-color','#2b4049');
				alert("Ingrese Precio de Compra de Producto");
				return false;
			
			} else if(prec=="0.00"){
				$("#precio").focus();
				$('#precio').css('border-color','#2b4049');
				$("#precio").val("");
				alert("Ingrese un Precio de Compra valido");
				return false;
				
			} else if(!er_num.test($('#precio').val())){
				$("#precio").focus();
				$('#precio').css('border-color','#2b4049');
				$("#precio").val("");
				alert("Ingrese solo Numeros Positivos en Precio de Compra");
				return false;
			
			} else if(cantp==""){
				$("#cantidad").focus();
				$('#cantidad').css('border-color','#2b4049');
				alert("Ingrese Cantidad de Producto");
				return false;
				
			} else if (isNaN($('#cantidad').val())) {
				$("#cantidad").focus();
				$('#cantidad').css('border-color','#2b4049');
				alert("Ingrese solo Numeros en Cantidad");
				return false;
				
			} else {
			
				var Carrito = new Object();
				Carrito.Codigo      = $('input#coditems').val();
				Carrito.Cantidad    = $('input#cantidad').val();
				Carrito.Precio      = $('input#precio').val();
				Carrito.Descripcion = $('input#servicio').val();
				var DatosJson = JSON.stringify(Carrito);
				$.post('carritoservicios.php',
					{ 
						MiCarrito: DatosJson
					},
					function(data, textStatus) {
						$("#carrito tbody").html("");
						var Subtotal = 0;
						var contador = 0;
					    var totaliva      = 0;
						var totaldescuento     = 0;
					    var totalpago    = 0;
						
						 $.each(data, function(i, item) {
							var cantsincero =  item.cantidad;
							cantsincero     = parseInt(cantsincero);
							if(cantsincero!=0){
							contador   = contador + 1;
							    
								var Operacion= parseFloat(item.precio) * parseFloat(item.cantidad);
								Subtotal = parseFloat(Subtotal.toFixed(2)) + parseFloat(Operacion.toFixed(2));
								var ivg = $('input#iva').val();
						        var desc = $('input#descuento').val();
						        ivg2  = ivg/100;
						        descuent  = desc/100;
								totaliva      = parseFloat(Subtotal.toFixed(2)) * parseFloat(ivg2.toFixed(2));
							    total    = parseFloat(totaliva.toFixed(2)) + parseFloat(Subtotal.toFixed(2));
						        var totaldescuento   = parseFloat(total.toFixed(2)) * descuent;
								var totalpago   = parseFloat(total.toFixed(2)) - parseFloat(totaldescuento.toFixed(2));
							
								var nuevaFila =
									"<tr>"
									+"<td><div align='center'>"+item.txtCodigo+"</div></td>"
									+"<td><div align='center'>"+item.descripcion+"</div></td>"
									+"<td><div align='center'>"+item.precio+"</div></td>"
									+"<td><div align='center'>"+item.cantidad+"</div></td>"
									+"<td><div align='center'>"+Operacion.toFixed(2)+"</div></td>"
									+"<td><div align='center'>"
									+'<img onclick="EliminarItem('
									+"'"+item.txtCodigo+"',"
									+"'-1',"
									+"'"+item.descripcion+"',"
									+"'"+item.precio+"'"
									+ ')"' 
									+" src='assets/img/papelera.png' width='20'/></div></td>"
									+"</tr>";
									$(nuevaFila).appendTo("#carrito tbody");
									
							$("#lblsubtotal").text(Subtotal.toFixed(2));
							$("#lbliva").text(totaliva.toFixed(2));
							$("#lbldescuento").text(totaldescuento.toFixed(2));
							$("#lbltotal").text(totalpago.toFixed(2));
							$("#txtsubtotal").val(Subtotal.toFixed(2));
							$("#txtIva").val(totaliva.toFixed(2));
							$("#txtDescuento").val(totaldescuento.toFixed(2));
							$("#txtTotal").val(totalpago.toFixed(2));
							}
									
						  });
						
						
						LimpiarTexto();
					}, 
					"json"		
				);
				return false;
			}
		});
		
		$("#vaciarservicios").click(function()
		{ 	
				var Carrito = new Object();
				Carrito.Codigo      = "vaciar";
				Carrito.Cantidad    = "0";
				Carrito.Descripcion = "vaciar";
				Carrito.Precio      = "0";
				var DatosJson = JSON.stringify(Carrito);
				$.post('carritoservicios.php',
					{ 
						MiCarrito: DatosJson
					},
					function(data, textStatus) {
						$("#carrito tbody").html("");
						var nuevaFila =
					"<tr>"

					+"<td colspan=6><center><label>NO HAY SERVICIOS AGREGADOS</label></center></td>"

					+"</tr>";

					$(nuevaFila).appendTo("#carrito tbody");
						LimpiarTexto();
					}, 
					"json"		
				);
				return false;
		});
	});
	function LimpiarTexto(){
		$("#coditems").val("");
		$("#servicio").val("");
		$("#precio").val("");
		$("#cantidad").val("");
	}
	function EliminarItem(codigo,cantidad,descripcion,precio){
				var Carrito = new Object();
				Carrito.Codigo      = codigo;
				Carrito.Precio      = precio;
				Carrito.Cantidad    = cantidad;
				Carrito.Descripcion = descripcion;

				var DatosJson = JSON.stringify(Carrito);
				$.post('carritoservicios.php',
					{ 
						MiCarrito: DatosJson
					},
					function(data, textStatus) {
						$("#carrito tbody").html("");
						var Subtotal = 0;
						var contador = 0;
					    var totaliva      = 0;
						var totaldescuento     = 0;
					    var totalpago    = 0;
						
						 $.each(data, function(i, item) {
							var cantsincero =  item.cantidad;
							cantsincero     = parseInt(cantsincero);
							if(cantsincero!=0){
							contador   = contador + 1;
							
							    var Operacion= parseFloat(item.precio) * parseFloat(item.cantidad);
								Subtotal = parseFloat(Subtotal.toFixed(2)) + parseFloat(Operacion.toFixed(2));
								var ivg = $('input#iva').val();
						        var desc = $('input#descuento').val();
						        ivg2  = ivg/100;
						        descuent  = desc/100;
								totaliva      = parseFloat(Subtotal.toFixed(2)) * parseFloat(ivg2.toFixed(2));
							    total    = parseFloat(totaliva.toFixed(2)) + parseFloat(Subtotal.toFixed(2));
						        var totaldescuento   = parseFloat(total.toFixed(2)) * descuent;
								var totalpago   = parseFloat(total.toFixed(2)) - parseFloat(totaldescuento.toFixed(2));
								
								var nuevaFila =
									"<tr>"
									+"<td><div align='center'>"+item.txtCodigo+"</div></td>"
									+"<td><div align='center'>"+item.descripcion+"</div></td>"
									+"<td><div align='center'>"+item.precio+"</div></td>"
									+"<td><div align='center'>"+item.cantidad+"</div></td>"
									+"<td><div align='center'>"+Operacion.toFixed(2)+"</div></td>"
									+"<td><div align='center'>"
									+'<img onclick="EliminarItem('
									+"'"+item.txtCodigo+"',"
									+"'-1',"
									+"'"+item.descripcion+"',"
									+"'"+item.precio+"'"
									+ ')"' 
									+" src='assets/img/papelera.png' width='20'/></div></td>"
									+"</tr>";
									$(nuevaFila).appendTo("#carrito tbody");
									
							$("#lblsubtotal").text(Subtotal.toFixed(2));
							$("#lbliva").text(totaliva.toFixed(2));
							$("#lbldescuento").text(totaldescuento.toFixed(2));
							$("#lbltotal").text(totalpago.toFixed(2));
							$("#txtsubtotal").val(Subtotal.toFixed(2));
							$("#txtIva").val(totaliva.toFixed(2));
							$("#txtDescuento").val(totaldescuento.toFixed(2));
							$("#txtTotal").val(totalpago.toFixed(2));
							}
							
									
						  });
						if(contador==0){

					$("#carrito tbody").html("");

					var nuevaFila =

					"<tr>"

					+"<td colspan=6><center><label>NO HAY SERVICIOS AGREGADOS</label></center></td>"

					+"</tr>";

					$(nuevaFila).appendTo("#carrito tbody");
					
					$("#lblsubtotal").text(Subtotal.toFixed(2));
					$("#lbliva").text(totaliva.toFixed(2));
					$("#lbldescuento").text(totaldescuento.toFixed(2));
					$("#lbltotal").text(totalpago.toFixed(2));
					$("#txtsubtotal").val(Subtotal.toFixed(2));
					$("#txtIva").val(totaliva.toFixed(2));
					$("#txtDescuento").val(totaldescuento.toFixed(2));
					$("#txtTotal").val(totalpago.toFixed(2));

					}
						LimpiarTexto();
					}, 
					"json"		
				);
				return false;
	}
    </script>
	
            <style type="text/css">
<!--

.Estilo10 {font-size: 18px; color: #000000; }
-->
            </style>
</head>

  <body onLoad="getTime()">
  
  
  
  <!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/img/close.png"/></button>
						        <h4 class="modal-title" id="myModalLabel">Formulario para Registro de Clientes</h4>
						      </div>
						     <div class="modal-body">
				<form class="form-horizontal" method="post"  action="#" name="servicioclientes" id="servicioclientes">
                                                  <div id="errores">
                                                 <!-- error will be shown here ! -->
                                                     </div>   
						 <div class="form-group has-feedback">
                              <label class="col-sm-3 col-sm-3 control-label">Cédula Cliente: <span class="symbol required"></span></label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="cedcliente" id="cedcliente" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cédula de Cliente" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  <div class="form-group has-feedback">
                              <label class="col-sm-3 col-sm-3 control-label">Nombre Cliente: <span class="symbol required"></span></label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="nomcliente" id="nomcliente" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre de Cliente" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						   <div class="form-group has-feedback">
                              <label class="col-sm-3 col-sm-3 control-label">Dirección Cliente: <span class="symbol required"></span></label>
                              <div class="col-sm-9">
                                   <textarea name="direccliente" class="form-control" id="direccliente" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Dirección de Cliente" required="" aria-required="true"></textarea>
                        <i class="fa fa-map-marker form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-3 col-sm-3 control-label">Telefono Cliente: <span class="symbol required"></span></label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="tlfcliente" id="tlfcliente" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Telefono de Cliente">
                        <i class="fa fa-phone form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-3 col-sm-3 control-label">Correo Cliente: <span class="symbol required"></span></label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" name="emailcliente" id="emailcliente" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Correo de Cliente">
                        <i class="fa fa-envelope-o form-control-feedback"></i>
                              </div>
                          </div>
						  
						  
						      <div class="modal-footer">
      <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"><span class="fa fa-times"></span> Cerrar</button>
      <button type="submit" name="btn-submit2" id="btn-submit2" class="btn btn-primary"><span class="fa fa-save"></span> Registrar</button> 
						      </div></form>
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
		    <h3><i class="fa fa-tasks"></i> Módulo Registro de Facturas por Servicios</h3><br>


              <div class="row">
                 
				  <form  method="post"  action="#" name="servicios" id="servicios">
				  <div class="col-lg-9">								  

					    <div class="row">
						<!-- TWITTER PANEL -->
						
				<div class="col-lg-12">
                           <div class="panel panel-border panel-warning widget-s-1">
                                <div class="panel-heading"><h4 class="mb"><i class="fa fa-edit"></i> Formulario para Registro de Facturas por Servicios</h4> </div>
                                    <div class="panel-body">

                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                     </div>
									<div class="row">	 
										 <div class="col-md-2"> 
                                                 <div class="form-group"> 
                                                         <label for="field-2" class="control-label">Código: <span class="symbol required"></span></label> 
<input class="form-control" type="text" name="coditems" id="coditems" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Codigo" readonly="readonly"> 
                                                  </div> 
                                         </div>
										 
										<div class="col-md-5"> 
                                                 <div class="form-group"> 
                                                         <label for="field-5" class="control-label">Búsqueda para Descripción de Servicio: <span class="symbol required"></span></label> 
 <input class="form-control" type="text" name="servicio" id="servicio" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descripcion de Servicio"><small><span class="symbol required"></span> Realice la búsqueda del Servicio.<br>Tipo de Búsqueda: Código o Descripción de Servicio</small> 
                                                  </div> 
                                         </div>
										 
										  <div class="col-md-3"> 
                                                 <div class="form-group"> 
                                                         <label for="field-3" class="control-label">Costo de Servicio: <span class="symbol required"></span></label> 
<input class="form-control" type="text" name="precio" id="precio" autocomplete="off" placeholder="Costo de Servicio" readonly="readonly">                                                 
                                                </div> 
                                         </div>
										 
										  <div class="col-md-2"> 
                                                 <div class="form-group"> 
                                                         <label for="field-2" class="control-label">Cantidad: <span class="symbol required"></span></label> 
<input class="form-control cantidad" type="text" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad"> 
                                                  </div> 
                                         </div>
										 
										
									</div>
									
									
						  
<div align="right"><button type="button" id="AgregaProductoServicios" class="btn btn-primary"><span class="fa fa-shopping-cart"></span> Agregar</button> 
<button type="button" id="vaciarservicios" class="btn btn-danger"><span class="fa fa-trash-o"></span> Vaciar</button>
<a href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><button type="button" class="btn btn-success"><span class="fa fa-user"></span> Nuevo Cliente</button></a> </div>
									<hr>	
										
										
										
										<div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered dt-responsive nowrap" id="carrito">
                                                        <thead>
                                                            <tr>
                                                            <th><div align="center">Código</div></th>
                                                            <th><div align="center">Descripción Producto</div></th>
															<th><div align="center">Precio</div></th>
                                                            <th><div align="center">Cantidad</div></th>
                                                            <th><div align="center">Importe</div></th>
															<th></th>
                                                        </tr></thead>
                                                        <tbody>
														<tr>
                                                       <td colspan=6><center><label>NO HAY SERVICIOS AGREGADOS</label></center></td>
                                                       </tr>
                                                        </tbody>
                                                  </table>
                                                </div>
                                            </div>
                                        </div>
										
										
										
										  
                         
						  <div class="modal-footer"> 
                          <button class="btn btn-danger" type="reset"><span class="fa fa-times"></span> Cancelar</button> 
                          <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-save"></span> Registrar</button> 
                          </div>
						  
						  
						  
                                  </div>
                                </div>
                            </div>
						
						
						
					    </div><!-- /row -->
                  </div><!-- /col-lg-9 END SECTION MIDDLE -->
                  
                  
      <!-- **********************************************************************************************************************************************************
      RIGHT SIDEBAR CONTENT
      *********************************************************************************************************************************************************** -->                  
                  
                  <div class="col-lg-3 ds">
                    <!--COMPLETED ACTIONS DONUTS CHART-->
						<h3>DATOS DE FACTURA</h3>
                                        
                      <!-- First Action -->
                                      <div class="form-group"> 
                                                     <label for="field-12" class="control-label">Código de Factura:</label> 
          <input type="hidden" name="codcaja" id="codcaja" value="<?php echo $caja[0]['codcaja']; ?>">
		  <div id="codigoservicio"><input class="form-control" type="text" name="codservicio" id="codservicio" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Codigo de Servicio" value="<?php echo $reg = $tra->CodigoServicios(); ?>" readonly="readonly"></div> 
                    </div> 
					
					 <!-- First Action -->
                                      <div class="form-group"> 
                                                     <label for="field-12" class="control-label">Nombre del Cajero/a:</label> 
		  <input class="form-control" type="text" name="nombres" id="nombres" value="<?php echo $_SESSION["nombres"]; ?>" readonly="readonly"> 
                    </div> 
					  
                      <!-- Second Action --> 
                                      <div class="form-group"> 
                                                     <label for="field-12" class="control-label">Búsqueda de Clientes:</label> 
         <input class="form-control" type="hidden" name="codcliente" id="codcliente"><input class="form-control" type="text" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Búsqueda de Cliente" required="required"><small><span class="symbol required"></span> Búsqueda de Cliente: Cédula o Nombre</small>
                                     </div>
									 
					 <!-- Second Action --> 
                                      <div class="form-group"> 
                                                     <label for="field-12" class="control-label">Tipo de Pago:</label> 
        <select name="tipopago" id="tipopago" class="form-control" required="required">
	       <option value="">SELECCIONE</option>
		   <option value="CHEQUE">PAGO CON CHEQUE</option>
		   <option value="EFECTIVO">PAGO CON EFECTIVO</option>
		   <option value="PUNTO DE VENTA">PUNTO DE VENTA</option>
		   <option value="TRANSFERENCIA">PAGO CON TRANSFERENCIA</option>
      </select>
                                     </div>
									 
					 <!-- Third Action -->
					   <div class="form-group">  
                                <label for="field-12" class="control-label">Descuento de Servicio %:</label> 
<input class="form-control number calculodescuentove" type="text" name="descuento" id="descuento" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento de Venta" value="0" required="required"> 
                    </div>
					
					<!-- four Action -->
                                      <div class="form-group">  
                                                     <label for="field-12" class="control-label">Fecha de Servicio:</label> 
<input class="form-control" type="text" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Venta" readonly="readonly"> 
                    </div>
							
                     <hr>		 
                      <table width="235">
                        <tr>
                          <td width="112"><span class="Estilo10"><strong>Subtotal:</strong></span></td>
                          <td width="118"><div align="right" class="Estilo10"><strong>$ </strong><label id="lblsubtotal" name="lblsubtotal"><strong>0.00</strong></label><input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/></div></td>
                        </tr>
                        <tr>
        <td><span class="Estilo10"><strong>Iva <?php echo $con[0]['ivas'] ?>%:</strong></span></td>
      <td><div align="right" class="Estilo10"><strong>$ </strong><label id="lbliva" name="lbliva"><strong>0.00</strong></label><input type="hidden" name="iva" id="iva" value="<?php echo $con[0]['ivas'] ?>"><input type="hidden" name="txtIva" id="txtIva" value="0.00"/></div></td>
                        </tr>
                        <tr>
      <td><span class="Estilo10"><strong>Total Pago:</strong></span></td>
     <td><div align="right" class="Estilo10"><strong>$ </strong><label id="lbltotal" name="lbltotal"><strong>0.00</strong></label><input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/></div></td>
                        </tr>
                    </table>
                      <br>
                      
                  </div><!-- /col-lg-3 --></form>
              </div><! --/row -->
          </section>

      </section>

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