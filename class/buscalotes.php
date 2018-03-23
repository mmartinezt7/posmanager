<?php
	include('class.consultas.php');
	$filtro    = $_GET["term"];
	$Json      = new Json;
	$lotes  = $Json->BuscaLotes($filtro);
	echo  json_encode($lotes);
	
?>  