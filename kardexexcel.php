<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

echo $hoy = "KARDEX_GENERAL";
header("Content-Type: application/vnd.ms-excel"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$hoy.".xls");  
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" id="Exportar_a_Excel">
  <tr>
    <td><table width="695" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>N°</th>
           <th>Movimiento</th>
           <th>Proveedor/Cliente</th>
           <th>Entradas</th>
           <th>Salidas</th>
           <th>Precio Costo</th>
           <th>Costo Movimiento</th>
           <th>Stock Actual</th>
           <th>Documento</th>
           <th>Fecha Kardex</th>
         </tr>
     	<?php 
$tra = new Login();
$reg = $tra->ListarKardexProductos();
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td style="text-align: center"><span class="Estilo15"><?php echo $a++; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['movimiento']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php if($reg[$i]["codresponsable"]=="0") { echo "INVENTARIO INICIAL"; } elseif($reg[$i]["movimiento"]=="ENTRADAS"){ echo $reg[$i]["proveedor"]; } elseif($reg[$i]["movimiento"]=="SALIDAS"){ echo $reg[$i]["clientes"]; } ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['entradas']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['salidas']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['preciounit'], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['costototal'], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['stockactual']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['documento']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo date("d-m-Y",strtotime($reg[$i]['fechakardex'])); ?></span></td>
         </tr>
        <?php } ?>
    </table>
    </td>
  </tr>
</table>
<?php } else { ?>	
		<script type='text/javascript' language='javascript'>
	    alert('USTED NO TIENE ACCESO A ESTA PARTE DE LA PAGINA, NO ERES EL ADMINISTRADOR')  
		document.location.href='logout.php'	 
        </script> 
<?php } } else { ?>
		<script type='text/javascript' language='javascript'>
	    alert('USTED NO TIENE ACCESO A ESTA PAGINA, DEBERA DE INICIAR SESION')  
		document.location.href='logout.php'	 
        </script> 
<?php } ?>
