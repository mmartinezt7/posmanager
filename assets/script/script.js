/*
Author: Ing. Ruben D. Chirinos R.
URL: http://asesoramientopc.hol.es/
*/

/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/
$('document').ready(function()
{ 
						   
	 $("#loginform").validate({
      rules:
	  {
			usuario: { required: true, },
			password: { required: true, },
	   },
       messages:
	   {
		    usuario:{  required: "Por favor ingrese su Usuario" },
			password:{  required: "Por favor ingrese su Clave de Acceso" },
       },
	   errorElement: "span",
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm()
	   {		
			var data = $("#loginform").serialize();
				
			$.ajax({
				
			type : 'POST',
			url  : 'index.php',
			data : data,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#btn-login").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(response)
			   {						
					if(response=="ok"){
									
						$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
						setTimeout(' window.location.href = "panel.php"; ',4000);
					}
					else{
				
				$("#error").fadeIn(1000, function(){	
				$("#error").html('<center><strong> '+response+' </strong></center>');
				setTimeout(function() { $("#error").html(""); }, 5000);
				$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
									});
					}
			  }
			});
				return false;
		}
	   /* login submit */
});




/* FUNCION JQUERY PARA VALIDAR DESBLOQUEAR CUENTA DE ACCESO*/
$('document').ready(function()
{ 
						   
	 $("#desbloquear").validate({
      rules:
	  {
			usuario: { required: true, },
			password: { required: true, },
	   },
       messages:
	   {
		    usuario:{  required: "Por favor ingrese su Usuario" },
			password:{  required: "Por favor ingrese su Clave de Acceso" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm()
	   {		
			var data = $("#desbloquear").serialize();
				
			$.ajax({
				
			type : 'POST',
			url  : 'login.php',
			data : data,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#btn-login").html(' Verificando...');
			},
			success :  function(response)
			   {						
					if(response=="ok"){
									
						$("#btn-login").html('<i class="fa"></i> Acceder');
						setTimeout(' window.location.href = "panel.php"; ',4000);
					}
					else{
				
				$("#error").fadeIn(1000, function(){	
				$("#error").html('<center><strong> '+response+' </strong></center>');
				setTimeout(function() { $("#error").html(""); }, 5000);
				$("#btn-login").html('<i class="fa"></i> Acceder');
									});
					}
			  }
			});
				return false;
		}
	   /* login submit */
});















/* FUNCION JQUERY PARA RECUPERAR CONTRASEÑA DE USUARIOS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	$("#recuperarpassword").validate({
      rules:
	  {
			email: { required: true,  email: true  },
	   },
       messages:
 	   {
			email:{  required: "Ingrese su Correo Electronico", email: "Ingrese un Correo Electronico Valido" },
       },
	   errorElement: "span",
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	    /* form submit */
	  function submitForm()
	   {		
				var data = $("#recuperarpassword").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'index.php',
				data : data,
				beforeSend: function()
				{	
					$("#errorr").fadeOut();
					$("#btn-recuperar").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error2").fadeIn(1000, function(){
											
											
	$("#errorr").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
											$("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Clave');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#errorr").fadeIn(1000, function(){
											
											
	$("#errorr").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> EL CORREO INGRESADO NO FUE ENCONTRADO ACTUALMENTE !</div></center>');
												
											$("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Clave');
										
									});
								}
								else{
										
									$("#errorr").fadeIn(1000, function(){
											
						$("#errorr").html('<center> &nbsp; '+data+' </center>');
						$("#recuperarpassword")[0].reset();
						setTimeout(function() { $("#errorr").html(""); }, 5000);	
						$("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Clave');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
   
	   
});

/*  FIN DE FUNCION PARA RECUPERAR CONTRASEÑA DE USUARIOS */




/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASEÑA */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updatepassword").validate({
      rules:
	  {
			password: {required: true, minlength: 8},  
            password2:   {required: true, minlength: 8, equalTo: "#password"}, 
	   },
       messages:
	   {
            password:{ required: "Ingrese su Nuevo Password", minlength: "Ingrese 8 caracteres como minimo" },
		    password2:{ required: "Repita su Nuevo Password", minlength: "Ingrese 8 caracteres como minimo", equalTo: "Este Password no coincide" },
           
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatepassword").serialize();
				var id= $("#updatepassword").attr("data-id");
		        var codigo = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'password.php?codigo='+codigo,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
											$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#updatepassword")[0].reset();
						setTimeout(function() { $("#error").html(""); }, 5000);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
});

 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASEÑA */
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 












 
 
 






/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION GENERAL */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#configuracion").validate({
      rules:
	  {
			rifempresa: { required: true },
			nomempresa: { required: true, lettersonly: true },
			direcempresa: { required: true},
			tlfempresa: { required: true },
			cedresponsable: { required: true, },
			nomresponsable: { required: true, lettersonly: true},
			correoresponsable: { required: true,  email : true },
			tlfresponsable: { required: true },
			ivav: { required: true,  number : true },
			ivas: { required: true, number: true },
	   },
       messages:
	   {
            rifempresa:{ required: "Ingrese Rif de Empresa" },
			nomempresa:{ required: "Ingrese Nombre de Empresa", lettersonly: "Ingrese solo letras" },
			direcempresa:{ required: "Ingrese Direcci&oacute;n de Empresa" },
			tlfempresa: { required: "Ingrese N&deg; de Telefono de Empresa" },
			cedresponsable:{ required: "Ingrese C&eacute;dula de Responsable", digits: "Ingrese solo digitos para C&eacute;dula" },
			nomresponsable:{ required: "Ingrese Nombre de Responsable", lettersonly: "Ingrese solo letras para Nombre" },
			correoresponsable: { required: "Ingrese Correo de Responsable", email: "Ingrese un correo valido" },
			tlfresponsable: { required: "Ingrese N&deg; de Telefono de Responsable" },
			ivav:{ required: "Ingrese Iva para Ventas", number: "Ingrese solo numeros con dos decimales para Iva de Ventas" },
			ivas: { required: "Ingrese Iva para Servicios", number: "Ingrese solo numeros con dos decimales para Iva de Servicios" },
           
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#configuracion").serialize();
				var id= $("#configuracion").attr("data-id");
		        var id = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'configuracion.php?id='+id,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
											$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
									
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						setTimeout(function() { $("#error").html(""); }, 5000);
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');				
						
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
	   
});

 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION GENERAL */
 
 






















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE USUARIOS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#usuario").validate({
      rules:
	  {
			cedula: { required: true,  digits : true, minlength: 7 },
			nombres: { required: true, lettersonly: true },
			sexo: { required: true, },
			cargo: { required: true, },
			email: { required: true, email: true },
			usuario: { required: true, },
			password: {required: true, minlength: 8},  
            password2:   {required: true, minlength: 8, equalTo: "#password"}, 
			nivel: { required: true, },
	   },
       messages:
	   {
           cedula:{ required: "Ingrese C&eacute;dula de Usuario", digits: "Ingrese solo digitos para C&eacute;dula", minlength: "Ingrese 7 digitos como minimo" },
			nombres:{ required: "Ingrese Nombre Completo de Usuario" },
            sexo:{ required: "Seleccione Sexo de Usuario" },
			cargo: { required: "Ingrese Cargo de Usuario" },
			email:{  required: "Ingrese Email de Usuario", email: "Ingrese un Email Valido" },
			usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Password de Acceso", minlength: "Ingrese 8 caracteres como minimo" },
		    password2:{ required: "Repita Password de Acceso", minlength: "Ingrese 8 caracteres como minimo", equalTo: "Este Password no coincide" },
			nivel:{ required: "Seleccione Nivel de Acceso" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#usuario").serialize();
				var formData = new FormData($("#usuario")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'forusuario.php',
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}  
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN USUARIO CON ESTE NUMERO DE C&Eacute;DULA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==3){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CORREO ELECTRONICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==4)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#usuario")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
   
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE USUARIOS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE USUARIOS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updateusuario").validate({
      rules:
	  {
			cedula: { required: true,  digits : true, minlength: 7 },
			nombres: { required: true, lettersonly: true },
			sexo: { required: true, },
			cargo: { required: true, },
			email: { required: true, email: true },
			usuario: { required: true, },
			password: {required: true, minlength: 8},  
            password2:   {required: true, minlength: 8, equalTo: "#password"}, 
			nivel: { required: true, },
			status: { required: true, },
	   },
       messages:
	   {
           cedula:{ required: "Ingrese C&eacute;dula de Usuario", digits: "Ingrese solo digitos para C&eacute;dula", minlength: "Ingrese 7 digitos como minimo" },
			nombres:{ required: "Ingrese Nombre Completo de Usuario" },
            sexo:{ required: "Seleccione Sexo de Usuario" },
			cargo: { required: "Ingrese Cargo de Usuario" },
			email:{  required: "Ingrese Email de Usuario", email: "Ingrese un Email Valido" },
			usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Password de Acceso", minlength: "Ingrese 8 caracteres como minimo" },
		    password2:{ required: "Repita Password de Acceso", minlength: "Ingrese 8 caracteres como minimo", equalTo: "Este Password no coincide" },
			nivel:{ required: "Seleccione Nivel de Acceso" },
			status:{ required: "Seleccione Status" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateusuario").serialize();
				var id= $("#updateusuario").attr("data-id");
		        var codcatalogo = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'editusuario.php?codigo='+codigo,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}  
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN USUARIO CON ESTE NUMERO DE C&Eacute;DULA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==3){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CORREO ELECTRONICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==4)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#btn-update").html('<span class="icon-edit"></span> Actualizar');
					    setTimeout("location.href='usuarios.php'", 5000);
				
						
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});

 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE USUARIOS */




















 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE CATEGORIAS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#categorias").validate({
      rules:
	  {
			nomcategoria: { required: true, },
	   },
       messages:
	   {
			nomcategoria:{ required: "Ingrese Nombre de Categoria" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#categorias").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forcategoria.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								} 
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE CATEGORIA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#categorias")[0].reset();		
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
   
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CATEGORIAS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CATEGORIAS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#updatecategoria").validate({
      rules:
	  {
			codcategoria: { required: true, },
			nomcategoria: { required: true, },
	   },
       messages:
	   {
            codcategoria:{ required: "Ingrese C&oacute;digo de Categoria" },
			nomcategoria:{ required: "Ingrese Nombre de Categoria" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatecategoria").serialize();
				var id= $("#updatecategoria").attr("data-id");
		        var codcategoria = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'editcategoria.php?codcategoria='+codcategoria,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE CATEGORIA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
						$("#error").fadeIn(1000, function(){
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='categorias.php'", 5000);
				
						
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
	   
});

 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CATEGORIAS */
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
  
 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE CAJAS DE VENTAS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#cajas").validate({
      rules:
	  {
			nrocaja: { required: true, },
			nombrecaja: { required: true, },
			codigo: { required: true, },
	   },
       messages:
	   {
            nrocaja:{  required: "Ingrese Numero de Caja" },
			nombrecaja:{ required: "Ingrese Nombre de Caja" },
			codigo:{ required: "Seleccione Responsable de Caja" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#cajas").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forcaja.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE CAJA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA TIENE UNA CAJA DE VENTAS ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#cajas")[0].reset();			
						            setTimeout(function() { $("#error").html(""); }, 5000);
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
   
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CAJAS DE VENTAS */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CAJA DE VENTAS */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatecajas").validate({
       rules:
	  {
			nrocaja: { required: true, },
			nombrecaja: { required: true, },
			codigo: { required: true, },
	   },
       messages:
	   {
            nrocaja:{  required: "Ingrese Numero de Caja" },
			nombrecaja:{ required: "Ingrese Nombre de Caja" },
			codigo:{ required: "Seleccione Responsable de Caja" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatecajas").serialize();
				var id= $("#updatecajas").attr("data-id");
		        var codcaja = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'editcaja.php?codcaja='+codcaja,
				data : data,

				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE CAJA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE USUARIO YA TIENE UNA CAJA DE VENTAS ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
					   $("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
					   setTimeout("location.href='cajas.php'", 5000);
				
				});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CAJAS DE VENTAS */
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE RETIRO DE EFECTIVO EN CAJA */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#retiro").validate({
      rules:
	  {
			motivoretiro: { required: true, },
			cantretiro: { required: true, number : true },
			codcaja: { required: true, },
	   },
       messages:
	   {
            motivoretiro:{  required: "Ingrese Motivo de Retiro" },
			cantretiro:{ required: "Ingrese Monto de Retiro", number: "Ingrese solo digitos con 2 decimales" },
			codcaja:{ required: "Seleccione Caja de Venta" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#retiro").serialize();
				var cant = $('#cantretiro').val();
	
	        if (cant==0.00 || cant==0) {
	            
				alert('POR FAVOR INGRESE UN MONTO VALIDO PARA RETIRO DE EFECTIVO');
         
        return false;
	 
	  } else {
		  
				$.ajax({
				
				type : 'POST',
				url  : 'forretiro.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR INGRESE UN MONTO VALIDO PARA RETIRO DE EFECTIVO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTA CAJA DE VENTA NO DISPONE DE EFECTIVO ACTUALMENTE, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==4)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> EL MONTO SOLICITADO PARA RETIRO EXCEDE EL LIMITE DE EFECTIVO EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            document.getElementById('retiro').reset();	
					                setTimeout(function() { $("#error").html(""); }, 5000);
								$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
	         }
		}
	   /* form submit */
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE RETIRO DE EFECTIVO EN CAJA */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE RETIRO DE EFECTIVO EN CAJA */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateretiro").validate({
       rules:
	  {
			motivoretiro: { required: true, },
			cantretiro: { required: true, number : true },
			codcaja: { required: true, },
	   },
       messages:
	   {
            motivoretiro:{  required: "Ingrese Motivo de Retiro" },
			cantretiro:{ required: "Ingrese Monto de Retiro", number: "Ingrese solo digitos con 2 decimales" },
			codcaja:{ required: "Seleccione Caja de Venta" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateretiro").serialize();
				var id= $("#updateretiro").attr("data-id");
		        var codretiro = id;
				var cant = $('#cantretiro').val();
	
	        if (cant==0.00 || cant==0) {
	            
				alert('POR FAVOR INGRESE UN MONTO VALIDO PARA RETIRO DE EFECTIVO');
         
        return false;
	 
	  } else {
				$.ajax({
				
				type : 'POST',
				url  : 'editretiro.php?codretiro='+codretiro,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR INGRESE UN MONTO VALIDO PARA RETIRO DE EFECTIVO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTA CAJA DE VENTA NO DISPONE DE EFECTIVO ACTUALMENTE, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else if(data==4)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> EL MONTO SOLICITADO PARA RETIRO EXCEDE EL LIMITE DE EFECTIVO EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
					    setTimeout("location.href='retiro.php'", 5000);
				});

								}
						   }
				});
				return false;
	         }
		}
	   /* form submit */
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE RETIRO DE EFECTIVO EN CAJA */
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
  
/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PRODUCTOS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#productos").validate({
      rules:
	  {
			codproducto: { required: true, },
			producto: { required: true,},
			codcategoria: { required: true, },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			existencia: { required: true, digits : true },
			stockminimo: { required: true, digits : true },
			codigobarra: { required: false, },
			ubicacion: { required: false,},
			ivaproducto: { required: true, },
			statusproducto: { required: true, },
	   },
       messages:
	   {
			codproducto: { required: "Ingrese C&oacute;digo de Producto" },
			producto:{  required: "Ingrese Nombre de Producto" },
			codcategoria:{ required: "Seleccione Categoria de Producto" },
			preciocompra:{ required: "Ingrese Precio de Compra de Producto", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta de Producto", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Cantidad o Existencia de Producto", digits: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", digits: "Ingrese solo digitos" },
			codigobarra: { required: "Ingrese C&oacute;digo de Barra" },
			ubicacion:{  required: "Ingrese Ubicacion de Producto" },
			ivaproducto:{ required: "Seleccione Iva de Producto" },
			statusproducto:{ required: "Seleccione Status de Producto" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#productos").serialize();
				var formData = new FormData($("#productos")[0]);
				var cant = $('#existencia').val();
				var compra = $('#preciocompra').val();
				var venta = $('#precioventa').val();
				cant    = parseInt(cant);
	
	       if (compra==0.00 || compra==0) {
	            
				$("#preciocompra").focus();
				$('#preciocompra').val("");
				$('#preciocompra').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UN COSTO VALIDO PARA PRECIO COMPRA DE PRODUCTO');
         
        return false;
		
		   } else if (venta==0.00 || venta==0) {
	            
				$("#precioventa").focus();
				$('#precioventa').val("");
				$('#precioventa').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UN PRECIO VALIDO PARA PRECIO VENTA DE PRODUCTO');
         
        return false;
		
			} else  if (cant==0) {
	            
				$("#existencia").focus();
				$('#existencia').val("");
				$('#existencia').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UNA CANTIDAD VALIDA PARA PRODUCTOS');
         
        return false;
	 
	  } else {
				$.ajax({
				type : 'POST',
				url  : 'forproducto.php',
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}  
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> YA EXISTE UN PRODUCTO CON ESTE C&Oacute;DIGO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#productos")[0].reset();	
					    $("#nroproducto").load("funciones.php?muestranroproducto=si");	
						setTimeout(function() { $("#error").html(""); }, 5000);		
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
	        }
		}
	   /* form submit */	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PRODUCTOS */
 
 
 /* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRODUCTOS */
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateproducto").validate({
        rules:
	  {
			codproducto: { required: true, },
			producto: { required: true,},
			codcategoria: { required: true, },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			existencia: { required: true, digits : true },
			stockminimo: { required: true, digits : true },
			codigobarra: { required: false, },
			ubicacion: { required: false,},
			ivaproducto: { required: true, },
			statusproducto: { required: true, },
	   },
       messages:
	   {
			codproducto: { required: "Ingrese C&oacute;digo de Producto" },
			producto:{  required: "Ingrese Nombre de Producto" },
			codcategoria:{ required: "Seleccione Categoria de Producto" },
			preciocompra:{ required: "Ingrese Precio de Compra de Producto", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta de Producto", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Cantidad o Existencia de Producto", digits: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", digits: "Ingrese solo digitos" },
			codigobarra: { required: "Ingrese C&oacute;digo de Barra" },
			ubicacion:{  required: "Ingrese Ubicacion de Producto" },
			ivaproducto:{ required: "Seleccione Iva de Producto" },
			statusproducto:{ required: "Seleccione Status de Producto" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateproducto").serialize();
				var formData = new FormData($("#updateproducto")[0]);
				var id= $("#updateproducto").attr("data-id");
		        var codalmacen = id;
				
	            var cant = $('#existencia').val();
			    var compra = $('#preciocompra').val();
				var venta = $('#precioventa').val();
				cant    = parseInt(cant);
	
	       if (compra==0.00 || compra==0) {
	            
				$("#preciocompra").focus();
				$('#preciocompra').val("");
				$('#preciocompra').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UN COSTO VALIDO PARA PRECIO COMPRA DE PRODUCTO');
         
        return false;
		
		   } else if (venta==0.00 || venta==0) {
	            
				$("#precioventa").focus();
				$('#precioventa').val("");
				$('#precioventa').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UN PRECIO VALIDO PARA PRECIO VENTA DE PRODUCTO');
         
        return false;
		
			} else  if (cant==0) {
	            
				$("#existencia").focus();
				$('#existencia').val("");
				$('#existencia').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UNA CANTIDAD VALIDA PARA PRODUCTOS');
         
        return false;
	 
	  } else {
				$.ajax({
				type : 'POST',
				url  : 'editproducto.php?codalmacen='+codalmacen,
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

											
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
     					setTimeout("location.href='productos.php'", 5000);
				
				});
											
								}
						   }
				});
				return false;
	        }
		}
	   /* form submit */	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRODUCTOS */
 

/* FUNCION JQUERY PARA CARGA MASIVA DE PRODUCTOS */	 
	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#cargarproductos").validate({
      rules:
	  {
			sel_file: { required: true, },
	   },
       messages:
	   {
            sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#cargarproductos").serialize();
				var formData = new FormData($("#cargarproductos")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'productos.php',
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-cargar").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR !</div></center>');
											
									$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
										
									});
																				
								}  
								else if(data==2){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE PRODUCTOS</div></center>');
											
									$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#cargarproductos")[0].reset();		 
						setTimeout(function() { 
						$("#error").html("");
						window.location.reload("productos.php"); 
						}, 5000);
						$("#btn-cargar").html('<span class="fa fa-cloud-upload"></span> Cargar');
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
});

/*  FIN DE FUNCION PARA CARGA MASIVA DE PRODUCTOS */
 
  
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
   
 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE CAJAS DE VENTAS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#items").validate({
       rules:
	  {
			coditems: { required: true, },
			nombreitems: { required: true, },
			descripcionitems: { required: true, },
			costoitems: { required: true, number : true },
			statusitems: { required: true, },
	   },
       messages:
	   {
            coditems:{  required: "Ingrese C&oacute;digo de Items" },
			nombreitems:{ required: "Ingrese Nombre de Items" },
			descripcionitems:{ required: "Ingrese Descripci&oacute;n de Items" },
			costoitems:{ required: "Ingrese Costo de Items", number: "Ingrese solo digitos con 2 decimales" },
			statusitems:{ required: "Seleccione Status de Items" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#items").serialize();
				var prec = $('#costoitems').val();
	
	       if (prec==0.00 || prec==0) {
	            
				$("#costoitems").focus();
				$('#costoitems').val("");
				$('#costoitems').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UN COSTO VALIDO PARA ITEMS DE SERVICIOS');
         
        return false;
	 
	  } else {
		  
		        $.ajax({
				
				type : 'POST',
				url  : 'foritem.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CODIGO DE ITEMS YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE ITEMS YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#items")[0].reset();			
						            setTimeout(function() { $("#error").html(""); }, 5000);
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
	           }
		}
	   /* form submit */
   
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CAJAS DE VENTAS */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CAJA DE VENTAS */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateitems").validate({
       rules:
	  {
			coditems: { required: true, },
			nombreitems: { required: true, },
			descripcionitems: { required: true, },
			costoitems: { required: true, number : true },
			statusitems: { required: true, },
	   },
       messages:
	   {
            coditems:{  required: "Ingrese C&oacute;digo de Items" },
			nombreitems:{ required: "Ingrese Nombre de Items" },
			descripcionitems:{ required: "Ingrese Descripci&oacute;n de Items" },
			costoitems:{ required: "Ingrese Costo de Items", number: "Ingrese solo digitos con 2 decimales" },
			statusitems:{ required: "Seleccione Status de Items" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateitems").serialize();
				var id= $("#updateitems").attr("data-id");
		        var iditems = id;
				
				var prec = $('#costoitems').val();
	
	       if (prec==0.00 || prec==0) {
	            
				$("#costoitems").focus();
				$('#costoitems').val("");
				$('#costoitems').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UN COSTO VALIDO PARA ITEMS DE SERVICIOS');
         
        return false;
	 
	  } else {
		               $.ajax({
				
				type : 'POST',
				url  : 'edititem.php?iditems='+iditems,
				data : data,

				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CODIGO DE ITEMS YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE NOMBRE DE ITEMS YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
					   $("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
					   setTimeout("location.href='items.php'", 5000);
				
				});
											
								}
						   }
				});
				return false;
	           }
		}
	   /* form submit */
	   
	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CAJAS DE VENTAS */
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

 
 
 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE CLIENTES */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#clientes").validate({
      rules:
	  {
			cedcliente: { required: true, digits : true },
			nomcliente: { lettersonly: true, },
			direccliente: { required: true, },
			tlfcliente: { required: false, digits : false  },
			emailcliente: { required: false, email: true },
	   },
       messages:
	   {
            cedcliente:{ required: "Ingrese C&eacute;dula de Cliente", digits: "Ingrese solo digitos para C&eacute;dula"},
			nomcliente:{ required: "Ingrese Nombre de Cliente" },
            direccliente:{ required: "Ingrese Direcci&oacute;n de Cliente" },
			tlfcliente: { required: "Ingrese Telefono de Cliente", digits: "Ingrese solo digitos" },
			emailcliente:{  required: "Ingrese Email de Cliente", email: "Ingrese un Email Valido" },
           
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#clientes").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forcliente.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#clientes")[0].reset();
					            	setTimeout(function() { $("#error").html(""); }, 5000); 					
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CLIENTES */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CLIENTES */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateclientes").validate({
       rules:
	  {
			cedcliente: { required: true, digits : true },
			nomcliente: { lettersonly: true, },
			direccliente: { required: true, },
			tlfcliente: { required: false, digits : false  },
			emailcliente: { required: false, email: true },
	   },
       messages:
	   {
            cedcliente:{ required: "Ingrese C&eacute;dula de Cliente", digits: "Ingrese solo digitos para C&eacute;dula"},
			nomcliente:{ required: "Ingrese Nombre de Cliente" },
            direccliente:{ required: "Ingrese Direcci&oacute;n de Cliente" },
			tlfcliente: { required: "Ingrese Telefono de Cliente", digits: "Ingrese solo digitos" },
			emailcliente:{  required: "Ingrese Email de Cliente", email: "Ingrese un Email Valido" },
           
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateclientes").serialize();
				var id= $("#updateclientes").attr("data-id");
		        var codcliente = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'editcliente.php?codcliente='+codcliente,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
							 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');

										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
					    $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
 					   setTimeout("location.href='clientes.php'", 5000);
				
				});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CLIENTES */
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE PROVEEDORES */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#proveedores").validate({
      rules:
	  {
			ritproveedor: { required: true, },
			nomproveedor: { required: true, },
			direcproveedor: { required: true, },
			tlfproveedor: { required: true, digits : false  },
			emailproveedor: { required: true, email: true },
			contactoproveedor: { required: true, lettersonly: true, },
	   },
       messages:
	   {
            ritproveedor:{ required: "Ingrese Rif de Proveedor" },
			nomproveedor:{ required: "Ingrese Nombre de Proveedor" },
            direcproveedor:{ required: "Ingrese Direcci&oacute;n de Proveedor" },
			tlfproveedor: { required: "Ingrese Telefono de Proveedor", digits: "Ingrese solo digitos" },
			emailproveedor:{  required: "Ingrese Email de Proveedor", email: "Ingrese un Email Valido" },
            contactoproveedor:{ required: "Ingrese Nombre de Contacto" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#proveedores").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forproveedor.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE PROVEEDOR YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						            $("#error").html('<center> &nbsp; '+data+' </center>');
						            $("#proveedores")[0].reset();
						            setTimeout(function() { $("#error").html(""); }, 5000);				
								    $("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PROVEEDORES */



/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PROVEEDORES */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updateproveedores").validate({
       rules:
	  {
			ritproveedor: { required: true, },
			nomproveedor: { required: true, },
			direcproveedor: { required: true, },
			tlfproveedor: { required: true, digits : false  },
			emailproveedor: { required: true, email: true },
			contactoproveedor: { required: true, lettersonly: true, },
	   },
       messages:
	   {
            ritproveedor:{ required: "Ingrese Rif de Proveedor" },
			nomproveedor:{ required: "Ingrese Nombre de Proveedor" },
            direcproveedor:{ required: "Ingrese Direcci&oacute;n de Proveedor" },
			tlfproveedor: { required: "Ingrese Telefono de Proveedor", digits: "Ingrese solo digitos" },
			emailproveedor:{  required: "Ingrese Email de Proveedor", email: "Ingrese un Email Valido" },
            contactoproveedor:{ required: "Ingrese Nombre de Contacto" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updateproveedores").serialize();
				var id= $("#updateproveedores").attr("data-id");
		        var codproveedor = id;
				
				$.ajax({
				
				type : 'POST',
				url  : 'editproveedor.php?codproveedor='+codproveedor,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
							 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
		$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE PROVEEDOR YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
							 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
					    $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
   					   setTimeout("location.href='proveedores.php'", 5000);
				
				});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PROVEEDORES */
 

 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 











 
 /* FUNCION JQUERY PARA VALIDAR REGISTRO DE PEDIDOS DE PRODUCTOS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#pedidos").validate({
      rules:
	  {
			codpedido: { required: true, },
			codproveedor: { required: true, },
			fechapedido: { required: true, },
	   },
       messages:
	   {
            codpedido:{  required: "Ingrese C&oacute;digo de Pedido" },
			codproveedor:{  required: "	Seleccione Pedido" },
			fechapedido:{  required: "Ingrese Fecha Compra" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#pedidos").serialize();
			    var nuevaFila ="<tr>"+"<td colspan=5><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
		  
		        $.ajax({
				
				type : 'POST',
				url  : 'forpedidos.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO HA INGRESADO PRODUCTOS PARA PEDIDOS, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#pedidos")[0].reset();	
					    $("#carrito tbody").html("");
						$(nuevaFila).appendTo("#carrito tbody");
					    $("#codigopedido").load("funciones.php?muestracodigopedido=si");
						setTimeout(function() { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
   
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PEDIDOS DE PRODUCTOS */




/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PEDIDOS DE PRODUCTOS */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatedetallespedidos").validate({
        rules:
	  {
			codpedido: { required: true, },
			codproducto : { required: true, },
			producto: { required: true, },
			codcategoria: { required: true, },
			cantpedido: { required: true, digits : true  },
			fechadetallepedido: { required: true, },
	   },
       messages:
	   {
            codpedido:{ required: "Ingrese C&oacute;digo Pedido" },
			codproducto : { required : "Ingrese C&oacute;digo Producto"  },
			producto:{  required: "Ingrese Descripci&oacute;n Producto"  },
			codcategoria:{ required: "Seleccione Categoria de Producto" },
			cantpedido:{  required: "Ingrese Cantidad de Pedido", digits: "Ingrese solo digitos"  },
			fechadetallepedido:{ required: "Ingrese Fecha de Pedido" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatedetallespedidos").serialize();
				var id= $("#updatedetallespedidos").attr("data-id");
		        var coddetallepedido = id;
				
				var cant = $('#cantpedido').val();
				cant    = parseInt(cant);
	
	       if (cant==0) {
	            
				$("#cantpedido").focus();
				$('#cantpedido').val("");
				$('#cantpedido').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UNA CANTIDAD VALIDA PARA PEDIDOS DE PRODUCTOS');
         
        return false;
	 
	  } else {
		        $.ajax({
				
				type : 'POST',
				url  : 'editdetallepedidos.php?coddetallepedido='+coddetallepedido,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');

											
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
    					setTimeout("location.href='detallespedidos.php'", 5000);
				
				});
											
								}
						   }
				});
				return false;
	               }
		}
	   /* form submit */
	   
	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE DETALLE DE PEDIDOS DE PRODUCTOS */
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COMPRAS DE PRODUCTOS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#compras").validate({
      rules:
	  {
			codcompra: { required: true, },
			codseriec: { required: true, },
			codautorizacionc: { required: true, },
			codproveedor: { required: true, },
			tipocompra: { required: true, },
			formacompra: { required: true, },
			fechavencecredito: { required: true, },
			fechacompra: { required: true, },
			descuento: { required: true, },
	   },
       messages:
	   {
            codcompra:{  required: "Ingrese N&deg; de Compra" },
			codseriec:{  required: "Ingrese N&deg; de Serie" },
			codautorizacionc:{  required: "Ingrese N&deg; de Autorizaci&oacute;n" },
			codproveedor:{  required: "	Seleccione Proveedor" },
			tipocompra:{  required: "	Seleccione Tipo de Pago" },
			formacompra:{  required: "Por favor seleccione Forma de Pago" },
			fechavencecredito:{  required: "Ingrese Fecha de Vencimiento de Cr&eacute;dito" },
			fechacompra:{  required: "Ingrese Fecha de Compra" },
			descuento:{  required: "Ingrese Descuento para Compra" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#compras").serialize();
			    var nuevaFila ="<tr>"+"<td colspan=7><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
				var total = $('#txtTotal').val();
	
	        if (total==0.00) {
	            
				$("#producto").focus();
				$('#producto').css('border-color','#2b4049');
				alert('POR FAVOR DEBE DE AGREGAR PRODUCTOS AL CARRITO PARA CONTINUAR CON LA COMPRA');
         
        return false;
	 
	  } else {
				$.ajax({
				
				type : 'POST',
				url  : 'forcompras.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Compras');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO HA INGRESADO PRODUCTOS PARA ENTRADA EN ALMACEN, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Compras');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#compras")[0].reset();	
					    //$("#nrocompra").load("funciones.php?muestranrocompra=si");
					    //$("#nroseriec").load("funciones.php?muestranroseriec=si");
					    //$("#nroautorizacionc").load("funciones.php?muestranroautorizacionc=si");
					    $("#nrolote").load("funciones.php?muestranrolote=si");
					    $("#carrito tbody").html("");
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
						$(nuevaFila).appendTo("#carrito tbody");
						setTimeout(function() { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Compras');
										
									});
								}
						   }
				});
				return false;
		         }
		}
	   /* form submit */
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE COMPRAS DE PRODUCTOS */

 
/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE COMPRAS DE PRODUCTOS */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatedetallescompras").validate({
        rules:
	  {
			codcompra: { required: true, },
			codproducto : { required: true, },
			producto: { required: true, },
			codcategoria: { required: true, },
			cantcompra: { required: true, digits : true  },
			precio1: { required: true, number : true },
			lote: { required: true, },
	   },
       messages:
	   {
            codcompra:{ required: "Ingrese C&oacute;digo de Compra" },
			codproducto : { required : "Ingrese C&oacute;digo Producto"  },
			producto:{  required: "Ingrese Descripci&oacute;n Producto"  },
			codcategoria:{ required: "Seleccione Categoria de Producto" },
			cantcompra:{  required: "Ingrese Cantidad de Compra", digits: "Ingrese solo digitos"  },
			precio1:{ required: "Ingrese Precio de Compra", number: "Ingrese solo digitos con 2 decimales" },
			lote:{  required: "Ingrese N&deg; de Lote"  },

       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatedetallescompras").serialize();
				var id= $("#updatedetallescompras").attr("data-id");
		        var coddetallecompra = id;
				
			    var cant = $('#cantcompra').val();
				var prec = $('#precio1').val();
				cant    = parseInt(cant);
	
	       if (prec==0.00 || prec==0) {
	            
				$("#precio1").focus();
				$('#precio1').val("");
				$('#precio1').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UN PRECIO VALIDO PARA COMPRA DE PRODUCTOS');
         
        return false;
		
			} else  if (cant==0) {
	            
				$("#cantcompra").focus();
				$('#cantcompra').val("");
				$('#cantcompra').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UNA CANTIDAD VALIDA PARA COMPRA DE PRODUCTOS');
         
        return false;
	 
	  } else {
		        $.ajax({
				
				type : 'POST',
				url  : 'editdetallecompras.php?coddetallecompra='+coddetallecompra,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE DETALLE DE COMPRA NO PUEDE SER ACTUALIZADO, SE ENCUENTRA INACTIVO PARA ACTUALIZAR !</div></center>');
											
										$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
    					setTimeout("location.href='detallescompras.php'", 5000);
				
				});
								}
						   }
				});
				return false;
	           }
		}
	   /* form submit */	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE DETALLE DE COMPRAS DE PRODUCTOS */
 
  










































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE NUEVOS CLIENTES PARA FACTURAR VENTAS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#ventaclientes").validate({
      rules:
	  {
			cedcliente: { required: true, digits : true },
			nomcliente: { lettersonly: true, },
			direccliente: { required: true, },
			tlfcliente: { required: false, digits : false  },
			emailcliente: { required: false, email: true },
	   },
       messages:
	   {
            cedcliente:{ required: "Ingrese C&eacute;dula de Cliente", digits: "Ingrese solo digitos para C&eacute;dula"},
			nomcliente:{ required: "Ingrese Nombre de Cliente" },
            direccliente:{ required: "Ingrese Direcci&oacute;n de Cliente" },
			tlfcliente: { required: "Ingrese Telefono de Cliente", digits: "Ingrese solo digitos" },
			emailcliente:{  required: "Ingrese Email de Cliente", email: "Ingrese un Email Valido" },
           
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#ventaclientes").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forventas.php',
				data : data,
				beforeSend: function()
				{	
					$("#errorres").fadeOut();
					$("#btn-submit2").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#errores").fadeIn(1000, function(){
											
											
	$("#errores").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit2").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#errores").fadeIn(1000, function(){
											
											
	$("#errores").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit2").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#errores").fadeIn(1000, function(){
											
						            $("#errores").html('<center> &nbsp; '+data+' </center>');
						            $("#ventaclientes")[0].reset();
					            	setTimeout(function() { $("#errores").html(""); }, 5000); 					
								    $("#btn-submit2").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE NUEVOS CLIENTES PARA FACTURAR VENTAS*/


/* FUNCION JQUERY PARA VALIDAR REGISTRO DE VENTAS DE PRODUCTOS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#ventas").validate({
     rules:
	  {
			busqueda: { required: true, },
			formapagove: { required: true, },
			montoabono: { required: true, },
			descuento: { required: true, },
			montopagado: { required: true, },
			montodevuelto: { required: true, },
	   },
       messages:
	   {
            busqueda:{  required: "Por favor realice la B&uacute;squeda del Cliente" },
			formapagove:{  required: "Por favor seleccione Forma de Pago" },
			montoabono:{  required: "Ingrese Monto de Abono" },
			descuento:{  required: "Ingrese Descuento para Venta" },
			montopagado:{  required: "Ingrese Monto Pagado" },
			montodevuelto:{  required: "Ingrese Monto Devuelto" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#ventas").serialize();
			    var nuevaFila ="<tr>"+"<td colspan=6><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
				var total = $('#txtTotal').val();
				var cliente = $('#codcliente').val();
				//var tipopagove = $('#tipopagove').val();
				//var dia = $('#dia').val();
				//var mes = $('#mes').val();
				//var year = $('#year').val();
	
	    /* if (tipopagove=="CREDITO" || dia=="") {
	            
				$("#dia").focus();
				$('#dia').val("");
				$('#dia').css('border-color','#2b4049');
				alert('POR FAVOR SELECCIONE DIA DE FECHA DE VENCIMIENTO DE CR\u00C9DITO');
         
       return false;
	 
	  } else if (tipopagove=="CREDITO" || mes=="") {
	            
				$("#mes").focus();
				$('#mes').val("");
				$('#mes').css('border-color','#2b4049');
				alert('POR FAVOR SELECCIONE MES DE FECHA DE VENCIMIENTO DE CR\u00C9DITO');
         
       return false;
	 
	  } else if (tipopagove=="CREDITO" || year=="") {
	            
				$("#year").focus();
				$('#year').val("");
				$('#year').css('border-color','#2b4049');
				alert('POR FAVOR SELECCIONE A&Ntilde;O DE FECHA DE VENCIMIENTO DE CR\u00C9DITO');
         
       return false;
	 
	  } else*/ if (total==0.00) {
	            
				$("#producto").focus();
				$('#producto').css('border-color','#2b4049');
				alert('POR FAVOR DEBE DE AGREGAR PRODUCTOS AL CARRITO PARA CONTINUAR CON LA VENTA');
         
        return false;
	 
	  } else if (cliente=="") {
	            
				$("#busqueda").focus();
				$("#busqueda").val("");
				$('#busqueda').css('border-color','#2b4049');
				alert('POR FAVOR REALICE LA BUSQUEDA DEL CLIENTE CORRECTAMENTE');
         
        return false;
	 
	  } else {
				$.ajax({
				
				type : 'POST',
				url  : 'forventas.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Ventas');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO HA INGRESADO PRODUCTOS PARA VENTAS, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Ventas');
										
									});
								}
								else if(data==3)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> SI EL ABONO DE CREDITO ES MAYOR O IGUAL AL TOTAL DE PAGO DE VENTA, POR FAVOR MODIFIQUE EL TIPO DE PAGO A CONTADO!</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Ventas');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#ventas")[0].reset();	
					    $("#nroventa").load("funciones.php?muestranroventas=si");
					    $("#nroserieve").load("funciones.php?muestranroserieve=si");
					    $("#nroautorizacionve").load("funciones.php?muestranroautorizacionve=si");
						$("#muestraformapago").load("funciones.php?BuscaFormaPago=si&tipopago=CONTADO");
					    $("#carrito tbody").html("");
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
						$(nuevaFila).appendTo("#carrito tbody");
						setTimeout(function() { $("#error").html(""); }, 80000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		         }
		}
	   /* form submit */
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE VENTAS DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE VENTAS DE PRODUCTOS */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatedetallesventas").validate({
        rules:
	  {
			codventa: { required: true, },
			codproducto : { required: true, },
			producto: { required: true, },
			codcategoria: { required: true, },
			cantventa: { required: true, digits : true  },
			precioventa: { required: true, number : true },
	   },
       messages:
	   {
            codventa:{ required: "Ingrese C&oacute;digo de Venta" },
			codproducto : { required : "Ingrese C&oacute;digo Producto"  },
			producto:{  required: "Ingrese Descripci&oacute;n Producto"  },
			codcategoria:{ required: "Seleccione Categoria de Producto" },
			cantventa:{  required: "Ingrese Cantidad", digits: "Ingrese solo digitos"  },
			precioventa:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },

       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatedetallesventas").serialize();
				var id= $("#updatedetallesventas").attr("data-id");
		        var coddetalleventa = id;
				
				var cant = $('#cantventa').val();
	            var exist = $('#existencia').val();
	            var producto = $('#producto').val();
				cant    = parseInt(cant);
			    exist    = parseInt(exist);
	
	          if (cant>exist) {	 
	            
				alert('LA CANTIDAD ' + cant + ' NO PUEDE SER MAYOR QUE LA EXISTENCIA ' + exist + ' DE PRODUCTOS : ' + producto);
         
        return false;
		
		} else  if (cant==0) {
	            
				$("#cantventa").focus();
				$('#cantventa').val("");
				$('#cantventa').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UNA CANTIDAD VALIDA PARA VENTA DE PRODUCTOS');
         
        return false;
	 
	  } else { 
				$.ajax({
				
				type : 'POST',
				url  : 'editdetalleventas.php?coddetalleventa='+coddetalleventa,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
    					setTimeout("location.href='detallesventas.php'", 5000);
				
				});
								}
						   }
				});
				return false;
	         }
		}
	   /* form submit */	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE DETALLE DE VENTAS DE PRODUCTOS */ 
 




































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ABONOS DE CREDITOS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#abonoscreditos").validate({
     rules:
	  {
			montoabono: { required: true, },
	   },
       messages:
	   {
            montoabono:{  required: "Ingrese Monto de Abono" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#abonoscreditos").serialize();
			    var nuevaFila ="<tr>"+"<td colspan=6><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
				var totaldebe = $('#totaldebe').val();
				var montoabono = $('#montoabono').val();
				totaldebe1    = parseFloat(totaldebe);
			    montoabono1    = parseFloat(montoabono);
	
	        if (montoabono==0.00 || montoabono=="") {
	            
				$("#montoabono").focus();
				$('#montoabono').css('border-color','#2b4049');
				alert('POR FAVOR DEBE DE INGRESAR UN MONTO VALIDO PARA ABONAR A CREDITO');
         
        return false;
	 
	  } else if (montoabono1 > totaldebe) {
	            
				$("#montoabono").focus();
				$("#montoabono").val("");
				$('#montoabono').css('border-color','#2b4049');
				alert('POR FAVOR EL MONTO ABONADO ES MAYOR AL QUE DEBE \n EN ESTA FACTURA DE CREDITO, VERIFIQUE EL MONTO POR FAVOR');
         
        return false;
	 
	  } else {
				$.ajax({
				
				type : 'POST',
				url  : 'forcreditos.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Abono');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> POR FAVOR EL MONTO ABONADO ES MAYOR AL QUE DEBE EN ESTA FACTURA DE CREDITO, VERIFIQUE EL MONTO POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar Abono');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#abonoscreditos")[0].reset();	
					    $("#muestraclientesabonos").html("");
						$("#muestraformularioabonos").html("");
						setTimeout(function() { $("#error").html(""); }, 80000);
						$("#btn-submit").html('<span class="fa fa-search"></span> Realizar Busqueda');
										
									});
								}
						   }
				});
				return false;
		         }
		}
	   /* form submit */
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE ABONOS DE CREDITOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ABONOS DE CREDITOS */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatedetallesventaWWWWWWWWWWWWs").validate({
        rules:
	  {
			codventa: { required: true, },
			codproducto : { required: true, },
			producto: { required: true, },
			codcategoria: { required: true, },
			cantventa: { required: true, digits : true  },
			precioventa: { required: true, number : true },
	   },
       messages:
	   {
            codventa:{ required: "Ingrese C&oacute;digo de Venta" },
			codproducto : { required : "Ingrese C&oacute;digo Producto"  },
			producto:{  required: "Ingrese Descripci&oacute;n Producto"  },
			codcategoria:{ required: "Seleccione Categoria de Producto" },
			cantventa:{  required: "Ingrese Cantidad", digits: "Ingrese solo digitos"  },
			precioventa:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },

       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatedetallesventas").serialize();
				var id= $("#updatedetallesventas").attr("data-id");
		        var coddetalleventa = id;
				
				var cant = $('#cantventa').val();
	            var exist = $('#existencia').val();
	            var producto = $('#producto').val();
				cant    = parseInt(cant);
			    exist    = parseInt(exist);
	
	          if (cant>exist) {	 
	            
				alert('LA CANTIDAD ' + cant + ' NO PUEDE SER MAYOR QUE LA EXISTENCIA ' + exist + ' DE PRODUCTOS : ' + producto);
         
        return false;
		
		} else  if (cant==0) {
	            
				$("#cantventa").focus();
				$('#cantventa').val("");
				$('#cantventa').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UNA CANTIDAD VALIDA PARA VENTA DE PRODUCTOS');
         
        return false;
	 
	  } else { 
				$.ajax({
				
				type : 'POST',
				url  : 'editdetalleventas.php?coddetalleventa='+coddetalleventa,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
    					setTimeout("location.href='detallesventas.php'", 5000);
				
				});
								}
						   }
				});
				return false;
	         }
		}
	   /* form submit */	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ABONOS DE CREDITOS */


































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE DEVOLUCIONES DE PRODUCTOS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#devoluciones").validate({
      rules:
	  {
			coddevolucion: { required: true, },
			codproveedor: { required: true, },
			fechacompra: { required: true, },
	   },
       messages:
	   {
            coddevolucion:{  required: "Ingrese C&oacute;digo de Devoluci&oacute;n" },
			codproveedor:{  required: "	Seleccione Proveedor" },
			fechacompra:{  required: "Ingrese Fecha de Devoluci&oacute;n" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#devoluciones").serialize();
			    var nuevaFila ="<tr>"+"<td colspan=6><center><label>NO HAY PRODUCTOS AGREGADOS</label></center></td>"+"</tr>";
				var total = $('#txtTotal').val();
	
	        if (total==0.00) {
	            
				$("#producto").focus();
				$('#producto').css('border-color','#2b4049');
				alert('POR FAVOR DEBE DE AGREGAR PRODUCTOS AL CARRITO PARA CONTINUAR CON LA DEVOLUCION');
         
        return false;
	 
	  } else {
				$.ajax({
				
				type : 'POST',
				url  : 'fordevolucion.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO HA INGRESADO PRODUCTOS PARA DEVOLUCION, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#devoluciones")[0].reset();	
					    $("#codigodevolucion").load("funciones.php?muestracodigodevolucion=si");
					    $("#carrito tbody").html("");
						$("#lblsubtotal").text("0.00");
						$("#lbliva").text("0.00");
						$("#lbltotal").text("0.00");
						$("#txtsubtotal").val("0.00");
						$("#txtIva").val("0.00");
						$("#txtTotal").val("0.00");
						$(nuevaFila).appendTo("#carrito tbody");
						setTimeout(function() { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		         }
		}
	   /* form submit */
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE DEVOLUCIONES DE PRODUCTOS */

 
/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE DEVOLUCIONES DE PRODUCTOS */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatedetallesdevoluciones").validate({
        rules:
	  {
			coddevolucion: { required: true, },
			codproducto : { required: true, },
			producto: { required: true, },
			codcategoria: { required: true, },
			cantdevolucion: { required: true, digits : true },
			lote: { required: true,},
			precio: { required: true, number : true },
			lote: { required: true, },
	   },
       messages:
	   {
            coddevolucion:{ required: "Ingrese C&oacute;digo de Devoluci&oacute;n" },
			codproducto : { required : "Ingrese C&oacute;digo de Producto"  },
			producto:{  required: "Ingrese Descripci&oacute;n de Producto"  },
			codcategoria:{ required: "Seleccione Categoria de de Producto" },
			cantdevolucion:{  required: "Ingrese Cantidad de Compra", digits: "Ingrese solo digitos"  },
			lote:{ required: "Ingrese Lote de Producto" },
			precio:{ required: "Ingrese Precio de Compra", number: "Ingrese solo digitos con 2 decimales" },
			lote:{  required: "Ingrese N&deg; de Lote"  },

       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatedetallesdevoluciones").serialize();
				var id= $("#updatedetallesdevoluciones").attr("data-id");
		        var coddetalledevolucion = id;
				
			    var cant = $('#cantdevolucion').val();
				var prec = $('#precio').val();
				cant    = parseInt(cant);
	
	       if (prec==0.00 || prec==0) {
	            
				$("#precio").focus();
				$('#precio').val("");
				$('#precio').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UN PRECIO VALIDO PARA DEVOLUCI&Oacute;N DE PRODUCTOS');
         
        return false;
		
			} else  if (cant==0) {
	            
				$("#cantdevolucion").focus();
				$('#cantdevolucion').val("");
				$('#cantdevolucion').css('border-color','#2b4049');
				alert('POR FAVOR INGRESE UNA CANTIDAD VALIDA PARA DEVOLUCI&Oacute;N DE PRODUCTOS');
         
        return false;
	 
	  } else {
		        $.ajax({
				
				type : 'POST',
				url  : 'editdetalledevolucion.php?coddetalledevolucion='+coddetalledevolucion,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
    					setTimeout("location.href='detallesdevolucion.php'", 5000);
				
				});
								}
						   }
				});
				return false;
	           }
		}
	   /* form submit */	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE DETALLE DE DEVOLUCIONES DE PRODUCTOS */
 




































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE NUEVOS CLIENTES PARA FACTURAR SERVICIOS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#servicioclientes").validate({
      rules:
	  {
			cedcliente: { required: true, digits : true },
			nomcliente: { lettersonly: true, },
			direccliente: { required: true, },
			tlfcliente: { required: false, digits : false  },
			emailcliente: { required: false, email: true },
	   },
       messages:
	   {
            cedcliente:{ required: "Ingrese C&eacute;dula de Cliente", digits: "Ingrese solo digitos para C&eacute;dula"},
			nomcliente:{ required: "Ingrese Nombre de Cliente" },
            direccliente:{ required: "Ingrese Direcci&oacute;n de Cliente" },
			tlfcliente: { required: "Ingrese Telefono de Cliente", digits: "Ingrese solo digitos" },
			emailcliente:{  required: "Ingrese Email de Cliente", email: "Ingrese un Email Valido" },
           
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#servicioclientes").serialize();
				
				$.ajax({
				
				type : 'POST',
				url  : 'forservicios.php',
				data : data,
				beforeSend: function()
				{	
					$("#errorres").fadeOut();
					$("#btn-submit2").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#errores").fadeIn(1000, function(){
											
											
	$("#errores").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit2").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#errores").fadeIn(1000, function(){
											
											
	$("#errores").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> ESTE CLIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
								    $("#btn-submit2").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#errores").fadeIn(1000, function(){
											
						            $("#errores").html('<center> &nbsp; '+data+' </center>');
						            $("#servicioclientes")[0].reset();
					            	setTimeout(function() { $("#errores").html(""); }, 5000); 					
								    $("#btn-submit2").html('<span class="fa fa-save"></span> Registrar');
										
									});
											
								}
						   }
				});
				return false;
		}
	   /* form submit */
	   
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE NUEVOS CLIENTES PARA FACTURAR SERVICIOS*/


/* FUNCION JQUERY PARA VALIDAR REGISTRO DE FACTURAS DE SERVICIOS */	 
	 
$('document').ready(function()
{ 
     /* validation */
	 $("#servicios").validate({
     rules:
	  {
			busqueda: { required: true, },
			tipopago: { required: true, },
	   },
       messages:
	   {
            busqueda:{  required: "Por favor realice la B&uacute;squeda del Cliente" },
			tipopago:{  required: "Por favor seleccione Tipo de Pago" },
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#servicios").serialize();
			    var nuevaFila ="<tr>"+"<td colspan=6><center><label>NO HAY SERVICIOS AGREGADOS</label></center></td>"+"</tr>";
				var total = $('#txtTotal').val();
				var cliente = $('#codcliente').val();
	
	        if (total==0.00) {
	            
				$("#servicio").focus();
				$('#servicio').css('border-color','#2b4049');
				alert('POR FAVOR DEBE DE AGREGAR SERVICIOS AL CARRITO PARA CONTINUAR CON LA FACTURA');
         
        return false;
	 
	  } else if (cliente=="") {
	            
				$("#busqueda").focus();
				$("#busqueda").val("");
				$('#busqueda').css('border-color','#2b4049');
				alert('POR FAVOR REALICE LA BUSQUEDA DEL CLIENTE CORRECTAMENTE');
         
        return false;
	 
	  } else {
				$.ajax({
				
				type : 'POST',
				url  : 'forservicios.php',
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
																				
								}
								else if(data==2)
								{
									
					$("#error").fadeIn(1000, function(){
											
											
	$("#error").html('<center><div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> NO HA INGRESADO SERVICIOS AL CARRITO PARA FACTURAR, VERIFIQUE DE NUEVO POR FAVOR !</div></center>');
											
										$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#servicios")[0].reset();	
					    $("#codigoservicio").load("funciones.php?muestracodigoservicios=si");
					    $("#carrito tbody").html("");
						$("#lblsubtotal").text("0.00");
						$("#lbliva").text("0.00");
						$("#lbldescuento").text("0.00");
						$("#lbltotal").text("0.00");
						$("#txtsubtotal").val("0.00");
						$("#txtIva").val("0.00");
						$("#txtDescuento").text("0.00");
						$("#txtTotal").val("0.00");
						$(nuevaFila).appendTo("#carrito tbody");
						setTimeout(function() { $("#error").html(""); }, 5000);
						$("#btn-submit").html('<span class="fa fa-save"></span> Registrar');
										
									});
								}
						   }
				});
				return false;
		         }
		}
	   /* form submit */
});

/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE FACTURAS DE SERVICIOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE FACTURAS DE SERVICIOS */	 
	 
     $('document').ready(function()
{ 
     /* validation */
	 $("#updatedetallesservicios").validate({
        rules:
	  {
			codservicio: { required: true, },
			coditems : { required: true, },
			nombreitems: { required: true, },
			cantservicio: { required: true, digits : true  },
			precioservicio: { required: true, number : true },
	   },
       messages:
	   {
            codservicio:{ required: "Ingrese C&oacute;digo de Factura" },
			coditems : { required : "Ingrese C&oacute;digo de Servicio"  },
			nombreitems:{  required: "Ingrese Descripci&oacute;n de Servicio"  },
			cantservicio:{  required: "Ingrese Cantidad de Servicio", digits: "Ingrese solo digitos"  },
			precioservicio:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },

       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* form submit */
	  function submitForm()
	   {		
				var data = $("#updatedetallesservicios").serialize();
				var id= $("#updatedetallesservicios").attr("data-id");
		        var coddetalleservicio = id;
				
				var cant = $('#cantservicio').val();
				cant    = parseInt(cant);
	
	          if (cant<=0) {	 
	            
				$("#cantservicio").focus();
				$("#cantservicio").val("");
				$('#cantservicio').css('border-color','#2b4049');
				alert('POR FAOR INGRESE UNA CANTIDAD VALIDA PARA SERVICIOS');
         
        return false;
	 
	  } else { 
				$.ajax({
				
				type : 'POST',
				url  : 'editdetalleservicios.php?coddetalleservicio='+coddetalleservicio,
				data : data,
				beforeSend: function()
				{	
					$("#error").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando ...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#error").fadeIn(1000, function(){
											
											
	("#error").html('<center><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="fa fa-info-circle"></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR !</div></center>');
											
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
																				
								}
								else{
										
									$("#error").fadeIn(1000, function(){
											
						$("#error").html('<center> &nbsp; '+data+' </center>');
						$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
    					setTimeout("location.href='detallesservicios.php'", 5000);
				
				});
								}
						   }
				});
				return false;
	         }
		}
	   /* form submit */	   
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE DETALLE DE FACTURAS DE SERVICIOS */ 
 