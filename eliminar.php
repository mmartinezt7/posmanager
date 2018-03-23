<?php
require_once("class/class.php");
$tra = new Login();
$tipo = base64_decode($_GET['tipo']);
switch($tipo)
	{
case 'USUARIOS':
$tra->EliminarUsuarios();
exit;
break;

case 'CATEGORIAS':
$tra->EliminarCategorias();
exit;
break;

case 'CAJAS':
$tra->EliminarCaja();
exit;
break;

case 'RETIROEFECTIVO':
$tra->EliminarRetiro();
exit;
break;

case 'PRODUCTOS':
$tra->EliminarProductos();
exit;
break;

case 'ITEMS':
$tra->EliminarItems();
exit;
break;

case 'CLIENTES':
$tra->EliminarClientes();
exit;
break;

case 'PROVEEDORES':
$tra->EliminarProveedores();
exit;
break;

case 'PEDIDOS':
$tra->EliminarPedidos();
exit;
break;

case 'ABONOSCREDITOS':
$tra->EliminarAbonosCreditos();
exit;
break;

case 'DETALLESPEDIDOS':
$tra->EliminarDetallesPedidos();
exit;
break;

case 'PAGARFACTURA':
$tra->PagarCompras();
exit;
break;

case 'DETALLESCOMPRAS':
$tra->EliminarDetallesCompras();
exit;
break;

case 'DETALLESVENTAS':
$tra->EliminarDetallesVentas();
exit;
break;

case 'DETALLESDEVOLUCIONES':
$tra->EliminarDetallesDevoluciones();
exit;
break;

case 'DETALLESSERVICIOS':
$tra->EliminarDetallesServicios();
exit;
break;

}
?>