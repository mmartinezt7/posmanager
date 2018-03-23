// FUNCION AUTOCOMPLETE PARA PRODUCTOS, SERVICIOS Y CLIENTES
$(function() {
           $("#producto").autocomplete({
           source: "class/buscaproductos.php",
		   minLength: 2,
           select: function(event, ui) { 
		   $('#codproducto').val(ui.item.codproducto);
		   $('#codcategoria').val(ui.item.codcategoria);
		   $('#precio').val(ui.item.preciocompra);
		   $('#precio2').val(ui.item.precioventa);
		   $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.preciocompra : "0.00");
		   $('#ivaproducto').val(ui.item.ivaproducto);		   
		   $('#existencia').val(ui.item.existencia);
           }  
        });
 });

$(function() {
           $("#productoventas").autocomplete({
           source: "class/buscaproductos.php",
		   minLength: 2,
           select: function(event, ui) { 
		   $('#codproducto').val(ui.item.codproducto);
		   $('#codcategoria').val(ui.item.codcategoria);
		   $('#precio').val(ui.item.preciocompra);
		   $('#precio2').val(ui.item.precioventa);
		   $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioventa : "0.00");
		   $('#ivaproducto').val(ui.item.ivaproducto);		   
		   $('#existencia').val(ui.item.existencia);
           }  
        });
 });

$(function() {
           $("#lote").autocomplete({
           source: "class/buscalotes.php",
		   minLength: 1,
           select: function(event, ui) { 
		   $('#lote').val(ui.item.lote);
           }  
        });
 });

 $(function() {
           $("#servicio").autocomplete({
           source: "class/buscaservicios.php",
		   minLength: 2,
           select: function(event, ui) { 
		   $('#coditems').val(ui.item.coditems);
		   $('#precio').val(ui.item.costoitems);
           }  
        });
 });


$(function() {
           $("#busqueda").autocomplete({
           source: "class/buscacliente.php",
		   minLength: 2,
           select: function(event, ui) { 
		    $('#codcliente').val(ui.item.codcliente);
           }  
      });
 });
