<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

echo $hoy = "CREDITOS_FECHAS_".$_GET["desde"]."_HASTA_".$_GET["hasta"];
header("Content-Type: application/vnd.ms-excel"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$hoy.".xls");

$bon = new Login();
$bon = $bon->BuscarCreditosFechas();  
   
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
          <th colspan="11">Creditos por Fechas Desde <?php echo "<strong><font color='red'>".$_GET["desde"]." hasta ".$_GET["hasta"]."</font color></strong>"; ?></th>
        </tr>
        <tr>
                                  <th>N&deg;</th>
								  <th>Cédula de Cliente</th>
								  <th>Nombre de Cliente</th>
                                  <th>N&deg; de Caja</th>
                                  <th>Status Cr&eacute;dito</th>
								  <th>Dias Vencidos</th>
								  <th>C&oacute;digo de Venta</th>
                                  <th>Fecha Venta</th>
                                  <th>Total Factura</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                              </tr>
     	<?php 
$a=1;
$TotalFactura=0;
$TotalCredito=0;
$TotalDebe=0;
for($i=0;$i<sizeof($bon);$i++){  
$TotalFactura+=$bon[$i]['totalpago'];
$TotalCredito+=$bon[$i]['abonototal'];
$TotalDebe+=$bon[$i]['totalpago']-$bon[$i]['abonototal'];
?>
        <tr class="even_row">
                           <td style="text-align: center"><?php echo $a++; ?></td>
                           <td style="text-align: center"><?php echo $bon[$i]['cedcliente']; ?></td>
                           <td style="text-align: center"><?php echo $bon[$i]['nomcliente']; ?></td>
                           <td style="text-align: center"><?php echo $bon[$i]['nrocaja']; ?></td>
                          <td style="text-align: center"><span class="Estilo15"><?php 
if($bon[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>"; } 
elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "<span class='label label-success'>".$bon[$i]["statusventa"]."</span>"; } 
elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) { echo "<span class='label label-danger'>VENCIDA</span>"; } ?></span></td>
                          <td style="text-align: center"><span class="Estilo15"><?php 
if($bon[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
elseif($bon[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "0"; } 
elseif($bon[$i]['fechavencecredito'] < date("Y-m-d")) { echo Dias_Transcurridos(date("Y-m-d"),$bon[$i]['fechavencecredito']); } ?></span></td>
                           <td style="text-align: center"><?php echo $bon[$i]['codventa']; ?></td>
                           <td style="text-align: center"><?php echo $bon[$i]['fechaventa']; ?></td>
                           <td style="text-align: center"><?php echo number_format($bon[$i]['totalpago'], 2, '.', ','); ?></td>
                           <td style="text-align: center"><?php echo number_format($bon[$i]['abonototal'], 2, '.', ','); ?></td>
                           <td style="text-align: center"><?php echo number_format($bon[$i]['totalpago']-$bon[$i]['abonototal'], 2, '.', ','); ?></td>
                              </tr>
        <?php } ?>
         <tr class="even_row">
                              <td>&nbsp;</td>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td style="text-align: center"><strong>Total General</strong></td>
                              <td style="text-align: center"><strong><?php echo number_format($TotalFactura, 2, '.', ','); ?></strong></td>
                              <td style="text-align: center"><strong><?php echo number_format($TotalCredito, 2, '.', ','); ?></strong></td>
                              <td style="text-align: center"><strong><?php echo number_format($TotalDebe, 2, '.', ','); ?></strong></td>
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
