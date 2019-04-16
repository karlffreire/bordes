<?php
session_start();
abstract class ConBD {
	//TODOS LOS METODOS LOS DECLARO static PARA PODER ACCEDER SIN TENER QUE INSTANCIAR UN OBJETO
	public static function conectaBDSinSesion($menda,$contra){
		// REALIZAMOS UNA CONEXIÓN DE PRUEBA CON EL USUARIO INTRODUCIDO EN EL FORMULARIO DE entrando.php
		// SI FUNCIONA ALMACENAMOS USUARIO Y PASSWORD EN UNA COOKIE
		try {
	    $mbd = new PDO(	"pgsql:host={$_SESSION['host']};dbname={$_SESSION['dbname']};port={$_SESSION['port']}", $menda, $contra, array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	  } catch (Exception $e) {
			return null;
	    //die("No se pudo conectar: " . $e->getMessage());
	  }
		if ($mbd) {
			 $_SESSION['proyecto']='bordes';
			 setcookie('bordesarch',$menda.'#'.$contra.'#bordesarch', time() + (3600 * 4), "/");//pruebas
			 //setcookie('bordes',$menda.'#'.$contra.'#bordesarch', time() + (3600 * 4), "/",'usig-proyectos.cchs.csic.es');//preproducción
			$mbd = null; //cierro conexion
			return true;
		}
		return false;
	}

	public static function conectaBD(){
	  $credenciales = explode('#',$_COOKIE["bordesarch"]);
	  try {
	    $mbd = new PDO(	"pgsql:host={$_SESSION['host']};dbname={$_SESSION['dbname']};port={$_SESSION['port']}", $credenciales[0], $credenciales[1], array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	  } catch (Exception $e) {
	    return $e->getMessage();
	  }
	  return $mbd;
	}

	public static function desconecta(){
		setcookie('bordesarch', $menda.'#'.$contra.'#bordesarch', time() - 3600, "/");//pruebas
		//setcookie('bordes', $menda.'#'.$contra.'#bordesarch', time() - 3600, "/",'usig-proyectos.cchs.csic.es');//preproducción
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), time() - 42000,$params["path"],$params["domain"],$params["secure"],$params["httponly"]);
		}
		session_destroy();
	}

	public static function miembroDe($usuario){
		$con = ConBD::conectaBD();
		$sentencia = $con->prepare("WITH RECURSIVE cte AS (SELECT oid FROM pg_roles WHERE rolname = ? UNION ALL SELECT m.roleid FROM cte JOIN pg_auth_members m ON m.member = cte.oid) SELECT pg_get_userbyid(oid) as grupo FROM cte;");
	  if ($sentencia->execute(array($usuario))) {
	    while ($fila = $sentencia->fetch()) {
	      $grupos[]=$fila["grupo"];
	    }
	  }
	  $con = null;
	  return $grupos;
	}
}
