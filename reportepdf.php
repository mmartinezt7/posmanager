<?php
include_once('fpdf/pdf.php');

require_once("class/class.php");

ob_start();

$casos = array (

                  'LOGS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarLogs',

                                    'output' => array('Listado Logs de Acceso.pdf', 'I')

                                  ),
				
				'CAJAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarCajas',

                                    'output' => array('Listado de Cajas de Ventas.pdf', 'I')

                                  ),

                  'RETIROEFECTIVO' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarRetiro',

                                    'output' => array('Listado General de Retiro Efectivo.pdf', 'I')

                                  ),

                  'PRODUCTOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductos',

                                    'output' => array('Listado de Productos en Almacen.pdf', 'I')

                                  ),

                  'PRODUCTOSVENDIDOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarProductosVendidos',

                                    'output' => array('Listado de Productos Facturados.pdf', 'I')

                                  ),

                  'STOCK' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'ListarProductosStockMinimo',

                                    'output' => array('Listado de Productos en Stock Minimo.pdf', 'I')

                                  ),
			 
			  'KARDEXGENERAL' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaKardexGeneral',

                                    'output' => array('Kardex General.pdf', 'I')

                                  ),
			 
			  'KARDEXPRODUCTOS' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaKardexProductos',

                                    'output' => array('Kardex por Producto.pdf', 'I')

                                  ),

                  'ITEMS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarItems',

                                    'output' => array('Listado de Items de Servicios.pdf', 'I')

                                  ),

                  'CLIENTES' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaListarClientes',

                                    'output' => array('Listado General de Clientes.pdf', 'I')

                                  ),

                  'PROVEEDORES' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaListarProveedores',

                                    'output' => array('Listado General de Proveedores.pdf', 'I')

                                  ),

                  'PEDIDOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaPedidosProductos',

                                    'output' => array('Factura de Pedidos.pdf', 'I')

                                  ),

                  'FACTURACOMPRAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaComprasProductos',

                                    'output' => array('Factura de Compras.pdf', 'I')

                                  ),
			 
			  'COMPRASGENERAL' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaComprasGeneral',

                                    'output' => array('Listado de Compras.pdf', 'I')

                                  ),
			 
			  'COMPRASPROVEEDOR' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaComprasProveedor',

                                    'output' => array('Compras por Proveedor.pdf', 'I')

                                  ),
				
				'VENTAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaVentasProductos',

                                    'output' => array('Factura de Venta.pdf', 'I')

                                  ),
				
				'TICKET' => array(

                                    'medidas' => array('P','mm','ticket'),

                                    'func' => 'TablaTicketProductos',

                                    'output' => array('Ticket de Venta.pdf', 'I')

                                  ),
			 
			  'VENTASGENERAL' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaVentasGeneral',

                                    'output' => array('Listado de Ventas.pdf', 'I')

                                  ),
			 
			  'VENTASFECHAS' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaVentasFechas',

                                    'output' => array('Ventas por Fechas.pdf', 'I')

                                  ),
			 
			  'VENTASCAJAS' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaVentasCajas',

                                    'output' => array('Ventas por Fechas y Cajas.pdf', 'I')

                                  ),
			 
			  'VENTASPRODUCTOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaProductosVendidos',

                                    'output' => array('Productos Vendidos.pdf', 'I')

                                  ),
			 
			  'VENTASDIARIASADMINISTRADOR' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaVentasDiariasAdmin',

                                    'output' => array('Ventas Diarias General.pdf', 'I')

                                  ),
			 
			  'VENTASDIARIASVENDEDOR' => array(

                                    'medidas' => array('L','mm','LEGAL'),

                                    'func' => 'TablaVentasDiariasVendedor',

                                    'output' => array('Ventas Diarias por Caja.pdf', 'I')

                                  ),
				
				'TICKETCREDITOS' => array(

                                    'medidas' => array('P','mm','ticket'),

                                    'func' => 'TablaTicketCreditos',

                                    'output' => array('Ticket de Venta.pdf', 'I')

                                  ),
			 
			  'CREDITOSCLIENTES' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaCreditosClientes',

                                    'output' => array('Creditos por Clientes.pdf', 'I')

                                  ),
			 
			  'CREDITOSFECHAS' => array(

                                    'medidas' => array('L','mm','LETTER'),

                                    'func' => 'TablaCreditosFechas',

                                    'output' => array('Creditos por Fechas.pdf', 'I')

                                  ),
				
				'DEVOLUCIONES' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaDevolucionesProductos',

                                    'output' => array('Factura de DEvolucion.pdf', 'I')

                                  ),
								 
				
				'SERVICIOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaServicios',

                                    'output' => array('Factura de Servicios.pdf', 'I')

                                  ),
			 
			  'SERVICIOSFECHAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaServiciosFechas',

                                    'output' => array('Servicios por Fechas.pdf', 'I')

                                  ),
			 
			  'SERVICIOSCAJAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaServiciosCajas',

                                    'output' => array('Servicios por Fechas y Cajas.pdf', 'I')

                                  ),
			 
			  'SERVICIOSFACTURADOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaServiciosFacturados',

                                    'output' => array('Servicios Facturados.pdf', 'I')

                                  ),
			 
			  'SERVICIOSDIARIASADMINISTRADOR' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaServiciosDiariasAdmin',

                                    'output' => array('Servicios Diarios General.pdf', 'I')

                                  ),
			 
			  'SERVICIOSDIARIASVENDEDOR' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaServiciosDiariasVendedor',

                                    'output' => array('Servicios Diarios por Caja.pdf', 'I')

                                  ),
								  
				  'VENTASFECHASGENERAL' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaVentasProductosGeneral',

                                    'output' => array('Ventas General por Productos.pdf', 'I')

                                  ),
								  
				  'ESTADISTICAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'MuestraGrafica',

                                    'output' => array('Grafico de Ventas Anual.pdf', 'I')

                                  ),

                );

 
$tipo = base64_decode($_GET['tipo']);
$caso_data = $casos[$tipo];
$pdf = new PDF($caso_data['medidas'][0], $caso_data['medidas'][1], $caso_data['medidas'][2]);
$pdf->AddPage();
$pdf->{$caso_data['func']}();
$pdf->Output($caso_data['output'][0], $caso_data['output'][1]);
ob_end_flush();
?>