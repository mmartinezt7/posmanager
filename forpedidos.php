<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador") {

$tra = new Login();
$ses = $tra->ExpiraSession();

if(isset($_POST['btn-submit']))
{
$reg = $tra->RegistrarPedidos();
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
		$("#AgregaProductoPedido").click(function(){
		 	var code = $('input#codproducto').val();
		    var prod = $('input#producto').val();
			var cantp= $('input#cantidad').val();
			var tip = $('select#codcategoria').val();
			//cantp    = parseInt(cantp);
			
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
				
			} else if(tip==""){
				$("#codcategoria").focus();
				$('#codcategoria').css('border-color','#2b4049');
				alert("Seleccione Tipo de Producto");
				return false;
				
			} else {
			
				var Carrito = new Object();
				Carrito.Codigo      = $('input#codproducto').val();
				Carrito.Tipo    = $('select#codcategoria').val();
				Carrito.Cantidad    = $('input#cantidad').val();
				Carrito.Descripcion = $('input#producto').val();
				var DatosJson = JSON.stringify(Carrito);
				$.post('carritopedidos.php',
					{ 
						MiCarrito: DatosJson
					},
					function(data, textStatus) {
						$("#carrito tbody").html("");
						var Subtotal = 0;
						var contador = 0;
						
						 $.each(data, function(i, item) {
							var cantsincero =  item.cantidad;
							cantsincero     = parseInt(cantsincero);
							if(cantsincero!=0){
							contador   = contador + 1;
								var nuevaFila =
									"<tr>"
									+"<td><div align='center'>"+item.txtCodigo+"</div></td>"
									+"<td><div align='center'>"+item.descripcion+"</div></td>"
									+"<td><div align='center'>"+item.tipo+"</div></td>"
									+"<td><div align='center'>"+item.cantidad+"</div></td>"
									+"<td><div align='center'>"
									+'<img onclick="EliminarItem('
									+"'"+item.txtCodigo+"',"
									+"'-1',"
									+"'"+item.descripcion+"',"
									+"'"+item.tipo+"'"
									+ ')"' 
									+" src='assets/img/papelera.png' width='20'/></div></td>"
									+"</tr>";
									$(nuevaFila).appendTo("#carrito tbody");
							}
									
						  });
						
						
						LimpiarTexto();
					}, 
					"json"		
				);
				return false;
			}
		});
		$("#vaciarpedidos").click(function()
		{ 	
				var Carrito = new Object();
				Carrito.Codigo      = "vaciar";
				Carrito.Tipo    = "vaciar";
				Carrito.Cantidad    = "0";
				Carrito.Descripcion = "vaciar";
				var DatosJson = JSON.stringify(Carrito);
				$.post('carritopedidos.php',
					{ 
						MiCarrito: DatosJson
					},
					function(data, textStatus) {
						$("#carrito tbody").html("");
						var nuevaFila =
					"<tr>"

					+"<td colspan=5><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"

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
		$("#codcategoria").val("");
		$("#cantidad").val("");
		//$("#codproducto").focus();
	}
	function EliminarItem(codigo,cantidad,descripcion,tipo){
				var Carrito = new Object();
				Carrito.Codigo      = codigo;
				Carrito.Tipo    = tipo;
				Carrito.Cantidad    = cantidad;
				Carrito.Descripcion = descripcion;

				var DatosJson = JSON.stringify(Carrito);
				$.post('carritopedidos.php',
					{ 
						MiCarrito: DatosJson
					},
					function(data, textStatus) {
						$("#carrito tbody").html("");
						var contador = 0;
						
						 $.each(data, function(i, item) {
							var cantsincero =  item.cantidad;
							cantsincero     = parseInt(cantsincero);
							if(cantsincero!=0){
							contador   = contador + 1;
								var nuevaFila =
									"<tr>"
									+"<td><div align='center'>"+item.txtCodigo+"</div></td>"
									+"<td><div align='center'>"+item.descripcion+"</div></td>"
									+"<td><div align='center'>"+item.tipo+"</div></td>"
									+"<td><div align='center'>"+item.cantidad+"</div></td>"
									+"<td><div align='center'>"
									+'<img onclick="EliminarItem('
									+"'"+item.txtCodigo+"',"
									+"'-1',"
									+"'"+item.descripcion+"',"
									+"'"+item.tipo+"'"
									+ ')"' 
									+" src='assets/img/papelera.png' width='20'/></div></td>"
									+"</tr>";
									$(nuevaFila).appendTo("#carrito tbody");
							}
							
									
						  });
						if(contador==0){

					$("#carrito tbody").html("");

					var nuevaFila =

					"<tr>"

					+"<td colspan=5><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"

					+"</tr>";

					$(nuevaFila).appendTo("#carrito tbody");

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
		    <h3><i class="fa fa-tasks"></i> Módulo Registro de Pedidos de Productos</h3><br>


              <div class="row">
                 
				  <form  method="post"  action="#" name="pedidos" id="pedidos">
				  <div class="col-lg-9">								  

					    <div class="row">
						<!-- TWITTER PANEL -->
						
						
						
						
				<div class="col-lg-12">
                           <div class="panel panel-border panel-warning widget-s-1">
                                <div class="panel-heading"><h4 class="mb"><i class="fa fa-edit"></i> Formulario para Registro de Pedidos de Productos</h4> </div>
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
										 
										  <div class="col-md-5"> 
                                                 <div class="form-group"> 
                                                         <label for="field-5" class="control-label">Búsqueda para Descripción de Producto: <span class="symbol required"></span></label> 
 <input class="form-control" type="text" name="producto" id="producto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descripcion de Producto"><small><span class="symbol required"></span> Realice la búsqueda del Producto para Venta.<br>Tipo de Búsqueda: Código o Descripción de Producto</small> 
                                                  </div> 
                                         </div>
										 
										  <div class="col-md-3"> 
                                                 <div class="form-group"> 
                                                         <label for="field-3" class="control-label">Categoria: <span class="symbol required"></span></label> 
        <select name="codcategoria" id="codcategoria" class='form-control'>
												<option value="">SELECCIONE</option>
			<?php
			$cat = new Login();
			$cat = $cat->ListarCategorias();
			for($i=0;$i<sizeof($cat);$i++){
		              ?>
<option value="<?php echo $cat[$i]['codcategoria'] ?>"><?php echo $cat[$i]['codcategoria'] ." - ".$cat[$i]['nomcategoria'] ?></option>			  
                      <?php } ?>
							    </select>     
                                                  </div> 
                                         </div>
										 
										 <div class="col-md-2"> 
                                                 <div class="form-group"> 
                                                         <label for="field-2" class="control-label">Cantidad: <span class="symbol required"></span></label> 
<input class="form-control cantidad" type="text" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad"> 
                                                  </div> 
                                         </div>
										 
									</div>
										 
						  
<div align="right"><button type="button" id="AgregaProductoPedido" class="btn btn-primary"><span class="fa fa-shopping-cart"></span> Agregar</button> 
<button type="button" id="vaciarpedidos" class="btn btn-danger" ><span class="fa fa-trash-o"></span> Vaciar</button> </div>
									<hr>	
										
										
										
										<div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered dt-responsive nowrap" id="carrito">
                                                        <thead>
                                                            <tr>
                                                            <th><div align="center">Código</div></th>
                                                            <th><div align="center">Descripción de Producto</div></th>
															<th><div align="center">Categoria</div></th>
                                                            <th><div align="center">Cantidad</div></th>
															<th></th>
                                                        </tr></thead>
                                                        <tbody>
														<tr>
                                                       <td colspan=5><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>
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
                                                     <label for="field-12" class="control-label">Código de Pedido:</label> 
          <div id="codigopedido"><input class="form-control" type="text" name="codpedido" id="codpedido" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Codigo Pedido" value="<?php echo $reg = $tra->CodigoPedidos(); ?>" readonly="readonly"></div> 
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
									 
                      <!-- Third Action -->
                                      <div class="form-group">  
                                                     <label for="field-12" class="control-label">Fecha de Pedido:</label> 
<input class="form-control" type="text" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Pedido" readonly="readonly"> 
                                            </div>
											
				 
					  <!-- Four Action 
                  <div class="col-lg-12">
                      <div class="row"> 
						  <div class="col-md-12"> 
                                      <div class="form-group">  
                                                     <label for="field-12" class="control-label">Registrado por:</label> 
 <input class="form-control" type="text" name="nombres" id="nombres" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" readonly="readonly"> 
                                            </div> 
                             </div>
                      </div>
				 </div>-->
				 
				                    <div class="form-group">  
                                                     <label for="field-12" class="control-label">Registrado por:</label> 
 <input class="form-control" type="text" name="nombres" id="nombres" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo $_SESSION["nombres"]; ?>" readonly="readonly"> 
                                            </div> 
                     

                      
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