<?php
	include('class.consultas.php');
	$filtro    = $_GET["term"];
	$Json      = new Json;
	$servicios  = $Json->BuscaServicios($filtro);
	echo  json_encode($servicios);
	
?>  