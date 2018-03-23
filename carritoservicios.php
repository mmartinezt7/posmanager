<?php
		//CARRITO DE ENTRADAS DE PRODUCTOS
		session_start();
		$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
		if($ObjetoCarrito->Codigo=="vaciar"){
			unset($_SESSION["CarritoServicios"]);  
		} else {
			if(isset($_SESSION['CarritoServicios'])){
					$carrito_servicio=$_SESSION['CarritoServicios'];
					if(isset($ObjetoCarrito->Codigo)){
						$txtCodigo = $ObjetoCarrito->Codigo;
						$precio    = $ObjetoCarrito->Precio;
						$cantidad  = $ObjetoCarrito->Cantidad;
						$descripcio= $ObjetoCarrito->Descripcion;
						$donde     = -1;
						for($i=0;$i<=count($carrito_servicio)-1;$i ++){
						if($txtCodigo==$carrito_servicio[$i]['txtCodigo']){
							$donde=$i;
						  }
						}
						if($donde != -1){
							$cuanto=$carrito_servicio[$donde]['cantidad'] + $cantidad;
							$carrito_servicio[$donde]=array("txtCodigo"=>$txtCodigo,"precio"=>$precio,"cantidad"=>$cuanto,"descripcion"=>$descripcio);
						} else {
							$carrito_servicio[]=array("txtCodigo"=>$txtCodigo,"precio"=>$precio,"cantidad"=>$cantidad,"descripcion"=>$descripcio);
						}
					}
			} else {
					$txtCodigo = $ObjetoCarrito->Codigo;
					$precio    = $ObjetoCarrito->Precio;
					$cantidad  = $ObjetoCarrito->Cantidad;
					$descripcio= $ObjetoCarrito->Descripcion;
				$carrito_servicio[]=array("txtCodigo"=>$txtCodigo,"precio"=>$precio,"cantidad"=>$cantidad,"descripcion"=>$descripcio);	
			}
			$_SESSION['CarritoServicios']=$carrito_servicio;
			echo json_encode($_SESSION['CarritoServicios']);
	}
?>