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
foreach ($_POST['viajeros'] as $key => $idviajero) {
  $idsviajeros[] =  $idviajero;
}
$carta=$_SESSION['carta'];
$viaje = new Viaje(true,$_POST);
$viaje->almacena();
$carta->setViaje($viaje->idviajes);
$viaje->setViajeros($idsviajeros);

header('location:../modif-viajes.php?id='.$viaje->idviajes);
 ?>
