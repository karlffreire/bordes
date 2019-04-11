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
$carta = $_SESSION['carta'];
$carta->setAcontecimiento($_POST['idacontecimiento']);

header('location:../cartas.php?p=acontecimientosdescritos');
 ?>
