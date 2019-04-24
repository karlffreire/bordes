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
if (!isset($_POST['lugaremision-existente']) && !isset($_POST['lugaremision-nuevo'])) {
  //echo '<script type="text/javascript">alert("Es obligatorio rellenar el lugar de emisión");history.go(-1);</script>';
    echo '<script type="text/javascript">if (confirm("Es obligatorio rellenar el lugar de emisión") == true) {window.location.href = "javascript:history.go(-1)";} else {window.location.href = "javascript:history.go(-1)";}</script>';
}
else {
  $carta = new Carta(true,$_POST);
  if ($_POST['lugaremision-existente']) {
    $carta->setLugarEmision($_POST['lugaremision-existente'],false);
  }
  else if (isset($_POST['lugaremision-nuevo'])){
    $lugar = array('nombre' =>$_POST['lugaremision-nuevo'] ,'tipolugar'=>$_POST['tipolugar-emi'],'gid'=>$_POST['geomemision'] );
    $carta->setLugarEmision($lugar,true);
  }
  if ($_POST['lugarrecepcion-existente']) {
    $carta->setLugarRecepcion($_POST['lugarrecepcion-existente'],false);
  }
  else if (isset($_POST['lugarrecepcion-nuevo'])) {
    $lugar = array('nombre' =>$_POST['lugarrecepcion-nuevo'] ,'tipolugar'=>$_POST['tipolugar-rec'],'gid'=>$_POST['geomrecepcion'] );
    $carta->setLugarRecepcion($lugar,true);
  }

  $carta->almacena();

  header('location:../modif-cartas.php?id='.$carta->idcartas);
}
 ?>
