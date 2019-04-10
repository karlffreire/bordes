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
  $idpersona = filter_var($_GET['id'],FILTER_SANITIZE_STRING);
  $persona = OperaBD::selec('datos.personas',array('*'),'Persona',array('idpersonas'=>$idpersona))[0];

  $_SESSION['persona'] = $persona;
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
  </head>
  <script type="text/javascript">
    function ponPersona(){
      $('#boton-accion').removeClass('btn-success').addClass('btn-warning');
      $('#nombre').val(<?php echo '"'.$persona->nombre.'"' ?>);
      $('#apellidos').val(<?php echo '"'.$persona->apellidos.'"' ?>);
      $('#fechanacimiento').val(<?php echo '"'.$persona->fechanacimiento.'"' ?>);
      $('select#confianzafechanacimiento').val(<?php echo '"'.$persona->confianzafechanacimiento.'"' ?>);
      $('#fechadefuncion').val(<?php echo '"'.$persona->fechadefuncion.'"' ?>);
      $('select#confianzafechadefuncion').val(<?php echo '"'.$persona->confianzafechadefuncion.'"' ?>);
      $('select#genero').val(<?php echo '"'.$persona->genero.'"' ?>);
      $('select#tipopersona').val(<?php echo '"'.$persona->tipopersona.'"' ?>);
      $('#profesion').val(<?php echo '"'.$persona->profesion.'"' ?>);
      $('#urlimagen').val(<?php echo '"'.$persona->urlimagen.'"' ?>);
      $('.lug-nac').hide();
      $('.lug-def').hide();
      var divnac = $('<div>').addClass('input-group col-md-6').append($('<span>').addClass('input-group-btn').append($('<a>').addClass('btn btn-default').html('Editar')));
      $(divnac).append($('<input>').val(<?php echo '"'.$persona->getTxtLugarNacimiento().'"' ?>).addClass('form-control'));
      $(divnac).on('click',function(){$(this).hide();$('.lug-nac').show();$('#lugarnacimientooculto').remove();})
      $('#eti-nac').after(divnac);
      var divdef = $('<div>').addClass('input-group col-md-6').append($('<span>').addClass('input-group-btn').append($('<a>').addClass('btn btn-default').html('Editar')));
      $(divdef).append($('<input>').val(<?php echo '"'.$persona->getTxtLugarDefuncion().'"' ?>).addClass('form-control'));
      $(divdef).on('click',function(){$(this).hide();$('.lug-def').show();$('#lugardefuncionoculto').remove();})
      $('#eti-def').after(divdef);

      $('#form-persona').append($('<input>').attr('name','idpersonas').addClass('hidden').val(<?php echo '"'.$persona->idpersonas.'"' ?>));
      $('#form-persona').append($('<input>').attr('name','lugarnacimiento').attr('id','lugarnacimientooculto').addClass('hidden').val(<?php echo $persona->lugarnacimiento ?>));
      $('#form-persona').append($('<input>').attr('name','lugardefuncion').attr('id','lugardefuncionoculto').addClass('hidden').val(<?php echo $persona->lugardefuncion ?>));
    }
    function ponValPais(){
      $('#pais').val(<?php echo '"'.$persona->nacionalidad.'"' ?>).trigger('change');
    }
  </script>
  <body onload="javascript:cargaPaises(ponSelPais,true);ponPersona();">
    <?php
    $cabecera = str_replace('%menda%', $menda, file_get_contents('./plantillas/cabecera.html'));
    echo $cabecera;
    ?>
    <div class="container" style="margin-top:6em;">
      <?php
        $fichapersona = file_get_contents('./plantillas/ficha-personas.html');
        $nuevapersona = str_replace(array('%persona%','%accion%','%fa%'),array($persona->nombre.' '.$persona->apellidos,'./datos/modificapersona.php','fa-edit'),$fichapersona);
        echo $nuevapersona;

        $accionespersona = file_get_contents('./plantillas/acciones-personas.html');
        echo $accionespersona;
      ?>
    </div>
    <?php
    $pie = file_get_contents('./plantillas/pie.html');
    echo $pie;
     ?>
  </body>
</html>
