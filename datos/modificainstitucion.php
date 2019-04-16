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
$institucion = new Institucion(false,$_POST);
$institucion->idinstituciones = filter_var($_SESSION['institucion']->idinstituciones,FILTER_SANITIZE_STRING);
if (isset($_POST['lugar-existente'])) {
  $institucion->sede = $_POST['lugar-existente'];
}
else if (!isset($_POST['lugar-existente'])) {
  $lugar = array('nombre' =>$_POST['lugar-nuevo'] ,'tipolugar'=>$_POST['tipolugar'],'gid'=>$_POST['geom'] );
  $institucion->setSede($lugar,true);
}
$institucion->modifica();

header('location:../principal.php?p=instituciones&f=');
 ?>
