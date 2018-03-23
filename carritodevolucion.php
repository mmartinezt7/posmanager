<?php
		//CARRITO DE ENTRADAS DE PRODUCTOS
		session_start();
		$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
		if($ObjetoCarrito->Codigo=="vaciar"){
			unset($_SESSION["CarritoDevolucion"]);  
		} else {
			if(isset($_SESSION['CarritoDevolucion'])){
					$carrito_devolucion=$_SESSION['CarritoDevolucion'];
					if(isset($ObjetoCarrito->Codigo)){
						$txtCodigo = $ObjetoCarrito->Codigo;
						$precio    = $ObjetoCarrito->Precio;
						$lote    = $ObjetoCarrito->Lote;
						$tipo    = $ObjetoCarrito->Tipo;
						$cantidad  = $ObjetoCarrito->Cantidad;
						$descripcio= $ObjetoCarrito->Descripcion;
						$existencia= $ObjetoCarrito->Existencia;
						$donde     = -1;
						for($i=0;$i<=count($carrito_devolucion)-1;$i ++){
	                    if($txtCodigo==$carrito_devolucion[$i]['txtCodigo'] && $lote==$carrito_devolucion[$i]['lote']){
							$donde=$i;
						  }
						}
						if($donde != -1){
							$cuanto=$carrito_devolucion[$donde]['cantidad'] + $cantidad;
							$carrito_devolucion[$donde]=array("txtCodigo"=>$txtCodigo,"precio"=>$precio,"lote"=>$lote,"tipo"=>$tipo,"cantidad"=>$cuanto,"descripcion"=>$descripcio,"existencia"=>$existencia);
						} else {
							$carrito_devolucion[]=array("txtCodigo"=>$txtCodigo,"precio"=>$precio,"lote"=>$lote,"tipo"=>$tipo,"cantidad"=>$cantidad,"descripcion"=>$descripcio,"existencia"=>$existencia);
						}
					}
			} else {
					$txtCodigo = $ObjetoCarrito->Codigo;
					$precio    = $ObjetoCarrito->Precio;
					$lote    = $ObjetoCarrito->Lote;
					$tipo    = $ObjetoCarrito->Tipo;
					$cantidad  = $ObjetoCarrito->Cantidad;
					$descripcio= $ObjetoCarrito->Descripcion;
					$existencia= $ObjetoCarrito->Existencia;
				$carrito_devolucion[]=array("txtCodigo"=>$txtCodigo,"precio"=>$precio,"lote"=>$lote,"tipo"=>$tipo,"cantidad"=>$cantidad,"descripcion"=>$descripcio,"existencia"=>$existencia);	
			}
			$_SESSION['CarritoDevolucion']=$carrito_devolucion;
			echo json_encode($_SESSION['CarritoDevolucion']);
	}
?>