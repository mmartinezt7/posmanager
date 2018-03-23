<?php
if(isset($_SESSION['acceso'])) {
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

?>



<?php if($_SESSION['acceso'] == "administrador") { ?>

	<!----- INICIO DE MENU ----->

	<li class="mt">
                      <a class="active" href="panel">
                          <i class="fa fa-home"></i>
                          <span>Inicio</span>
                      </a>
                  </li>

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-cog"></i>
                          <span>Administración </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="configuracion">Configuración</a></li>
                          <li><a href="usuarios">Usuarios</a></li>
                          <li><a href="logs">Logs de Acceso</a></li>
                          <li><a href="categorias">Categorias</a></li>
						  <li class="has_sub"><a href="javascript:void(0);">Base de Datos</a>
                                  <ul style="">
                                    <li><a href="backup">Respaldar</a></li>
                                    <li><a href="restore">Restaurar</a></li>
                                  </ul>
                          </li>
                      </ul>
                  </li>

				   <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-suitcase"></i>
                          <span>Mantenimiento </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="cajas">Cajas de Ventas</a></li>
                          <li><a href="retiro">Retiro de Efectivo</a></li>
                          <li><a href="items">Items de Servicios</a></li>
                          <li><a href="clientes">Clientes</a></li>
                          <li><a href="proveedores">Proveedores</a></li>
                      </ul>
                  </li>

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-truck"></i>
                          <span>Pedidos </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="forpedidos">Nuevo Pedido</a></li>
                          <li><a href="pedidos">Consultar Pedidos</a></li>
                          <li><a href="detallespedidos">Detalles de Pedidos</a></li>
                          <li><a href="busquedapedidos">Búsqueda de Pedidos</a></li>
                      </ul>
                  </li>

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-folder-open"></i>
                          <span>Compras </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="forcompras">Nueva Compra</a></li>
                          <li><a href="compras">Consultar Compras</a></li>
                          <li><a href="detallescompras">Detalles de Compras</a></li>
                          <li><a href="busquedacompras">Búsqueda de Compras</a></li>
                      </ul>
                  </li>

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-shopping-cart"></i>
                          <span>Ventas </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="forventas">Nueva Venta</a></li>
                          <li><a href="ventas">Consultar Ventas</a></li>
                          <li><a href="detallesventas">Detalles de Ventas</a></li>
                          <li><a href="ventasfechas">Ventas por Fechas</a></li>
                          <li><a href="ventascajas">Ventas por Cajas</a></li>
                          <li><a href="ventasproductos">Productos Facturados</a></li>
                      </ul>
                  </li>
									<li class="sub-menu">
				                      <a href="javascript:;" >
				                          <i class="fa fa-cubes"></i>
				                          <span>Almacen </span> <i class="fa fa-angle-double-right"></i>
				                      </a>
				                      <ul class="sub">
                          <li><a href="productos">Productos en Almacen</a></li>
				          <li><a href="kardex">Kardex General</a></li>
				          <li><a href="buscakardex">Kardex por Productos</a></li>
				                      </ul>
				                  </li>

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-briefcase"></i>
                          <span>Pagos a Créditos </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="forcreditos">Nuevo Pago Créditos</a></li>
                          <li><a href="creditos">Consultar Créditos</a></li>
                          <li><a href="creditosclientes">Créditos por Clientes</a></li>
                          <li><a href="creditosfechas">Créditos por Fechas</a></li>
                      </ul>
                  </li>

				 <!-- <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-archive"></i>
                          <span>Devoluciones </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="fordevolucion">Nueva Devolución</a></li>
                          <li><a href="devolucion">Consultar Devoluciones</a></li>
                          <li><a href="detallesdevolucion">Detalles de Devoluciones</a></li>
                          <li><a href="busquedadevolucion">Búsqueda de Devoluciones</a></li>
                      </ul>
                  </li>-->

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-mortar-board"></i>
                          <span>Servicios </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="forservicios">Facturas Servicios</a></li>
                          <li><a href="servicios">Consultar Servicios</a></li>
						  <li><a href="detallesservicios">Detalles de Servicios</a></li>
                          <li><a href="serviciosfechas">Servicios por Fechas</a></li>
                          <li><a href="servicioscajas">Servicios por Cajas</a></li>
                          <li><a href="serviciosfacturados">Servicios Facturados</a></li>
                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class=" fa fa-bar-chart-o"></i>
                          <span>Estadisticas </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="graficoventas">Estadisticas Ventas</a></li>
                          <li><a href="graficoservicios">Estadisticas Servicios</a></li>
                      </ul>
                  </li>

				  <li>
                      <a href="logout">
                          <i class="fa fa-power-off"></i>
                          <span>Cerrar Sessión</span>
                      </a>
                  </li>

    <!----- FIN DE MENU ----->

				<?php } elseif($_SESSION['acceso'] == "vendedor") { ?>
				
				
				
				
		<!----- INICIO DE MENU ----->

	<li class="mt">
                      <a class="active" href="panel">
                          <i class="fa fa-home"></i>
                          <span>Inicio</span>
                      </a>
                  </li>

				   <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-suitcase"></i>
                          <span>Mantenimiento </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="items">Items de Servicios</a></li>
                          <li><a href="clientes">Clientes</a></li>
                          <li><a href="proveedores">Proveedores</a></li>
                      </ul>
                  </li>

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-folder-open"></i>
                          <span>Compras </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="forcompras">Nueva Compra</a></li>
                          <li><a href="compras">Consultar Compras</a></li>
                          <li><a href="detallescompras">Detalles de Compras</a></li>
                          <li><a href="busquedacompras">Búsqueda de Compras</a></li>
                      </ul>
                  </li>

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-shopping-cart"></i>
                          <span>Ventas </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="forventas">Nueva Venta</a></li>
                          <li><a href="ventas">Consultar Ventas</a></li>
                          <li><a href="detallesventas">Detalles de Ventas</a></li>
                          <li><a href="ventasfechas">Ventas por Fechas</a></li>
                          <li><a href="ventascajas">Ventas por Cajas</a></li>
                          <li><a href="ventasproductos">Productos Facturados</a></li>
                      </ul>
                  </li>
									<li class="sub-menu">
				                      <a href="javascript:;" >
				                          <i class="fa fa-cubes"></i>
				                          <span>Almacen </span> <i class="fa fa-angle-double-right"></i>
				                      </a>
				                      <ul class="sub">
                          <li><a href="productos">Productos en Almacen</a></li>
				          <li><a href="kardex">Kardex General</a></li>
				          <li><a href="buscakardex">Kardex por Productos</a></li>
				                      </ul>
				                  </li>

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-briefcase"></i>
                          <span>Pagos a Créditos </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="forcreditos">Nuevo Pago Créditos</a></li>
                          <li><a href="creditos">Consultar Créditos</a></li>
                          <li><a href="creditosclientes">Créditos por Clientes</a></li>
                          <li><a href="creditosfechas">Créditos por Fechas</a></li>
                      </ul>
                  </li>

				  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-mortar-board"></i>
                          <span>Servicios </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="forservicios">Facturas Servicios</a></li>
                          <li><a href="servicios">Consultar Servicios</a></li>
						  <li><a href="detallesservicios">Detalles de Servicios</a></li>
                          <li><a href="serviciosfechas">Servicios por Fechas</a></li>
                          <li><a href="servicioscajas">Servicios por Cajas</a></li>
                          <li><a href="serviciosfacturados">Servicios Facturados</a></li>
                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class=" fa fa-bar-chart-o"></i>
                          <span>Estadisticas </span> <i class="fa fa-angle-double-right"></i>
                      </a>
                      <ul class="sub">
                          <li><a href="graficoventas">Estadisticas Ventas</a></li>
                          <li><a href="graficoservicios">Estadisticas Servicios</a></li>
                      </ul>
                  </li>

				  <li>
                      <a href="logout">
                          <i class="fa fa-power-off"></i>
                          <span>Cerrar Sessión</span>
                      </a>
                  </li>

    <!----- FIN DE MENU ----->


                  <?php } ?>

</body>
</html>
<?php } else { ?>
		<script type='text/javascript' language='javascript'>
	    alert('USTED NO TIENE ACCESO A ESTA PARTE DE LA PAGINA')
		document.location.href='logout.php'
        </script>
<?php } } else { ?>
		<script type='text/javascript' language='javascript'>
	    alert('USTED NO TIENE ACCESO A ESTA PAGINA')
		document.location.href='logout.php'
        </script>
<?php } ?>
