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

$orden = array('nombre');
$instituciones = OperaBD::selec('datos.instituciones',array('idinstituciones as id','nombre as text'),null,null,$orden);
$institucionesjson = json_encode($instituciones);

header('Content-type:application/json;charset=utf-8');
echo $institucionesjson;

 ?>
