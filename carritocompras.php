<?php
		//CARRITO DE ENTRADAS DE PRODUCTOS
		session_start();
		$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
		if($ObjetoCarrito->Codigo=="vaciar"){
			unset($_SESSION["CarritoCompras"]);  
		} else {
			if(isset($_SESSION['CarritoCompras'])){
					$carrito_compra=$_SESSION['CarritoCompras'];
					if(isset($ObjetoCarrito->Codigo)){
						$txtCodigo = $ObjetoCarrito->Codigo;
						$ivaproducto= $ObjetoCarrito->Ivaproducto;
						$precioconiva= $ObjetoCarrito->Precioconiva;
						$precio    = $ObjetoCarrito->Precio;
						$precio2    = $ObjetoCarrito->Precio2;
						$vence    = $ObjetoCarrito->Vence;
						$tipo    = $ObjetoCarrito->Tipo;
						$cantidad  = $ObjetoCarrito->Cantidad;
						$descripcio= $ObjetoCarrito->Descripcion;
						$donde     = -1;
						for($i=0;$i<=count($carrito_compra)-1;$i ++){
						if($txtCodigo==$carrito_compra[$i]['txtCodigo']){
							$donde=$i;
						  }
						}
						if($donde != -1){
							$cuanto=$carrito_compra[$donde]['cantidad'] + $cantidad;
$carrito_compra[$donde]=array("txtCodigo"=>$txtCodigo,"ivaproducto"=>$ivaproducto,"precioconiva"=>$precioconiva,"precio"=>$precio,"precio2"=>$precio2,"vence"=>$vence,"tipo"=>$tipo,"cantidad"=>$cuanto,"descripcion"=>$descripcio);
						} else {
$carrito_compra[]=array("txtCodigo"=>$txtCodigo,"ivaproducto"=>$ivaproducto,"precioconiva"=>$precioconiva,"precio"=>$precio,"precio2"=>$precio2,"vence"=>$vence,"tipo"=>$tipo,"cantidad"=>$cantidad,"descripcion"=>$descripcio);
						}
					}
			} else {
					$txtCodigo = $ObjetoCarrito->Codigo;
					$ivaproducto= $ObjetoCarrito->Ivaproducto;
					$precioconiva= $ObjetoCarrito->Precioconiva;
					$precio    = $ObjetoCarrito->Precio;
					$precio2    = $ObjetoCarrito->Precio2;
					$vence    = $ObjetoCarrito->Vence;
					$tipo    = $ObjetoCarrito->Tipo;
					$cantidad  = $ObjetoCarrito->Cantidad;
					$descripcio= $ObjetoCarrito->Descripcion;
$carrito_compra[]=array("txtCodigo"=>$txtCodigo,"ivaproducto"=>$ivaproducto,"precioconiva"=>$precioconiva,"precio"=>$precio,"precio2"=>$precio2,"vence"=>$vence,"tipo"=>$tipo,"cantidad"=>$cantidad,"descripcion"=>$descripcio);	
			}
			$_SESSION['CarritoCompras']=$carrito_compra;
			echo json_encode($_SESSION['CarritoCompras']);
	}
?>