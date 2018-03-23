<?php
		//CARRITO DE ENTRADAS DE PRODUCTOS
		session_start();
		$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
		if($ObjetoCarrito->Codigo=="vaciar"){
			unset($_SESSION["CarritoVentas"]);  
		} else {
			if(isset($_SESSION['CarritoVentas'])){
					$carrito_venta=$_SESSION['CarritoVentas'];
					if(isset($ObjetoCarrito->Codigo)){
						$txtCodigo = $ObjetoCarrito->Codigo;
						$ivaproducto= $ObjetoCarrito->Ivaproducto;
						$precioconiva= $ObjetoCarrito->Precioconiva;
						$precio    = $ObjetoCarrito->Precio;
						$precio2    = $ObjetoCarrito->Precio2;
						$existencia    = $ObjetoCarrito->Existencia;
						$tipo    = $ObjetoCarrito->Tipo;
						$cantidad  = $ObjetoCarrito->Cantidad;
						$descripcio= $ObjetoCarrito->Descripcion;
						$donde     = -1;
						for($i=0;$i<=count($carrito_venta)-1;$i ++){
						if($txtCodigo==$carrito_venta[$i]['txtCodigo']){
							$donde=$i;
						  }
						}
						if($donde != -1){
							$cuanto=$carrito_venta[$donde]['cantidad'] + $cantidad;
$carrito_venta[$donde]=array("txtCodigo"=>$txtCodigo,"ivaproducto"=>$ivaproducto,"precioconiva"=>$precioconiva,"precio"=>$precio,"precio2"=>$precio2,"existencia"=>$existencia,"tipo"=>$tipo,"cantidad"=>$cuanto,"descripcion"=>$descripcio);
						} else {
$carrito_venta[]=array("txtCodigo"=>$txtCodigo,"ivaproducto"=>$ivaproducto,"precioconiva"=>$precioconiva,"precio"=>$precio,"precio2"=>$precio2,"existencia"=>$existencia,"tipo"=>$tipo,"cantidad"=>$cantidad,"descripcion"=>$descripcio);
						}
					}
			} else {
					$txtCodigo = $ObjetoCarrito->Codigo;
					$ivaproducto= $ObjetoCarrito->Ivaproducto;
					$precioconiva= $ObjetoCarrito->Precioconiva;
					$precio    = $ObjetoCarrito->Precio;
					$precio2    = $ObjetoCarrito->Precio2;
					$existencia    = $ObjetoCarrito->Existencia;
					$tipo    = $ObjetoCarrito->Tipo;
					$cantidad  = $ObjetoCarrito->Cantidad;
					$descripcio= $ObjetoCarrito->Descripcion;
$carrito_venta[]=array("txtCodigo"=>$txtCodigo,"ivaproducto"=>$ivaproducto,"precioconiva"=>$precioconiva,"precio"=>$precio,"precio2"=>$precio2,"existencia"=>$existencia,"tipo"=>$tipo,"cantidad"=>$cantidad,"descripcion"=>$descripcio);	
			}
			$_SESSION['CarritoVentas']=$carrito_venta;
			echo json_encode($_SESSION['CarritoVentas']);
	}
?>