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

$orden = array('nombre');
$personas = OperaBD::selec('datos.personas',array("idpersonas as id","nombre ||' '||apellidos as text"),null,null,$orden);
$personasjson = json_encode($personas);

header('Content-type:application/json;charset=utf-8');
echo $personasjson;

 ?>
