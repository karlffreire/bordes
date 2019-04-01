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
$arrprop  = array('*');
$orden = array('fecha','identificador');
$cartas = OperaBD::selec('datos.cartas',$arrprop,'Carta',null,$orden);
// foreach ($cartas as $key => $carta) {
//   $carta->emisor = $carta->getEmisor();
// }
$cartasjson = json_encode($cartas);

header('Content-type:application/json;charset=utf-8');
echo  $cartasjson;


 ?>
