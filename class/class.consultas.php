<?php
require_once("classconexion.php");

class conectorDB extends Db
{
	public function __construct()
    {
        parent::__construct();
    } 	
	
	public function EjecutarSentencia($consulta, $valores = array()){  //funcion principal, ejecuta todas las consultas
		$resultado = false;
		
		if($statement = $this->dbh->prepare($consulta)){  //prepara la consulta
			if(preg_match_all("/(:\w+)/", $consulta, $campo, PREG_PATTERN_ORDER)){ //tomo los nombres de los campos iniciados con :xxxxx
				$campo = array_pop($campo); //inserto en un arreglo
				foreach($campo as $parametro){
					$statement->bindValue($parametro, $valores[substr($parametro,1)]);
				}
			}
			try {
				if (!$statement->execute()) { //si no se ejecuta la consulta...
					print_r($statement->errorInfo()); //imprimir errores
					return false;
				}
				$resultado = $statement->fetchAll(PDO::FETCH_ASSOC); //si es una consulta que devuelve valores los guarda en un arreglo.
				$statement->closeCursor();
			}
			catch(PDOException $e){
				echo "Error de ejecución: \n";
				print_r($e->getMessage());
			}	
		}
		return $resultado;
		$this->dbh = null; //cerramos la conexión
	} /// Termina funcion consultarBD
}/// Termina clase conectorDB

class Json
{
	private $json;
	public function BuscaProductos($filtro){
    $consulta = "SELECT DISTINCT CONCAT(producto) as label, codproducto, codcategoria, precioventa, preciocompra, ivaproducto, existencia FROM productos WHERE CONCAT(codproducto, '',producto) LIKE '%".$filtro."%' GROUP BY codproducto ASC LIMIT 0,10";
	
//$consulta = "SELECT CONCAT(productos.producto) as label, productos.codproducto, productos.codcategoria, productos.precioventa, detallecompras.precio1, productos.ivaproducto, productos.existencia FROM productos INNER JOIN detallecompras ON productos.codproducto=detallecompras.codproducto WHERE CONCAT(productos.codproducto, '',productos.producto) LIKE '%".$filtro."%' GROUP BY detallecompras.codproducto ASC LIMIT 0,20";
	
	
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	
	public function BuscaLotes($filtro){
    $consulta = "SELECT CONCAT(lote) as label, lote FROM compras WHERE CONCAT(lote) LIKE '%".$filtro."%' GROUP BY lote order by lote asc LIMIT 0,10";
			$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	
	public function BuscaServicios($filtro){
    $consulta = "SELECT CONCAT(nombreitems) as label, coditems, costoitems FROM items WHERE CONCAT(coditems, '',nombreitems) LIKE '%".$filtro."%' order by coditems asc LIMIT 0,10";
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	
	public function BuscaClientes($filtro){
		$consulta = "SELECT CONCAT(cedcliente, ': ',nomcliente) as label, codcliente FROM clientes WHERE CONCAT(cedcliente, '',nomcliente) LIKE '%".$filtro."%' order by codcliente asc LIMIT 0,10";
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	
}/// TERMINA CLASE  ///
?>