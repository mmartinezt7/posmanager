<?php
require('fpdf.php');
 
class PDF extends FPDF
{
var $flowingBlockAttr;
	
############################################# FUNCION PARA MOSTRAR EL FOOTER ##########################################

   function FooterRR()
    {
        //Posición: a 2 cm del final
  $this->Ln();
  $this->SetY(-12);
  $this->SetFont('Arial','B',6);
        //Número de página
  $this->Cell(190,4,'Sistema de Control de Ventas y Facturacion "BOUTIQUE DE ZAPATERIA"','T',0,'L');
  $this->AliasNbPages();
  $this->Cell(0,4,'Pagina '.$this->PageNo(),'T',1,'R');
    } 
	
	
############################################# FIN DE FUNCION PARA MOSTRAR EL FOOTER ##########################################

############################################# FUNCION PARA MOSTRAR EL FOOTER ##########################################
	
	//Pie de página
   function Footer()
    {
  //Posición: a 2 cm del final
  $this->Ln();
  $this->SetY(-3);
  //Arial italic 8
  $this->SetFont('courier','B',7);
  //Número de página
  $con = new Login();
  $con = $con->ConfiguracionPorId();
	
  $this->Cell(195,-3,'TELÉFONO: '.$con[0]['tlfempresa'],'0',0,'L');
  $this->Ln();
  $this->Cell(195,-3,utf8_decode($con[0]['direcempresa']),'0',0,'L');
  $this->Ln();
  $this->Cell(195,-4,utf8_decode($con[0]['rifempresa']." - ".$con[0]['nomempresa']),'0',0,'L');
  $this->Ln();
  
  $this->AliasNbPages();
  $this->Cell(0,4,'Pagina '.$this->PageNo().'/{nb}','T',1,'R');
    }
############################################# FIN DE FUNCION PARA MOSTRAR EL FOOTER ##########################################











###################################################################### REPORTES DE MANTENIMIENTO ####################################################################
	
############################################### FUNCION LISTAR LOGS DE ACCESO DE USUARIOS ######################################################

	  function TablaListarLogs()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',16);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,25,'LISTADO GENERAL DE LOGS DE ACCESO DE USUARIOS',0,0,'C');
    //Salto de línea
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln();
	
	$this->Ln();
	$this->SetFont('courier','B',10);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->Cell(10,8,'N°',1,0,'C', True);
	$this->Cell(35,8,'IP',1,0,'C', True);
	$this->Cell(45,8,'TIEMPO ENTRADA',1,0,'C', True);
	$this->Cell(190,8,'NAVEGADOR DE ACCESO',1,0,'C', True);
	$this->Cell(50,8,'USUARIO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarLogs();
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(35,5,$reg[$i]["ip"],1,0,'C');
    $this->CellFitSpace(45,5,utf8_decode($reg[$i]["tiempo"]),1,0,'C');
    $this->CellFitSpace(190,5,utf8_decode($reg[$i]["detalles"]),1,0,'C');
	$this->CellFitSpace(50,5,utf8_decode($reg[$i]["usuario"]),1,0,'C');
    $this->Ln();
	
   }
  $this->Ln(15); 
  $this->SetFont('courier','B',9);
  $this->Cell(250,0,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]).'                        RECIBIDO POR:______________________________________','',1,'C');
  $this->Ln(4);
     }
	

############################################### FIN DE FUNCION LISTAR LOGS DE ACCESO DE USUARIOS ######################################################


############################################### FUNCION LISTAR CAJAS DE VENTAS ######################################################

	  function TablaListarCajas()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',15);
    //Movernos a la derecha
    $this->Cell(100);
    //Título
    $this->Cell(65,20,'LISTADO GENERAL DE CAJAS DE VENTAS',0,0,'C');
    //Salto de línea
    $this->Ln(25);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA GERENTE: ',0,0,'');
	$this->Cell(44,5,$con[0]['cedresponsable'],0,0,'');
	$this->Cell(30,5,'NOMBRE GERENTE:',0,0,'');
	$this->Cell(83,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO GERENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->Cell(30,5,'CORREO GERENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',10);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->Cell(10,8,'N°',1,0,'C', True);
	$this->Cell(25,8,'N° CAJA',1,0,'C', True);
	$this->Cell(45,8,'NOMBRE DE CAJA',1,0,'C', True);
	$this->Cell(40,8,'CÉDULA CAJERO',1,0,'C', True);
	$this->Cell(70,8,'NOMBRE CAJERO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarCajas();
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(25,5,utf8_decode($reg[$i]["nrocaja"]),1,0,'C');
    $this->CellFitSpace(45,5,utf8_decode($reg[$i]["nombrecaja"]),1,0,'C');
    $this->CellFitSpace(40,5,utf8_decode($reg[$i]["cedula"]),1,0,'C');
	$this->CellFitSpace(70,5,utf8_decode($reg[$i]["nombres"]),1,0,'C');
    $this->Ln();
	
   }
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(60,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(60,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR CAJAS DE VENTAS ######################################################


############################################### FUNCION LISTAR RETIRO DE EFECTIVO ######################################################
	  function TablaListarRetiro()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',11);
    //Movernos a la derecha
    $this->Cell(100);
    //Título
    $this->Cell(65,20,'LISTADO GENERAL DE RETIRO DE EFECTIVO EN CAJAS',0,0,'C');
    //Salto de línea
    $this->Ln(25);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA GERENTE: ',0,0,'');
	$this->Cell(44,5,$con[0]['cedresponsable'],0,0,'');
	$this->Cell(30,5,'NOMBRE GERENTE:',0,0,'');
	$this->Cell(83,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO GERENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->Cell(30,5,'CORREO GERENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',10);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->Cell(10,8,'N°',1,0,'C', True);
	$this->Cell(25,8,'N° CAJA',1,0,'C', True);
	$this->Cell(95,8,'MOTIVO DE RETIRO',1,0,'C', True);
	$this->Cell(25,8,'MONTO',1,0,'C', True);
	$this->Cell(35,8,'FECHA RETIRO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarRetiro();
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(25,5,utf8_decode($reg[$i]['nrocaja']),1,0,'C');
    $this->CellFitSpace(95,5,utf8_decode($reg[$i]['motivoretiro']),1,0,'C');
    $this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]['cantretiro'], 2, '.', '.')),1,0,'C');
	$this->CellFitSpace(35,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fecharetiro']))),1,0,'C');
    $this->Ln();
	
   }
   
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(60,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(60,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR RETIRO DE EFECTIVO ######################################################


############################################### FUNCION LISTAR PRODUTOS EN ALMACEN ######################################################
	  function TablaListarProductos()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',18);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,25,'LISTADO GENERAL DE PRODUCTOS',0,0,'C');
    //Salto de línea
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln();
	
	$this->Ln();
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(20,8,'CÓDIGO',1,0,'C', True);
	$this->CellFitSpace(90,8,'DESCRIPCION',1,0,'C', True);
	$this->CellFitSpace(25,8,'CATEGORIA',1,0,'C', True);
	$this->CellFitSpace(30,8,'PRECIO',1,0,'C', True);
	$this->CellFitSpace(25,8,'EXISTENCIA',1,0,'C', True);
	$this->CellFitSpace(25,8,'COSTO TOTAL',1,0,'C', True);
	$this->CellFitSpace(20,8,'STOCK MIN',1,0,'C', True);
	$this->CellFitSpace(40,8,'UBICACIÓN',1,0,'C', True);
	$this->CellFitSpace(25,8,'CÓD BARRA',1,0,'C', True);
	$this->CellFitSpace(20,8,'STATUS',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarProductos();
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(20,5,$reg[$i]["codproducto"],1,0,'C');
    $this->CellFitSpace(90,5,utf8_decode($reg[$i]["producto"]),1,0,'C');
	$this->CellFitSpace(25,5,utf8_decode($reg[$i]["nomcategoria"]),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]["precioventa"], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(25,5,utf8_decode($reg[$i]["existencia"]),1,0,'C');
    $this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]["precioventa"]*$reg[$i]["existencia"], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode($reg[$i]["stockminimo"]),1,0,'C');
	$this->Cell(40,5,utf8_decode($reg[$i]["ubicacion"]),1,0,'C');
	$this->Cell(25,5,utf8_decode($reg[$i]["codigobarra"]),1,0,'C');
    $this->CellFitSpace(20,5,utf8_decode($reg[$i]["statusproducto"]),1,0,'C');
    $this->Ln();
	
   }
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR PRODUCTOS EN ALMACEN ######################################################

############################################### FUNCION LISTAR PRODUTOS VENDIDOS ######################################################
	  function TablaListarProductosVendidos()
   {
       //Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',12);
    //Movernos a la derecha
    $this->Cell(100);
    //Título
    $this->Cell(65,20,'LISTADO GENERAL DE PRODUCTOS VENDIDOS',0,0,'C');
    //Salto de línea
    $this->Ln(25);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA GERENTE: ',0,0,'');
	$this->Cell(44,5,$con[0]['cedresponsable'],0,0,'');
	$this->Cell(30,5,'NOMBRE GERENTE:',0,0,'');
	$this->Cell(83,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO GERENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->Cell(30,5,'CORREO GERENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(18,8,'CÓDIGO',1,0,'C', True);
	$this->CellFitSpace(68,8,'DESCRIPCION',1,0,'C', True);
	$this->CellFitSpace(20,8,'CATEGORIA',1,0,'C', True);
	$this->CellFitSpace(20,8,'PRECIO',1,0,'C', True);
	$this->CellFitSpace(18,8,'VENDIDO',1,0,'C', True);
	$this->CellFitSpace(25,8,'COSTO TOTAL',1,0,'C', True);
	$this->CellFitSpace(15,8,'EXISTE',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarProductosVendidos();
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(18,5,$reg[$i]["codproducto"],1,0,'C');
    $this->CellFitSpace(68,5,utf8_decode($reg[$i]["producto"]),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode($reg[$i]["nomcategoria"]),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode(number_format($reg[$i]["precioventa"], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(18,5,utf8_decode($nro = ( $reg[$i]["cantidad"] == '' ? "0" : $reg[$i]["cantidad"])),1,0,'C');
    $this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]["precioventa"]*$reg[$i]["cantidad"], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(15,5,utf8_decode($reg[$i]["existencia"]),1,0,'C');
    $this->Ln();
	
   }
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(60,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(60,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR PRODUCTOS VENDIDOS ######################################################


############################################### FUNCION LISTAR PRODUTOS EN STOCK MINIMO ######################################################
	  function ListarProductosStockMinimo()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',16);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,25,'LISTADO GENERAL DE PRODUCTOS EN STOCK MINIMO',0,0,'C');
    //Salto de línea
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln();
	
	$this->Ln();
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(20,8,'CÓDIGO',1,0,'C', True);
	$this->CellFitSpace(90,8,'DESCRIPCION',1,0,'C', True);
	$this->CellFitSpace(30,8,'CATEGORIA',1,0,'C', True);
	$this->CellFitSpace(30,8,'PRECIO',1,0,'C', True);
	$this->CellFitSpace(25,8,'EXISTENCIA',1,0,'C', True);
	$this->CellFitSpace(35,8,'STOCK MINIMO',1,0,'C', True);
	$this->CellFitSpace(40,8,'UBICACIÓN',1,0,'C', True);
	$this->CellFitSpace(25,8,'CÓD BARRA',1,0,'C', True);
	$this->CellFitSpace(25,8,'STATUS',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarProductosStockMinimo();
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(20,5,$reg[$i]["codproducto"],1,0,'C');
    $this->CellFitSpace(90,5,utf8_decode($reg[$i]["producto"]),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode($reg[$i]["nomcategoria"]),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]["precioventa"], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(25,5,utf8_decode($reg[$i]["existencia"]),1,0,'C');
	$this->CellFitSpace(35,5,utf8_decode($reg[$i]["stockminimo"]),1,0,'C');
	$this->Cell(40,5,utf8_decode($reg[$i]["ubicacion"]),1,0,'C');
	$this->Cell(25,5,utf8_decode($reg[$i]["codigobarra"]),1,0,'C');
    $this->CellFitSpace(25,5,utf8_decode($reg[$i]["statusproducto"]),1,0,'C');
    $this->Ln();
	
   }
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ######################################################



############################################### FUNCION LISTAR KARDEX POR PRODUCTOS######################################################
	  function TablaKardexProductos()
   {
       //Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',18);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,25,'LISTADO GENERAL DE KARDEX POR PRODUCTO',0,0,'C');
    //Salto de línea
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$kardex = new Login();
    $kardex = $kardex->BuscarKardexProducto();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(35,8,'MOVIMIENTO',1,0,'C', True);
	$this->CellFitSpace(20,8,'ENTRADAS',1,0,'C', True);
	$this->CellFitSpace(20,8,'SALIDAS',1,0,'C', True);
	$this->CellFitSpace(40,8,'PRECIO COSTO',1,0,'C', True);
	$this->CellFitSpace(40,8,'COSTO MOVIMIENTO',1,0,'C', True);
	$this->CellFitSpace(20,8,'STOCK ACTUAL',1,0,'C', True);
	$this->CellFitSpace(110,8,'DOCUMENTO',1,0,'C', True);
	$this->CellFitSpace(40,8,'FECHA',1,1,'C', True);
	
   $TotalEntradas=0;
   $TotalSalidas=0;
   $a=1;
   for($i=0;$i<sizeof($kardex);$i++){ 
   $TotalEntradas+=$kardex[$i]['entradas'];
   $TotalSalidas+=$kardex[$i]['salidas']; 
	
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(35,5,$kardex[$i]['movimiento'],1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode($kardex[$i]['entradas']),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode($kardex[$i]['salidas']),1,0,'C');
	$this->CellFitSpace(40,5,utf8_decode(number_format($kardex[$i]['preciounit'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(40,5,utf8_decode(number_format($kardex[$i]['costototal'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode($kardex[$i]['stockactual']),1,0,'C');
	$this->CellFitSpace(110,5,utf8_decode($kardex[$i]['documento']),1,0,'C');
	$this->CellFitSpace(40,5,utf8_decode(date("d-m-Y h:i:s",strtotime($kardex[$i]['fechakardex']))),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(325,5,'',0,0,'C');
	$this->Ln();
	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(120,5,'DETALLES DEL PRODUCTO',1,0,'C', True);
	$this->Ln();
	
    $this->Cell(35,5,'CÓDIGO',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['codproducto']),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'DESCRIPCIÓN',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['producto']),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'CATEGORIA',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['nomcategoria']),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'ENTRADAS',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($TotalEntradas),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'SALIDAS',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($TotalSalidas),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'EXISTENCIA',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['existencia']),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'PRECIO COMPRA',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['preciocompra']),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'PRECIO VENTA',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['precioventa']),1,0,'C');
   
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR KARDEX POR PRODUCTOS ######################################################


############################################### FUNCION LISTAR KARDEX GENERAL ######################################################
	  function TablaKardexGeneral()
   {
       //Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',18);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,25,'LISTADO GENERAL DE KARDEX',0,0,'C');
    //Salto de línea
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$kardex = new Login();
    $kardex = $kardex->ListarKardexProductos();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(25,8,'MOVIMIENTO',1,0,'C', True);
	$this->CellFitSpace(55,8,'PROVEEDOR/CLIENTE',1,0,'C', True);
	$this->CellFitSpace(20,8,'ENTRADAS',1,0,'C', True);
	$this->CellFitSpace(20,8,'SALIDAS',1,0,'C', True);
	$this->CellFitSpace(28,8,'PRECIO COSTO',1,0,'C', True);
	$this->CellFitSpace(32,8,'COSTO MOVIMIENTO',1,0,'C', True);
	$this->CellFitSpace(20,8,'STOCK ACTUAL',1,0,'C', True);
	$this->CellFitSpace(80,8,'DOCUMENTO',1,0,'C', True);
	$this->CellFitSpace(40,8,'FECHA KARDEX',1,1,'C', True);
	
   $TotalEntradas=0;
   $TotalSalidas=0;
   $a=1;
   for($i=0;$i<sizeof($kardex);$i++){ 
   $TotalEntradas+=$kardex[$i]['entradas'];
   $TotalSalidas+=$kardex[$i]['salidas']; 
	
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(25,5,$kardex[$i]['movimiento'],1,0,'C');
	
	if($kardex[$i]["codresponsable"]=="0") { 
	$this->CellFitSpace(55,5,"INVENTARIO INICIAL",1,0,'C'); 
	} elseif($kardex[$i]["movimiento"]=="ENTRADAS"){ 
	$this->CellFitSpace(55,5,utf8_decode($kardex[$i]['proveedor']),1,0,'C');
	} elseif($kardex[$i]["movimiento"]=="SALIDAS"){ 
	$this->CellFitSpace(55,5,utf8_decode($kardex[$i]['clientes']),1,0,'C');
    }
		
	$this->CellFitSpace(20,5,utf8_decode($kardex[$i]['entradas']),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode($kardex[$i]['salidas']),1,0,'C');
	$this->CellFitSpace(28,5,utf8_decode(number_format($kardex[$i]['preciounit'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(32,5,utf8_decode(number_format($kardex[$i]['costototal'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode($kardex[$i]['stockactual']),1,0,'C');
	$this->CellFitSpace(80,5,utf8_decode($kardex[$i]['documento']),1,0,'C');
	$this->CellFitSpace(40,5,utf8_decode(date("d-m-Y h:i:s",strtotime($kardex[$i]['fechakardex']))),1,0,'C');
    $this->Ln();
	
   } 
   
	/*$this->Cell(325,5,'',0,0,'C');
	$this->Ln();
	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(120,5,'DETALLES DEL PRODUCTO',1,0,'C', True);
	$this->Ln();
	
    $this->Cell(35,5,'CÓDIGO',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['codproducto']),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'DESCRIPCIÓN',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['producto']),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'CATEGORIA',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['nomcategoria']),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'ENTRADAS',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($TotalEntradas),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'SALIDAS',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($TotalSalidas),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'EXISTENCIA',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['existencia']),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'PRECIO COMPRA',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['preciocompra']),1,0,'C');
	$this->Ln();
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(35,5,'PRECIO VENTA',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode($kardex[0]['precioventa']),1,0,'C');*/
   
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR KARDEX GENERAL ######################################################



############################################### FUNCION LISTAR ITEMS DE SERVICIOS ######################################################
    function TablaListarItems()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',15);
    //Movernos a la derecha
    $this->Cell(100);
    //Título
    $this->Cell(65,20,'LISTADO GENERAL DE SERVICIOS',0,0,'C');
    //Salto de línea
    $this->Ln(25);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA GERENTE: ',0,0,'');
	$this->Cell(44,5,$con[0]['cedresponsable'],0,0,'');
	$this->Cell(30,5,'NOMBRE GERENTE:',0,0,'');
	$this->Cell(83,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO GERENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->Cell(30,5,'CORREO GERENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
		
	$this->SetFont('courier','B',10);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->Cell(10,8,'N°',1,0,'C', True);
	$this->Cell(20,8,'CÓDIGO',1,0,'C', True);
	$this->Cell(120,8,'NOMBRE DE ITEMS',1,0,'C', True);
	$this->Cell(25,8,'COSTO',1,0,'C', True);
	$this->Cell(18,8,'STATUS',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarItems();
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode($reg[$i]["coditems"]),1,0,'C');
    $this->CellFitSpace(120,5,utf8_decode($reg[$i]["nombreitems"]),1,0,'C');
	$this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]["costoitems"], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(18,5,utf8_decode($reg[$i]["statusitems"]),1,0,'C');
    $this->Ln();
	
   }
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(60,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(60,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR ITEMS DE SERVICIOS ######################################################

	
############################################### FUNCION LISTAR CLIENTES ######################################################
	  function TablaListarClientes()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',18);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,25,'LISTADO GENERAL DE CLIENTES',0,0,'C');
    //Salto de línea
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln();
	
	$this->Ln();
	$this->SetFont('courier','B',10);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->Cell(10,8,'N°',1,0,'C', True);
	$this->Cell(35,8,'CÉDULA',1,0,'C', True);
	$this->Cell(70,8,'NOMBRES',1,0,'C', True);
	$this->Cell(110,8,'DIRECCIÓN DOMICILIARIA',1,0,'C', True);
	$this->Cell(35,8,'N° TELÉFONO',1,0,'C', True);
	$this->Cell(75,8,'CORREO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarClientes();
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(35,5,utf8_decode($reg[$i]["cedcliente"]),1,0,'C');
    $this->CellFitSpace(70,5,utf8_decode($reg[$i]["nomcliente"]),1,0,'C');
    $this->CellFitSpace(110,5,utf8_decode($reg[$i]["direccliente"]),1,0,'C');
	$this->Cell(35,5,utf8_decode($reg[$i]["tlfcliente"]),1,0,'C');
	$this->Cell(75,5,utf8_decode($reg[$i]["emailcliente"]),1,0,'C');
    $this->Ln();
	
   }
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR CLIENTES ######################################################


############################################### FUNCION LISTAR PROVEEDORES ######################################################
	  function TablaListarProveedores()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',18);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,25,'LISTADO GENERAL DE PROVEEDORES',0,0,'C');
    //Salto de línea
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln();
	
	$this->Ln();
	$this->SetFont('courier','B',10);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->Cell(10,8,'N°',1,0,'C', True);
	$this->Cell(28,8,'CÉDULA',1,0,'C', True);
	$this->Cell(70,8,'NOMBRES',1,0,'C', True);
	$this->Cell(65,8,'DIRECCIÓN DOMICILIARIA',1,0,'C', True);
	$this->Cell(32,8,'N° TELÉFONO',1,0,'C', True);
	$this->Cell(75,8,'CORREO',1,0,'C', True);
	$this->Cell(55,8,'CONTACTO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarProveedores();
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(28,5,utf8_decode($reg[$i]["ritproveedor"]),1,0,'C');
    $this->CellFitSpace(70,5,utf8_decode($reg[$i]["nomproveedor"]),1,0,'C');
    $this->CellFitSpace(65,5,utf8_decode($reg[$i]["direcproveedor"]),1,0,'C');
	$this->Cell(32,5,utf8_decode($reg[$i]["tlfproveedor"]),1,0,'C');
	$this->Cell(75,5,utf8_decode($reg[$i]["emailproveedor"]),1,0,'C');
	$this->Cell(55,5,utf8_decode($reg[$i]["contactoproveedor"]),1,0,'C');
    $this->Ln();
	
   }
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR PROVEEDORES ######################################################

###################################################################### REPORTES DE MANTENIMIENTO ####################################################################


































##################################################################### CLASE PEDIDOS DE PRODUCTOS ####################################################################

############################################### FUNCION LISTAR FACTURA DE PEDIDOS DE PRODUCTOS ######################################################
	  function TablaPedidosProductos()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 15 ,10, 55 , 17 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',15);
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$pe = new Login();
    $pe = $pe->PedidosPorId();
	
################################################# BLOQUE N° 1 ###################################################	

   //Bloque de membrete principal
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 10, 190, 17, '1.5', '');
	
	//Bloque de membrete principal
    $this->SetFillColor(199);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(98, 12, 12, 12, '1.5', 'F');
	//Bloque de membrete principal
    $this->SetFillColor(199);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(98, 12, 12, 12, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',16);
    $this->SetXY(101, 14);
    $this->Cell(20, 5, 'P', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(98, 19);
    $this->Cell(20, 5, 'Pedido', 0 , 0);
	
	
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',11);
    $this->SetXY(135, 12);
    $this->Cell(20, 5, 'N° PEDIDO ', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(165, 12);
    $this->Cell(20, 5,utf8_decode($pe[0]['codpedido']), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 16);
    $this->Cell(20, 5, 'FECHA PEDIDO ', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 16);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y h:i:s",strtotime($pe[0]['fechapedido']))), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 20);
    $this->Cell(20, 5, 'FECHA EMISIÓN', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 20);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y h:i:s")), 0 , 0);
	
	
################################################# BLOQUE N° 2 ###################################################	

	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 29, 190, 18, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(15, 30);
    $this->Cell(20, 5, 'DATOS DE LA EMPRESA ', 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 34);
    $this->Cell(20, 5, 'RAZÓN SOCIAL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(40, 34);
    $this->Cell(20, 5,utf8_decode($con[0]['nomempresa']), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',7);
    $this->SetXY(147, 34);
    $this->Cell(90, 5, 'RIF :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(156, 34);
    $this->Cell(90, 5,utf8_decode($con[0]['rifempresa']), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 38);
    $this->Cell(20, 5, 'DIRECCIÓN :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(32, 38);
    $this->Cell(20, 5,utf8_decode($con[0]['direcempresa']), 0 , 0);
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',7);
    $this->SetXY(140, 38);
    $this->Cell(20, 5, 'TELÉFONO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(156, 38);
    $this->Cell(20, 5,utf8_decode($con[0]['tlfempresa']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 42);
    $this->Cell(20, 5, 'GERENTE :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(30, 42);
    $this->Cell(20, 5,utf8_decode($con[0]['nomresponsable']), 0 , 0);
	//Linea de membrete Nro 7
	$this->SetFont('courier','B',7);
    $this->SetXY(94, 42);
    $this->Cell(20, 5, 'CÉDULA :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(108, 42);
    $this->Cell(20, 5,utf8_decode($con[0]['cedresponsable']), 0 , 0);
	//Linea de membrete Nro 8
	$this->SetFont('courier','B',7);
    $this->SetXY(130, 42);
    $this->Cell(20, 5, 'EMAIL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(142, 42);
    $this->Cell(20, 5,utf8_decode($con[0]['correoresponsable']), 0 , 0);
	
################################################# BLOQUE N° 3 ###################################################	

	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 49, 190, 14, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(15, 50);
    $this->Cell(20, 5, 'DATOS DEL PROVEEDOR ', 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 54);
    $this->Cell(20, 5, 'RAZÓN SOCIAL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(36, 54);
    $this->Cell(20, 5,utf8_decode($pe[0]['nomproveedor']), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',7);
    $this->SetXY(100, 54);
    $this->Cell(70, 5, 'RIF :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(108, 54);
    $this->Cell(75, 5,utf8_decode($pe[0]['ritproveedor']), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',7);
    $this->SetXY(130, 54);
    $this->Cell(90, 5, 'EMAIL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(142, 54);
    $this->Cell(90, 5,utf8_decode($pe[0]['emailproveedor']), 0 , 0);
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 58);
    $this->Cell(20, 5, 'DIRECCIÓN :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(33, 58);
    $this->Cell(20, 5,utf8_decode($pe[0]['direcproveedor']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(90, 58);
    $this->Cell(20, 5, 'TELÉFONO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(108, 58);
    $this->Cell(20, 5,utf8_decode($pe[0]['tlfproveedor']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(130, 58);
    $this->Cell(20, 5, 'CONTACTO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(150, 58);
    $this->Cell(20, 5,utf8_decode($pe[0]['contactoproveedor']), 0 , 0);
	
	$this->Ln(7);
	$this->SetFont('courier','B',10);
	$this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS
	$this->Cell(8,8,'N°',1,0,'C', True);
	$this->Cell(28,8,'CÓDIGO',1,0,'C', True);
	$this->Cell(97,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
	$this->Cell(35,8,'CATEGORIA',1,0,'C', True);
	$this->Cell(22,8,'CANTIDAD',1,1,'C', True);
	
	################################################# BLOQUE N° 4 DE DETALLES DE PRODUCTOS ###################################################	
	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 75, 190, 180, '1.5', '');
	
    $this->Ln(3);
    $tra = new Login();
    $reg = $tra->VerDetallesPedidos();
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(8,4,$a++,0,0,'C');
	$this->CellFitSpace(28,4,utf8_decode($reg[$i]["codproducto"]),0,0,'C');
    $this->CellFitSpace(97,4,utf8_decode($reg[$i]["producto"]),0,0,'C');
    $this->CellFitSpace(35,4,utf8_decode($reg[$i]["nomcategoria"]),0,0,'C');
	$this->CellFitSpace(22,4,utf8_decode($reg[$i]["cantpedido"]),0,0,'C');
    $this->Ln();
	
   }
   
  $this->Ln(175); 
  $this->SetFont('courier','B',9);
  $this->Cell(190,0,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]).'         RECIBIDO POR:___________________________','',1,'C');
  $this->Ln(4);
     }
	

############################################### FIN DE FUNCION FACTURA DE PEDIDOS DE PRODUCTOS ######################################################

##################################################################### CLASE PEDIDOS DE PRODUCTOS ####################################################################











































##################################################################### CLASE COMPRAS DE PRODUCTOS ####################################################################

############################################### FUNCION LISTAR FACTURA DE COMPRAS DE PRODUCTOS ######################################################
	  function TablaComprasProductos()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 15 ,10, 55 , 18 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',15);
    //Movernos a la derecha
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$co = new Login();
    $co = $co->ComprasPorId();
	
################################################# BLOQUE N° 1 ###################################################	

   //Bloque de membrete principal
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 10, 190, 20, '1.5', '');
	
	//Bloque de membrete principal
    $this->SetFillColor(199);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(98, 14, 12, 12, '1.5', 'F');
	//Bloque de membrete principal
    $this->SetFillColor(199);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(98, 14, 12, 12, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',16);
    $this->SetXY(101, 14);
    $this->Cell(20, 5, 'C', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(98, 19);
    $this->Cell(20, 5, 'Compra', 0 , 0);
	
	
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 10);
    $this->Cell(20, 5, 'N° COMPRA ', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(165, 10);
    $this->Cell(20, 5,utf8_decode($co[0]['codcompra']), 0 , 0);
	
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 13);
    $this->Cell(20, 5, 'N° SERIE ', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(165, 13);
    $this->Cell(20, 5,utf8_decode($co[0]['codseriec']), 0 , 0);
	
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 16);
    $this->Cell(20, 5, 'N° AUTORIZACIÓN ', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(165, 16);
    $this->Cell(20, 5,utf8_decode($co[0]['codautorizacionc']), 0 , 0);
	
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 19);
    $this->Cell(20, 5, 'FECHA COMPRA ', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 19);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y h:i:s",strtotime($co[0]['fechacompra']))), 0 , 0);
	
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 22);
    $this->Cell(20, 5, 'FECHA EMISIÓN', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 22);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y h:i:s")), 0 , 0);
	
	$dias = ( $co[0]['fechavencecredito'] == '0000-00-00' ? "0" : Dias_Transcurridos($co[0]['fechavencecredito'],date("Y-m-d")));
	
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 25);
    $this->Cell(20, 5, 'STATUS COMPRA', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 25);
    
	if($co[0]['fechavencecredito']== '0000-00-00') { 
	$this->Cell(20, 5,utf8_decode($co[0]['statuscompra']), 0 , 0);
	} elseif($co[0]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->Cell(20, 5,utf8_decode($co[0]['statuscompra']), 0 , 0);
	} elseif($co[0]['fechavencecredito'] < date("Y-m-d")) { 
	$this->Cell(20, 5,utf8_decode("VENCIDA"), 0 , 0);
	}


	
	
################################################# BLOQUE N° 2 ###################################################	

	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 32, 190, 18, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(15, 32);
    $this->Cell(20, 5, 'DATOS DE LA EMPRESA ', 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 36);
    $this->Cell(20, 5, 'RAZÓN SOCIAL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(40, 36);
    $this->Cell(20, 5,utf8_decode($con[0]['nomempresa']), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',7);
    $this->SetXY(147, 36);
    $this->Cell(90, 5, 'RIF :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(156, 36);
    $this->Cell(90, 5,utf8_decode($con[0]['rifempresa']), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 40);
    $this->Cell(20, 5, 'DIRECCIÓN :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(32, 40);
    $this->Cell(20, 5,utf8_decode($con[0]['direcempresa']), 0 , 0);
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',7);
    $this->SetXY(140, 40);
    $this->Cell(20, 5, 'TELÉFONO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(156, 40);
    $this->Cell(20, 5,utf8_decode($con[0]['tlfempresa']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 44);
    $this->Cell(20, 5, 'GERENTE :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(30, 44);
    $this->Cell(20, 5,utf8_decode($con[0]['nomresponsable']), 0 , 0);
	//Linea de membrete Nro 7
	$this->SetFont('courier','B',7);
    $this->SetXY(94, 44);
    $this->Cell(20, 5, 'CÉDULA :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(108, 44);
    $this->Cell(20, 5,utf8_decode($con[0]['cedresponsable']), 0 , 0);
	//Linea de membrete Nro 8
	$this->SetFont('courier','B',7);
    $this->SetXY(130, 44);
    $this->Cell(20, 5, 'EMAIL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(142, 44);
    $this->Cell(20, 5,utf8_decode($con[0]['correoresponsable']), 0 , 0);
	
################################################# BLOQUE N° 3 ###################################################	

	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 52, 190, 14, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(15, 52);
    $this->Cell(20, 5, 'DATOS DEL PROVEEDOR ', 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 56);
    $this->Cell(20, 5, 'RAZÓN SOCIAL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(36, 56);
    $this->Cell(20, 5,utf8_decode($co[0]['nomproveedor']), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',7);
    $this->SetXY(100, 56);
    $this->Cell(70, 5, 'RIF :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(108, 56);
    $this->Cell(75, 5,utf8_decode($co[0]['ritproveedor']), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',7);
    $this->SetXY(130, 56);
    $this->Cell(90, 5, 'EMAIL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(142, 56);
    $this->Cell(90, 5,utf8_decode($co[0]['emailproveedor']), 0 , 0);
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 60);
    $this->Cell(20, 5, 'DIRECCIÓN :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(33, 60);
    $this->Cell(20, 5,utf8_decode($co[0]['direcproveedor']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(90, 60);
    $this->Cell(20, 5, 'TELÉFONO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(108, 60);
    $this->Cell(20, 5,utf8_decode($co[0]['tlfproveedor']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(130, 60);
    $this->Cell(20, 5, 'CONTACTO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(150, 60);
    $this->Cell(20, 5,utf8_decode($co[0]['contactoproveedor']), 0 , 0);
	
	$this->Ln(8);
	$this->SetFont('courier','B',9);
	$this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
	$this->Cell(6,8,'N°',1,0,'C', True);
	$this->Cell(15,8,'CÓDIGO',1,0,'C', True);
	$this->Cell(50,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
	$this->Cell(22,8,'CATEGORIA',1,0,'C', True);
	$this->Cell(20,8,'PRECIO',1,0,'C', True);
	$this->Cell(15,8,'CANT',1,0,'C', True);
	$this->Cell(18,8,'LOTE',1,0,'C', True);
	$this->Cell(20,8,'VENCE',1,0,'C', True);
	$this->Cell(25,8,'IMPORTE',1,1,'C', True);
	
	################################################# BLOQUE N° 4 DE DETALLES DE PRODUCTOS ###################################################	
	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 78, 190, 170, '1.5', '');
	
	$this->Ln(3);
    $tra = new Login();
    $reg = $tra->VerDetallesCompras();
	$cantidad=0;
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$cantidad+=$reg[$i]['cantcompra'];
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(6,4,$a++,0,0,'C');
	$this->CellFitSpace(15,4,utf8_decode($reg[$i]["codproducto"]),0,0,'C');
    $this->CellFitSpace(50,4,utf8_decode($reg[$i]["producto"]),0,0,'C');
    $this->CellFitSpace(22,4,utf8_decode($reg[$i]["nomcategoria"]),0,0,'C');
	$this->CellFitSpace(20,4,utf8_decode(number_format($reg[$i]["precio1"], 2, '.', ',')),0,0,'C');
	$this->CellFitSpace(15,4,utf8_decode($reg[$i]["cantcompra"]),0,0,'C');
	$this->CellFitSpace(18,4,utf8_decode($reg[$i]["lote"]),0,0,'C');
	$this->CellFitSpace(20,4,utf8_decode($reg[$i]["vence"]),0,0,'C');
	$this->CellFitSpace(24,4,utf8_decode(number_format($reg[$i]["importecompra"], 2, '.', ',')),0,0,'C');
    $this->Ln();
                                 }
    
################################################# BLOQUE N° 5 DE TOTALES ###################################################	
	//Bloque de Informacion adicional
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 250, 110, 28, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',10);
    $this->SetXY(44, 250);
    $this->Cell(20, 5, 'INFORMACIÓN ADICIONAL', 0 , 0);
	
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',8);
    $this->SetXY(12, 254);
    $this->Cell(20, 5, 'CANTIDAD DE PRODUCTOS :', 0 , 0);
    $this->SetXY(60, 254);
	$this->SetFont('courier','',8);
    $this->Cell(20, 5,utf8_decode($cantidad), 0 , 0);
	
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',8);
    $this->SetXY(12, 257.2);
    $this->Cell(20, 5, 'TIPO DE DOCUMENTO :', 0 , 0);
    $this->SetXY(60, 257.2);
	$this->SetFont('courier','',8);
    $this->Cell(20, 5,utf8_decode("FACTURA"), 0 , 0);
	
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',8);
    $this->SetXY(12, 260.5);
    $this->Cell(20, 5, 'TIPO DE PAGO :', 0 , 0);
    $this->SetXY(60, 260.5);
	$this->SetFont('courier','',8);
    $this->Cell(20, 5,utf8_decode($co[0]['tipocompra']." - ".$co[0]['formacompra']), 0 , 0);
	
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',8);
    $this->SetXY(12, 263.5);
    $this->Cell(20, 5, 'FECHA DE VENCIMIENTO :', 0 , 0);
    $this->SetXY(60, 263.5);
	$this->SetFont('courier','',8);
    $this->Cell(20, 5,utf8_decode($vence = ( $co[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($co[0]['fechavencecredito'])))), 0 , 0);
	
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',8);
    $this->SetXY(12, 266.5);
    $this->Cell(20, 5, 'DIAS VENCIDOS :', 0 , 0);
    $this->SetXY(60, 266.5);
	$this->SetFont('courier','',8);
	
    if($co[0]['fechavencecredito']== '0000-00-00') { 
	$this->Cell(20, 5,utf8_decode("0"), 0 , 0);
	} elseif($co[0]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->Cell(20, 5,utf8_decode("0"), 0 , 0);
	} elseif($co[0]['fechavencecredito'] < date("Y-m-d")) { 
	$this->Cell(20, 5,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$co[0]['fechavencecredito'])), 0 , 0);
	}
	//$this->Cell(20, 5,$dias = ( $co[0]['fechavencecredito'] == '0000-00-00' ? "0" : Dias_Transcurridos($co[0]['fechavencecredito'],date("Y-m-d"))), 0 , 0);
	
	//Linea de membrete Nro 7
	$this->SetXY(52, 33);
	$this->Codabar(13,271,utf8_decode("133923786899444489448576556789"));
	//Linea de membrete Nro 2
    $this->SetFont('courier','B',6.5);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetXY(48, 271);
    $this->Cell(20, 5, 'Este documento no constituye un comprobante de pago', 0 , 0);
	
	//Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(122, 250, 78, 28, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(124, 252);
    $this->Cell(20, 5, 'SUBTOTAL IVA '.$co[0]["ivac"].'% :', 0 , 0);
    $this->SetXY(167, 252);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($co[0]["subtotalivasic"], 2, '.', ',')), 0 , 0);
	
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(124, 256);
    $this->Cell(20, 5, 'SUBTOTAL IVA 0% :', 0 , 0);
    $this->SetXY(167, 256);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($co[0]["subtotalivanoc"], 2, '.', ',')), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',9);
    $this->SetXY(124, 260);
    $this->Cell(20, 5, 'IVA '.$co[0]["ivac"].'% :', 0 , 0);
    $this->SetXY(167, 260);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($co[0]["totalivac"], 2, '.', ',')), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',9);
    $this->SetXY(124, 264);
    $this->Cell(20, 5, 'DESC '.$co[0]["descuentoc"].'% :', 0 , 0);
    $this->SetXY(167, 264);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($co[0]["totaldescuentoc"], 2, '.', ',')), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',9);
    $this->SetXY(124, 268);
    $this->Cell(20, 5, 'TOTAL PAGO :', 0 , 0);
    $this->SetXY(167, 268);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($co[0]["totalc"], 2, '.', ',')), 0 , 0);
    
}
############################################### FIN DE FUNCION FACTURA DE COMPRAS DE PRODUCTOS ######################################################

############################################### FUNCION LISTAR COMPRAS GENERALES ######################################################
	  function TablaComprasGeneral()
   {	
	 //Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',18);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,25,'LISTADO GENERAL DE COMPRAS',0,0,'C');
    //Salto de línea
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(30,8,'CÓDIGO COMPRA',1,0,'C', True);
	$this->CellFitSpace(60,8,'PROVEEDOR',1,0,'C', True);
	$this->CellFitSpace(17,8,'STATUS',1,0,'C', True);
	$this->CellFitSpace(35,8,'FECHA COMPRA',1,0,'C', True);
	$this->CellFitSpace(15,8,'ARTICULOS',1,0,'C', True);
	$this->CellFitSpace(30,8,'SUBTOTAL CON IVA',1,0,'C', True);
	$this->CellFitSpace(30,8,'SUBTOTAL IVA 0%',1,0,'C', True);
	$this->CellFitSpace(15,8,'IVA',1,0,'C', True);
	$this->CellFitSpace(25,8,'TOTAL IVA',1,0,'C', True);
	$this->CellFitSpace(15,8,'DESC',1,0,'C', True);
	$this->CellFitSpace(25,8,'TOTAL DESC',1,0,'C', True);
	$this->CellFitSpace(30,8,'TOTAL PAGO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarCompras();
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
    $Subtotalconiva+=$reg[$i]['subtotalivasic'];
    $Subtotalsiniva+=$reg[$i]['subtotalivanoc'];
	$Totaliva+=$reg[$i]['totalivac']; 
	$Totaldescuento+=$reg[$i]['totaldescuentoc']; 
	$Pagototal+=$reg[$i]['totalc'];  
		
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(30,5,$reg[$i]["codcompra"],1,0,'C');
	$this->CellFitSpace(60,5,utf8_decode($reg[$i]["nomproveedor"]),1,0,'C');
	
	if($reg[$i]['fechavencecredito']== '0000-00-00') { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statuscompra']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statuscompra']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode("VENCIDA"),1,0,'C');
	}
		
	$this->CellFitSpace(35,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fechacompra']))),1,0,'C');
	$this->CellFitSpace(15,5,utf8_decode($reg[$i]["articulos"]),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['subtotalivasic'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['subtotalivanoc'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(15,5,utf8_decode(number_format($reg[$i]['ivac'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]['totalivac'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(15,5,utf8_decode(number_format($reg[$i]['descuentoc'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]['totaldescuentoc'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['totalc'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(10,5,'',0,0,'C');
    $this->Cell(32,5,'',0,0,'C');	
    $this->Cell(60,5,'',0,0,'C');	
    $this->Cell(15,5,'',0,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(15,5,utf8_decode($totalarticulos),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Subtotalconiva, 2, '.', ',')),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Subtotalsiniva, 2, '.', ',')),1,0,'C');
    $this->Cell(15,5,"",1,0,'C');
    $this->Cell(25,5,utf8_decode(number_format($Totaliva, 2, '.', ',')),1,0,'C');
    $this->Cell(15,5,"",1,0,'C');
    $this->Cell(25,5,utf8_decode(number_format($Totaldescuento, 2, '.', ',')),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Pagototal, 2, '.', ',')),1,0,'C');
    $this->Ln();
   
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
	
     }
############################################### FIN DE FUNCION LISTAR COMPRAS GENERALES ######################################################

############################################### FUNCION LISTAR COMPRAS POR PROVEEDORES ######################################################
	  function TablaComprasProveedor()
   {		 
	
	$tra = new Login();
    $reg = $tra->BuscarComprasReportes();
	
	//Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',18);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,10,'LISTADO DE COMPRAS POR PROVEEDOR',0,0,'C');
    $this->Ln();
    $this->Cell(130);
    $this->Cell(180,10,'PROVEEDOR '.utf8_decode($reg[0]["nomproveedor"]),0,0,'C');
    $this->Ln(20);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(40,8,'CÓDIGO COMPRA',1,0,'C', True);
	$this->CellFitSpace(30,8,'STATUS COMPRA',1,0,'C', True);
	$this->CellFitSpace(40,8,'FECHA COMPRA',1,0,'C', True);
	$this->CellFitSpace(25,8,'ARTICULOS',1,0,'C', True);
	$this->CellFitSpace(30,8,'SUBTOTAL CON IVA',1,0,'C', True);
	$this->CellFitSpace(30,8,'SUBTOTAL IVA 0%',1,0,'C', True);
	$this->CellFitSpace(20,8,'IVA',1,0,'C', True);
	$this->CellFitSpace(25,8,'TOTAL IVA',1,0,'C', True);
	$this->CellFitSpace(20,8,'DESCUENTO',1,0,'C', True);
	$this->CellFitSpace(25,8,'TOTAL DESC',1,0,'C', True);
	$this->CellFitSpace(35,8,'TOTAL PAGO',1,1,'C', True);
	
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
    $Subtotalconiva+=$reg[$i]['subtotalivasic'];
    $Subtotalsiniva+=$reg[$i]['subtotalivanoc'];
	$Totaliva+=$reg[$i]['totalivac']; 
	$Totaldescuento+=$reg[$i]['totaldescuentoc']; 
	$Pagototal+=$reg[$i]['totalc'];  
	
	//$dias = ( $reg[$i]['fechavencecredito'] == '0000-00-00' ? "0" : Dias_Transcurridos($reg[$i]['fechavencecredito'],date("Y-m-d")));
	
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(40,5,$reg[$i]["codcompra"],1,0,'C');
	
	if($reg[$i]['fechavencecredito']== '0000-00-00') { 
	$this->CellFitSpace(30, 5,utf8_decode($reg[$i]['statuscompra']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->CellFitSpace(30, 5,utf8_decode($reg[$i]['statuscompra']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { 
	$this->CellFitSpace(30, 5,utf8_decode("VENCIDA"),1,0,'C');
	}
	$this->CellFitSpace(40,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fechacompra']))),1,0,'C');
	$this->CellFitSpace(25,5,utf8_decode($reg[$i]["articulos"]),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['subtotalivasic'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['subtotalivanoc'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(20,5,utf8_decode(number_format($reg[$i]['ivac'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]['totalivac'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(20,5,utf8_decode(number_format($reg[$i]['descuentoc'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]['totaldescuentoc'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(35,5,utf8_decode(number_format($reg[$i]['totalc'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(10,5,'',0,0,'C');
    $this->Cell(40,5,'',0,0,'C');	
    $this->Cell(30,5,'',0,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(40,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(25,5,utf8_decode($totalarticulos),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Subtotalconiva, 2, '.', ',')),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Subtotalsiniva, 2, '.', ',')),1,0,'C');
    $this->Cell(20,5,"",1,0,'C');
    $this->Cell(25,5,utf8_decode(number_format($Totaliva, 2, '.', ',')),1,0,'C');
    $this->Cell(20,5,"",1,0,'C');
    $this->Cell(25,5,utf8_decode(number_format($Totaldescuento, 2, '.', ',')),1,0,'C');
    $this->Cell(35,5,utf8_decode(number_format($Pagototal, 2, '.', ',')),1,0,'C');
    $this->Ln();
   
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
	
     }
############################################### FIN DE FUNCION LISTAR COMPRAS POR PROVEEDORES ######################################################

##################################################################### CLASE COMPRAS DE PRODUCTOS ####################################################################





























































##################################################################### CLASE VENTAS DE PRODUCTOS ####################################################################

############################################### FUNCION LISTAR FACTURA DE VENTAS DE PRODUCTOS ######################################################
  function TablaVentasProductos()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 15 ,10, 55 , 18 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',15);
    //Movernos a la derecha
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$ve = new Login();
    $ve = $ve->VentasPorId();
	
################################################# BLOQUE N° 1 ###################################################	

   //Bloque de membrete principal
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 10, 190, 20, '1.5', '');
	
	//Bloque de membrete principal
    $this->SetFillColor(199);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(98, 14, 12, 12, '1.5', 'F');
	//Bloque de membrete principal
    $this->SetFillColor(199);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(98, 14, 12, 12, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',16);
    $this->SetXY(101, 14);
    $this->Cell(20, 5, 'V', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(98, 19);
    $this->Cell(20, 5, 'Venta', 0 , 0);
	
	
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 10);
    $this->Cell(20, 5, 'N° VENTA ', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(165, 10);
    $this->Cell(20, 5,utf8_decode($ve[0]['codventa']), 0 , 0);
	
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 13);
    $this->Cell(20, 5, 'N° SERIE ', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(165, 13);
    $this->Cell(20, 5,utf8_decode($ve[0]['codserieve']), 0 , 0);
	
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 16);
    $this->Cell(20, 5, 'N° AUTORIZACIÓN ', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(165, 16);
    $this->Cell(20, 5,utf8_decode($ve[0]['codautorizacionve']), 0 , 0);
	
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 19);
    $this->Cell(20, 5, 'FECHA VENTA ', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 19);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y h:i:s",strtotime($ve[0]['fechaventa']))), 0 , 0);
	
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 22);
    $this->Cell(20, 5, 'FECHA EMISIÓN', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 22);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y h:i:s")), 0 , 0);
	
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 25);
    $this->Cell(20, 5, 'STATUS VENTA', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 25);
	
	if($ve[0]['fechavencecredito']== '0000-00-00') { 
	$this->Cell(20, 5,utf8_decode($ve[0]['statusventa']), 0 , 0);
	} elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->Cell(20, 5,utf8_decode($ve[0]['statusventa']), 0 , 0);
	} elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) { 
	$this->Cell(20, 5,utf8_decode("VENCIDA"), 0 , 0);
	}	
	
################################################# BLOQUE N° 2 ###################################################	

	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 32, 190, 18, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(15, 32);
    $this->Cell(20, 5, 'DATOS DE LA EMPRESA ', 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 36);
    $this->Cell(20, 5, 'RAZÓN SOCIAL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(40, 36);
    $this->Cell(20, 5,utf8_decode($con[0]['nomempresa']), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',7);
    $this->SetXY(147, 36);
    $this->Cell(90, 5, 'RIF :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(156, 36);
    $this->Cell(90, 5,utf8_decode($con[0]['rifempresa']), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 40);
    $this->Cell(20, 5, 'DIRECCIÓN :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(32, 40);
    $this->Cell(20, 5,utf8_decode($con[0]['direcempresa']), 0 , 0);
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',7);
    $this->SetXY(140, 40);
    $this->Cell(20, 5, 'TELÉFONO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(156, 40);
    $this->Cell(20, 5,utf8_decode($con[0]['tlfempresa']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 44);
    $this->Cell(20, 5, 'GERENTE :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(30, 44);
    $this->Cell(20, 5,utf8_decode($con[0]['nomresponsable']), 0 , 0);
	//Linea de membrete Nro 7
	$this->SetFont('courier','B',7);
    $this->SetXY(94, 44);
    $this->Cell(20, 5, 'CÉDULA :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(108, 44);
    $this->Cell(20, 5,utf8_decode($con[0]['cedresponsable']), 0 , 0);
	//Linea de membrete Nro 8
	$this->SetFont('courier','B',7);
    $this->SetXY(130, 44);
    $this->Cell(20, 5, 'EMAIL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(142, 44);
    $this->Cell(20, 5,utf8_decode($con[0]['correoresponsable']), 0 , 0);
	
################################################# BLOQUE N° 3 ###################################################	

	//Bloque de datos de cliente
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 52, 190, 14, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(15, 52);
    $this->Cell(20, 5, 'DATOS DEL CLIENTE ', 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 56);
    $this->Cell(20, 5, 'RAZÓN SOCIAL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(38, 56);
    $this->Cell(20, 5,utf8_decode($ve[0]['nomcliente']), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',7);
    $this->SetXY(112, 56);
    $this->Cell(74, 5, 'RIF :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(122, 56);
    $this->Cell(75, 5,utf8_decode($ve[0]['cedcliente']), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',7);
    $this->SetXY(150, 56);
    $this->Cell(90, 5, 'TELÉFONO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(166, 56);
    $this->Cell(90, 5,utf8_decode($ve[0]['tlfcliente']), 0 , 0);
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 60);
    $this->Cell(20, 5, 'DIRECCIÓN :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(33, 60);
    $this->Cell(20, 5,utf8_decode($ve[0]['direccliente']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(116, 60);
    $this->Cell(20, 5, 'EMAIL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(128, 60);
    $this->Cell(20, 5,utf8_decode($ve[0]['emailcliente']), 0 , 0);
	
	$this->Ln(8);
	$this->SetFont('courier','B',10);
	$this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
	$this->Cell(8,8,'N°',1,0,'C', True);
	$this->Cell(17,8,'CÓDIGO',1,0,'C', True);
	$this->Cell(67,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
	$this->Cell(25,8,'CATEGORIA',1,0,'C', True);
	$this->Cell(25,8,'PRECIO',1,0,'C', True);
	$this->Cell(23,8,'CANTIDAD',1,0,'C', True);
	$this->Cell(25,8,'IMPORTE',1,1,'C', True);
	
	################################################# BLOQUE N° 4 DE DETALLES DE PRODUCTOS ###################################################	
	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 78, 190, 170, '1.5', '');
	
	$this->Ln(3);
    $tra = new Login();
    $reg = $tra->VerDetallesVentas();
	$cantidad=0;
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$cantidad+=$reg[$i]['cantventa'];
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(8,4,$a++,0,0,'C');
	$this->CellFitSpace(17,4,utf8_decode($reg[$i]["codproducto"]),0,0,'C');
    $this->CellFitSpace(67,4,utf8_decode($reg[$i]["producto"]),0,0,'C');
    $this->CellFitSpace(25,4,utf8_decode($reg[$i]["nomcategoria"]),0,0,'C');
	$this->CellFitSpace(25,4,utf8_decode(number_format($reg[$i]["precioventa"], 2, '.', ',')),0,0,'C');
	$this->CellFitSpace(23,4,utf8_decode($reg[$i]["cantventa"]),0,0,'C');
	$this->CellFitSpace(25,4,utf8_decode(number_format($reg[$i]["importe"], 2, '.', ',')),0,0,'C');
    $this->Ln();
                                 }
    
################################################# BLOQUE N° 5 DE TOTALES ###################################################	
	//Bloque de Informacion adicional
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 250, 110, 28, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',10);
    $this->SetXY(44, 250);
    $this->Cell(20, 5, 'INFORMACIÓN ADICIONAL', 0 , 0);
	
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',8);
    $this->SetXY(12, 254);
    $this->Cell(20, 5, 'CANTIDAD DE PRODUCTOS :', 0 , 0);
    $this->SetXY(60, 254);
	$this->SetFont('courier','',8);
    $this->Cell(20, 5,utf8_decode($cantidad), 0 , 0);
	
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',8);
    $this->SetXY(12, 257.2);
    $this->Cell(20, 5, 'TIPO DE DOCUMENTO :', 0 , 0);
    $this->SetXY(60, 257.2);
	$this->SetFont('courier','',8);
    $this->Cell(20, 5,utf8_decode("FACTURA"), 0 , 0);
	
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',8);
    $this->SetXY(12, 260.5);
    $this->Cell(20, 5, 'TIPO DE PAGO :', 0 , 0);
    $this->SetXY(60, 260.5);
	$this->SetFont('courier','',8);
    $this->Cell(20, 5,utf8_decode($ve[0]['tipopagove']." - ".$ve[0]['formapagove']), 0 , 0);
	
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',8);
    $this->SetXY(12, 263.5);
    $this->Cell(20, 5, 'FECHA DE VENCIMIENTO :', 0 , 0);
    $this->SetXY(60, 263.5);
	$this->SetFont('courier','',8);
    $this->Cell(20, 5,utf8_decode($vence = ( $ve[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($ve[0]['fechavencecredito'])))), 0 , 0);
	
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',8);
    $this->SetXY(12, 266.5);
    $this->Cell(20, 5, 'DIAS VENCIDOS :', 0 , 0);
    $this->SetXY(60, 266.5);
	$this->SetFont('courier','',8);
	
    if($ve[0]['fechavencecredito']== '0000-00-00') { 
	$this->Cell(20, 5,utf8_decode("0"), 0 , 0);
	} elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->Cell(20, 5,utf8_decode("0"), 0 , 0);
	} elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) { 
	$this->Cell(20, 5,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$ve[0]['fechavencecredito'])), 0 , 0);
	}
	
	//Linea de membrete Nro 7
	$this->SetXY(52, 33);
	$this->Codabar(13,271,utf8_decode("133923786899444489448576556789"));
	//Linea de membrete Nro 2
    $this->SetFont('courier','B',6.5);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetXY(48, 271);
    $this->Cell(20, 5, 'Este documento no constituye un comprobante de pago', 0 , 0);
	
	//Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(122, 250, 78, 28, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(124, 252);
    $this->Cell(20, 5, 'SUBTOTAL IVA '.$ve[0]["ivave"].'% :', 0 , 0);
    $this->SetXY(167, 252);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($ve[0]["subtotalivasive"], 2, '.', ',')), 0 , 0);
	
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(124, 256);
    $this->Cell(20, 5, 'SUBTOTAL IVA 0% :', 0 , 0);
    $this->SetXY(167, 256);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($ve[0]["subtotalivanove"], 2, '.', ',')), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',9);
    $this->SetXY(124, 260);
    $this->Cell(20, 5, 'IVA '.$ve[0]["ivave"].'% :', 0 , 0);
    $this->SetXY(167, 260);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($ve[0]["totalivave"], 2, '.', ',')), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',9);
    $this->SetXY(124, 264);
    $this->Cell(20, 5, 'DESC '.$ve[0]["descuentove"].'% :', 0 , 0);
    $this->SetXY(167, 264);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($ve[0]["totaldescuentove"], 2, '.', ',')), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',9);
    $this->SetXY(124, 268);
    $this->Cell(20, 5, 'TOTAL PAGO :', 0 , 0);
    $this->SetXY(167, 268);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($ve[0]["totalpago"], 2, '.', ',')), 0 , 0);
}
############################################### FIN DE FUNCION FACTURA DE VENTAS DE PRODUCTOS ######################################################


############################################### FUNCION TICKET DE VENTAS DE PRODUCTOS ######################################################
	  function TablaTicketProductos()
   {
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$ve = new Login();
    $ve = $ve->VentasPorId();
	
	$this->SetFont('courier','B',14);
	$this->SetFillColor(2,157,116);
	$this->SetXY(13, 6);
    $this->Cell(13, 5, "TICKET DE VENTA", 0 , 0);
	$this->Ln(5);
	
	$this->SetFont('courier','B',6);
	$this->SetFillColor(2,157,116);
	$this->SetXY(4, 13);
	$this->CellFitSpace(65,3,utf8_decode($con[0]['direcempresa']),0,1,'C');
	$this->SetXY(4, 15);
	$this->CellFitSpace(65,3,"RIF:".utf8_decode($con[0]['rifempresa']),0,1,'C');
	$this->SetXY(4, 17);
	$this->CellFitSpace(65,3,utf8_decode($con[0]['nomempresa']),0,1,'C');
	$this->SetXY(4, 19);
	$this->CellFitSpace(65,3,"TLF:".utf8_decode($con[0]['tlfempresa']),0,1,'C');
		
	$this->SetFont('courier','B',7);
	$this->SetFillColor(2,157,116);
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
	$this->SetXY(3, 25);
    $this->Cell(3, 5, "N° VENTA: ".utf8_decode($ve[0]['codventa']), 0 , 0);
	$this->SetXY(3, 28);
    $this->Cell(3, 5, "N° SERIE: ".utf8_decode($ve[0]['codserieve']), 0 , 0);
	$this->SetXY(3, 31);
    $this->Cell(3, 5, "N° AUTORIZACIÓN: ".utf8_decode($ve[0]['codautorizacionve']), 0 , 0);
	$this->SetXY(3, 34);
    $this->Cell(3, 5, "FECHA VENTA: ".utf8_decode($ve[0]['fechaventa']), 0 , 0);
	$this->SetXY(3, 37);
    $this->Cell(3, 5, "FECHA IMPRESIÓN: ".date("Y-m-d h:i:s A ",time()+1800), 0 , 0);
	
	$this->Ln(6);
	$this->SetXY(3, 44);
    $tra = new Login();
    $reg = $tra->VerDetallesVentas();
	$cantidad=0;
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	
	 $this->SetX(3);
     $this->SetFillColor(192);
     $this->SetDrawColor(3,3,3);
     $this->SetLineWidth(.2);
	 $this->SetFont('courier','',6);  
	 $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
	 $this->CellFitSpace(5,3,utf8_decode($reg[$i]["cantventa"]),0,0,'C');
     $this->CellFitSpace(45,3,utf8_decode($reg[$i]["producto"]),0,0,'L');
	 $this->CellFitSpace(17,3,utf8_decode(number_format($reg[$i]["precioventa"], 2, '.', ',')),0,0,'R');
     $this->Ln();	 
   }
   
    $this->Ln();
	$this->SetFont('courier','',6);
	$this->SetFillColor(2,157,116);
	$this->SetX(4);
	$this->CellFitSpace(60,3,"SUBTOTAL IVA ".$ve[0]["ivave"].'% : '.utf8_decode(number_format($ve[0]["subtotalivasive"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"SUBTOTAL IVA 0%: ".utf8_decode(number_format($ve[0]["subtotalivanove"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"IVA ".$ve[0]["ivave"].'% : '.utf8_decode(number_format($ve[0]["totalivave"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->SetFont('courier','',6);
	$this->CellFitSpace(60,3,"DESCUENTO ".$ve[0]["descuentove"].'% : '.utf8_decode(number_format($ve[0]["totaldescuentove"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->SetFont('courier','B',6);
	$this->CellFitSpace(60,3,"PRECIO FINAL: ".utf8_decode(number_format($ve[0]["totalpago"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"TIPO PAGO: ".utf8_decode($ve[0]['tipopagove']." - ".$ve[0]['formapagove']),0,1,'L');
	
	if($ve[0]['fechavencecredito']== '0000-00-00') { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"VENTA ".utf8_decode($ve[0]['statusventa']),0,1,'L');
	} elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"VENTA ".utf8_decode($ve[0]['statusventa']),0,1,'L');
	} elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"VENTA ".utf8_decode("VENCIDA"),0,1,'L');
	}	
	
	$this->SetX(4);
	$this->CellFitSpace(60,3,"FECHA DE VENCIMIENTO ".utf8_decode($vence = ( $ve[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($ve[0]['fechavencecredito'])))),0,1,'L');
	
	if($ve[0]['fechavencecredito']== '0000-00-00') { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"DIAS VENCIDOS ".utf8_decode($ve[0]['statusventa']),0,1,'L');
	} elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"DIAS VENCIDOS ".utf8_decode($ve[0]['statusventa']),0,1,'L');
	} elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"DIAS VENCIDOS ".utf8_decode(Dias_Transcurridos(date("Y-m-d"),$ve[0]['fechavencecredito'])),0,1,'L');
	}

	
	if($ve[0]['tipopagove']=="CREDITO"){
	$this->SetX(4);
	$this->CellFitSpace(60,3,"TOTAL ABONO: ".utf8_decode(number_format($ve[0]["abonototal"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"TOTAL DEBE: ".utf8_decode(number_format($ve[0]["totalpago"]-$ve[0]["abonototal"], 2, '.', ',')),0,1,'L');
	}
	
	$this->SetX(4);
    $this->CellFitSpace(60, 3, "C.I/DNI CLIENTE: ".utf8_decode($ve[0]['cedcliente']),0,1,'L');
	$this->SetX(4);
    $this->CellFitSpace(60, 3, "NOMBRE DE CLIENTE: ".utf8_decode($ve[0]['nomcliente']),0,1,'L');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"EMPLEADO: ".utf8_decode($ve[0]['nombres']),0,1,'L');	
	
	$this->Ln(12);
	$logo = "./assets/img/barcode.png";
	$this->Cell(4,10,$this->Image($logo, $this->GetX()-4, $this->GetY()-7, 62),5,0,'C');
	
	$this->Ln(5);
	$this->SetFont('courier','B',5);
	$this->SetFillColor(2,157,116);
	$this->SetX(4);
	$this->CellFitSpace(65,2,"NOTA: DEBERÁ DE PRESENTAR ESTE TOCKET EN CASO ",0,1,'C');
	$this->SetX(4);
	$this->CellFitSpace(65,2,"DE RECLAMO SOBRE ALGÚN PRODUCTO DEFECTUOSO ",0,1,'C');
	
	
	$this->SetX(4);
	$this->Cell(60,3,"",0,1,'C');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"CONFORME EL CLIENTE ______________________________________",0,1,'C');
    $this->Ln(8);
	
	$this->SetFont('Arial','B',14);
	$this->SetFillColor(2,157,116);
	$this->SetX(4);
	$this->CellFitSpace(65,3,"GRACIAS POR SU COMPRA",0,1,'C');
	
	//$this->SetXY(4, 0);
	//$this->Codabar(6,0,utf8_decode("111111222222333333444444555555666666777777888888999999"));
	
	//$this->SetXY(4, 94);
	$this->Codabar(6,-90,utf8_decode("111111222222333333444444555555666666777777888888999999"));

     }
############################################### FIN DE FUNCION TICKET DE VENTAS DE PRODUCTOS ######################################################

############################################### FUNCION LISTAR VENTAS GENERALES ######################################################
	  function TablaVentasGeneral()
   {	
	 //Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',18);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,25,'LISTADO GENERAL DE VENTAS',0,0,'C');
    //Salto de línea
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(32,8,'CÓDIGO VENTA',1,0,'C', True);
	$this->CellFitSpace(15,8,'CAJA',1,0,'C', True);
	$this->CellFitSpace(60,8,'CLIENTES',1,0,'C', True);
	$this->CellFitSpace(17,8,'STATUS',1,0,'C', True);
	$this->CellFitSpace(35,8,'FECHA VENTA',1,0,'C', True);
	$this->CellFitSpace(15,8,'ARTIC',1,0,'C', True);
	$this->CellFitSpace(28,8,'SUBTOT CON IVA',1,0,'C', True);
	$this->CellFitSpace(28,8,'SUBTOT IVA 0%',1,0,'C', True);
	$this->CellFitSpace(12,8,'IVA',1,0,'C', True);
	$this->CellFitSpace(22,8,'TOTAL IVA',1,0,'C', True);
	$this->CellFitSpace(12,8,'DESC',1,0,'C', True);
	$this->CellFitSpace(20,8,'TOT DESC',1,0,'C', True);
	$this->CellFitSpace(27,8,'TOTAL PAGO',1,1,'C', True);
	
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
	
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(32,5,$reg[$i]["codventa"],1,0,'C');
	$this->CellFitSpace(15,5,utf8_decode($reg[$i]["nrocaja"]),1,0,'C');
	$this->CellFitSpace(60,5,utf8_decode($reg[$i]["nomcliente"]),1,0,'C');
	
	if($reg[$i]['fechavencecredito']== '0000-00-00') { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statusventa']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statusventa']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode("VENCIDA"),1,0,'C');
	}
	$this->CellFitSpace(35,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa']))),1,0,'C');
	$this->CellFitSpace(15,5,utf8_decode($reg[$i]["articulos"]),1,0,'C');
	$this->CellFitSpace(28,5,utf8_decode(number_format($reg[$i]['subtotalivasive'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(28,5,utf8_decode(number_format($reg[$i]['subtotalivanove'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(12,5,utf8_decode(number_format($reg[$i]['ivave'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(22,5,utf8_decode(number_format($reg[$i]['totalivave'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(12,5,utf8_decode(number_format($reg[$i]['descuentove'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(20,5,utf8_decode(number_format($reg[$i]['totaldescuentove'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(27,5,utf8_decode(number_format($reg[$i]['totalpago'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(10,5,'',0,0,'C');
    $this->Cell(32,5,'',0,0,'C');		
    $this->Cell(15,5,'',0,0,'C');
    $this->Cell(60,5,'',0,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(52,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(15,5,utf8_decode($totalarticulos),1,0,'C');
    $this->Cell(28,5,utf8_decode(number_format($Subtotalconiva, 2, '.', ',')),1,0,'C');
    $this->Cell(28,5,utf8_decode(number_format($Subtotalsiniva, 2, '.', ',')),1,0,'C');
    $this->Cell(12,5,"",1,0,'C');
    $this->Cell(22,5,utf8_decode(number_format($Totaliva, 2, '.', ',')),1,0,'C');
    $this->Cell(12,5,"",1,0,'C');
    $this->Cell(20,5,utf8_decode(number_format($Totaldescuento, 2, '.', ',')),1,0,'C');
    $this->Cell(27,5,utf8_decode(number_format($Pagototal, 2, '.', ',')),1,0,'C');
    $this->Ln();
   
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
	
     }
############################################### FIN DE FUNCION LISTAR VENTAS GENERALES ######################################################


############################################### FUNCION LISTAR VENTAS POR FECHAS ######################################################
	  function TablaVentasFechas()
   {
       //Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',18);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,25,'LISTADO DE VENTAS DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"].'',0,0,'C');
    //Salto de línea
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(32,8,'CÓDIGO VENTA',1,0,'C', True);
	$this->CellFitSpace(15,8,'CAJA',1,0,'C', True);
	$this->CellFitSpace(60,8,'CLIENTES',1,0,'C', True);
	$this->CellFitSpace(17,8,'STATUS',1,0,'C', True);
	$this->CellFitSpace(35,8,'FECHA VENTA',1,0,'C', True);
	$this->CellFitSpace(15,8,'ARTIC',1,0,'C', True);
	$this->CellFitSpace(28,8,'SUBTOT CON IVA',1,0,'C', True);
	$this->CellFitSpace(28,8,'SUBTOT IVA 0%',1,0,'C', True);
	$this->CellFitSpace(12,8,'IVA',1,0,'C', True);
	$this->CellFitSpace(22,8,'TOTAL IVA',1,0,'C', True);
	$this->CellFitSpace(12,8,'DESC',1,0,'C', True);
	$this->CellFitSpace(20,8,'TOT DESC',1,0,'C', True);
	$this->CellFitSpace(27,8,'TOTAL PAGO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->BuscarVentasFechas();
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
	
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(32,5,$reg[$i]["codventa"],1,0,'C');
	$this->CellFitSpace(15,5,utf8_decode($reg[$i]["nrocaja"]),1,0,'C');
	$this->CellFitSpace(60,5,utf8_decode($reg[$i]["nomcliente"]),1,0,'C');
	
	if($reg[$i]['fechavencecredito']== '0000-00-00') { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statusventa']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statusventa']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode("VENCIDA"),1,0,'C');
	}
	$this->CellFitSpace(35,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa']))),1,0,'C');
	$this->CellFitSpace(15,5,utf8_decode($reg[$i]["articulos"]),1,0,'C');
	$this->CellFitSpace(28,5,utf8_decode(number_format($reg[$i]['subtotalivasive'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(28,5,utf8_decode(number_format($reg[$i]['subtotalivanove'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(12,5,utf8_decode(number_format($reg[$i]['ivave'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(22,5,utf8_decode(number_format($reg[$i]['totalivave'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(12,5,utf8_decode(number_format($reg[$i]['descuentove'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(20,5,utf8_decode(number_format($reg[$i]['totaldescuentove'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(27,5,utf8_decode(number_format($reg[$i]['totalpago'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(10,5,'',0,0,'C');
    $this->Cell(32,5,'',0,0,'C');		
    $this->Cell(15,5,'',0,0,'C');
    $this->Cell(60,5,'',0,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(52,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(15,5,utf8_decode($totalarticulos),1,0,'C');
    $this->Cell(28,5,utf8_decode(number_format($Subtotalconiva, 2, '.', ',')),1,0,'C');
    $this->Cell(28,5,utf8_decode(number_format($Subtotalsiniva, 2, '.', ',')),1,0,'C');
    $this->Cell(12,5,"",1,0,'C');
    $this->Cell(22,5,utf8_decode(number_format($Totaliva, 2, '.', ',')),1,0,'C');
    $this->Cell(12,5,"",1,0,'C');
    $this->Cell(20,5,utf8_decode(number_format($Totaldescuento, 2, '.', ',')),1,0,'C');
    $this->Cell(27,5,utf8_decode(number_format($Pagototal, 2, '.', ',')),1,0,'C');
    $this->Ln();
   
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR VENTAS POR FECHAS ######################################################

############################################### FUNCION LISTAR VENTAS POR FECHAS Y CAJAS DE VENTAS ######################################################
	  function TablaVentasCajas()
   {
    $ca = new Login(); 
	$ca = $ca->CajerosPorId();	
	
	//Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");
	$this->SetXY(10, 15);
	$this->SetFont('courier','B',18);
	$this->SetFillColor(2,157,116);
	$this->Cell(120,8,'',0,0,'');
	$this->Cell(180,8,'LISTADO DE VENTAS DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"],0,1,'C');
       
	$this->Cell(150,8,'',0,0,'');
    $this->Cell(120,8,'Y CAJA N°.'.$ca[0]['nrocaja'],0,0,'C');
    //Salto de línea
    $this->Ln(15);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(32,8,'CÓDIGO VENTA',1,0,'C', True);
	$this->CellFitSpace(70,8,'CLIENTES',1,0,'C', True);
	$this->CellFitSpace(17,8,'STATUS',1,0,'C', True);
	$this->CellFitSpace(35,8,'FECHA VENTA',1,0,'C', True);
	$this->CellFitSpace(15,8,'ARTIC',1,0,'C', True);
	$this->CellFitSpace(28,8,'SUBTOT CON IVA',1,0,'C', True);
	$this->CellFitSpace(28,8,'SUBTOT IVA 0%',1,0,'C', True);
	$this->CellFitSpace(12,8,'IVA',1,0,'C', True);
	$this->CellFitSpace(22,8,'TOTAL IVA',1,0,'C', True);
	$this->CellFitSpace(12,8,'DESC',1,0,'C', True);
	$this->CellFitSpace(20,8,'TOT DESC',1,0,'C', True);
	$this->CellFitSpace(30,8,'TOTAL PAGO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->BuscarVentasCajas();
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
	
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(32,5,$reg[$i]["codventa"],1,0,'C');
	$this->CellFitSpace(70,5,utf8_decode($reg[$i]["nomcliente"]),1,0,'C');
	if($reg[$i]['fechavencecredito']== '0000-00-00') { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statusventa']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statusventa']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode("VENCIDA"),1,0,'C');
	}
	$this->CellFitSpace(35,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa']))),1,0,'C');
	$this->CellFitSpace(15,5,utf8_decode($reg[$i]["articulos"]),1,0,'C');
	$this->CellFitSpace(28,5,utf8_decode(number_format($reg[$i]['subtotalivasive'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(28,5,utf8_decode(number_format($reg[$i]['subtotalivanove'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(12,5,utf8_decode(number_format($reg[$i]['ivave'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(22,5,utf8_decode(number_format($reg[$i]['totalivave'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(12,5,utf8_decode(number_format($reg[$i]['descuentove'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(20,5,utf8_decode(number_format($reg[$i]['totaldescuentove'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['totalpago'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(10,5,'',0,0,'C');
    $this->Cell(32,5,'',0,0,'C');		
    $this->Cell(70,5,'',0,0,'C');		
    $this->Cell(17,5,'',0,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)

    $this->Cell(35,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(15,5,utf8_decode($totalarticulos),1,0,'C');
    $this->Cell(28,5,utf8_decode(number_format($Subtotalconiva, 2, '.', ',')),1,0,'C');
    $this->Cell(28,5,utf8_decode(number_format($Subtotalsiniva, 2, '.', ',')),1,0,'C');
    $this->Cell(12,5,"",1,0,'C');
    $this->Cell(22,5,utf8_decode(number_format($Totaliva, 2, '.', ',')),1,0,'C');
    $this->Cell(12,5,"",1,0,'C');
    $this->Cell(20,5,utf8_decode(number_format($Totaldescuento, 2, '.', ',')),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Pagototal, 2, '.', ',')),1,0,'C');
    $this->Ln();
   
    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR VENTAS POR FECHAS Y CAJAS DE VENTAS ######################################################

############################################### FUNCION LISTAR PRODUCTOS VENDIDOS ######################################################

	  function TablaProductosVendidos()
   {
      //Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");
	$this->SetXY(10, 15);
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(75,6,'',0,0,'');
	$this->Cell(120,6,'LISTADO DE PRODUCTOS VENDIDOS POR FECHAS ',0,1,'C');
       
	$this->Cell(75,6,'',0,0,'');
    $this->Cell(120,6,' DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"],0,0,'C');
    //Salto de línea
    $this->Ln(15);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA GERENTE: ',0,0,'');
	$this->Cell(44,5,$con[0]['cedresponsable'],0,0,'');
	$this->Cell(30,5,'NOMBRE GERENTE:',0,0,'');
	$this->Cell(83,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO GERENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->Cell(30,5,'CORREO GERENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(8,8,'N°',1,0,'C', True);
	$this->CellFitSpace(15,8,'CÓDIGO',1,0,'C', True);
	$this->CellFitSpace(60,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
	$this->CellFitSpace(20,8,'CATEGORIA',1,0,'C', True);
	$this->CellFitSpace(23,8,'PRECIO V.',1,0,'C', True);
	$this->CellFitSpace(22,8,'EXISTENCIA',1,0,'C', True);
	$this->CellFitSpace(18,8,'VENDIDOS',1,0,'C', True);
	$this->CellFitSpace(26,8,'MONTO TOTAL',1,1,'C', True);
	
    $ve = new Login();
	$reg = $ve->BuscarVentasProductos();
	$precioTotal=0;
	$existeTotal=0;
	$vendidosTotal=0;
	$pagoTotal=0;
	$a=1;
	for($i=0;$i<sizeof($reg);$i++){
	$precioTotal+=$reg[$i]['precioventa'];
	$existeTotal+=$reg[$i]['existencia'];
	$vendidosTotal+=$reg[$i]['cantidad']; 
	$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['cantidad'];
	$this->SetFont('courier','',7);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(8,5,$a++,1,0,'C');
	$this->CellFitSpace(15,5,$reg[$i]["codproducto"],1,0,'C');
    $this->CellFitSpace(60,5,utf8_decode($reg[$i]["producto"]),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode($reg[$i]["nomcategoria"]),1,0,'C');
	$this->CellFitSpace(23,5,utf8_decode(number_format($reg[$i]["precioventa"], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(22,5,utf8_decode($reg[$i]['existencia']),1,0,'C');
	$this->CellFitSpace(18,5,utf8_decode($reg[$i]['cantidad']),1,0,'C');
	$this->CellFitSpace(26,5,utf8_decode(number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(8,5,'',0,0,'C');
    $this->Cell(15,5,'',0,0,'C');
    $this->Cell(60,5,'',0,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(20,5,'TOTALES',1,0,'C', True);
    $this->SetFont('courier','B',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(23,5,utf8_decode(number_format($precioTotal, 2, '.', ',')),1,0,'C');
    $this->Cell(22,5,utf8_decode($existeTotal),1,0,'C');
    $this->Cell(18,5,utf8_decode($vendidosTotal),1,0,'C');  
    $this->CellFitSpace(26,5,utf8_decode(number_format($pagoTotal, 2, '.', ',')),1,0,'C');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(60,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(60,6,'',0,0,'');
    $this->Ln(4);
     }
	

############################################### FIN DE FUNCION LISTAR PRODUCTOS VENDIDOS ######################################################

############################################### FUNCION LISTAR VENTAS DEL DIA PARA ADMINISTRADOR ######################################################

	  function TablaVentasDiariasAdmin()
   {
       //Logo
    $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',18);
    //Movernos a la derecha
    $this->Cell(130);
    //Título
    $this->Cell(180,25,'LISTADO DE VENTAS GENERAL DEL DIA '.date("d-m-Y"),0,0,'C');
    //Salto de línea
    $this->Ln(30);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(32,8,'CÓDIGO VENTA',1,0,'C', True);
	$this->CellFitSpace(15,8,'CAJA',1,0,'C', True);
	$this->CellFitSpace(60,8,'CLIENTES',1,0,'C', True);
	$this->CellFitSpace(35,8,'FECHA VENTA',1,0,'C', True);
	$this->CellFitSpace(15,8,'ARTIC',1,0,'C', True);
	$this->CellFitSpace(30,8,'SUBTOTAL CON IVA',1,0,'C', True);
	$this->CellFitSpace(30,8,'SUBTOTAL IVA 0%',1,0,'C', True);
	$this->CellFitSpace(15,8,'IVA',1,0,'C', True);
	$this->CellFitSpace(22,8,'TOTAL IVA',1,0,'C', True);
	$this->CellFitSpace(15,8,'DESC',1,0,'C', True);
	$this->CellFitSpace(22,8,'TOTAL DESC',1,0,'C', True);
	$this->CellFitSpace(30,8,'TOTAL PAGO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarVentasDiarias();
	$totalarticulos=0;
	$Subtotalconiva=0;
	$Subtotalsiniva=0;
	$Totaliva=0;
	$Totaldescuento=0;
	$pagoDescuento=0;
	$Pagototal=0;
	$PagototalCompras=0;
	$a=1;
	
    for($i=0;$i<sizeof($reg);$i++){
	
    $totalarticulos+=$reg[$i]['articulos'];
    $Subtotalconiva+=$reg[$i]['subtotalivasive'];
    $Subtotalsiniva+=$reg[$i]['subtotalivanove'];
	$Totaliva+=$reg[$i]['totalivave']; 
	$Totaldescuento+=$reg[$i]['totaldescuentove']; 
	$Pagototal+=$reg[$i]['totalpago'];
    $PagototalCompras+=$reg[$i]['totalpago2'];  
	
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(32,5,$reg[$i]["codventa"],1,0,'C');
	$this->CellFitSpace(15,5,utf8_decode($reg[$i]["nrocaja"]),1,0,'C');
	$this->CellFitSpace(60,5,utf8_decode($reg[$i]["nomcliente"]),1,0,'C');
	$this->CellFitSpace(35,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa']))),1,0,'C');
	$this->CellFitSpace(15,5,utf8_decode($reg[$i]["articulos"]),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['subtotalivasive'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['subtotalivanove'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(15,5,utf8_decode(number_format($reg[$i]['ivave'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(22,5,utf8_decode(number_format($reg[$i]['totalivave'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(15,5,utf8_decode(number_format($reg[$i]['descuentove'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(22,5,utf8_decode(number_format($reg[$i]['totaldescuentove'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['totalpago'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
    
	$this->Cell(10,5,'',0,0,'C');
    $this->Cell(32,5,'',0,0,'C');		
    $this->Cell(15,5,'',0,0,'C');
    $this->Cell(60,5,'',0,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)

    $this->Cell(35,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(15,5,utf8_decode($totalarticulos),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Subtotalconiva, 2, '.', ',')),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Subtotalsiniva, 2, '.', ',')),1,0,'C');
    $this->Cell(15,5,"",1,0,'C');
    $this->Cell(22,5,utf8_decode(number_format($Totaliva, 2, '.', ',')),1,0,'C');
    $this->Cell(15,5,"",1,0,'C');
    $this->Cell(22,5,utf8_decode(number_format($Totaldescuento, 2, '.', ',')),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Pagototal, 2, '.', ',')),1,0,'C');
    $this->Ln();
	
	$UtilidadBruto= $Pagototal-$PagototalCompras;
	$MargenBruto = ( $UtilidadBruto == '' ? "0.00" : number_format($UtilidadBruto/$PagototalCompras, 2, '.', ','));
	
	$this->Cell(10,5,'',0,0,'C');
    $this->Cell(32,5,'',0,0,'C');		
    $this->Cell(15,5,'',0,0,'C');
    $this->Cell(60,5,'',0,0,'C');	
	$this->Cell(35,5,'',0,0,'C');
	$this->Cell(15,5,'',0,0,'C');
    $this->Cell(30,5,'',0,0,'C');
    $this->Cell(30,5,'',0,0,'C');
    $this->Cell(15,5,'',0,0,'C');
    $this->Cell(22,5,'',0,0,'C');
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(37,5,"TOTAL GANANCIAS",1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(30,5,utf8_decode(number_format($MargenBruto*100, 2, '.', ',')),1,0,'C');
    $this->Ln();
   
     $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR VENTAS DEL DIA PARA ADMINISTRADOR ######################################################

############################################### FUNCION LISTAR VENTAS DEL DIA PARA VENDEDOR #####################################################
	  function TablaVentasDiariasVendedor()
   {	
	
	 $this->Image("./assets/img/logo.png" , 35 ,12, 80 , 25 , "PNG"); 
	 $this->SetXY(10, 15); 
    //Arial bold 15
    $this->SetFont('Courier','B',18);
    //Movernos a la derecha
    //$this->Cell(130);
    //Título
    $this->Cell(140,8,'',0,0,'');
	$this->Cell(180,8,'LISTADO DE VENTAS DIARIAS DEL '.date("d-m-Y"),0,1,'C');
	
    $this->Cell(140,8,'',0,0,'');
	$this->Cell(180,8,'DE CAJA N°.'.base64_decode($_GET['caja']),0,0,'C');
    //Salto de línea
    $this->Ln(15);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'CÉDULA GERENTE :',0,0,'');
	$this->CellFitSpace(95,5,$con[0]['cedresponsable'],0,0,'');
	$this->CellFitSpace(42,5,'NOMBRE GERENTE :',0,0,'');
	$this->CellFitSpace(120,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(30,5,'',0,0,'');
	$this->CellFitSpace(42,5,'TELÉFONO GERENTE :',0,0,'');
    $this->CellFitSpace(95,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->CellFitSpace(42,5,'CORREO GERENTE :',0,0,'');
    $this->CellFitSpace(120,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(32,8,'CÓDIGO VENTA',1,0,'C', True);
	$this->CellFitSpace(15,8,'CAJA',1,0,'C', True);
	$this->CellFitSpace(60,8,'CLIENTES',1,0,'C', True);
	$this->CellFitSpace(35,8,'FECHA VENTA',1,0,'C', True);
	$this->CellFitSpace(15,8,'ARTIC',1,0,'C', True);
	$this->CellFitSpace(30,8,'SUBTOTAL CON IVA',1,0,'C', True);
	$this->CellFitSpace(30,8,'SUBTOTAL IVA 0%',1,0,'C', True);
	$this->CellFitSpace(15,8,'IVA',1,0,'C', True);
	$this->CellFitSpace(22,8,'TOTAL IVA',1,0,'C', True);
	$this->CellFitSpace(15,8,'DESC',1,0,'C', True);
	$this->CellFitSpace(22,8,'TOTAL DESC',1,0,'C', True);
	$this->CellFitSpace(30,8,'TOTAL PAGO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarVentasDiarias();
	$totalarticulos=0;
	$Subtotalconiva=0;
	$Subtotalsiniva=0;
	$Totaliva=0;
	$Totaldescuento=0;
	$pagoDescuento=0;
	$Pagototal=0;
	$PagototalCompras=0;
	$a=1;
	
    for($i=0;$i<sizeof($reg);$i++){
	
    $totalarticulos+=$reg[$i]['articulos'];
    $Subtotalconiva+=$reg[$i]['subtotalivasive'];
    $Subtotalsiniva+=$reg[$i]['subtotalivanove'];
	$Totaliva+=$reg[$i]['totalivave']; 
	$Totaldescuento+=$reg[$i]['totaldescuentove']; 
	$Pagototal+=$reg[$i]['totalpago'];
    $PagototalCompras+=$reg[$i]['totalpago2'];  
	
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(32,5,$reg[$i]["codventa"],1,0,'C');
	$this->CellFitSpace(15,5,utf8_decode($reg[$i]["nrocaja"]),1,0,'C');
	$this->CellFitSpace(60,5,utf8_decode($reg[$i]["nomcliente"]),1,0,'C');
	$this->CellFitSpace(35,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa']))),1,0,'C');
	$this->CellFitSpace(15,5,utf8_decode($reg[$i]["articulos"]),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['subtotalivasive'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['subtotalivanove'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(15,5,utf8_decode(number_format($reg[$i]['ivave'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(22,5,utf8_decode(number_format($reg[$i]['totalivave'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(15,5,utf8_decode(number_format($reg[$i]['descuentove'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(22,5,utf8_decode(number_format($reg[$i]['totaldescuentove'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(30,5,utf8_decode(number_format($reg[$i]['totalpago'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(10,5,'',0,0,'C');
    $this->Cell(32,5,'',0,0,'C');		
    $this->Cell(15,5,'',0,0,'C');
    $this->Cell(60,5,'',0,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)

    $this->Cell(35,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
	$this->Cell(15,5,utf8_decode($totalarticulos),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Subtotalconiva, 2, '.', ',')),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Subtotalsiniva, 2, '.', ',')),1,0,'C');
    $this->Cell(15,5,"",1,0,'C');
    $this->Cell(22,5,utf8_decode(number_format($Totaliva, 2, '.', ',')),1,0,'C');
    $this->Cell(15,5,"",1,0,'C');
    $this->Cell(22,5,utf8_decode(number_format($Totaldescuento, 2, '.', ',')),1,0,'C');
    $this->Cell(30,5,utf8_decode(number_format($Pagototal, 2, '.', ',')),1,0,'C');
    $this->Ln();
	
	$UtilidadBruto= $Pagototal-$PagototalCompras;
	$MargenBruto = ( $UtilidadBruto == '' ? "0.00" : number_format($UtilidadBruto/$PagototalCompras, 2, '.', ','));
	
	$this->Cell(10,5,'',0,0,'C');
    $this->Cell(32,5,'',0,0,'C');		
    $this->Cell(15,5,'',0,0,'C');
    $this->Cell(60,5,'',0,0,'C');	
	$this->Cell(35,5,'',0,0,'C');
	$this->Cell(15,5,'',0,0,'C');
    $this->Cell(30,5,'',0,0,'C');
    $this->Cell(30,5,'',0,0,'C');
    $this->Cell(15,5,'',0,0,'C');
    $this->Cell(22,5,'',0,0,'C');
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(37,5,"TOTAL GANANCIAS",1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(30,5,utf8_decode(number_format($MargenBruto*100, 2, '.', ',')),1,0,'C');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',9);
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(80,6,'RECIBIDO:__________________________________',0,0,'');
    $this->Ln();
    $this->Cell(40,6,'',0,0,'');
    $this->Cell(140,6,'FECHA/HORA ELABORACIÓN:  '.date('d-m-Y h:i:s A'),0,0,'');
    $this->Cell(80,6,'',0,0,'');
    $this->Ln(4);
     }
############################################### FIN DE FUNCION LISTAR VENTAS DEL DIA PARA VENDEDOR ######################################################

##################################################################### CLASE VENTAS DE PRODUCTOS ####################################################################








































##################################################################### CLASE CREDITOS DE VENTAS ####################################################################

############################################### FUNCION TICKET DE ABONOS DE CREDITOS ######################################################

	  function TablaTicketCreditos()
   {
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$ve = new Login();
    $ve = $ve->CreditosPorId();
	
	$this->SetFont('courier','B',14);
	$this->SetFillColor(2,157,116);
	$this->SetXY(13, 6);
    $this->Cell(13, 5, "TICKET DE ABONO", 0 , 0);
	$this->Ln(5);
	
	$this->SetFont('courier','B',6);
	$this->SetFillColor(2,157,116);
	$this->SetXY(4, 13);
	$this->CellFitSpace(65,3,utf8_decode($con[0]['direcempresa']),0,1,'C');
	$this->SetXY(4, 15);
	$this->CellFitSpace(65,3,"RIF:".utf8_decode($con[0]['rifempresa']),0,1,'C');
	$this->SetXY(4, 17);
	$this->CellFitSpace(65,3,utf8_decode($con[0]['nomempresa']),0,1,'C');
	$this->SetXY(4, 19);
	$this->CellFitSpace(65,3,"TLF:".utf8_decode($con[0]['tlfempresa']),0,1,'C');
		
	$this->SetFont('courier','B',7);
	$this->SetFillColor(2,157,116);
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
	$this->SetXY(3, 25);
    $this->Cell(3, 5, "N° VENTA: ".utf8_decode($ve[0]['codventa']), 0 , 0);
	$this->SetXY(3, 28);
    $this->Cell(3, 5, "N° SERIE: ".utf8_decode($ve[0]['codserieve']), 0 , 0);
	$this->SetXY(3, 31);
    $this->Cell(3, 5, "N° AUTORIZACIÓN: ".utf8_decode($ve[0]['codautorizacionve']), 0 , 0);
	$this->SetXY(3, 34);
    $this->Cell(3, 5, "FECHA VENTA: ".utf8_decode($ve[0]['fechaventa']), 0 , 0);
	$this->SetXY(3, 37);
    $this->Cell(3, 5, "FECHA IMPRESIÓN: ".date("Y-m-d h:i:s A ",time()+1800), 0 , 0);
	
	$this->Ln(6);
	$this->SetXY(3, 44);
    $tra = new Login();
    $reg = $tra->VerDetallesVentas();
	$cantidad=0;
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	
	 $this->SetX(3);
     $this->SetFillColor(192);
     $this->SetDrawColor(3,3,3);
     $this->SetLineWidth(.2);
	 $this->SetFont('courier','',6);  
	 $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
	 $this->CellFitSpace(5,3,utf8_decode($reg[$i]["cantventa"]),0,0,'C');
     $this->CellFitSpace(45,3,utf8_decode($reg[$i]["producto"]),0,0,'L');
	 $this->CellFitSpace(17,3,utf8_decode(number_format($reg[$i]["precioventa"], 2, '.', ',')),0,0,'R');
     $this->Ln();	 
   }
   
    $this->Ln();
	$this->SetFont('courier','',6);
	$this->SetFillColor(2,157,116);
	$this->SetX(4);
	$this->CellFitSpace(60,3,"SUBTOTAL IVA ".$ve[0]["ivave"].'% : '.utf8_decode(number_format($ve[0]["subtotalivasive"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"SUBTOTAL IVA 0%: ".utf8_decode(number_format($ve[0]["subtotalivanove"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"IVA ".$ve[0]["ivave"].'% : '.utf8_decode(number_format($ve[0]["totalivave"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->SetFont('courier','',6);
	$this->CellFitSpace(60,3,"DESCUENTO ".$ve[0]["descuentove"].'% : '.utf8_decode(number_format($ve[0]["totaldescuentove"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->SetFont('courier','B',6);
	$this->CellFitSpace(60,3,"PRECIO FINAL: ".utf8_decode(number_format($ve[0]["totalpago"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"TIPO PAGO: ".utf8_decode($ve[0]['tipopagove']." - ".$ve[0]['formapagove']),0,1,'L');
	
	if($ve[0]['fechavencecredito']== '0000-00-00') { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"VENTA ".utf8_decode($ve[0]['statusventa']),0,1,'L');
	} elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"VENTA ".utf8_decode($ve[0]['statusventa']),0,1,'L');
	} elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"VENTA ".utf8_decode("VENCIDA"),0,1,'L');
	}	
	
	$this->SetX(4);
	$this->CellFitSpace(60,3,"FECHA DE VENCIMIENTO ".utf8_decode($vence = ( $ve[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($ve[0]['fechavencecredito'])))),0,1,'L');
	
	if($ve[0]['fechavencecredito']== '0000-00-00') { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"DIAS VENCIDOS ".utf8_decode($ve[0]['statusventa']),0,1,'L');
	} elseif($ve[0]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"DIAS VENCIDOS ".utf8_decode($ve[0]['statusventa']),0,1,'L');
	} elseif($ve[0]['fechavencecredito'] < date("Y-m-d")) { 
	$this->SetX(4);
	$this->CellFitSpace(60, 3,"DIAS VENCIDOS ".utf8_decode(Dias_Transcurridos(date("Y-m-d"),$ve[0]['fechavencecredito'])),0,1,'L');
	}

	
	if($ve[0]['tipopagove']=="CREDITO"){
	$this->SetX(4);
	$this->CellFitSpace(60,3,"TOTAL ABONO: ".utf8_decode(number_format($ve[0]["abonototal"], 2, '.', ',')),0,1,'L');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"TOTAL DEBE: ".utf8_decode(number_format($ve[0]["totalpago"]-$ve[0]["abonototal"], 2, '.', ',')),0,1,'L');
	}
	$this->SetX(4);
    $this->CellFitSpace(60, 3, "C.I/DNI CLIENTE: ".utf8_decode($ve[0]['cedcliente']),0,1,'L');
	$this->SetX(4);
    $this->CellFitSpace(60, 3, "NOMBRE DE CLIENTE: ".utf8_decode($ve[0]['nomcliente']),0,1,'L');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"EMPLEADO: ".utf8_decode($ve[0]['nombres']),0,1,'L');	
	
	$this->Ln(12);
	$logo = "./assets/img/barcode.png";
	$this->Cell(4,10,$this->Image($logo, $this->GetX()-4, $this->GetY()-7, 62),5,0,'C');
	
	$this->Ln(5);
	$this->SetFont('courier','B',5);
	$this->SetFillColor(2,157,116);
	$this->SetX(4);
	$this->CellFitSpace(65,2,"NOTA: DEBERÁ DE PRESENTAR ESTE TOCKET EN CASO ",0,1,'C');
	$this->SetX(4);
	$this->CellFitSpace(65,2,"DE RECLAMO SOBRE ALGÚN PRODUCTO DEFECTUOSO ",0,1,'C');
	
	
	$this->SetX(4);
	$this->Cell(60,3,"",0,1,'C');
	$this->SetX(4);
	$this->CellFitSpace(60,3,"CONFORME EL CLIENTE ______________________________________",0,1,'C');
    $this->Ln(8);
	
	$this->SetFont('Arial','B',14);
	$this->SetFillColor(2,157,116);
	$this->SetX(4);
	$this->CellFitSpace(65,3,"GRACIAS POR SU COMPRA",0,1,'C');
	
	//$this->SetXY(4, 94);
	$this->Codabar(6,-90,utf8_decode("111111222222333333444444555555666666777777888888999999"));

     }
############################################### FIN DE FUNCION TICKET DE ABONOS DE CREDITOS ######################################################


############################################### FUNCION LISTAR CREDITOS POR CLIENTES ######################################################
	  function TablaCreditosClientes()
   {
       //Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',10);
    //Movernos a la derecha
    $this->Cell(100);
    //Título
    $this->Cell(65,20,'LISTADO DE CRÉDITOS POR CLIENTES ',0,0,'C');
    //Salto de línea
    $this->Ln(25);	
	
	$tra = new Login();
    $reg = $tra->BuscarClientesAbonos();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA CLIENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($reg[0]['cedcliente']),0,0,'');
    $this->Cell(30,5,'NOMBRE CLIENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($reg[0]['nomcliente']),0,1,'');
	
    $this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO CLIENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($reg[0]['tlfcliente']),0,0,'');
    $this->Cell(30,5,'CORREO CLIENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($reg[0]['emailcliente']),0,1,'');
    $this->Ln(6);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(8,8,'N°',1,0,'C', True);
	$this->CellFitSpace(30,8,'CÓDIGO VENTA',1,0,'C', True);
	$this->CellFitSpace(18,8,'N° CAJA',1,0,'C', True);
	$this->CellFitSpace(17,8,'STATUS',1,0,'C', True);
	$this->CellFitSpace(20,8,'DIAS VENC',1,0,'C', True);
	$this->CellFitSpace(26,8,'FECHA VENTA',1,0,'C', True);
	$this->CellFitSpace(25,8,'TOT FACTURA',1,0,'C', True);
	$this->CellFitSpace(25,8,'TOT ABONO',1,0,'C', True);
	$this->CellFitSpace(20,8,'TOT DEBE',1,1,'C', True);
	
    $TotalFactura=0;
	$TotalCredito=0;
	$TotalDebe=0;
	$a=1;
	for($i=0;$i<sizeof($reg);$i++){  
	$TotalFactura+=$reg[$i]['totalpago'];
	$TotalCredito+=$reg[$i]['abonototal'];
	$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['abonototal'];

	$this->SetFont('courier','',7);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(8,5,$a++,1,0,'C');
	$this->CellFitSpace(30,5,$reg[$i]["codventa"],1,0,'C');
    $this->CellFitSpace(18,5,$reg[$i]['nrocaja'],1,0,'C');
	
	
	if($reg[$i]['fechavencecredito']== '0000-00-00') { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statusventa']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statusventa']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode("VENCIDA"),1,0,'C');
	}	
	if($reg[$i]['fechavencecredito']== '0000-00-00') { 
	$this->CellFitSpace(20, 5,utf8_decode("0"),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->CellFitSpace(20, 5,utf8_decode("0"),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { 
	$this->CellFitSpace(20, 5,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito'])),1,0,'C');
	}
	$this->CellFitSpace(26,5,date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa'])),1,0,'C');
    $this->CellFitSpace(25,5,number_format($reg[$i]['totalpago'], 2, '.', ','),1,0,'C');
	$this->CellFitSpace(25,5,number_format($reg[$i]['abonototal'], 2, '.', ','),1,0,'C');
	$this->CellFitSpace(20,5,number_format($reg[$i]['totalpago']-$reg[$i]['abonototal'], 2, '.', ','),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(8,5,'',0,0,'C');
    $this->Cell(30,5,'',0,0,'C');
    $this->Cell(18,5,'',0,0,'C');
    $this->Cell(17,5,'',0,0,'C'); 
    $this->Cell(20,5,'',0,0,'C');
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(26,5,'TOTAL GENERAL',1,0,'C', True);	
    $this->SetFont('courier','B',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(25,5,utf8_decode(number_format($TotalFactura, 2, '.', ',')),1,0,'C');
    $this->Cell(25,5,utf8_decode(number_format($TotalCredito, 2, '.', ',')),1,0,'C');
    $this->Cell(20,5,utf8_decode(number_format($TotalDebe, 2, '.', ',')),1,0,'C');
    $this->Ln();


   
   $this->Ln(15); 
  $this->SetFont('courier','B',9);
  $this->Cell(190,0,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]).'         RECIBIDO POR:___________________________','',1,'C');
  $this->Ln(4);
     }
	

############################################### FIN DE FUNCION LISTAR CREDITOS POR CLIENTES ######################################################

############################################### FUNCION LISTAR CREDITOS POR FECHAS ######################################################
	  function TablaCreditosFechas()
   {
       //Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',10);
    //Movernos a la derecha
    $this->Cell(100);
    //Título
    $this->Cell(110,20,'LISTADO DE CRÉDITOS PENDIENTES POR FECHAS '.$_GET["desde"].' HASTA '.$_GET["hasta"].'',0,0,'C');
    //Salto de línea
    $this->Ln(25);	
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(40,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA GERENTE: ',0,0,'');
	$this->Cell(45,5,$con[0]['cedresponsable'],0,0,'');
	$this->Cell(30,5,'NOMBRE GERENTE:',0,0,'');
	$this->Cell(83,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(40,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO GERENTE: ',0,0,'');
    $this->Cell(45,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->Cell(30,5,'CORREO GERENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(8,8,'N°',1,0,'C', True);
	$this->CellFitSpace(20,8,'CÉDULA',1,0,'C', True);
	$this->CellFitSpace(55,8,'NOMBRE CLIENTE',1,0,'C', True);
	$this->CellFitSpace(20,8,'N° CAJA',1,0,'C', True);
	$this->CellFitSpace(17,8,'STATUS',1,0,'C', True);
	$this->CellFitSpace(20,8,'DIAS VENC',1,0,'C', True);
	$this->CellFitSpace(30,8,'CÓDIGO VENTA',1,0,'C', True);
	$this->CellFitSpace(25,8,'FECHA VENTA',1,0,'C', True);
	$this->CellFitSpace(25,8,'TOT FACTURA',1,0,'C', True);
	$this->CellFitSpace(20,8,'TOT ABONO',1,0,'C', True);
	$this->CellFitSpace(20,8,'TOT DEBE',1,1,'C', True);
	
   	$tra = new Login();
    $reg = $tra->BuscarCreditosFechas(); 
	$TotalFactura=0;
	$TotalCredito=0;
	$TotalDebe=0;
	$a=1;
	for($i=0;$i<sizeof($reg);$i++){  
	$TotalFactura+=$reg[$i]['totalpago'];
	$TotalCredito+=$reg[$i]['abonototal'];
	$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['abonototal'];

	$this->SetFont('courier','',7);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(8,5,$a++,1,0,'C');
    $this->CellFitSpace(20,5,$reg[$i]['cedcliente'],1,0,'C');
	$this->CellFitSpace(55,5,$reg[$i]["nomcliente"],1,0,'C');
	$this->CellFitSpace(20,5,$reg[$i]['nrocaja'],1,0,'C');
	if($reg[$i]['fechavencecredito']== '0000-00-00') { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statusventa']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode($reg[$i]['statusventa']),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { 
	$this->CellFitSpace(17, 5,utf8_decode("VENCIDA"),1,0,'C');
	}	
	if($reg[$i]['fechavencecredito']== '0000-00-00') { 
	$this->CellFitSpace(20, 5,utf8_decode("0"),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { 
	$this->CellFitSpace(20, 5,utf8_decode("0"),1,0,'C');
	} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { 
	$this->CellFitSpace(20, 5,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito'])),1,0,'C');
	}
	$this->CellFitSpace(30,5,$reg[$i]["codventa"],1,0,'C');
	$this->CellFitSpace(25,5,date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa'])),1,0,'C');
    $this->CellFitSpace(25,5,number_format($reg[$i]['totalpago'], 2, '.', ','),1,0,'C');
	$this->CellFitSpace(20,5,number_format($reg[$i]['abonototal'], 2, '.', ','),1,0,'C');
	$this->CellFitSpace(20,5,number_format($reg[$i]['totalpago']-$reg[$i]['abonototal'], 2, '.', ','),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(8,5,'',0,0,'C');
    $this->Cell(20,5,'',0,0,'C');
    $this->Cell(55,5,'',0,0,'C');
    $this->Cell(20,5,'',0,0,'C');
    $this->Cell(17,5,'',0,0,'C');
    $this->Cell(20,5,'',0,0,'C');
    $this->Cell(30,5,'',0,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(25,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(25,5,utf8_decode(number_format($TotalFactura, 2, '.', ',')),1,0,'C');
    $this->Cell(20,5,utf8_decode(number_format($TotalCredito, 2, '.', ',')),1,0,'C');
    $this->Cell(20,5,utf8_decode(number_format($TotalDebe, 2, '.', ',')),1,0,'C');
    $this->Ln();


   
   $this->Ln(15); 
  $this->SetFont('courier','B',9);
  $this->Cell(250,0,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]).'         RECIBIDO POR:___________________________','',1,'C');
  $this->Ln(4);
     }
	

############################################### FIN DE FUNCION LISTAR CREDITOS POR FECHAS ######################################################

##################################################################### CLASE CREDITOS DE VENTAS ####################################################################

























































############################################################### CLASE DEVOLUCIONES DE PRODUCTOS #################################################################

############################################### FUNCION LISTAR FACTURA DE DEVOLUCIONES DE PRODUCTOS ######################################################

	  function TablaDevolucionesProductos()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 15 ,10, 55 , 17 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',15);
    //Movernos a la derecha
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$dev = new Login();
    $dev = $dev->DevolucionesPorId();
	
################################################# BLOQUE N° 1 ###################################################	

   //Bloque de membrete principal
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 10, 190, 17, '1.5', '');
	
	//Bloque de membrete principal
    $this->SetFillColor(199);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(98, 12, 18, 12, '1.5', 'F');
	//Bloque de membrete principal
    $this->SetFillColor(199);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(98, 12, 18, 12, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',16);
    $this->SetXY(104, 14);
    $this->Cell(26, 5, 'D', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(98, 19);
    $this->Cell(20, 5, 'Devolución', 0 , 0);
	
	
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',10);
    $this->SetXY(135, 10);
    $this->Cell(20, 5, 'N° DEVOLUCIÓN ', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(165, 10);
    $this->Cell(20, 5,utf8_decode($dev[0]['coddevolucion']), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 14);
    $this->Cell(20, 5, 'FECHA DEVOLUCIÓN ', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 14);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y h:i:s",strtotime($dev[0]['fechadevolucion']))), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 18);
    $this->Cell(20, 5, 'FECHA EMISIÓN', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 18);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y h:i:s")), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 22);
    $this->Cell(20, 5, 'N° DE CAJA', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 22);
    $this->Cell(20, 5,utf8_decode($dev[0]['nrocaja']), 0 , 0);
	
	
################################################# BLOQUE N° 2 ###################################################	

	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 29, 190, 18, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(15, 30);
    $this->Cell(20, 5, 'DATOS DE LA EMPRESA ', 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 34);
    $this->Cell(20, 5, 'RAZÓN SOCIAL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(40, 34);
    $this->Cell(20, 5,utf8_decode($con[0]['nomempresa']), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',7);
    $this->SetXY(147, 34);
    $this->Cell(90, 5, 'RIF :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(156, 34);
    $this->Cell(90, 5,utf8_decode($con[0]['rifempresa']), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 38);
    $this->Cell(20, 5, 'DIRECCIÓN :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(32, 38);
    $this->Cell(20, 5,utf8_decode($con[0]['direcempresa']), 0 , 0);
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',7);
    $this->SetXY(140, 38);
    $this->Cell(20, 5, 'TELÉFONO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(156, 38);
    $this->Cell(20, 5,utf8_decode($con[0]['tlfempresa']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 42);
    $this->Cell(20, 5, 'GERENTE :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(30, 42);
    $this->Cell(20, 5,utf8_decode($con[0]['nomresponsable']), 0 , 0);
	//Linea de membrete Nro 7
	$this->SetFont('courier','B',7);
    $this->SetXY(94, 42);
    $this->Cell(20, 5, 'CÉDULA :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(108, 42);
    $this->Cell(20, 5,utf8_decode($con[0]['cedresponsable']), 0 , 0);
	//Linea de membrete Nro 8
	$this->SetFont('courier','B',7);
    $this->SetXY(130, 42);
    $this->Cell(20, 5, 'EMAIL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(142, 42);
    $this->Cell(20, 5,utf8_decode($con[0]['correoresponsable']), 0 , 0);
	
################################################# BLOQUE N° 3 ###################################################	

	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 49, 190, 14, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(15, 50);
    $this->Cell(20, 5, 'DATOS DEL PROVEEDOR ', 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 54);
    $this->Cell(20, 5, 'RAZÓN SOCIAL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(36, 54);
    $this->Cell(20, 5,utf8_decode($dev[0]['nomproveedor']), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',7);
    $this->SetXY(100, 54);
    $this->Cell(70, 5, 'RIF :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(108, 54);
    $this->Cell(75, 5,utf8_decode($dev[0]['ritproveedor']), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',7);
    $this->SetXY(130, 54);
    $this->Cell(90, 5, 'EMAIL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(142, 54);
    $this->Cell(90, 5,utf8_decode($dev[0]['emailproveedor']), 0 , 0);
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 58);
    $this->Cell(20, 5, 'DIRECCIÓN :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(33, 58);
    $this->Cell(20, 5,utf8_decode($dev[0]['direcproveedor']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(90, 58);
    $this->Cell(20, 5, 'TELÉFONO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(108, 58);
    $this->Cell(20, 5,utf8_decode($dev[0]['tlfproveedor']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(130, 58);
    $this->Cell(20, 5, 'CONTACTO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(150, 58);
    $this->Cell(20, 5,utf8_decode($dev[0]['contactoproveedor']), 0 , 0);
	
	$this->Ln(7);
	$this->SetFont('courier','B',9);
	$this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
	$this->Cell(6,8,'N°',1,0,'C', True);
	$this->Cell(15,8,'CÓDIGO',1,0,'C', True);
	$this->Cell(50,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
	$this->Cell(29,8,'CATEGORIA',1,0,'C', True);
	$this->Cell(29,8,'PRECIO',1,0,'C', True);
	$this->Cell(16,8,'CANT',1,0,'C', True);
	$this->Cell(20,8,'LOTE',1,0,'C', True);
	//$this->Cell(20,8,'VENCE',1,0,'C', True);
	$this->Cell(25,8,'IMPORTE',1,1,'C', True);
	
	################################################# BLOQUE N° 4 DE DETALLES DE PRODUCTOS ###################################################	
	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 75, 190, 170, '1.5', '');
	
	$this->Ln(3);
    $tra = new Login();
    $reg = $tra->VerDetallesDevoluciones();
	$cantidad=0;
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$cantidad+=$reg[$i]['cantdevolucion'];
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(6,4,$a++,0,0,'C');
	$this->CellFitSpace(15,4,utf8_decode($reg[$i]["codproducto"]),0,0,'C');
    $this->CellFitSpace(50,4,utf8_decode($reg[$i]["producto"]),0,0,'C');
    $this->CellFitSpace(29,4,utf8_decode($reg[$i]["nomcategoria"]),0,0,'C');
	$this->CellFitSpace(29,4,utf8_decode(number_format($reg[$i]["preciodevolucion"], 2, '.', ',')),0,0,'C');
	$this->CellFitSpace(16,4,utf8_decode($reg[$i]["cantdevolucion"]),0,0,'C');
	$this->CellFitSpace(20,4,utf8_decode($reg[$i]["lotedevolucion"]),0,0,'C');
	//$this->CellFitSpace(20,4,utf8_decode($reg[$i]["cantdevolucion"]),0,0,'C');
	$this->CellFitSpace(25,4,utf8_decode(number_format($reg[$i]["importe"], 2, '.', ',')),0,0,'C');
    $this->Ln();
                                 }
    
	


################################################# BLOQUE N° 5 DE TOTALES ###################################################	
	//Bloque de Informacion adicional
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 250, 130, 25, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',12);
    $this->SetXY(46, 252);
    $this->Cell(20, 5, 'INFORMACIÓN ADICIONAL', 0 , 0);
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(12, 258);
    $this->Cell(20, 5, 'CANTIDAD DE PRODUCTOS :', 0 , 0);
    $this->SetXY(60, 258);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode($cantidad), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',9);
    $this->SetXY(12, 262);
    $this->Cell(20, 5, 'TIPO DE DOCUMENTO :', 0 , 0);
    $this->SetXY(60, 262);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode("FACTURA"), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetXY(52, 33);
	$this->Codabar(13,267,utf8_decode("133923786899444489448576556789"));
	//Linea de membrete Nro 2
    $this->SetFont('courier','B',7);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetXY(55, 268);
    $this->Cell(20, 5, 'Este documento no constituye un comprobante de pago.', 0 , 0);
	
	//Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(142, 250, 58, 25, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(143, 254);
    $this->Cell(20, 5, 'SUB  TOTAL :', 0 , 0);
    $this->SetXY(167, 254);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($dev[0]["subtotald"], 2, '.', ',')), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',9);
    $this->SetXY(143, 258);
    $this->Cell(20, 5, 'IVA '.$dev[0]["ivad"].'% :', 0 , 0);
    $this->SetXY(167, 258);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($dev[0]["totalivad"], 2, '.', ',')), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',9);
    $this->SetXY(143, 262);
    $this->Cell(20, 5, 'DESC 0% :', 0 , 0);
    $this->SetXY(167, 262);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode("0.00"), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',9);
    $this->SetXY(143, 266);
    $this->Cell(20, 5, 'TOTAL PAGO :', 0 , 0);
    $this->SetXY(167, 266);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($dev[0]["totald"], 2, '.', ',')), 0 , 0);
    
}
############################################### FIN DE FUNCION FACTURA DE DEVOLUCIONES DE PRODUCTOS ######################################################

############################################################## CLASE DEVOLUCIONES DE PRODUCTOS ####################################################################








































































##################################################################### CLASE SERVICIOS FACTURADOS ####################################################################

############################################### FUNCION LISTAR FACTURA DE SERVICIOS ######################################################

	  function TablaServicios()
   {
        //Logo
    $this->Image("./assets/img/logo.png" , 15 ,10, 55 , 17 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',15);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$se = new Login();
    $se = $se->ServiciosPorId();
	
################################################# BLOQUE N° 1 ###################################################	

   //Bloque de membrete principal
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 10, 190, 17, '1.5', '');
	
	//Bloque de membrete principal
    $this->SetFillColor(199);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(98, 12, 13, 13, '1.5', 'F');
	//Bloque de membrete principal
    $this->SetFillColor(199);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(98, 12, 13, 13, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',16);
    $this->SetXY(102, 14);
    $this->Cell(19, 5, 'S', 0 , 0);
	$this->SetFont('courier','B',7);
    $this->SetXY(98, 19);
    $this->Cell(20, 5, 'Servicio', 0 , 0);
	
	
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',10);
    $this->SetXY(135, 10);
    $this->Cell(20, 5, 'N° SERVICIO ', 0 , 0);
	$this->SetFont('courier','B',8);
    $this->SetXY(165, 10);
    $this->Cell(20, 5,utf8_decode($se[0]['codservicio']), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 13);
    $this->Cell(20, 5, 'FECHA SERVICIO ', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 13);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y h:i:s",strtotime($se[0]['fechaservicio']))), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 16);
    $this->Cell(20, 5, 'FECHA EMISIÓN', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 16);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y h:i:s")), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 19);
    $this->Cell(20, 5, 'N° DE CAJA', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 19);
    $this->Cell(20, 5,utf8_decode($se[0]['nrocaja']), 0 , 0);
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',8);
    $this->SetXY(135, 22);
    $this->Cell(20, 5, 'TIPO DE PAGO', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(165, 22);
    $this->Cell(20, 5,utf8_decode($se[0]['tipopago']), 0 , 0);
	
	
################################################# BLOQUE N° 2 ###################################################	

	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 29, 190, 18, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(15, 30);
    $this->Cell(20, 5, 'DATOS DE LA EMPRESA ', 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 34);
    $this->Cell(20, 5, 'RAZÓN SOCIAL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(40, 34);
    $this->Cell(20, 5,utf8_decode($con[0]['nomempresa']), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',7);
    $this->SetXY(147, 34);
    $this->Cell(90, 5, 'RIF :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(156, 34);
    $this->Cell(90, 5,utf8_decode($con[0]['rifempresa']), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 38);
    $this->Cell(20, 5, 'DIRECCIÓN :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(32, 38);
    $this->Cell(20, 5,utf8_decode($con[0]['direcempresa']), 0 , 0);
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',7);
    $this->SetXY(140, 38);
    $this->Cell(20, 5, 'TELÉFONO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(156, 38);
    $this->Cell(20, 5,utf8_decode($con[0]['tlfempresa']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 42);
    $this->Cell(20, 5, 'GERENTE :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(30, 42);
    $this->Cell(20, 5,utf8_decode($con[0]['nomresponsable']), 0 , 0);
	//Linea de membrete Nro 7
	$this->SetFont('courier','B',7);
    $this->SetXY(94, 42);
    $this->Cell(20, 5, 'CÉDULA :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(108, 42);
    $this->Cell(20, 5,utf8_decode($con[0]['cedresponsable']), 0 , 0);
	//Linea de membrete Nro 8
	$this->SetFont('courier','B',7);
    $this->SetXY(130, 42);
    $this->Cell(20, 5, 'EMAIL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(142, 42);
    $this->Cell(20, 5,utf8_decode($con[0]['correoresponsable']), 0 , 0);
	
################################################# BLOQUE N° 3 ###################################################	

	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 49, 190, 14, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(15, 50);
    $this->Cell(20, 5, 'DATOS DEL CLIENTE ', 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 54);
    $this->Cell(20, 5, 'RAZÓN SOCIAL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(38, 54);
    $this->Cell(20, 5,utf8_decode($se[0]['nomcliente']), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',7);
    $this->SetXY(112, 54);
    $this->Cell(74, 5, 'RIF :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(122, 54);
    $this->Cell(75, 5,utf8_decode($se[0]['cedcliente']), 0 , 0);
	//Linea de membrete Nro 4
	$this->SetFont('courier','B',7);
    $this->SetXY(150, 54);
    $this->Cell(90, 5, 'TELÉFONO :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(166, 54);
    $this->Cell(90, 5,utf8_decode($se[0]['tlfcliente']), 0 , 0);
	//Linea de membrete Nro 5
	$this->SetFont('courier','B',7);
    $this->SetXY(15, 58);
    $this->Cell(20, 5, 'DIRECCIÓN :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(33, 58);
    $this->Cell(20, 5,utf8_decode($se[0]['direccliente']), 0 , 0);
	//Linea de membrete Nro 6
	$this->SetFont('courier','B',7);
    $this->SetXY(116, 58);
    $this->Cell(20, 5, 'EMAIL :', 0 , 0);
	$this->SetFont('courier','',7);
    $this->SetXY(128, 58);
    $this->Cell(20, 5,utf8_decode($se[0]['emailcliente']), 0 , 0);
	
	$this->Ln(7);
	$this->SetFont('courier','B',10);
	$this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
	$this->Cell(8,8,'N°',1,0,'C', True);
	$this->Cell(19,8,'CÓDIGO',1,0,'C', True);
	$this->Cell(95,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
	$this->Cell(22,8,'PRECIO',1,0,'C', True);
	$this->Cell(22,8,'CANTIDAD',1,0,'C', True);
	$this->Cell(24,8,'IMPORTE',1,1,'C', True);
	
	################################################# BLOQUE N° 4 DE DETALLES DE PRODUCTOS ###################################################	
	//Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 75, 190, 170, '1.5', '');
	
	$this->Ln(3);
    $tra = new Login();
    $reg = $tra->VerDetallesServicios();
	$cantidad=0;
	$a=1;
    for($i=0;$i<sizeof($reg);$i++){
	$cantidad+=$reg[$i]['cantservicio'];
	$this->SetFont('courier','',7);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(8,4,$a++,0,0,'C');
	$this->CellFitSpace(19,4,utf8_decode($reg[$i]["coditems"]),0,0,'C');
    $this->CellFitSpace(95,4,utf8_decode($reg[$i]["nombreitems"]),0,0,'C');
    $this->CellFitSpace(22,4,utf8_decode(number_format($reg[$i]["precioservicio"], 2, '.', ',')),0,0,'C');
	$this->CellFitSpace(22,4,utf8_decode($reg[$i]["cantservicio"]),0,0,'C');
	$this->CellFitSpace(24,4,utf8_decode(number_format($reg[$i]["importe"], 2, '.', ',')),0,0,'C');
    $this->Ln();
                                 }
    
	


################################################# BLOQUE N° 5 DE TOTALES ###################################################	
	//Bloque de Informacion adicional
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(10, 250, 130, 25, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',12);
    $this->SetXY(46, 252);
    $this->Cell(20, 5, 'INFORMACIÓN ADICIONAL', 0 , 0);
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(12, 258);
    $this->Cell(20, 5, 'CANTIDAD DE SERVICIOS :', 0 , 0);
    $this->SetXY(60, 258);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode($cantidad), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',9);
    $this->SetXY(12, 262);
    $this->Cell(20, 5, 'TIPO DE DOCUMENTO :', 0 , 0);
    $this->SetXY(60, 262);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode("FACTURA"), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetXY(52, 33);
	$this->Codabar(13,267,utf8_decode("133923786899444489448576556789"));
	//Linea de membrete Nro 2
    $this->SetFont('courier','B',7);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetXY(55, 268);
    $this->Cell(20, 5, 'Este documento no constituye un comprobante de pago.', 0 , 0);
	
	//Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(142, 250, 58, 25, '1.5', '');
	//Linea de membrete Nro 1
	$this->SetFont('courier','B',9);
    $this->SetXY(143, 254);
    $this->Cell(20, 5, 'SUB  TOTAL :', 0 , 0);
    $this->SetXY(167, 254);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($se[0]["subtotal"], 2, '.', '.,')), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',9);
    $this->SetXY(143, 258);
    $this->Cell(20, 5, 'IVA '.$se[0]["iva"].'% :', 0 , 0);
    $this->SetXY(167, 258);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($se[0]["totaliva"], 2, '.', ',')), 0 , 0);
	//Linea de membrete Nro 3
	$this->SetFont('courier','B',9);
    $this->SetXY(143, 262);
    $this->Cell(20, 5, 'DESC '.$se[0]["descuento"].'% :', 0 , 0);
    $this->SetXY(167, 262);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($se[0]["totaldescuento"], 2, '.', ',')), 0 , 0);
	//Linea de membrete Nro 2
	$this->SetFont('courier','B',9);
    $this->SetXY(143, 266);
    $this->Cell(20, 5, 'TOTAL PAGO :', 0 , 0);
    $this->SetXY(167, 266);
	$this->SetFont('courier','',9);
    $this->Cell(20, 5,utf8_decode(number_format($se[0]["totalpago"], 2, '.', ',')), 0 , 0);
     }
	

############################################### FIN DE FUNCION FACTURA DE SERVICIOS ######################################################

############################################### FUNCION LISTAR SERVICIOS FACTURADOS POR FECHAS ######################################################

	  function TablaServiciosFechas()
   {
       //Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',10);
    //Movernos a la derecha
    $this->Cell(100);
    //Título
    $this->Cell(65,20,'LISTADO DE SERVICIOS DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"].'',0,0,'C');
    //Salto de línea
    $this->Ln(25);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA GERENTE: ',0,0,'');
	$this->Cell(44,5,$con[0]['cedresponsable'],0,0,'');
	$this->Cell(30,5,'NOMBRE GERENTE:',0,0,'');
	$this->Cell(83,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO GERENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->Cell(30,5,'CORREO GERENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(8,8,'N°',1,0,'C', True);
	$this->CellFitSpace(30,8,'CÓDIGO SERVICIO',1,0,'C', True);
	$this->CellFitSpace(18,8,'N° CAJA',1,0,'C', True);
	$this->CellFitSpace(28,8,'FECHA SERVICIO',1,0,'C', True);
	$this->CellFitSpace(20,8,'SERVICIOS',1,0,'C', True);
	$this->CellFitSpace(25,8,'SUBTOTAL',1,0,'C', True);
	$this->CellFitSpace(20,8,'IVA',1,0,'C', True);
	$this->CellFitSpace(20,8,'DESCUENTO',1,0,'C', True);
	$this->CellFitSpace(26,8,'TOTAL PAGO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->BuscarServiciosFechas();
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
	$this->SetFont('courier','',7);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(8,5,$a++,1,0,'C');
	$this->CellFitSpace(30,5,$reg[$i]["codservicio"],1,0,'C');
    $this->CellFitSpace(18,5,utf8_decode($reg[$i]["nrocaja"]),1,0,'C');
	$this->CellFitSpace(28,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fechaservicio']))),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode($reg[$i]["cantidad"]),1,0,'C');
	$this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]['subtotal'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode(number_format($reg[$i]['totaliva'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(20,5,utf8_decode(number_format($reg[$i]['totaldescuento'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(26,5,utf8_decode(number_format($reg[$i]['totalpago'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(8,5,'',1,0,'C');
    $this->Cell(30,5,'',1,0,'C');
    $this->Cell(18,5,'',1,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(28,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(20,5,utf8_decode($serviciosTotal),1,0,'C');
    $this->Cell(25,5,utf8_decode(number_format($pagoSubtotal, 2, '.', ',')),1,0,'C');
    $this->Cell(20,5,utf8_decode(number_format($pagoIva, 2, '.', ',')),1,0,'C');
    $this->Cell(20,5,utf8_decode(number_format($pagoDescuento, 2, '.', ',')),1,0,'C');  
    $this->CellFitSpace(26,5,utf8_decode(number_format($pagoTotal, 2, '.', ',')),1,0,'C');
    $this->Ln();

   
   $this->Ln(15); 
  $this->SetFont('courier','B',9);
  $this->Cell(190,0,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]).'         RECIBIDO POR:___________________________','',1,'C');
  $this->Ln(4);
     }
	

############################################### FIN DE FUNCION LISTAR SERVICIOS FACTURADOS POR FECHAS ######################################################

############################################### FUNCION LISTAR VENTAS POR FECHAS Y CAJAS DE VENTAS ######################################################

	  function TablaServiciosCajas()
   {
    $ca = new Login(); 
	$ca = $ca->CajerosPorId();	
	
	//Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");
	$this->SetXY(10, 15);
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(75,6,'',0,0,'');
	$this->Cell(120,6,'LISTADO DE SERVICIOS DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"],0,1,'C');
       
	$this->Cell(75,6,'',0,0,'');
    $this->Cell(120,6,'Y CAJA N°.'.$ca[0]['nrocaja'],0,0,'C');
    //Salto de línea
    $this->Ln(15);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA GERENTE: ',0,0,'');
	$this->Cell(44,5,$con[0]['cedresponsable'],0,0,'');
	$this->Cell(30,5,'NOMBRE GERENTE:',0,0,'');
	$this->Cell(83,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO GERENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->Cell(30,5,'CORREO GERENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(32,8,'CÓDIGO SERVICIO',1,0,'C', True);
	$this->CellFitSpace(32,8,'FECHA SERVICIO',1,0,'C', True);
	$this->CellFitSpace(22,8,'SERVICIOS',1,0,'C', True);
	$this->CellFitSpace(25,8,'SUBTOTAL',1,0,'C', True);
	$this->CellFitSpace(22,8,'IVA',1,0,'C', True);
	$this->CellFitSpace(22,8,'DESCUENTO',1,0,'C', True);
	$this->CellFitSpace(26,8,'TOTAL PAGO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->BuscarServiciosCajas();
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
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(32,5,$reg[$i]["codservicio"],1,0,'C');
	$this->CellFitSpace(32,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fechaservicio']))),1,0,'C');
	$this->CellFitSpace(22,5,utf8_decode($reg[$i]["cantidad"]),1,0,'C');
	$this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]['subtotal'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(22,5,utf8_decode(number_format($reg[$i]['totaliva'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(22,5,utf8_decode(number_format($reg[$i]['totaldescuento'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(26,5,utf8_decode(number_format($reg[$i]['totalpago'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(10,5,'',1,0,'C');
    $this->Cell(32,5,'',1,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(32,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(22,5,utf8_decode($serviciosTotal),1,0,'C');
    $this->Cell(25,5,utf8_decode(number_format($pagoSubtotal, 2, '.', ',')),1,0,'C');
    $this->Cell(22,5,utf8_decode(number_format($pagoIva, 2, '.', ',')),1,0,'C');
    $this->Cell(22,5,utf8_decode(number_format($pagoDescuento, 2, '.', ',')),1,0,'C');  
    $this->CellFitSpace(26,5,utf8_decode(number_format($pagoTotal, 2, '.', ',')),1,0,'C');
    $this->Ln();

   
   $this->Ln(15); 
  $this->SetFont('courier','B',9);
  $this->Cell(190,0,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]).'         RECIBIDO POR:___________________________','',1,'C');
  $this->Ln(4);
     }
	

############################################### FIN DE FUNCION LISTAR VENTAS POR FECHAS Y CAJAS DE VENTAS ######################################################

############################################### FUNCION LISTAR SERVICIOS FACTURADOS ######################################################

	  function TablaServiciosFacturados()
   {
      //Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");
	$this->SetXY(10, 15);
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(75,6,'',0,0,'');
	$this->Cell(120,6,'LISTADO DE SERVICIOS FACTURADOS POR FECHAS ',0,1,'C');
       
	$this->Cell(75,6,'',0,0,'');
    $this->Cell(120,6,' DESDE '.$_GET["desde"].' HASTA '.$_GET["hasta"],0,0,'C');
    //Salto de línea
    $this->Ln(15);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA GERENTE: ',0,0,'');
	$this->Cell(44,5,$con[0]['cedresponsable'],0,0,'');
	$this->Cell(30,5,'NOMBRE GERENTE:',0,0,'');
	$this->Cell(83,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO GERENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->Cell(30,5,'CORREO GERENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(8,8,'N°',1,0,'C', True);
	$this->CellFitSpace(20,8,'CÓDIGO',1,0,'C', True);
	$this->CellFitSpace(90,8,'DESCRIPCIÓN DE SERVICIO',1,0,'C', True);
	$this->CellFitSpace(25,8,'COSTO',1,0,'C', True);
	$this->CellFitSpace(25,8,'FACTURADOS',1,0,'C', True);
	$this->CellFitSpace(26,8,'MONTO TOTAL',1,1,'C', True);
	
    $ve = new Login();
	$reg = $ve->BuscarServicios();
	$serviciosTotal=0;
	$pagoTotal=0;
	$a=1;
	for($i=0;$i<sizeof($reg);$i++){
	$serviciosTotal+=$reg[$i]['cantidad']; 
	$pagoTotal+=$reg[$i]['precioservicio']*$reg[$i]['cantidad'];
	$this->SetFont('courier','',7);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(8,5,$a++,1,0,'C');
	$this->CellFitSpace(20,5,$reg[$i]["coditems"],1,0,'C');
    $this->CellFitSpace(90,5,utf8_decode($reg[$i]["nombreitems"]),1,0,'C');
	$this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]["precioservicio"], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(25,5,utf8_decode($reg[$i]["cantidad"]),1,0,'C');
	$this->CellFitSpace(26,5,utf8_decode(number_format($reg[$i]['precioservicio']*$reg[$i]['cantidad'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(8,5,'',1,0,'C');
    $this->Cell(20,5,'',1,0,'C');
    $this->Cell(90,5,'',1,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(25,5,'TOTALES',1,0,'C', True);
    $this->SetFont('courier','B',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(25,5,utf8_decode($serviciosTotal),1,0,'C');  
    $this->CellFitSpace(26,5,utf8_decode(number_format($pagoTotal, 2, '.', ',')),1,0,'C');
    $this->Ln();

   
   $this->Ln(15); 
  $this->SetFont('courier','B',9);
  $this->Cell(190,0,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]).'         RECIBIDO POR:___________________________','',1,'C');
  $this->Ln(4);
     }
	

############################################### FIN DE FUNCION LISTAR SERVICIOS FACTURADOS ######################################################

############################################### FUNCION LISTAR SERVICIOS DIARIOS POR ADMINISTRADOR ######################################################

	  function TablaServiciosDiariasAdmin()
   {
       //Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");  
    //Arial bold 15
    $this->SetFont('Courier','B',10);
    //Movernos a la derecha
    $this->Cell(100);
    //Título
    $this->Cell(65,20,'LISTADO DE SERVICIOS DEL DIA '.date("Y-m-d").'',0,0,'C');
    //Salto de línea
    $this->Ln(25);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA GERENTE: ',0,0,'');
	$this->Cell(44,5,$con[0]['cedresponsable'],0,0,'');
	$this->Cell(30,5,'NOMBRE GERENTE:',0,0,'');
	$this->Cell(83,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO GERENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->Cell(30,5,'CORREO GERENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(8,8,'N°',1,0,'C', True);
	$this->CellFitSpace(30,8,'CÓDIGO SERVICIO',1,0,'C', True);
	$this->CellFitSpace(18,8,'N° CAJA',1,0,'C', True);
	$this->CellFitSpace(28,8,'FECHA SERVICIO',1,0,'C', True);
	$this->CellFitSpace(20,8,'SERVICIOS',1,0,'C', True);
	$this->CellFitSpace(25,8,'SUBTOTAL',1,0,'C', True);
	$this->CellFitSpace(20,8,'IVA',1,0,'C', True);
	$this->CellFitSpace(20,8,'DESCUENTO',1,0,'C', True);
	$this->CellFitSpace(26,8,'TOTAL PAGO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarServiciosDiarias();
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
	$this->SetFont('courier','',7);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(8,5,$a++,1,0,'C');
	$this->CellFitSpace(30,5,$reg[$i]["codservicio"],1,0,'C');
    $this->CellFitSpace(18,5,utf8_decode($reg[$i]["nrocaja"]),1,0,'C');
	$this->CellFitSpace(28,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fechaservicio']))),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode($reg[$i]["cantidad"]),1,0,'C');
	$this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]['subtotal'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(20,5,utf8_decode(number_format($reg[$i]['totaliva'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(20,5,utf8_decode(number_format($reg[$i]['totaldescuento'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(26,5,utf8_decode(number_format($reg[$i]['totalpago'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(8,5,'',1,0,'C');
    $this->Cell(30,5,'',1,0,'C');
    $this->Cell(18,5,'',1,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(28,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(20,5,utf8_decode($serviciosTotal),1,0,'C');
    $this->Cell(25,5,utf8_decode(number_format($pagoSubtotal, 2, '.', ',')),1,0,'C');
    $this->Cell(20,5,utf8_decode(number_format($pagoIva, 2, '.', ',')),1,0,'C');
    $this->Cell(20,5,utf8_decode(number_format($pagoDescuento, 2, '.', ',')),1,0,'C');  
    $this->CellFitSpace(26,5,utf8_decode(number_format($pagoTotal, 2, '.', ',')),1,0,'C');
    $this->Ln();

   
   $this->Ln(15); 
  $this->SetFont('courier','B',9);
  $this->Cell(190,0,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]).'         RECIBIDO POR:___________________________','',1,'C');
  $this->Ln(4);
     }
	

############################################### FIN DE FUNCION LISTAR SERVICIOS DIARIOS POR ADMINISTRADOR ######################################################

############################################### FUNCION LISTAR SERVICIOS DIARIOS POR VENDEDOR ######################################################

	  function TablaServiciosDiariasVendedor()
   {	
	
	//Logo
    $this->Image("./assets/img/logo.png" , 20 ,12, 60 , 20 , "PNG");
	$this->SetXY(10, 15);
	$this->SetFont('courier','B',10);
	$this->SetFillColor(2,157,116);
	$this->Cell(75,6,'',0,0,'');
	$this->Cell(120,6,'LISTADO DE SERVICIOS DEL DIA '.date("Y-m-d"),0,1,'C');
       
	$this->Cell(75,6,'',0,0,'');
    $this->Cell(120,6,'DE CAJA N°.'.base64_decode($_GET['caja']),0,0,'C');
    //Salto de línea
    $this->Ln(15);
	
	$con = new Login();
    $con = $con->ConfiguracionPorId();
	
	$this->SetFont('courier','B',9);
	$this->SetFillColor(2,157,116);
	$this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'CÉDULA GERENTE: ',0,0,'');
	$this->Cell(44,5,$con[0]['cedresponsable'],0,0,'');
	$this->Cell(30,5,'NOMBRE GERENTE:',0,0,'');
	$this->Cell(83,5,$con[0]['nomresponsable'],0,1,'');
       
    $this->Cell(10,5,'',0,0,'');
	$this->Cell(35,5,'TELÉFONO GERENTE: ',0,0,'');
    $this->Cell(44,5,utf8_decode($con[0]['tlfresponsable']),0,0,'');
    $this->Cell(30,5,'CORREO GERENTE:',0,0,'');
    $this->Cell(83,5,utf8_decode($con[0]['correoresponsable']),0,0,'');
    $this->Ln(8);
	
	$this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(249, 187, 31); // establece el color del fondo de la celda (en este caso es NARANJA)
	$this->CellFitSpace(10,8,'N°',1,0,'C', True);
	$this->CellFitSpace(32,8,'CÓDIGO SERVICIO',1,0,'C', True);
	$this->CellFitSpace(32,8,'FECHA SERVICIO',1,0,'C', True);
	$this->CellFitSpace(22,8,'SERVICIOS',1,0,'C', True);
	$this->CellFitSpace(25,8,'SUBTOTAL',1,0,'C', True);
	$this->CellFitSpace(22,8,'IVA',1,0,'C', True);
	$this->CellFitSpace(22,8,'DESCUENTO',1,0,'C', True);
	$this->CellFitSpace(26,8,'TOTAL PAGO',1,1,'C', True);
	
    $tra = new Login();
    $reg = $tra->ListarServiciosDiarias();
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
	$this->SetFont('courier','',8);  
	$this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(10,5,$a++,1,0,'C');
	$this->CellFitSpace(32,5,$reg[$i]["codservicio"],1,0,'C');
	$this->CellFitSpace(32,5,utf8_decode(date("d-m-Y h:i:s",strtotime($reg[$i]['fechaservicio']))),1,0,'C');
	$this->CellFitSpace(22,5,utf8_decode($reg[$i]["cantidad"]),1,0,'C');
	$this->CellFitSpace(25,5,utf8_decode(number_format($reg[$i]['subtotal'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(22,5,utf8_decode(number_format($reg[$i]['totaliva'], 2, '.', ',')),1,0,'C');
    $this->CellFitSpace(22,5,utf8_decode(number_format($reg[$i]['totaldescuento'], 2, '.', ',')),1,0,'C');
	$this->CellFitSpace(26,5,utf8_decode(number_format($reg[$i]['totalpago'], 2, '.', ',')),1,0,'C');
    $this->Ln();
	
   } 
   
	$this->Cell(10,5,'',1,0,'C');
    $this->Cell(32,5,'',1,0,'C');	
    $this->SetFont('courier','B',9);
	$this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(32,5,'TOTAL GENERAL',1,0,'C', True);
    $this->SetFont('courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(22,5,utf8_decode($serviciosTotal),1,0,'C');
    $this->Cell(25,5,utf8_decode(number_format($pagoSubtotal, 2, '.', ',')),1,0,'C');
    $this->Cell(22,5,utf8_decode(number_format($pagoIva, 2, '.', ',')),1,0,'C');
    $this->Cell(22,5,utf8_decode(number_format($pagoDescuento, 2, '.', ',')),1,0,'C');  
    $this->CellFitSpace(26,5,utf8_decode(number_format($pagoTotal, 2, '.', ',')),1,0,'C');
    $this->Ln();

   
   $this->Ln(15); 
  $this->SetFont('courier','B',9);
  $this->Cell(190,0,'ELABORADO POR: '.utf8_decode($_SESSION["nombres"]).'         RECIBIDO POR:___________________________','',1,'C');
  $this->Ln(4);
     }
	

############################################### FIN DE FUNCION LISTAR SERVICIOS DIARIOS POR VENDEDOR ######################################################

##################################################################### CLASE SERVICIOS FACTURADOS ####################################################################




















































   
########################################################## AQUI COMIENZA CODIGO PARA AJUSTAR TEXTO #############################################################

########### FUNCION PARA CODIGO DE BARRA CON CODE39 ############
function Code39($x, $y, $code, $ext = true, $cks = false, $w = 0.4, $h = 20, $wide = true) {

    //Display code
    $this->SetFont('Arial', '', 10);
    $this->Text($x, $y+$h+4, $code);

    if($ext) {
        //Extended encoding
        $code = $this->encode_code39_ext($code);
    }
    else {
        //Convert to upper case
        $code = strtoupper($code);
        //Check validity
        if(!preg_match('|^[0-9A-Z. $/+%-]*$|', $code))
            $this->Error('Invalid barcode value: '.$code);
    }

    //Compute checksum
    if ($cks)
        $code .= $this->checksum_code39($code);

    //Add start and stop characters
    $code = '*'.$code.'*';

    //Conversion tables
    $narrow_encoding = array (
        '0' => '101001101101', '1' => '110100101011', '2' => '101100101011', 
        '3' => '110110010101', '4' => '101001101011', '5' => '110100110101', 
        '6' => '101100110101', '7' => '101001011011', '8' => '110100101101', 
        '9' => '101100101101', 'A' => '110101001011', 'B' => '101101001011', 
        'C' => '110110100101', 'D' => '101011001011', 'E' => '110101100101', 
        'F' => '101101100101', 'G' => '101010011011', 'H' => '110101001101', 
        'I' => '101101001101', 'J' => '101011001101', 'K' => '110101010011', 
        'L' => '101101010011', 'M' => '110110101001', 'N' => '101011010011', 
        'O' => '110101101001', 'P' => '101101101001', 'Q' => '101010110011', 
        'R' => '110101011001', 'S' => '101101011001', 'T' => '101011011001', 
        'U' => '110010101011', 'V' => '100110101011', 'W' => '110011010101', 
        'X' => '100101101011', 'Y' => '110010110101', 'Z' => '100110110101', 
        '-' => '100101011011', '.' => '110010101101', ' ' => '100110101101', 
        '*' => '100101101101', '$' => '100100100101', '/' => '100100101001', 
        '+' => '100101001001', '%' => '101001001001' );

    $wide_encoding = array (
        '0' => '101000111011101', '1' => '111010001010111', '2' => '101110001010111', 
        '3' => '111011100010101', '4' => '101000111010111', '5' => '111010001110101', 
        '6' => '101110001110101', '7' => '101000101110111', '8' => '111010001011101', 
        '9' => '101110001011101', 'A' => '111010100010111', 'B' => '101110100010111', 
        'C' => '111011101000101', 'D' => '101011100010111', 'E' => '111010111000101', 
        'F' => '101110111000101', 'G' => '101010001110111', 'H' => '111010100011101', 
        'I' => '101110100011101', 'J' => '101011100011101', 'K' => '111010101000111', 
        'L' => '101110101000111', 'M' => '111011101010001', 'N' => '101011101000111', 
        'O' => '111010111010001', 'P' => '101110111010001', 'Q' => '101010111000111', 
        'R' => '111010101110001', 'S' => '101110101110001', 'T' => '101011101110001', 
        'U' => '111000101010111', 'V' => '100011101010111', 'W' => '111000111010101', 
        'X' => '100010111010111', 'Y' => '111000101110101', 'Z' => '100011101110101', 
        '-' => '100010101110111', '.' => '111000101011101', ' ' => '100011101011101', 
        '*' => '100010111011101', '$' => '100010001000101', '/' => '100010001010001', 
        '+' => '100010100010001', '%' => '101000100010001');

    $encoding = $wide ? $wide_encoding : $narrow_encoding;

    //Inter-character spacing
    $gap = ($w > 0.29) ? '00' : '0';

    //Convert to bars
    $encode = '';
    for ($i = 0; $i< strlen($code); $i++)
        $encode .= $encoding[$code[$i]].$gap;

    //Draw bars
    $this->draw_code39($encode, $x, $y, $w, $h);
}

function checksum_code39($code) {

    //Compute the modulo 43 checksum

    $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
                            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 
                            'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 
                            'W', 'X', 'Y', 'Z', '-', '.', ' ', '$', '/', '+', '%');
    $sum = 0;
    for ($i=0 ; $i<strlen($code); $i++) {
        $a = array_keys($chars, $code[$i]);
        $sum += $a[0];
    }
    $r = $sum % 43;
    return $chars[$r];
}

function encode_code39_ext($code) {

    //Encode characters in extended mode

    $encode = array(
        chr(0) => '%U', chr(1) => '$A', chr(2) => '$B', chr(3) => '$C', 
        chr(4) => '$D', chr(5) => '$E', chr(6) => '$F', chr(7) => '$G', 
        chr(8) => '$H', chr(9) => '$I', chr(10) => '$J', chr(11) => '£K', 
        chr(12) => '$L', chr(13) => '$M', chr(14) => '$N', chr(15) => '$O', 
        chr(16) => '$P', chr(17) => '$Q', chr(18) => '$R', chr(19) => '$S', 
        chr(20) => '$T', chr(21) => '$U', chr(22) => '$V', chr(23) => '$W', 
        chr(24) => '$X', chr(25) => '$Y', chr(26) => '$Z', chr(27) => '%A', 
        chr(28) => '%B', chr(29) => '%C', chr(30) => '%D', chr(31) => '%E', 
        chr(32) => ' ', chr(33) => '/A', chr(34) => '/B', chr(35) => '/C', 
        chr(36) => '/D', chr(37) => '/E', chr(38) => '/F', chr(39) => '/G', 
        chr(40) => '/H', chr(41) => '/I', chr(42) => '/J', chr(43) => '/K', 
        chr(44) => '/L', chr(45) => '-', chr(46) => '.', chr(47) => '/O', 
        chr(48) => '0', chr(49) => '1', chr(50) => '2', chr(51) => '3', 
        chr(52) => '4', chr(53) => '5', chr(54) => '6', chr(55) => '7', 
        chr(56) => '8', chr(57) => '9', chr(58) => '/Z', chr(59) => '%F', 
        chr(60) => '%G', chr(61) => '%H', chr(62) => '%I', chr(63) => '%J', 
        chr(64) => '%V', chr(65) => 'A', chr(66) => 'B', chr(67) => 'C', 
        chr(68) => 'D', chr(69) => 'E', chr(70) => 'F', chr(71) => 'G', 
        chr(72) => 'H', chr(73) => 'I', chr(74) => 'J', chr(75) => 'K', 
        chr(76) => 'L', chr(77) => 'M', chr(78) => 'N', chr(79) => 'O', 
        chr(80) => 'P', chr(81) => 'Q', chr(82) => 'R', chr(83) => 'S', 
        chr(84) => 'T', chr(85) => 'U', chr(86) => 'V', chr(87) => 'W', 
        chr(88) => 'X', chr(89) => 'Y', chr(90) => 'Z', chr(91) => '%K', 
        chr(92) => '%L', chr(93) => '%M', chr(94) => '%N', chr(95) => '%O', 
        chr(96) => '%W', chr(97) => '+A', chr(98) => '+B', chr(99) => '+C', 
        chr(100) => '+D', chr(101) => '+E', chr(102) => '+F', chr(103) => '+G', 
        chr(104) => '+H', chr(105) => '+I', chr(106) => '+J', chr(107) => '+K', 
        chr(108) => '+L', chr(109) => '+M', chr(110) => '+N', chr(111) => '+O', 
        chr(112) => '+P', chr(113) => '+Q', chr(114) => '+R', chr(115) => '+S', 
        chr(116) => '+T', chr(117) => '+U', chr(118) => '+V', chr(119) => '+W', 
        chr(120) => '+X', chr(121) => '+Y', chr(122) => '+Z', chr(123) => '%P', 
        chr(124) => '%Q', chr(125) => '%R', chr(126) => '%S', chr(127) => '%T');

    $code_ext = '';
    for ($i = 0 ; $i<strlen($code); $i++) {
        if (ord($code[$i]) > 127)
            $this->Error('Invalid character: '.$code[$i]);
        $code_ext .= $encode[$code[$i]];
    }
    return $code_ext;
}

function draw_code39($code, $x, $y, $w, $h) {

    //Draw bars

    for($i=0; $i<strlen($code); $i++) {
        if($code[$i] == '1')
            $this->Rect($x+$i*$w, $y, $w, $h, 'F');
    }
}


########### FUNCION PARA CODIGO DE BARRA CON EAN13 ############
function EAN13($x, $y, $barcode, $h=16, $w=.35)
{
 $this->Barcode($x,$y,$barcode,$h,$w,13);
}
function UPC_A($x, $y, $barcode, $h=16, $w=.35)
{
 $this->Barcode($x,$y,$barcode,$h,$w,12);
}
function GetCheckDigit($barcode)
{
 //Compute the check digit
 $sum=0;
 for($i=1;$i<=11;$i+=2)
 $sum+=3*$barcode[$i];
 for($i=0;$i<=10;$i+=2)
 $sum+=$barcode[$i];
 $r=$sum%10;
 if($r>0)
 $r=10-$r;
 return $r;
}
function TestCheckDigit($barcode)
{
 //Test validity of check digit
 $sum=0;
 for($i=1;$i<=11;$i+=2)
 $sum+=3*$barcode[$i];
 for($i=0;$i<=10;$i+=2)
 $sum+=$barcode[$i];
 return ($sum+$barcode[12])%10==0;
}
function Barcode($x, $y, $barcode, $h, $w, $len)
{
 //Padding
 $barcode=str_pad($barcode,$len-1,'0',STR_PAD_LEFT);
 if($len==12)
 $barcode='0'.$barcode;
 //Add or control the check digit
 if(strlen($barcode)==12)
 $barcode.=$this->GetCheckDigit($barcode);
 elseif(!$this->TestCheckDigit($barcode))
 $this->Error('Incorrect check digit');
 //Convert digits to bars
 $codes=array(
 'A'=>array(
 '0'=>'0001101','1'=>'0011001','2'=>'0010011','3'=>'0111101','4'=>'0100011',
 '5'=>'0110001','6'=>'0101111','7'=>'0111011','8'=>'0110111','9'=>'0001011'),
 'B'=>array(
 '0'=>'0100111','1'=>'0110011','2'=>'0011011','3'=>'0100001','4'=>'0011101',
 '5'=>'0111001','6'=>'0000101','7'=>'0010001','8'=>'0001001','9'=>'0010111'),
 'C'=>array(
 '0'=>'1110010','1'=>'1100110','2'=>'1101100','3'=>'1000010','4'=>'1011100',
 '5'=>'1001110','6'=>'1010000','7'=>'1000100','8'=>'1001000','9'=>'1110100')
 );
 $parities=array(
 '0'=>array('A','A','A','A','A','A'),
 '1'=>array('A','A','B','A','B','B'),
 '2'=>array('A','A','B','B','A','B'),
 '3'=>array('A','A','B','B','B','A'),
 '4'=>array('A','B','A','A','B','B'),
 '5'=>array('A','B','B','A','A','B'),
 '6'=>array('A','B','B','B','A','A'),
 '7'=>array('A','B','A','B','A','B'),
 '8'=>array('A','B','A','B','B','A'),
 '9'=>array('A','B','B','A','B','A')
 );
 $code='101';
 $p=$parities[$barcode[0]];
 for($i=1;$i<=6;$i++)
 $code.=$codes[$p[$i-1]][$barcode[$i]];
 $code.='01010';
 for($i=7;$i<=12;$i++)
 $code.=$codes['C'][$barcode[$i]];
 $code.='101';
 //Draw bars
 for($i=0;$i<strlen($code);$i++)
 {
 if($code[$i]=='1')
 $this->Rect($x+$i*$w,$y,$w,$h,'F');
 }
 //Print text uder barcode
 $this->SetFont('Arial','',12);
 $this->Text($x,$y+$h+11/$this->k,substr($barcode,-$len));
}





function RoundedRect($x, $y, $w, $h, $r, $style = '')
	{
		$k = $this->k;
		$hp = $this->h;
		if($style=='F')
			$op='f';
		elseif($style=='FD' || $style=='DF')
			$op='B';
		else
			$op='S';
		$MyArc = 4/3 * (sqrt(2) - 1);
		$this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
		$xc = $x+$w-$r ;
		$yc = $y+$r;
		$this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

		$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
		$xc = $x+$w-$r ;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
		$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
		$xc = $x+$r ;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
		$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
		$xc = $x+$r ;
		$yc = $y+$r;
		$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
		$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
		$this->_out($op);
	}

	function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
	{
		$h = $this->h;
		$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
	}


    function GetMultiCellHeight($w, $h, $txt, $border=null, $align='J') {
	// Calculate MultiCell with automatic or explicit line breaks height
	// $border is un-used, but I kept it in the parameters to keep the call
	//   to this function consistent with MultiCell()
	$cw = &$this->CurrentFont['cw'];
	if($w==0)
		$w = $this->w-$this->rMargin-$this->x;
	$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
	$s = str_replace("\r",'',$txt);
	$nb = strlen($s);
	if($nb>0 && $s[$nb-1]=="\n")
		$nb--;
	$sep = -1;
	$i = 0;
	$j = 0;
	$l = 0;
	$ns = 0;
	$height = 0;
	while($i<$nb)
	{
		// Get next character
		$c = $s[$i];
		if($c=="\n")
		{
			// Explicit line break
			if($this->ws>0)
			{
				$this->ws = 0;
				$this->_out('0 Tw');
			}
			//Increase Height
			$height += $h;
			$i++;
			$sep = -1;
			$j = $i;
			$l = 0;
			$ns = 0;
			continue;
		}
		if($c==' ')
		{
			$sep = $i;
			$ls = $l;
			$ns++;
		}
		$l += $cw[$c];
		if($l>$wmax)
		{
			// Automatic line break
			if($sep==-1)
			{
				if($i==$j)
					$i++;
				if($this->ws>0)
				{
					$this->ws = 0;
					$this->_out('0 Tw');
				}
				//Increase Height
				$height += $h;
			}
			else
			{
				if($align=='J')
				{
					$this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
					$this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
				}
				//Increase Height
				$height += $h;
				$i = $sep+1;
			}
			$sep = -1;
			$j = $i;
			$l = 0;
			$ns = 0;
		}
		else
			$i++;
	}
	// Last chunk
	if($this->ws>0)
	{
		$this->ws = 0;
		$this->_out('0 Tw');
	}
	//Increase Height
	$height += $h;

	return $height;
}

function MultiAlignCell($w,$h,$text,$border=0,$ln=0,$align='L',$fill=false)
{
    // Store reset values for (x,y) positions
    $x = $this->GetX() + $w;
    $y = $this->GetY();

    // Make a call to FPDF's MultiCell
    $this->MultiCell($w,$h,$text,$border,$align,$fill);

    // Reset the line position to the right, like in Cell
    if( $ln==0 )
    {
        $this->SetXY($x,$y);
    }
}


function MultiCellText($w, $h, $txt, $border=0, $ln=0, $align='J', $fill=false)
{
    // Custom Tomaz Ahlin
    if($ln == 0) {
        $current_y = $this->GetY();
        $current_x = $this->GetX();
    }

    // Output text with automatic or explicit line breaks
    $cw = &$this->CurrentFont['cw'];
    if($w==0)
        $w = $this->w-$this->rMargin-$this->x;
    $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
    $s = str_replace("\r",'',$txt);
    $nb = strlen($s);
    if($nb>0 && $s[$nb-1]=="\n")
        $nb--;
    $b = 0;
    if($border)
    {
        if($border==1)
        {
            $border = 'LTRB';
            $b = 'LRT';
            $b2 = 'LR';
        }
        else
        {
            $b2 = '';
            if(strpos($border,'L')!==false)
                $b2 .= 'L';
            if(strpos($border,'R')!==false)
                $b2 .= 'R';
            $b = (strpos($border,'T')!==false) ? $b2.'T' : $b2;
        }
    }
    $sep = -1;
    $i = 0;
    $j = 0;
    $l = 0;
    $ns = 0;
    $nl = 1;
    while($i<$nb)
    {
        // Get next character
        $c = $s[$i];
        if($c=="\n")
        {
            // Explicit line break
            if($this->ws>0)
            {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
            $i++;
            $sep = -1;
            $j = $i;
            $l = 0;
            $ns = 0;
            $nl++;
            if($border && $nl==2)
                $b = $b2;
            continue;
        }
        if($c==' ')
        {
            $sep = $i;
            $ls = $l;
            $ns++;
        }
        $l += $cw[$c];
        if($l>$wmax)
        {
            // Automatic line break
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
                if($this->ws>0)
                {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
            }
            else
            {
                if($align=='J')
                {
                    $this->ws = ($ns>1) ?     ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                    $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                }
                $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                $i = $sep+1;
            }
            $sep = -1;
            $j = $i;
            $l = 0;
            $ns = 0;
            $nl++;
            if($border && $nl==2)
                $b = $b2;
        }
        else
            $i++;
    }
    // Last chunk
    if($this->ws>0)
    {
        $this->ws = 0;
        $this->_out('0 Tw');
    }
    if($border && strpos($border,'B')!==false)
        $b .= 'B';
    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
    $this->x = $this->lMargin;

    // Custom Tomaz Ahlin
    if($ln == 0) {
        $this->SetXY($current_x + $w, $current_y);
    }
}











    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)

    {

        //Get string width

        $str_width=$this->GetStringWidth($txt);


        //Calculate ratio to fit cell

        if($w==0)

            $w = $this->w-$this->rMargin-$this->x;

        $ratio = ($w-$this->cMargin*2)/$str_width;


        $fit = ($ratio < 1 || ($ratio > 1 && $force));

        if ($fit)

        {

            if ($scale)

            {

                //Calculate horizontal scaling

                $horiz_scale=$ratio*100.0;

                //Set horizontal scaling

                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));

            }

            else

            {

                //Calculate character spacing in points

                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;

                //Set character spacing

                $this->_out(sprintf('BT %.2F Tc ET',$char_space));

            }

            //Override user alignment (since text will fill up cell)

            $align='';

        }


        //Pass on to Cell method

        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);


        //Reset character spacing/horizontal scaling

        if ($fit)

            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');

    }


    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')

    {

        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);

    }


    //Patch to also work with CJK double-byte text

    function MBGetStringLength($s)

    {

        if($this->CurrentFont['type']=='Type0')

        {

            $len = 0;

            $nbbytes = strlen($s);

            for ($i = 0; $i < $nbbytes; $i++)

            {

                if (ord($s[$i])<128)

                    $len++;

                else

                {

                    $len++;

                    $i++;

                }

            }

            return $len;

        }

        else

            return strlen($s);

    }

################################## FIN DEL CODIGO PARA AJUSTAR TEXTO EN CELDAS #########################################


	


function saveFont()
	{

		$saved = array();

		$saved[ 'family' ] = $this->FontFamily;
		$saved[ 'style' ] = $this->FontStyle;
		$saved[ 'sizePt' ] = $this->FontSizePt;
		$saved[ 'size' ] = $this->FontSize;
		$saved[ 'curr' ] =& $this->CurrentFont;

		return $saved;

	}

	function restoreFont( $saved )
	{

		$this->FontFamily = $saved[ 'family' ];
		$this->FontStyle = $saved[ 'style' ];
		$this->FontSizePt = $saved[ 'sizePt' ];
		$this->FontSize = $saved[ 'size' ];
		$this->CurrentFont =& $saved[ 'curr' ];

		if( $this->page > 0)
			$this->_out( sprintf( 'BT /F%d %.2F Tf ET', $this->CurrentFont[ 'i' ], $this->FontSizePt ) );

	}

	function newFlowingBlock( $w, $h, $b = 0, $a = 'J', $f = 0 )
	{

		// cell width in points
		$this->flowingBlockAttr[ 'width' ] = $w * $this->k;

		// line height in user units
		$this->flowingBlockAttr[ 'height' ] = $h;

		$this->flowingBlockAttr[ 'lineCount' ] = 0;

		$this->flowingBlockAttr[ 'border' ] = $b;
		$this->flowingBlockAttr[ 'align' ] = $a;
		$this->flowingBlockAttr[ 'fill' ] = $f;

		$this->flowingBlockAttr[ 'font' ] = array();
		$this->flowingBlockAttr[ 'content' ] = array();
		$this->flowingBlockAttr[ 'contentWidth' ] = 0;

	}

	function finishFlowingBlock()
	{

		$maxWidth =& $this->flowingBlockAttr[ 'width' ];

		$lineHeight =& $this->flowingBlockAttr[ 'height' ];

		$border =& $this->flowingBlockAttr[ 'border' ];
		$align =& $this->flowingBlockAttr[ 'align' ];
		$fill =& $this->flowingBlockAttr[ 'fill' ];

		$content =& $this->flowingBlockAttr[ 'content' ];
		$font =& $this->flowingBlockAttr[ 'font' ];

		// set normal spacing
		$this->_out( sprintf( '%.3F Tw', 0 ) );

		// print out each chunk

		// the amount of space taken up so far in user units
		$usedWidth = 0;

		foreach ( $content as $k => $chunk )
		{

			$b = '';

			if ( is_int( strpos( $border, 'B' ) ) )
				$b .= 'B';

			if ( $k == 0 && is_int( strpos( $border, 'L' ) ) )
				$b .= 'L';

			if ( $k == count( $content ) - 1 && is_int( strpos( $border, 'R' ) ) )
				$b .= 'R';

			$this->restoreFont( $font[ $k ] );

			// if it's the last chunk of this line, move to the next line after
			if ( $k == count( $content ) - 1 )
				$this->Cell( ( $maxWidth / $this->k ) - $usedWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 1, $align, $fill );
			else
				$this->Cell( $this->GetStringWidth( $chunk ), $lineHeight, $chunk, $b, 0, $align, $fill );

			$usedWidth += $this->GetStringWidth( $chunk );

		}

	}

	function WriteFlowingBlock( $s )
	{

		// width of all the content so far in points
		$contentWidth =& $this->flowingBlockAttr[ 'contentWidth' ];

		// cell width in points
		$maxWidth =& $this->flowingBlockAttr[ 'width' ];

		$lineCount =& $this->flowingBlockAttr[ 'lineCount' ];

		// line height in user units
		$lineHeight =& $this->flowingBlockAttr[ 'height' ];

		$border =& $this->flowingBlockAttr[ 'border' ];
		$align =& $this->flowingBlockAttr[ 'align' ];
		$fill =& $this->flowingBlockAttr[ 'fill' ];

		$content =& $this->flowingBlockAttr[ 'content' ];
		$font =& $this->flowingBlockAttr[ 'font' ];

		$font[] = $this->saveFont();
		$content[] = '';

		$currContent =& $content[ count( $content ) - 1 ];

		// where the line should be cutoff if it is to be justified
		$cutoffWidth = $contentWidth;

		// for every character in the string
		for ( $i = 0; $i < strlen( $s ); $i++ )
		{

			// extract the current character
			$c = $s[ $i ];

			// get the width of the character in points
			$cw = $this->CurrentFont[ 'cw' ][ $c ] * ( $this->FontSizePt / 1000 );

			if ( $c == ' ' )
			{

				$currContent .= ' ';
				$cutoffWidth = $contentWidth;

				$contentWidth += $cw;

				continue;

			}

			// try adding another char
			if ( $contentWidth + $cw > $maxWidth )
			{

				// won't fit, output what we have
				$lineCount++;

				// contains any content that didn't make it into this print
				$savedContent = '';
				$savedFont = array();

				// first, cut off and save any partial words at the end of the string
				$words = explode( ' ', $currContent );

				// if it looks like we didn't finish any words for this chunk
				if ( count( $words ) == 1 )
				{

					// save and crop off the content currently on the stack
					$savedContent = array_pop( $content );
					$savedFont = array_pop( $font );

					// trim any trailing spaces off the last bit of content
					$currContent =& $content[ count( $content ) - 1 ];

					$currContent = rtrim( $currContent );

				}

				// otherwise, we need to find which bit to cut off
				else
				{

					$lastContent = '';

					for ( $w = 0; $w < count( $words ) - 1; $w++)
						$lastContent .= "{$words[ $w ]} ";

					$savedContent = $words[ count( $words ) - 1 ];
					$savedFont = $this->saveFont();

					// replace the current content with the cropped version
					$currContent = rtrim( $lastContent );

				}

				// update $contentWidth and $cutoffWidth since they changed with cropping
				$contentWidth = 0;

				foreach ( $content as $k => $chunk )
				{

					$this->restoreFont( $font[ $k ] );

					$contentWidth += $this->GetStringWidth( $chunk ) * $this->k;

				}

				$cutoffWidth = $contentWidth;

				// if it's justified, we need to find the char spacing
				if( $align == 'J' )
				{

					// count how many spaces there are in the entire content string
					$numSpaces = 0;

					foreach ( $content as $chunk )
						$numSpaces += substr_count( $chunk, ' ' );

					// if there's more than one space, find word spacing in points
					if ( $numSpaces > 0 )
						$this->ws = ( $maxWidth - $cutoffWidth ) / $numSpaces;
					else
						$this->ws = 0;

					$this->_out( sprintf( '%.3F Tw', $this->ws ) );

				}

				// otherwise, we want normal spacing
				else
					$this->_out( sprintf( '%.3F Tw', 0 ) );

				// print out each chunk
				$usedWidth = 0;

				foreach ( $content as $k => $chunk )
				{

					$this->restoreFont( $font[ $k ] );

					$stringWidth = $this->GetStringWidth( $chunk ) + ( $this->ws * substr_count( $chunk, ' ' ) / $this->k );

					// determine which borders should be used
					$b = '';

					if ( $lineCount == 1 && is_int( strpos( $border, 'T' ) ) )
						$b .= 'T';

					if ( $k == 0 && is_int( strpos( $border, 'L' ) ) )
						$b .= 'L';

					if ( $k == count( $content ) - 1 && is_int( strpos( $border, 'R' ) ) )
						$b .= 'R';

					// if it's the last chunk of this line, move to the next line after
					if ( $k == count( $content ) - 1 )
						$this->Cell( ( $maxWidth / $this->k ) - $usedWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 1, $align, $fill );
					else
					{

						$this->Cell( $stringWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 0, $align, $fill );
						$this->x -= 2 * $this->cMargin;

					}

					$usedWidth += $stringWidth;

				}

				// move on to the next line, reset variables, tack on saved content and current char
				$this->restoreFont( $savedFont );

				$font = array( $savedFont );
				$content = array( $savedContent . $s[ $i ] );

				$currContent =& $content[ 0 ];

				$contentWidth = $this->GetStringWidth( $currContent ) * $this->k;
				$cutoffWidth = $contentWidth;

			}

			// another character will fit, so add it on
			else
			{

				$contentWidth += $cw;
				$currContent .= $s[ $i ];

			}

		}

	}
	
	########### FUNCION PARA CODIGO DE BARRA CON CODABAR ############
	function Codabar($xpos, $ypos, $code, $start='A', $end='A', $basewidth=0.12, $height=6) {
	$barChar = array (
		'0' => array (6.5, 4.4, 6.5, 3.4, 6.5, 7.3, 2.9),
		'1' => array (6.5, 4.4, 6.5, 8.4, 4.9, 4.3, 6.5),
		'2' => array (6.5, 4.0, 6.5, 9.4, 6.5, 3.0, 8.6),
		'3' => array (17.9, 24.3, 6.5, 6.4, 6.5, 3.4, 6.5),
		'4' => array (6.5, 2.4, 8.9, 6.4, 6.5, 4.3, 6.5),
		'5' => array (5.9,	2.4, 6.5, 6.4, 6.5, 4.3, 6.5),
		'6' => array (6.5, 8.3, 6.5, 6.4, 6.5, 6.4, 7.9),
		'7' => array (6.5, 8.3, 6.5, 2.4, 7.9, 6.4, 6.5),
		'8' => array (6.5, 8.3, 5.9, 10.4, 6.5, 6.4, 6.5),
		'9' => array (7.6, 5.0, 6.5, 8.4, 6.5, 3.0, 6.5),
		'$' => array (6.5, 5.0, 18.6, 24.4, 6.5, 10.0, 6.5),
		'-' => array (6.5, 5.0, 6.5, 4.4, 8.6, 10.0, 6.5),
		':' => array (16.7, 9.3, 6.5, 9.3, 16.7, 9.3, 14.7),
		'/' => array (14.7, 9.3, 16.7, 9.3, 6.5, 9.3, 16.7),
		'.' => array (13.6, 10.1, 14.9, 10.1, 17.2, 10.1, 6.5),
		'+' => array (6.5, 10.1, 17.2, 10.1, 14.9, 10.1, 13.6),
		'A' => array (6.5, 8.0, 19.6, 19.4, 6.5, 16.1, 6.5),
		'T' => array (6.5, 8.0, 19.6, 19.4, 6.5, 16.1, 6.5),
		'B' => array (6.5, 16.1, 6.5, 19.4, 6.5, 8.0, 19.6),
		'N' => array (6.5, 16.1, 6.5, 19.4, 6.5, 8.0, 19.6),
		'C' => array (6.5, 8.0, 6.5, 19.4, 6.5, 16.1, 19.6),
		'*' => array (6.5, 8.0, 6.5, 19.4, 6.5, 16.1, 19.6),
		'D' => array (6.5, 8.0, 6.5, 19.4, 19.6, 16.1, 6.5),
		'E' => array (6.5, 8.0, 6.5, 19.4, 19.6, 16.1, 6.5),
	);
	$this->SetFont('Arial','',1);
	$this->SetTextColor(259);  // Establece el color del texto (en este caso es blanco)
	$this->Text($xpos, $ypos + $height + 2, $code);
	$this->SetFillColor(0);
	$code = strtoupper($start.$code.$end);
	for($i=0; $i<strlen($code); $i++){
		$char = $code[$i];
		if(!isset($barChar[$char])){
			$this->Error('Invalid character in barcode: '.$char);
		}
		$seq = $barChar[$char];
		for($bar=0; $bar<7; $bar++){
			$lineWidth = $basewidth*$seq[$bar]/6.5;
			if($bar % 2 == 0){
				$this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
			}
			$xpos += $lineWidth;
		}
		$xpos += $basewidth*10.4/6.5;
	}
}

   function TextWithDirection($x, $y, $txt, $direction='R')
{
    if ($direction=='R')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 1, 0, 0, 1, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    elseif ($direction=='L')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', -1, 0, 0, -1, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    elseif ($direction=='U')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    elseif ($direction=='D')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, -1, 1, 0, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    else
        $s=sprintf('BT %.2F %.2F Td (%s) Tj ET', $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    if ($this->ColorFlag)
        $s='q '.$this->TextColor.' '.$s.' Q';
    $this->_out($s);
}

function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0)
{
    $font_angle+=90+$txt_angle;
    $txt_angle*=M_PI/180;
    $font_angle*=M_PI/180;

    $txt_dx=cos($txt_angle);
    $txt_dy=sin($txt_angle);
    $font_dx=cos($font_angle);
    $font_dy=sin($font_angle);

    $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', $txt_dx, $txt_dy, $font_dx, $font_dy, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    if ($this->ColorFlag)
        $s='q '.$this->TextColor.' '.$s.' Q';
    $this->_out($s);
}

 // FIN Class PDF

}
?>