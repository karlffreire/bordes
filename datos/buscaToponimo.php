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

$term = filter_var($_GET['termino'],FILTER_SANITIZE_STRING);
$idpais = filter_var($_GET['pais'],FILTER_SANITIZE_STRING);

$terminos = '';
$letras = explode(' ',strtolower(urldecode($term)));
foreach ($letras as $key => $letra) {
  $terminos .= "unaccent(lower(toponimo)) like unaccent('%".$letra."%') and ";
}
$terminos_limpio = rtrim($terminos,'and ');

$mbd = ConBD::conectaBD();
try {
  foreach ($mbd->query("SELECT toponimo as text,gid as id,idnomenclator,idexterno FROM datos.geometrias WHERE $terminos_limpio and idpaises = $idpais ORDER BY toponimo;") as $fila) {
    $resultado[] =$fila;
  }
} catch (PDOException $e) {
  echo 'Error en Base de Datos: '.$e->getMessage(); //HACER FUNCION PARA MANEJAR ERRORES
}
$topojson = json_encode($resultado);
header('Content-type:application/json;charset=utf-8');
echo $topojson;

 ?>
