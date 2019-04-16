<?php
function __autoload($className) {
    $file = "./datos/modelo/".$className.'.class.php';
    if(file_exists($file)) {
        require_once $file;
    }
}
  require_once './datos/modelo/conexion.php';
  $credenciales = explode('#',$_COOKIE["bordesarch"]);
  if (!isset($_COOKIE["bordesarch"]) || $_SESSION['proyecto'] != 'bordes') {
    header('location:./entrando.php');
  }
  $menda = filter_var($credenciales[0], FILTER_SANITIZE_STRING);
  $idacontecimiento = filter_var($_GET['id'],FILTER_SANITIZE_STRING);
  $acontecimiento = OperaBD::selec('datos.acontecimiento', array('*'),'Acontecimiento',array('idacontecimiento'=>$idacontecimiento))[0];
  $_SESSION['acontecimiento'] = $acontecimiento;
 ?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Persona</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/estilo_index.css">
    <script type="text/javascript" src="./js/funBordes.js"></script>
    <script type="text/javascript">
    function ponAcontecimiento(){
      $('#boton-accion').removeClass('btn-success').addClass('btn-warning');
      $('#nombre').val(<?php echo '"'.$acontecimiento->nombre.'"' ?>);
      $('#fecha').val(<?php echo '"'.$acontecimiento->fecha.'"' ?>);
      $('select#confianzafecha').val(<?php echo '"'.$acontecimiento->confianzafecha.'"' ?>);
    }
    function ponValLugares(){
      $('select#lugar-existente').val(<?php echo '"'.$acontecimiento->lugar.'"' ?>);
    }
    </script>
  </head>
  <body onload="javascript:cargaPaises(ponSelPais);cargaLugares(ponSelLugares,true);ponAcontecimiento();">
    <?php
      $cabecera = str_replace('%menda%', $menda, file_get_contents('./plantillas/cabecera.html'));
      echo $cabecera;
    ?>
    <div class="container" style="margin-top:6em;">
    <?php
      $fichaacontecimiento = file_get_contents('./plantillas/ficha-acontecimiento.html');
      $nuevoacontecimiento = str_replace(array('%acontecimiento%','%accion%','%fa%'),array('Nuevo acontecimiento','./datos/modificaacontecimiento.php','fa-edit'),$fichaacontecimiento);
      echo $nuevoacontecimiento;
    ?>
    </div>
    <?php
    $pie = file_get_contents('./plantillas/pie.html');
    echo $pie;

      ?>
  </body>
</html>
