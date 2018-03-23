<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

$tra = new Login();
$ses = $tra->ExpiraSession();

$con = new Login();
$con = $con->ConfiguracionPorId();

if(isset($_POST['btn-submit']))
{
$reg = $tra->RegistrarCompras();
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
		$("#AgregaProductoCompras").click(function(){
		 	var code = $('input#codproducto').val();
		    var prod = $('input#producto').val();
			var prec = $('input#precio').val();
			var prec2 = $('input#precio2').val();
			var descuen = $('input#descuento').val();
			var vence = $('input#vence').val();
			var cantp= $('input#cantidad').val();
			var tip = $('select#codcategoria').val();
			var ivgprod = $('select#ivaproducto').val();
			var er_num=/^([0-9])*[.]?[0-9]*$/;
			cantp    = cantp;
			
			if(code==""){
				$("#codproducto").focus();
				$('#codproducto').css('border-color','#2b4049');
				alert("Ingrese Codigo de Producto");
				return false;
			
			 } else if(prod==""){
				$("#producto").focus();
				$('#producto').css('border-color','#2b4049');
				alert("Ingrese Descripcion de Producto");
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
				
			} else if(prec2==""){
				$("#precio2").focus();
				$('#precio2').css('border-color','#2b4049');
				alert("Ingrese Precio de Venta de Producto");
				return false;
			
			} else if(prec2=="0.00"){
				$("#precio2").focus();
				$('#precio2').css('border-color','#2b4049');
				$("#precio2").val("");
				alert("Ingrese un Precio de Venta valido");
				return false;
				
			} else if(!er_num.test($('#precio2').val())){
				$("#precio2").focus();
				$('#precio2').css('border-color','#2b4049');
				$("#precio2").val("");
				alert("Ingrese solo Numeros Positivos en Precio de Venta");
				return false;
				
			} else if(tip==""){
				$("#codcategoria").focus();
				$('#codcategoria').css('border-color','#2b4049');
				alert("Seleccione Tipo de Producto");
				return false;
				
			} else if(ivgprod==""){
				$("#ivaproducto").focus();
				$('#ivaproducto').css('border-color','#2b4049');
				alert("Seleccione Si tiene Iva el Producto");
				return false;
				
			} else if(descuen==""){
				$("#descuento").focus();
				$('#descuento').css('border-color','#2b4049');
				alert("Ingrese Descuento de Compra");
				return false;
				
			} else if(!er_num.test($('#descuento').val())){
				$("#descuento").focus();
				$('#descuento').css('border-color','#2b4049');
				$("#descuento").val("");
				alert("Ingrese solo Numeros Positivos en Descuento");
				return false;
				
			} else {
			
				var Carrito = new Object();
				Carrito.Codigo      = $('input#codproducto').val();
				Carrito.Tipo    = $('select#codcategoria').val();
				Carrito.Cantidad    = $('input#cantidad').val();
				Carrito.Precio      = $('input#precio').val();
				Carrito.Precio2      = $('input#precio2').val();
				Carrito.Ivaproducto = $('select#ivaproducto').val();
				Carrito.Precioconiva = $('input#precioconiva').val();
				Carrito.Vence      = $('input#vence').val();
				Carrito.Descripcion = $('input#producto').val();
				var DatosJson = JSON.stringify(Carrito);
				$.post('carritocompras.php',
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
						
						 $.each(data, function(i, item) {
							var cantsincero =  item.cantidad;
							cantsincero     = parseInt(cantsincero);
							if(cantsincero!=0){
							contador   = contador + 1;
							    								
								var Operacion= parseFloat(item.precio) * parseFloat(item.cantidad);
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
									+"<td><div align='center'>"+item.txtCodigo+"<input type='hidden' value='"+item.precio2+"'></div></td>"
									+"<td><div align='center'>"+item.descripcion+"<input type='hidden' value='"+item.precioconiva+"'></div></td>"
									+"<td><div align='center'>"+item.precio+"<input type='hidden' value='"+item.tipo+"'></div></td>"
									+"<td><div align='center'>"+item.cantidad+"<input type='hidden' value='"+item.vence+"'></div></td>"
									+"<td><div align='center'>"+item.ivaproducto+"</div></td>"
									+"<td><div align='center'>"+Operacion.toFixed(2)+"</div></td>"
									+"<td><div align='center'>"
									+'<img onclick="EliminarItem('
									+"'"+item.txtCodigo+"',"
									+"'-1',"
									+"'"+item.descripcion+"',"
									+"'"+item.ivaproducto+"',"
									+"'"+item.precioconiva+"',"
									+"'"+item.precio+"',"
									+"'"+item.tipo+"',"
									+"'"+item.precio2+"',"
									+"'"+item.vence+"'"
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
							}
									
						  });
						
						
						LimpiarTexto();
					}, 
					"json"		
				);
				return false;
			}
		});
		
		$("#vaciarcompras").click(function()
		{ 	
				var Carrito = new Object();
				Carrito.Codigo      = "vaciar";
				Carrito.Tipo    = "vaciar";
				Carrito.Cantidad    = "0";
				Carrito.Descripcion = "vaciar";
				Carrito.Ivaproducto = "vaciar";
				Carrito.Precioconiva      = "0";
				Carrito.Precio      = "0";
				Carrito.Precio2      = "0";
				Carrito.Vence      = "vaciar";
				var DatosJson = JSON.stringify(Carrito);
				$.post('carritocompras.php',
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
		$("#producto").val("");
		$("#precio").val("");
		$("#precioconiva").val("");
		$("#ivaproducto").val("");
		$("#precio2").val("");
		$("#vence").val("");
		$("#codcategoria").val("");
		$("#cantidad").val("");
	}
	function EliminarItem(codigo,cantidad,descripcion,ivaproducto,precioconiva,precio,tipo,precio2,vence){
				var Carrito = new Object();
				Carrito.Codigo      = codigo;
				Carrito.Ivaproducto = ivaproducto;
				Carrito.Precioconiva      = precioconiva;
				Carrito.Precio      = precio;
				Carrito.Tipo    = tipo;
				Carrito.Precio2      = precio2;
				Carrito.Vence    = vence;
				Carrito.Cantidad    = cantidad;
				Carrito.Descripcion = descripcion;

				var DatosJson = JSON.stringify(Carrito);
				$.post('carritocompras.php',
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
						
						 $.each(data, function(i, item) {
							var cantsincero =  item.cantidad;
							cantsincero     = parseInt(cantsincero);
							if(cantsincero!=0){
							contador   = contador + 1;
							
							    var Operacion= parseFloat(item.precio) * parseFloat(item.cantidad);
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
									+"<td><div align='center'>"+item.txtCodigo+"<input type='hidden' value='"+item.precio2+"'></div></td>"
									+"<td><div align='center'>"+item.descripcion+"<input type='hidden' value='"+item.precioconiva+"'></div></td>"
									+"<td><div align='center'>"+item.precio+"<input type='hidden' value='"+item.tipo+"'></div></td>"
									+"<td><div align='center'>"+item.cantidad+"<input type='hidden' value='"+item.vence+"'></div></td>"
									+"<td><div align='center'>"+item.ivaproducto+"</div></td>"
									+"<td><div align='center'>"+Operacion.toFixed(2)+"</div></td>"
									+"<td><div align='center'>"
									+'<img onclick="EliminarItem('
									+"'"+item.txtCodigo+"',"
									+"'-1',"
									+"'"+item.descripcion+"',"
									+"'"+item.ivaproducto+"',"
									+"'"+item.precioconiva+"',"
									+"'"+item.precio+"',"
									+"'"+item.tipo+"',"
									+"'"+item.precio2+"',"
									+"'"+item.vence+"'"
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
					$("#compras")[0].reset();
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

					}
						LimpiarTexto();
					}, 
					"json"		
				);
				return false;
	}
    </script>

</head>

  <body onLoad="getTime()">
  
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
		    <h3><i class="fa fa-tasks"></i> Módulo Registro de Compras de Productos</h3><br>


              <div class="row">
                 
				  <form  method="post"  action="#" name="compras" id="compras">
				  <div class="col-lg-9">								  

					    <div class="row">
						<!-- TWITTER PANEL -->
						
						
				<div class="col-lg-12">
                           <div class="panel panel-border panel-warning widget-s-1">
                                <div class="panel-heading"><h4 class="mb"><i class="fa fa-edit"></i> Formulario para Registro Compras de Productos</h4> </div>
                                    <div class="panel-body">

                                                  <div id="error">
                                                 <!-- error will be shown here ! -->
                                                     </div>
									<div class="row">	 
										 <div class="col-md-2"> 
                                                 <div class="form-group"> 
                                                         <label for="field-2" class="control-label">Código: <span class="symbol required"></span></label> 
<input class="form-control" type="text" name="codproducto" id="codproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Codigo"> 
                                                  </div> 
                                         </div>
										 
										 <div class="col-md-6"> 
                                                 <div class="form-group"> 
          <label for="field-6" class="control-label">Búsqueda para Descripción de Producto: <span class="symbol required"></span></label> 
 <input class="form-control" type="text" name="producto" id="producto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descripcion de Producto">
                                                  </div> 
                                         </div>
										 
										  <div class="col-md-4"> 
                                                 <div class="form-group"> 
                                                         <label for="field-4" class="control-label">Categoria: <span class="symbol required"></span></label> 
        <select name="codcategoria" id="codcategoria" class='form-control'>
												<option value="">SELECCIONE</option>
			<?php
			$cat = new Login();
			$cat = $cat->ListarCategorias();
			for($i=0;$i<sizeof($cat);$i++){
		              ?>
<option value="<?php echo $cat[$i]['codcategoria'] ?>"><?php echo $cat[$i]['nomcategoria'] ?></option>			  
                      <?php } ?>
							    </select>     
                                                  </div> 
                                         </div>
										 
									</div>
									
									<div class="row">
										 
										 <div class="col-md-4"> 
                                                 <div class="form-group"> 
                                                         <label for="field-4" class="control-label">Cantidad de Compra: <span class="symbol required"></span></label> 
<input class="form-control number" type="text" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad de Compra"> 
                                                  </div> 
                                         </div>
									
									 <div class="col-md-4"> 
                                             <div class="form-group"> 
                                                     <label for="field-4" class="control-label">Precio de Compra: <span class="symbol required"></span></label> 
<input class="form-control number" type="text" name="precio" id="precio" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Precio de Compra"> 
<input class="form-control" type="hidden" name="precioconiva" id="precioconiva" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" value="0.00">                                                   
</div> 
                                         </div>
										 
										 
									 <div class="col-md-4"> 
                                              <div class="form-group"> 
                                                      <label for="field-4" class="control-label">Precio de Venta: <span class="symbol required"></span></label> 
<input class="form-control number" type="text" name="precio2" id="precio2" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Precio de Venta">                                                 
 </div> 
                                         </div>
										 
							</div>
							
							<div class="row">	 
										
										 
										  <div class="col-md-4"> 
                                                 <div class="form-group"> 
                                                    <label for="field-4" class="control-label">Tiene Iva el Producto: <span class="symbol required"></span></label> 
        <select name="ivaproducto" id="ivaproducto" class='form-control'>
												<option value="">SELECCIONE</option>
												<option value="SI">SI</option>
												<option value="NO">NO</option>
							    </select>     
                                                  </div> 
                                         </div>
										 
										 <div class="col-md-4"> 
                                                 <div class="form-group"> 
                                                         <label for="field-4" class="control-label">Fecha de Vencimiento: </label> 
<input class="form-control calendario" type="text" name="vence" id="vence" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Vencimiento">                                                 
 </div> 
                                         </div>
																				 
									</div>
										 
						  
<div align="right"><button type="button" id="AgregaProductoCompras" class="btn btn-primary"><span class="fa fa-shopping-cart"></span> Agregar Producto</button> 
<button type="button" id="vaciarcompras" class="btn btn-danger" ><span class="fa fa-trash-o"></span> Vaciar Productos</button> </div>
									<hr>	
										
										
										
										<div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered dt-responsive nowrap" id="carrito">
                                                        <thead>
                                                            <tr>
                                                            <th><div align="center">Código</div></th>
                                                            <th><div align="center">Descripción de Producto</div></th>
															<th><div align="center">Precio</div></th>
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
                            <label>Subtotal Iva <?php echo $con[0]['ivac'] ?>%:</label></span></td>
                          <td width="123"><div align="right" class="Estilo9"><label id="lblsubtotal" name="lblsubtotal">0.00</label><input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/></div></td>
                        </tr>
                        <tr>
                          <td width="167"><span class="Estilo9">
                            <label>Subtotal Iva 0%:</label></span></td>
                          <td width="123"><div align="right" class="Estilo9"><label id="lblsubtotal2" name="lblsubtotal2">0.00</label><input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/></div></td>
                        </tr>
                        <tr>
        <td><span class="Estilo9"><label>Iva <?php echo $con[0]['ivac'] ?>%<input name="iva" id="iva" type="hidden" value="<?php echo $con[0]['ivac'] ?>"  /></label></span></td>
      <td><div align="right" class="Estilo9"><label id="lbliva" name="lbliva">0.00</label><input type="hidden" name="txtIva" id="txtIva" value="0.00"/></div></td>
                        </tr>
                        <tr>
      <td><span class="Estilo9"><label>Descuento:</label></span></td>
     <td><div align="right" class="Estilo9"><label id="lbldescuento" name="lbldescuento">0.00</label><input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/></div></td>
                        </tr>
                        <tr>
      <td><span class="Estilo9"><label>Total:</label></span></td>
     <td><div align="right" class="Estilo9"><label id="lbltotal" name="lbltotal">0.00</label><input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/></div></td>
                        </tr>
                    </table>
                                                </div>
                                            </div>
                                        </div>
										
										
										  
                     
						  <div class="modal-footer"> 
                          <button class="btn btn-danger" type="reset"><span class="fa fa-times"></span> Cancelar</button> 
                          <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-save"></span> Registrar Compras</button> 
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
                                                     <label for="field-12" class="control-label">N° de Compra:</label> 
          <div id="nrocompra"><input class="form-control" type="text" name="codcompra" id="codcompra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Compra" required="required"></div> 
                    </div> 
                                        
                      <!-- First Action -->
                                      <div class="form-group"> 
                                                     <label for="field-12" class="control-label">N° de Serie:</label> 
          <div id="nroseriec"><input class="form-control" type="text" name="codseriec" id="codseriec" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Serie" required="required"></div> 
                    </div> 
                                        
                      <!-- First Action -->
                                      <div class="form-group"> 
                                                     <label for="field-12" class="control-label">N° de Autorización:</label> 
          <div id="nroautorizacionc"><input class="form-control" type="text" name="codautorizacionc" id="codautorizacionc" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Autorización" required="required"></div> 
                    </div> 
                                        
                      <!-- First Action -->
                                      <div class="form-group"> 
                                                     <label for="field-12" class="control-label">N° de Lote:</label> 
          <div id="nrolote"><input class="form-control" type="text" name="lote" id="lote" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Lote" value="<?php echo $reg = $tra->CodigoLote(); ?>" readonly="readonly"></div> 
                    </div> 
					  
                      <!-- Second Action --> 
                                      <div class="form-group"> 
                                                     <label for="field-12" class="control-label">Proveedores:</label> 
           <select name="codproveedor" id="codproveedor" class='form-control' required="" aria-required="true">
												<option value="">SELECCIONE</option>
			<?php
			$prov = new Login();
			$prov = $prov->ListarProveedores();
			for($i=0;$i<sizeof($prov);$i++){
		              ?>
					  <option value="<?php echo $prov[$i]['codproveedor'] ?>"><?php echo $prov[$i]['nomproveedor'] ?></option>			  
                      <?php } ?> </select>  
                                     </div>
									 
					 <!-- Second Action -->
					 <div class="form-group">
					 
					 <div class="radio">Tipo de Pago: 
						  <label>
						    <input name="tipocompra" id="tipocompra" value="CONTADO" onClick="BuscaFormaPagosCompras()" checked="checked" type="radio">
						    Contado
						  </label>&nbsp;&nbsp;
						  <label>
						    <input name="tipocompra" id="tipocompra" value="CREDITO" onClick="BuscaFormaPagosCompras()" type="radio">
						    Crédito
						  </label>
						</div>
						
                      </div>  
					  
					  <!-- Second Action --> 
      <div id="muestraformapagocompras"><div class="form-group"> 
                                                     <label for="field-12" class="control-label">Forma de Pago:</label> 
       <select name="formacompra" id="formacompra" class="form-control" required="required">
	       <option value="">SELECCIONE</option>
		   <option value="EFECTIVO">EFECTIVO</option>
		   <option value="CHEQUE">CHEQUE</option>
		   <option value="CHEQUE POSFECHADO">CHEQUE POSFECHADO</option>
		   <option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option>
		   <option value="TRANSFERENCIA">TRANSFERENCIA</option>
      </select>
                                     </div></div>
							
                      <!-- Third Action -->
					   <div class="form-group">  
                                <label for="field-12" class="control-label">Descuento de Compra %:</label> 
<input class="form-control number calculodescuentoc" type="text" name="descuento" id="descuento" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento de Compra" value="0" required="required"> 
                    </div>
									 
					 <!-- four Action -->
                                      <div class="form-group">  
                                                     <label for="field-12" class="control-label">Fecha de Registro:</label> 
<input class="form-control" type="text" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Compra" readonly="readonly"> 
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
<script>
$('body').on('focus',".calendario", function(){
 $(this).datepicker({
 closeText: 'Cerrar',
 prevText: '<Anterior',
 nextText: 'Siguiente>',
 currentText: 'Hoy',
 monthNamesShort: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNames: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
 dayNamesShort: ['Dom','Lun','Mar','Mie','Juv','Vie','Sab'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
 weekHeader: 'Sm',
 dateFormat: 'dd-mm-yy',
 firstDay: 1,
 //maxDate: 0,
 changeMonth: true,
 changeYear: true,
 yearRange: '2017:2030'
 //yearRange: '1900:' + new Date().getFullYear()
 //yearRange: "1900:2017"
//showOn: 'button',
//buttonImage: 'jquery/images/calendar.gif',
//buttonImageOnly: true
});
});
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