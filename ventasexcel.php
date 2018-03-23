<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

echo $hoy = "VENTAS_GENERALES";
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
           <th>Código de Venta</th>
           <th>Caja</th>
           <th>Clientes</th>
           <th>Status Venta</th>
           <th>Fecha Venta</th>
           <th>Articulos</th>
           <th>Subtotal con Iva</th>
           <th>Subtotal Iva 0%</th>
           <th>Iva</th>
           <th>Total Iva</th>
           <th>Descuento</th>
           <th>Total Desc</th>
           <th>Total Pago</th>
         </tr>
     	<?php 
$tra = new Login();
$reg = $tra->ListarVentas();
$totalarticulos=0;
$Subtotalconiva=0;
$Subtotalsiniva=0;
$Totaliva=0;
$Totaldescuento=0;
$pagoDescuento=0;
$Pagototal=0;
$a=1;
	
for($i=0;$i<sizeof($reg);$i++){
	
$totalarticulos+=$reg[$i]['articulos'];
$Subtotalconiva+=$reg[$i]['subtotalivasive'];
$Subtotalsiniva+=$reg[$i]['subtotalivanove'];
$Totaliva+=$reg[$i]['totalivave']; 
$Totaldescuento+=$reg[$i]['totaldescuentove']; 
$Pagototal+=$reg[$i]['totalpago']; 
?>
         <tr class="even_row">
           <td style="text-align: center"><span class="Estilo15"><?php echo $a++; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['codventa']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['nrocaja']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['nomcliente']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php 
if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='label label-success'>".$reg[$i]["statusventa"]."</span>"; } 
elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "<span class='label label-success'>".$reg[$i]["statusventa"]."</span>"; } 
elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { echo "<span class='label label-danger'>VENCIDA</span>"; } ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa'])); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['articulos']; ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['subtotalivasive'], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['subtotalivanove'], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['ivave'], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['totalivave'], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['descuentove'], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['totaldescuentove'], 2, '.', ','); ?></span></td>
           <td style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
         </tr>
        <?php } ?>
         <tr class="even_row">
           <td colspan="5" style="text-align: center">&nbsp;</td>
           <td style="text-align: center"><strong>Total General</strong></div></td>
           <td style="text-align: center"><strong><?php echo $totalarticulos; ?></strong></td>
           <td style="text-align: center"><strong><?php echo number_format($Subtotalconiva, 2, '.', ','); ?></strong></td>
           <td style="text-align: center"><strong><?php echo number_format($Subtotalsiniva, 2, '.', ','); ?></strong></td>
           <td style="text-align: center"></td>
           <td style="text-align: center"><strong><?php echo number_format($Totaliva, 2, '.', ','); ?></strong></td>
           <td style="text-align: center"></td>
           <td style="text-align: center"><strong><?php echo number_format($Totaldescuento, 2, '.', ','); ?></strong></td>
           <td style="text-align: center"><strong><?php echo number_format($Pagototal, 2, '.', ','); ?></strong></td>
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
