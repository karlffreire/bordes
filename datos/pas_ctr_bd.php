<?php
require '../datos/modelo/conexion.php';
//SEGUNDA Y ÚLTIMA COMPROBACIÓN, SI EL USUARIO SE PUEDE CONECTAR A LA BASE DE DATOS Y ES DEL PROYECTO, PASAAMOS A index.php
$credenciales = explode('#',$_COOKIE["bordesarch"]);
$usbordes = false;
$grupos = ConBD::miembroDe($credenciales[0]);
foreach ($grupos as $grupo) {
    if ($grupo == 'lector_bordes' || $grupo == 'editor_bordes'){
    	$usbordes = true;
    }
};
if ($usbordes) {
	header('location: ../index.php');
}
else {
	header('location: ../entrando.php?fallo=ident');
}
