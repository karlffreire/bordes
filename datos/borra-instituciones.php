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
  $where = array('idinstituciones' => filter_var($_GET['id'],FILTER_SANITIZE_STRING));
  $institucion = OperaBD::selec('datos.instituciones',array('*'),'Institucion',$where)[0];
  $resultado = $institucion->borra();
  if ($resultado) {
    echo '<script type="text/javascript">if (confirm("'.$resultado.'") == true) {window.location.href = "../principal.php?p=instituciones&f=";} else {window.location.href = "../principal.php?p=instituciones&f=";}</script>';
   }
  else {
    header('location:../principal.php?p=instituciones&f=');
  }
?>
