<?php

session_start();
	session_unset();
	session_destroy();
session_start();

$config = parse_ini_file('C:\wamp64\conexiones\bordes.ini');
//$config = parse_ini_file('/var/www/conexiones/bordes.ini');

$_SESSION['host']= $config['srv'];
$_SESSION['port']=  $config['prt'];
$_SESSION['dbname']= $config['bd'];

function conectaBDSinSesion($menda,$contra){

	$con = pg_connect("host=".$_SESSION['host']." port=".$_SESSION['port']." dbname=".$_SESSION['dbname']." user=".$menda." password=".$contra);

	if ($con) {
		$_SESSION['proyecto']='bordes';
		setcookie('bordes',$menda.'#'.$contra, time() + (3600 * 4), "/");//pruebas
		//setcookie('bordes',$menda.'#'.$contra, time() + (3600 * 4), "/",'usig-proyectos.cchs.csic.es');//preproducción
	}

	return $con;
}


function desconecta(){
	setcookie('bordes', $menda.'#'.$contra, time() - 3600, "/");//pruebas
	//setcookie('bordes', $menda.'#'.$contra, time() - 3600, "/",'usig-proyectos.cchs.csic.es');//preproducción
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), time() - 42000,$params["path"],$params["domain"],$params["secure"],$params["httponly"]);
	}
	session_destroy();
}
