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
$reg = $tra->RegistrarVentas();
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
	<script type="text/javascript" src="assets/script/script2.js"></script>
	<!-- Autocompleto -->
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/autocompleto.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
	<script type="text/javascript" src="assets/script/script.js"></script>
	<script>
	$(document).ready(function(){
		$("#AgregaProductoVentas").click(function(){
		 	var code = $('input#codproducto').val();
		    var prod = $('input#productoventas').val();
			var prec = $('input#precio2').val();
			var cantp= $('input#cantidad').val();
			var exist= $('input#existencia').val();
			var tip = $('select#codcategoria').val();
			var ivgprod = $('input#ivaproducto').val();
			var er_num=/^([0-9])*[.]?[0-9]*$/;
			cantp    = parseInt(cantp);
			exist    = parseInt(exist);
			cantp    = cantp;
			
			if(code==""){
				$("#codproducto").focus();
				$("#codproducto").css('border-color','#2b4049');
				alert("Ingrese Codigo de Producto");
				return false;
			
			 } else if(prod==""){
				$("#producto").focus();
				$("#producto").css('border-color','#2b4049');
				alert("Ingrese Descripcion de Producto");
				return false;
				
			} else if(prec==""){
				$("#precio2").focus();
				$("#precio2").css('border-color','#2b4049');
				alert("Ingrese Precio de Venta de Producto");
				return false;			
			
			} else if($('#cantidad').val()==""){
				$("#cantidad").focus();
				$("#cantidad").css('border-color','#2b4049');
				alert("Ingrese Cantidad de Producto");
				return false;
				
			} else if (isNaN($('#cantidad').val())) {
				$("#cantidad").focus();
				$("#cantidad").css('border-color','#2b4049');
				alert("Ingrese solo Numeros en Cantidad");
				return false;
				
			}else if(cantp>exist){
				$("#cantidad").focus();
				$("#cantidad").css('border-color','#2b4049');
				alert("Actualmente existen " + exist + " Productos en Almacen y Usted Solicito " + cantp + " Productos de: " + prod);
				return false;
				
			} else {
			
				var Carrito = new Object();
				Carrito.Codigo      = $('input#codproducto').val();
				Carrito.Tipo    = $('input#codcategoria').val();
				Carrito.Cantidad    = $('input#cantidad').val();
				Carrito.Precio      = $('input#precio').val();
				Carrito.Precio2      = $('input#precio2').val();
				Carrito.Precioconiva = $('input#precioconiva').val();
				Carrito.Ivaproducto = $('input#ivaproducto').val();
				Carrito.Descripcion = $('input#productoventas').val();
				Carrito.Existencia  = $('input#existencia').val();
				var DatosJson = JSON.stringify(Carrito);
				$.post('carritoventas.php',
					{ 
						MiCarrito: DatosJson
					},
					function(data, textStatus) {
						$("#carrito tbody").html("");
						var SubtotalFact = 0;
						var BaseImpIva1 = 0;
						var contador = 0;
					    var iva      = 0;
					    var total    = 0;
					    var TotalCompra    = 0;
						
						 $.each(data, function(i, item) {
							var cantsincero =  item.cantidad;
							cantsincero     = parseInt(cantsincero);
							if(cantsincero!=0){
							contador   = contador + 1;
							    
								var OperacionCompra= parseFloat(item.precio);
								TotalCompra = parseFloat(TotalCompra) + parseFloat(OperacionCompra);
								
								var Operacion= parseFloat(item.precio2) * parseFloat(item.cantidad);
								var Subtotal = Operacion.toFixed(2);
								
								//CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
							    var Operacion3 = parseFloat(item.precioconiva) * parseFloat(item.cantidad);
						        var Subbaseimponiva = Operacion3.toFixed(2);
							
							    //BASE IMPONIBLE IVA CON PORCENTAJE
							    BaseImpIva1 = parseFloat(BaseImpIva1) + parseFloat(Subbaseimponiva);
								
								//CALCULO GENERAL DE IVA CON BASE IVA * IVA %
							    var ivg = $('input#iva').val();
						        ivg2  = ivg/100;
								TotalIvaGeneral = parseFloat(BaseImpIva1) * parseFloat(ivg2.toFixed(2));
								
							    //SUBTOTAL GENERAL DE FACTURA
						        SubtotalFact = parseFloat(SubtotalFact) + parseFloat(Subtotal);
							    //BASE IMPONIBLE IVA SIN PORCENTAJE
							    BaseImpIva2 = parseFloat(SubtotalFact) - parseFloat(BaseImpIva1);
								
							    //CALCULAMOS DESCUENTO POR PRODUCTO
							    var desc = $('input#descuento').val();
						        desc2  = desc/100;
								
							    //CALCULO DEL TOTAL DE FACTURA
			                    Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
								TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
								TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));	
							
								var nuevaFila =
									"<tr>"
									+"<td><div align='center'>"+item.txtCodigo+"<input type='hidden' value='"+item.existencia+"'></div></td>"
									+"<td><div align='center'>"+item.descripcion+"<input type='hidden' value='"+item.tipo+"'></div></td>"
									+"<td><div align='center'>"+item.precio2+"<input type='hidden' value='"+item.precioconiva+"'></div></td>"
									+"<td><div align='center'>"+item.cantidad+"<input type='hidden' value='"+item.precio+"'></div></td>"
									+"<td><div align='center'>"+item.ivaproducto+"<input type='hidden' value='"+OperacionCompra.toFixed(2)+"'></div></td>"
									+"<td><div align='center'>"+Operacion.toFixed(2)+"</div></td>"
									+"<td><div align='center'>"
									+'<img onclick="EliminarItem('
									+"'"+item.txtCodigo+"',"
									+"'-1',"
									+"'"+item.descripcion+"',"
									+"'"+item.existencia+"',"
									+"'"+item.precio+"',"
									+"'"+item.precio2+"',"
									+"'"+item.precioconiva+"',"
									+"'"+item.ivaproducto+"',"
									+"'"+item.tipo+"'"
									+ ')"' 
									+" src='assets/img/papelera.png' width='20'/></div></td>"
									+"</tr>";
									$(nuevaFila).appendTo("#carrito tbody");
									
							$("#lblsubtotal").text(BaseImpIva1.toFixed(2));
					        $("#lblsubtotal2").text(BaseImpIva2.toFixed(2));
					        $("#lbliva").text(TotalIvaGeneral.toFixed(2));
					        $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
					        $("#lbltotal").text(TotalFactura.toFixed(2));
							
					        $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
					        $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
					        $("#txtIva").val(TotalIvaGeneral.toFixed(2));
					        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
					        $("#txtTotal").val(TotalFactura.toFixed(2));
					        $("#txtTotalCompra").val(TotalCompra.toFixed(2));
							}
									
						  });
						
						
						LimpiarTexto();
					}, 
					"json"		
				);
				return false;
			}
		});
		
		$("#vaciarventas").click(function()
		{ 	
				var Carrito = new Object();
				Carrito.Codigo      = "vaciar";
				Carrito.Tipo    = "vaciar";
				Carrito.Cantidad    = "0";
				Carrito.Descripcion = "vaciar";
				Carrito.Existencia  = "0";
				Carrito.Precio      = "0";
				Carrito.Precio2      = "0";
				Carrito.Precioconiva      = "0";
				Carrito.Ivaproducto = "vaciar";
				var DatosJson = JSON.stringify(Carrito);
				$.post('carritoventas.php',
					{ 
						MiCarrito: DatosJson
					},
					function(data, textStatus) {
						$("#carrito tbody").html("");
						var nuevaFila =
					"<tr>"

					+"<td colspan=7><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"

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
		$("#codproducto").val("");
		$("#productoventas").val("");
		$("#precio").val("");
		$("#precio2").val("");
		$("#precioconiva").val("");
		$("#ivaproducto").val("");
		$("#codcategoria").val("");
		$("#cantidad").val("");
		$("#existencia").val("");
	}
	function EliminarItem(codigo,cantidad,descripcion,existencia,precio,precio2,precioconiva,ivaproducto,tipo){
				var Carrito = new Object();
				Carrito.Codigo      = codigo;
				Carrito.Precio      = precio;
				Carrito.Precio2      = precio2;
				Carrito.Precioconiva      = precioconiva;
				Carrito.Ivaproducto = ivaproducto;
				Carrito.Tipo    = tipo;
				Carrito.Cantidad    = cantidad;
				Carrito.Descripcion = descripcion;
				Carrito.Existencia  = existencia;

				var DatosJson = JSON.stringify(Carrito);
				$.post('carritoventas.php',
					{ 
						MiCarrito: DatosJson
					},
					function(data, textStatus) {
						$("#carrito tbody").html("");
						var SubtotalFact = 0;
						var BaseImpIva1 = 0;
						var contador = 0;
					    var iva      = 0;
					    var total    = 0;
					    var TotalCompra    = 0;
						
						 $.each(data, function(i, item) {
							var cantsincero =  item.cantidad;
							cantsincero     = parseInt(cantsincero);
							if(cantsincero!=0){
							contador   = contador + 1;
							
							    var OperacionCompra= parseFloat(item.precio);
								TotalCompra = parseFloat(TotalCompra) + parseFloat(OperacionCompra);
								
							    var Operacion= parseFloat(item.precio2) * parseFloat(item.cantidad);
								var Subtotal = Operacion.toFixed(2);
								
								//CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
							    var Operacion3 = parseFloat(item.precioconiva) * parseFloat(item.cantidad);
						        var Subbaseimponiva = Operacion3.toFixed(2);
							
							    //BASE IMPONIBLE IVA CON PORCENTAJE
							    BaseImpIva1 = parseFloat(BaseImpIva1) + parseFloat(Subbaseimponiva);
								
								//CALCULO GENERAL DE IVA CON BASE IVA * IVA %
							    var ivg = $('input#iva').val();
						        ivg2  = ivg/100;
								TotalIvaGeneral = parseFloat(BaseImpIva1) * parseFloat(ivg2.toFixed(2));
								
							    //SUBTOTAL GENERAL DE FACTURA
						        SubtotalFact = parseFloat(SubtotalFact) + parseFloat(Subtotal);
							    //BASE IMPONIBLE IVA SIN PORCENTAJE
							    BaseImpIva2 = parseFloat(SubtotalFact) - parseFloat(BaseImpIva1);
								
							    //CALCULAMOS DESCUENTO POR PRODUCTO
							    var desc = $('input#descuento').val();
						        desc2  = desc/100;
								
							    //CALCULO DEL TOTAL DE FACTURA
			                    Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
								TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
								TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));
								
								var nuevaFila =
									"<tr>"
									+"<td><div align='center'>"+item.txtCodigo+"<input type='hidden' value='"+item.existencia+"'></div></td>"
									+"<td><div align='center'>"+item.descripcion+"<input type='hidden' value='"+item.tipo+"'></div></td>"
									+"<td><div align='center'>"+item.precio2+"<input type='hidden' value='"+item.precioconiva+"'></div></td>"
									+"<td><div align='center'>"+item.cantidad+"<input type='hidden' value='"+item.precio+"'></div></td>"
									+"<td><div align='center'>"+item.ivaproducto+"<input type='hidden' value='"+OperacionCompra.toFixed(2)+"'></div></td>"
									+"<td><div align='center'>"+Operacion.toFixed(2)+"</div></td>"
									+"<td><div align='center'>"
									+'<img onclick="EliminarItem('
									+"'"+item.txtCodigo+"',"
									+"'-1',"
									+"'"+item.descripcion+"',"
									+"'"+item.existencia+"',"
									+"'"+item.precio+"',"
									+"'"+item.precio2+"',"
									+"'"+item.precioconiva+"',"
									+"'"+item.ivaproducto+"',"
									+"'"+item.tipo+"'"
									+ ')"' 
									+" src='assets/img/papelera.png' width='20'/></div></td>"
									+"</tr>";
									$(nuevaFila).appendTo("#carrito tbody");
									
							$("#lblsubtotal").text(BaseImpIva1.toFixed(2));
					        $("#lblsubtotal2").text(BaseImpIva2.toFixed(2));
					        $("#lbliva").text(TotalIvaGeneral.toFixed(2));
					        $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
					        $("#lbltotal").text(TotalFactura.toFixed(2));
							
					        $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
					        $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
					        $("#txtIva").val(TotalIvaGeneral.toFixed(2));
					        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
					        $("#txtTotal").val(TotalFactura.toFixed(2));
					        $("#txtTotalCompra").val(TotalCompra.toFixed(2));
							}
							
									
						  });
						if(contador==0){

					$("#carrito tbody").html("");

					var nuevaFila =

					"<tr>"

					+"<td colspan=7><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"

					+"</tr>";

					$(nuevaFila).appendTo("#carrito tbody");
					
					//alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
					$("#ventas")[0].reset();
					$("#lblsubtotal").text("0.00");
					$("#lblsubtotal2").text("0.00");
					$("#lbliva").text("0.00");
					$("#lbldescuento").text("0.00");
					$("#lbltotal").text("0.00");
					
					$("#txtsubtotal").val("0.00");
					$("#txtsubtotal2").val("0.00");
					$("#txtIva").val("0.00");
					$("#txtDescuento").val("0.00");
					$("#txtTotal").val("0.00");
					$("#txtTotalCompra").val("0.00");

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
				<form class="form-horizontal" method="post"  action="#" name="ventaclientes" id="ventaclientes">
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
		    <h3><i class="fa fa-tasks"></i> Módulo Registro de Ventas de Productos</h3><br>


              <div class="row">
                 
				  <form  method="post"  action="#" name="ventas" id="ventas">
				  <div class="col-lg-9">								  

					    <div class="row">
						<!-- TWITTER PANEL -->
						
				<div class="col-lg-12">
                           <div class="panel panel-border panel-warning widget-s-1">
<div class="panel-heading"><h4 class="mb"><i class="fa fa-archive"></i> <strong>Punto de Venta</strong> | <strong>Cajero:</strong> <?php echo $_SESSION['nombres']; ?> | <strong>Caja:</strong> #<?php echo $_SESSION['nrocaja']; ?></h4> </div>
                                    <div class="panel-body">

                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                     </div>
									<div class="row">	 
										 <div class="col-md-2"> 
                                                 <div class="form-group"> 
                                                         <label for="field-2" class="control-label">Código: <span class="symbol required"></span></label> 
<input class="form-control" type="hidden" name="existencia" id="existencia">
<input class="form-control" type="hidden" name="codcategoria" id="codcategoria">
<input class="form-control" type="hidden" name="precioconiva" id="precioconiva">
<input class="form-control" type="hidden" name="precio" id="precio"> 
<input class="form-control" type="hidden" name="ivaproducto" id="ivaproducto">  
<input class="form-control" type="text" name="codproducto" id="codproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Codigo" readonly="readonly"> 
                                                  </div> 
                                         </div>
										 
										 <div class="col-md-5"> 
                                                 <div class="form-group"> 
                                                         <label for="field-5" class="control-label">Búsqueda para Descripción de Producto: <span class="symbol required"></span></label> 
 <input class="form-control" type="text" name="productoventas" id="productoventas" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descripcion de Producto"><small><span class="symbol required"></span> Realice la búsqueda del Producto para Venta.<br>Tipo de Búsqueda: Código o Descripción de Producto</small> 
                                                  </div> 
                                         </div>
										 
										  <div class="col-md-3"> 
                                                 <div class="form-group"> 
                                                         <label for="field-3" class="control-label">Precio Venta: <span class="symbol required"></span></label> 
<input class="form-control" type="text" name="precio2" id="precio2" autocomplete="off" placeholder="Precio de Venta" readonly="readonly">                                                 
 </div> 
                                         </div>
										 
										 
										 <div class="col-md-2"> 
                                                 <div class="form-group"> 
                                                         <label for="field-2" class="control-label">Cantidad: <span class="symbol required"></span></label> 
<input class="form-control number" type="text" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad"> 
                                                  </div> 
                                         </div>
										 
									</div>
									
									
						  
<div align="right"><button type="button" id="AgregaProductoVentas" class="btn btn-primary"><span class="fa fa-shopping-cart"></span> Agregar Producto</button> 
<button type="button" id="vaciarventas" class="btn btn-danger" ><span class="fa fa-trash-o"></span> Vaciar Productos</button>
<a href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><button type="button" class="btn btn-success"><span class="fa fa-user"></span> Nuevo Cliente</button></a></div>
									<hr>	
										
										
										
										<div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered dt-responsive nowrap" id="carrito">
                                                        <thead>
                                                            <tr>
                                                            <th><div align="center">Código</div></th>
                                                            <th><div align="center">Descripción de Producto</div></th>
															<th><div align="center">Precio Unit.</div></th>
                                                            <th><div align="center">Cantidad</div></th>
                                                            <th><div align="center">Iva</div></th>
                                                            <th><div align="center">Importe</div></th>
															<th></th>
                                                        </tr></thead>
                                                        <tbody>
														<tr>
                                                       <td colspan=7><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>
                                                       </tr>
                                                        </tbody>
                                                  </table>
	<table width="302" id="carritototal">
                        <tr>
                          <td width="167"><span class="Estilo9">
                            <label>Subtotal Iva <?php echo $con[0]['ivav'] ?>%:</label></span></td>
                          <td width="123"><div align="right" class="Estilo9"><label id="lblsubtotal" name="lblsubtotal">0.00</label><input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/></div></td>
                        </tr>
                        <tr>
                          <td width="167"><span class="Estilo9">
                            <label>Subtotal Iva 0%:</label></span></td>
                          <td width="123"><div align="right" class="Estilo9"><label id="lblsubtotal2" name="lblsubtotal2">0.00</label><input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/></div></td>
                        </tr>
                        <tr>
        <td><span class="Estilo9"><label>Iva <?php echo $con[0]['ivav'] ?>%<input name="iva" id="iva" type="hidden" value="<?php echo $con[0]['ivav'] ?>"  /></label></span></td>
      <td><div align="right" class="Estilo9"><label id="lbliva" name="lbliva">0.00</label><input type="hidden" name="txtIva" id="txtIva" value="0.00"/></div></td>
                        </tr>
                        <tr>
      <td><span class="Estilo9"><label>Descuento:</label></span></td>
     <td><div align="right" class="Estilo9"><label id="lbldescuento" name="lbldescuento">0.00</label><input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/></div></td>
                        </tr>
                        <tr>
      <td><span class="Estilo9"><label>Total:</label></span></td>
     <td><div align="right" class="Estilo9"><label id="lbltotal" name="lbltotal">0.00</label><input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
	 <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/></div></td>
                        </tr>
                    </table>
                                                </div>
                                            </div>
                                        </div>
										
										
										
										  
                         
						  <div class="modal-footer"> 
                          <button class="btn btn-danger" type="reset"><span class="fa fa-times"></span> Cancelar</button> 
                          <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-save"></span> Registrar Ventas</button> 
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
                                                     <label for="field-12" class="control-label">Código de Venta:</label> 
          <input type="hidden" name="codcaja" id="codcaja" value="<?php echo $caja[0]['codcaja']; ?>">
		  <div id="nroventa"><input class="form-control" type="text" name="codventa" id="codventa" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Venta" value="<?php echo $reg = $tra->CodigoVentas(); ?>" readonly="readonly"></div> 
                    </div>  
                                        
                      <!-- First Action -->
                                      <div class="form-group"> 
                                                     <label for="field-12" class="control-label">N° de Serie:</label> 
          <div id="nroserieve"><input class="form-control" type="text" name="codserieve" id="codserieve" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Serie" value="<?php echo $reg = $tra->CodigoSerieVe(); ?>" readonly="readonly"></div> 
                    </div> 
                                        
                      <!-- First Action -->
                                      <div class="form-group"> 
                                                     <label for="field-12" class="control-label">N° de Autorización:</label> 
          <div id="nroautorizacionve"><input class="form-control" type="text" name="codautorizacionve" id="codautorizacionve" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Autorización" value="<?php echo $reg = $tra->CodigoAutorizacionVe(); ?>" readonly="readonly"></div> 
                    </div> 
					
                      <!-- Second Action --> 
                                      <div class="form-group"> 
                                                     <label for="field-12" class="control-label">Búsqueda de Clientes:</label> 
         <input class="form-control" type="hidden" name="codcliente" id="codcliente"><input class="form-control" type="text" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Búsqueda de Cliente" required="required"><small><span class="symbol required"></span> Búsqueda de Cliente: Cédula o Nombre</small>
                                     </div>
									 
					 <!-- Second Action -->
					 <div class="form-group">
					 
					 <div class="radio">Tipo de Pago: 
						  <label>
						    <input name="tipopagove" id="tipopagove" value="CONTADO" onClick="BuscaFormaVenta()" checked="checked" type="radio">
						    Contado
						  </label>&nbsp;&nbsp;
						  <label>
						    <input name="tipopagove" id="tipopagove" value="CREDITO" onClick="BuscaFormaVenta(); MuestraCambioPagos();" type="radio">
						    Crédito
						  </label>
						</div>
						
                      </div>
															 
									  <!-- Second Action --> 
      <div id="muestraformapagoventas"><div class="form-group"> 
                                                     <label for="field-12" class="control-label">Forma de Pago:</label> 
       <select name="formapagove" id="formapagove" class="form-control" onChange="MuestraCambioPagos()" required="required">
	       <option value="">SELECCIONE</option>
		   <option value="EFECTIVO">EFECTIVO</option>
		   <option value="CHEQUE">CHEQUE</option>
		   <option value="CHEQUE POSFECHADO">CHEQUE POSFECHADO</option>
		   <option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option>
		   <option value="TRANSFERENCIA">TRANSFERENCIA</option>
      </select>
                                     </div></div>
									 
			<div id="muestracambiospagos"></div>
				
				<!-- Second Action -->
			<div class="form-group">
					 
					 <div class="radio">
						  <label>
						    <input name="tiporeporte" id="tiporeporte" value="TICKET" checked="checked" type="radio">
						    Imprimir Ticket
						  </label>&nbsp;&nbsp;&nbsp;&nbsp;
						  <label>
						    <input name="tiporeporte" id="tiporeporte" value="FACTURA" type="radio">
						    Imprimir Factura
						  </label>
						</div>
						
                      </div>
							
                      <!-- Third Action -->
					   <div class="form-group">  
                                <label for="field-12" class="control-label">Descuento de Venta %:</label> 
<input class="form-control number calculodescuentove" type="text" name="descuento" id="descuento" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento de Venta" value="0" required="required"> 
                    </div>
					  
					  	 <!-- four Action -->
                                      <div class="form-group">  
                                                     <label for="field-12" class="control-label">Fecha de Venta:</label> 
<input class="form-control" type="text" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Venta" readonly="readonly"> 
                    </div>
							
                     <hr>		 
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