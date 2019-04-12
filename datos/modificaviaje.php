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
$viaje = new Viaje(false,array_filter($_POST));
$viaje->idviajes = filter_var($_SESSION['viaje']->idviajes,FILTER_SANITIZE_STRING);
$viaje->modifica();
OperaBD::borra('datos.viajeros',array('idviajes' => $viaje->idviajes ));
$viaje->setViajeros($idsviajeros);

header('location:../viajes.php?');
 ?>
