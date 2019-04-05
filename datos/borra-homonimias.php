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
    header('location:./entrando.php');
  }
  $where = array('idhomonimias' => filter_var($_GET['id'],FILTER_SANITIZE_STRING));
  OperaBD::borra('datos.homonimias',$where);

  header('location:../personas.php?p=homonimias');

?>
