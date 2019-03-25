<?php

$config = parse_ini_file('C:\wamp64\conexiones\bordes.ini');
//$config = parse_ini_file('/var/www/conexiones/bordes.ini');
//$config = parse_ini_file('/opt/lampp/conbd/bordes.ini');

session_start();
$_SESSION['host']= $config['srv'];
$_SESSION['port']=  $config['prt'];
$_SESSION['dbname']= $config['bd'];

$menda = filter_var($_POST['usr'], FILTER_SANITIZE_STRING);
$contra = filter_var($_POST['ctr'],FILTER_SANITIZE_STRING);

if ($menda == 'postgres') {
	header('location: ../entrando.php?fallo=su');
}
else {
	require '../datos/modelo/conexion.php';
	$prueba = ConBD::conectaBDSinSesion($menda,$contra);
	if ($prueba) {
		//SI SE HA PODIDO CONECTAR A LA BASE DE DATOS PASAMOS A COMPROBAR QUE EL USUARIO PERTENECE A LOS GRUPOS DE LECTURA O EDICIÓN DEL PROYECTO
		header('location: ./pas_ctr_bd.php');
	}
	else {
		header('location: ../entrando.php?fallo=ident');
	}
}
