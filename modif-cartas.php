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
  $idcarta = filter_var($_GET['id'],FILTER_SANITIZE_STRING);
  $carta = OperaBD::selec('datos.cartas',array('*'),'Carta',array('idcartas'=>$idcarta))[0];
  $_SESSION['carta'] = $carta;
 ?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Carta</title>
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
      function ponCarta(){
        $('#boton-accion').removeClass('btn-success').addClass('btn-warning');
        $('#divpersonas').remove();
        $('#form-carta').append($('<input>').attr('name','idemisor').val(<?php echo '"'.$carta->idemisor.'"' ?>).hide());
        $('#form-carta').append($('<input>').attr('name','idreceptor').val(<?php echo '"'.$carta->idreceptor.'"' ?>).hide());
        $('#identificador').val(<?php echo '"'.$carta->identificador.'"' ?>);
        $('#pagina').val(<?php echo '"'.$carta->pagina.'"' ?>);
        $('#numeroregistro').val(<?php echo '"'.$carta->numeroregistro.'"' ?>);
        $('#palabrasclave').val(<?php echo '"'.ltrim(rtrim($carta->palabrasclave,'}'),'{').'"' ?>);
        $('#fecha').val(<?php echo '"'.$carta->fecha.'"' ?>);
        $('select#confianzafecha').val(<?php echo '"'.$carta->confianzafecha.'"' ?>);
        $('#asunto').val(<?php echo '"'.$carta->asunto.'"' ?>);
        $('#asuntoclave').val(<?php echo '"'.$carta->asuntoclave.'"' ?>);
        $('#urlimagen').val(<?php echo '"'.$carta->urlimagen.'"' ?>);
        $('#observacioneshonra').val(<?php echo '"'.$carta->observacioneshonra.'"' ?>);
        $('#notas').val(<?php echo '"'.$carta->notas.'"' ?>);
        var tramiteslegales = <?php if (isset($carta->tramiteslegales)) {
          echo json_encode($carta->tramiteslegales);
        } else {
          echo '""';
        } ?>;
        if (tramiteslegales != '') {
          var arrtram = tramiteslegales.replace(/{|}|"/g,'').split(',');
          $('#tramiteslegales').val(arrtram).trigger('change');
        }
      }
      function ponValLugares(){
        $('select#lugaremision-existente').val(<?php echo '"'.$carta->lugaremision.'"' ?>);
        $('select#lugarrecepcion-existente').val(<?php echo '"'.$carta->lugarrecepcion.'"' ?>);
      }
    </script>
  </head>
  <body onload="javascript:ponSelTramites();cargaPaises(ponSelPais);cargaLugares(ponSelLugares,true);ponCarta();">
    <?php
      $cabecera = str_replace('%menda%', $menda, file_get_contents('./plantillas/cabecera.html'));
      echo $cabecera;
    ?>
    <div class="container" style="margin-top:6em;">
    <?php
      $fichacarta = file_get_contents('./plantillas/ficha-cartas.html');
      $nuevacarta = str_replace(array('%carta%','%accion%','%fa%'),array('Carta de '.$carta->getEmisor()->nombre.' '.$carta->getEmisor()->apellidos.' a '.$carta->getReceptor()->nombre.' '.$carta->getReceptor()->apellidos, './datos/modificacarta.php', 'fa-edit'), $fichacarta);
      echo $nuevacarta;

      $accionescarta = file_get_contents('./plantillas/acciones-cartas.html');
      echo $accionescarta;
    ?>
    </div>
    <?php
    $pie = file_get_contents('./plantillas/pie.html');
    echo $pie;

      ?>
  </body>
</html>
