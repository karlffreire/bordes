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
$persona = new Persona(false,array_filter($_POST));
$persona->idpersonas = filter_var($_POST['idpersonas'],FILTER_SANITIZE_STRING);
$persona->modifica();

header('location:../principal.php?p=personas&f=');
 ?>
