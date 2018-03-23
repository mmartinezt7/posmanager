<?php
		//CARRITO DE ENTRADAS DE PRODUCTOS
		session_start();
		$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
		if($ObjetoCarrito->Codigo=="vaciar"){
			unset($_SESSION["CarritoPedidos"]);  
		} else {
			if(isset($_SESSION['CarritoPedidos'])){
					$carrito_pedido=$_SESSION['CarritoPedidos'];
					if(isset($ObjetoCarrito->Codigo)){
						$txtCodigo = $ObjetoCarrito->Codigo;
						$tipo    = $ObjetoCarrito->Tipo;
						$cantidad  = $ObjetoCarrito->Cantidad;
						$descripcio= $ObjetoCarrito->Descripcion;
						$donde     = -1;
						for($i=0;$i<=count($carrito_pedido)-1;$i ++){
						if($txtCodigo==$carrito_pedido[$i]['txtCodigo']){
							$donde=$i;
						  }
						}
						if($donde != -1){
							$cuanto=$carrito_pedido[$donde]['cantidad'] + $cantidad;
							$carrito_pedido[$donde]=array("txtCodigo"=>$txtCodigo,"tipo"=>$tipo,"cantidad"=>$cuanto,"descripcion"=>$descripcio);
						} else {
							$carrito_pedido[]=array("txtCodigo"=>$txtCodigo,"tipo"=>$tipo,"cantidad"=>$cantidad,"descripcion"=>$descripcio);
						}
					}
			} else {
					$txtCodigo = $ObjetoCarrito->Codigo;
					$tipo    = $ObjetoCarrito->Tipo;
					$cantidad  = $ObjetoCarrito->Cantidad;
					$descripcio= $ObjetoCarrito->Descripcion;
				$carrito_pedido[]=array("txtCodigo"=>$txtCodigo,"tipo"=>$tipo,"cantidad"=>$cantidad,"descripcion"=>$descripcio);	
			}
			$_SESSION['CarritoPedidos']=$carrito_pedido;
			echo json_encode($_SESSION['CarritoPedidos']);
	}
?>