<?php
function __autoload($className) {
    $file = "./modelo/".$className.'.class.php';
    if(file_exists($file)) {
        require_once $file;
    }
}
  require_once './modelo/conexion.php';
  $credenciales = explode('#',$_COOKIE["bordesarch"]);
  if (!isset($_COOKIE["bordesarch"]) || $_SESSION['proyecto'] != 'bordes') {
    header('location:../entrando.php');
  }

foreach ($_POST as $key => $value) {
  if($value=="") {
    $_POST[$key] = NULL;
  }
}
$carta = new Carta(false,array_filter($_POST));
$carta->idcartas = filter_var($_SESSION['carta']->idcartas,FILTER_SANITIZE_STRING);
if (isset($_POST['lugaremision-existente'])) {
  $carta->setLugarEmision($_POST['lugaremision-existente'],false);
}
else if (!isset($_POST['lugaremision-existente'])){
  $lugar = array('nombre' =>$_POST['lugaremision-nuevo'] ,'tipolugar'=>$_POST['tipolugar-emi'],'gid'=>$_POST['geomemision'] );
  $carta->setLugarEmision($lugar,true);
}
if (isset($_POST['lugarrecepcion-existente'])) {
  $carta->setLugarRecepcion($_POST['lugarrecepcion-existente'],false);
}
else if (!$_POST['lugarrecepcion-existente']) {
  $lugar = array('nombre' =>$_POST['lugarrecepcion-nuevo'] ,'tipolugar'=>$_POST['tipolugar-rec'],'gid'=>$_POST['geomrecepcion'] );
  $carta->setLugarRecepcion($lugar,true);
}

$carta->modifica();

header('location:../principal.php?p=cartas&f=');
 ?>
