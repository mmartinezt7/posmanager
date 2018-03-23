<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

$ca = new Login();
$ca = $ca->CajerosPorId();

echo $hoy = "SERVICIOS_DESDE_".$_GET["desde"]."_HASTA_".$_GET["hasta"]."_CAJA_N°_".$ca[0]['nrocaja'];
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
           <th>Código de Servicio</th>
           <th>N° de Caja</th>
           <th>Fecha Servicio</th>
           <th>Servicio</th>
           <th>Subtotal</th>
           <th>Iva</th>
           <th>Descuento</th>
           <th>Total Pago</th>
         </tr>
<?php 
$ve = new Login();
$reg = $ve->BuscarServiciosCajas();
$serviciosTotal=0;
$pagoSubtotal=0;
$pagoIva=0;
$pagoDescuento=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$serviciosTotal+=$reg[$i]['cantidad'];
$pagoSubtotal+=$reg[$i]['subtotal']; 
$pagoIva+=$reg[$i]['totaliva']; 
$pagoDescuento+=$reg[$i]['totaldescuento'];  
$pagoTotal+=$reg[$i]['totalpago']; 
?>
         <tr class="even_row">
           <td style="text-align: center"><span class="Estilo15"><?php echo $a++; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['codservicio']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['nrocaja']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['fechaservicio']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['cantidad']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['totaliva'], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
         </tr>
        <?php } ?>
         <tr class="even_row">
           <td colspan="3" style="text-align: center">&nbsp;</td>
           <td style="text-align: center"><strong>Total General</strong></div></td>
           <td style="text-align: center"><strong><?php echo $serviciosTotal; ?></strong></td>
           <td style="text-align: center"><strong><?php echo number_format($pagoSubtotal, 2, '.', ','); ?></strong></td>
           <td style="text-align: center"><strong><?php echo number_format($pagoIva, 2, '.', ','); ?></strong></td>
           <td style="text-align: center"><strong><?php echo number_format($pagoDescuento, 2, '.', ','); ?></strong></td>
           <td style="text-align: center"><strong><?php echo number_format($pagoTotal, 2, '.', ','); ?></strong></td>
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
