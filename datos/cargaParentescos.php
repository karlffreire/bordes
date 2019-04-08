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

$orden = array('categoria');
$parecntescos = OperaBD::selec('datos.tiporelacion',array("idtiporel as id","datos.txt_relaciones(idtiporel) as text"),null,null,null);
$parecntescosjson = json_encode($parecntescos);

header('Content-type:application/json;charset=utf-8');
echo $parecntescosjson;

 ?>
