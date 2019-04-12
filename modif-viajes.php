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
  unset($_SESSION['viaje']);
  $idviaje = array('idviajes' => filter_var($_GET['id'],FILTER_SANITIZE_STRING));
  $viaje = OperaBD::selec('datos.viajes',array('*'),'Viaje',$idviaje)[0];
  $_SESSION['viaje']=$viaje;
 ?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Viaje</title>
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
      function ponViaje(){
          $('#boton-accion').removeClass('btn-success').addClass('btn-warning');
          $('#fechainicio').val(<?php echo '"'.$viaje->fechainicio.'"'; ?>);
          $('select#confianzafechainicio').val(<?php echo '"'.$viaje->confianzafechainicio.'"'; ?>);
          $('#fechafin').val(<?php echo '"'.$viaje->fechafin.'"' ?>);
          $('select#confianzafechafin').val(<?php echo '"'.$viaje->confianzafechafin.'"'; ?>);
          $('#motivoviaje').val(<?php echo '"'.$viaje->motivoviaje.'"' ?>);
          $('#embarcaciones').val(<?php echo '"'.ltrim(rtrim($viaje->embarcaciones,'}'),'{').'"'; ?>);
          $('#observacionesdecoro').val(<?php echo '"'.$viaje->observacionesdecoro.'"'; ?>);
          $('#observaciones').val(<?php echo '"'.$viaje->observaciones.'"'; ?>);
          var honraydecoro = <?php if (isset($viaje->honraydecoro)) {
            echo json_encode($viaje->honraydecoro);
          } else {
            echo '""';
          } ?>;
          if (honraydecoro != '') {
            var arrhd = honraydecoro.replace(/{|}|"/g,'').split(',');
            $('#honraydecoro').val(arrhd).trigger('change');
          }
          var consejosviaje = <?php if (isset($viaje->consejosviaje)) {
            echo json_encode($viaje->consejosviaje);
          } else {
            echo '""';
          } ?>;
          if (consejosviaje != '') {
            var arrcv = consejosviaje.replace(/{|}|"/g,'').split(',');
            $('#consejosviaje').val(arrcv).trigger('change');
          }
          var realizado = <?php echo $viaje->realizado; ?>;//NO FUNCIONA CON FALSE O NULL
          if (realizado == 1) {
            $('#realizado').attr('checked',true);
          }
          var decoro = <?php echo $viaje->decoro; ?>;//NO FUNCIONA CON FALSE O NULL
          if (decoro == 1) {
            $('#decoro').attr('checked',true);
          }
      }
      function ponValPersonas(){
        var viajeros = <?php
          $viajeros = $viaje->getViajeros();
          if (count($viajeros)>0) {
          foreach ($viajeros as $key => $value) {
            $idviajeros[]=$value->idpersonas;
          }
          echo json_encode($idviajeros);
        } else {
          echo '""';
        } ?>;
        $('#viajeros').val(viajeros).trigger('change');
      }
    </script>
  </head>
  <body onload="cargaPersonas(ponSelPersonas,true);ponSelHonraDecoro();ponSelConsejosViaje();ponViaje();">
    <?php
      $cabecera = str_replace('%menda%', $menda, file_get_contents('./plantillas/cabecera.html'));
    //  echo $cabecera;
    ?>
    <div class="container" style="margin-top:6em;">
    <?php
      $fichaviaje = file_get_contents('./plantillas/ficha-viajes.html');
      $nuevoviaje = str_replace(array('%viaje%','%accion%','%fa%'),array('Modificar viaje','./datos/modificaviaje.php','fa-edit'),$fichaviaje);
      echo $nuevoviaje;
    ?>
    </div>
    <?php
    $pie = file_get_contents('./plantillas/pie.html');
    echo $pie;

      ?>
  </body>
</html>
