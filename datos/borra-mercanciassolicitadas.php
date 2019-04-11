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
  $carta = $_SESSION['carta'];
  $where = array('idmercanciasybienes' => filter_var($_GET['id'],FILTER_SANITIZE_STRING));
  OperaBD::borra('datos.mercanciasybienes',$where);

  header('location:../cartas.php?p=mercanciassolicitadas');

?>
