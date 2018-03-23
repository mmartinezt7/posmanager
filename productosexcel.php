<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="vendedor") {

$hoy = "PRODUCTOS_".date("Y-m-d");
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
     	 <?php
$tra = new Login();
$reg = $tra->ListarProductos();
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
  ?>
         <tr class="even_row">
           <td width="33" style="text-align: center"><span class="Estilo15"><?php echo $a++; ?></span></td>
           <td width="114" style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['codproducto']; ?></span></td>
           <td width="114" style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['producto']; ?></span></td>
           <td width="114" style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['codcategoria']; ?></span></td>
           <td width="114" style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]['existencia']; ?></span></td>
           <td width="112" style="text-align: center"><span class="Estilo15"><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></span></td>
           <td width="112" style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]["stockminimo"]; ?></span></td>
           <td width="128" style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]["codigobarra"]; ?></span></td>
		   <td width="128" style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]["ubicacion"]; ?></span></td>
		   <td width="128" style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]["ivaproducto"]; ?></span></td>
           <td width="128" style="text-align: center"><span class="Estilo15"><?php echo $reg[$i]["statusproducto"]; ?></span></td>
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
