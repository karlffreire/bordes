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

$columnas = array('pais as text','idpaises as id');
$orden = array('pais');
$paises = OperaBD::selec('datos.paises',$columnas,null,null,$orden);
$paisesjson = json_encode($paises);

header('Content-type:application/json;charset=utf-8');
//echo  '{"results":'.$paisesjson.'}';
echo $paisesjson;

 ?>
