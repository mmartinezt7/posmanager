<?php
require_once("classconexion.php");
session_start();
include_once('funciones_basicas.php');


#################################################### AQUI TERMINA LA CLASE LOGIN ######################################################
class Login extends Db
{
	
	public function __construct()
    {
        parent::__construct();
    } 	
	
		
##################################################################  CLASE LOGIN   ######################################################################


############  FUNCION PARA EXPIRAR SESSION POR INACTIVIDAD  ################
public function ExpiraSession(){

if(!isset($_SESSION['usuario'])){// Esta logeado?.
    header("Location: logout.php"); 
}

//Verifico el tiempo si esta seteado, caso contrario lo seteo.
if(isset($_SESSION['time'])){
 $tiempo = $_SESSION['time'];
}else{
 $tiempo = strtotime(date("Y-m-d h:i:s"));
}

$inactividad =360000000000000000;   //Exprecion en segundos.

$actual =  strtotime(date("Y-m-d h:i:s"));

if( ($actual-$tiempo) >= $inactividad){
?>					
			<script type='text/javascript' language='javascript'>
			alert('SU SESSION A EXPIRADO \nPOR FAVOR LOGUEESE DE NUEVO PARA ACCEDER AL SISTEMA') 
			document.location.href='logout.php'	 
			</script> 
<?php
    
	}else{

 $_SESSION['time'] =$actual;
 
    } 
}
	
############  FIN DE FUNCION PARA EXPIRAR SESSION POR INACIVIDAD  ################



##############################################  FUNCION PARA ACCEDER AL SISTEMA DE VENTA ########################################################
	public function Logueo()
	{
		self::SetNames();
		if(empty($_POST["usuario"]) or empty($_POST["password"]))
		{
		echo "<div class='alert alert-danger'>";
        echo "<span class='fa fa-info-circle'></span> LOS CAMPOS NO PUEDEN IR VACIOS </div>";
        echo "</div>";		
		exit;
		}
		$pass = sha1(md5(strtoupper($_POST["password"])));
		$sql = " select * from usuarios INNER JOIN cajas ON usuarios.codigo = cajas.codigo WHERE usuarios.usuario = ? and usuarios.password = ? and usuarios.status = 'ACTIVO'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array( strtoupper($_POST["usuario"]), $pass ) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		echo "<div class='alert alert-danger'>";
        echo "<span class='fa fa-info-circle'></span> LOS DATOS INGRESADOS NO EXISTEN </div>";
        echo "</div>";		
		exit;
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[]=$row;
			}
			
			$_SESSION["codigo"] = $p[0]["codigo"];
			$_SESSION["cedula"] = $p[0]["cedula"];
			$_SESSION["nombres"] = $p[0]["nombres"];
			$_SESSION["sexo"] = $p[0]["sexo"];
			$_SESSION["cargo"] = $p[0]["cargo"];
			$_SESSION["email"] = $p[0]["email"];
			$_SESSION["usuario"] = $p[0]["usuario"];
			$_SESSION["nivel"] = $p[0]["nivel"];
			$_SESSION["status"] = $p[0]["status"];
			$_SESSION["codcaja"] = $p[0]["codcaja"];
			$_SESSION["nrocaja"] = $p[0]["nrocaja"];
			$_SESSION["nombrecaja"] = $p[0]["nombrecaja"];
			
			$query = " insert into log values (null, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1,$a);
			$stmt->bindParam(2,$b);
			$stmt->bindParam(3,$c);
			$stmt->bindParam(4,$d);
			$stmt->bindParam(5,$e);
			
			$a = strip_tags($_SERVER['REMOTE_ADDR']);
			$b = strip_tags(date("Y-m-d h:i:s"));
			$c = strip_tags($_SERVER['HTTP_USER_AGENT']);
			$d = strip_tags($_SERVER['PHP_SELF']);
			$e = strip_tags($_POST["usuario"]);
			$stmt->execute();
			
			switch($_SESSION["nivel"])
	{
		     case 'ADMINISTRADOR':
	         $_SESSION["acceso"]="administrador";
			
		   ?>
		   
			<script type="text/javascript">
            window.location="panel";
            </script>
			
		    <?php
		    break;
		    case 'VENDEDOR':
		    $_SESSION["acceso"]="vendedor";
			?>
		   
			<script type="text/javascript">
            window.location="panel";
            </script>
			
			<?php
		    break;
			}
	 }
		//print_r($_POST);
		exit;
	}
######################################################  FUNCION PARA ACCEDER AL SISTEMA DE VENTAS ##########################################################
















################################################################ FUNCION RECUPERAR Y ACTUALIZAR PASSWORD ############################################################

############################################### FUNCION PARA RECUPERAR CLAVE #############################################
public function RecuperarPassword()
	{
		self::SetNames();
		if(empty($_POST["email"]))
		{
			echo "1";
			exit;
		}
		
		$sql = " select * from usuarios where email = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["email"]) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "2";
		    exit;
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pa[] = $row;
			}
			$id = $pa[0]["codigo"];
			$nombres = $pa[0]["nombres"];
			$password = $pa[0]["password"];
		}
	
			$sql = " update usuarios set "
			  ." password = ? "
			  ." where "
			  ." codigo = ?;
			   ";
		    $stmt = $this->dbh->prepare($sql);
		    $stmt->bindParam(1, $password);
		    $stmt->bindParam(2, $codigo);
			
            $codigo = $id;
			$pass = strtoupper(generar_clave(10));
			$password = sha1(md5($pass));
            $stmt->execute();
		
       $para = $_POST["email"];
       $titulo = 'RECUPERACION DE PASSWORD';
       $header = 'From: ' . 'FACTURACIÓN E INVENTARIOS';
       $msjCorreo = " Nombre: $nombres\n Nuevo Passw: $pass\n Mensaje: Por favor use esta nueva clave de acceso para ingresar al Sistema de Facturación e Inventarios\n";
       mail($para, $titulo, $msjCorreo, $header);
			
		echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-check-square-o'></span> SU NUEVA CLAVE DE ACCESO LE FUE ENVIADA A SU CORREO </div>";
        echo "</div>";

}	
################################################ FIN DE FUNCION PARA RECUPERAR CLAVE  ################################################

##################################################  FUNCION PARA ACTUALIZAR PASSWORD  ################################################
	public function ActualizarPassword()
	{
		if(empty($_POST["cedula"]))
		{
			echo "1";
			exit;
		}
		
		self::SetNames();
		$sql = " update usuarios set "
			  ." cedula = ?, "
			  ." usuario = ?, "
			  ." password = ? "
			  ." where "
			  ." codigo = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $cedula);
		$stmt->bindParam(2, $usuario);
		$stmt->bindParam(3, $password);
		$stmt->bindParam(4, $codigo);	
			
		$cedula = strip_tags($_POST["cedula"]);
		$usuario = strip_tags($_POST["usuario"]);
		$password = sha1(md5($_POST["password"]));
		$codigo = strip_tags($_SESSION["codigo"]);
		$stmt->execute();
		
		echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-check-square-o'></span> SU CLAVE DE ACCESO FUE ACTUALIZADA EXITOSAMENTE, SER&Aacute; EXPULSADO DE SU SESI&Oacute;N Y DEBER&Aacute; DE ACCEDER NUEVAMENTE </div>";
        echo "</div>";		
		?>
		<script>
function redireccionar(){location.href="logout.php";}
setTimeout ("redireccionar()", 3000);
</script>
		<?php
		exit;
	}
################################################   FIN DE FUNCION PARA ACTUALIZAR PASSWORD #################################################

########################################################## FIN DE FUNCION RECUPERAR Y ACTUALIZAR PASSWORD ############################################################





























######################################################### FUNCION CONFIGURACION GENERAL DEL SISTEMA ########################################################

#################################################### FUNCION PARA SELECCIONAR CODIGO DE CONFIGURACION DE EMPRESA #################################################
	public function ConfiguracionPorId()
	{
		self::SetNames();
		$sql = " select * from configuracion where id = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array('1') );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################### FIN DE FUNCION SELECCIONAR CODIGO DE CONFIGURACION DE EMPRESA ##################################################

###################################################  FUNCION PARA ACTUALIZAR CONFIGURACION DE EMPRESA  ###################################################
	public function ActualizarConfiguracion()
	{
		
		if(empty($_POST["rifempresa"]) or empty($_POST["nomempresa"]) or empty($_POST["direcempresa"]))
		{
			echo "1";
			exit;
		}
		$sql = " update configuracion set "
			  ." rifempresa = ?, "
			  ." nomempresa = ?, "
			  ." direcempresa = ?, "
			  ." tlfempresa = ?, "
			  ." cedresponsable = ?, "
			  ." nomresponsable = ?, "
			  ." correoresponsable = ?, "
			  ." tlfresponsable = ?, "
			  ." ivav = ?, "
			  ." ivas = ? "
			  ." where "
			  ." id = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $rifempresa);
		$stmt->bindParam(2, $nomempresa);
		$stmt->bindParam(3, $direcempresa);
		$stmt->bindParam(4, $tlfempresa);
		$stmt->bindParam(5, $cedresponsable);
		$stmt->bindParam(6, $nomresponsable);
		$stmt->bindParam(7, $correoresponsable);
		$stmt->bindParam(8, $tlfresponsable);
		$stmt->bindParam(9, $ivav);
		$stmt->bindParam(10, $ivas);
		$stmt->bindParam(11, $id);
			
		$rifempresa = strip_tags($_POST["rifempresa"]);
		$nomempresa = strip_tags($_POST["nomempresa"]);
		$direcempresa = strip_tags($_POST["direcempresa"]);
		$tlfempresa = strip_tags($_POST["tlfempresa"]);
		$cedresponsable = strip_tags($_POST["cedresponsable"]);
		$nomresponsable = strip_tags($_POST["nomresponsable"]);
		$correoresponsable = strip_tags($_POST["correoresponsable"]);
		$tlfresponsable = strip_tags($_POST["tlfresponsable"]);
		$ivav = strip_tags($_POST["ivav"]);
		$ivas = strip_tags($_POST["ivas"]);
		$id = strip_tags($_POST["id"]);
		$stmt->execute();
		
		echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-check-square-o'></span> LOS DATOS DE CONFIGURACI&Oacute;N DEL SISTEMA FUERON ACTUALIZADOS EXITOSAMENTE </div>";
        echo "</div>";		
		exit;
}
################################################### FIN DE FUNCION PARA ACTUALIZAR CONFIGURACION DE EMPRESA ################################################

########################################################## FIN DE FUNCION CONFIGURACION GENERAL DEL SISTEMA ##########################################################



































##################################################################  CLASE USUARIOS   ######################################################################

################################################  FUNCION PARA REGISTRAR USUARIOS  ################################################
	public function RegistrarUsuarios()
	{
		self::SetNames();
		if(empty($_POST["nombres"]) or empty($_POST["usuario"]) or empty($_POST["password"]))
		{
			echo "1";
			exit;
		}
		$sql = " select cedula from usuarios where cedula = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["cedula"]) );
		$num = $stmt->rowCount();
		if($num > 0)
		{
		
		echo "2";
		exit;
		}
		else
		{
		$sql = " select email from usuarios where email = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["email"]) );
		$num = $stmt->rowCount();
		if($num > 0)
		{
		
		echo "3";
		exit;
		}
		else
		{
		$sql = " select usuario from usuarios where usuario = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["usuario"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " insert into usuarios values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $cedula);
			$stmt->bindParam(2, $nombres);
			$stmt->bindParam(3, $sexo);
			$stmt->bindParam(4, $cargo);
			$stmt->bindParam(5, $email);
			$stmt->bindParam(6, $usuario);
			$stmt->bindParam(7, $password);
			$stmt->bindParam(8, $nivel);
			$stmt->bindParam(9, $status);
			
			$cedula = strip_tags($_POST["cedula"]);
			$nombres = strip_tags($_POST["nombres"]);
			$sexo = strip_tags($_POST["sexo"]);
			$cargo = strip_tags($_POST["cargo"]);
			$email = strip_tags($_POST["email"]);
			$usuario = strip_tags($_POST["usuario"]);
			$password = sha1(md5($_POST["password"]));
			$nivel = strip_tags($_POST["nivel"]);
			$status = strip_tags("ACTIVO");
			$stmt->execute();
		
		##################  SUBIR FOTO DE USUARIOS ######################################
         //datos del arhivo  
         if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
		 if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
		 if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; }  
         //compruebo si las características del archivo son las que deseo  
		 if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<50000) 
		 {  
		 if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["cedula"].".jpg"))
		 { 
		 ## se puede dar un aviso
		 } 
		 ## se puede dar otro aviso 
		 }
		##################  FINALIZA SUBIR FOTO DE USUARIOS ######################################


		    echo "<div class='alert alert-success'>";
		    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL USUARIO FUE REGISTRADO EXITOSAMENTE </div>";
            echo "</div>";		
		    exit;
		}
		else
		{
			echo "4";
			exit;
		   }
		}
	}
}
#################################################  FIN DE FUNCION PARA REGISTRAR USUARIOS  ################################################

##################################################  FUNCION PARA LISTAR USUARIOS ################################################
	public function ListarUsuarios()
	{
		self::SetNames();
		$sql = " select * from usuarios ";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
################################################  FIN DE FUNCION PARA LISTAR USUARIOS  #################################################

################################################  FUNCION PARA LISTAR LOGS DE USUARIOS EN GENERAL  ################################################
	public function ListarLogs()
	{
		self::SetNames();
		
		$sql = " select * from log ";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
################################################ FIN DE FUNCION PARA LISTAR LOGS DE USUARIOS EN GENERAL ################################################

#################################################### FUNCION PARA SELECCIONAR USUARIOS #################################################
	public function UsuariosPorId()
	{
		self::SetNames();
		$sql = " select * from usuarios where codigo = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codigo"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################### FIN DE FUNCION PARA SELECCIONAR USUARIOS ##################################################
	
	
###################################################  FUNCION PARA ACTUALIZAR USUARIOS  ###################################################
	public function ActualizarUsuarios()
	{
		
		if(empty($_POST["cedula"]) or empty($_POST["nombres"]) or empty($_POST["usuario"]) or empty($_POST["password"]))
		{
			echo "1";
			exit;
		}
		self::SetNames();
		$sql = " select * from usuarios where codigo != ? and cedula = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codigo"], $_POST["cedula"]) );
		$num = $stmt->rowCount();
		if($num > 0)
		{
		echo "2";
		exit;
		}
		else
		{
		$sql = " select email from usuarios where codigo != ? and email = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codigo"], $_POST["email"]) );
		$num = $stmt->rowCount();
		if($num > 0)
		{
		echo "3";
		exit;
		}
		else
		{
		$sql = " select usuario from usuarios where codigo != ? and usuario = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codigo"], $_POST["usuario"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		$sql = " update usuarios set "
			  ." cedula = ?, "
			  ." nombres = ?, "
			  ." sexo = ?, "
			  ." cargo = ?, "
			  ." email = ?, "
			  ." usuario = ?, "
			  ." password = ?, "
			  ." nivel = ?, "
			  ." status = ? "
			  ." where "
			  ." codigo = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $cedula);
		$stmt->bindParam(2, $nombres);
		$stmt->bindParam(3, $sexo);
		$stmt->bindParam(4, $cargo);
		$stmt->bindParam(5, $email);
		$stmt->bindParam(6, $usuario);
		$stmt->bindParam(7, $password);
		$stmt->bindParam(8, $nivel);
		$stmt->bindParam(9, $status);
		$stmt->bindParam(10, $codigo);
			
		$cedula = strip_tags($_POST["cedula"]);
		$nombres = strip_tags($_POST["nombres"]);
		$sexo = strip_tags($_POST["sexo"]);
		$cargo = strip_tags($_POST["cargo"]);
		$email = strip_tags($_POST["email"]);
		$usuario = strip_tags($_POST["usuario"]);
		$password = sha1(md5($_POST["password"]));
		$nivel = strip_tags($_POST["nivel"]);
		$status = strip_tags(strtoupper($_POST["status"]));
		$codigo = strip_tags(strtoupper($_POST["codigo"]));
		$stmt->execute();
		
		##################  SUBIR FOTO DE USUARIOS ######################################
         //datos del arhivo  
         if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
		 if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
		 if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; }  
         //compruebo si las características del archivo son las que deseo  
		 if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<50000) 
		 {  
		 if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["cedula"].".jpg"))
		 { 
		 ## se puede dar un aviso
		 } 
		 ## se puede dar otro aviso 
		 }
		##################  FINALIZA SUBIR FOTO DE USUARIOS ######################################
		
            echo "<div class='alert alert-success'>";
		    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL USUARIO FUE ACTUALIZADO EXITOSAMENTE </div>";
            echo "</div>";		
		    exit;
	
	}
		else
		{
			echo "4";
			exit;
			}
		}
	}
}
################################################### FIN DE FUNCION PARA ACTUALIZAR USUARIOS ################################################

################################################ FUNCION PARA ELIMINAR USUARIOS ################################################
	
	public function EliminarUsuarios()
	{

		$sql = " select codigo from ventas where codigo = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codigo"])) );
		$num = $stmt->rowCount();
		if($num == 0)
		{

		$sql = " delete from usuarios where codigo = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codigo);
		$codigo = base64_decode($_GET["codigo"]);
		$stmt->execute();
		
		header("Location: usuarios?mesage=1");
		exit;
		   
		   }else {
		   
			header("Location: usuarios?mesage=2");
			exit;
		  }
			
	}
################################################ FUNCION PARA ELIMINAR USUARIOS ################################################


################################################################## FIN DE CLASE USUARIOS ######################################################################


























##################################################################  CLASE CATEGORIAS DE LIBROS ######################################################################

################################################  FUNCION PARA REGISTRAR CATEGORIAS DE LIBROS ################################################
	public function RegistrarCategorias()
	{
		self::SetNames();
		if(empty($_POST["nomcategoria"]))
		{
			echo "1";
			exit;
		}
		$sql = " select nomcategoria from categorias where nomcategoria = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["nomcategoria"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " insert into categorias values (null, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $nomcategoria);
			
			$nomcategoria = strip_tags(strtoupper($_POST["nomcategoria"]));
			$stmt->execute();


		    echo "<div class='alert alert-success'>";
		    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LA CATEGORIA DE PRODUCTO FUE REGISTRADA EXITOSAMENTE </div>";
            echo "</div>";		
		    exit;
		}
		else
		{
			echo "2";
			exit;
		}
	}
#################################################  FIN DE FUNCION PARA REGISTRAR CATEGORIAS DE LIBROS ################################################

##################################################  FUNCION PARA LISTAR CATEGORIAS DE LIBROS ################################################
	public function ListarCategorias()
	{
		self::SetNames();
		$sql = " select * from categorias";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
	
	
################################################  FIN DE FUNCION PARA LISTAR CATEGORIAS DE LIBROS #################################################


#################################################### FUNCION PARA SELECCIONAR CATEGORIAS DE LIBROS #################################################
	public function CategoriasPorId()
	{
		self::SetNames();
		$sql = " select * from categorias where codcategoria = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codcategoria"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################### FIN DE FUNCION PARA SELECCIONAR CATEGORIAS DE LIBROS ##################################################
	
###################################################  FUNCION PARA ACTUALIZAR CATEGORIAS DE LIBROS ###################################################
	public function ActualizarCategorias()
	{
		
		self::SetNames();
		if(empty($_POST["codcategoria"]) or empty($_POST["nomcategoria"]))
		{
			echo "1";
			exit;
		}
		$sql = " select nomcategoria from categorias where codcategoria != ? and nomcategoria = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codcategoria"], $_POST["nomcategoria"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		$sql = " update categorias set "
			  ." nomcategoria = ? "
			  ." where "
			  ." codcategoria = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $nomcategoria);
		$stmt->bindParam(2, $codcategoria);
			
		$codcategoria = strip_tags(strtoupper($_POST["codcategoria"]));
		$nomcategoria = strip_tags(strtoupper($_POST["nomcategoria"]));
		$stmt->execute();
		
         echo "<div class='alert alert-success'>";
		 echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
         echo "<span class='fa fa-check-square-o'></span> LA CATEGORIA DE PRODUCTO FUE ACTUALIZADA EXITOSAMENTE </div>";
         echo "</div>";		
		 exit;
	}
		else
		{
			echo "2";
			exit;
		}
  }
################################################### FIN DE FUNCION PARA ACTUALIZAR CATEGORIAS DE LIBROS ################################################

################################################ FUNCION PARA ELIMINAR CATEGORIAS DE LIBROS ################################################
	
	public function EliminarCategorias()
	{

		$sql = " select codcategoria from productos where codcategoria = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codcategoria"])) );
		$num = $stmt->rowCount();
		if($num == 0)
		{

		$sql = " delete from categorias where codcategoria = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcategoria);
		$codcategoria = base64_decode($_GET["codcategoria"]);
		$stmt->execute();
		
		header("Location: categorias?mesage=1");
		exit;
		   
		   }else {
		   
			header("Location: categorias?mesage=2");
			exit;
		  }
			
	}
################################################ FUNCION PARA ELIMINAR CATEGORIAS DE LIBROS ################################################

############################################################## FIN DE CLASE CATEGORIAS DE LIBROS ###############################################################




































##############################################################  CLASE CAJAS DE VENTAS ###############################################################

################################################  FUNCION PARA REGISTRAR CAJAS DE VENTAS ################################################
	public function RegistrarCajas()
	{
		self::SetNames();
		if(empty($_POST["nrocaja"]) or empty($_POST["nombrecaja"]))
		{
			echo "1";
			exit;
		}
		$sql = " select nombrecaja from cajas where nombrecaja = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["nombrecaja"]) );
		$num = $stmt->rowCount();
		if($num > 0)
		{
		echo "2";
		exit;
		}
		else
		{
		$sql = " select codigo from cajas where codigo = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codigo"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " insert into cajas values (null, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $nrocaja);
			$stmt->bindParam(2, $nombrecaja);
			$stmt->bindParam(3, $codigo);
			
			$nrocaja = strip_tags($_POST["nrocaja"]);
			$nombrecaja = strip_tags($_POST["nombrecaja"]);
			$codigo = strip_tags($_POST["codigo"]);
			$stmt->execute();
			
			echo "<div class='alert alert-success'>";
		    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LA CAJA PARA VENTA FUE REGISTRADA EXITOSAMENTE </div>";
            echo "</div>";		
		    exit;
		}
		else
		{
			echo "3";
			exit;
		}
	}
} 
################################################ FIN DE FUNCION PARA REGISTRAR CAJAS DE VENTAS ################################################

################################################ FUNCION PARA LISTAR CAJAS DE VENTAS ################################################

public function ListarCajas()
	{
		self::SetNames();
		$sql = " select * from cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}

################################################ FIN DE FUNCION PARA LISTAR CAJAS DE VENTAS ################################################

################################################ FUNCION PARA MOSTRAR CAJAS DE VENTAS POR CODIGO ################################################

public function CajaPorId()
	{
		self::SetNames();
		$sql = " select * from cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE cajas.codcaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codcaja"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR CAJAS DE VENTAS POR CODIGO ################################################

################################################ FUNCION PARA MOSTRAR CAJAS DE VENTAS POR CODIGO PARA REPORTES ######################################
public function CajerosPorId()
	{
		self::SetNames();
		$sql = " select * from cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE cajas.codcaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codcaja"]) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR CAJAS DE VENTAS POR CODIGO PARA REPORTES ##############################

#################################################### FUNCION PARA VERIFICAR CAJA ASIGNADA A USUARIO #################################################
	public function VerificaCaja()
	{
		self::SetNames();
		$sql = " select * from cajas where codigo = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_SESSION["codigo"]) );
		$num = $stmt->rowCount();
		if($num==0)
		{
		?>
		<script type='text/javascript' language='javascript'>
	    alert('DISCULPE, USTED NO TIENE ASIGNADA UNA CAJA PARA VENTA, \nDIRIJASE AL ADMINISTRADOR DEL SISTEMA PARA QUE LE SEA ASIGNADA UNA CAJA')  
		document.location.href='panel'	 
        </script> 
		<?php 
			exit;
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################### FIN DE FUNCION PARA VERIFICAR CAJA ASIGNADA A USUARIO ##################################################


######################################### FUNCION PARA MOSTRAR CAJAS DE VENTAS EN SESSION POR CODIGO PARA REPORTES ###########################################
public function CajerosSessionPorId()
	{
		self::SetNames();
		$sql = " select * from cajas where cajas.codigo = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_SESSION["codigo"]) );

		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
######################################## FIN DE FUNCION PARA MOSTRAR CAJAS DE VENTAS EN SESSION POR CODIGO PARA REPORTES #######################################


################################################ FUNCION PARA ACTUALIZAR CAJAS DE VENTAS ################################################

public function ActualizarCaja()
	{
		self::SetNames();
		if(empty($_POST["codcaja"]))
		{
			echo "1";
		    exit;
		}
		$sql = " select nombrecaja from cajas where codcaja != ? and nombrecaja = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codcaja"], $_POST["nombrecaja"]) );
		$num = $stmt->rowCount();
		if($num > 0)
		{
		echo "2";
		exit;
		}
		else
		{
		$sql = " select codigo from cajas where codcaja != ? and codigo = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codcaja"], $_POST["codigo"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		$sql = " update cajas set "
		      ." nrocaja = ?, "
			  ." nombrecaja = ?, "
			  ." codigo = ? "
			  ." where "
			  ." codcaja = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $nrocaja);
		$stmt->bindParam(2, $nombrecaja);
		$stmt->bindParam(3, $codigo);
		$stmt->bindParam(4, $codcaja);
			
		$nrocaja = strip_tags($_POST["nrocaja"]);
		$nombrecaja = strip_tags($_POST["nombrecaja"]);
		$codigo = strip_tags($_POST["codigo"]);
		$codcaja = strip_tags($_POST["codcaja"]);
		$stmt->execute();
		
		 echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> LA CAJA DE VENTA FUE ACTUALIZADA EXITOSAMENTE </div>"; // wrong details
		exit;
	}
		else
		{
			echo "3";
			exit;
		}
	}
} 
################################################ FIN DE FUNCION PARA ACTUALIZAR CAJAS DE VENTAS ################################################


################################################ FUNCION PARA ELIMINAR CAJAS DE VENTAS ################################################

public function EliminarCaja()
	{

		$sql = " select codcaja from ventas where codcaja = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codcaja"])) );
		$num = $stmt->rowCount();
		if($num == 0)
		{

		$sql = " delete from cajas where codcaja = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcaja);
		$codcaja = base64_decode($_GET["codcaja"]);
		$stmt->execute();
		
		header("Location: cajas?mesage=1");
		exit;
		   
		   }else {
		   
			header("Location: cajas?mesage=2");
			exit;
		  }
			
	} 

################################################ FIN DE FUNCION PARA ELIMINAR CAJAS DE VENTAS ################################################

############################################################  FIN DE CLASE CAJAS DE VENTAS  #############################################################





































##############################################################  CLASE RETIRO DE EFECTIVO ###############################################################

################################################  FUNCION PARA REGISTRAR RETIRO DE EFECTIVO ################################################
	public function RegistrarRetiro()
	{
		self::SetNames();
		if(empty($_POST["motivoretiro"]) or empty($_POST["cantretiro"]))
		{
			echo "1";
			exit;
		}
		
		########### HAGO LA CONSULTA DE TOTAL DE VENTAS POR CAJAS EN LA FECHA ACTUAL #############
		$sql2 = "select sum(totalpago) as totalpago from ventas where codcaja = ? and DATE_FORMAT(fechaventa,'%Y-%m-%d') = '".date('Y-m-d')."'";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($_POST["codcaja"]));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch())
			{
				$pa[] = $row;
			}
		$totalcaja = $pa[0]["totalpago"];		
		
		########### HAGO LA CONSULTA DE TOTAL DE RETIRO EFECTIVO POR CAJAS EN LA FECHA ACTUAL #############
		$sql3 = "select sum(cantretiro) as cantretiro from retiroefectivo where codcaja = ? and DATE_FORMAT(fecharetiro,'%Y-%m-%d') = '".date('Y-m-d')."'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array($_POST["codcaja"]));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch())
			{
				$sa[] = $row;
			}
		$totalretiro = $sa[0]["cantretiro"];
		
		$retiro = $totalcaja - $totalretiro;
		
		if($_POST["cantretiro"]<1)
		{
		echo "2";
		exit;
		
		}
		elseif($totalcaja==0)
		{
		echo "3";
		exit;
		}
		elseif($_POST["cantretiro"] < $retiro)
		{
		$query = " insert into retiroefectivo values (null, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $motivoretiro);
		$stmt->bindParam(2, $cantretiro);
		$stmt->bindParam(3, $fecharetiro);
		$stmt->bindParam(4, $codcaja);
		$stmt->bindParam(5, $codigo);
			
		$motivoretiro = strip_tags($_POST["motivoretiro"]);
		$cantretiro = strip_tags($_POST["cantretiro"]);
		$fecharetiro = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharetiro'])));
		$codcaja = strip_tags($_POST["codcaja"]);
		$codigo = strip_tags($_SESSION["codigo"]);
		$stmt->execute();
			
		   echo "<div class='alert alert-success'>";
		   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
           echo "<span class='fa fa-check-square-o'></span> EL RETIRO DE EFECTIVO EN CAJA DE VENTA FUE REGISTRADO EXITOSAMENTE </div>";
           echo "</div>";		
		   exit;
		}
	else
		{
			echo "4";
			exit;
		}
	}
		
################################################ FIN DE FUNCION PARA REGISTRAR RETIRO DE EFECTIVO ################################################

################################################ FUNCION PARA LISTAR RETIRO DE EFECTIVO ################################################

public function ListarRetiro()
	{
		self::SetNames();
		$sql = " select * from retiroefectivo INNER JOIN usuarios ON retiroefectivo.codigo = usuarios.codigo INNER JOIN cajas ON retiroefectivo.codcaja = cajas.codcaja";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}

################################################ FIN DE FUNCION PARA LISTAR RETIRO DE EFECTIVO ################################################

################################################ FUNCION PARA MOSTRAR RETIRO DE EFECTIVO  ################################################

public function RetiroPorId()
	{
		self::SetNames();
		$sql = " select * from retiroefectivo where codretiro = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codretiro"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR RETIRO DE EFECTIVO ################################################


################################################ FUNCION PARA ACTUALIZAR CAJAS DE VENTAS ################################################

public function ActualizarRetiro()
	{
		if(empty($_POST["codretiro"]))
		{
			echo "1";
		    exit;
		}
		
		########### HAGO LA CONSULTA DE TOTAL DE VENTAS POR CAJAS EN LA FECHA ACTUAL #############
		$sql1 = "select sum(totalpago) as totalpago from ventas where codcaja = ? and DATE_FORMAT(fechaventa,'%Y-%m-%d') = '".date('Y-m-d')."'";
		$stmt = $this->dbh->prepare($sql1);
		$stmt->execute( array($_POST["codcaja"]));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch())
			{
				$pa[] = $row;
			}
		$totalcaja = $pa[0]["totalpago"];
		
		########### HAGO LA CONSULTA DE PARA OBTENER EL MONTO DE RETIRO DEL CODIGO ACTUALIZADO #############
		$sql2 = "select cantretiro from retiroefectivo where codretiro = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($_POST["codretiro"]));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$sa[] = $row;
			}
		$retiroactual = $sa[0]["cantretiro"];
		
		########### HAGO LA CONSULTA DE TOTAL DE RETIRO EFECTIVO POR CAJAS EN LA FECHA ACTUAL #############
		$sql3 = "select sum(cantretiro) as cantretiro from retiroefectivo where codcaja = ? and DATE_FORMAT(fecharetiro,'%Y-%m-%d') = '".date('Y-m-d')."'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array($_POST["codcaja"]));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$sa[] = $row;
			}
		$totalretiro = $sa[0]["cantretiro"] - $retiroactual;
		
		$retiro = $totalcaja - $totalretiro;
		
		if($_POST["cantretiro"]<1)
		{
		echo "2";
		exit;
		}
		elseif($totalcaja==0)
		{
		echo "3";
		exit;
		}
		elseif($_POST["cantretiro"] < $retiro)
		{
		$sql = " update retiroefectivo set "
		      ." motivoretiro = ?, "
			  ." cantretiro = ?, "
			  ." codcaja = ? "
			  ." where "
			  ." codretiro = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $motivoretiro);
		$stmt->bindParam(2, $cantretiro);
		$stmt->bindParam(3, $codcaja);
		$stmt->bindParam(4, $codretiro);
			
		$motivoretiro = strip_tags($_POST["motivoretiro"]);
		$cantretiro = strip_tags($_POST["cantretiro"]);
		$codcaja = strip_tags($_POST["codcaja"]);
		$codretiro = strip_tags($_POST["codretiro"]);
		$stmt->execute();
		
		echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL RETIRO DE EFECTIVO EN CAJA DE VENTA FUE ACTUALIZADA EXITOSAMENTE </div>"; // wrong details
		exit;
	}
	else
		{
			echo "4";
			exit;
		}
	}
################################################ FIN DE FUNCION PARA ACTUALIZAR CAJAS DE VENTAS ################################################

################################################ FUNCION PARA ELIMINAR RETIRO DE EFECTIVO EN CAJAS DE VENTAS ################################################

public function EliminarRetiro()
	{
		
		########### HAGO LA CONSULTA DE FECHA DE REGISTRO DE EFECTIVO DE CAJAS #############
		$sql3 = "select fecharetiro from retiroefectivo where codretiro = ? ";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array(base64_decode($_GET["codretiro"])));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$sa[] = $row;
			}
		$fecharetiro = $sa[0]["fecharetiro"];
		
		if(date("Y-m-d", strtotime($fecharetiro)) == date("Y-m-d")) {
		
		$sql = " delete from retiroefectivo where codretiro = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codretiro);
		$codretiro = base64_decode($_GET["codretiro"]);
		$stmt->execute();
		
		header("Location: retiro?mesage=1");
		exit;
		   
		   }else {
		   
			header("Location: retiro?mesage=2");
			exit;
		  }
			
	} 

################################################ FIN DE FUNCION PARA ELIMINAR RETIRO DE EFECTIVO EN CAJAS DE VENTAS ################################################

############################################################## FIN DE  CLASE RETIRO DE EFECTIVO ###############################################################





























##################################################################  CLASE PRODUCTOS EN ALMACEN   ############################################################

################################################  FUNCION PARA PARA CARGA MASIVA DE PRODUCTOS ################################################
	public function CargarProductos()
	{
		self::SetNames();
		if(empty($_FILES["sel_file"]))
		{
			echo "1";
			exit;
		}
        //Aquí es donde seleccionamos nuestro csv
         $fname = $_FILES['sel_file']['name'];
         //echo 'Cargando nombre del archivo: '.$fname.' ';
         $chk_ext = explode(".",$fname);
         
        if(strtolower(end($chk_ext)) == "csv")
        {
        //si es correcto, entonces damos permisos de lectura para subir
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
               //Insertamos los datos con los valores...
			   
		$query = " insert into productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?; ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $data[1]);
		$stmt->bindParam(2, $data[2]);
		$stmt->bindParam(3, $data[3]);
		$stmt->bindParam(4, $data[4]);
		$stmt->bindParam(5, $data[5]);
		$stmt->bindParam(6, $data[6]);
		$stmt->bindParam(7, $data[7]);
		$stmt->bindParam(8, $data[8]);
		$stmt->bindParam(9, $data[9]);
		$stmt->bindParam(10, $data[10]);
		$stmt->execute();
				
        }
           //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
           fclose($handle);
	        
			echo "<div class='alert alert-success'>";
		    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> LA CARGA DE PRODUCTOS FUE REALIZADA EXITOSAMENTE </div>";
            echo "</div>";		
		    exit;
             
         }
         else
         {
    //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
         echo "2";
		 exit;
      }  
}
################################################ FIN DE FUNCION PARA CARGA MASIVA DE PRODUCTOS ################################################

######################################  FUNCION PARA REGISTRAR PRODUCTOS  ######################################
	public function RegistrarProductos()
	{
		self::SetNames();
		if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codcategoria"]))
		{
			echo "1";
			exit;
		}
		
		$sql = " select codproducto from productos where codproducto = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codproducto"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		##################### REGISTRAMOS LOS NUEVOS PRODUCTOS ####################################
		$query = " insert into productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
	    $stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $producto);
		$stmt->bindParam(3, $codcategoria);
		$stmt->bindParam(4, $preciocompra);
		$stmt->bindParam(5, $precioventa);
		$stmt->bindParam(6, $existencia);
		$stmt->bindParam(7, $stockminimo);
		$stmt->bindParam(8, $codigobarra);
		$stmt->bindParam(9, $ubicacion);
		$stmt->bindParam(10, $ivaproducto);
		$stmt->bindParam(11, $statusproducto);
		
		$codproducto = strip_tags($_POST["codproducto"]);
		$producto = strip_tags($_POST["producto"]);
		$codcategoria = strip_tags($_POST["codcategoria"]);
		$preciocompra = strip_tags($_POST["preciocompra"]);
		$precioventa = strip_tags($_POST["precioventa"]);
		$existencia = strip_tags($_POST["existencia"]);
		$stockminimo = strip_tags($_POST["stockminimo"]);
		$codigobarra = strip_tags($_POST["codproducto"]);
		$ubicacion = strip_tags($_POST["ubicacion"]);
		$ivaproducto = strip_tags($_POST["ivaproducto"]);
		$statusproducto = strip_tags($_POST["statusproducto"]);
		$stmt->execute();
		##################### REGISTRAMOS LOS NUEVOS PRODUCTOS ####################################
		
		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################################
		$query = " insert into kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproceso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $stockactual);
		$stmt->bindParam(8, $preciounit);
		$stmt->bindParam(9, $costototal);
		$stmt->bindParam(10, $documento);
		$stmt->bindParam(11, $fechakardex);
		
		$codproceso = strip_tags($_POST['codproceso']);
		$codresponsable = strip_tags("0");
		$codproducto = strip_tags($_POST['codproducto']);
		$movimiento = strip_tags("ENTRADAS");
		$entradas = strip_tags($_POST['existencia']);
		$salidas = strip_tags("0");
		$stockactual = strip_tags($_POST['existencia']);
		$preciounit = strip_tags($_POST['precioventa']);
		$costototal = strip_tags($_POST['precioventa'] * $_POST['existencia']);
		$documento = strip_tags("INVENTARIO INICIAL");
		$fechakardex = strip_tags(date("Y-m-d"));
		$stmt->execute();
		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################################
		
		##################  SUBIR FOTO DE PRODUCTO ######################################
         //datos del arhivo  
         if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
		 if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
		 if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; } 
         //compruebo si las características del archivo son las que deseo  
		 if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
		 {  
		 if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$codproducto.".jpg"))
		 { 
		 ## se puede dar un aviso
		 } 
		 ## se puede dar otro aviso 
		 }
		##################  FINALIZA SUBIR FOTO DE PRODUCTO ######################################
		
		    echo "<div class='alert alert-success'>";
		    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL PRODUCTO FUE REGISTRADO EXITOSAMENTE </div>";
            echo "</div>";		
		    exit;
		}
		else
		{
			echo "2";
			exit;
		}
	}
######################################  FIN DE FUNCION PARA REGISTRAR PRODUCTOS ######################################

###################################### FUNCION PARA LISTAR PRODUCTOS EN ALMACEN ######################################
	public function ListarProductos()
	{
		self::SetNames();
        $sql = " select * from productos INNER JOIN categorias ON productos.codcategoria = categorias.codcategoria";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
######################################  FIN DE FUNCION PARA LISTAR PRODUCTOS EN ALMACEN  ######################################

######################################  FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS DE PRODUCTOS POR FECHAS Y CAJAS ######################################
	    public function ListarProductosVendidos() 
	       {
		self::SetNames();
		$sql ="SELECT 
  productos.codproducto, productos.producto, productos.codcategoria, productos.precioventa, productos.existencia, productos.stockminimo, categorias.nomcategoria, SUM(detalleventas.cantventa) as cantidad 
FROM
 (productos LEFT OUTER JOIN detalleventas ON productos.codproducto=detalleventas.codproducto) LEFT OUTER JOIN categorias ON 
 categorias.codcategoria=productos.codcategoria WHERE detalleventas.codproducto is not null GROUP BY productos.codproducto";
		
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS DE PRODUCTOS POR FECHAS Y CAJAS ######################################


###################################### FUNCION PARA LISTAR PRODUCTOS EN STOCK MINIMO ######################################
	public function ListarProductosStockMinimo()
	{
		self::SetNames();
		 $sql = " select * from productos INNER JOIN categorias ON productos.codcategoria = categorias.codcategoria WHERE productos.existencia <= productos.stockminimo";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
######################################  FIN DE FUNCION PARA LISTAR PRODUCTOS EN STOCK MINIMO  ######################################

######################################  FUNCION PARA LISTAR KARDEX DE PRODUCTOS ######################################
	    public function ListarKardexProductos() 
	       {
		self::SetNames();
			$sql ="SELECT productos.producto, categorias.nomcategoria, kardex.codproducto, kardex.codresponsable, kardex.movimiento, kardex.entradas, kardex.salidas, kardex.stockactual, kardex.preciounit, kardex.costototal, kardex.documento, kardex.fechakardex, proveedores.nomproveedor as proveedor, clientes.nomcliente as clientes FROM (productos LEFT JOIN kardex ON productos.codproducto=kardex.codproducto) LEFT JOIN categorias ON categorias.codcategoria=productos.codcategoria LEFT JOIN proveedores ON proveedores.codproveedor=kardex.codresponsable LEFT JOIN clientes ON clientes.codcliente=kardex.codresponsable";
			foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
###################################### FIN DE FUNCION PARA LISTAR KARDEX DE PRODUCTOS ######################################

################################################ FUNCION PARA MOSTRAR PRODUCTOS EN ALMACEN POR CODIGO ################################################

public function ProductosPorId()
	{
		self::SetNames();
		$sql = " select * from productos INNER JOIN categorias ON productos.codcategoria = categorias.codcategoria WHERE productos.codalmacen = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codalmacen"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR PRODUCTOS EN ALMACEN POR CODIGO ################################################

################################################ FUNCION PARA MOSTRAR DETALLES DE PRODUCTO ################################################

public function DetalleProductosPorId()
	{
		self::SetNames();
		$sql = " select * from productos INNER JOIN categorias ON productos.codcategoria = categorias.codcategoria WHERE productos.codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codproducto"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE PRODUCTO ################################################

################################################ FUNCION PARA MOSTRAR DETALLES DE KARDEX DE PRODUCTO ################################################
public function VerDetallesKardexProducto()
	{
		self::SetNames();
		$sql ="SELECT kardex.codproducto, kardex.codresponsable, kardex.movimiento, kardex.entradas, kardex.salidas, kardex.stockactual, kardex.preciounit, kardex.costototal, kardex.documento, kardex.fechakardex, proveedores.nomproveedor as proveedor, clientes.nomcliente as clientes FROM (productos LEFT JOIN kardex ON productos.codproducto=kardex.codproducto) LEFT JOIN proveedores ON proveedores.codproveedor=kardex.codresponsable LEFT JOIN clientes ON clientes.codcliente=kardex.codresponsable WHERE kardex.codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codproducto"])) );
		$num = $stmt->rowCount();
		
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
################################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE KARDEX DE PRODUCTO ################################################

################################################  FUNCION PARA ACTUALIZAR COMPRAS DE PRODUCTOS ################################################
	public function ActualizarProductos()
	{
		if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codcategoria"]))
		{
			echo "1";
		    exit;
		}
		
		self::SetNames();
		$sql = " update productos set "
			  ." codproducto = ?, "
			  ." producto = ?, "
			  ." codcategoria = ?, "
			  ." existencia = ?, "
		      ." precioventa = ?, "
		      ." codcategoria = ?, "
			  ." stockminimo = ?, "
			  ." codigobarra = ?, "
			  ." ubicacion = ?, "
			  ." ivaproducto = ?, "
			  ." statusproducto = ? "
			  ." where "
			  ." codalmacen = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
	    $stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $producto);
		$stmt->bindParam(3, $codcategoria);
		$stmt->bindParam(4, $existencia);
		$stmt->bindParam(5, $precioventa);
		$stmt->bindParam(6, $codcategoria);
		$stmt->bindParam(7, $stockminimo);
		$stmt->bindParam(8, $codigobarra);
		$stmt->bindParam(9, $ubicacion);
		$stmt->bindParam(10, $ivaproducto);
		$stmt->bindParam(11, $statusproducto);
		$stmt->bindParam(12, $codalmacen);
		
		$codproducto = strip_tags($_POST["codproducto"]);
		$producto = strip_tags($_POST["producto"]);
		$codcategoria = strip_tags($_POST["codcategoria"]);
		$existencia = strip_tags($_POST["existencia"]);
		$precioventa = strip_tags($_POST["precioventa"]);
		$codcategoria = strip_tags($_POST["codcategoria"]);
		$stockminimo = strip_tags($_POST["stockminimo"]);
		$codigobarra = strip_tags($_POST["codproducto"]);
		$ubicacion = strip_tags($_POST["ubicacion"]);
		$ivaproducto = strip_tags($_POST["ivaproducto"]);
		$statusproducto = strip_tags($_POST["statusproducto"]);
		$codalmacen = strip_tags($_POST["codalmacen"]);
		$stmt->execute();
		
		###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ############################		
		$sql2 = " update kardex set "
		      ." entradas = ?, "
			  ." preciounit = ?, "
			  ." costototal = ? "
			  ." where "
			  ." codproceso = ? and codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $entradas);
		$stmt->bindParam(2, $preciounit);
		$stmt->bindParam(3, $costototal);
		$stmt->bindParam(4, $codproceso);
		$stmt->bindParam(5, $codproducto);
		
		$entradas = strip_tags($_POST["existencia"]);
		$preciounit = strip_tags($_POST["precioventa"]);
		$costototal = strip_tags($_POST["existencia"] * $_POST["precioventa"]);
		$codproceso = strip_tags("001");
		$codproducto = strip_tags($_POST["codproducto"]);
		$stmt->execute();
		###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ############################
		
         ##################  SUBIR FOTO DE PRODUCTO ######################################
         //datos del arhivo  
         if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
		 if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
		 if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; }  
         //compruebo si las características del archivo son las que deseo  
if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
{  
if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$codproducto.".jpg"))
{ 
## se puede dar un aviso
} 
## se puede dar otro aviso 
}
##################  FINALIZA SUBIR FOTO DE PRODUCTO ######################################

		echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL PRODUCTO FUE ACTUALIZADO EXITOSAMENTE </div>"; // wrong details
		exit;
	}
################################################ FIN DE FUNCION PARA ACTUALIZAR COMPRAS DE PRODUCTOS ################################################

################################################  FUNCION PARA ELIMINAR PRODUCTOS EN ALMACEN ################################################
	public function EliminarProductos()
	{
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " select codproducto from detalleventas where codproducto = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codproducto"])) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		
		$sql = " delete from productos where codproducto = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproducto);
		$codproducto = base64_decode($_GET["codproducto"]);
		$stmt->execute();
		
		$sql = " delete from kardex where codproducto = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproducto);
		$codproducto = base64_decode($_GET["codproducto"]);
		$stmt->execute();
		
		header("Location: productos?mesage=1");
		exit;
		   
		   }else {
		   
			header("Location: productos?mesage=2");
			exit;
		  }
			
	} else {
		
		header("Location: productos?mesage=3");
		exit;
	    }	
	}
################################################  FUNCION PARA ELIMINAR PRODUCTOS EN ALMACEN ################################################

######################################  FUNCION PARA BUSQUEDA DE KARDEX POR PRODUCTOS ######################################
	    public function BuscarKardexProducto() 
	       {
		self::SetNames();
		$sql ="SELECT * FROM (productos LEFT JOIN kardex ON productos.codproducto=kardex.codproducto) LEFT JOIN categorias ON productos.codcategoria=categorias.codcategoria WHERE kardex.codproducto = ?";
        $stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codproducto"]) );
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN MOVIMIENTOS EN KARDEX PARA EL PRODUCTO INGRESADO</div></center>";
		exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE KARDEX POR PRODUCTOS ######################################

################################################################## FIN DE CLASE PRODUCTOS EN ALMACEN ############################################################















































##############################################################  CLASE ITEMS PARA SERVICIOS ###############################################################

################################################  FUNCION PARA REGISTRAR ITEMS PARA SERVICIOS ################################################
	public function RegistrarItems()
	{
		self::SetNames();
		if(empty($_POST["coditems"]) or empty($_POST["nombreitems"]) or empty($_POST["costoitems"]))
		{
			echo "1";
			exit;
		}
		$sql = " select coditems from items where coditems = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["coditems"]) );
		$num = $stmt->rowCount();
		if($num > 0)
		{
		echo "2";
		exit;
		}
		else
		{
		$sql = " select nombreitems from items where nombreitems = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["nombreitems"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " insert into items values (null, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $coditems);
			$stmt->bindParam(2, $nombreitems);
			$stmt->bindParam(3, $costoitems);
			$stmt->bindParam(4, $statusitems);
			
			$coditems = strip_tags($_POST["coditems"]);
			$nombreitems = strip_tags($_POST["nombreitems"]);
			$costoitems = strip_tags($_POST["costoitems"]);
			$statusitems = strip_tags($_POST["statusitems"]);
			$stmt->execute();
			
			echo "<div class='alert alert-success'>";
		    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL ITEMS PARA SERVICIOS FUE REGISTRADO EXITOSAMENTE </div>";
            echo "</div>";		
		    exit;
		}
		else
		{
			echo "3";
			exit;
		}
	}
} 
################################################ FIN DE FUNCION PARA REGISTRAR ITEMS PARA SERVICIOS ################################################


################################################ FUNCION PARA LISTAR ITEMS PARA SERVICIOS ################################################

public function ListarItems()
	{
		self::SetNames();
		$sql = " select * from items";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}

################################################ FIN DE FUNCION PARA LISTAR ITEMS PARA SERVICIOS ################################################


################################################ FUNCION PARA MOSTRAR ITEMS PARA SERVICIOS POR CODIGO ################################################

public function ItemsPorId()
	{
		self::SetNames();
		$sql = " select * from items where iditems = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["iditems"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR ITEMS PARA SERVICIOS POR CODIGO ################################################


################################################ FUNCION PARA ACTUALIZAR ITEMS PARA SERVICIOS ################################################

public function ActualizarItems()
	{
		self::SetNames();
		if(empty($_POST["coditems"]) or empty($_POST["nombreitems"]) or empty($_POST["costoitems"]))
		{
			echo "1";
		    exit;
		}
		$sql = " select coditems from items where iditems != ? and coditems = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["iditems"], $_POST["coditems"]) );
		$num = $stmt->rowCount();
		if($num > 0)
		{
		echo "2";
		exit;
		}
		else
		{
		$sql = " select nombreitems from items where iditems != ? and nombreitems = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["iditems"], $_POST["nombreitems"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		$sql = " update items set "
		      ." coditems = ?, "
			  ." nombreitems = ?, "
			  ." costoitems = ?, "
			  ." statusitems = ? "
			  ." where "
			  ." iditems = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $coditems);
		$stmt->bindParam(2, $nombreitems);
		$stmt->bindParam(3, $costoitems);
		$stmt->bindParam(4, $statusitems);
		$stmt->bindParam(5, $iditems);
			
		$coditems = strip_tags($_POST["coditems"]);
		$nombreitems = strip_tags($_POST["nombreitems"]);
		$costoitems = strip_tags($_POST["costoitems"]);
		$statusitems = strip_tags($_POST["statusitems"]);
		$iditems = strip_tags($_POST["iditems"]);
		$stmt->execute();
		
		echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL ITEMS PARA SERVICIOS FUE ACTUALIZADO EXITOSAMENTE </div>"; // wrong details
		exit;
	}
		else
		{
			echo "3";
			exit;
		}
	}
} 
################################################ FIN DE FUNCION PARA ACTUALIZAR ITEMS PARA SERVICIOS ################################################


################################################ FUNCION PARA ELIMINAR ITEMS PARA SERVICIOS ################################################

public function EliminarItems()
	{

		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " select iditems from detalleservicios where iditems = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["iditems"])) );
		$num = $stmt->rowCount();
		if($num == 0)
		{

		$sql = " delete from items where iditems = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$iditems);
		$iditems = base64_decode($_GET["iditems"]);
		$stmt->execute();
		
		header("Location: items?mesage=1");
		exit;
		   
		   }else {
		   
			header("Location: items?mesage=2");
			exit;
		  }
			
	} else {
		
		header("Location: items?mesage=3");
		exit;
	    }	
	}
################################################ FIN DE FUNCION PARA ELIMINAR ITEMS PARA SERVICIOS ################################################

############################################################  FIN DE CLASE ITEMS PARA SERVICIOS  #############################################################

































##################################################################  CLASE CLIENTES   ######################################################################

##################################  FUNCION PARA REGISTRAR CLIENTES  #############################
	public function RegistrarClientes()
	{
		self::SetNames();
		if(empty($_POST["cedcliente"]) or empty($_POST["nomcliente"]))
		{
			echo "1";
			exit;
		}
		
		$sql = " select cedcliente from clientes where cedcliente = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["cedcliente"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		$query = " insert into clientes values (null, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cedcliente);
		$stmt->bindParam(2, $nomcliente);
		$stmt->bindParam(3, $direccliente);
		$stmt->bindParam(4, $tlfcliente);
		$stmt->bindParam(5, $emailcliente);
			
		$cedcliente = strip_tags($_POST["cedcliente"]);
		$nomcliente = strip_tags($_POST["nomcliente"]);
		$direccliente = strip_tags($_POST["direccliente"]);
		$tlfcliente = strip_tags($_POST["tlfcliente"]);
		$emailcliente = strip_tags($_POST["emailcliente"]);
		$stmt->execute();

			echo "<div class='alert alert-success'>";
		    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL CLIENTE FUE REGISTRADO EXITOSAMENTE </div>";
            echo "</div>";		
		    exit;
		}
		else
		{
			echo "2";
			exit;
		}
	}
##################################  FUNCION PARA REGISTRAR CLIENTES  #############################


##################################   FUNCION PARA LISTAR CLIENTES  ################################## 
	public function ListarClientes()
	{
		self::SetNames();
		$sql = " select * from clientes ";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
##################################   FIN DE FUNCION PARA LISTAR CLIENTES  ################################## 


#################################################### FUNCION PARA SELECCIONAR CLIENTE ##################################################
	public function ClientesPorId()
	{
		self::SetNames();
		$sql = " select * from clientes where codcliente = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codcliente"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################### FIN DE FUNCION PARA SELECCIONAR CLIENTES ##################################################
	
###################################################  FUNCION PARA ACTUALIZAR CLIENTES  ###################################################
	public function ActualizarClientes()
	{
		self::SetNames();
		if(empty($_POST["cedcliente"]) or empty($_POST["nomcliente"]))
		{
		echo "1";
		exit;
		}

		$sql = " select cedcliente from clientes where codcliente != ? and cedcliente = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codcliente"], $_POST["cedcliente"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		
		$sql = " update clientes set "
			  ." cedcliente = ?, "
			  ." nomcliente = ?, "
			  ." direccliente = ?, "
			  ." tlfcliente = ?, "
			  ." emailcliente = ? "
			  ." where "
			  ." codcliente = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $cedcliente);
		$stmt->bindParam(2, $nomcliente);
		$stmt->bindParam(3, $direccliente);
		$stmt->bindParam(4, $tlfcliente);
		$stmt->bindParam(5, $emailcliente);
		$stmt->bindParam(6, $codcliente);
			
		$cedcliente = strip_tags($_POST["cedcliente"]);
		$nomcliente = strip_tags($_POST["nomcliente"]);
		$direccliente = strip_tags($_POST["direccliente"]);
		$tlfcliente = strip_tags($_POST["tlfcliente"]);
		$emailcliente = strip_tags($_POST["emailcliente"]);
		$codcliente = strip_tags($_POST["codcliente"]);
		$stmt->execute();
		
		echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL CLIENTE FUE ACTUALIZADO EXITOSAMENTE </div>"; // wrong details
		exit;
	}
	else
		{
			echo "3";
			exit;
		}
	}
################################################## FIN DE FUNCION PARA ACTUALIZAR CLIENTES  ###################################################

###################################################  FUNCION PARA ELIMINAR CLIENTES  #######################################################
	public function EliminarClientes()
	{
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " select codcliente from ventas where codcliente = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codcliente"])) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		
		$sql = " delete from clientes where codcliente = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcliente);
		$codcliente = base64_decode($_GET["codcliente"]);
		$stmt->execute();
		
		header("Location: clientes?mesage=1");
		exit;
		   
		  }else {
		   
			header("Location: clientes?mesage=2");
			exit;
		  } 
			
		} else {
		
		header("Location: clientes?mesage=3");
		exit;
	    }	
	}
######################################################  FUNCION PARA ELIMINAR CLIENTES  ########################################################

################################################################  FIN DE CLASE CLIENTES   ##################################################################























##################################################################  CLASE PROVEEDORES   ######################################################################

##################################  FUNCION PARA REGISTRAR PROVEEDORES  #############################
	public function RegistrarProveedores()
	{
		self::SetNames();
		if(empty($_POST["ritproveedor"]) or empty($_POST["nomproveedor"]) or empty($_POST["direcproveedor"]) or empty($_POST["tlfproveedor"]))
		{
			echo "1";
			exit;
		}
		$sql = " select ritproveedor from proveedores where ritproveedor = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["ritproveedor"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		$query = " insert into proveedores values (null, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $ritproveedor);
		$stmt->bindParam(2, $nomproveedor);
		$stmt->bindParam(3, $direcproveedor);
		$stmt->bindParam(4, $tlfproveedor);
		$stmt->bindParam(5, $emailproveedor);
		$stmt->bindParam(6, $contactoproveedor);
			
		$ritproveedor = strip_tags($_POST["ritproveedor"]);
		$nomproveedor = strip_tags($_POST["nomproveedor"]);
		$direcproveedor = strip_tags($_POST["direcproveedor"]);
		$tlfproveedor = strip_tags($_POST["tlfproveedor"]);
		$emailproveedor = strip_tags($_POST["emailproveedor"]);
		$contactoproveedor = strip_tags($_POST["contactoproveedor"]);
		$stmt->execute();

			echo "<div class='alert alert-success'>";
		    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<span class='fa fa-check-square-o'></span> EL PROVEEDOR FUE REGISTRADO EXITOSAMENTE </div>";
            echo "</div>";		
		    exit;
		}
		else
		{
			echo "3";
			exit;
		}
	}
##################################  FUNCION PARA REGISTRAR PROVEEDORES  #############################


##################################   FUNCION PARA LISTAR PROVEEDORES  ################################## 
	public function ListarProveedores()
	{
		self::SetNames();
		$sql = " select * from proveedores ";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
################################## FIN DE FUNCION PARA LISTAR PROVEEDORES  ################################## 

#################################################### FUNCION PARA SELECCIONAR PROVEEDORES ##################################################
	public function ProveedoresPorId()
	{
		self::SetNames();
		$sql = " select * from proveedores where codproveedor = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codproveedor"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################### FIN DE FUNCION PARA SELECCIONAR PROVEEDORES ##################################################
	
#################################################### FUNCION PARA SELECCIONAR PROVEEDORES #2 ##################################################
	public function ProveedorPorId()
	{
		self::SetNames();
		$sql = " select * from proveedores where codproveedor = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codproveedor"]) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################### FIN DE FUNCION PARA SELECCIONAR PROVEEDORES #2 ##################################################
	

###################################################  FUNCION PARA ACTUALIZAR PROVEEDORES  ###################################################
	public function ActualizarProveedores()
	{
		self::SetNames();
		if(empty($_POST["ritproveedor"]) or empty($_POST["nomproveedor"]) or empty($_POST["direcproveedor"]) or empty($_POST["tlfproveedor"]))
		{
		echo "1";
		exit;
		}

		$sql = " select * from proveedores where codproveedor != ? and ritproveedor = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_POST["codproveedor"], $_POST["ritproveedor"]) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		
		$sql = " update proveedores set "
			  ." ritproveedor = ?, "
			  ." nomproveedor = ?, "
			  ." direcproveedor = ?, "
			  ." tlfproveedor = ?, "
			  ." emailproveedor = ?, "
			  ." contactoproveedor = ? "
			  ." where "
			  ." codproveedor = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $ritproveedor);
		$stmt->bindParam(2, $nomproveedor);
		$stmt->bindParam(3, $direcproveedor);
		$stmt->bindParam(4, $tlfproveedor);
		$stmt->bindParam(5, $emailproveedor);
		$stmt->bindParam(6, $contactoproveedor);
		$stmt->bindParam(7, $codproveedor);
			
		$ritproveedor = strip_tags($_POST["ritproveedor"]);
		$nomproveedor = strip_tags($_POST["nomproveedor"]);
		$direcproveedor = strip_tags($_POST["direcproveedor"]);
		$tlfproveedor = strip_tags($_POST["tlfproveedor"]);
		$emailproveedor = strip_tags($_POST["emailproveedor"]);
		$contactoproveedor = strip_tags($_POST["contactoproveedor"]);
		$codproveedor = strip_tags($_POST["codproveedor"]);
		$stmt->execute();
		
		echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL PROVEEDOR FUE ACTUALIZADO EXITOSAMENTE </div>"; // wrong details
		exit;
	}
	else
		{
			echo "3";
			exit;
		}
	}
################################################## FIN DE FUNCION PARA ACTUALIZAR PROVEEDORES  ###################################################

###################################################  FUNCION PARA ELIMINAR PROVEEDORES  #######################################################
	public function EliminarProveedores()
	{
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " select codproveedor from compras where codproveedor = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codproveedor"])) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		
		$sql = " delete from proveedores where codproveedor = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproveedor);
		$codproveedor = base64_decode($_GET["codproveedor"]);
		$stmt->execute();
		
		header("Location: proveedores?mesage=1");
		exit;
		   
		  }else {
		   
			header("Location: proveedores?mesage=2");
			exit;
		  } 
			
		} else {
		
		header("Location: proveedores?mesage=3");
		exit;
	    }	
	}
######################################################  FUNCION PARA ELIMINAR PROVEEDORES  ########################################################

################################################################  FIN DE CLASE PROVEEDORES   ##################################################################








































##################################################################  CLASE PEDIDOS DE PRODUCTOS   ############################################################

###################################### FUNCION PARA SELECCIONAR ULTIMO CODIGO DE FACTURA DE PEDIDOS DE PRODUCTOS ######################################
	public function CodigoPedidos()
	{
    self::SetNames();
    $sql = " select codpedido from pedidos where codigo = '".$_SESSION["codigo"]."' and DATE_FORMAT(fechapedido,'%Y-%m-%d') = '".date("Y-m-d")."' order by codpedido desc limit 1";
	foreach ($this->dbh->query($sql) as $row){

     $fecha= date("Y-m-d"); 
     $year= date("Y");
     $mes= date("m");
     $day= date("d"); 
     $codpedido["codpedido"]=$row["codpedido"];
	   
      }
          if(empty($codpedido["codpedido"]))
           {
			  echo $factura = date("Y").'-'.date("m").''.date("d").'-'.'P0001';
     } else
           {
               $num     = substr($codpedido["codpedido"] , 11);
               $dig     = $num + 1;
               $cod = str_pad($dig, 4, "0", STR_PAD_LEFT);
			   echo $factura = $year.'-'.$mes.''.$day.'-P'.$cod;

         }
				 }
###################################### FIN DE FUNCION PARA SELECCIONAR ULTIMO CODIGO DE FACTURA DE PEDIDOS DE PRODUCTOS ######################################

######################################  FUNCION PARA REGISTRAR PEDIDOS DE PRODUCTOS  ######################################
	public function RegistrarPedidos()
	{
		self::SetNames();
		if(empty($_POST["codpedido"]) or empty($_POST["codproveedor"]))
		{
			echo "1";
			exit;
		}
		
		if(empty($_SESSION["CarritoPedidos"]))
		{
			echo "2";
			exit;
			
		} else {
		
		$query = " insert into pedidos values (?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpedido);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $fechapedido);
		$stmt->bindParam(4, $codigo);
			
		$codpedido = strip_tags($_POST['codpedido']);
		$codproveedor = strip_tags($_POST['codproveedor']);
		$fechapedido = strip_tags($_POST['fecharegistro']);
		$codigo = strip_tags($_SESSION['codigo']);
		$stmt->execute();
		
		$pedidos = $_SESSION["CarritoPedidos"];
		for($i=0;$i<count($pedidos);$i++){
		
		$query = " insert into detallepedidos values (null, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpedido);
	    $stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $producto);
		$stmt->bindParam(4, $codcategoria);
		$stmt->bindParam(5, $cantidad);
		$stmt->bindParam(6, $fechadetallepedido);
			
		$codpedido = strip_tags($_POST['codpedido']);
		$codproducto = strip_tags($pedidos[$i]['txtCodigo']);
		$producto = strip_tags($pedidos[$i]['descripcion']);
		$cantidad = strip_tags($pedidos[$i]['cantidad']);
		$codcategoria = strip_tags($pedidos[$i]['tipo']);
		$fechadetallepedido = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$stmt->execute();
		
		$sql = " delete from detallepedidos where codpedido = ? and cantpedido = '0'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$codpedido = $_POST["codpedido"];
		$stmt->execute();
		
		}
		###### AQUI DESTRUIMOS TODAS LAS VARIABLES DE SESSION QUE RECIBIMOS EN CARRITO DE PEDIDOS ######
		unset($_SESSION["CarritoPedidos"]);
		
		echo "<div class='alert alert-success'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<span class='fa fa-check-square-o'></span> EL PEDIDO DE PRODUCTOS AL PROVEEDOR FUE REGISTRADA EXITOSAMENTE <a href='reportepdf.php?codpedido=".base64_encode($codpedido)."&tipo=".base64_encode("PEDIDOS")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black'><strong>IMPRIMIR FACTURA DE PEDIDOS</strong></a></div>";
        echo "</div>";		
		exit;
		}
	}
###################################### FIN DE FUNCION PARA REGISTRAR PEDIDOS DE PRODUCTOS ######################################


###################################### FUNCION PARA LISTAR PEDIDOS DE PRODUCTOS ###################################### 
	public function ListarPedidos()
	{
		self::SetNames();
	    $sql = " select * from pedidos, proveedores, usuarios where pedidos.codproveedor = proveedores.codproveedor and pedidos.codigo = usuarios.codigo";
       foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
###################################### FIN DE FUNCION PARA LISTAR PEDIDOS DE PRODUCTOS ######################################

###################################### FUNCION PARA LISTAR DETALLES DE PEDIDOS DE PRODUCTOS ######################################
	public function ListarDetallesPedidos()
	{
		self::SetNames();
		$sql = " select * from detallepedidos, categorias where detallepedidos.codcategoria = categorias.codcategoria";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
######################################  FIN DE FUNCION PARA LISTAR DETALLES DE PEDIDOS DE PRODUCTOS ######################################


################################################ FUNCION PARA MOSTRAR PEDIDOS DE PRODUCTOS POR CODIGO ################################################
public function PedidosPorId()
	{
		self::SetNames();
		$sql = " select * from pedidos, proveedores, usuarios where pedidos.codpedido = ? and pedidos.codproveedor = proveedores.codproveedor and pedidos.codigo = usuarios.codigo";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codpedido"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR PEDIDOS DE PRODUCTOS POR CODIGO ################################################


################################################ FUNCION PARA MOSTRAR DETALLES DE PEDIDOS POR CODIGO N# 1 ################################################
public function VerDetallesPedidos()
	{
		self::SetNames();
		$sql = " select * from detallepedidos, categorias where detallepedidos.codpedido = ? and detallepedidos.codcategoria = categorias.codcategoria";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(base64_decode($_GET["codpedido"])));
		$stmt->execute();
		$num = $stmt->rowCount();
		
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
################################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE PEDIDOS POR CODIGO N# 1 ################################################

################################################ FUNCION PARA MOSTRAR DETALLES DE PEDIDOS POR CODIGO N# 2 ################################################
public function DetallesPedidosPorId()
	{
		self::SetNames();
		$sql = " select * from detallepedidos, categorias where detallepedidos.coddetallepedido = ? and detallepedidos.codcategoria = categorias.codcategoria";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["coddetallepedido"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE PEDIDOS POR CODIGO N# 2 ################################################

################################################  FUNCION PARA ACTUALIZAR PEDIDOS DE PRODUCTOS ################################################
	public function ActualizarDetallesPedidos()
	{
		if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["cantpedido"]))
		{
			echo "1";
		    exit;
		}
		
		self::SetNames();
		$sql = " update detallepedidos set "
			  ." codproducto = ?, "
			  ." producto = ?, "
			  ." codcategoria = ?, "
			  ." cantpedido = ? "
			  ." where "
			  ." coddetallepedido = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $producto);
		$stmt->bindParam(3, $codcategoria);
		$stmt->bindParam(4, $cantpedido);
		$stmt->bindParam(5, $coddetallepedido);
		
		$codproducto = strip_tags($_POST["codproducto"]);
		$producto = strip_tags($_POST["producto"]);
		$codcategoria = strip_tags($_POST["codcategoria"]);
		$cantpedido = strip_tags($_POST["cantpedido"]);
		$coddetallepedido = strip_tags($_POST["coddetallepedido"]);
		$stmt->execute();
         
		echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL PRODUCTO PARA PEDIDO FUE ACTUALIZADO EXITOSAMENTE </div>"; // wrong details
		exit;
	}
################################################ FIN DE FUNCION PARA ACTUALIZAR PEDIDOS DE PRODUCTOS ################################################


######################################  FUNCION PARA ELIMINAR PEDIDOS DE PRODUCTOS  ######################################
	public function EliminarPedidos()
	{
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " delete from pedidos where codpedido = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$codpedido = base64_decode($_GET["codpedido"]);
		$stmt->execute();
		
		$sql = " delete from detallepedidos where codpedido = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$codpedido = base64_decode($_GET["codpedido"]);
		$stmt->execute();

		    header("Location: pedidos?mesage=1");
			exit;
		}
		else
		{
			header("Location: pedido?mesage=2");
			exit;
		}
	}
######################################  FUNCION PARA ELIMINAR PEDIDOS DE PRODUCTOS ######################################

######################################  FUNCION PARA ELIMINAR DETALLES DE PEDIDOS DE PRODUCTOS  ######################################
	public function EliminarDetallesPedidos()
	{
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " select * from detallepedidos where codpedido = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codpedido"])) );
		$nu = $stmt->rowCount();
		if($nu > 1)
		{
		
		$sql = " delete from detallepedidos where coddetallepedido = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetallepedido);
		$coddetallepedido = base64_decode($_GET["coddetallepedido"]);
		$stmt->execute();

		    header("Location: detallespedidos?mesage=1");
			exit;
		}
		else
		{
		$sql = " delete from pedidos where codpedido = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$codpedido = base64_decode($_GET["codpedido"]);
		$stmt->execute();
		
		$sql = " delete from detallepedidos where codpedido = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$codpedido = base64_decode($_GET["codpedido"]);
		$stmt->execute();
		
		header("Location: detallespedidos?mesage=1");
		exit;
		       }
		}
		else
		{
		
			header("Location: detallespedidos?mesage=2");
			exit;
		}
	}
######################################  FUNCION PARA ELIMINAR DETALLES DE PEDIDOS DE PRODUCTOS ######################################

######################################  FUNCION PARA BUSQUEDA DE REPORTES DE PEDIDOS DE PRODUCTOS POR PROVEEDORES ######################################
	    public function BuscarPedidosReportes() 
	       {
		self::SetNames();
		$sql = "select * from pedidos, usuarios where pedidos.codproveedor = ? and pedidos.codigo = usuarios.codigo";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codproveedor"]) );
		$num = $stmt->rowCount();
		     if($num==0)
		{
		
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN PEDIDOS DE PRODUCTOS PARA EL PROVEEDOR SELECCIONADO</div></center>";
		exit;
		       }
		else
		{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE REPORTES DE PEDIDOS DE PRODUCTOS POR PROVEEDORES ######################################
	
################################################################## FIN DE CLASE PEDIDOS DE PRODUCTOS   ############################################################










































##################################################################  CLASE COMPRAS DE PRODUCTOS   ############################################################

###################################### FUNCION PARA CREAR NUMERO DE COMPRA ######################################
	public function CodigoCompra()
	{
    
	self::SetNames();		
    $sql = " select codcompra from compras order by codcompra desc limit 1";
	foreach ($this->dbh->query($sql) as $row){

     $year= date("Y");
     $mes= date("m");
     $day= date("d"); 
     $codcompra["codcompra"]=$row["codcompra"];
      }
          if(empty($codcompra["codcompra"]))
           {
              echo $nrocompra = date("Y").'-'.date("m").''.date("d").'-'.'E0001';
     }else
           {
               $num     = substr($codcompra["codcompra"] , 11);
               $dig     = $num + 1;
               $codigo = str_pad($dig, 4, "0", STR_PAD_LEFT);
			   echo $nrocompra = $year.'-'.$mes.''.$day.'-E'.$codigo;
         }
				 }
###################################### FIN DE FUNCION PARA CREAR NUMERO DE COMPRA ######################################

###################################### FUNCION PARA CREAR NUMERO DE SERIE ######################################
	public function CodigoSerieC()
	{
    
	self::SetNames();		
    $sql = " select codseriec from compras order by codseriec desc limit 1";
	foreach ($this->dbh->query($sql) as $row){

     $year= date("Y");
     $mes= date("m");
     $day= date("d"); 
     $codseriec["codseriec"]=$row["codseriec"];
      }
          if(empty($codseriec["codseriec"]))
           {
              echo $nroserie = 'E'.date("d").''.date("m").''.date("Y").'-'.'0001';
     }else
           {
               $num     = substr($codseriec["codseriec"] , 10);
               $dig     = $num + 1;
               $codigo = str_pad($dig, 4, "0", STR_PAD_LEFT);
			   echo $nroserie = 'E'.$day.''.$mes.''.$year.'-'.$codigo;
         }
				 }
###################################### FIN DE FUNCION PARA CREAR NUMERO DE SERIE ######################################

###################################### FUNCION PARA CREAR NUMERO DE AUTORIZACION ######################################
	public function CodigoAutorizacionC()
	{
    
	self::SetNames();		
    $sql = " select codautorizacionc from compras order by codautorizacionc desc limit 1";
	foreach ($this->dbh->query($sql) as $row){

     $year= date("Y");
     $mes= date("m");
     $day= date("d"); 
     $codautorizacionc["codautorizacionc"]=$row["codautorizacionc"];
      }
          if(empty($codautorizacionc["codautorizacionc"]))
           {
              echo $nroautorizacion = 'EAHXF-'.date("Y").''.'00001';
     }else
           {
               $num     = substr($codautorizacionc["codautorizacionc"] , 10);
               $dig     = $num + 1;
               $codigo = str_pad($dig, 5, "0", STR_PAD_LEFT);
			   echo $nroautorizacion = 'EAHXF-'.$year.''.$codigo;
         }
				 }
###################################### FIN DE FUNCION PARA CREAR NUMERO DE AUTORIZACION ######################################

###################################### FUNCION PARA CREAR NUMERO DE LOTE ######################################
	public function CodigoLote()
	{
    
	self::SetNames();		
    $sql = " select lote from compras order by lote desc limit 1";
	foreach ($this->dbh->query($sql) as $row){

    $lote["lote"]=$row["lote"];
      }
          if(empty($lote["lote"]))
           {
              echo $nrolote = 'L'.'000001';
     }else
           {
               $num     = substr($lote["lote"] , 1);
               $dig     = $num + 1;
               $codigo = str_pad($dig, 6, "0", STR_PAD_LEFT);
			   echo $nrolote = 'L'.$codigo;
         }
				 }
###################################### FIN DE FUNCION PARA CREAR NUMERO DE LOTE ######################################

######################################  FUNCION PARA REGISTRAR COMPRAS DE PRODUCTOS  ######################################
	public function RegistrarCompras()
	{
		self::SetNames();
		if(empty($_POST["codcompra"]) or empty($_POST["codseriec"]) or empty($_POST["codautorizacionc"]) or empty($_POST["codproveedor"]))
		{
			echo "1";
			exit;
		}
		
		if(empty($_SESSION["CarritoCompras"]))
		{
			echo "2";
			exit;
			
		} else {
		
		$query = " insert into compras values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codseriec);
		$stmt->bindParam(3, $codautorizacionc);
		$stmt->bindParam(4, $lote);
		$stmt->bindParam(5, $codproveedor);
		$stmt->bindParam(6, $subtotalivasic);
		$stmt->bindParam(7, $subtotalivanoc);
		$stmt->bindParam(8, $ivac);
		$stmt->bindParam(9, $totalivac);
		$stmt->bindParam(10, $descuentoc);
		$stmt->bindParam(11, $totaldescuentoc);
		$stmt->bindParam(12, $totalc);
		$stmt->bindParam(13, $tipocompra);
		$stmt->bindParam(14, $formacompra);
		$stmt->bindParam(15, $fechavencecredito);
		$stmt->bindParam(16, $statuscompra);
		$stmt->bindParam(17, $fechacompra);
		$stmt->bindParam(18, $codigo);
	    
		$codcompra = strip_tags($_POST["codcompra"]);
		$codseriec = strip_tags($_POST["codseriec"]);
		$codautorizacionc = strip_tags($_POST["codautorizacionc"]);
		$lote = strip_tags($_POST['lote']);
		$codproveedor = strip_tags($_POST["codproveedor"]);
		$subtotalivasic = strip_tags($_POST["txtsubtotal"]);
		$subtotalivanoc = strip_tags($_POST["txtsubtotal2"]);
		$ivac = strip_tags($_POST["iva"]);
		$totalivac = strip_tags($_POST["txtIva"]);
		$descuentoc = strip_tags($_POST["descuento"]);
		$totaldescuentoc = strip_tags($_POST["txtDescuento"]);
		$totalc = strip_tags($_POST["txtTotal"]);
		$tipocompra = strip_tags($_POST["tipocompra"]);
		if (strip_tags($_POST["tipocompra"]=="CONTADO")) { $formacompra = strip_tags($_POST["formacompra"]); } else { $formacompra = "CREDITO"; }
		if (strip_tags($_POST["tipocompra"]=="CREDITO")) { $fechavencecredito = strip_tags(date("Y-m-d",strtotime($_POST['fechavencecredito']))); } else { $fechavencecredito = "0000-00-00"; }
		if (strip_tags($_POST["tipocompra"]=="CONTADO")) { $statuscompra = strip_tags("PAGADA"); } else { $statuscompra = "PENDIENTE"; }
		$fechacompra = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$codigo = strip_tags($_SESSION["codigo"]);
		$stmt->execute();
		
		$compra = $_SESSION["CarritoCompras"];
		for($i=0;$i<count($compra);$i++){
		
		$query = " insert into detallecompras values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
	    $stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $producto);
		$stmt->bindParam(4, $codcategoria);
		$stmt->bindParam(5, $cantidad);
		$stmt->bindParam(6, $precio);
		$stmt->bindParam(7, $precio2);
		$stmt->bindParam(8, $ivaproductoc);
		$stmt->bindParam(9, $importe);
		$stmt->bindParam(10, $lote);
		$stmt->bindParam(11, $vence);
		$stmt->bindParam(12, $fechadetallecompra);
		$stmt->bindParam(13, $codigo);
			
		$codcompra = strip_tags($_POST['codcompra']);
		$codproducto = strip_tags($compra[$i]['txtCodigo']);
		$producto = strip_tags($compra[$i]['descripcion']);
		$codcategoria = strip_tags($compra[$i]['tipo']);
		$cantidad = strip_tags($compra[$i]['cantidad']);
		$precio = strip_tags($compra[$i]['precio']);
		$precio2 = strip_tags($compra[$i]['precio2']);
		$ivaproductoc = strip_tags($compra[$i]['ivaproducto']);
		$importe = strip_tags($compra[$i]['cantidad'] * $compra[$i]['precio']);
		$lote = strip_tags($_POST['lote']);
		if (strip_tags($compra[$i]['vence']=="")) { $vence = "0000-00-00";  } else { $vence = strip_tags(date("Y-m-d",strtotime($compra[$i]['vence']))); }
		$fechadetallecompra = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$codigo = strip_tags($_SESSION['codigo']);
		$stmt->execute();
		
		$sql = " delete from detallecompras where codcompra = ? and cantcompra = '0'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcompra);
		$codcompra = $_POST["codcompra"];
		$stmt->execute();
		
		$sql = " select codproducto from productos where codproducto = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($compra[$i]['txtCodigo']) );
		$num = $stmt->rowCount();
		if($num == 0)
		{
		##################### REGISTRAMOS LOS NUEVOS PRODUCTOS COMPRADOS ####################################
		$query = " insert into productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
	    $stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $producto);
		$stmt->bindParam(3, $codcategoria);
		$stmt->bindParam(4, $existencia);
		$stmt->bindParam(5, $preciocompra);
		$stmt->bindParam(6, $precioventa);
		$stmt->bindParam(7, $stockminimo);
		$stmt->bindParam(8, $codigobarra);
		$stmt->bindParam(9, $ubicacion);
		$stmt->bindParam(10, $ivaproducto);
		$stmt->bindParam(11, $statusproducto);
			
		$codproducto = strip_tags($compra[$i]['txtCodigo']);
		$producto = strip_tags($compra[$i]['descripcion']);
		$codcategoria = strip_tags($compra[$i]['tipo']);
		$existencia = strip_tags($compra[$i]['cantidad']);
		$preciocompra = strip_tags($compra[$i]['precio']);
		$precioventa = strip_tags($compra[$i]['precio2']);
		$stockminimo = strip_tags('0');
		$codigobarra = strip_tags($compra[$i]['txtCodigo']);
		$ubicacion = strip_tags('SIN ASIGNACION');
		$ivaproducto = strip_tags($compra[$i]['ivaproducto']);
		$statusproducto = strip_tags('ACTIVO');
		$stmt->execute();
		##################### REGISTRAMOS LOS NUEVOS PRODUCTOS COMPRADOS ####################################
		
		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################################
		$query = " insert into kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $stockactual);
		$stmt->bindParam(8, $preciounit);
		$stmt->bindParam(9, $costototal);
		$stmt->bindParam(10, $documento);
		$stmt->bindParam(11, $fechakardex);
		
		$codcompra = strip_tags($_POST['codcompra']);
		$codproveedor = strip_tags($_POST["codproveedor"]);
		$codproducto = strip_tags($compra[$i]['txtCodigo']);
		$movimiento = strip_tags("ENTRADAS");
		$entradas = strip_tags($compra[$i]['cantidad']);
		$salidas = strip_tags("0");
		$stockactual = strip_tags($compra[$i]['cantidad']);
		$preciounit = strip_tags($compra[$i]['precio']);
		$costototal = strip_tags($compra[$i]['precio'] * $compra[$i]['cantidad']);
		$documento = strip_tags("COMPRA - ".$_POST["tipocompra"]." - FACTURA: ".$_POST['codcompra']);
		$fechakardex = strip_tags(date("Y-m-d",strtotime($_POST['fecharegistro'])));
		$stmt->execute();
		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################################
		
		} else {
		
		$sql = "select existencia from productos where codproducto = '".$compra[$i]['txtCodigo']."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		
		$cantidanterior = $row['existencia'];
	
		##################### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS COMPRADOS ####################################
		$sql = " update productos set "
		      ." preciocompra = ?, "
			  ." precioventa = ?, "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $preciocompra);
		$stmt->bindParam(2,$precioventa);
		$stmt->bindParam(3, $existencia);
		$stmt->bindParam(4, $codigo);
		
		$preciocompra = strip_tags($compra[$i]['precio']);
		$precioventa = strip_tags($compra[$i]['precio2']);
		$cantidad = strip_tags($compra[$i]['cantidad']);
		$existencia = $cantidad + $cantidanterior;
		$codigo = strip_tags($compra[$i]['txtCodigo']);
		$stmt->execute();
		##################### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS COMPRADOS ####################################		
		
		$sql = " delete from detallecompras where codcompra = ? and cantcompra = '0'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcompra);
		$codcompra = $_POST["codcompra"];
		$stmt->execute();
		
		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################################
		$query = " insert into kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $stockactual);
		$stmt->bindParam(8, $preciounit);
		$stmt->bindParam(9, $costototal);
		$stmt->bindParam(10, $documento);
		$stmt->bindParam(11, $fechakardex);
		
		$codcompra = strip_tags($_POST['codcompra']);
		$codproveedor = strip_tags($_POST["codproveedor"]);
		$codproducto = strip_tags($compra[$i]['txtCodigo']);
		$movimiento = strip_tags("ENTRADAS");
		$entradas = strip_tags($compra[$i]['cantidad']);
		$salidas = strip_tags("0");
		$stockactual = strip_tags($cantidanterior+$compra[$i]['cantidad']);
		$preciounit = strip_tags($compra[$i]['precio']);
		$costototal = strip_tags($compra[$i]['precio'] * $compra[$i]['cantidad']);
		$documento = strip_tags("COMPRA - ".$_POST["tipocompra"]." - FACTURA: ".$_POST['codcompra']);
		$fechakardex = strip_tags(date("Y-m-d",strtotime($_POST['fecharegistro'])));
		$stmt->execute();
		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################################		
		       }			   
		
		}
		###### AQUI DESTRUIMOS TODAS LAS VARIABLES DE SESSION QUE RECIBIMOS EN CARRITO DE COMPRA ######
		unset($_SESSION["CarritoCompras"]);
		
		echo "<div class='alert alert-success'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-check-square-o'></span> LA COMPRA DE PRODUCTOS FUE REGISTRADA EXITOSAMENTE <a href='reportepdf.php?codcompra=".base64_encode($codcompra)."&tipo=".base64_encode("FACTURACOMPRAS")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black'><strong>IMPRIMIR FACTURA DE COMPRA</strong></a></div>";
		exit;
		}
	}
######################################  FIN DE FUNCION PARA REGISTRAR COMPRAS DE PRODUCTOS  ######################################

######################################  FUNCION PARA LISTAR COMPRAS DE PRODUCTOS ###################################### 
	public function ListarCompras()
	{
		self::SetNames();
	    if($_SESSION['acceso'] == "administrador") {
		
		$sql = " SELECT compras.codcompra, compras.subtotalivasic, compras.subtotalivanoc, compras.ivac, compras.totalivac, compras.descuentoc, compras.totaldescuentoc, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fechacompra, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN usuarios ON compras.codigo = usuarios.codigo LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra GROUP BY compras.codcompra";
       foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
	    else {
		
		$sql = " SELECT compras.codcompra, compras.subtotalivasic, compras.subtotalivanoc, compras.ivac, compras.totalivac, compras.descuentoc, compras.totaldescuentoc, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fechacompra, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN usuarios ON compras.codigo = usuarios.codigo LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE compras.codigo = ".$_SESSION["codigo"]." GROUP BY compras.codcompra";
		
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################################  FIN DE FUNCION PARA LISTAR COMPRAS DE PRODUCTOS ######################################

######################################  FUNCION PARA PAGAR FACTURA DE COMPRAR DE PRODUCTOS  ######################################

public function PagarCompras()
	{
		if($_SESSION['acceso'] == "administrador") {
		
		self::SetNames();
		$sql = " update compras set "
			  ." fechavencecredito = '0000-00-00', "
			  ." statuscompra = ? "
			  ." where "
			  ." codcompra = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $statuscompra);
		$stmt->bindParam(2, $codcompra);
		$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
		$statuscompra = strip_tags("PAGADA");
		$stmt->execute();
	
		header("Location: compras.php?mesage=1");
		exit;
		   
		   }else {
		   
			header("Location: compras.php?mesage=2");
			exit;
		  }
			
	}
######################################  FIN DE FUNCION PARA PARA PAGAR FACTURA DE COMPRAR DE PRODUCTOS ######################################

######################################  FUNCION PARA LISTAR DETALLES DE COMPRAS DE PRODUCTOS  ######################################
	public function ListarDetallesCompras()
	{
		self::SetNames();
		
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " select * FROM detallecompras INNER JOIN categorias ON detallecompras.codcategoria = categorias.codcategoria";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
		 else {
		
		$sql = " select * FROM detallecompras INNER JOIN categorias ON detallecompras.codcategoria = categorias.codcategoria WHERE detallecompras.codigo = ".$_SESSION["codigo"]."";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################################  FIN DE FUNCION PARA LISTAR DETALLES DE COMPRAS DE PRODUCTOS ######################################


################################################ FUNCION PARA MOSTRAR COMPRAS DE PRODUCTOS POR CODIGO ################################################
public function ComprasPorId()
	{
		self::SetNames();
		$sql = " select * FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN usuarios ON compras.codigo = usuarios.codigo WHERE compras.codcompra = ?";	
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codcompra"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA COMPRAS DE PRODUCTOS POR CODIGO ################################################


################################################ FUNCION PARA MOSTRAR DETALLES DE COMPRAS POR CODIGO N# 1 ################################################
public function VerDetallesCompras()
	{
		self::SetNames();
		$sql = " select * FROM detallecompras INNER JOIN categorias ON detallecompras.codcategoria = categorias.codcategoria WHERE detallecompras.codcompra = ?";	
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(base64_decode($_GET["codcompra"])));
		$stmt->execute();
		$num = $stmt->rowCount();
		
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
################################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE COMPRAS POR CODIGO N# 1 ################################################

################################################ FUNCION PARA MOSTRAR DETALLES DE COMPRAS POR CODIGO N# 2 ################################################
public function DetallesComprasPorId()
	{
		self::SetNames();
		$sql = " select * FROM detallecompras INNER JOIN categorias ON detallecompras.codcategoria = categorias.codcategoria LEFT JOIN productos ON detallecompras.codproducto = productos.codproducto WHERE detallecompras.coddetallecompra = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["coddetallecompra"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE COMPRAS POR CODIGO N# 2 ################################################


################################################  FUNCION PARA ACTUALIZAR COMPRAS DE PRODUCTOS ################################################
	public function ActualizarDetallesCompras()
	{
		self::SetNames();
		if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["cantcompra"]))
		{
			echo "1";
		    exit;
		}
		
		$sql6 = " select codcompra from compras order by codcompra desc limit 1";
	    foreach ($this->dbh->query($sql6) as $row6){
		$codc["codcompra"]=$row6["codcompra"];
		                                           }
		
		if($codc["codcompra"] != $_POST["codcompra"])
           { 
		     echo "2";
			 exit;
           }
		
		$sql2 = " select * from detallecompras where coddetallecompra = ? and codcompra = ? ";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($_POST["coddetallecompra"], $_POST["codcompra"]) );
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pa[] = $row;
			}
		$cantidadcompradb = $pa[0]["cantcompra"];
		
		$sql = " update detallecompras set "
		      ." codcompra = ?, "
			  ." codproducto = ?, "
			  ." producto = ?, "
			  ." codcategoria = ?, "
			  ." cantcompra = ?, "
			  ." precio1 = ?, "
			  ." ivaproductoc = ?, "
			  ." precio2 = ?, "
			  ." importecompra = ?, "
			  ." lote = ?, "
			  ." vence = ? "
			  ." where "
			  ." coddetallecompra = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $producto);
		$stmt->bindParam(4, $codcategoria);
		$stmt->bindParam(5, $cantcompra);
		$stmt->bindParam(6, $precio1);
		$stmt->bindParam(7, $ivaproductoc);
		$stmt->bindParam(8, $precio2);
		$stmt->bindParam(9, $importecompra);
		$stmt->bindParam(10, $lote);
		$stmt->bindParam(11, $vence);
		$stmt->bindParam(12, $coddetallecompra);
		
		$codcompra = strip_tags($_POST["codcompra"]);
		$codproducto = strip_tags($_POST["codproducto"]);
		$producto = strip_tags($_POST["producto"]);
		$codcategoria = strip_tags($_POST["codcategoria"]);
		$cantcompra = strip_tags($_POST["cantcompra"]);
		$precio1 = strip_tags($_POST["precio1"]);
		$ivaproductoc = strip_tags($_POST["ivaproductoc"]);
		$precio2 = strip_tags($_POST["precio2"]);
		$importecompra = strip_tags($_POST["importecompra"]);
		$lote = strip_tags($_POST['lote']);
		$vence = strip_tags(date("Y-m-d",strtotime($_POST['vence'])));
		$coddetallecompra = strip_tags($_POST["coddetallecompra"]);
		$stmt->execute();
		
		###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
		$sql2 = " update productos set "
		      ." producto = ?, "
			  ." codcategoria = ?, "
			  ." existencia = ?, "
			  ." precioventa = ? "
			  ." where "
			  ." codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $producto);
		$stmt->bindParam(2, $codcategoria);
		$stmt->bindParam(3, $existencia);
		$stmt->bindParam(4, $precioventa);
		$stmt->bindParam(5, $codproducto);
		
		$producto = strip_tags($_POST["producto"]);
		$codcategoria = strip_tags($_POST["codcategoria"]);
		$precioventa = strip_tags($_POST["precio2"]);
		$codproducto = strip_tags($_POST["codproducto"]);
		$cantidad = strip_tags($_POST["cantcompra"]);
		$existenciadb = strip_tags($_POST["existencia"]);
		$calculoproducto=$cantidad - $cantidadcompradb;
		$existencia = $existenciadb + $calculoproducto;
		$stmt->execute();
		
		
		###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ############################		
		$sql2 = " update kardex set "
		      ." entradas = ?, "
		      ." stockactual = ?, "
			  ." preciounit = ?, "
			  ." costototal = ? "
			  ." where "
			  ." codproceso = ? and codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $entradas);
		$stmt->bindParam(2, $stockactual);
		$stmt->bindParam(3, $preciounit);
		$stmt->bindParam(4, $costototal);
		$stmt->bindParam(5, $codcompra);
		$stmt->bindParam(6, $codproducto);
		
		$entradas = strip_tags($_POST["cantcompra"]);
		$preciounit = strip_tags($_POST["precio1"]);
		$codcompra = strip_tags($_POST["codcompra"]);
		$codproducto = strip_tags($_POST["codproducto"]);
		$costototal = strip_tags($_POST["cantcompra"] * $_POST["precio1"]);
		$calculoproducto=$cantidad - $cantidadcompradb;
		$stockactual = $existenciadb + $calculoproducto;
		$stmt->execute();
			
	    $sql4 = "select * from compras where codcompra = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array($_POST["codcompra"]) );
		$num = $stmt->rowCount();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$paea[] = $row;
			}
			$subtotalivasic = $paea[0]["subtotalivasic"];
			$subtotalivanoc = $paea[0]["subtotalivanoc"];
			$iva = $paea[0]["ivac"]/100;
			$descuento = $paea[0]["descuentoc"]/100;
			$totalivac = $paea[0]["totalivac"];
			$totaldescuentoc = $paea[0]["totaldescuentoc"];
			
	if($_POST["ivaproductoc"]=="SI"){	
	
		$sql3 = "select sum(importecompra) as importe from detallecompras where codcompra = ? and ivaproductoc = 'SI'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array($_POST["codcompra"]));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch())
			{
				$pae[] = $row;
			}
		$importe = $pae[0]["importe"];
	 
	 	$sql = " update compras set "
			  ." subtotalivasic = ?, "
			  ." totalivac = ?, "
			  ." totaldescuentoc = ?, "
			  ." totalc= ? "
			  ." where "
			  ." codcompra = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaliva);
		$stmt->bindParam(3, $totaldescuentoc);
		$stmt->bindParam(4, $total);
		$stmt->bindParam(5, $codcompra);
		
		$subtotal= rount($importe,2);
        $totaliva= rount($subtotal*$iva,2);
		$tot= rount($subtotal+$subtotalivanoc+$totaliva,2);
		$totaldescuentoc= rount($tot*$descuento,2);
		$total= rount($tot-$totaldescuentoc,2);
		$codcompra = strip_tags($_POST["codcompra"]);
		$stmt->execute();
		
		                    } else {
							
		$sql3 = "select sum(importecompra) as importe from detallecompras where codcompra = ? and ivaproductoc = 'NO'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array($_POST["codcompra"]));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pae[] = $row;
			}
		$importe = $pae[0]["importe"];
		
		$sql = " update compras set "
			  ." subtotalivanoc = ?, "
			  ." totaldescuentoc = ?, "
			  ." totalc= ? "
			  ." where "
			  ." codcompra = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaldescuentoc);
		$stmt->bindParam(3, $total);
		$stmt->bindParam(4, $codcompra);
		
		$subtotal= rount($importe,2);
		$tot= rount($subtotal+$subtotalivasic+$totalivac,2);
		$totaldescuentoc= rount($tot*$descuento,2);
		$total= rount($tot-$totaldescuentoc,2);
		$codcompra = strip_tags($_POST["codcompra"]);
		$stmt->execute();		
		
		                        }
		
        echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL DETALLE DE COMPRA DE PRODUCTO FUE ACTUALIZADA EXITOSAMENTE </div>"; // wrong details
		exit;
	}
################################################ FIN DE FUNCION PARA ACTUALIZAR COMPRAS DE PRODUCTOS ################################################


######################################  FUNCION PARA ELIMINAR DETALLES DE COMPRAS DE PRODUCTOS  ######################################
public function EliminarDetallesCompras()
	{
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " select codcompra from compras order by codcompra desc limit 1";
	    foreach ($this->dbh->query($sql) as $row){
		$codcompra["codcompra"]=$row["codcompra"];
		                                         }
		
		if($codcompra["codcompra"] != base64_decode($_GET["codcompra"]))
           {
			  header("Location: detallescompras?mesage=1");
		      exit;
           }
		
		self::SetNames();
		$sql = " select * from detallecompras where codcompra = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codcompra"])) );
		$num = $stmt->rowCount();
		if($num > 1)
		{
		
		$sql2 = "select existencia from productos where codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array(base64_decode($_GET["codproducto"])));
		$num = $stmt->rowCount();
		
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $row;
			}
		$existenciadb = $p[0]["existencia"];
		
		$sql = " delete from detallecompras where coddetallecompra = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetallecompra);
		$coddetallecompra = base64_decode($_GET["coddetallecompra"]);
		$stmt->execute();
		
	   ###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
		$sql = " update productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$cantcompra = strip_tags(base64_decode($_GET["cantcompra"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$existencia = $existenciadb - $cantcompra;
		$stmt->execute();
		
		###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
		$sql = " delete from kardex where codproceso = ? and codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcompra);
		$stmt->bindParam(2,$codproducto);
		$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$stmt->execute();
					
		$sql4 = "select * from compras where codcompra = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array(base64_decode($_GET["codcompra"])));
		$num = $stmt->rowCount();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$paea[] = $row;
			}
			$subtotalivasic = $paea[0]["subtotalivasic"];
			$subtotalivanoc = $paea[0]["subtotalivanoc"];
			$iva = $paea[0]["ivac"]/100;
			$descuento = $paea[0]["descuentoc"]/100;
			$totalivac = $paea[0]["totalivac"];
			$totaldescuentoc = $paea[0]["totaldescuentoc"];
			
	if(base64_decode($_GET["ivaproductoc"])=="SI"){	
	
		$sql3 = "select sum(importecompra) as importe from detallecompras where codcompra = ? and ivaproductoc = 'SI'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array(base64_decode($_GET["codcompra"])));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pae[] = $row;
			}
		$importe = $pae[0]["importe"];	
	
		$sql = " update compras set "
			  ." subtotalivasic = ?, "
			  ." totalivac = ?, "
			  ." totaldescuentoc = ?, "
			  ." totalc= ? "
			  ." where "
			  ." codcompra = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaliva);
		$stmt->bindParam(3, $totaldescuentoc);
		$stmt->bindParam(4, $total);
		$stmt->bindParam(5, $codcompra);
		
		$subtotal= rount($importe,2);
        $totaliva= rount($subtotal*$iva,2);
		$tot= rount($subtotal+$subtotalivanoc+$totaliva,2);
		$totaldescuentoc= rount($tot*$descuento,2);
		$total= rount($tot-$totaldescuentoc,2);
		$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
		$stmt->execute();
		
		                    } else {
							
		$sql3 = "select sum(importecompra) as importe from detallecompras where codcompra = ? and ivaproductoc = 'NO'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array(base64_decode($_GET["codcompra"])));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pae[] = $row;
			}
		$importe = $pae[0]["importe"];
		
		$sql = " update compras set "
			  ." subtotalivanoc = ?, "
			  ." totaldescuentoc = ?, "
			  ." totalc= ? "
			  ." where "
			  ." codcompra = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaldescuentoc);
		$stmt->bindParam(3, $total);
		$stmt->bindParam(4, $codcompra);
		
		$subtotal= rount($importe,2);
		$tot= rount($subtotal+$subtotalivasic+$totalivac,2);
		$totaldescuentoc= rount($tot*$descuento,2);
		$total= rount($tot-$totaldescuentoc,2);
		$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
		$stmt->execute();		
		                        }					
	
		header("Location: detallescompras?mesage=2");
		exit;
		   
		}
		else
		{
		
	###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
	    $sql2 = "select existencia from productos where codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array(base64_decode($_GET["codproducto"])));
		$num = $stmt->rowCount();
		
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $row;
			}
		$existenciadb = $p[0]["existencia"];
		
		$sql = " update productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$cantcompra = strip_tags(base64_decode($_GET["cantcompra"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$existencia = $existenciadb - $cantcompra;
		$stmt->execute();
		
		###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
		$sql = " delete from kardex where codproceso = ? and codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcompra);
		$stmt->bindParam(2,$codproducto);
		$codcompra = strip_tags(base64_decode($_GET["codcompra"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$stmt->execute();
		
		$sql = " delete from compras where codcompra = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcompra);
		$codcompra = base64_decode($_GET["codcompra"]);
		$stmt->execute();
		
		$sql = " delete from detallecompras where coddetallecompra = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetallecompra);
		$coddetallecompra = base64_decode($_GET["coddetallecompra"]);
		$stmt->execute();
		
		header("Location: detallescompras?mesage=2");
		exit;
		       }
		}
		else
		{
			header("Location: detallescompras?mesage=3");
			exit;
		}
	}
######################################  FIN DE FUNCION PARA ELIMINAR DETALLES DE COMPRAS DE PRODUCTOS ######################################


######################################  FUNCION PARA BUSQUEDA DE REPORTES DE COMPRAS DE PRODUCTOS POR PROVEEDORES ######################################
	    public function BuscarComprasReportes() 
	       {
		self::SetNames();
		
	    if($_SESSION['acceso'] == "administrador") {
		
		$sql = " SELECT compras.codcompra, compras.subtotalivasic, compras.subtotalivanoc, compras.ivac, compras.totalivac, compras.descuentoc, compras.totaldescuentoc, compras.totalc, compras.statuscompra, compras.fechavencecredito, compras.fechacompra, proveedores.nomproveedor, SUM(detallecompras.cantcompra) AS articulos FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) INNER JOIN usuarios ON compras.codigo = usuarios.codigo LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra WHERE proveedores.codproveedor = ? GROUP BY compras.codcompra";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codproveedor"]) );
		$num = $stmt->rowCount();
		     if($num==0)
		{
		
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN COMPRAS DE PRODUCTOS PARA EL PROVEEDOR SELECCIONADO</div></center>";
		exit;
		       }
		else
		{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}  else {
		
		$sql = "select * from compras, usuarios where compras.codigo = ".$_SESSION["codigo"]." and compras.codproveedor = ? and compras.codigo = usuarios.codigo";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codproveedor"]) );
		$num = $stmt->rowCount();
		     if($num==0)
		{
		
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN COMPRAS DE PRODUCTOS PARA EL PROVEEDOR SELECCIONADO</div></center>";
		exit;
		       }
		else
		{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
    }  
}
###################################### FIN DE FUNCION PARA BUSQUEDA DE REPORTES DE COMPRAS DE PRODUCTOS POR PROVEEDORES ######################################
	
################################################################## FIN DE CLASE COMPRAS DE PRODUCTOS   ############################################################






































































##################################################################  CLASE VENTAS DE PRODUCTOS   ############################################################

###################################### FUNCION PARA CODIGO DE VENTAS ######################################
	public function CodigoVentas()
	{
     self::SetNames();
	 
	 $sql = "select nrocaja from cajas where codigo = '".$_SESSION["codigo"]."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$nrocaja = $row['nrocaja'];
		
	 $sql = " select codventa from ventas where codigo = '".$_SESSION["codigo"]."' order by codventa desc limit 1";
	 foreach ($this->dbh->query($sql) as $row){

     $codventa["codventa"]=$row["codventa"];
	   
      }
          if(empty($codventa["codventa"]))
           {
              echo $nroventa = date("Y").'-'.$nrocaja.'-V00001';

     } else
           {
               $resto = substr($codventa["codventa"], 0, -5);
			   $coun = strlen($resto);
			   $num     = substr($codventa["codventa"] , $coun);
               $dig     = $num + 1;
               $codigo = str_pad($dig, 5, "0", STR_PAD_LEFT);
			   echo $nroventa = date("Y").'-'.$nrocaja.'-V'.$codigo;
         }
				 }
###################################### FIN DE FUNCION PARA CODIGO DE VENTAS ######################################

###################################### FUNCION PARA CREAR NUMERO DE SERIE #PARA VENTAS #####################################
	public function CodigoSerieVe()
	{
    
	 self::SetNames();
     $sql = "select nrocaja from cajas where codigo = '".$_SESSION["codigo"]."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$nrocaja = $row['nrocaja'];
		
	 $sql = " select codserieve from ventas where codigo = '".$_SESSION["codigo"]."' order by codserieve desc limit 1";
	foreach ($this->dbh->query($sql) as $row){

     $codserieve["codserieve"]=$row["codserieve"];
      }
          if(empty($codserieve["codserieve"]))
           {
			  echo $nroserie = date("d").''.date("m").''.date("Y").'-'.$nrocaja.'-V00001';
     } else
           {
               $resto = substr($codserieve["codserieve"], 0, -5);
			   $coun = strlen($resto);
			   $num     = substr($codserieve["codserieve"] , $coun);
               $dig     = $num + 1;
               $codigo = str_pad($dig, 5, "0", STR_PAD_LEFT);
			   echo $nroserie = date("d").''.date("m").''.date("Y").'-'.$nrocaja.'-V'.$codigo;
         }
				 }
###################################### FIN DE FUNCION PARA CREAR NUMERO DE SERIE PARA VENTAS ######################################

###################################### FUNCION PARA CREAR NUMERO DE AUTORIZACION PARA VENTAS ######################################
	public function CodigoAutorizacionVe()
	{
    
	self::SetNames();		
    $sql = "select nrocaja from cajas where codigo = '".$_SESSION["codigo"]."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$nrocaja = $row['nrocaja'];
		
	 $sql = " select codautorizacionve from ventas where codigo = '".$_SESSION["codigo"]."' order by codautorizacionve desc limit 1";
	foreach ($this->dbh->query($sql) as $row){
 
     $codautorizacionve["codautorizacionve"]=$row["codautorizacionve"];
      }
          if(empty($codautorizacionve["codautorizacionve"]))
           {
              echo $nroautorizacion = 'VAHXF-'.date("Y").'-'.$nrocaja.'-'.'V00001';
     }else
           {
               $resto = substr($codautorizacionve["codautorizacionve"], 0, -5);
			   $coun = strlen($resto);			   
			   $num     = substr($codautorizacionve["codautorizacionve"] , $coun);
               $dig     = $num + 1;
               $codigo = str_pad($dig, 5, "0", STR_PAD_LEFT);
			   echo $nroautorizacion = 'VAHXF-'.date("Y").'-'.$nrocaja.'-V'.$codigo;
         }
				 }
###################################### FIN DE FUNCION PARA CREAR NUMERO DE AUTORIZACION PARA VENTAS ######################################


###################################### FUNCION PARA REGISTRAR VENTAS DE PRODUCTOS ######################################
	public function RegistrarVentas()
	{
		self::SetNames();
	if(empty($_POST["codventa"]) or empty($_POST["codserieve"]) or empty($_POST["codautorizacionve"]) or empty($_POST["codcliente"]) or empty($_POST["tipopagove"]))
		{
			echo "1";
			exit;
		}
		
		if(empty($_SESSION["CarritoVentas"]))
		{
			echo "2";
			exit;
			
		} 
		else if($_POST["tipopagove"]=="CREDITO" && $_POST["montoabono"] >= $_POST["txtTotal"])
		{
			echo "3";
			exit;
			
		} else {
		
		$query = " insert into ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codserieve);
		$stmt->bindParam(3, $codautorizacionve);
		$stmt->bindParam(4, $codcaja);
		$stmt->bindParam(5, $codcliente);
		$stmt->bindParam(6, $subtotalivasive);
		$stmt->bindParam(7, $subtotalivanove);
		$stmt->bindParam(8, $ivave);
		$stmt->bindParam(9, $totalivave);
		$stmt->bindParam(10, $descuentove);
		$stmt->bindParam(11, $totaldescuentove);
		$stmt->bindParam(12, $totalpago);
		$stmt->bindParam(13, $totalpago2);
		$stmt->bindParam(14, $tipopagove);
		$stmt->bindParam(15, $formapagove);
		$stmt->bindParam(16, $montopagado);
		$stmt->bindParam(17, $montodevuelto);
		$stmt->bindParam(18, $fechavencecredito);
		$stmt->bindParam(19, $statusventa);
		$stmt->bindParam(20, $fechaventa);
		$stmt->bindParam(21, $codigo);
				 
		$codventa = strip_tags($_POST["codventa"]);
		$codserieve = strip_tags($_POST["codserieve"]);
		$codautorizacionve = strip_tags($_POST["codautorizacionve"]);
		$codcaja = strip_tags($_POST["codcaja"]);
		$codcliente = strip_tags($_POST["codcliente"]);
		$subtotalivasive = strip_tags($_POST["txtsubtotal"]);
		$subtotalivanove = strip_tags($_POST["txtsubtotal2"]);
		$ivave = strip_tags($_POST["iva"]);
		$totalivave = strip_tags($_POST["txtIva"]);
		$descuentove = strip_tags($_POST["descuento"]);
		$totaldescuentove = strip_tags($_POST["txtDescuento"]);
		$totalpago = strip_tags($_POST["txtTotal"]);
		$totalpago2 = strip_tags($_POST["txtTotalCompra"]);
		$tipopagove = strip_tags($_POST["tipopagove"]);
		if (strip_tags($_POST["tipopagove"]=="CONTADO")) { $formapagove = strip_tags($_POST["formapagove"]); } else { $formapagove = "CREDITO"; }
		
		if (strip_tags($_POST["tipopagove"]=="CONTADO" && $_POST["formapagove"]=="EFECTIVO")) { $montopagado = strip_tags($_POST["montopagado"]); } else { $montopagado = "0.00"; }
		if (strip_tags($_POST["tipopagove"]=="CONTADO" && $_POST["formapagove"]=="EFECTIVO")) { $montodevuelto = strip_tags($_POST["montodevuelto"]); } else { $montodevuelto = "0.00"; }
		if (strip_tags($_POST["tipopagove"]=="CREDITO")) { $fechavencecredito = strip_tags(date("Y-m-d",strtotime($_POST['fechavencecredito']))); } else { $fechavencecredito = "0000-00-00"; }
		if (strip_tags($_POST["tipopagove"]=="CONTADO")) { $statusventa = strip_tags("PAGADA"); } else { $statusventa = "PENDIENTE"; }
		$fechaventa = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$codigo = strip_tags($_SESSION["codigo"]);
		$stmt->execute();
		
		$venta = $_SESSION["CarritoVentas"];
		for($i=0;$i<count($venta);$i++){
		
		$query = " insert into detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
	    $stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $producto);
		$stmt->bindParam(5, $codcategoria);
		$stmt->bindParam(6, $cantidad);
		$stmt->bindParam(7, $preciocompra);
		$stmt->bindParam(8, $precioventa);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $importe);
		$stmt->bindParam(11, $importe2);
		$stmt->bindParam(12, $fechadetalleventa);
		$stmt->bindParam(13, $codigo);
			
		$codventa = strip_tags($_POST['codventa']);
		$codcliente = strip_tags($_POST["codcliente"]);
		$codproducto = strip_tags($venta[$i]['txtCodigo']);
		$producto = strip_tags($venta[$i]['descripcion']);
		$codcategoria = strip_tags($venta[$i]['tipo']);
		$cantidad = strip_tags($venta[$i]['cantidad']);
		$preciocompra = strip_tags($venta[$i]['precio']);
		$precioventa = strip_tags($venta[$i]['precio2']);
		$ivaproducto = strip_tags($venta[$i]['ivaproducto']);
		$importe = strip_tags($venta[$i]['cantidad'] * $venta[$i]['precio2']);
		$importe2 = strip_tags($venta[$i]['cantidad'] * $venta[$i]['precio']);
		$fechadetalleventa = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$codigo = strip_tags($_SESSION['codigo']);
		$stmt->execute();
		
		$sql = " update productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = '".$venta[$i]['txtCodigo']."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$existencia = $venta[$i]['existencia' ] - $venta[$i]['cantidad'];
		$stmt->execute();
		
		$sql = " delete from detalleventas where codventa = ? and cantventa = '0'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$codventa = $_POST["codventa"];
		$stmt->execute();
		
		##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ####################################
		$query = " insert into kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $stockactual);
		$stmt->bindParam(8, $preciounit);
		$stmt->bindParam(9, $costototal);
		$stmt->bindParam(10, $documento);
		$stmt->bindParam(11, $fechakardex);
		
		$codventa = strip_tags($_POST['codventa']);
		$codcliente = strip_tags($_POST["codcliente"]);
		$codproducto = strip_tags($venta[$i]['txtCodigo']);
		$movimiento = strip_tags("SALIDAS");
		$entradas = strip_tags("0");
		$salidas =strip_tags($venta[$i]['cantidad']);
		$stockactual = strip_tags($venta[$i]['existencia' ] - $venta[$i]['cantidad']); 
		$preciounit = strip_tags($venta[$i]['precio2']);
		$costototal = strip_tags($venta[$i]['precio2'] * $venta[$i]['cantidad']);
		$documento = strip_tags("VENTA - ".$_POST["tipopagove"]." - FACTURA: ".$_POST['codventa']);
		$fechakardex = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$stmt->execute();				
		}
		###### AQUI DESTRUIMOS TODAS LAS VARIABLES DE SESSION QUE RECIBIMOS EN CARRITO DE VENTAS ######
		unset($_SESSION["CarritoVentas"]);
		
		############## REGISTRO DE ABONOS EN VENTAS ##################
		if (strip_tags($_POST["tipopagove"]=="CREDITO" && $_POST["montoabono"]!="0.00")) { 
				
		$query = " insert into abonoscreditos values (null, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $montoabono);
		$stmt->bindParam(4, $fechaabono);
		$stmt->bindParam(5, $codigo);
	    
		$codventa = strip_tags($_POST["codventa"]);
		$codcliente = strip_tags($_POST["codcliente"]);
		$montoabono = strip_tags($_POST["montoabono"]);
		$fechaabono = strip_tags(date("Y-m-d h:i:s"));
		$codigo = strip_tags($_SESSION["codigo"]);
		$stmt->execute();
																					   }
		
		if (strip_tags($_POST["tiporeporte"]=="TICKET")) {
		
		echo "<div class='alert alert-success'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> LA VENTA DE PRODUCTOS FUE REGISTRADA EXITOSAMENTE <a href='reportepdf.php?codventa=".base64_encode($codventa)."&tipo=".base64_encode("TICKET")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black'><strong>IMPRIMIR TICKET DE VENTA</strong></a></div>";
		exit;
                                                          } else {
		
		echo "<div class='alert alert-success'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> LA VENTA DE PRODUCTOS FUE REGISTRADA EXITOSAMENTE <a href='reportepdf.php?codventa=".base64_encode($codventa)."&tipo=".base64_encode("VENTAS")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black'><strong>IMPRIMIR FACTURA DE VENTA</strong></a></div>";
		exit;
														  }		                                                 
		}
	}
######################################  FIN DE FUNCION PARA REGISTRAR VENTAS DE PRODUCTOS  ######################################

######################################   FUNCION PARA LISTAR VENTAS DE PRODUCTOS  ###################################### 
	public function ListarVentas()
	{
		self::SetNames();
	    
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " SELECT ventas.codventa, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, cajas.nrocaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente) INNER JOIN usuarios ON ventas.codigo = usuarios.codigo INNER JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa GROUP BY ventas.codventa";
       foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}  else {
		
		$sql = " SELECT ventas.codventa, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.totalpago2, ventas.statusventa, ventas.fechavencecredito, ventas.fechaventa, clientes.nomcliente, cajas.nrocaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente) INNER JOIN usuarios ON ventas.codigo = usuarios.codigo INNER JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa WHERE ventas.codigo = ".$_SESSION["codigo"]." GROUP BY ventas.codventa";		
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################################  FIN DE FUNCION PARA LISTAR VENTAS DE PRODUCTOS ###################################### 


######################################  FUNCION PARA LISTAR DETALLES DE VENTAS DE PRODUCTOS  ######################################
	public function ListarDetallesVentas()
	{
		self::SetNames();
		
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " select * FROM detalleventas INNER JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
		 else {
		
		$sql = " select * FROM detalleventas INNER JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria WHERE detalleventas.codigo = ".$_SESSION["codigo"];
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################################  FIN DE FUNCION PARA LISTAR DETALLES DE VENTAS DE PRODUCTOS ######################################

################################################ FUNCION PARA MOSTRAR VENTAS DE PRODUCTOS POR CODIGO ################################################
public function VentasPorId()
	{
		self::SetNames();
		$sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.direccliente, clientes.emailcliente, ventas.codventa, ventas.codserieve, ventas.codautorizacionve, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.totalpago2, ventas.tipopagove, ventas.formapagove, ventas.fechaventa, ventas.fechavencecredito, ventas.statusventa, usuarios.nombres, cajas.nrocaja, abonoscreditos.codventa as cod, abonoscreditos.fechaabono, SUM(montoabono) AS abonototal FROM (clientes INNER JOIN ventas ON clientes.codcliente = ventas.codcliente) LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo WHERE ventas.codventa =? GROUP BY cod";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codventa"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA VENTAS DE PRODUCTOS POR CODIGO ################################################

################################################ FUNCION PARA MOSTRAR DETALLES DE VENTAS POR CODIGO N# 1 ################################################
public function VerDetallesVentas()
	{
		self::SetNames();
		$sql = " select * FROM detalleventas INNER JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria WHERE detalleventas.codventa = ?";	
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(base64_decode($_GET["codventa"])));
		$stmt->execute();
		$num = $stmt->rowCount();
		
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
################################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE VENTAS POR CODIGO N# 1 ################################################


################################################ FUNCION PARA MOSTRAR DETALLES DE VENTAS POR CODIGO N# 2 ################################################
public function DetallesVentasPorId()
	{
		self::SetNames();
		$sql = " select detalleventas.coddetalleventa, detalleventas.codventa, detalleventas.codproducto, detalleventas.producto, detalleventas.codcategoria, detalleventas.cantventa, detalleventas.precioventa, detalleventas.preciocompra, detalleventas.importe, detalleventas.importe2, detalleventas.fechadetalleventa, categorias.nomcategoria, productos.ivaproducto, productos.existencia, clientes.codcliente, clientes.cedcliente, clientes.nomcliente FROM detalleventas INNER JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria LEFT JOIN clientes ON detalleventas.codcliente = clientes.codcliente LEFT JOIN productos ON detalleventas.codproducto = productos.codproducto WHERE detalleventas.coddetalleventa = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["coddetalleventa"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE VENTAS POR CODIGO N# 2 ################################################

################################################  FUNCION PARA ACTUALIZAR VENTAS DE PRODUCTOS ################################################
	public function ActualizarDetallesVentas()
	{
		self::SetNames();
		if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["cantventa"]))
		{
			echo "1";
		    exit;
		}
		
		$sql2 = " select * from detalleventas where coddetalleventa = ? and codventa = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($_POST["coddetalleventa"], $_POST["codventa"]) );
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pa[] = $row;
			}
		$cantidadventadb = $pa[0]["cantventa"];
		
		###################### ACTUALIZAMOS EL DETALLE DEL PRODUCTO ############################
		$sql = " update detalleventas set "
			  ." cantventa = ?, "
			  ." precioventa = ?, "
			  ." importe = ?, "
			  ." importe2 = ? "
			  ." where "
			  ." coddetalleventa = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $cantventa);
		$stmt->bindParam(2, $precioventa);
		$stmt->bindParam(3, $importeventa);
		$stmt->bindParam(4, $importecompra);
		$stmt->bindParam(5, $coddetalleventa);
		
		$cantventa = strip_tags($_POST["cantventa"]);
		$precioventa = strip_tags($_POST["precioventa"]);
		$importeventa = strip_tags($_POST["importe"]);
		$importecompra = strip_tags($_POST["importe2"]);
		$coddetalleventa = strip_tags($_POST["coddetalleventa"]);
		$stmt->execute();
		
		###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
		$sql2 = " update productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		
		$codproducto = strip_tags($_POST["codproducto"]);
		$cantidad = strip_tags($_POST["cantventa"]);
		$existenciadb = strip_tags($_POST["existencia"]);
		$calculoproducto=$cantidad - $cantidadventadb;
		$existencia = $existenciadb - $calculoproducto;
		$stmt->execute();
		
		###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ############################		
		$sql2 = " update kardex set "
		      ." salidas = ?, "
			  ." preciounit = ?, "
			  ." costototal = ? "
			  ." where "
			  ." codproceso = ? and codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $salidas);
		$stmt->bindParam(2, $preciounit);
		$stmt->bindParam(3, $costototal);
		$stmt->bindParam(4, $codventa);
		$stmt->bindParam(5, $codproducto);
		
		$salidas = strip_tags($_POST["cantventa"]);
		$preciounit = strip_tags($_POST["precioventa"]);
		$codventa = strip_tags($_POST["codventa"]);
		$codproducto = strip_tags($_POST["codproducto"]);
		$costototal = strip_tags($_POST["cantventa"] * $_POST["precioventa"]);
		$stmt->execute();
		
	    $sql4 = "select * from ventas where codventa = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array($_POST["codventa"]) );
		$num = $stmt->rowCount();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$paea[] = $row;
			}
			$subtotalivasive = $paea[0]["subtotalivasive"];
			$subtotalivanove = $paea[0]["subtotalivanove"];
			$iva = $paea[0]["ivave"]/100;
			$descuento = $paea[0]["descuentove"]/100;
			$totalivave = $paea[0]["totalivave"];
			$totaldescuentove = $paea[0]["totaldescuentove"];
			
	    if($_POST["ivaproducto"]=="SI"){
	
	    $sql3 = "select sum(importe) as importe, sum(importe2) as importe2, sum(preciocompra) as preciocompra from detalleventas where codventa = ? and ivaproducto = 'SI'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array($_POST["codventa"]));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch())
			{
				$pae[] = $row;
			}
		$preciocompra = $pae[0]["preciocompra"];
		$importe = $pae[0]["importe"];
		$importe2 = $pae[0]["importe2"];
			
		$sql = " update ventas set "
			  ." subtotalivasive = ?, "
			  ." totalivave = ?, "
			  ." totaldescuentove = ?, "
			  ." totalpago= ?, "
			  ." totalpago2= ? "
			  ." where "
			  ." codventa = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaliva);
		$stmt->bindParam(3, $totaldescuentove);
		$stmt->bindParam(4, $total);
		$stmt->bindParam(5, $total2);
		$stmt->bindParam(6, $codventa);
		
		$subtotal= rount($importe,2);
        $totaliva= rount($subtotal*$iva,2);
		$tot= rount($subtotal+$subtotalivanove+$totaliva,2);
		$totaldescuentove= rount($tot*$descuento,2);
		$total= rount($tot-$totaldescuentove,2);
		$total2= rount($preciocompra,2);
		$codventa = strip_tags($_POST["codventa"]);
		$stmt->execute();
		
		                       } else {
							   
		$sql3 = "select sum(importe) as importe, sum(importe2) as importe2, sum(preciocompra) as preciocompra from detalleventas where codventa = ?  and ivaproducto = 'NO'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array($_POST["codventa"]));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pae[] = $row;
			}
		$preciocompra = $pae[0]["preciocompra"];
		$importe = $pae[0]["importe"];
		$importe2 = $pae[0]["importe2"];
			
			
		$sql = " update ventas set "
			  ." subtotalivanove = ?, "
			  ." totaldescuentove = ?, "
			  ." totalpago= ?, "
			  ." totalpago2= ? "
			  ." where "
			  ." codventa = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaldescuentove);
		$stmt->bindParam(3, $total);
		$stmt->bindParam(4, $total2);
		$stmt->bindParam(5, $codventa);
		
		$subtotal= rount($importe,2);
		$tot= rount($subtotal+$subtotalivasive+$totalivave,2);
		$totaldescuentove= rount($tot*$descuento,2);
		$total= rount($tot-$totaldescuentove,2);
		$total2= rount($preciocompra,2);
		$codventa = strip_tags($_POST["codventa"]);
		$stmt->execute();
		
		                        }					
	    
        echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL DETALLE DE VENTA DE PRODUCTO FUE ACTUALIZADO EXITOSAMENTE </div>"; // wrong details
		exit;
		
	}
################################################ FIN DE FUNCION PARA ACTUALIZAR VENTAS DE PRODUCTOS ################################################


######################################  FUNCION PARA ELIMINAR DETALLES DE VENTAS DE PRODUCTOS  ######################################
public function EliminarDetallesVentas()
	{
		if($_SESSION['acceso'] == "administrador") {
		
		self::SetNames();
		$sql = " select * from detalleventas where codventa = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codventa"])) );
		$num = $stmt->rowCount();
		if($num > 1)
		{
		
		$sql2 = "select existencia from productos where codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array(base64_decode($_GET["codproducto"])));
		$num = $stmt->rowCount();
		
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $row;
			}
		$existenciadb = $p[0]["existencia"];
		
		$sql = " delete from detalleventas where coddetalleventa = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetalleventa);
		$coddetalleventa = base64_decode($_GET["coddetalleventa"]);
		$stmt->execute();
		
		###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
		$sql = " update productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$cantventa = strip_tags(base64_decode($_GET["cantventa"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$existencia = $existenciadb + $cantventa;
		$stmt->execute();
		
		###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
		$sql = " delete from kardex where codproceso = ? and codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$stmt->bindParam(2,$codproducto);
		$codventa = strip_tags(base64_decode($_GET["codventa"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$stmt->execute();
			
			
		$sql4 = "select * from ventas where codventa = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array(base64_decode($_GET["codventa"])) );
		$num = $stmt->rowCount();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$paea[] = $row;
			}
		$subtotalivasive = $paea[0]["subtotalivasive"];
		$subtotalivanove = $paea[0]["subtotalivanove"];
		$iva = $paea[0]["ivave"]/100;
		$descuento = $paea[0]["descuentove"]/100;
		$totalivave = $paea[0]["totalivave"];
		$totaldescuentove = $paea[0]["totaldescuentove"];
		
		if(base64_decode($_GET["ivaproducto"])=="SI"){	
	
		$sql3 = "select sum(importe) as importe, sum(importe2) as importe2, sum(preciocompra) as preciocompra from detalleventas where codventa = ? and ivaproducto = 'SI'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array(base64_decode($_GET["codventa"])));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pae[] = $row;
			}
		$preciocompra = $pae[0]["preciocompra"];
		$importe = $pae[0]["importe"];
		$importe2 = $pae[0]["importe2"];	
	
		$sql = " update ventas set "
			  ." subtotalivasive = ?, "
			  ." totalivave = ?, "
			  ." totaldescuentove = ?, "
			  ." totalpago= ?, "
			  ." totalpago2= ? "
			  ." where "
			  ." codventa = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaliva);
		$stmt->bindParam(3, $totaldescuentove);
		$stmt->bindParam(4, $total);
		$stmt->bindParam(5, $total2);
		$stmt->bindParam(6, $codventa);
		
		$subtotal= rount($importe,2);
        $totaliva= rount($subtotal*$iva,2);
		$tot= rount($subtotal+$subtotalivanove+$totaliva,2);
		$totaldescuentove= rount($tot*$descuento,2);
		$total= rount($tot-$totaldescuentove,2);
		$total2= rount($preciocompra,2);
		$codventa = strip_tags(base64_decode($_GET["codventa"]));
		$stmt->execute();
		
		                            } else {
							
		$sql3 = "select sum(importe) as importe, sum(importe2) as importe2, sum(preciocompra) as preciocompra from detalleventas where codventa = ? and ivaproducto = 'NO'";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array(base64_decode($_GET["codventa"])));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$pae[] = $row;
			}
		$preciocompra = $pae[0]["preciocompra"];
		$importe = $pae[0]["importe"];
		$importe2 = $pae[0]["importe2"];
		
		$sql = " update ventas set "
			  ." subtotalivanove = ?, "
			  ." totaldescuentove = ?, "
			  ." totalpago= ?, "
			  ." totalpago2= ? "
			  ." where "
			  ." codventa = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaldescuentove);
		$stmt->bindParam(3, $total);
		$stmt->bindParam(4, $total2);
		$stmt->bindParam(5, $codventa);
		
		$subtotal= rount($importe,2);
		$tot= rount($subtotal+$subtotalivasive+$totalivave,2);
		$totaldescuentove= rount($tot*$descuento,2);
		$total= rount($tot-$totaldescuentove,2);
		$total2= rount($preciocompra,2);
		$codventa = strip_tags(base64_decode($_GET["codventa"]));
		$stmt->execute();
		
		                        }
		
		header("Location: detallesventas?mesage=1");
		exit;
		}
		else
		{
		
		$sql2 = "select existencia from productos where codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array(base64_decode($_GET["codproducto"])));
		$num = $stmt->rowCount();
		
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$p[] = $row;
			}
		$existenciadb = $p[0]["existencia"];
		
		###################### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN ALMACEN ############################
		$sql = " update productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$cantventa = strip_tags(base64_decode($_GET["cantventa"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$existencia = $existenciadb + $cantventa;
		$stmt->execute();
		
		###################### REALIZAMOS LA ELIMINACION DEL PRODUCTO EN KARDEX ############################
		$sql = " delete from kardex where codproceso = ? and codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$stmt->bindParam(2,$codproducto);
		$codventa = strip_tags(base64_decode($_GET["codventa"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$stmt->execute();
		
		$sql = " delete from ventas where codventa = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$codventa = base64_decode($_GET["codventa"]);
		$stmt->execute();
		
		$sql = " delete from detalleventas where coddetalleventa = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetalleventa);
		$coddetalleventa = base64_decode($_GET["coddetalleventa"]);
		$stmt->execute();
		
		header("Location: detallesventas?mesage=1");
		exit;
		       }
		}
		else
		{
			header("Location: detallesventas?mesage=2");
			exit;
		}
	}
######################################  FIN DE FUNCION PARA ELIMINAR DETALLES DE VENTAS DE PRODUCTOS ######################################

######################################  FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS DE PRODUCTOS POR FECHAS ######################################
	    public function BuscarVentasFechas() 
	       {
		self::SetNames();
		$sql ="SELECT detalleventas.codventa, cajas.nrocaja, ventas.codcaja, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave,  ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, SUM(detalleventas.cantventa) as articulos FROM (detalleventas LEFT JOIN ventas ON detalleventas.fechadetalleventa=ventas.fechaventa) 
LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? GROUP BY detalleventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS DE PRODUCTOS PARA EL RANGO DE FECHAS SELECCIONADAS</div></center>";
		exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS DE PRODUCTOS POR FECHAS ######################################

######################################  FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS DE PRODUCTOS POR FECHAS Y CAJAS ######################################
	    public function BuscarVentasCajas() 
	       {
		self::SetNames();
		$sql ="SELECT detalleventas.codventa, cajas.nrocaja, ventas.codcaja, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave,  ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.totalpago2, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, SUM(detalleventas.cantventa) as articulos FROM (detalleventas LEFT JOIN ventas ON detalleventas.fechadetalleventa=ventas.fechaventa) 
LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente WHERE ventas.codcaja = ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? GROUP BY detalleventas.codventa";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim($_GET['codcaja']));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN VENTAS DE PRODUCTOS PARA LA CAJA Y EL RANGO DE FECHAS SELECCIONADAS</div></center>";
		exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS DE PRODUCTOS POR FECHAS Y CAJAS ######################################

######################################  FUNCION PARA BUSQUEDA DE REPORTES DE PRODUCTOS FACTURADOS POR FECHAS ######################################
	    public function BuscarVentasProductos() 
	       {
		self::SetNames();
		$sql ="SELECT productos.codproducto, productos.producto, productos.codcategoria, productos.precioventa, productos.existencia, categorias.nomcategoria, SUM(detalleventas.cantventa) as cantidad FROM (productos LEFT JOIN detalleventas ON productos.codproducto=detalleventas.codproducto) 
LEFT JOIN categorias ON categorias.codcategoria=productos.codcategoria WHERE DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') <= ? GROUP BY detalleventas.codproducto, detalleventas.precioventa ORDER BY productos.codproducto ASC";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS FACTURADOS PARA EL RANGO DE FECHAS SELECCIONADAS</div></center>";
		exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE REPORTES DE PRODUCTOS FACTURADOS POR FECHAS ######################################

######################################  FUNCION PARA LISTAR VENTAS DIARIAS ######################################
	public function ListarVentasDiarias()
	{
		self::SetNames();
		
		if($_SESSION['acceso'] == "administrador") {
		
		$sql ="SELECT detalleventas.codventa, cajas.nrocaja, ventas.codcaja, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave,  ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.totalpago2, ventas.fechaventa, clientes.nomcliente, SUM(detalleventas.cantventa) as articulos FROM (detalleventas LEFT JOIN ventas ON detalleventas.fechadetalleventa=ventas.fechaventa) 
LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente WHERE DATE_FORMAT(fechaventa,'%Y-%m-%d') = '".date('Y-m-d')."' GROUP BY detalleventas.codventa";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
		 else {
		
         $sql ="SELECT detalleventas.codventa, cajas.nrocaja, ventas.codcaja, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave,  ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.totalpago2, ventas.fechaventa, clientes.nomcliente, SUM(detalleventas.cantventa) as articulos FROM (detalleventas LEFT JOIN ventas ON detalleventas.fechadetalleventa=ventas.fechaventa) 
LEFT JOIN cajas ON cajas.codcaja=ventas.codcaja LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente WHERE ventas.codigo = '".$_SESSION["codigo"]."' AND  DATE_FORMAT(fechaventa,'%Y-%m-%d') = '".date('Y-m-d')."' GROUP BY detalleventas.codventa";		
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################################  FIN DE FUNCION PARA LISTAR VENTAS DIARIAS ######################################

################################################################## FIN DE CLASE VENTAS DE PRODUCTOS   ############################################################




































################################################################ CLASE ABONOS DE CREDITOS ##################################################################

######################################  FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS ######################################
	    public function BuscarClientesAbonos() 
	       {
		self::SetNames();
		$sql ="SELECT 
  ventas.codventa, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, abonoscreditos.fechaabono, SUM(abonoscreditos.montoabono) as abonototal, clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.emailcliente, cajas.nrocaja
FROM
 (ventas LEFT JOIN abonoscreditos ON ventas.codventa=abonoscreditos.codventa) LEFT JOIN clientes ON 
 clientes.codcliente=ventas.codcliente LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE ventas.codcliente = ? AND ventas.tipopagove ='CREDITO' GROUP BY ventas.codventa";
        $stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codcliente"]) );
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN CREDITOS DE VENTAS PARA EL CLIENTE INGRESADO</div></center>";
		exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS ######################################

######################################  FUNCION PARA BUSQUEDA DE FORMULARIO PARA ABONOS DE CREDITOS ######################################
	    public function BuscaAbonosCreditos() 
	       {
		self::SetNames();
		$sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, ventas.codventa, ventas.totalpago, ventas.statusventa, abonoscreditos.codventa as codigo, abonoscreditos.fechaabono, SUM(montoabono) AS abonototal FROM (clientes INNER JOIN ventas ON clientes.codcliente = ventas.codcliente) LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa WHERE clientes.cedcliente = ? AND ventas.codventa = ? AND ventas.tipopagove ='CREDITO'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(base64_decode($_GET['cedcliente'])));
		$stmt->bindValue(2, trim(base64_decode($_GET['codventa'])));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		echo "";
		exit;
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE FORMULARIO PARA ABONOS DE CREDITOS ######################################

######################################  FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS POR ID ######################################
	    public function AbonosCreditosId() 
	       {
		self::SetNames();
		$sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, ventas.codventa, ventas.totalpago, ventas.statusventa, abonoscreditos.codventa as codigo, abonoscreditos.fechaabono, SUM(montoabono) AS abonototal FROM (clientes INNER JOIN ventas ON clientes.codcliente = ventas.codcliente) LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa WHERE abonoscreditos.codabono = ? AND clientes.cedcliente = ? AND ventas.codventa = ? AND ventas.tipopagove ='CREDITO'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(base64_decode($_GET['codabono'])));
		$stmt->bindValue(2, trim(base64_decode($_GET['cedcliente'])));
		$stmt->bindValue(3, trim(base64_decode($_GET['codventa'])));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		echo "";
		exit;
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE ABONOS DE CREDITOS POR ID ######################################

###################################### FUNCION PARA REGISTRAR DEVOLUCIONES DE PRODUCTOS ######################################
	public function RegistrarAbonos()
	{
		self::SetNames();
		if(empty($_POST["codcliente"]) or empty($_POST["codventa"]) or empty($_POST["montoabono"]))
		{
			echo "1";
			exit;
		}
		
		if($_POST["montoabono"] > $_POST["totaldebe"])
		{
			echo "2";
			exit;
			
		} else {
		
		$query = " insert into abonoscreditos values (null, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $montoabono);
		$stmt->bindParam(4, $fechaabono);
		$stmt->bindParam(5, $codigo);
	    
		$codventa = strip_tags($_POST["codventa"]);
		$codcliente = strip_tags($_POST["codcliente"]);
		$montoabono = strip_tags($_POST["montoabono"]);
		$fechaabono = strip_tags(date("Y-m-d h:i:s"));
		$codigo = strip_tags($_SESSION["codigo"]);
		$stmt->execute();
		
		############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################
		if($_POST["montoabono"] == $_POST["totaldebe"]) {
				
		$sql = " update ventas set "
			  ." statusventa = ? "
			  ." where "
			  ." codventa = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $statusventa);
		$stmt->bindParam(2, $codventa);
	    
		$codventa = strip_tags($_POST["codventa"]);
		$statusventa = strip_tags("PAGADA");
		$stmt->execute();
													    }
	
		echo "<div class='alert alert-success'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL ABONO AL CR&Eacute;DITO DE FACTURA FUE REGISTRADO EXITOSAMENTE <a href='reportepdf.php?codventa=".base64_encode($codventa)."&tipo=".base64_encode("TICKETCREDITOS")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Ticket' target='_black'><strong>IMPRIMIR TICKET</strong></a></div>";
		exit;
		}
	}
######################################  FIN DE FUNCION PARA REGISTRAR DEVOLUCIONES DE PRODUCTOS  ######################################

###################################### FUNCION PARA LISTAR CREDITOS DE VENTAS DE PRODUCTOS  ###################################### 
	public function ListarCreditos()
	{
		self::SetNames();
		//$sql ="SELECT * FROM ventas LEFT JOIN clientes ON ventas.codcliente=clientes.codcliente WHERE ventas.tipopagove = 'CREDITO'";
		$sql ="SELECT 
  ventas.codventa, ventas.totalpago, ventas.statusventa, abonoscreditos.fechaabono, SUM(abonoscreditos.montoabono) as abonototal, clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.emailcliente, cajas.nrocaja
FROM
 (ventas LEFT JOIN abonoscreditos ON ventas.codventa=abonoscreditos.codventa) LEFT JOIN clientes ON 
 clientes.codcliente=ventas.codcliente LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE ventas.tipopagove ='CREDITO' GROUP BY ventas.codventa";
 
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
######################################  FIN DE FUNCION PARA LISTAR CREDITOS DE VENTAS DE PRODUCTOS ###################################### 

################################################ FUNCION PARA MOSTRAR CREDITOS DE VENTAS POR CODIGO ################################################
public function CreditosPorId()
	{
		self::SetNames();
		$sql = " SELECT clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.direccliente, clientes.emailcliente, ventas.codventa, ventas.codserieve, ventas.codautorizacionve, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.tipopagove, ventas.formapagove, ventas.fechaventa, ventas.fechavencecredito, ventas.statusventa, usuarios.nombres, cajas.nrocaja, abonoscreditos.codventa as cod, abonoscreditos.fechaabono, SUM(montoabono) AS abonototal FROM (clientes INNER JOIN ventas ON clientes.codcliente = ventas.codcliente) LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo WHERE ventas.codventa =? GROUP BY cod";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codventa"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR CREDITOS DE VENTAS POR CODIGO ################################################

################################################ FUNCION PARA MOSTRAR DETALLES DE CREDITOS ################################################
public function VerDetallesCreditos()
	{
		self::SetNames();
		$sql = " select * FROM abonoscreditos INNER JOIN ventas ON abonoscreditos.codventa = ventas.codventa WHERE abonoscreditos.codventa = ?";	
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(base64_decode($_GET["codventa"])));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "<center><div class='alert alert-danger'>";
		    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		    echo "<span class='fa fa-info-circle'></span> NO EXISTEN ABONOS PARA CR&Eacute;DITOS ACTUALMENTE</div></center>";
		    exit;
		}
		else
		{
		
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE CREDITOS ################################################

######################################  FUNCION PARA BUSQUEDA DE CREDITOS POR FECHAS ######################################
	    public function BuscarCreditosFechas() 
	       {
		self::SetNames();
		$sql ="SELECT 
  ventas.codventa, ventas.totalpago, ventas.fechavencecredito, ventas.statusventa, ventas.fechaventa, abonoscreditos.fechaabono, SUM(abonoscreditos.montoabono) as abonototal, clientes.codcliente, clientes.cedcliente, clientes.nomcliente, clientes.tlfcliente, clientes.emailcliente, cajas.nrocaja
FROM
 (ventas LEFT JOIN abonoscreditos ON ventas.codventa=abonoscreditos.codventa) LEFT JOIN clientes ON 
 clientes.codcliente=ventas.codcliente LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? AND ventas.tipopagove ='CREDITO' GROUP BY ventas.codventa";
        $stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN CREDITOS DE VENTAS PARA EL RANGO DE FECHA INGRESADO</div></center>";
		exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE CREDITOS POR FECHAS ######################################

################################################################  FIN DE CLASE ABONOS DE CREDITOS  ##################################################################
















































##################################################################  CLASE DEVOLUCIONES DE PRODUCTOS   ############################################################

###################################### FUNCION PARA CODIGO DE DEVOLUCIONES ######################################
	public function CodigoDevolucion()
	{
    
	self::SetNames();		
    $sql = " select coddevolucion from devoluciones where codigo = '".$_SESSION["codigo"]."' and DATE_FORMAT(fechadevolucion,'%Y-%m-%d') = '".date("Y-m-d")."' order by coddevolucion desc limit 1";
	foreach ($this->dbh->query($sql) as $row){

     $year= date("Y");
     $mes= date("m");
     $day= date("d"); 
     $coddevolucion["coddevolucion"]=$row["coddevolucion"];
      }
          if(empty($coddevolucion["coddevolucion"]))
           {
              echo $factura = date("Y").'-'.date("m").''.date("d").'-'.'D0001';
     }else
           {
               $num     = substr($coddevolucion["coddevolucion"] , 11);
               $dig     = $num + 1;
               $cod = str_pad($dig, 4, "0", STR_PAD_LEFT);
			   echo $factura = $year.'-'.$mes.''.$day.'-D'.$cod;
         }
				 }
###################################### FIN DE FUNCION PARA CODIGO DE DEVOLUCIONES ######################################



###################################### FUNCION PARA REGISTRAR DEVOLUCIONES DE PRODUCTOS ######################################
	public function RegistrarDevoluciones()
	{
		self::SetNames();
		if(empty($_POST["coddevolucion"]) or empty($_POST["codproveedor"]) or empty($_POST["fecharegistro"]))
		{
			echo "1";
			exit;
		}
		
		if(empty($_SESSION["CarritoDevolucion"]))
		{
			echo "2";
			exit;
			
		} else {
		
		$query = " insert into devoluciones values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $coddevolucion);
		$stmt->bindParam(2, $codcaja);
		$stmt->bindParam(3, $codproveedor);
		$stmt->bindParam(4, $subtotald);
		$stmt->bindParam(5, $ivad);
		$stmt->bindParam(6, $totalivad);
		$stmt->bindParam(7, $totald);
		$stmt->bindParam(8, $fechadevolucion);
		$stmt->bindParam(9, $codigo);
	    
		$coddevolucion = strip_tags($_POST["coddevolucion"]);
		$codcaja = strip_tags($_POST["codcaja"]);
		$codproveedor = strip_tags($_POST["codproveedor"]);
		$subtotald = strip_tags($_POST["txtsubtotal"]);
		$ivad = strip_tags($_POST["iva"]);
		$totalivad = strip_tags($_POST["txtIva"]);
		$totald = strip_tags($_POST["txtTotal"]);
		$fechadevolucion = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$codigo = strip_tags($_SESSION["codigo"]);
		$stmt->execute();
		
		$devolucion = $_SESSION["CarritoDevolucion"];
		for($i=0;$i<count($devolucion);$i++){
		
		$query = " insert into detalledevolucion values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $coddevolucion);
		$stmt->bindParam(2, $codproveedor);
	    $stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $producto);
		$stmt->bindParam(5, $codcategoria);
		$stmt->bindParam(6, $cantidad);
		$stmt->bindParam(7, $lote);
		$stmt->bindParam(8, $precio);
		$stmt->bindParam(9, $importe);
		$stmt->bindParam(10, $fechadetalledevolucion);
		$stmt->bindParam(11, $codigo);
			
		$coddevolucion = strip_tags($_POST['coddevolucion']);
		$codproveedor = strip_tags($_POST["codproveedor"]);
		$codproducto = strip_tags($devolucion[$i]['txtCodigo']);
		$producto = strip_tags($devolucion[$i]['descripcion']);
		$codcategoria = strip_tags($devolucion[$i]['tipo']);
		$cantidad = strip_tags($devolucion[$i]['cantidad']);
		$lote = strip_tags($devolucion[$i]['lote']);
		$precio = strip_tags($devolucion[$i]['precio']);
		$importe = strip_tags($devolucion[$i]['cantidad'] * $devolucion[$i]['precio']);
		$fechadetalledevolucion = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$codigo = strip_tags($_SESSION['codigo']);
		$stmt->execute();
		
		$sql = " update productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = '".$devolucion[$i]['txtCodigo']."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$existencia = $devolucion[$i]['existencia' ] - $devolucion[$i]['cantidad'];
		$stmt->execute();
		
		$sql = " delete from detalledevolucion where coddevolucion = ? and cantdevolucion = '0'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddevolucion);
		$coddevolucion = $_POST["coddevolucion"];
		$stmt->execute();
				
		}
		###### AQUI DESTRUIMOS TODAS LAS VARIABLES DE SESSION QUE RECIBIMOS EN CARRITO DE VENTAS ######
		unset($_SESSION["CarritoDevolucion"]);
		
		echo "<div class='alert alert-success'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> LA DEVOLUCI&Oacute;N DE PRODUCTOS FUE REGISTRADA EXITOSAMENTE <a href='reportepdf.php?coddevolucion=".base64_encode($coddevolucion)."&tipo=".base64_encode("DEVOLUCIONES")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black'><strong>IMPRIMIR FACTURA DE DEVOLUCI&Oacute;N</strong></a></div>";
		exit;
		}
	}
######################################  FIN DE FUNCION PARA REGISTRAR DEVOLUCIONES DE PRODUCTOS  ######################################



######################################   FUNCION PARA LISTAR DEVOLUCIONES DE PRODUCTOS  ###################################### 
	public function ListarDevoluciones()
	{
		self::SetNames();
	    
		if($_SESSION['acceso'] == "administrador") {
		
		//$sql = " SELECT ventas.codventa, ventas.subtotalivasive, ventas.subtotalivanove, ventas.ivave, ventas.totalivave, ventas.descuentove, ventas.totaldescuentove, ventas.totalpago, ventas.statusventa, ventas.fechaventa, clientes.nomcliente, cajas.nrocaja, SUM(detalleventas.cantventa) AS articulos FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente) INNER JOIN usuarios ON ventas.codigo = usuarios.codigo INNER JOIN cajas ON ventas.codcaja = cajas.codcaja LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa GROUP BY ventas.codventa";
		
		
		$sql = " select * from devoluciones, cajas, proveedores, usuarios where devoluciones.codproveedor = proveedores.codproveedor and devoluciones.codigo = usuarios.codigo and devoluciones.codcaja = cajas.codcaja";
       foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}  else {
		
		$sql = " select * from devoluciones, cajas, proveedores, usuarios where devoluciones.codigo = ".$_SESSION["codigo"]." and devoluciones.codproveedor = proveedores.codproveedor and devoluciones.codigo = usuarios.codigo and devoluciones.codcaja = cajas.codcaja";
		
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################################  FIN DE FUNCION PARA LISTAR DEVOLUCIONES DE PRODUCTOS ######################################


######################################  FUNCION PARA LISTAR DETALLES DE DEVOLUCIONES DE PRODUCTOS ######################################
	public function ListarDetallesDevoluciones()
	{
		self::SetNames();
		
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " select * from detalledevolucion, categorias where detalledevolucion.codcategoria = categorias.codcategoria";
		
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
		 else {
		
				$sql = " select * from detalledevolucion, categorias where detalledevolucion.codigo = ".$_SESSION["codigo"]." and detalledevolucion.codcategoria = categorias.codcategoria";
		
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################################  FIN DE FUNCION PARA LISTAR DETALLES DE DEVOLUCIONES DE PRODUCTOS ######################################

################################################ FUNCION PARA MOSTRAR DEVOLUCIONES DE PRODUCTOS POR CODIGO ################################################
public function DevolucionesPorId()
	{
		self::SetNames();
		$sql = " select * from devoluciones, cajas, proveedores, usuarios where devoluciones.coddevolucion = ? and devoluciones.codproveedor = proveedores.codproveedor and devoluciones.codigo = usuarios.codigo and devoluciones.codcaja = cajas.codcaja";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["coddevolucion"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch())
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA DEVOLUCIONES DE PRODUCTOS POR CODIGO ################################################


################################################ FUNCION PARA MOSTRAR DETALLES DE DEVOLUCIONES POR CODIGO N# 1 ################################################
public function VerDetallesDevoluciones()
	{
		self::SetNames();
		$sql = " select * from detalledevolucion, categorias where detalledevolucion.coddevolucion = ? and detalledevolucion.codcategoria = categorias.codcategoria";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(base64_decode($_GET["coddevolucion"])));
		$stmt->execute();
		$num = $stmt->rowCount();
		
			while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
################################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE DEVOLUCIONES POR CODIGO N# 1 ################################################


################################################ FUNCION PARA MOSTRAR DETALLES DE DEVOLUCIONES POR CODIGO N# 2 ################################################
public function DetallesDevolucionesPorId()
	{
		self::SetNames();
		$sql = " select * from detalledevolucion, categorias, productos, proveedores where detalledevolucion.coddetalledevolucion = ? and detalledevolucion.codcategoria = categorias.codcategoria and detalledevolucion.codproducto = productos.codproducto and detalledevolucion.codproveedor = proveedores.codproveedor";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["coddetalledevolucion"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch())
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE DEVOLUCIONES POR CODIGO N# 2 ################################################



################################################  FUNCION PARA ACTUALIZAR DEVOLUCIONES DE PRODUCTOS ################################################
	public function ActualizarDetallesDevoluciones()
	{
		self::SetNames();
		if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["cantdevolucion"]))
		{
			echo "1";
		    exit;
		}
		
		$sql2 = " select cantdevolucion from detalledevolucion where coddetalledevolucion = ? and coddevolucion = ? ";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($_POST["coddetalledevolucion"], $_POST["coddevolucion"]) );
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch())
			{
				$pa[] = $row;
			}
		$pea = $pa[0]["cantdevolucion"];
		
		$sql = " update detalledevolucion set "
			  ." cantdevolucion = ?, "
			  ." lotedevolucion = ?, "
			  ." preciodevolucion = ?, "
			  ." importe = ? "
			  ." where "
			  ." coddetalledevolucion = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $cantdevolucion);
		$stmt->bindParam(2, $lotedevolucion);
		$stmt->bindParam(3, $preciodevolucion);
		$stmt->bindParam(4, $importe);
		$stmt->bindParam(5, $coddetalledevolucion);
		
		$cantdevolucion = strip_tags($_POST["cantdevolucion"]);
		$lotedevolucion = strip_tags($_POST["lote"]);
		$preciodevolucion = strip_tags($_POST["preciodevolucion"]);
		$importe = strip_tags($_POST["importe"]);
		$coddetalledevolucion = strip_tags($_POST["coddetalledevolucion"]);
		$stmt->execute();
		
		$sql2 = " update productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $nombre);
		$stmt->bindParam(2, $codproducto);
		
		$codproducto = strip_tags($_POST["codproducto"]);
		$cantidad = strip_tags($_POST["cantdevolucion"]);
		$pe = strip_tags($_POST["existencia"]);
		$can=$cantidad - $pea;
		$nombre = $pe - $can;
		$stmt->execute();
		
		$sql3 = "select sum(importe) as importe from detalledevolucion where coddevolucion = ? ";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array($_POST["coddevolucion"]));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch())
			{
				$pae[] = $row;
			}
			$importe = $pae[0]["importe"];
			
	    $sql4 = "select ivad from devoluciones where coddevolucion = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array($_POST["coddevolucion"]) );
		$num = $stmt->rowCount();

			if($row = $stmt->fetch())
			{
				$paea[] = $row;
			}
			$iva = $paea[0]["ivad"]/100;
			
		$sql = " update devoluciones set "
			  ." subtotald = ?, "
			  ." totalivad = ?, "
			  ." totald= ? "
			  ." where "
			  ." coddevolucion = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaliva);
		$stmt->bindParam(3, $total);
		$stmt->bindParam(4, $coddevolucion);
		
		$subtotal= rount($importe,2);
        $totaliva= rount($subtotal*$iva,2);
		$total= rount($subtotal+$totaliva,2);
		$coddevolucion = strip_tags($_POST["coddevolucion"]);
		$stmt->execute();

        echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL DETALLE DE DEVOLUCI&Oacute;N DE PRODUCTO FUE ACTUALIZADO EXITOSAMENTE </div>"; // wrong details
		exit;
		
	}
################################################ FIN DE FUNCION PARA ACTUALIZAR DEVOLUCIONES DE PRODUCTOS ################################################


######################################  FUNCION PARA ELIMINAR DETALLES DE DEVOLUCIONES DE PRODUCTOS  ######################################
public function EliminarDetallesDevoluciones()
	{
		if($_SESSION['acceso'] == "administrador") {
		
		self::SetNames();
		$sql = " select * from detalledevolucion where coddevolucion = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["coddevolucion"])) );
		$num = $stmt->rowCount();
		if($num > 1)
		{
		
		$sql2 = "select existencia from productos where codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array(base64_decode($_GET["codproducto"])));
		$num = $stmt->rowCount();
		
			if($row = $stmt->fetch())
			{
				$p[] = $row;
			}
		$existencia = $p[0]["existencia"];
		
		
		$sql = " delete from detalledevolucion where coddetalledevolucion = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetalleventa);
		$coddetalleventa = base64_decode($_GET["coddetalledevolucion"]);
		$stmt->execute();
		
		$sql = " update productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $totalexiste);
		$stmt->bindParam(2, $codproducto);
		$cantdevolucion = strip_tags(base64_decode($_GET["cantdevolucion"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$totalexiste = $existencia + $cantdevolucion;
		$stmt->execute();
		
		$sql3 = "select sum(importe) as importe from detalledevolucion where coddevolucion = ?";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array(base64_decode($_GET["coddevolucion"])));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch())
			{
				$pae[] = $row;
			}
		$importe = $pae[0]["importe"];
			
			
		$sql4 = "select ivad from devoluciones where coddevolucion = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array(base64_decode($_GET["coddevolucion"])) );
		$num = $stmt->rowCount();

			if($row = $stmt->fetch())
			{
				$paea[] = $row;
			}
		$iva = $paea[0]["ivad"]/100;
	
		$sql = " update devoluciones set "
			  ." subtotald = ?, "
			  ." totalivad = ?, "
			  ." totald= ? "
			  ." where "
			  ." coddevolucion = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaliva);
		$stmt->bindParam(3, $total);
		$stmt->bindParam(4, $coddevolucion);
		
		$subtotal= rount($importe,2);
        $totaliva= rount($subtotal*$iva,2);
		$total= rount($subtotal+$totaliva,2);
		$coddevolucion = strip_tags(base64_decode($_GET["coddevolucion"]));
		$stmt->execute();
		
		header("Location: detallesdevolucion?mesage=1");
		exit;
		   
		}
		else
		{
		
		$sql2 = "select existencia from productos where codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array(base64_decode($_GET["codproducto"])));
		$num = $stmt->rowCount();
		
			if($row = $stmt->fetch())
			{
				$p[] = $row;
			}
		$existencia = $p[0]["existencia"];
		
		$sql = " update productos set "
			  ." existencia = ? "
			  ." where "
			  ." codproducto = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $totalexiste);
		$stmt->bindParam(2, $codproducto);
		$cantdevolucion = strip_tags(base64_decode($_GET["cantdevolucion"]));
		$codproducto = strip_tags(base64_decode($_GET["codproducto"]));
		$totalexiste = $existencia + $cantdevolucion;
		$stmt->execute();
		
		$sql = " delete from devoluciones where coddevolucion = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddevolucion);
		$coddevolucion = base64_decode($_GET["coddevolucion"]);
		$stmt->execute();
		
		$sql = " delete from detalledevolucion where coddetalledevolucion = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetalledevolucion);
		$coddetalledevolucion = base64_decode($_GET["coddetalledevolucion"]);
		$stmt->execute();
		
		header("Location: detallesdevolucion?mesage=1");
		exit;
		       }
		}
		else
		{
			header("Location: detallesdevolucion?mesage=2");
			exit;
		}
	}
######################################  FIN DE FUNCION PARA ELIMINAR DETALLES DE DEVOLUCIONES DE PRODUCTOS ######################################

######################################  FUNCION PARA BUSQUEDA DE REPORTES DE DEVOLUCIONES DE PRODUCTOS POR PROVEEDORES ######################################
	    public function BuscarDevolucionesReportes() 
	       {
		self::SetNames();
		
	    if($_SESSION['acceso'] == "administrador") {
		
		$sql = "select * from devoluciones, usuarios where devoluciones.codproveedor = ? and devoluciones.codigo = usuarios.codigo";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codproveedor"]) );
		$num = $stmt->rowCount();
		     if($num==0)
		{
		
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN DEVOLUCIONES DE PRODUCTOS PARA EL PROVEEDOR SELECCIONADO</div></center>";
		exit;
		       }
		else
		{
		while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}  else {
		
		$sql = "select * from devoluciones, usuarios where compras.codigo = ".$_SESSION["codigo"]." and devoluciones.codproveedor = ? and devoluciones.codigo = usuarios.codigo";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codproveedor"]) );
		$num = $stmt->rowCount();
		     if($num==0)
		{
		
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN DEVOLUCIONES DE PRODUCTOS PARA EL PROVEEDOR SELECCIONADO</div></center>";
		exit;
		       }
		else
		{
		while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
    }  
}
###################################### FIN DE FUNCION PARA BUSQUEDA DE REPORTES DE DEVOLUCIONES DE PRODUCTOS POR PROVEEDORES ######################################


######################################  FUNCION PARA BUSQUEDA DE DEVOLUCIONES DE COMPRAS DE PRODUCTOS POR PROVEEDORES ######################################
public function ListarComprasDevolucion() 
	       {
		self::SetNames();
		$sql ="SELECT 
  detallecompras.codproducto, detallecompras.producto, detallecompras.codcategoria, detallecompras.precio1, detallecompras.lote, categorias.nomcategoria, SUM(detallecompras.cantcompra) as compra, SUM(detalledevolucion.cantdevolucion) as devolucion, compras.codproveedor
FROM
 (detallecompras LEFT OUTER JOIN detalledevolucion ON detallecompras.codproducto=detalledevolucion.codproducto) LEFT OUTER JOIN categorias ON 
 categorias.codcategoria=detallecompras.codcategoria LEFT OUTER JOIN compras ON 
 compras.codcompra=detallecompras.codcompra LEFT OUTER JOIN productos ON 
 productos.codproducto=detallecompras.codproducto WHERE compras.codproveedor = ? GROUP BY detallecompras.codproducto, detallecompras.lote";
 
 		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array($_GET["codproveedor"]) );
		$num = $stmt->rowCount();
		     if($num==0)
		{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN DEVOLUCIONES DE COMPRAS DE PRODUCTOS PARA EL PROVEEDOR SELECCIONADO</div></center>";
		exit;
		       }
		else
		{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
    } 
###################################### FIN DE FUNCION PARA BUSQUEDA DE DEVOLUCIONES DE COMPRAS DE PRODUCTOS POR PROVEEDORES ######################################
	
########################################################### FIN DE CLASE DEVOLUCIONES DE PRODUCTOS   ############################################################





















































##################################################################  CLASE FACTURAS DE SERVICIOS ############################################################

###################################### FUNCION PARA CODIGO DE FACTURAS DE SERVICIOS ######################################
	public function CodigoServicios()
	{
     self::SetNames();
	 
	 $sql = "select codcaja from cajas where codigo = '".$_SESSION["codigo"]."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$codigo = $row['codcaja'];
		
	 $sql = " select codservicio from servicios where codigo = '".$_SESSION["codigo"]."' and DATE_FORMAT(fechaservicio,'%Y-%m-%d') = '".date("Y-m-d")."' order by codservicio desc limit 1";
	 foreach ($this->dbh->query($sql) as $row){

     $fecha= date("Y-m-d"); 
     $year= date("Y");
     $mes= date("m");
     $day= date("d"); 
     $codservicio["codservicio"]=$row["codservicio"];
	   
      }
          if(empty($codservicio["codservicio"]))
           {
              echo $factura = date("Y").'-'.date("m").''.date("d").'-'.$codigo.'-'.'0001';
     }else
           {
               $num     = substr($codservicio["codservicio"] , 12);
               $dig     = $num + 1;
               $cod = str_pad($dig, 4, "0", STR_PAD_LEFT);
			   echo $factura = $year.'-'.$mes.''.$day.'-'.$codigo.'-'.$cod;
         }
				 }
###################################### FIN DE FUNCION PARA FACTURAS DE SERVICIOS ######################################

###################################### FUNCION PARA REGISTRAR FACTURAS DE SERVICIOS ######################################
	public function RegistrarServicios()
	{
		self::SetNames();
		if(empty($_POST["codservicio"]) or empty($_POST["codcliente"]) or empty($_POST["tipopago"]))
		{
			echo "1";
			exit;
		}
		
		if(empty($_SESSION["CarritoServicios"]))
		{
			echo "2";
			exit;
			
		} else {
		
		$query = " insert into servicios values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codservicio);
		$stmt->bindParam(2, $codcaja);
		$stmt->bindParam(3, $codcliente);
		$stmt->bindParam(4, $subtotal);
		$stmt->bindParam(5, $iva);
		$stmt->bindParam(6, $totaliva);
		$stmt->bindParam(7, $descuento);
		$stmt->bindParam(8, $totaldescuento);
		$stmt->bindParam(9, $totalpago);
		$stmt->bindParam(10, $tipopago);
		$stmt->bindParam(11, $fechaservicio);
		$stmt->bindParam(12, $codigo);
	    
		$codservicio = strip_tags($_POST["codservicio"]);
		$codcaja = strip_tags($_POST["codcaja"]);
		$codcliente = strip_tags($_POST["codcliente"]);
		$subtotal = strip_tags($_POST["txtsubtotal"]);
		$iva = strip_tags($_POST["iva"]);
		$totaliva = strip_tags($_POST["txtIva"]);
		$descuento = strip_tags($_POST["descuento"]);
		$totaldescuento = strip_tags($_POST["txtDescuento"]);
		$totalpago = strip_tags($_POST["txtTotal"]);
		$tipopago = strip_tags($_POST["tipopago"]);
		$fechaservicio = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$codigo = strip_tags($_SESSION["codigo"]);
		$stmt->execute();
		
		$servicio = $_SESSION["CarritoServicios"];
		for($i=0;$i<count($servicio);$i++){
		
		$query = " insert into detalleservicios values (null, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codservicio);
		$stmt->bindParam(2, $codcliente);
	    $stmt->bindParam(3, $coditems);
		$stmt->bindParam(4, $cantservicio);
		$stmt->bindParam(5, $precioservicio);
		$stmt->bindParam(6, $importe);
		$stmt->bindParam(7, $fechadetalleservicio);
		$stmt->bindParam(8, $codigo);
			
		$codservicio = strip_tags($_POST['codservicio']);
		$codcliente = strip_tags($_POST["codcliente"]);
		$coditems = strip_tags($servicio[$i]['txtCodigo']);
		$cantservicio = strip_tags($servicio[$i]['cantidad']);
		$precioservicio = strip_tags($servicio[$i]['precio']);
		$importe = strip_tags($servicio[$i]['cantidad'] * $servicio[$i]['precio']);
		$fechadetalleservicio = strip_tags(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro'])));
		$codigo = strip_tags($_SESSION['codigo']);
		$stmt->execute();
		
		$sql = " delete from detalleservicios where codservicio = ? and cantservicio = '0'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codservicio);
		$codservicio = $_POST["codservicio"];
		$stmt->execute();
			
		}
		###### AQUI DESTRUIMOS TODAS LAS VARIABLES DE SESSION QUE RECIBIMOS EN CARRITO DE SERVICIOS ######
		unset($_SESSION["CarritoServicios"]);
		
		echo "<div class='alert alert-success'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> LA FACTURA PARA SERVICIOS FUE REGISTRADA EXITOSAMENTE <a href='reportepdf.php?codservicio=".base64_encode($codservicio)."&tipo=".base64_encode("SERVICIOS")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Factura' target='_black'><strong>IMPRIMIR FACTURA DE SERVICIOS</strong></a></div>";
		exit;
		}
	}
######################################  FIN DE FUNCION PARA REGISTRAR FACTURAS DE SERVICIOS ######################################

######################################   FUNCION PARA LISTAR FACTURAS DE SERVICIOS ###################################### 
	public function ListarServicios()
	{
		self::SetNames();
	    
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " select * from servicios, cajas, clientes, usuarios where servicios.codcliente = clientes.codcliente and servicios.codigo = usuarios.codigo and servicios.codcaja = cajas.codcaja";
       foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}  else {
		
		$sql = " select * from servicios, cajas, clientes, usuarios where servicios.codigo = ".$_SESSION["codigo"]." and servicios.codcliente = clientes.codcliente and servicios.codigo = usuarios.codigo and servicios.codcaja = cajas.codcaja";
		
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################################  FIN DE FUNCION PARA LISTAR FACTURAS DE SERVICIOS ###################################### 

######################################  FUNCION PARA LISTAR DETALLES DE FACTURAS DE SERVICIOS ######################################
	public function ListarDetallesServicios()
	{
		self::SetNames();
		
		if($_SESSION['acceso'] == "administrador") {
		
		$sql = " select * from detalleservicios, items where detalleservicios.coditems = items.coditems";
		
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
		 else {
		
				$sql = " select * from detalleservicios, items where detalleservicios.codigo = ".$_SESSION["codigo"]." and detalleservicios.coditems = items.coditems";
		
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################################  FIN DE FUNCION PARA LISTAR DETALLES DE FACTURAS DE SERVICIOS ######################################

################################################ FUNCION PARA MOSTRAR FACTURAS DE SERVICIOS POR CODIGO ################################################
public function ServiciosPorId()
	{
		self::SetNames();
		$sql = " select * from servicios, cajas, clientes, usuarios where servicios.codservicio = ? and servicios.codcliente = clientes.codcliente and servicios.codigo = usuarios.codigo and servicios.codcaja = cajas.codcaja";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codservicio"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch())
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################################################ FIN DE FUNCION PARA FACTURAS DE SERVICIOS POR CODIGO ################################################

############################################# FUNCION PARA MOSTRAR DETALLES DE FACTURAS DE SERVICIOS POR CODIGO N# 1 ############################################
public function VerDetallesServicios()
	{
		self::SetNames();
		$sql = " select * from detalleservicios, items where detalleservicios.codservicio = ? and detalleservicios.coditems = items.coditems";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(base64_decode($_GET["codservicio"])));
		$stmt->execute();
		$num = $stmt->rowCount();
		
			while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
########################################## FIN DE FUNCION PARA MOSTRAR DETALLES DE FACTURAS DE SERVICIOS POR CODIGO N# 1 #########################################

########################################## FUNCION PARA MOSTRAR DETALLES DE FACTURAS DE SERVICIOS POR CODIGO N# 2 ################################################
public function DetallesServiciosPorId()
	{
		self::SetNames();
		$sql = " select * from detalleservicios, items, clientes where detalleservicios.coddetalleservicio = ? and detalleservicios.coditems = items.coditems and detalleservicios.codcliente = clientes.codcliente";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["coddetalleservicio"])) );
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch())
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################################ FIN DE FUNCION PARA MOSTRAR DETALLES DE FACTURAS DE SERVICIOS POR CODIGO N# 2 ############################################

################################################  FUNCION PARA ACTUALIZAR FACTURAS DE SERVICIOS ################################################
		public function ActualizarDetallesServicios()
	{
		self::SetNames();
		if(empty($_POST["coditems"]) or empty($_POST["nombreitems"]) or empty($_POST["cantservicio"]))
		{
			echo "1";
		    exit;
		}
		
		$sql2 = " select cantservicio from detalleservicios where coddetalleservicio = ? and codservicio = ? ";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($_POST["coddetalleservicio"], $_POST["codservicio"]) );
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch())
			{
				$pa[] = $row;
			}
		$pea = $pa[0]["cantservicio"];
		
		$sql = " update detalleservicios set "
			  ." cantservicio = ?, "
			  ." precioservicio = ?, "
			  ." importe = ? "
			  ." where "
			  ." coddetalleservicio = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $cantservicio);
		$stmt->bindParam(2, $precioservicio);
		$stmt->bindParam(3, $importe);
		$stmt->bindParam(4, $coddetalleservicio);
		
		$cantservicio = strip_tags($_POST["cantservicio"]);
		$precioservicio = strip_tags($_POST["precioservicio"]);
		$importe = strip_tags($_POST["importe"]);
		$coddetalleservicio = strip_tags($_POST["coddetalleservicio"]);
		$stmt->execute();
		
		$sql3 = "select sum(importe) as importe from detalleservicios where codservicio = ? ";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array($_POST["codservicio"]));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch())
			{
				$pae[] = $row;
			}
			$importe = $pae[0]["importe"];
			
	    $sql4 = "select iva,descuento from servicios where codservicio = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array($_POST["codservicio"]) );
		$num = $stmt->rowCount();

			if($row = $stmt->fetch())
			{
				$paea[] = $row;
			}
			$iva = $paea[0]["iva"]/100;
			$descuento = $paea[0]["descuento"]/100;
			
		$sql = " update servicios set "
			  ." subtotal = ?, "
			  ." totaliva = ?, "
			  ." totaldescuento = ?, "
			  ." totalpago= ? "
			  ." where "
			  ." codservicio = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaliva);
		$stmt->bindParam(3, $desc);
		$stmt->bindParam(4, $total);
		$stmt->bindParam(5, $codservicio);
		
		$subtotal= rount($importe,2);
        $totaliva= rount($subtotal*$iva,2);
		$tot= rount($subtotal+$totaliva,2);
		$desc= rount($tot*$descuento,2);
		$total= rount($tot-$desc,2);
		$codservicio = strip_tags($_POST["codservicio"]);
		$stmt->execute();
		

        echo "<div class='alert alert-info'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-check-square-o'></span> EL DETALLE DE SERVICIO FUE ACTUALIZADO EXITOSAMENTE </div>"; // wrong details
		exit;
		
	}
################################################ FIN DE FUNCION PARA ACTUALIZAR FACTURAS DE SERVICIOS ################################################


######################################  FUNCION PARA ELIMINAR DETALLES DE FACTURAS DE SERVICIOS ######################################
public function EliminarDetallesServicios()
	{
		if($_SESSION['acceso'] == "administrador") {
		
		self::SetNames();
		$sql = " select * from detalleservicios where codservicio = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute( array(base64_decode($_GET["codservicio"])) );
		$num = $stmt->rowCount();
		if($num > 1)
		{
		
		$sql = " delete from detalleservicios where coddetalleservicio = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetalleservicio);
		$coddetalleservicio = base64_decode($_GET["coddetalleservicio"]);
		$stmt->execute();
		
		$sql3 = "select sum(importe) as importe from detalleservicios where codservicio = ?";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->execute( array(base64_decode($_GET["codservicio"])));
		$num = $stmt->rowCount();
		 
		 if($row = $stmt->fetch())
			{
				$pae[] = $row;
			}
		$importe = $pae[0]["importe"];
			
			
		$sql4 = "select iva, descuento from servicios where codservicio = ? ";
		$stmt = $this->dbh->prepare($sql4);
		$stmt->execute( array(base64_decode($_GET["codservicio"])) );
		$num = $stmt->rowCount();

			if($row = $stmt->fetch())
			{
				$paea[] = $row;
			}
		$iva = $paea[0]["iva"]/100;
		$descuento = $paea[0]["descuento"]/100;
	
		$sql = " update servicios set "
			  ." subtotal = ?, "
			  ." totaliva = ?, "
			  ." totaldescuento = ?, "
			  ." totalpago= ? "
			  ." where "
			  ." codservicio = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotal);
		$stmt->bindParam(2, $totaliva);
		$stmt->bindParam(3, $desc);
		$stmt->bindParam(4, $total);
		$stmt->bindParam(5, $codservicio);
		
		$subtotal= rount($importe,2);
        $totaliva= rount($subtotal*$iva,2);
		$tot= rount($subtotal+$totaliva,2);
		$desc= rount($tot*$descuento,2);
		$total= rount($tot-$desc,2);
		$codservicio = strip_tags(base64_decode($_GET["codservicio"]));
		$stmt->execute();
		
		header("Location: detallesservicios?mesage=1");
		exit;
		   
		}
		else
		{
		
		$sql = " delete from servicios where codservicio = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codservicio);
		$codservicio = base64_decode($_GET["codservicio"]);
		$stmt->execute();
		
		$sql = " delete from detalleservicios where coddetalleservicio = ? ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetalleservicio);
		$coddetalleservicio = base64_decode($_GET["coddetalleservicio"]);
		$stmt->execute();
		
		header("Location: detallesservicios?mesage=1");
		exit;
		       }
		}
		else
		{
			header("Location: detallesservicios?mesage=2");
			exit;
		}
	}
######################################  FIN DE FUNCION PARA ELIMINAR DETALLES DE FACTURAS DE SERVICIOS ######################################

######################################  FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS DE PRODUCTOS POR FECHAS ######################################
	    public function BuscarServiciosFechas() 
	       {
		self::SetNames();
		$sql ="SELECT detalleservicios.codservicio, cajas.nrocaja, servicios.codcaja, servicios.subtotal, servicios.totaliva, servicios.totaldescuento, servicios.totalpago, servicios.fechaservicio, SUM(detalleservicios.cantservicio) as cantidad FROM (detalleservicios LEFT JOIN servicios ON detalleservicios.fechadetalleservicio=servicios.fechaservicio) 
LEFT JOIN cajas ON cajas.codcaja=servicios.codcaja WHERE servicios.fechaservicio BETWEEN ? AND ? GROUP BY detalleservicios.codservicio";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN FACTURAS DE SERVICIOS PARA EL RANGO DE FECHAS SELECCIONADAS</div></center>";
		exit;
		}
		else
		{
			while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS DE PRODUCTOS POR FECHAS ######################################

######################################  FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS DE PRODUCTOS POR FECHAS Y CAJAS ######################################
	    public function BuscarServiciosCajas() 
	       {
		self::SetNames();
		$sql ="SELECT detalleservicios.codservicio, cajas.nrocaja, servicios.codcaja, servicios.subtotal, servicios.totaliva, servicios.totaldescuento, servicios.totalpago, servicios.fechaservicio, SUM(detalleservicios.cantservicio) as cantidad FROM (detalleservicios LEFT JOIN servicios ON detalleservicios.fechadetalleservicio=servicios.fechaservicio) 
LEFT JOIN cajas ON cajas.codcaja=servicios.codcaja WHERE servicios.codcaja = ? and servicios.fechaservicio BETWEEN ? AND ? GROUP BY detalleservicios.codservicio";

		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim($_GET['codcaja']));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN FACTURAS DE SERVICIOS PARA LA CAJA Y EL RANGO DE FECHAS SELECCIONADAS</div></center>";
		exit;
		}
		else
		{
			while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE REPORTES DE VENTAS DE PRODUCTOS POR FECHAS Y CAJAS ######################################

##################################### FUNCION PARA BUSQUEDA DE REPORTES DE SERVICIOS FACTURADOS POR FECHAS ######################################
	    public function BuscarServicios() 
	       {
		self::SetNames();
		$sql ="SELECT items.coditems, items.nombreitems, detalleservicios.precioservicio, SUM(detalleservicios.cantservicio) as cantidad FROM items LEFT JOIN detalleservicios ON items.coditems=detalleservicios.coditems  WHERE detalleservicios.fechadetalleservicio BETWEEN ? AND ? GROUP BY detalleservicios.coditems, detalleservicios.precioservicio ORDER BY detalleservicios.precioservicio ASC";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO EXISTEN SERVICIOS FACTURADOS PARA EL RANGO DE FECHAS SELECCIONADAS</div></center>";
		exit;
		}
		else
		{
			while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################################### FIN DE FUNCION PARA BUSQUEDA DE REPORTES DE SERVICIOS FACTURADOS POR FECHAS ######################################

################################################################## FIN DE CLASE FACTURAS DE SERVICIOS ############################################################



























######################################  FUNCION PARA LISTAR SERVICIOS FACTURADOS DIARIOS ######################################
	public function ListarServiciosDiarias()
	{
		self::SetNames();
		
		if($_SESSION['acceso'] == "administrador") {
		
		$sql ="SELECT detalleservicios.codservicio, cajas.nrocaja, servicios.codcaja, servicios.subtotal, servicios.totaliva, servicios.totaldescuento, servicios.totalpago, servicios.fechaservicio, SUM(detalleservicios.cantservicio) as cantidad FROM (detalleservicios LEFT JOIN servicios ON detalleservicios.fechadetalleservicio=servicios.fechaservicio) 
LEFT JOIN cajas ON cajas.codcaja=servicios.codcaja WHERE DATE_FORMAT(fechaservicio,'%Y-%m-%d') = '".date('Y-m-d')."' GROUP BY detalleservicios.codservicio";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
		 else {
		
         $sql ="SELECT detalleservicios.codservicio, cajas.nrocaja, servicios.codcaja, servicios.subtotal, servicios.totaliva, servicios.totaldescuento, servicios.totalpago, servicios.fechaservicio, SUM(detalleservicios.cantservicio) as cantidad FROM (detalleservicios LEFT JOIN servicios ON detalleservicios.fechadetalleservicio=servicios.fechaservicio) 
LEFT JOIN cajas ON cajas.codcaja=servicios.codcaja WHERE servicios.codigo = '".$_SESSION["codigo"]."' and DATE_FORMAT(fechaservicio,'%Y-%m-%d') = '".date('Y-m-d')."' GROUP BY detalleservicios.codservicio";	
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################################  FIN DE FUNCION PARA LISTAR SERVICIOS FACTURADOS DIARIOS ######################################

################################################ CLASE CONSULTAS PARA GRAFICOS DE VENTAS POR MESES ###################################################

public function GraficoVentas()
	{
$year = date('Y');

if($_SESSION['acceso'] == "administrador") {

$sql = "SELECT COUNT(*) as total, MONTH(fechaventa) as totalmes from ventas WHERE YEAR(fechaventa) = '".$year."' GROUP BY MONTH(fechaventa)";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	  } else {
	
$sql = "SELECT COUNT(*) as total, MONTH(fechaventa) as totalmes from ventas WHERE codigo = '".$_SESSION["codigo"]."' and YEAR(fechaventa) = '".$year."' GROUP BY MONTH(fechaventa)";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}	
################################################ CLASE CONSULTAS PARA GRAFICOS DE VENTAS POR MESES ###################################################

	

################################################ CLASE CONSULTAS PARA GRAFICOS DE SERVICIOS POR MESES ###################################################

public function GraficoServicios()
	{
$year = date('Y');

if($_SESSION['acceso'] == "administrador") {

$sql = "SELECT COUNT(*) as total, MONTH(fechaservicio) as totalmes from servicios WHERE YEAR(fechaservicio) = '".$year."' GROUP BY MONTH(fechaservicio)";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	  } else {
	
$sql = "SELECT COUNT(*) as total, MONTH(fechaservicio) as totalmes from servicios WHERE codigo = '".$_SESSION["codigo"]."' and YEAR(fechaservicio) = '".$year."' GROUP BY MONTH(fechaservicio)";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}	
################################################ CLASE CONSULTAS PARA GRAFICOS DE SERVICIOS POR MESES ###################################################











}
#################################################### AQUI TERMINA LA CLASE LOGIN ######################################################
?>