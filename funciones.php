<script type="text/javascript" src="assets/script/script2.js"></script>
<script>
$(function () {
//$(".calendario").datepicker({
$('input').filter('.calendario').datepicker({
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
<?php
require_once("class/class.php");

$con = new Login();
$con = $con->ConfiguracionPorId(); 

$tra = new Login();
?>


<?php
############################# BUSQUEDA DE USUARIOS Y MOSTRAR EN VENTANA MODAL #############################################
if (isset($_GET['BuscaUsuarioModal']) && isset($_GET['codigo'])) { 

$reg = $tra->UsuariosPorId();

  ?>
  
  <div class="row">
  <table width="458" border="0" align="center" >
  <tr>
    <td width="410"><strong>C&eacute;dula:</strong> <?php echo $reg[0]['cedula']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres:</strong> <?php echo $reg[0]['nombres']; ?></td>
  </tr>
  <tr>
    <td><strong>Sexo:</strong> <?php echo $reg[0]['sexo']; ?></td>
  </tr>
  <tr>
    <td><strong>Cargo: </strong> <?php echo $reg[0]['cargo']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electr&oacute;nico: </strong> <?php echo $reg[0]['email']; ?></td>
  </tr>
  <tr>
    <td><strong>Usuario: </strong> <?php echo $reg[0]['usuario']; ?></td>
  </tr>
  <tr>
    <td><strong>Nivel: </strong> <?php echo $reg[0]['nivel']; ?></td>
  </tr>
  <tr>
    <td><strong>Status: </strong> <?php echo $status = ( $reg[0]['status'] == 'ACTIVO' ? "<span class='label label-success'>".$reg[0]['status']."</span>" : "<span class='label label-warning'>".$reg[0]['status']."</span>"); ?></td>
  </tr>
</table>
</div>
  
  <?php
   } 
############################# FIN DE BUSQUEDA DE USUARIOS Y MOSTRAR EN VENTANA MODAL #############################################
?>


<?php 
############################# MUESTRA NUMERO DE PRODUCTOS #############################################
if (isset($_GET['muestranroproducto'])) {
	
$tra = new Login();
	?>
<input type="hidden" name="codproceso" id="codproceso" value="<?php echo GenerateRandomString(); ?>">
<?php 
	}
############################# FIN DE MUESTRA NUMERO DE PRODUCTOS ######################################
?>
<?php
############################# FIN DE BUSQUEDA DE PRODUCTO EN ALMACEN Y MOSTRAR EN VENTANA MODAL #############################################
if (isset($_GET['BuscaProductoModal']) && isset($_GET['codproducto'])) { 

$codproducto = $_GET['codproducto'];

$reg = $tra->DetalleProductosPorId();
?>
<div class="row">
  <table width="547" border="0" align="center" >
    <tr>
      <td width="171" rowspan="9"><div align="center"><?php
	if (isset($pregro[0]['codproducto'])) {
	if (file_exists("fotos/".$reg[0]['codproducto'].".jpg")){
    echo "<img src='fotos/".$reg[0]['codproducto'].".jpg?".date('h:i:s')."' border='0' width='100' height='120' title='".$reg[0]['producto']."' data-rel='tooltip'>"; 
}else{
    echo "<img src='fotos/producto.png' border='1' width='100' height='120' data-rel='tooltip'>"; 
} } else {
	echo "<img src='fotos/producto.png' border='1' width='100' height='120' data-rel='tooltip'>"; 
}
?><br /><br /><strong><?php  //Mostramos la imagen
    echo "<img src='codigoBarras_img.php?numero=".$reg[0]['codigobarra']."' title='Codigo de Barra'>"; ?></strong></div></td>
      <td width="366"><strong>C&oacute;digo de Producto: </strong><?php echo $reg[0]['codproducto']; ?></td>
    </tr>
    <tr>
      <td><strong>Nombre de Producto: </strong> <?php echo $reg[0]['producto']; ?></td>
    </tr>
    <tr>
      <td><strong>Categoria: </strong> <?php echo $reg[0]['nomcategoria']; ?></td>
    </tr>
    <tr>
      <td><strong>Existencia: </strong> <?php echo $reg[0]['existencia']; ?></td>
    </tr>
    <tr>
      <td><strong>Precio Venta: </strong> <?php echo number_format($reg[0]['precioventa'], 2, '.', ','); ?></td>
    </tr>
    <tr>
      <td><strong>Tiene Iva: </strong> <?php echo $reg[0]['ivaproducto']; ?></td>
    </tr>
    <tr>
      <td><strong>Ubicaci&oacute;n: </strong> <?php echo $reg[0]['ubicacion']; ?></td>
    </tr>
    <tr>
      <td><strong>Stock Minimo: </strong> <?php echo $reg[0]['stockminimo']; ?></td>
    </tr>
    <tr>
      <td><strong>Status: </strong> <?php echo $status = ( $reg[0]['statusproducto'] == 'ACTIVO' ? "<span class='label label-success'>".$reg[0]['statusproducto']."</span>" : "<span class='label label-warning'>".$reg[0]['statusitems']."</span>"); ?></td>
    </tr>
  </table>
</div><br />
<table align="center" class="table m-t-30">
                                                        <thead>
                                                            <tr>
                                                            <th><div align="center">Fecha</div></th>
															<th><div align="center">Provedor/Cliente</div></th>
                                                            <th><div align="center">Movimiento</div></th>
															<th><div align="center">Entradas</div></th>
															<th><div align="center">Salidas</div></th>
															<th><div align="center">Precio Costo</div></th>
															<th><div align="center">Costo Movimiento</div></th>
															<th><div align="center">Stock Actual</div></th>
															<th><div align="center">Documento</div></th>
                                                            </tr>
														</thead>
                                                        <tbody>
 <?php 
$tru = new Login();
$busq = $tru->VerDetallesKardexProducto();
for($i=0;$i<sizeof($busq);$i++){
?>
														 <tr>
                                                                <td><div align="center"><?php echo $busq[$i]["fechakardex"]; ?></div></td>
																<td><div align="center"><?php if($busq[$i]["codresponsable"]=="0") { echo "INVENTARIO INICIAL"; } elseif($busq[$i]["movimiento"]=="ENTRADAS"){ echo $busq[$i]["proveedor"]; } elseif($busq[$i]["movimiento"]=="SALIDAS"){ echo $busq[$i]["clientes"]; } ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["movimiento"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["entradas"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["salidas"]; ?></div></td>
                                                                <td><div align="center"><?php echo number_format($busq[$i]['preciounit'], 2, '.', ','); ?></div></td>
                                                                <td><div align="center"><?php echo number_format($busq[$i]['costototal'], 2, '.', ','); ?></div></td>
                                                                <td><?php echo $busq[$i]['stockactual']; ?></td>
                                                                <td><div align="center"><?php echo $busq[$i]["documento"]; ?></div></td>
                                                          </tr>
															<?php } ?>
                                                        </tbody>
</table>
<?php
}
############################# FIN DE BUSQUEDA DE PRODUCTO EN ALMACEN Y MOSTRAR EN VENTANA MODAL #############################################

?>



<?php
############################# BUSQUEDA DE ITEMS DE SERVICIOS Y MOSTRAR EN VENTANA MODAL #############################################
if (isset($_GET['BuscaItemModal']) && isset($_GET['iditems'])) { 

$reg = $tra->ItemsPorId();

  ?>
  
  <div class="row">
  <table border="0" align="center" >
  <tr>
    <td width="350"><strong>C&oacute;digo de Items:</strong> <?php echo $reg[0]['coditems']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Items:</strong> <?php echo $reg[0]['nombreitems']; ?></td>
  </tr>
  <tr>
    <td><strong>Costo de Items:</strong> <?php echo number_format($reg[0]['costoitems'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Status de Items:</strong> <?php echo $status = ( $reg[0]['statusitems'] == 'ACTIVO' ? "<span class='label label-success'>".$reg[0]['statusitems']."</span>" : "<span class='label label-warning'>".$reg[0]['statusitems']."</span>"); ?></td>
  </tr>
</table>
</div>
  
  <?php
   } 
############################# FIN DE BUSQUEDA DE ITEMS DE SERVICIOS Y MOSTRAR EN VENTANA MODAL #############################################
?>




<?php
############################# BUSQUEDA DE CLIENTES Y MOSTRAR EN VENTANA MODAL #############################################
if (isset($_GET['BuscaClienteModal']) && isset($_GET['codcliente'])) { 

$reg = $tra->ClientesPorId();

  ?>
  
  <div class="row">
  <table border="0" align="center" >
  <tr>
    <td width="350"><strong>C&eacute;dula de Cliente:</strong> <?php echo $reg[0]['cedcliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Cliente:</strong> <?php echo $reg[0]['nomcliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Direcci&oacute;n de Cliente:</strong> <?php echo $reg[0]['direccliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Telefono de Cliente:</strong> <?php echo $reg[0]['tlfcliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Email de Cliente:</strong> <?php echo $reg[0]['emailcliente']; ?></td>
  </tr>
</table>
</div>
  
  <?php
   } 
############################# FIN DE BUSQUEDA DE CLIENTES Y MOSTRAR EN VENTANA MODAL #############################################
?>




<?php
############################# BUSQUEDA DE PROVEEDOR Y MOSTRAR EN VENTANA MODAL #############################################
if (isset($_GET['BuscaProveedorModal']) && isset($_GET['codproveedor'])) { 

$reg = $tra->ProveedoresPorId();

  ?>
  
  <div class="row">
  <table border="0" align="center" >
  <tr>
    <td width="350"><strong>Rif de Proveedor:</strong> <?php echo $reg[0]['ritproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Proveedor:</strong> <?php echo $reg[0]['nomproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Direcci&oacute;n de Proveedor:</strong> <?php echo $reg[0]['direcproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Telefono de Proveedor:</strong> <?php echo $reg[0]['tlfproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Email de Proveedor:</strong> <?php echo $reg[0]['emailproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Persona de Contacto:</strong> <?php echo $reg[0]['contactoproveedor']; ?></td>
  </tr>
</table>
</div>
  
  <?php
   } 
############################# FIN DE BUSQUEDA DE PROVEEDOR Y MOSTRAR EN VENTANA MODAL #############################################
?>




























<?php 
############################# MUESTRA CODIGO DE FACTURA DE PEDIDOS DE PRODUCTOS #############################################
if (isset($_GET['muestracodigopedido'])) {
	
$tra = new Login();
	?>
<input class="form-control" type="text" name="codpedido" id="codpedido" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Codigo Pedido" value="<?php echo $reg = $tra->CodigoPedidos(); ?>" readonly="readonly">
		<?php 
	}
############################# FIN DE MUESTRA CODIGO DE FACTURA DE PEDIDOS DE PRODUCTOS ######################################
?>

<?php
############################# BUSQUEDA DE PEDIDOS DE PRODUCTO Y DETALLES DE PEDIDOS #############################################
if (isset($_GET['BuscaPedidosModal']) && isset($_GET['codpedido'])) { 

$codpedido = $_GET['codpedido'];

$tra = new Login(); 
$pe = $tra->PedidosPorId();
?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="pull-right">
												 <address>
							  <abbr title="Orden de Pedido"><strong>ORDEN DE PEDIDO: </strong> <?php echo $pe[0]["codpedido"]; ?></abbr><br>
                              <abbr title="<?php echo $pe[0]["contactoproveedor"]; ?>"><strong><?php echo $pe[0]["ritproveedor"].": ".$pe[0]["nomproveedor"]; ?></strong></abbr><br>
							  <abbr title="Direcci&oacute;n de Proveedor"><?php echo $pe[0]["direcproveedor"]; ?></abbr><br>
                              <abbr title="Email de Proveedor"><?php echo $pe[0]["emailproveedor"]; ?></abbr> <abbr title="Telefono"><strong>TLF:</strong></abbr> <?php echo $pe[0]["tlfproveedor"]; ?><br />
					 <abbr title="Fecha de Pedido"><strong>FECHA DE PEDIDO:</strong></abbr> <?php echo date("d-m-Y h:i:s",strtotime($pe[0]["fechapedido"])); ?>
                                                  </address>
                                                </div>
                                            </div>
                                        </div>                      
											 
											 
											 
											  <table class="table m-t-30">
                                                        <thead>
                                                            <tr>
                                                            <th><div align="center">C&oacute;digo</div></th>
                                                            <th><div align="center">Descripci&oacute;n de Producto</div></th>
															<th><div align="center">Categoria</div></th>
															<th><div align="center">Cantidad</div></th>
                                                            </tr>
														</thead>
                                                        <tbody>
 <?php 
$tru = new Login();
$busq = $tru->VerDetallesPedidos();
for($i=0;$i<sizeof($busq);$i++){
?>
														 <tr>
                                                                <td><div align="center"><?php echo $busq[$i]["codproducto"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["producto"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["nomcategoria"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["cantpedido"]; ?></div></td>
                                                          </tr>
															<?php } ?>
                                                        </tbody>
</table>
<?php
}
############################# FIN DE BUSQUEDA DE PEDIDOS DE PRODUCTO Y DETALLES DE PEDIDOS #############################################

?>

<?php
############################# BUSQUEDA DE PEDIDOS DE PRODUCTOS POR PROVEEDORES #############################################
if (isset($_GET['BuscaPedidos']) && isset($_GET['codproveedor'])) { 
	
	 $codproveedor = $_GET['codproveedor'];

if($codproveedor=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR SELECCIONE EL PROVEEDOR PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		
} else {

$pro = new Login();
$pro = $pro->ProveedorPorId();

  ?>

   <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Pedidos de Productos del Proveedor <?php echo $pro[0]['nomproveedor']; ?></h3>
                                    </div>
                                    <div class="panel-body">

                      <div id="div1"><table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>N&deg;</th>
													<th>C&oacute;digo de Pedido</th>
                                                    <th>Fecha de Pedido</th>
													<th>Registrado por</th>
													<th>Factura</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$ci = new Login();
$reg = $ci->BuscarPedidosReportes();
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                                <tr>
                                                    <td><div align="center"><?php echo $a++; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['codpedido']; ?></div></td>
													   <td><div align="center"><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechapedido'])); ?></div></td>
                                                    <td><div align="center"><?php echo $reg[$i]['nombres']; ?></div></td>
													<td class="actions"><div align="center">
			 <a href="reportepdf?codpedido=<?php echo base64_encode($reg[$i]['codpedido']); ?>&tipo=<?php echo base64_encode("PEDIDOS") ?>" class="on-default" data-placement="left" data-toggle="tooltip" data-original-title="Imprimir Pdf" target="_blank" ><i class="fa fa-file-pdf-o"></i></a>				
									
												
                                                </div>                                            </td>
                                                </tr>
												<?php  }  ?>
                                            </tbody>
                                        </table></div>
									   
					</div>
				</div>
             </div>
  </div>
     </div> <!-- End Row -->
	 
  <?php
  
   }
 } 
############################# FIN DE BUSQUEDA DE PEDIDOS DE PRODUCTOS POR PROVEEDORES #############################################
?>






















































<?php 
############################# MUESTRA NUMERO DE COMPRAS DE PRODUCTOS #############################################
if (isset($_GET['muestranrocompra'])) {
	
$tra = new Login();
	?>
<input class="form-control" type="text" name="codcompra" id="codcompra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Compra" value="<?php echo $reg = $tra->CodigoCompra(); ?>" readonly="readonly">
<?php 
	}
############################# FIN DE MUESTRA NUMERO DE COMPRAS DE PRODUCTOS ######################################
?>

<?php 
############################# MUESTRA NUMERO DE SERIE DE PRODUCTOS #############################################
if (isset($_GET['muestranroseriec'])) {
	
$tra = new Login();
	?>
<input class="form-control" type="text" name="codseriec" id="codseriec" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Serie" value="<?php echo $reg = $tra->CodigoSerieC(); ?>" readonly="readonly">
<?php 
	}
############################# FIN DE MUESTRA NUMERO DE SERIE DE PRODUCTOS ######################################
?>

<?php 
############################# MUESTRA NUMERO DE AUTORIZACION DE PRODUCTOS #############################################
if (isset($_GET['muestranroautorizacionc'])) {
	
$tra = new Login();
	?>
<input class="form-control" type="text" name="codautorizacionc" id="codautorizacionc" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Autorización" value="<?php echo $reg = $tra->CodigoAutorizacionC(); ?>" readonly="readonly">
<?php 
	}
############################# FIN DE MUESTRA NUMERO DE AUTORIZACION DE PRODUCTOS ######################################
?>


<?php 
############################# MUESTRA FORMA DE PAGO PARA COMPRAS #############################################
if (isset($_GET['BuscaFormaPagoCompras']) && isset($_GET['tipocompra'])) { 
	
$tra = new Login();

 if($_GET['tipocompra']=="CONTADO"){  ?>
 
     <div class="form-group"> 
                 <label for="field-12" class="control-label">Forma de Pago:</label> 
       <select name="formacompra" id="formacompra" class="form-control" required="required">
	       <option value="">SELECCIONE</option>
		   <option value="EFECTIVO">EFECTIVO</option>
		   <option value="CHEQUE">CHEQUE</option>
		   <option value="CHEQUE POSFECHADO">CHEQUE POSFECHADO</option>
		   <option value="TARJETA DE CREDITO">TARJETA DE CR&Eacute;DITO</option>
		   <option value="TRANSFERENCIA">TRANSFERENCIA</option>
      </select>
</div>
 
 <?php   } else { ?>
 
 <!-- four Action -->
           <div class="form-group">  
                  <label for="field-12" class="control-label">Fecha de Vencimiento de Cr&eacute;dito:</label> 
<input class="form-control calendario" type="text" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Vence Cr&eacute;dito" required="required"> 
</div>
 
<?php  }
	}
############################# FIN DE MUESTRA FORMA DE PAGOS PARA COMPRAS ######################################
?>

<?php
############################# BUSQUEDA DE COMPRAS DE PRODUCTO Y DETALLES DE PEDIDOS #############################################
if (isset($_GET['BuscaComprasModal']) && isset($_GET['codcompra'])) { 

$tra = new Login(); 
$co = $tra->ComprasPorId();
?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="pull-right">
												 <address>
<abbr title="N° de Compra"><strong>N&deg; DE COMPRA: </strong> <?php echo $co[0]["codcompra"]; ?></abbr><br>
<abbr title="N° de Serie"><strong>N&deg; DE SERIE: </strong> <?php echo $co[0]["codseriec"]; ?></abbr><br>
<abbr title="N° de Autorizaci&oacute;n"><strong>N&deg; DE AUTORIZACI&Oacute;N: </strong> <?php echo $co[0]["codautorizacionc"]; ?></abbr><br>
<abbr title="<?php echo $co[0]["contactoproveedor"]; ?>"><strong><?php echo $co[0]["ritproveedor"].": ".$co[0]["nomproveedor"]; ?></strong></abbr><br>
<abbr title="Direcci&oacute;n de Proveedor"><?php echo $co[0]["direcproveedor"]; ?></abbr><br>
<abbr title="Email de Proveedor"><?php echo $co[0]["emailproveedor"]; ?></abbr> <abbr title="Telefono"><strong>TLF:</strong></abbr> <?php echo $co[0]["tlfproveedor"]; ?><br />
 <abbr title="Fecha de Compra"><strong>FECHA DE COMPRA:</strong></abbr> <?php echo date("d-m-Y h:i:s",strtotime($co[0]["fechacompra"])); ?><br />
<abbr title="Tipo de Compra"><strong>TIPO DE COMPRA:</strong></abbr> <?php echo $co[0]["tipocompra"]; ?><br />
<abbr title="Forma de Compra"><strong>FORMA DE PAGO:</strong></abbr> <?php echo $co[0]["formacompra"]; ?><br />
<abbr title="Fecha de Vencimiento de Cr&eacute;dito"><strong>FECHA DE VENCIMIENTO:</strong></abbr> <?php echo $vence = ( $co[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($co[0]['fechavencecredito']))); ?><br />

<abbr title="Dias Vencidos de Cr&eacute;dito"><strong>DIAS VENCIDOS:</strong></abbr> <?php 
if($co[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
elseif($co[0]['fechavencecredito'] >= date("Y-m-d")) { echo "0"; } 
elseif($co[0]['fechavencecredito'] < date("Y-m-d")) { echo Dias_Transcurridos(date("Y-m-d"),$co[0]['fechavencecredito']); } ?><br />

<abbr title="Status de Compra"><strong>STATUS DE COMPRA:</strong></abbr> <?php 
if($co[0]['fechavencecredito']== '0000-00-00') { echo "<span class='label label-success'>".$co[0]["statuscompra"]."</span>"; } 
elseif($co[0]['fechavencecredito'] >= date("Y-m-d")) { echo "<span class='label label-success'>".$co[0]["statuscompra"]."</span>"; } 
elseif($co[0]['fechavencecredito'] < date("Y-m-d")) { echo "<span class='label label-danger'>VENCIDA</span>"; } ?>
                                                  </address>
                                                </div>
                                            </div>
                                        </div>                      
											 
											 
											 
											  <table class="table m-t-30">
                                                        <thead>
                                                            <tr>
                                                            <th><div align="center">C&oacute;digo</div></th>
                                                            <th><div align="center">Descripci&oacute;n Producto</div></th>
															<th><div align="center">Categoria</div></thde >
															<th><div align="center">Precio C.</div></th>
															<th><div align="center">Cantidad</div></th>
															<th><div align="center">Importe</div></th>
                                                            </tr>
														</thead>
                                                        <tbody>
 <?php 
$tru = new Login();
$busq = $tru->VerDetallesCompras();
for($i=0;$i<sizeof($busq);$i++){
$cantidad=$busq[$i]["cantcompra"];
$importe=$busq[$i]["precio1"]*$cantidad;
?>
														 <tr>
                                                                <td><div align="center"><?php echo $busq[$i]["codproducto"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["producto"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["nomcategoria"]; ?></div></td>
                                                                <td><div align="center"><?php echo number_format($busq[$i]["precio1"], 2, '.', ','); ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["cantcompra"]; ?></div></td>
                                                                <td><div align="center"><?php echo number_format($importe, 2, '.', ','); ?></div></td>
                                                          </tr>
															<?php } ?>
														    <tr>
															<td colspan="3" rowspan="5">&nbsp;</td>
										<td colspan="2"><div align="right"><strong>SubTotal Iva <?php echo $co[0]["ivac"]."(%)"; ?>:</strong></div></td>
														   <td><div align="right"><?php echo number_format($co[0]["subtotalivasic"], 2, '.', ','); ?></div></td>
													      </tr>
													     <tr>
										<td colspan="2"><div align="right"><strong>SubTotal Iva 0%:</strong></div></td>
														   <td><div align="right"><?php echo number_format($co[0]["subtotalivanoc"], 2, '.', ','); ?></div></td>
										        </tr>
														  <tr>
										<td colspan="2"><div align="right"><strong>Iva <?php echo $co[0]["ivac"]."(%)"; ?>:</strong></div></td>
														   <td><div align="right"><?php echo number_format($co[0]["totalivac"], 2, '.', ','); ?></div></td>
													      </tr>
														  <tr>
										<td colspan="2"><div align="right"><strong>Descuento <?php echo $co[0]["descuentoc"]."(%)"; ?>:</strong></div></td>
														   <td><div align="right"><?php echo number_format($co[0]["totaldescuentoc"], 2, '.', ','); ?></div></td>
													      </tr>
														  <tr>
										<td colspan="2"><div align="right"><strong>Total Pago :</strong></div></td>
														   <td><div align="right"><?php echo number_format($co[0]["totalc"], 2, '.', ','); ?></div></td>
													      </tr>
                                                        </tbody>
</table>
<?php
}
############################# FIN DE BUSQUEDA DE COMPRAS DE PRODUCTO Y DETALLES DE PEDIDOS #############################################
?>

<?php
############################# FIN DE BUSQUEDA DE DETALLE DE COMPRA DE PRODUCTO Y MOSTRAR EN VENTANA MODAL #############################################
if (isset($_GET['BuscaDetallesComprasModal']) && isset($_GET['coddetallecompra'])) { 

$reg = $tra->DetallesComprasPorId();
?>
<div class="row">
  <table width="423" border="0" align="center" >
    <tr>
      <td width="133" rowspan="11"><div align="center"><?php
	if (isset($reg[0]['codproducto'])) {
	if (file_exists("fotos/".$reg[0]['codproducto'].".jpg")){
    echo "<img src='fotos/".$reg[0]['codproducto'].".jpg?".date('h:i:s')."' border='0' width='100' height='120' title='".$reg[0]['producto']."' data-rel='tooltip'>"; 
}else{
    echo "<img src='fotos/producto.png' border='1' width='100' height='120' data-rel='tooltip'>"; 
} } else {
	echo "<img src='fotos/producto.png' border='1' width='100' height='120' data-rel='tooltip'>"; 
}
?></div></td>
      <td width="260"><strong>C&oacute;digo de Producto: </strong><?php echo $reg[0]['codproducto']; ?></td>
    </tr>
    <tr>
      <td><strong>Nombre de Producto: </strong> <?php echo $reg[0]['producto']; ?></td>
    </tr>
    <tr>
      <td><strong>Categoria: </strong> <?php echo $reg[0]['nomcategoria']; ?></td>
    </tr>
    <tr>
      <td><strong>Precio Compra: </strong> <?php echo number_format($reg[0]['precio1'], 2, '.', ','); ?></td>
    </tr>
    <tr>
      <td><strong>Precio Venta: </strong> <?php echo number_format($reg[0]['precio2'], 2, '.', ','); ?></td>
    </tr>
    <tr>
      <td><strong>Tiene Iva: </strong> <?php echo $reg[0]['ivaproductoc']; ?></td>
    </tr>
    <tr>
      <td><strong>Cantidad Compra: </strong> <?php echo $reg[0]['cantcompra']; ?></td>
    </tr>
    <tr>
      <td><strong>Importe: </strong> <?php echo number_format($reg[0]['cantcompra'] * $reg[0]['precio1'], 2, '.', ','); ?></td>
    </tr>
    <tr>
      <td><strong>N&deg; de Lote: </strong> <?php echo $reg[0]['lote']; ?></td>
    </tr>
    <tr>
      <td><strong>Fecha de Vencimiento: </strong> <?php echo $reg[0]['vence']; ?></td>
    </tr>
    <tr>
      <td><strong>Fecha Registro: </strong> <?php echo date("d-m-Y h:i:s",strtotime($reg[0]['fechadetallecompra'])); ?></td>
    </tr>
  </table>
</div>
<?php
}
############################# FIN DE BUSQUEDA DE DETALLE DE COMPRA DE PRODUCTO Y MOSTRAR EN VENTANA MODAL #############################################

?>

<?php
############################# BUSQUEDA DE COMPRAS DE PRODUCTOS POR PROVEEDORES #############################################
if (isset($_GET['BuscaCompras']) && isset($_GET['codproveedor'])) { 
	
	 $codproveedor = $_GET['codproveedor'];

if($codproveedor=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR SELECCIONE EL PROVEEDOR PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		
} else {

$pro = new Login();
$pro = $pro->ProveedorPorId();

  ?>

   <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Compras de Productos del Proveedor <?php echo $pro[0]['nomproveedor']; ?></h3>
                                    </div>
                                    <div class="panel-body">

                      <div id="div1"><table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>N&deg;</th>
													<th>C&oacute;digo de Compra</th>
                                                    <th>Subtotal Con Iva</th>
                                                    <th>Subtotal Iva 0%</th>
													<th>Total Iva</th>
													<th>Total</th>
													<th>Fecha Registro</th>
													<th>Imprimir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$ci = new Login();
$reg = $ci->BuscarComprasReportes();
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                                <tr>
                                                    <td><div align="center"><?php echo $a++; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['codcompra']; ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['subtotalivasic'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['subtotalivanoc'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totalivac'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totalc'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechacompra'])); ?></div></td>
													<td class="actions"><div align="center">
			<a href="reportepdf?codcompra=<?php echo base64_encode($reg[$i]['codcompra']); ?>&tipo=<?php echo base64_encode("FACTURACOMPRAS") ?>" target="_black" class="btn btn-info btn-xs" title="Factura de Compra" ><i class="fa fa-print"></i></a></div></td>
                                                </tr>
												<?php  }  ?>
                                            </tbody>
                                        </table>
										<div align="center"><a href="reportepdf.php?codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo base64_encode("COMPRASPROVEEDOR") ?>" title="Compras por Proveedores (Pdf)" target="_blank"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>
													
									<a href="comprasproveedorexcel.php?codproveedor=<?php echo $codproveedor; ?>" title="Compras por Proveedores (Excel)"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>									  
									</div><br />
									   
					</div>
				</div>
             </div>
  </div>
  </div> <!-- End Row -->
	 
  <?php
  
   }
 } 
############################# FIN DE BUSQUEDA DE COMPRAS DE PRODUCTOS POR PROVEEDORES #############################################
?>

<?php
############################# BUSQUEDA DE DEVOLUCIONES DE COMPRAS DE PRODUCTOS POR PROVEEDORES #############################################
if (isset($_GET['BuscaComprasDevoluciones']) && isset($_GET['codproveedor'])) { 
	
	 $codproveedor = $_GET['codproveedor'];

if($codproveedor=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR SELECCIONE EL PROVEEDOR PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		
} else {

$pro = new Login();
$pro = $pro->ProveedorPorId();

  ?>

   <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Devoluciones de Compras de Productos del Proveedor <?php echo $pro[0]['nomproveedor']; ?></h3>
                                    </div>
                                    <div class="panel-body">

                      <div id="div1"><table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>N&deg;</th>
                                  <th>C&oacute;digo</th>
                                  <th>Producto</th>
                                  <th>Categoria</th>
                                  <th>Costo Devoluci&oacute;n</th>
                                  <th>Compra</th>
                                  <th>Devuelto</th>
                                  <th>Lote</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
$p = new Login(); 
$p = $p->BuscarDevolucionesReportes();
$a=1;
for($i=0;$i<sizeof($p);$i++){  
?>
                              <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $p[$i]['codproducto']; ?></td>
                                  <td><?php echo $p[$i]['producto']; ?></td>
                                  <td><?php echo $p[$i]['nomcategoria']; ?></td>
                                  <td><?php echo number_format($p[$i]['precio1'], 2, '.', ','); ?></td>
                                  <td><?php echo $p[$i]['compra']; ?></td>
                                  <td><?php echo $nro = ( $p[$i]["devolucion"] == '' ? "0" : $p[$i]["devolucion"]); ?></td>
                                  <td><?php echo $p[$i]['lote']; ?></td>
                              </tr>
												<?php  }  ?>
                              </tbody>
                          </table></div>
									   
					</div>
				</div>
             </div>
  </div>
     </div> <!-- End Row -->
	 
  <?php
  
   }
 } 
############################# FIN DE BUSQUEDA DE DEVOLUCIONES DE COMPRAS DE PRODUCTOS POR PROVEEDORES #############################################
?>





































































<?php 
############################# MUESTRA NUMERO DE VENTAS DE PRODUCTOS #############################################
if (isset($_GET['muestranroventas'])) {
	
$tra = new Login();
	?>
<input class="form-control" type="text" name="codventa" id="codventa" value="<?php echo $reg = $tra->CodigoVentas(); ?>" readonly="readonly">
		<?php 
	}
############################# FIN DE MUESTRA NUMERO DE VENTAS ######################################
?>

<?php 
############################# MUESTRA NUMERO DE SERIE DE PRODUCTOS #############################################
if (isset($_GET['muestranroserieve'])) {
	
$tra = new Login();
	?>
<input class="form-control" type="text" name="codserieve" id="codserieve" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Serie" value="<?php echo $reg = $tra->CodigoSerieVe(); ?>" readonly="readonly">
<?php 
	}
############################# FIN DE MUESTRA NUMERO DE SERIE DE PRODUCTOS ######################################
?>

<?php 
############################# MUESTRA NUMERO DE AUTORIZACION DE PRODUCTOS #############################################
if (isset($_GET['muestranroautorizacionve'])) {
	
$tra = new Login();
	?>
<input class="form-control" type="text" name="codautorizacionve" id="codautorizacionve" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese N° de Autorización" value="<?php echo $reg = $tra->CodigoAutorizacionVe(); ?>" readonly="readonly">
<?php 
	}
############################# FIN DE MUESTRA NUMERO DE AUTORIZACION DE PRODUCTOS ######################################
?>


<?php 
############################# MUESTRA FORMA DE PAGO PARA VENTAS #############################################
if (isset($_GET['BuscaFormaPagoVentas']) && isset($_GET['tipopagove'])) { 
	
$tra = new Login();

 if($_GET['tipopagove']=="CONTADO"){  ?>
 
     <div class="form-group"> 
                 <label for="field-12" class="control-label">Forma de Pago:</label> 
       <select name="formapagove" id="formapagove" class="form-control" onChange="MuestraCambioPagos()" required="required">
	       <option value="">SELECCIONE</option>
		   <option value="EFECTIVO">EFECTIVO</option>
		   <option value="CHEQUE">CHEQUE</option>
		   <option value="CHEQUE POSFECHADO">CHEQUE POSFECHADO</option>
		   <option value="TARJETA DE CREDITO">TARJETA DE CR&Eacute;DITO</option>
		   <option value="TRANSFERENCIA">TRANSFERENCIA</option>
      </select>
</div>
 
 <?php  } else {  ?>

 <div class="form-group"> 
                  <label for="field-2" class="control-label">Fecha de Vencimiento de Cr&eacute;dito:</label> 
<input class="form-control calendario" type="text" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Vence Cr&eacute;dito" required="required">

<div class="form-group"> 
                 <label for="field-12" class="control-label">Monto de Abono:</label>
				 <input class="form-control number" type="text" name="montoabono" id="montoabono" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Monto de Abono" required="" aria-required="true">
</div>

          
		<?php  }
	}
############################# FIN DE MUESTRA FORMA DE PAGOS PARA VENTAS ######################################
?>


<?php 
############################# MUESTRA CAMBIO DE VUELTO PARA VENTAS #############################################
if (isset($_GET['MuestraCambiosVentas']) && isset($_GET['tipopagove']) && isset($_GET['formapagove'])) { 
	
 if($_GET['tipopagove']=="CONTADO" && $_GET['formapagove']=="EFECTIVO"){  ?>

<div class="form-group"> 
                 <label for="field-12" class="control-label">Monto Pagado por Cliente:</label>
				 <input class="form-control number calculodevolucion" type="text" name="montopagado" id="montopagado" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Monto Pagado por Cliente" required="" aria-required="true">
</div>


<div class="form-group"> 
                 <label for="field-12" class="control-label">Cambio Devuelto a Cliente:</label>
				 <input class="form-control number" type="text" name="montodevuelto" id="montodevuelto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cambio Devuelto a Cliente" readonly="readonly" aria-required="true">
</div>

<?php  } }
############################# FIN DE MUESTRA CAMBIO DE VUELTO PARA VENTAS ######################################
?>

<?php
############################# BUSQUEDA DE VENTAS DE PRODUCTO Y DETALLES DE PEDIDOS #############################################
if (isset($_GET['BuscaVentasModal']) && isset($_GET['codventa'])) { 

$codventa = $_GET['codventa'];

$tra = new Login(); 
$ve = $tra->VentasPorId();
?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="pull-right">
												 <address>
				<abbr title="N° de Venta"><strong>N&deg; DE VENTA: </strong> <?php echo $ve[0]["codventa"]; ?></abbr><br>
				<abbr title="N° de Serie"><strong>N&deg; DE SERIE: </strong> <?php echo $ve[0]["codserieve"]; ?></abbr><br>
			    <abbr title="N° de Autorizacion"><strong>N&deg; DE AUTORIZACI&Oacute;N: </strong> <?php echo $ve[0]["codautorizacionve"]; ?></abbr><br>
				<abbr title="N&deg; de Caja"><strong>N&deg; DE CAJA: </strong> <?php echo $ve[0]["nrocaja"]; ?></abbr><br>
                <abbr title="Nombre de Cliente"><strong><?php echo $ve[0]["cedcliente"].": ".$ve[0]["nomcliente"]; ?></strong></abbr><br>
				<abbr title="Direcci&oacute;n de Cliente"><?php echo $ve[0]["direccliente"]; ?></abbr><br>
                <abbr title="Email de Cliente"><strong>EMAIL: </strong> <?php echo $ve[0]["emailcliente"]; ?></abbr><br>
                <abbr title="Telefono"><strong>N&deg; DE TLF:</strong></abbr> <?php echo $ve[0]["tlfcliente"]; ?><br />
				<abbr title="Tipo de Pago"><strong>TIPO DE PAGO:</strong></abbr> <?php echo $ve[0]["tipopagove"]; ?><br />
				<abbr title="Forma de Pago"><strong>FORMA DE PAGO:</strong></abbr> <?php echo $ve[0]["formapagove"]; ?><br />
				<abbr title="Fecha de Vencimiento de Cr&eacute;dito"><strong>FECHA DE VENCIMIENTO:</strong></abbr> <?php echo $vence = ( $ve[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($ve[0]['fechavencecredito']))); ?><br />
<abbr title="Dias Vencidos de Cr&eacute;dito"><strong>DIAS VENCIDOS:</strong></abbr> <?php 
if($ve[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) { echo "0"; } 
elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) { echo Dias_Transcurridos(date("Y-m-d"),$ve[0]['fechavencecredito']); } ?><br />
				<abbr title="Fecha de Venta"><strong>FECHA DE VENTA:</strong></abbr> <?php echo date("d-m-Y h:i:s",strtotime($ve[0]['fechaventa'])); ?><br />
				<abbr title="Status de Venta"><strong>STATUS DE VENTA:</strong></abbr> <?php 
if($ve[0]['fechavencecredito']== '0000-00-00') { echo "<span class='label label-success'>".$ve[0]["statusventa"]."</span>"; } 
elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) { echo "<span class='label label-success'>".$ve[0]["statusventa"]."</span>"; } 
elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) { echo "<span class='label label-danger'>VENCIDA</span>"; } ?>
                                                  </address>
                                                </div>
                                            </div>
                                        </div>                      
											 
											 
											 
											  <table class="table m-t-30">
                                                        <thead>
                                                            <tr>
                                                            <th><div align="center">C&oacute;digo</div></th>
                                                            <th><div align="center">Descripci&oacute;n de Producto</div></th>
															<th><div align="center">Categoria</div></th>
															<th><div align="center">Precio C.</div></th>
															<th><div align="center">Cantidad</div></th>
															<th><div align="center">Importe</div></th>
                                                            </tr>
														</thead>
                                                        <tbody>
 <?php 
$tru = new Login();
$busq = $tru->VerDetallesVentas();
for($i=0;$i<sizeof($busq);$i++){
$cantidad=$busq[$i]["cantventa"];
$importe=$busq[$i]["precioventa"]*$cantidad;
?>
														 <tr>
                                                                <td><div align="center"><?php echo $busq[$i]["codproducto"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["producto"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["nomcategoria"]; ?></div></td>
                                                                <td><div align="center"><?php echo number_format($busq[$i]["precioventa"], 2, '.', ','); ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["cantventa"]; ?></div></td>
                                                                <td><div align="center"><?php echo number_format($importe, 2, '.', ','); ?></div></td>
                                                          </tr>
															<?php } ?>
														 <tr>
														   <td colspan="3" rowspan="5">&nbsp;</td>
										<td colspan="2"><div align="right"><strong>SubTotal Iva <?php echo $ve[0]["ivave"]."(%)"; ?>:</strong></div></td>
														   <td><div align="right"><?php echo number_format($ve[0]["subtotalivasive"], 2, '.', ','); ?></div></td>
										        </tr>
													     <tr>
										<td colspan="2"><div align="right"><strong>SubTotal Iva 0%:</strong></div></td>
														   <td><div align="right"><?php echo number_format($ve[0]["subtotalivanove"], 2, '.', ','); ?></div></td>
										        </tr>
														  <tr>
										<td colspan="2"><div align="right"><strong>Iva <?php echo $ve[0]["ivave"]."(%)"; ?>:</strong></div></td>
														   <td><div align="right"><?php echo number_format($ve[0]["totalivave"], 2, '.', ','); ?></div></td>
													      </tr>
														  <tr>
										<td colspan="2"><div align="right"><strong>Descuento <?php echo $ve[0]["descuentove"]."(%)"; ?>:</strong></div></td>
														   <td><div align="right"><?php echo number_format($ve[0]["totaldescuentove"], 2, '.', ','); ?></div></td>
													      </tr>
														  <tr>
										<td colspan="2"><div align="right"><strong>Total Pago :</strong></div></td>
														   <td><div align="right"><?php echo number_format($ve[0]["totalpago"], 2, '.', ','); ?></div></td>
													      </tr>
                                                        </tbody>
</table>
<?php
}
############################# FIN DE BUSQUEDA DE VENTAS DE PRODUCTO Y DETALLES DE VENTAS #############################################
?>

<?php
############################# FIN DE BUSQUEDA DE DETALLE DE COMPRA DE PRODUCTO Y MOSTRAR EN VENTANA MODAL #############################################
if (isset($_GET['BuscaDetallesVentasModal']) && isset($_GET['coddetalleventa'])) { 

$reg = $tra->DetallesVentasPorId();
?>
<div class="row">
  <table width="423" border="0" align="center" >
    <tr>
      <td width="133" rowspan="10"><div align="center"><?php
	if (isset($reg[0]['codproducto'])) {
	if (file_exists("fotos/".$reg[0]['codproducto'].".jpg")){
    echo "<img src='fotos/".$reg[0]['codproducto'].".jpg?".date('h:i:s')."' border='0' width='100' height='120' title='".$reg[0]['producto']."' data-rel='tooltip'>"; 
}else{
    echo "<img src='fotos/producto.png' border='1' width='100' height='120' data-rel='tooltip'>"; 
} } else {
	echo "<img src='fotos/producto.png' border='1' width='100' height='120' data-rel='tooltip'>"; 
}
?></div></td>
      <td width="260"><strong>C&eacute;dula de Cliente: </strong><?php echo $reg[0]['cedcliente']; ?></td>
    </tr>
    <tr>
    <td><strong>Nombre de Cliente:</strong> <?php echo $reg[0]['nomcliente']; ?></td>
  </tr>
   <tr>
    <td><strong>C&oacute;digo de Producto:</strong> <?php echo $reg[0]['codproducto']; ?></td>
  </tr>
  <tr>
      <td><strong>Nombre de Producto: </strong> <?php echo $reg[0]['producto']; ?></td>
    </tr>
    <tr>
      <td><strong>Categoria: </strong> <?php echo $reg[0]['nomcategoria']; ?></td>
    </tr>
    <tr>
      <td><strong>Precio Venta: </strong> <?php echo number_format($reg[0]['precioventa'], 2, '.', ','); ?></td>
    </tr>
    <tr>
      <td><strong>Cantidad Venta: </strong> <?php echo $reg[0]['cantventa']; ?></td>
    </tr>
    <tr>
      <td><strong>Tiene Iva: </strong> <?php echo $reg[0]['ivaproducto']; ?></td>
    </tr>
    <tr>
      <td><strong>Importe: </strong> <?php echo number_format($reg[0]['cantventa'] * $reg[0]['precioventa'], 2, '.', ','); ?></td>
    </tr>
    <tr>
      <td><strong>Fecha Venta: </strong> <?php echo date("d-m-Y h:i:s",strtotime($reg[0]['fechadetalleventa'])); ?></td>
    </tr>
  </table>
</div>
<?php
}
############################# FIN DE BUSQUEDA DE DETALLE DE VENTAS DE PRODUCTO Y MOSTRAR EN VENTANA MODAL #############################################
?>

<?php
############################# BUSQUEDA DE VENTAS DE PRODUCTOS POR FECHAS #############################################
if (isset($_GET['BuscaVentasFechas']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 
	
	 $desde = $_GET['desde']; 
     $hasta = $_GET['hasta']; 

if($desde=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA DE INICIO PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} else if($hasta=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA FINAL PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} elseif($desde>$hasta) {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</div></center>"; // wrong details
	 exit;
		
} else {

  ?>
						  
   <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Ventas registradas desde <?php echo "<font color='red'>".$desde."</font color>"; ?> hasta <?php echo "<font color='red'>".$hasta."</font color>"; ?></h3>
                                    </div>
                                    <div class="panel-body">

                      <div id="div1"><table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>N&deg;</th>
													<th>C&oacute;digo de Venta</th>
													<th>N&deg; de Caja</th>
													<th>Fecha Venta</th>
                                                    <th>Subtotal Con Iva</th>
                                                    <th>Subtotal Iva 0%</th>
													<th>Total Iva</th>
													<th>Total Desc</th>
													<th>Total</th>
													<th>Articulos</th>
													<th>Imprimir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$ve = new Login();
$reg = $ve->BuscarVentasFechas();

$totalarticulos=0;
$Subtotalconiva=0;
$Subtotalsiniva=0;
$Totaliva=0;
$Totaldescuento=0;
$pagoDescuento=0;
$Pagototal=0;
$a=1;

for($i=0;$i<sizeof($reg);$i++){
	
$totalarticulos+=$reg[$i]['articulos'];
$Subtotalconiva+=$reg[$i]['subtotalivasive'];
$Subtotalsiniva+=$reg[$i]['subtotalivanove'];
$Totaliva+=$reg[$i]['totalivave']; 
$Totaldescuento+=$reg[$i]['totaldescuentove']; 
$Pagototal+=$reg[$i]['totalpago']; 
?>
                                                <tr>
                                                    <td><div align="center"><?php echo $a++; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['codventa']; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['nrocaja']; ?></div></td>
													   <td><div align="center"><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa'])); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['subtotalivasive'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['subtotalivanove'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totalivave'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totaldescuentove'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo $reg[$i]['articulos']; ?></div></td>
													<td class="actions"><div align="center">
			 <a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKET") ?>" target="_black" class="btn btn-info btn-xs" title="Ticket de Venta" ><i class="fa fa-print"></i></a>

<a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("VENTAS") ?>" target="_black" class="btn btn-warning btn-xs" title="Factura de Venta" ><i class="fa fa-print"></i></a> </div>                                            </td>
                                                </tr>
												<?php  }  ?>
                                                <tr>
                                                  <td></td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td><div align="center"><strong>Total General</strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($Subtotalconiva, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($Subtotalsiniva, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($Totaliva, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($Totaldescuento, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($Pagototal, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo $totalarticulos; ?></strong></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
				<div align="center"><a href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("VENTASFECHAS") ?>" target="_blank"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>
													
									<a href="ventasfechasexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>									  
						</div><br />
									   
					</div>
				</div>
             </div>
          </div>
  </div> <!-- End Row -->
	 
  <?php
   } 
 } 
############################# FIN DE BUSQUEDA DE VENTAS DE PRODUCTOS POR FECHAS #############################################
?>

<?php
############################# BUSQUEDA DE VENTAS DE PRODUCTOS POR FECHAS Y CAJAS DE VENTAS #############################################
if (isset($_GET['BuscaVentasCajas']) && isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['codcaja'])) { 
	
	 $desde = $_GET['desde']; 
     $hasta = $_GET['hasta'];  
     $codcaja = $_GET['codcaja'];

if($desde=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA DE INICIO PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} else if($hasta=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA FINAL PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} elseif($desde>$hasta) {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</div></center>"; // wrong details
	 exit;
	 
} else if($codcaja=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR SELECCIONE CAJA DE VENTA PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		
} else {

$ca = new Login();
$ca = $tra->CajerosPorId();
  ?>
						  
   <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Ventas registradas de Caja <?php echo "<font color='red'>N&deg; ".$ca[0]['nrocaja']."</font color>"; ?> y Fecha desde <?php echo "<font color='red'>".$desde."</font color>"; ?> hasta <?php echo "<font color='red'>".$hasta."</font color>"; ?></h3>
                                    </div>
                                    <div class="panel-body">

                      <div id="div1"><table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>N&deg;</th>
													<th>C&oacute;digo de Venta</th>
													<th>Clientes</th>
													<th>Fecha Venta</th>
                                                    <th>Subtotal Con Iva</th>
                                                    <th>Subtotal Iva 0%</th>
													<th>Total Iva</th>
													<th>Total Desc</th>
													<th>Total</th>
													<th>Articulos</th>
													<th>Imprimir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$ve = new Login();
$reg = $ve->BuscarVentasCajas();

$totalarticulos=0;
$Subtotalconiva=0;
$Subtotalsiniva=0;
$Totaliva=0;
$Totaldescuento=0;
$pagoDescuento=0;
$Pagototal=0;
$a=1;

for($i=0;$i<sizeof($reg);$i++){
	
$totalarticulos+=$reg[$i]['articulos'];
$Subtotalconiva+=$reg[$i]['subtotalivasive'];
$Subtotalsiniva+=$reg[$i]['subtotalivanove'];
$Totaliva+=$reg[$i]['totalivave']; 
$Totaldescuento+=$reg[$i]['totaldescuentove']; 
$Pagototal+=$reg[$i]['totalpago']; 
?>
                                                <tr>
                                                    <td><div align="center"><?php echo $a++; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['codventa']; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['nomcliente']; ?></div></td>
													   <td><div align="center"><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa'])); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['subtotalivasive'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['subtotalivanove'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totalivave'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totaldescuentove'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo $reg[$i]['articulos']; ?></div></td>
													<td class="actions"><div align="center">
			 <a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKET") ?>" target="_black" class="btn btn-info btn-xs" title="Ticket de Venta" ><i class="fa fa-print"></i></a>

<a href="reportepdf?codventa=<?php echo base64_encode($reg[$i]['codventa']); ?>&tipo=<?php echo base64_encode("VENTAS") ?>" target="_black" class="btn btn-warning btn-xs" title="Factura de Venta" ><i class="fa fa-print"></i></a> </div>                                            </td>
                                                </tr>
												<?php  }  ?>
                                                <tr>
                                                  <td></td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td><div align="center"><strong>Total General</strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($Subtotalconiva, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($Subtotalsiniva, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($Totaliva, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($Totaldescuento, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($Pagototal, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo $totalarticulos; ?></strong></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
				<div align="center"><a href="reportepdf?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("VENTASCAJAS") ?>" target="_blank"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>
													
									<a href="ventascajasexcel?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>									  
						</div><br />
									   
					</div>
				</div>
             </div>
          </div>
  </div> <!-- End Row -->
	 
  <?php
   } 
 } 
############################# FIN DE BUSQUEDA DE VENTAS DE PRODUCTOS POR FECHAS Y CAJAS DE VENTAS #############################################
?>

<?php
############################# BUSQUEDA DE PRODUCTOS FACTURADOS POR FECHAS #############################################
if (isset($_GET['BuscaVentasProductos']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 
	
	 $desde = $_GET['desde']; 
     $hasta = $_GET['hasta']; 

if($desde=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA DE INICIO PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} else if($hasta=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA FINAL PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} elseif($desde>$hasta) {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</div></center>"; // wrong details
	 exit;
		
} else {

  ?>
						  
   <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Productos Vendidos registrados desde <?php echo "<font color='red'>".$desde."</font color>"; ?> hasta <?php echo "<font color='red'>".$hasta."</font color>"; ?></h3>
                                    </div>
                                    <div class="panel-body">

                      <div id="div1"><table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>N&deg;</th>
													<th>C&oacute;digo</th>
													<th>Descripcion de Producto</th>                                                    
													<th>Categoria</th>
													<th>Precio de Venta</th>
													<th>Existencia</th>
													<th>Vendido</th>
													<th>Monto Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$ve = new Login();
$reg = $ve->BuscarVentasProductos();
$precioTotal=0;
$existeTotal=0;
$vendidosTotal=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$precioTotal+=$reg[$i]['precioventa'];
$existeTotal+=$reg[$i]['existencia'];
$vendidosTotal+=$reg[$i]['cantidad']; 
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['cantidad']; 
?>
                                                <tr>
                                                    <td><div align="center"><?php echo $a++; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['codproducto']; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['producto']; ?></div></td>
													   <td><div align="center"><?php echo $reg[$i]['nomcategoria']; ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]["precioventa"], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo $reg[$i]['existencia']; ?></div></td>
													   <td><div align="center"><?php echo $reg[$i]['cantidad']; ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></div></td>
                                                </tr>
												<?php  }  ?>
                                                <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><div align="center"><strong>Total General</strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($precioTotal, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo $existeTotal; ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo $vendidosTotal; ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($pagoTotal, 2, '.', ','); ?></strong></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
				<div align="center"><a href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("VENTASPRODUCTOS") ?>" target="_blank"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>
													
									<a href="ventasproductosexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>									  
						</div><br />
									   
					</div>
				</div>
             </div>
          </div>
  </div> <!-- End Row -->
	 
  <?php
   } 
 } 
############################# FIN DE BUSQUEDA DE PRODUCTOS FACTURADOS POR FECHAS #############################################
?>


<?php 
############################# MUESTRA BUSQUEDA DE KARDEX POR PRODUCTOS #############################################
if (isset($_GET['BuscaKardexProducto']) && isset($_GET['codproducto'])) { 

$codproducto = $_GET['codproducto']; 

if($codproducto=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR REALICE LA B&Uacute;SQUEDA DEL PRODUCTO CORRECTAMENTE </div></center>"; // wrong details
	 exit;
	 
	 } else {
	
$kardex = new Login();
$kardex = $kardex->BuscarKardexProducto();  
 ?>
 
 


 <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Movimientos del Producto <?php echo "<strong><font color='red'>C&Oacute;D. ".$kardex[0]['codproducto']." - NOM. ".$kardex[0]['producto']." - PREC. ".$kardex[0]['precioventa']." - EXIST. ".$kardex[0]['existencia']."</font color></strong>"; ?></h3>
                                    </div>
                                    <div class="panel-body">

                     <div id="div1"> <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>N&deg;</th>
                                  <th>Movimiento</th>
                                  <th>Entradas</th>
                                  <th>Salidas</th>
                                  <th>Precio Costo</th>
                                  <th>Costo Movimiento</th>
                                  <th>Stock Actual</th>
                                  <th>Documento</th>
                                  <th>Fecha</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
 


$TotalEntradas=0;
$TotalSalidas=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){ 
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
?>
                              <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $kardex[$i]['movimiento']; ?></td>
                                  <td><?php echo $kardex[$i]['entradas']; ?></td>
                                  <td><?php echo $kardex[$i]['salidas']; ?></td>
                                  <td><?php echo number_format($kardex[$i]['preciounit'], 2, '.', ','); ?></td>
                                  <td><?php echo number_format($kardex[$i]['costototal'], 2, '.', ','); ?></td>
                                  <td><?php echo $kardex[$i]['stockactual']; ?></td>
                                  <td><?php echo $kardex[$i]['documento']; ?></td>
                                  <td><?php echo date("d-m-Y h:i:s",strtotime($kardex[$i]['fechakardex'])); ?></td>
                              </tr>
												<?php  }  ?>
                              </tbody>
                          </table>
	                      
						  <strong>Detalles de Producto</strong><br>
						  <strong>C&oacute;digo : <?php echo $kardex[0]['codproducto']; ?></strong><br>
						  <strong>Descripci&oacute;n : <?php echo $kardex[0]['producto']; ?></strong><br>
						  <strong>Categoria : <?php echo $kardex[0]['nomcategoria']; ?></strong><br>
						  <strong>Total Entradas : <?php echo $TotalEntradas; ?></strong><br>
						  <strong>Total Salidas : <?php echo $TotalSalidas; ?></strong><br>
						  <strong>Existencia : <?php echo $kardex[0]['existencia']; ?></strong><br>
						  <strong>Precio Compra : <?php echo $kardex[0]['preciocompra']; ?></strong><br>
						  <strong>Precio Venta : <?php echo $kardex[0]['precioventa']; ?></strong>
				<div align="center"><a href="reportepdf?codproducto=<?php echo $codproducto; ?>&tipo=<?php echo base64_encode("KARDEXPRODUCTOS") ?>" target="_blank"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>	</div>
									   
				     </div>
                </div>
             </div>
          </div>
  </div> <!-- End Row -->
		<?php
		} 
	}
############################# FIN DE BUSQUEDA DE KARDEX POR PRODUCTOS ######################################
?>

























<?php 
############################# MUESTRA BUSQUEDA DE ABONOS DE CREDITOS #############################################
if (isset($_GET['BuscaAbonosClientes']) && isset($_GET['codcliente'])) { 

$codcliente = $_GET['codcliente']; 

if($codcliente=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR REALICE LA B&Uacute;SQUEDA DEL CLIENTE CORRECTAMENTE </div></center>"; // wrong details
	 exit;
	 
	 } else {
	
$bon = new Login();
$bon = $bon->BuscarClientesAbonos();  
 ?>
 
 


 <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Creditos de Ventas del Cliente <?php echo "<strong><font color='red'>".$bon[0]['nomcliente']."</font color></strong>"; ?></h3>
                                    </div>
                                    <div class="panel-body">

                      <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>N&deg;</th>
								  <th>C&oacute;digo de Venta</th>
                                  <th>Fecha Venta</th>
                                  <th>Total Factura</th>
                                  <th>Monto Abono</th>
                                  <th>Total Debe</th>
                                  <th>Status Cr&eacute;dito</th>
                                  <th>Dias Vencidos</th>
                                  <th>Acciones</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalFactura=0;
$TotalCredito=0;
$TotalDebe=0;
for($i=0;$i<sizeof($bon);$i++){  
$TotalFactura+=$bon[$i]['totalpago'];
$TotalCredito+=$bon[$i]['abonototal'];
$TotalDebe+=$bon[$i]['totalpago']-$bon[$i]['abonototal'];
?>
                            <tr>
                           <td><?php echo $a++; ?></td>
                           <td><?php echo $bon[$i]['codventa']; ?></td>
                           <td><?php echo date("d-m-Y h:i:s",strtotime($bon[$i]['fechaventa'])); ?></td>
                           <td><?php echo number_format($bon[$i]['totalpago'], 2, '.', ','); ?></td>
                           <td><?php echo number_format($bon[$i]['abonototal'], 2, '.', ','); ?></td>
                           <td><?php echo number_format($bon[$i]['totalpago']-$bon[$i]['abonototal'], 2, '.', ','); ?></td>
                           <td><?php 
if($bon[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>"; } 
elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>"; } 
elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) { echo "<span class='label label-danger'>VENCIDA</span>"; } ?></td>
                          <td><?php 
if($bon[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "0"; } 
elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) { echo Dias_Transcurridos(date("Y-m-d"),$bon[$i]['fechavencecredito']); } ?></td>
                           <td>
<a href="reportepdf?codventa=<?php echo base64_encode($bon[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKETCREDITOS") ?>" target="_black" class="btn btn-info" title="Ticket de Abono" ><i class="fa fa-print"></i></a>
						   
<?php if($bon[$i]['statusventa'] == 'PAGADA') { echo "<span class='label label-success'> CR&Eacute;DITO PAGADO</span>"; } else { ?><button type="button" onclick="NuevoAbono('<?php echo $bon[$i]['cedcliente'] ?>','<?php echo $bon[$i]['codventa'] ?>')" class="btn btn-primary"><span class="fa fa-save"></span> Abonar a Factura</button><?php } ?>					       </td>
                              </tr>
												<?php  }  ?>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td><strong>Total General</strong></td>
                              <td><strong><?php echo number_format($TotalFactura, 2, '.', ','); ?></strong></td>
                              <td><strong><?php echo number_format($TotalCredito, 2, '.', ','); ?></strong></td>
                              <td><strong><?php echo number_format($TotalDebe, 2, '.', ','); ?></strong></td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                              </tbody>
                          </table>
									   
				</div>
             </div>
          </div>
  </div> <!-- End Row -->
		<?php
		} 
	}
############################# FIN DE BUSQUEDA DE ABONOS DE CREDITOS ######################################
?>


<?php 
############################# MUESTRA MUESTRA FORMULARIO PARA PAGOS DE ABONOS DE CREDITOS #############################################
if (isset($_GET['MuestraFormularioAbonos']) && isset($_GET['cedcliente']) && isset($_GET['codventa'])) { 

$cedcliente = $_GET['cedcliente']; 
$codventa = $_GET['codventa'];
	
$forbon = new Login();
$forbon = $forbon->BuscaAbonosCreditos();  
 ?>
 
 
<div class="row">
						    <div class="col-lg-12">
                                <div class="panel panel-border panel-warning widget-s-1">
<div class="panel-heading"><h4 class="mb"><i class="fa fa-edit"></i> Formulario para Registro Abonos de Creditos de Factura N&deg; <?php echo "<strong><font color='red'>".base64_decode($codventa)."</font color></strong>"; ?></h4> </div>
                                    <div class="panel-body">
 
						 <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">C&eacute;dula de Cliente: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
           <input type="text" class="form-control" name="cedcliente" id="cedcliente" value="<?php echo $forbon[0]['cedcliente']; ?>" readonly="readonly">
		   <input type="hidden" name="codcliente" id="codcliente" value="<?php echo $forbon[0]['codcliente']; ?>" readonly="readonly">
		   <input type="hidden" name="codventa" id="codventa" value="<?php echo $forbon[0]['codventa']; ?>" readonly="readonly">
		                         <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						   <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Nombre de Cliente: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
           <input type="text" class="form-control" name="nomcliente" id="nomcliente" value="<?php echo $forbon[0]['nomcliente']; ?>" readonly="readonly">
                        <i class="fa fa-pencil form-control-feedback"></i>
                              </div>
                          </div>
						  
						   <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Total Factura Cr&eacute;dito: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
         <input type="text" class="form-control" name="totalpago" id="totalpago" value="<?php echo $forbon[0]['totalpago']; ?>" readonly="readonly">
                        <i class="fa fa-money form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Total Factura Abonado: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
<input type="text" class="form-control" name="abonado" id="abonado" value="<?php echo $total = ( $forbon[0]['abonototal'] == '' ? "0.00" : $forbon[0]['abonototal']); ?>" readonly="readonly">
                        <i class="fa fa-money form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Total Debe: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
    <input type="text" class="form-control" name="totaldebe" id="totaldebe" value="<?php echo number_format($forbon[0]['totalpago']-$forbon[0]['abonototal'], 2, '.', ''); ?>" readonly="readonly">
                        <i class="fa fa-money form-control-feedback"></i>
                              </div>
                          </div>
						  
						  <div class="form-group has-feedback">
                              <label class="col-sm-2 col-sm-2 control-label">Monto a Abonar: <span class="symbol required"></span></label>
                              <div class="col-sm-10">
   <input class="form-control number" type="text" name="montoabono" id="montoabono" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Monto a Abonar" required="" aria-required="true">
                        <i class="fa fa-money form-control-feedback"></i>
                              </div>
                          </div>
						                           
						  <div class="modal-footer"> 
        <button class="btn btn-danger" type="button" onclick="document.getElementById('montoabono').value = ''"><span class="fa fa-times"></span> Cancelar</button> 
        <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-save"></span> Registrar Abono</button> 
                          </div>
                      </form>
                                  </div>
                                </div>
                            </div>
  </div>
		<?php
	}
############################# FIN DE MUESTRA FORMULARIO PARA PAGOS DE ABONOS DE CREDITOS ######################################
?>


<?php
############################# BUSQUEDA DE CREDITOS Y DETALLES DE CREDITOS #############################################
if (isset($_GET['BuscaCreditosModal']) && isset($_GET['codventa'])) { 

$codventa = $_GET['codventa'];

$tra = new Login(); 
$ve = $tra->CreditosPorId();
?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="pull-right">
												 <address>
				<abbr title="N° de Venta"><strong>N&deg; DE VENTA: </strong> <?php echo $ve[0]["codventa"]; ?></abbr><br>
				<abbr title="N° de Serie"><strong>N&deg; DE SERIE: </strong> <?php echo $ve[0]["codserieve"]; ?></abbr><br>
			    <abbr title="N° de Autorizacion"><strong>N&deg; DE AUTORIZACI&Oacute;N: </strong> <?php echo $ve[0]["codautorizacionve"]; ?></abbr><br>
				<abbr title="N&deg; de Caja"><strong>N&deg; DE CAJA: </strong> <?php echo $ve[0]["nrocaja"]; ?></abbr><br>
                <abbr title="Nombre de Cliente"><strong><?php echo $ve[0]["cedcliente"].": ".$ve[0]["nomcliente"]; ?></strong></abbr><br>
                <abbr title="Telefono"><strong>N&deg; DE TLF:</strong></abbr> <?php echo $ve[0]["tlfcliente"]; ?><br />
				<abbr title="Tipo de Pago"><strong>TIPO DE PAGO:</strong></abbr> <?php echo $ve[0]["tipopagove"]; ?><br />
				<abbr title="Forma de Pago"><strong>FORMA DE PAGO:</strong></abbr> <?php echo $ve[0]["formapagove"]; ?><br />
				<abbr title="Fecha de Vencimiento de Cr&eacute;dito"><strong>FECHA DE VENCIMIENTO:</strong></abbr> <?php echo $vence = ( $ve[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($ve[0]['fechavencecredito']))); ?><br />
<abbr title="Dias Vencidos de Cr&eacute;dito"><strong>DIAS VENCIDOS:</strong></abbr> <?php 
if($ve[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) { echo "0"; } 
elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) { echo Dias_Transcurridos(date("Y-m-d"),$ve[0]['fechavencecredito']); } ?><br />
				<abbr title="Fecha de Venta"><strong>FECHA DE VENTA:</strong></abbr> <?php echo date("d-m-Y h:i:s",strtotime($ve[0]['fechaventa'])); ?><br />
				<abbr title="Status de Venta"><strong>STATUS DE VENTA:</strong></abbr> <?php 
if($ve[0]['fechavencecredito']== '0000-00-00') { echo "<span class='label label-success'>".$ve[0]["statusventa"]."</span>"; } 
elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) { echo "<span class='label label-success'>".$ve[0]["statusventa"]."</span>"; } 
elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) { echo "<span class='label label-danger'>VENCIDA</span>"; } ?><br />
			<abbr title="Total Factura"><strong>TOTAL FACTURA:</strong></abbr> <?php echo number_format($ve[0]["totalpago"], 2, '.', ','); ?><br />
			<abbr title="Total Abono"><strong>TOTAL ABONO:</strong></abbr> <?php echo $total = ( $ve[0]['abonototal'] == '' ? "0.00" : $ve[0]['abonototal']); ?><br />		            <abbr title="Total Debe"><strong>TOTAL DEBE:</strong></abbr> <?php echo number_format($ve[0]['totalpago']-$ve[0]['abonototal'], 2, '.', ','); ?>
                                                  </address>
                                                </div>
                                            </div>
                                        </div>                      
											 
											 
											 
											  <table class="table m-t-30">
                                                        <thead>
                                                            <tr>
                                                            <th><div align="center">C&oacute;digo</div></th>
                                                            <th><div align="center">Monto de Abono</div></th>
															<th><div align="center">Fecha de Abono</div></th>
                                                            </tr>
														</thead>
                                                        <tbody>
 <?php 
$tru = new Login();
$busq = $tru->VerDetallesCreditos();
$a=1;
for($i=0;$i<sizeof($busq);$i++){
?>
														 <tr>
                                                                <td><div align="center"><?php echo $a++; ?></div></td>
                                                                <td><div align="center"><?php echo number_format($busq[$i]["montoabono"], 2, '.', ','); ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["fechaabono"]; ?></div></td>
                                                          </tr>
															<?php } ?>
                                                        </tbody>
  </table>
<?php
}
############################# FIN DE BUSQUEDA DE CREDITOS Y DETALLES DE CREDITOS #############################################
?>


<?php 
############################# MUESTRA BUSQUEDA DE CREDITOS POR CLIENTES PARA REPORTES #############################################
if (isset($_GET['BuscaCreditosClientesReportes']) && isset($_GET['codcliente'])) { 

$codcliente = $_GET['codcliente']; 

if($codcliente=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR REALICE LA B&Uacute;SQUEDA DEL CLIENTE CORRECTAMENTE</div></center>"; // wrong details
	 exit;
	 
	 } else {
	
$bon = new Login();
$bon = $bon->BuscarClientesAbonos();  
 ?>
 


 <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Creditos de Ventas del Cliente <?php echo "<strong><font color='red'>".$bon[0]['nomcliente']."</font color></strong>"; ?></h3>
                                    </div>
                                    <div class="panel-body">

                     <div id="div1"> <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>N&deg;</th>
								  <th>C&oacute;digo de Venta</th>
                                  <th>N&deg; de Caja</th>
                                  <th>Status Cr&eacute;dito</th>
                                  <th>Dias Vencidos</th>
                                  <th>Total Factura</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th>Acciones</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalFactura=0;
$TotalCredito=0;
$TotalDebe=0;
for($i=0;$i<sizeof($bon);$i++){  
$TotalFactura+=$bon[$i]['totalpago'];
$TotalCredito+=$bon[$i]['abonototal'];
$TotalDebe+=$bon[$i]['totalpago']-$bon[$i]['abonototal'];
?>
                            <tr>
                           <td><?php echo $a++; ?></td>
                           <td><?php echo $bon[$i]['codventa']; ?></td>
                           <td><?php echo $bon[$i]['nrocaja']; ?></td>
                           <td><?php 
if($bon[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>"; } 
elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>"; } 
elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) { echo "<span class='label label-danger'>VENCIDA</span>"; } ?></td>
                            <td><?php 
if($bon[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "0"; } 
elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) { echo Dias_Transcurridos(date("Y-m-d"),$bon[$i]['fechavencecredito']); } ?></td>
                           <td><?php echo number_format($bon[$i]['totalpago'], 2, '.', ','); ?></td>
                           <td><?php echo number_format($bon[$i]['abonototal'], 2, '.', ','); ?></td>
                           <td><?php echo number_format($bon[$i]['totalpago']-$bon[$i]['abonototal'], 2, '.', ','); ?></td>
                           <td>
<a href="reportepdf?codventa=<?php echo base64_encode($bon[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKETCREDITOS") ?>" target="_black" class="btn btn-info" title="Ticket de Abono" ><i class="fa fa-print"></i></a>					       </td>
                              </tr>
												<?php  }  ?>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td><strong>Total General</strong></td>
                              <td><strong><?php echo number_format($TotalFactura, 2, '.', ','); ?></strong></td>
                              <td><strong><?php echo number_format($TotalCredito, 2, '.', ','); ?></strong></td>
                              <td><strong><?php echo number_format($TotalDebe, 2, '.', ','); ?></strong></td>
                              <td>&nbsp;</td>
                            </tr>
                              </tbody>
                          </table>
				<div align="center"><a href="reportepdf?codcliente=<?php echo $codcliente; ?>&tipo=<?php echo base64_encode("CREDITOSCLIENTES") ?>" target="_blank"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>
													
									<a href="creditosclientesexcel?codcliente=<?php echo $codcliente; ?>"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>									  
					   </div><br />
								      </div>
				</div>
             </div>
          </div>
    </div> <!-- End Row -->
		<?php
		} 
	}
############################# FIN DE BUSQUEDA DE CREDITOS POR CLIENTES PARA REPORTES ######################################
?>


<?php 
############################# MUESTRA BUSQUEDA DE CREDITOS POR FECHAS PARA REPORTES #############################################
if (isset($_GET['BuscaCreditosFechasReportes']) && isset($_GET['desde']) && isset($_GET['hasta'])) {  

     $desde = $_GET['desde']; 
     $hasta = $_GET['hasta']; 

if($desde=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA DE INICIO PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} else if($hasta=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA FINAL PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
	 
	 } else {
	
$bon = new Login();
$bon = $bon->BuscarCreditosFechas();  
 ?>
 
 


 <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Creditos por Fechas Desde <?php echo "<strong><font color='red'>".$_GET["desde"]." hasta ".$_GET["hasta"]."</font color></strong>"; ?></h3>
                                    </div>
                                    <div class="panel-body">

                     <div id="div1"> <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>N&deg;</th>
                                  <th>C&eacute;dula Cliente</th>
                                  <th>Nombre Cliente</th>
                                  <th>Status Cr&eacute;dito</th>
                                  <th>Dias Vencidos</th>
								  <th>C&oacute;digo de Venta</th>
                                  <th>Total Factura</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th>Acciones</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalFactura=0;
$TotalCredito=0;
$TotalDebe=0;
for($i=0;$i<sizeof($bon);$i++){  
$TotalFactura+=$bon[$i]['totalpago'];
$TotalCredito+=$bon[$i]['abonototal'];
$TotalDebe+=$bon[$i]['totalpago']-$bon[$i]['abonototal'];
?>
                            <tr>
                           <td><?php echo $a++; ?></td>
                           <td><?php echo $bon[$i]['cedcliente']; ?></td>
						   <td><?php echo $bon[$i]['nomcliente']; ?></td>
                           <td><?php 
if($bon[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>"; } 
elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>"; } 
elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) { echo "<span class='label label-danger'>VENCIDA</span>"; } ?></td>
                            <td><?php 
if($bon[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "0"; } 
elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) { echo Dias_Transcurridos(date("Y-m-d"),$bon[$i]['fechavencecredito']); } ?></td>
                           <td><?php echo $bon[$i]['codventa']; ?></td>
                           <td><?php echo number_format($bon[$i]['totalpago'], 2, '.', ','); ?></td>
                           <td><?php echo number_format($bon[$i]['abonototal'], 2, '.', ','); ?></td>
                           <td><?php echo number_format($bon[$i]['totalpago']-$bon[$i]['abonototal'], 2, '.', ','); ?></td>
                           <td>
<a href="reportepdf?codventa=<?php echo base64_encode($bon[$i]['codventa']); ?>&tipo=<?php echo base64_encode("TICKETCREDITOS") ?>" target="_black" class="btn btn-info" title="Ticket de Abono" ><i class="fa fa-print"></i></a>					       </td>
                           
                              </tr>
												<?php  }  ?>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td><strong>Total General</strong></td>
                              <td><strong><?php echo number_format($TotalFactura, 2, '.', ','); ?></strong></td>
                              <td><strong><?php echo number_format($TotalCredito, 2, '.', ','); ?></strong></td>
                              <td><strong><?php echo number_format($TotalDebe, 2, '.', ','); ?></strong></td>
                              <td>&nbsp;</td>
                            </tr>
                              </tbody>
                          </table>
				<div align="center"><a href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("CREDITOSFECHAS") ?>" target="_blank"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>
													
									<a href="creditosfechasexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>									  
					   </div><br />
								      </div>
				</div>
             </div>
          </div>
  </div> <!-- End Row -->
		<?php
		} 
	}
############################# FIN DE BUSQUEDA DE CREDITOS POR FECHAS PARA REPORTES ######################################
?>











































<?php 
############################# MUESTRA CODIGO DE FACTURAS DE DEVOLUCIONES #############################################
if (isset($_GET['muestracodigodevolucion'])) {
	
$tra = new Login();
	?>
<input class="form-control" type="text" name="coddevolucion" id="coddevolucion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código de Devolución" value="<?php echo $reg = $tra->CodigoDevolucion(); ?>" readonly="readonly">
		<?php 
	}
############################# FIN DE MUESTRA CODIGO DE FACTURAS DE DEVOLUCIONES ######################################
?>

<?php
############################# BUSQUEDA DE DEVOLUCIONES DE PRODUCTO Y DETALLES DE DEVOLUCIONES #############################################
if (isset($_GET['BuscaDevolucionesModal']) && isset($_GET['coddevolucion'])) { 

$coddevolucion = $_GET['coddevolucion'];

$tra = new Login(); 
$dev = $tra->DevolucionesPorId();
?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="pull-right">
												 <address>
							  <abbr title="C&oacute;digo de Venta"><strong>ORDEN DE DEVOLUCI&Oacute;N: </strong> <?php echo $dev[0]["coddevolucion"]; ?></abbr><br>
							  <abbr title="N&deg; de Caja"><strong>N&deg; DE CAJA: </strong> <?php echo $dev[0]["nrocaja"]; ?></abbr><br>
                              <abbr title="Nombre de Cliente"><strong><?php echo $dev[0]["ritproveedor"].": ".$dev[0]["nomproveedor"]; ?></strong></abbr><br>
							  <abbr title="Direcci&oacute;n de Cliente"><?php echo $dev[0]["direcproveedor"]; ?></abbr><br>
                               <abbr title="Email de Cliente"><strong>EMAIL: </strong> <?php echo $dev[0]["emailproveedor"]; ?></abbr><br>
                              <abbr title="Telefono"><strong>N&deg; DE TLF:</strong></abbr> <?php echo $dev[0]["tlfproveedor"]; ?><br />
							  <abbr title="Fecha de Venta"><strong>FECHA DE DEVOLUCI&Oacute;N:</strong></abbr> <?php echo date("d-m-Y h:i:s",strtotime($dev[0]['fechadevolucion'])); ?>
                                                  </address>
                                                </div>
                                            </div>
                                        </div>                      
											 
											 
											 
											  <table class="table m-t-30">
                                                        <thead>
                                                            <tr>
                                                            <th><div align="center">C&oacute;digo</div></th>
                                                            <th><div align="center">Descripci&oacute;n</div></th>
															<th><div align="center">Categoria</div></th>
															<th><div align="center">Precio</div></th>
															<th><div align="center">Cant.</div></th>
															<th><div align="center">Lote</div></th>
															<th><div align="center">Importe</div></th>
                                                            </tr>
														</thead>
                                                        <tbody>
 <?php 
$tru = new Login();
$busq = $tru->VerDetallesDevoluciones();
for($i=0;$i<sizeof($busq);$i++){
$cantidad=$busq[$i]["cantdevolucion"];
$importe=$busq[$i]["preciodevolucion"]*$cantidad;
?>
														 <tr>
                                                                <td><div align="center"><?php echo $busq[$i]["codproducto"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["producto"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["nomcategoria"]; ?></div></td>
                                                                <td><div align="center"><?php echo number_format($busq[$i]["preciodevolucion"], 2, '.', ','); ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["cantdevolucion"]; ?></div></td>
																<td><div align="center"><?php echo $busq[$i]["lotedevolucion"]; ?></div></td>
                                                                <td><div align="center"><?php echo number_format($importe, 2, '.', ','); ?></div></td>
                                                          </tr>
															<?php } ?>
														 <tr>
														   <td colspan="5" rowspan="5">&nbsp;</td>
														   <td><div align="right"><strong>Sub-Total :</strong></div></td>
														   <td><div align="right"><?php echo number_format($dev[0]["subtotald"], 2, '.', ','); ?></div></td>
										        </tr>
														  <tr>
														   <td><div align="right"><strong>Iva <?php echo $dev[0]["ivad"]."(%)"; ?> :</strong></div></td>
														   <td><div align="right"><?php echo number_format($dev[0]["totalivad"], 2, '.', ','); ?></div></td>
													      </tr>
														  <tr>
														   <td><div align="right"><strong>Total Pago :</strong></div></td>
														   <td><div align="right"><?php echo number_format($dev[0]["totald"], 2, '.', ','); ?></div></td>
													      </tr>
                                                        </tbody>
</table>
<?php
}
############################# FIN DE BUSQUEDA DE DEVOLUCIONES DE PRODUCTO Y DETALLES DE DEVOLUCIONES #############################################
?>

<?php
############################# FIN DE BUSQUEDA DE DETALLE DE DEVOLUCIONES DE PRODUCTO Y MOSTRAR EN VENTANA MODAL #############################################
if (isset($_GET['BuscaDetallesDevolucionesModal']) && isset($_GET['coddetalledevolucion'])) { 

$reg = $tra->DetallesDevolucionesPorId();
?>
<div class="row">
  <table width="423" border="0" align="center" >
    <tr>
      <td width="133" rowspan="9"><div align="center"><?php
	if (isset($reg[0]['codproducto'])) {
	if (file_exists("fotos/".$reg[0]['codproducto'].".jpg")){
    echo "<img src='fotos/".$reg[0]['codproducto'].".jpg?".date('h:i:s')."' border='0' width='100' height='120' title='".$reg[0]['producto']."' data-rel='tooltip'>"; 
}else{
    echo "<img src='fotos/producto.png' border='1' width='100' height='120' data-rel='tooltip'>"; 
} } else {
	echo "<img src='fotos/producto.png' border='1' width='100' height='120' data-rel='tooltip'>"; 
}
?></div></td>
      <td width="260"><strong>Rif de Proveedor: </strong><?php echo $reg[0]['ritproveedor']; ?></td>
    </tr>
    <tr>
    <td><strong>Nombre de Proveedor:</strong> <?php echo $reg[0]['nomproveedor']; ?></td>
  </tr>
   <tr>
    <td><strong>C&oacute;digo de Producto:</strong> <?php echo $reg[0]['codproducto']; ?></td>
  </tr>
  <tr>
      <td><strong>Nombre de Producto: </strong> <?php echo $reg[0]['producto']; ?></td>
    </tr>
    <tr>
      <td><strong>Categoria: </strong> <?php echo $reg[0]['nomcategoria']; ?></td>
    </tr>
    <tr>
      <td><strong>Precio Venta: </strong> <?php echo number_format($reg[0]['preciodevolucion'], 2, '.', ','); ?></td>
    </tr>
    <tr>
      <td><strong>Cantidad Venta: </strong> <?php echo $reg[0]['cantdevolucion']; ?></td>
    </tr>
    <tr>
      <td><strong>Importe: </strong> <?php echo number_format($reg[0]['cantdevolucion'] * $reg[0]['preciodevolucion'], 2, '.', ','); ?></td>
    </tr>
    <tr>
      <td><strong>Fecha Venta: </strong> <?php echo date("d-m-Y h:i:s",strtotime($reg[0]['fechadetalledevolucion'])); ?></td>
    </tr>
  </table>
</div>
<?php
}
############################# FIN DE BUSQUEDA DE DETALLE DE DEVOLUCIONES DE PRODUCTO Y MOSTRAR EN VENTANA MODAL #############################################
?>


<?php
############################# BUSQUEDA DE DEVOLUCIONES DE PRODUCTOS POR PROVEEDORES #############################################
if (isset($_GET['BuscaDevoluciones']) && isset($_GET['codproveedor'])) { 
	
	 $codproveedor = $_GET['codproveedor'];

if($codproveedor=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR SELECCIONE EL PROVEEDOR PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		
} else {

$pro = new Login();
$pro = $pro->ProveedorPorId();

  ?>

   <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Devoluciones de Productos del Proveedor <?php echo $pro[0]['nomproveedor']; ?></h3>
                                    </div>
                                    <div class="panel-body">

                      <div id="div1"><table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>N&deg;</th>
													<th>C&oacute;digo de Devoluci&oacute;n</th>
                                                    <th>Subtotal</th>
													<th>Total Iva</th>
													<th>Total</th>
													<th>Fecha Registro</th>
													<th>Factura</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$ci = new Login();
$reg = $ci->BuscarDevolucionesReportes();
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                                <tr>
                                                    <td><div align="center"><?php echo $a++; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['coddevolucion']; ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['subtotald'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totalivad'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totald'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechadevolucion'])); ?></div></td>
													<td class="actions"><div align="center">
			 <a href="reportepdf?coddevolucion=<?php echo base64_encode($reg[$i]['coddevolucion']); ?>&tipo=<?php echo base64_encode("DEVOLUCIONES") ?>" class="on-default" data-placement="left" data-toggle="tooltip" data-original-title="Imprimir Pdf" target="_blank" ><i class="fa fa-file-pdf-o"></i></a>	
						
									
												
                                                </div>                                            </td>
                                                </tr>
												<?php  }  ?>
                                            </tbody>
                                        </table></div>
									   
					</div>
				</div>
             </div>
  </div>
     </div> <!-- End Row -->
	 
  <?php
  
   }
 } 
############################# FIN DE BUSQUEDA DE DEVOLUCIONES DE PRODUCTOS POR PROVEEDORES #############################################
?>





























































<?php 
############################# MUESTRA CODIGO DE FACTURAS DE SERVICIOS #############################################
if (isset($_GET['muestracodigoservicios'])) {
	
$tra = new Login();
	?>
<input class="form-control" type="text" name="codservicio" id="codservicio" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Codigo de Servicio" value="<?php echo $reg = $tra->CodigoServicios(); ?>" readonly="readonly">
		<?php 
	}
############################# FIN DE MUESTRA CODIGO DE FACTURAS DE SERVICIOS ######################################
?>

<?php
############################# BUSQUEDA DE FACTURAS DE SERVICIOS Y DETALLES DE PEDIDOS #############################################
if (isset($_GET['BuscaServiciosModal']) && isset($_GET['codservicio'])) { 

$tra = new Login(); 
$se = $tra->ServiciosPorId();
?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="pull-right">
												 <address>
							  <abbr title="C&oacute;digo de Venta"><strong>C&Oacute;DIGO DE FACTURA: </strong> <?php echo $se[0]["codservicio"]; ?></abbr><br>
							  <abbr title="N&deg; de Caja"><strong>N&deg; DE CAJA: </strong> <?php echo $se[0]["nrocaja"]; ?></abbr><br>
                              <abbr title="Nombre de Cliente"><strong><?php echo $se[0]["cedcliente"].": ".$se[0]["nomcliente"]; ?></strong></abbr><br>
							  <abbr title="Direcci&oacute;n de Cliente"><?php echo $se[0]["direccliente"]; ?></abbr><br>
							  <abbr title="Email de Cliente"><strong>EMAIL: </strong> <?php echo $se[0]["emailcliente"]; ?></abbr><br>
                              <abbr title="Telefono"><strong>N&deg; DE TLF:</strong></abbr> <?php echo $se[0]["tlfcliente"]; ?><br />
							  <abbr title="Tipo de Pago"><strong>TIPO DE PAGO:</strong></abbr> <?php echo $se[0]["tipopago"]; ?><br />
							  <abbr title="Fecha de Servicio"><strong>FECHA DE SERVICIO:</strong></abbr> <?php echo date("d-m-Y h:i:s",strtotime($se[0]['fechaservicio'])); ?>
                                                  </address>
                                                </div>
                                            </div>
                                        </div>                      
											 
											 
											 
											  <table class="table m-t-30">
                                                        <thead>
                                                            <tr>
                                                            <th><div align="center">C&oacute;digo</div></th>
                                                            <th><div align="center">Descripci&oacute;n de Servicio</div></th>
															<th><div align="center">Precio C.</div></th>
															<th><div align="center">Cantidad</div></th>
															<th><div align="center">Importe</div></th>
                                                            </tr>
														</thead>
                                                        <tbody>
 <?php 
$tru = new Login();
$busq = $tru->VerDetallesServicios();
for($i=0;$i<sizeof($busq);$i++){
$cantidad=$busq[$i]["cantservicio"];
$importe=$busq[$i]["precioservicio"]*$cantidad;
?>
														 <tr>
                                                                <td><div align="center"><?php echo $busq[$i]["coditems"]; ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["nombreitems"]; ?></div></td>
                                                                <td><div align="center"><?php echo number_format($busq[$i]["precioservicio"], 2, '.', ','); ?></div></td>
                                                                <td><div align="center"><?php echo $busq[$i]["cantservicio"]; ?></div></td>
                                                                <td><div align="center"><?php echo number_format($importe, 2, '.', ','); ?></div></td>
                                                          </tr>
															<?php } ?>
														 <tr>
														   <td colspan="3" rowspan="5">&nbsp;</td>
														   <td><div align="right"><strong>Sub-Total :</strong></div></td>
														   <td><div align="right"><?php echo number_format($se[0]["subtotal"], 2, '.', ','); ?></div></td>
										        </tr>
														  <tr>
														   <td><div align="right"><strong>Iva <?php echo $se[0]["iva"]."(%)"; ?> :</strong></div></td>
														   <td><div align="right"><?php echo number_format($se[0]["totaliva"], 2, '.', ','); ?></div></td>
													      </tr>
														  <tr>
														   <td><div align="right"><strong>Desc. <?php echo $se[0]["descuento"]."(%)"; ?> :</strong></div></td>
														   <td><div align="right"><?php echo number_format($se[0]["totaldescuento"], 2, '.', ','); ?></div></td>
													      </tr>
														  <tr>
														   <td><div align="right"><strong>Total :</strong></div></td>
														   <td><div align="right"><?php echo number_format($se[0]["totalpago"], 2, '.', ','); ?></div></td>
													      </tr>
                                                        </tbody>
</table>
<?php
}
############################# FIN DE BUSQUEDA DE FACTURAS DE SERVICIOS Y DETALLES DE PEDIDOS #############################################
?>

<?php
############################# FIN DE BUSQUEDA DE DETALLE DE FACTURAS DE SERVICIOS Y MOSTRAR EN VENTANA MODAL #############################################
if (isset($_GET['BuscaDetallesServiciosModal']) && isset($_GET['coddetalleservicio'])) { 

$reg = $tra->DetallesServiciosPorId();
?>
<div class="row">
  <table border="0" align="center" >
   <tr>
    <td width="350"><strong>C&oacute;dula de Cliente:</strong> <?php echo $reg[0]['cedcliente']; ?></td>
  </tr>
   <tr>
    <td width="350"><strong>Nombre de Cliente:</strong> <?php echo $reg[0]['nomcliente']; ?></td>
  </tr>
  <tr>
    <td width="350"><strong>C&oacute;digo de Servicio:</strong> <?php echo $reg[0]['coditems']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Servicio:</strong> <?php echo $reg[0]['nombreitems']; ?></td>
  </tr>
  <tr>
    <td><strong>Costo de Servicio:</strong> <?php echo number_format($reg[0]['precioservicio'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Cantidad de Servicio:</strong> <?php echo $reg[0]['cantservicio']; ?></td>
  </tr>
  <tr>
    <td><strong>Importe:</strong> <?php echo number_format($reg[0]['importe'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Servicio:</strong> <?php echo date("d-m-Y h:i:s",strtotime($reg[0]['fechadetalleservicio'])); ?></td>
  </tr>
</table>
</div>
<?php
}
############################# FIN DE BUSQUEDA DE DETALLE DE FACTURAS DE SERVICIOS Y MOSTRAR EN VENTANA MODAL #############################################
?>


<?php
############################# BUSQUEDA DE FACTURAS DE SERVICIOS POR FECHAS #############################################
if (isset($_GET['BuscaServiciosFechas']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 
	
	 $desde = $_GET['desde']; 
     $hasta = $_GET['hasta']; 

if($desde=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA DE INICIO PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} else if($hasta=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA FINAL PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} elseif($desde>$hasta) {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</div></center>"; // wrong details
	 exit;
		
} else {

  ?>
						  
   <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Servicios registrados desde <?php echo "<font color='red'>".$desde."</font color>"; ?> hasta <?php echo "<font color='red'>".$hasta."</font color>"; ?></h3>
                                    </div>
                                    <div class="panel-body">

                      <div id="div1"><table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>N&deg;</th>
													<th>C&oacute;digo de Servicio</th>
													<th>N&deg; de Caja</th> 
													<th>Fecha Venta</th>                                                   
													<th>Subtotal</th>
													<th>Iva</th>
													<th>Descuento</th>
													<th>Total Pago</th>
													<th>Servicios</th>
													<th>Factura</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$ve = new Login();
$reg = $ve->BuscarServiciosFechas();
$serviciosTotal=0;
$pagoSubtotal=0;
$pagoIva=0;
$pagoDescuento=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$serviciosTotal+=$reg[$i]['cantidad'];
$pagoSubtotal+=$reg[$i]['subtotal']; 
$pagoIva+=$reg[$i]['totaliva']; 
$pagoDescuento+=$reg[$i]['totaldescuento'];  
$pagoTotal+=$reg[$i]['totalpago']; 
?>
                                                <tr>
                                                    <td><div align="center"><?php echo $a++; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['codservicio']; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['nrocaja']; ?></div></td>
													   <td><div align="center"><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechaservicio'])); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totaliva'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo $reg[$i]['cantidad']; ?></div></td>
													<td class="actions"><div align="center">
			 <a href="reportepdf?codservicio=<?php echo base64_encode($reg[$i]['codservicio']); ?>&tipo=<?php echo base64_encode("SERVICIOS") ?>" class="on-default" data-placement="left" data-toggle="tooltip" data-original-title="Imprimir Pdf" target="_blank" ><i class="fa fa-file-pdf-o"></i></a> </div>                                            </td>
                                                </tr>
												<?php  }  ?>
                                                <tr>
                                                  <td></td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td><div align="center"><strong>Total General</strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($pagoSubtotal, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($pagoIva, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($pagoDescuento, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($pagoTotal, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo $serviciosTotal; ?></strong></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
				<div align="center"><a href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("SERVICIOSFECHAS") ?>" target="_blank"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>
													
									<a href="serviciosfechasexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>									  
						</div><br />
									   
					</div>
				</div>
             </div>
          </div>
  </div> <!-- End Row -->
	 
  <?php
   } 
 } 
############################# FIN DE BUSQUEDA DE FACTURAS DE SERVICIOS POR FECHAS #############################################
?>

<?php
############################# BUSQUEDA DE FACTURAS DE SERVICIOS POR FECHAS Y CAJAS DE VENTAS #############################################
if (isset($_GET['BuscaServiciosCajas']) && isset($_GET['desde']) && isset($_GET['hasta']) && isset($_GET['codcaja'])) { 
	
	 $desde = $_GET['desde']; 
     $hasta = $_GET['hasta'];  
     $codcaja = $_GET['codcaja'];

if($desde=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA DE INICIO PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} else if($hasta=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA FINAL PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} elseif($desde>$hasta) {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</div></center>"; // wrong details
	 exit;
	 
} else if($codcaja=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR SELECCIONE CAJA DE VENTA PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		
} else {

$ca = new Login();
$ca = $tra->CajerosPorId();
  ?>
						  
   <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Ventas registradas de Caja <?php echo "<font color='red'>N&deg; ".$ca[0]['nrocaja']."</font color>"; ?> y Fecha desde <?php echo "<font color='red'>".$desde."</font color>"; ?> hasta <?php echo "<font color='red'>".$hasta."</font color>"; ?></h3>
                                    </div>
                                    <div class="panel-body">

                      <div id="div1"><table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>N&deg;</th>
													<th>C&oacute;digo de Servicio</th>
													<th>N&deg; de Caja</th>
													<th>Fecha Servicio</th> 
													<th>Articulos</th>                                                   
													<th>Subtotal</th>
													<th>Iva</th>
													<th>Descuento</th>
													<th>Total Pago</th>
													<th>Factura</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$ve = new Login();
$reg = $ve->BuscarServiciosCajas();
$serviciosTotal=0;
$pagoSubtotal=0;
$pagoIva=0;
$pagoDescuento=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$serviciosTotal+=$reg[$i]['cantidad'];
$pagoSubtotal+=$reg[$i]['subtotal']; 
$pagoIva+=$reg[$i]['totaliva']; 
$pagoDescuento+=$reg[$i]['totaldescuento'];  
$pagoTotal+=$reg[$i]['totalpago']; 
?>
                                                <tr>
                                                    <td><div align="center"><?php echo $a++; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['codservicio']; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['nrocaja']; ?></div></td>
													   <td><div align="center"><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechaservicio'])); ?></div></td>
													   <td><div align="center"><?php echo $reg[$i]['cantidad']; ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totaliva'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></div></td>
													<td class="actions"><div align="center">
			 <a href="reportepdf?codservicio=<?php echo base64_encode($reg[$i]['codservicio']); ?>&tipo=<?php echo base64_encode("SERVICIOS") ?>" class="on-default" data-placement="left" data-toggle="tooltip" data-original-title="Imprimir Pdf" target="_blank" ><i class="fa fa-file-pdf-o"></i></a> </div>                                            </td>
                                                </tr>
												<?php  }  ?>
                                                <tr>
                                                  <td></td>
                                                  <td>&nbsp;</td>
                                                  <td>&nbsp;</td>
                                                  <td><div align="center"><strong>Total General</strong></div></td>
                                                  <td><div align="center"><strong><?php echo $serviciosTotal; ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($pagoSubtotal, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($pagoIva, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($pagoDescuento, 2, '.', ','); ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($pagoTotal, 2, '.', ','); ?></strong></div></td>
                                                  <td>&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
	<div align="center"><a href="reportepdf?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("SERVICIOSCAJAS") ?>" target="_blank"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>
													
			<a href="servicioscajasexcel?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>									  
						</div><br />
									   
					</div>
				</div>
             </div>
          </div>
  </div> <!-- End Row -->
	 
  <?php
   } 
 } 
############################# FIN DE BUSQUEDA DE FACTURAS DE SERVICIOS POR FECHAS Y CAJAS DE VENTAS #############################################
?>

<?php
############################# BUSQUEDA DE SERVICIOS FACTURADOS POR FECHAS #############################################
if (isset($_GET['BuscaServicios']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 
	
	 $desde = $_GET['desde']; 
     $hasta = $_GET['hasta']; 

if($desde=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA DE INICIO PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} else if($hasta=="") {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; POR FAVOR INGRESE FECHA FINAL PARA TU B&Uacute;SQUEDA</div></center>"; // wrong details
	 exit;
		

} elseif($desde>$hasta) {

     echo "<br><center><div class='alert alert-danger'>";
     echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	 echo "<span class='glyphicon glyphicon-info-sign'></span>&nbsp; LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</div></center>"; // wrong details
	 exit;
		
} else {

  ?>
						  
   <div class="row">
                          <div class="col-md-12">
                                <div class="panel panel-border panel-warning widget-s-1">
                                    <div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-edit"></i> Productos Vendidos registrados desde <?php echo "<font color='red'>".$desde."</font color>"; ?> hasta <?php echo "<font color='red'>".$hasta."</font color>"; ?></h3>
                                    </div>
                                    <div class="panel-body">

                      <div id="div1"><table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>N&deg;</th>
													<th>C&oacute;digo</th>
													<th>Nombre de Servicio</th>
													<th>Costo de Servicio</th>
													<th>Facturados</th>
													<th>Monto Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$ve = new Login();
$reg = $ve->BuscarServicios();
$serviciosTotal=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$serviciosTotal+=$reg[$i]['cantidad'];
$pagoTotal+=$reg[$i]['precioservicio']*$reg[$i]['cantidad']; 
?>
                                                <tr>
                                                    <td><div align="center"><?php echo $a++; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['coditems']; ?></div></td>
                                                       <td><div align="center"><?php echo $reg[$i]['nombreitems']; ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['precioservicio'], 2, '.', ','); ?></div></td>
													   <td><div align="center"><?php echo $reg[$i]['cantidad']; ?></div></td>
													   <td><div align="center"><?php echo number_format($reg[$i]['precioservicio']*$reg[$i]['cantidad'], 2, '.', ','); ?></div></td>
                                                </tr>
												<?php  }  ?>
                                                <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><div align="center"><strong>Total General</strong></div></td>
                                                  <td><div align="center"><strong><?php echo $serviciosTotal; ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($pagoTotal, 2, '.', ','); ?></strong></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
				<div align="center"><a href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo base64_encode("SERVICIOSFACTURADOS") ?>" target="_blank"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-pdf-o"></span> Exportar Pdf</button></a>
													
									<a href="serviciosexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>"><button class="btn btn-success btn-lg" type="button"><span class="fa fa-file-excel-o"></span> Exportar Excel</button> </a>									  
						</div><br />
									   
					</div>
				</div>
             </div>
          </div>
  </div> <!-- End Row -->
	 
  <?php
   } 
 } 
############################# FIN DE BUSQUEDA DE SERVICIOS FACTURADOS POR FECHAS #############################################
?>
