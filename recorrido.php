<?php
function __autoload($className) {
    $file = "./datos/modelo/".$className.'.class.php';
    if(file_exists($file)) {
        require_once $file;
    }
}
  require_once './datos/modelo/conexion.php';
  $credenciales = explode('#',$_COOKIE["bordesarch"]);
  $edit = $_SESSION["editor"];
  if (!isset($_COOKIE["bordesarch"]) || $_SESSION['proyecto'] != 'bordes') {
    header('location:./entrando.php');
  }
  $menda = filter_var($credenciales[0], FILTER_SANITIZE_STRING);
  $viaje = $_SESSION['viaje'];
  $recorrido = $viaje->getRecorrido();
 ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Recorrido</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/estilo_index.css">
    <script type="text/javascript" src="./js/funBordes.js"></script>
    <script type="text/javascript">
      function anyadeEtapa(gid=false,topo=false){
        if (gid) {
          var idtoponimo = gid;
        }
        else{
          var idtoponimo = $('#puntoetapa').val();
        }
        if (topo) {
          var toponimo = topo;
        }
        else{
          var toponimo = $("#puntoetapa option:selected").text();
        }
        var quita = $('<div>').html('X').addClass('col-md-2').attr('style','cursor:pointer').on('click',function(){$(this).parent().parent().remove()});
        var fila = $('<div>').addClass('row').append($('<div>').addClass('col-md-10').html(toponimo)).append(quita);
        $('#puntos').append($('<li>').attr('id',idtoponimo).addClass('list-group-item').append(fila));
      }
      function grabaRecorrido(){
        var ids = [];
        var etapas = $('#puntos').children();
        for (var i = 0; i < etapas.length; i++) {
          ids.push(etapas[i].id);
        }
        $('#idsetapas').val(ids);
        $('#form-recorrido').trigger('submit');
      }
      function ponRecorrido(){
        <?php if ($recorrido): ?>
          <?php foreach ($recorrido as $key => $etapa): ?>
            anyadeEtapa(<?php echo $etapa['gid'].',"'.$etapa['toponimo'].'"'; ?>);
          <?php endforeach; ?>
        <?php endif; ?>
      }


    </script>
  </head>
  <body onload="javascript:cargaPaises(ponSelPais);ponSortable('puntos');ponRecorrido();">
    <?php
      $cabecera = str_replace('%menda%', $menda, file_get_contents('./plantillas/cabecera.html'));
      echo $cabecera;
    ?>
    <div class="container" style="margin-top:7em;">
      <form id="form-recorrido" class="hidden" action="./datos/introrecorrido.php" method="post">
        <input id="idsetapas" type="text" name="idsetapas" value="">
        <input type="submit">
      </form>
      <div class="row">
        <h2>
        Especificar recorrido
        </h2>
        <p>Recuerda introducir el origen del viaje como primera etapa</p>
      </div>
      <div class="row" style="margin-top:3em;">
        <div id="divpais" class="controls col-md-5 lug-nac" style="margin-bottom: 10px">
          <select id="paisetapa" class="form-control selec-pais" name="paisetapa" value="" onchange="javascript:habToponimo(this,'puntoetapa');">
            <option value=""></option>
          </select>
        </div>
        <div class="controls col-md-5 ">
          <select id="puntoetapa" class="form-control selec-topo lug-nac" name="puntoetapa" value="" disabled="disabled" onchange="javascript:habBoton('nuevaetapa');">
          </select>
        </div>
        <button id="nuevaetapa" class="btn btn-success col-md-2" name="button" onclick="javascript:anyadeEtapa();" disabled="disabled">Añadir etapa</button>
      </div>
      <div class="row" style="margin-top:2em;">
        <div class="col-md-6 panel panel-default" style="border:none;">
          <div class="panel-body">
            <ul  id="puntos" class="list-group" style="user-select: none;">
            </ul>
          </div>
        </div>
        <div class="col-md-6 panel panel-default" style="border:none;">
          <div class="panel-body">
            <p>Ordena las etapas situando el origen arriba y el destino abajo</p>
            <button class="btn btn-success" name="button" onclick="grabaRecorrido();">Grabar recorrido</button>
          </div>
        </div>
      </div>
      <div class="row">
        <a href="./modif-viajes.php?id=<?php echo $viaje->idviajes; ?>" class="btn btn-primary">Volver</a>
      </div>
    </div>

    <?php
      $pie = file_get_contents('./plantillas/pie.html');
      echo $pie;
     ?>
  </body>
</html>
