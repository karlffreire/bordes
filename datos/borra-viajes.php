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
  $where = array('idviajes' => filter_var($_GET['id'],FILTER_SANITIZE_STRING));
  $viaje = OperaBD::selec('datos.viajes',array('*'),'Viaje',$where)[0];
  $resultado = $viaje->borra();
  if ($resultado) {
    echo '<script type="text/javascript">if (confirm("'.$resultado.'") == true) {window.location.href = "../viajes.php";} else {window.location.href = "../viajes.php";}</script>';
   }
  else {
    header('location:../viajes.php');
  }
?>
