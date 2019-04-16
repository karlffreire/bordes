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
$forzar = $_GET['forzar'];
if ($forzar == 'true') {
  $persona = new Persona(true,$_SESSION['nuevapersona']);
  $persona->almacena();
  unset($_SESSION['nuevapersona']);
  header('location:../modif-personas.php?id='.$persona->idpersonas);
}
else{
  $repes = OperaBD::selec('datos.personas',array('idpersonas'),null,array('nombre'=>$_POST['nombre'],'apellidos'=>$_POST['apellidos']), null,'AND');
  if (count($repes)>0) {
    $_SESSION['nuevapersona'] = $_POST;
    echo '<script type="text/javascript">if (confirm("Existe otra persona con ese nombre\n¿Deseas continuar?") == true) {window.location.href = "./intropersona.php?forzar=true";} else {window.location.href = "../principal.php?p=personas&f=";}</script>';

  }
  else{
    $persona = new Persona(true,$_POST);
    $persona->almacena();
    header('location:../modif-personas.php?id='.$persona->idpersonas);
  }
}

 ?>
