<?php
require '../datos/conexion.php';
require '../datos/modelo.php';

$menda = filter_var($_POST['usr'], FILTER_SANITIZE_STRING);
$contra = filter_var($_POST['ctr'],FILTER_SANITIZE_STRING);

if ($menda == 'postgres') {
	header('location: ../entrando.php?fallo=su');
}
else {
	$prueba = conectaBDSinSesion($menda,$contra);
	$usedired = false;
	$grupos = miembroDe($menda);
	foreach ($grupos as $grupo) {
	    if ($grupo == 'lector_bordes' || $grupo == 'editor_bordes'){
	    	$usedired = true;
	    }
	};
	if ($prueba && $usedired) {
		header('location: ../index.php');
		pg_close($prueba);
	}
	else {
		header('location: ../entrando.php?fallo=ident');
	}
}
