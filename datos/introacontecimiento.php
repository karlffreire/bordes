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
$acontecimiento = new Acontecimiento(true,$_POST);
if (isset($_POST['lugar-existente'])) {
  $acontecimiento->lugar = $_POST['lugar-existente'];
}
else if (isset($_POST['lugar-nuevo'])){
  $lugar = array('nombre' =>$_POST['lugar-nuevo'] ,'tipolugar'=>$_POST['tipolugar'],'gid'=>$_POST['geom'] );
  $acontecimiento->setLugar($lugar,true);
}
$acontecimiento->almacena();


header('location:../principal.php?p=acontecimientos&f=');
 ?>
