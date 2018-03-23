<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

echo $hoy = "SERVICIOS_FACTURADOS_DESDE_".$_GET["desde"]."_HASTA_".$_GET["hasta"];
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
		  <th>C&oacute;digo</th>
		  <th>Nombre de Servicio</th>
		  <th>Costo de Servicio</th>
		  <th>Facturados</th>
		  <th>Monto Total</th>
         </tr>
<?php 
$ve = new Login();
$reg = $ve->BuscarServicios();
$serviciosTotal=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$serviciosTotal+=$reg[$i]['cantidad'];
$pagoTotal+=$reg[$i]['precioservicio']*$reg[$i]['cantidad']; 
?>         <tr class="even_row">
           <td style="text-align: center"><span class="Estilo15"><?php echo $a++; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['coditems']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['nombreitems']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]["precioservicio"], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['cantidad']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['precioservicio']*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
         </tr>
        <?php } ?>
         <tr class="even_row">
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><div align="center"><strong>Total General</strong></div></td>
                                                  <td><div align="center"><strong><?php echo $serviciosTotal; ?></strong></div></td>
                                                  <td><div align="center"><strong><?php echo number_format($pagoTotal, 2, '.', ','); ?></strong></div></td>
                                                </tr>
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
