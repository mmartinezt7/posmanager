/*$(document).ready(function (){
          $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
        });*/



// FUNCION PARA DARLE TITULO A TODOS LOS ARCHIVOS
$(document).ready(function() {

document.title = '.:: Sistema de Facturacion e Inventarios ::.';		
$(".current-year").text((new Date).getFullYear() + ' CopyRight. Todos los derechos reservados. Facturacion e Inventarios.');
$(".logo").text('FACTURACION');
		
});    
	  
	  
// FUNCION PARA PERMITIR CAMPOS NUMEROS
function NumberFormat(num, numDec, decSep, thousandSep){
    var arg;
    var Dec;
    Dec = Math.pow(10, numDec); 
    if (typeof(num) == 'undefined') return; 
    if (typeof(decSep) == 'undefined') decSep = ',';
    if (typeof(thousandSep) == 'undefined') thousandSep = '.';
    if (thousandSep == '.')
     arg=/./g;
    else
     if (thousandSep == ',') arg=/,/g;
    if (typeof(arg) != 'undefined') num = num.toString().replace(arg,'');
    num = num.toString().replace(/,/g, '.'); 
    if (isNaN(num)) num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * Dec + 0.50000000001);
    cents = num % Dec;
    num = Math.floor(num/Dec).toString(); 
    if (cents < (Dec / 10)) cents = "0" + cents; 
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
     num = num.substring(0, num.length - (4 * i + 3)) + thousandSep + num.substring(num.length - (4 * i + 3));
    if (Dec == 1)
     return (((sign)? '': '-') + num);
    else
     return (((sign)? '': '-') + num + decSep + cents);
   } 

   function EvaluateText(cadena, obj){
    opc = false; 
    if (cadena == "%d")
     if (event.keyCode > 47 && event.keyCode < 58)
      opc = true;
    if (cadena == "%f"){ 
     if (event.keyCode > 47 && event.keyCode < 58)
      opc = true;
     if (obj.value.search("[.*]") == -1 && obj.value.length != 0)
      if (event.keyCode == 46)
       opc = true;
    }
    if(opc == false)
     event.returnValue = false; 
   }
   
   $(document).ready(function(){ 
$(".number").keydown(function(event) {
   if(event.shiftKey)
   {
        event.preventDefault();
   }
 
   if (event.keyCode == 46 || event.keyCode == 8)    {
   }
   else {
        if (event.keyCode < 95) {
          if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault();
          }
        } 
        else {
              if (event.keyCode < 96 || event.keyCode > 105) {
                  event.preventDefault();
              }
        }
      }
   });
});
   
  
function getTime()
        {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            var num = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
			var mt = "AM";

         // Pongo el formato 12 horas
			if (h> 12) {
			mt = "PM";
			h = h - 12;
			}
			if (h == 0) h = 12;
			// Pongo minutos y segundos con dos digitos
			//if (m <= 9) m = "0" + m;
			//if (s <= 9) s = "0" + s;
			
            // add a zero in front of numbers<10
            m=checkTime(m);
            s=checkTime(s);
			document.getElementById('fecharegistro').value= today.getDate() + "-" + num[today.getMonth()] + "-" + today.getFullYear() + " " + h+":"+m+":"+s;
            t=setTimeout(function(){getTime()},500);
        }

        function checkTime(i)
        {
            if (i<10)
            {
                i="0" + i;
            }
            return i;
        }

//////// FUNCIONES PARA MOSTRAR MENSAJES DE ALERTA DE ACTUALIZAR, ELIMINAR Y PAGAR REGISTROS
function actualizar(url)
{
	if(confirm('ESTA SEGURO DE ACTUALIZAR ESTE REGISTRO ?'))
	{
		window.location=url;
	}
}

function eliminar(url)
{
	if(confirm('ESTA SEGURO DE ELIMINAR ESTE REGISTRO ?'))
	{
		window.location=url;
	}
}

function pagar(url)
{
	if(confirm('ESTA SEGURO DE REALIZAR EL PAGO DE FACTURA DE COMPRA ?'))
	{
		window.location=url;
	}
}


$(document).ready(function(){ 
$(".precio").keydown(function(event) {
   if(event.shiftKey)
   {
        event.preventDefault();
   }
 
   if (event.keyCode == 46 || event.keyCode == 8)    {
   }
   else {
        if (event.keyCode < 95) {
          if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault();
          }
        } 
        else {
              if (event.keyCode < 96 || event.keyCode > 105) {
                  event.preventDefault();
              }
        }
      }
   });
});

















//////////////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR REGISTROS //////////////////////////////////////////////////////////////////

// FUNCION PARA MOSTRAR USUARIOS EN VENTANA MODAL
function VerUsuario(codigo){

$('#muestrausuariomodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								
var dataString = 'BuscaUsuarioModal=si&codigo='+btoa(codigo);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrausuariomodal').empty();
                $('#muestrausuariomodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });
}

// FUNCION PARA MOSTRAR PRODUCTOS EN VENTANA MODAL
function VerProducto(codproducto){

$('#muestraproductomodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								
var dataString = 'BuscaProductoModal=si&codproducto='+btoa(codproducto);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraproductomodal').empty();
                $('#muestraproductomodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

// FUNCION PARA MOSTRAR ITEMS DE SERVICIOS EN VENTANA MODAL
function VerItems(iditems){

$('#muestraitemmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								
var dataString = 'BuscaItemModal=si&iditems='+btoa(iditems);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraitemmodal').empty();
                $('#muestraitemmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
          }
      });
}



// FUNCION PARA MOSTRAR CLIENTES EN VENTANA MODAL
function VerCliente(codcliente){

$('#muestraclientemodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								
var dataString = 'BuscaClienteModal=si&codcliente='+btoa(codcliente);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraclientemodal').empty();
                $('#muestraclientemodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


// FUNCION PARA MOSTRAR PROVEEDOR EN VENTANA MODAL
function VerProveedor(codproveedor){

$('#muestraproveedormodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								
var dataString = 'BuscaProveedorModal=si&codproveedor='+btoa(codproveedor);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraproveedormodal').empty();
                $('#muestraproveedormodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

//FUNCION PARA CARGAR CODIGO DE PRODUCTO EN CODIGO DE BARRA
/*$(document).ready(function (){
          $('#codproducto').keyup(function (){
			var codproducto = $('input#codproducto').val();						
			$("#codigobarra").val(codproducto); 
         });
 });*/



























//////////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR PPEDIDOS DE PRODUCTOS /////////////////////////////////////////////////////////////

// FUNCION PARA VACIAR CARRITO DE PEDIDOS DE PRODUCTOS
$(document).ready(function() {
$('#vaciarpedidos').click(function() {
$("#carrito tbody").html("");
var nuevaFila =
"<tr>"
+"<td colspan=5><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"
+"</tr>";
$(nuevaFila).appendTo("#carrito tbody");
$("#codproducto").val("");
$("#producto").val("");
$("#codcategoria").val("");
$("#cantidad").val("");
     });
});


// FUNCION PARA MOSTRAR PEDIDOS DE PRODUCTOS EN VENTANA MODAL
$(document).ready(function() {

$(".verpedidos").click(function(){
									
$('#muestrapedidosmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								  
var codpedido = btoa($(this).attr('data-id'));
var dataString = 'BuscaPedidosModal=si&codpedido='+codpedido;

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrapedidosmodal').empty();
                $('#muestrapedidosmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
     });

}); 


 //FUNCION PARA BUSQUEDA DE ORDEN DE PEDIDOS DE PRODUCTOS POR PROVEDORES
function BuscaPedidosProductos(){
		
$('#muestrapedidos').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codproveedor = $("#codproveedor").val();
var dataString = $("#buscapedidosreportes").serialize();
var url = 'funciones.php?BuscaPedidos=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestrapedidos').empty();
                $('#muestrapedidos').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}






























//////////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR COMPRAS DE PRODUCTOS /////////////////////////////////////////////////////////////

// FUNCION PARA VACIAR CARRITO DE COMPRAS DE PRODUCTOS
$(document).ready(function() {
$('#vaciarcompras').click(function() {
$("#carrito tbody").html("");
var nuevaFila =
"<tr>"
+"<td colspan=8><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"
+"</tr>";
$(nuevaFila).appendTo("#carrito tbody");
$("#codproducto").val("");
$("#producto").val("");
$("#codcategoria").val("");
$("#precio").val("");
$("#precio2").val("");
$("#precioconiva").val("");
$("#ivaproducto").val("");
$("#cantidad").val("");
$("#vence").val("");

$("#lblsubtotal").text("0.00");
$("#lblsubtotal2").text("0.00");
$("#lbliva").text("0.00");
$("#lbldescuento").text("0.00");
$("#lbltotal").text("0.00");
					
$("#txtsubtotal").val("0.00");
$("#txtsubtotal2").val("0.00");
$("#txtIva").val("0.00");
$("#txtDescuento").val("0.00");
$("#txtTotal").val("0.00");

     });
});

//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON DESCUENTO
$(document).ready(function (){
          $('.calculodescuentoc').keyup(function (){
		
		    var txtsubtotal = $('input#txtsubtotal').val();
		    var txtsubtotal2 = $('input#txtsubtotal2').val();
		    var txtIva = $('input#txtIva').val();
			var desc = $('input#descuento').val();
			descuento  = desc/100;
						
			//REALIZO EL CALCULO CON EL DESCUENTO INDICADO
			Subtotal = parseFloat(txtsubtotal) + parseFloat(txtsubtotal2) + parseFloat(txtIva); 
			TotalDescuentoGeneral   = parseFloat(Subtotal.toFixed(2)) * parseFloat(descuento.toFixed(2));
			TotalFactura   = parseFloat(Subtotal.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));		
		
			$("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
			$("#lbltotal").text(TotalFactura.toFixed(2));
			$("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
			$("#txtTotal").val(TotalFactura.toFixed(2));
         });
 });


 //FUNCION PARA CARGAR PRECIO CON IVA
$(document).ready(function() {
						   
$('#ivaproducto').on('change', function() {

              var valor = $("#ivaproducto").val();
			  var precio = $("#precio").val();
			  var precioiva = $("#precioconiva").val();

               if (valor === "SI" || valor === true) {

               $("#precioconiva").val(precio); 

               } else {

                $("#precioconiva").val("0.00"); 
			 } 
	    });
});

//FUNCION PARA CARGAR PRECIO CON IVA
$(document).ready(function (){
          $('#precio').keyup(function (){
		
			var precio = $('input#precio').val();
			var precioconiva = $("input#precioconiva").val();
						
			$("#precioconiva").val(precio); 
			
         });
 });

// FUNCION PARA MOSTRAR FORMA DE PAGO
function BuscaFormaPagosCompras(){
	
$('#muestraformapagocompras').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var tipocompra = $("#tipocompra").val();
var dataString = $("#compras").serialize();
var url = 'funciones.php?BuscaFormaPagoCompras=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraformapagocompras').empty();
                $('#muestraformapagocompras').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}

// FUNCION PARA MOSTRAR COMPRAS DE PRODUCTOS EN VENTANA MODAL
function VerCompra(codcompra){

$('#muestracomprasmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var dataString = 'BuscaComprasModal=si&codcompra='+btoa(codcompra);
$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracomprasmodal').empty();
                $('#muestracomprasmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


// FUNCION PARA MOSTRAR DETALLES DE COMPRAS DE PRODUCTOS EN VENTANA MODAL
function VerDetalleCompra(coddetallecompra){

$('#muestradetallecompramodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var dataString = 'BuscaDetallesComprasModal=si&coddetallecompra='+btoa(coddetallecompra);
$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestradetallecompramodal').empty();
                $('#muestradetallecompramodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}


//FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE COMPRA DE PRODUCTOS
$(document).ready(function (){
          $('.calculo').keyup(function (){
			
			var precio = $('input#precio1').val();
		    var cantidad = $('input#cantcompra').val();
			var importe = $('input#importecompra').val();
			
			//REALIZO EL PRIMER CALCULO
			total=precio*cantidad;
			var original=parseFloat(total.toFixed(2));
			var importe1=Math.round(original*100)/100;
			$("#importecompra").val(original.toFixed(2));
          });
        });

 //FUNCION PARA BUSQUEDA DE ORDEN DE COMPRAS DE PRODUCTOS POR PROVEDORES
function BuscaComprasProductos(){
		
$('#muestracompras').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codproveedor = $("#codproveedor").val();
var dataString = $("#buscacomprasreportes").serialize();
var url = 'funciones.php?BuscaCompras=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestracompras').empty();
                $('#muestracompras').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}


 //FUNCION PARA BUSQUEDA DE DEVOLUCIONES DE COMPRAS DE PRODUCTOS POR PROVEDORES
function BuscaDevolucionProductos(){
			
$('#muestracomprasdevoluciones').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codproveedor = $("#codproveedor").val();
var dataString = $("#buscadevolucionesreportes").serialize();
var url = 'funciones.php?BuscaComprasDevoluciones=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestracomprasdevoluciones').empty();
                $('#muestracomprasdevoluciones').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}































//////////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR VENTAS DE PRODUCTOS /////////////////////////////////////////////////////////////

// FUNCION PARA VACIAR CARRITO DE COMPRAS DE PRODUCTOS
$(document).ready(function() {
$('#vaciarventas').click(function() {
$("#carrito tbody").html("");
var nuevaFila =
"<tr>"
+"<td colspan=7><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"
+"</tr>";
$(nuevaFila).appendTo("#carrito tbody");
$("#codproducto").val("");
$("#producto").val("");
$("#precio").val("");
$("#precio2").val("");
$("#precioconiva").val("");
$("#codcategoria").val("");
$("#cantidad").val("");
$("#existencia").val("");

$("#lblsubtotal").text("0.00");
$("#lblsubtotal2").text("0.00");
$("#lbliva").text("0.00");
$("#lbldescuento").text("0.00");
$("#lbltotal").text("0.00");
$("#txtsubtotal").val("0.00");
$("#txtsubtotal2").val("0.00");
$("#txtIva").val("0.00");
$("#txtDescuento").val("0.00");
$("#txtTotal").val("0.00");
$("#txtTotalCompra").val("0.00");
     });
});

//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE VENTAS CON DESCUENTO
$(document).ready(function (){
          $('.calculodescuentove').keyup(function (){
		
		    var txtsubtotal = $('input#txtsubtotal').val();
		    var txtsubtotal2 = $('input#txtsubtotal2').val();
		    var txtIva = $('input#txtIva').val();
			var desc = $('input#descuento').val();
			descuento  = desc/100;
						
			//REALIZO EL CALCULO CON EL DESCUENTO INDICADO
			Subtotal = parseFloat(txtsubtotal) + parseFloat(txtsubtotal2) + parseFloat(txtIva); 
			TotalDescuentoGeneral   = parseFloat(Subtotal.toFixed(2)) * parseFloat(descuento.toFixed(2));
			TotalFactura   = parseFloat(Subtotal.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));		
		
			$("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
			$("#lbltotal").text(TotalFactura.toFixed(2));
			$("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
			$("#txtTotal").val(TotalFactura.toFixed(2));
         });
 });


// FUNCION PARA MOSTRAR FORMA DE PAGO PARA VENTAS
function BuscaFormaVenta(){
	
$('#muestraformapagoventas').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var tipopagove = $("#tipopagove").val();
var dataString = $("#ventas").serialize();
var url = 'funciones.php?BuscaFormaPagoVentas=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
				$('#muestraformapagoventas').empty();
                $('#muestraformapagoventas').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}

// FUNCION PARA MOSTRAR FORMA DE PAGO PARA VENTAS
function MuestraCambioPagos(){
	
	//alert("CHINGA TU MADRE CABRON");
	
$('#muestracambiospagos').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var tipopagove = $("#tipopagove").val();
var formapagove = $("#formapagove").val();
var dataString = $("#ventas").serialize();
var url = 'funciones.php?MuestraCambiosVentas=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracambiospagos').empty();
                $('#muestracambiospagos').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });
}

//FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE COMPRA DE PRODUCTOS
$(document).ready(function (){
          $('.calculodevolucion').keyup(function (){
			
			var montototal = $('input#txtTotal').val();
		    var montopagado = $('input#montopagado').val();
			var montodevuelto = $('input#montodevuelto').val();
						
			//REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
			total=montopagado - montototal;
			var original=parseFloat(total.toFixed(2));
			$("#montodevuelto").val(original.toFixed(2));/**/
			
          });
     });


// FUNCION PARA MOSTRAR VENTAS DE PRODUCTOS EN VENTANA MODAL
function VerVentas(codventa){
									
$('#muestraventasmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								  
var dataString = 'BuscaVentasModal=si&codventa='+btoa(codventa);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraventasmodal').empty();
                $('#muestraventasmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

// FUNCION PARA MOSTRAR DETALLES DE VENTA DE PRODUCTOS EN VENTANA MODAL
function VerDetalleVentas(coddetalleventa){
									
$('#muestradetalleventamodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								  
var dataString = 'BuscaDetallesVentasModal=si&coddetalleventa='+btoa(coddetalleventa);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestradetalleventamodal').empty();
                $('#muestradetalleventamodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

//FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE VENTA DE PRODUCTOS
$(document).ready(function (){
          $('.calculoventa').keyup(function (){
			
			var precio = $('input#precioventa').val();
			var precio2 = $('input#preciocompra').val();
		    var cantidad = $('input#cantventa').val();
			var importe = $('input#importe').val();
			var importe2 = $('input#importe2').val();
			
			//REALIZO EL PRIMER CALCULO
			total=precio*cantidad;
			var original=parseFloat(total);
			//var importe1=Math.round(original*100)/100;
			$("#importe").val(original.toFixed(2));
			
			//REALIZO EL SEGUNDO CALCULO
			total2=precio2*cantidad;
			var original2=parseFloat(total2);
			//var importe3=Math.round(original2*100)/100;
			$("#importe2").val(original2.toFixed(2));
			
          });
        });


//FUNCIONES PARA ACTIVAR-DESACTIVAR CAMPOS PARA BUSQUEDA DE REPORTES DE VENTAS
$(document).ready(function() {

            $("#tipo").on("change", function() {
											 			
               var valor = $("#tipo").val();

               if (valor === "1" || valor === true) {

                  $("#desde").attr('disabled', false);
				  $("#hasta").attr('disabled', false);
				  $("#busqueda").attr('disabled', true);

               } else if (valor === "2" || valor === true) {

                  // deshabilitamos
                  $("#desde").attr('disabled', false);
				  $("#hasta").attr('disabled', false);
				  $("#busqueda").attr('disabled', false);
             
			 } else if (valor === "3" || valor === true) {

                  // deshabilitamos
                  $("#desde").attr('disabled', true);
				  $("#hasta").attr('disabled', true);
				  $("#busqueda").attr('disabled', false);
             }
       });
 });

//FUNCION PARA BUSQUEDA DE VENTAS POR FECHAS PARA REPORTES
$(document).ready(function() {

$("#buscarventasfechas").click(function(){
									
$('#muestraventasfechas').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#buscaventafecha").serialize();
var url = 'funciones.php?BuscaVentasFechas=si';

$.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasfechas').empty();
                $('#muestraventasfechas').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
     });
 }); 

//FUNCION PARA BUSQUEDA DE VENTAS POR FECHAS Y CAJAS DE VENTAS PARA REPORTES
$(document).ready(function() {

$("#buscarventascajas").click(function(){
									
$('#muestraventascajas').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var desde = $("#desde").val();
var hasta = $("#hasta").val();
var codcaja = $("select[name='codcaja']").val();
var dataString = $("#buscaventacaja").serialize();
var url = 'funciones.php?BuscaVentasCajas=si';

$.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventascajas').empty();
                $('#muestraventascajas').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
     });
 });

//FUNCION PARA BUSQUEDA DE PRODUCTOS FACTURADOS POR FECHAS PARA REPORTES
$(document).ready(function() {

$("#buscarventasproductos").click(function(){
									
$('#muestraventasproductos').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#buscaventaproducto").serialize();
var url = 'funciones.php?BuscaVentasProductos=si';

$.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasproductos').empty();
                $('#muestraventasproductos').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
     });
 });


// FUNCION PARA BUSQUEDA DE KARDEX POR PRODUCTOS
function BuscaKardexProductos(){
		
$('#muestrakardexproducto').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codproducto = $("#codproducto").val();
var dataString = $("#buscakardex").serialize();
var url = 'funciones.php?BuscaKardexProducto=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexproducto').empty();
                $('#muestrakardexproducto').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}



























///////////////////////////////////////////////// FUNCIONES PARA PROCESAR ABONOS A CREDITOS DE PRODUCTOS /////////////////////////////////////////////////////

// FUNCION PARA BUSQUEDA DE ABONOS DE CLIENTES
function BuscaClientesAbonos(){
		
$('#muestraclientesabonos').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codcliente = $("#codcliente").val();
var dataString = $("#abonoscreditos").serialize();
var url = 'funciones.php?BuscaAbonosClientes=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestraformularioabonos').html("");            
                $('#muestraclientesabonos').empty();
                $('#muestraclientesabonos').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}

// FUNCION PARA MOSTRAR FOMRULARIO DE NUEVOS ABONOS
function NuevoAbono(cedcliente,codventa){
	
$('#muestraformularioabonos').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var dataString = 'MuestraFormularioAbonos=si&cedcliente='+btoa(cedcliente)+'&codventa='+btoa(codventa);

 $.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
				$('#muestraformularioabonos').empty();
                $('#muestraformularioabonos').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });
}

// FUNCION PARA MOSTRAR CREDITOS DE VENTAS DE PRODUCTOS EN VENTANA MODAL
function VerCreditos(codventa){
		
$('#muestracreditosmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var dataString = 'BuscaCreditosModal=si&codventa='+btoa(codventa);

 $.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
				$('#muestracreditosmodal').empty();
                $('#muestracreditosmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });
}

// FUNCION PARA BUSQUEDA DE ABONOS DE CLIENTES PARA REPORTES
function BuscaCreditosClientesReportes(){
		
$('#muestracreditosclientesreportes').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var codcliente = $("#codcliente").val();
var dataString = $("#creditosclientesreportes").serialize();
var url = 'funciones.php?BuscaCreditosClientesReportes=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestracreditosclientesreportes').empty();
                $('#muestracreditosclientesreportes').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}


// FUNCION PARA BUSQUEDA DE ABONOS DE CLIENTES PARA REPORTES
function BuscaCreditosFechasReportes(){
		
$('#muestracreditosfechasreportes').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
var cedcliente = $("#cedcliente").val();
var dataString = $("#creditosfechasreportes").serialize();
var url = 'funciones.php?BuscaCreditosFechasReportes=si';

        $.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {
                $('#muestracreditosfechasreportes').empty();
                $('#muestracreditosfechasreportes').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
      });	
}





























///////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR DEVOLUCION DE PRODUCTOS /////////////////////////////////////////////////////////

// FUNCION PARA VACIAR CARRITO DE COMPRAS DE PRODUCTOS
$(document).ready(function() {
$('#vaciardevolucion').click(function() {
$("#carrito tbody").html("");
var nuevaFila =
"<tr>"
+"<td colspan=7><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"
+"</tr>";
$(nuevaFila).appendTo("#carrito tbody");
$("#codproducto").val("");
$("#producto").val("");
$("#codcategoria").val("");
$("#precio").val("");
$("#lote").val("");
$("#cantidad").val("");
$("#existencia").val("");

$("#lblsubtotal").text("0.00");
$("#lbliva").text("0.00");
$("#lbltotal").text("0.00");
$("#txtsubtotal").val("0.00");
$("#txtIva").val("0.00");
$("#txtTotal").val("0.00");
     });
});


// FUNCION PARA MOSTRAR VENTAS DE PRODUCTOS EN VENTANA MODAL
$(document).ready(function() {

$(".verdevoluciones").click(function(){
									
$('#muestradevolucionmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								  
var coddevolucion = btoa($(this).attr('data-id'));
var dataString = 'BuscaDevolucionesModal=si&coddevolucion='+coddevolucion;

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestradevolucionmodal').empty();
                $('#muestradevolucionmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
     });
});

// FUNCION PARA MOSTRAR DETALLES DE VENTA DE PRODUCTOS EN VENTANA MODAL
$(document).ready(function() {

$(".verdetalledevolucion").click(function(){
									
$('#muestradetalledevolucionmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								  
var coddetalledevolucion = btoa($(this).attr('data-id'));
var dataString = 'BuscaDetallesDevolucionesModal=si&coddetalledevolucion='+coddetalledevolucion;

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestradetalledevolucionmodal').empty();
                $('#muestradetalledevolucionmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
     });
}); 

//FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE VENTA DE PRODUCTOS
$(document).ready(function (){
          $('.calculodevolucion').keyup(function (){
			
			var precio = $('input#preciodevolucion').val();
		    var cantidad = $('input#cantdevolucion').val();
			var importe = $('input#importe').val();
			
			//REALIZO EL PRIMER CALCULO
			total=precio*cantidad;
			var original=parseFloat(total);
			var importe1=Math.round(original*100)/100;
			$("#importe").val(original.toFixed(2));
          });
        });

 //FUNCION PARA BUSQUEDA DE ORDEN DE DEVOLUCIONES DE PRODUCTOS POR PROVEDORES
$(document).ready(function() {
						   
$('.devoluciones').on('change', function() {
									
$('#muestradevoluciones').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var codproveedor = $("#codproveedor").val();
var dataString = 'BuscaDevoluciones=si&codproveedor='+codproveedor;

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestradevoluciones').empty();
                $('#muestradevoluciones').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
     });
});














































//////////////////////////////////////////////////////////// FUNCIONES PARA PROCESAR FACTURAS DE SERVICIOS /////////////////////////////////////////////////////////////

// FUNCION PARA VACIAR CARRITO DE SERVICIOS
$(document).ready(function() {
$('#vaciarservicios').click(function() {
$("#carrito tbody").html("");
var nuevaFila =
"<tr>"
+"<td colspan=6><center><label>NO HAY SERVICIOS AGREGADOS</label></center></td>"
+"</tr>";
$(nuevaFila).appendTo("#carrito tbody");
$("#coditems").val("");
$("#servicio").val("");
$("#precio").val("");
$("#cantidad").val("");

$("#lblsubtotal").text("0.00");
$("#lbliva").text("0.00");
$("#lbldescuento").text("0.00");
$("#lbltotal").text("0.00");
$("#txtsubtotal").val("0.00");
$("#txtIva").val("0.00");
$("#txtDescuento").text("0.00");
$("#txtTotal").val("0.00");
     });
});


// FUNCION PARA MOSTRAR SERVICIOS EN VENTANA MODAL
function VerServicios(codservicio){
									
$('#muestraserviciosmodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								  
var dataString = 'BuscaServiciosModal=si&codservicio='+btoa(codservicio);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraserviciosmodal').empty();
                $('#muestraserviciosmodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}

// FUNCION PARA MOSTRAR DETALLES DE SERVICIOS EN VENTANA MODAL
function VerDetalleServicio(coddetalleservicio){
									
$('#muestradetalleserviciomodal').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');
								  
var dataString = 'BuscaDetallesServiciosModal=si&coddetalleservicio='+btoa(coddetalleservicio);

$.ajax({
            type: "GET",
			url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestradetalleserviciomodal').empty();
                $('#muestradetalleserviciomodal').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
           }
      });
}



//FUNCION PARA ACTUALIZAR IMPORTE EN DETALLE DE SERVICIOS
$(document).ready(function (){
          $('.calculoservicio').keyup(function (){
			
			var precio = $('input#precioservicio').val();
		    var cantidad = $('input#cantservicio').val();
			var importe = $('input#importe').val();
			
			//REALIZO EL PRIMER CALCULO
			total=precio*cantidad;
			var original=parseFloat(total);
			$("#importe").val(original.toFixed(2));
       });
 });

//FUNCION PARA BUSQUEDA DE SERVICIOS POR FECHAS PARA REPORTES
$(document).ready(function() {

$("#buscarserviciosfechas").click(function(){
									
$('#muestraserviciosfechas').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#buscaserviciofecha").serialize();
var url = 'funciones.php?BuscaServiciosFechas=si';

$.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraserviciosfechas').empty();
                $('#muestraserviciosfechas').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
     });
 }); 

//FUNCION PARA BUSQUEDA DE SERVICIOS POR FECHAS Y CAJAS DE VENTAS PARA REPORTES
$(document).ready(function() {

$("#buscarservicioscajas").click(function(){
									
$('#muestraservicioscajas').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var desde = $("#desde").val();
var hasta = $("#hasta").val();
var codcaja = $("select[name='codcaja']").val();
var dataString = $("#buscaserviciocaja").serialize();
var url = 'funciones.php?BuscaServiciosCajas=si';

$.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraservicioscajas').empty();
                $('#muestraservicioscajas').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
     });
 });

//FUNCION PARA BUSQUEDA DE SERVICIOS FACTURADOS POR FECHAS PARA REPORTES
$(document).ready(function() {

$("#buscarservicios").click(function(){
									
$('#muestraservicios').html('<center><img src="assets/img/loading.gif" width="30" height="30"/></center>');

var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#buscaservicios").serialize();
var url = 'funciones.php?BuscaServicios=si';

$.ajax({
            type: "GET",
			url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraservicios').empty();
                $('#muestraservicios').append(''+response+'').fadeIn("slow");
                $('#'+parent).remove();
            }
         });
     });
 });
