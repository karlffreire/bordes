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

//SÓLO SE PUEDEN VER LOS VIAJES A PARTIR DE LAS CARTAS O PERSONAS
if (isset($_SESSION['carta'])) {
  $columnas = array('Origen','Destino','Fecha','idviajes');
  $pretitulo ='Viajes referidos en la carta:';
  $carta = $_SESSION['carta'];
  $datoscrudo = $carta->getViajes();
  if ($datoscrudo) {
    $i=0;
    foreach ($datoscrudo as $key => $viaje) {
      $recorrido;
      $recorrido = $viaje->getRecorrido();
      if (isset($recorrido)) {
        $datos[$i]['origen'] = $recorrido[0]['toponimo'];
        $datos[$i]['destino'] = $recorrido[count($recorrido)-1]['toponimo'];
      }
      else{
        $datos[$i]['origen'] = 'Por rellenar';
        $datos[$i]['destino'] = 'Por rellenar';
      }
      $datos[$i]['fecha'] = $viaje->fechainicio;
      $datos[$i]['idviajes'] = $viaje->idviajes;
      ++$i;
    }
  }
  else {
    $datos = null;
  }
}
else if (isset($_SESSION['persona'])) {
  // HAY QUE ASEGURARSE DE NUNCA UNA SESIÓN TIENE CARTA Y PERSONA
}
else{
  header('location:./index.php');
}
 ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Viajes</title>
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
  <body onload="">
    <?php
      $cabecera = str_replace('%menda%', $menda, file_get_contents('./plantillas/cabecera.html'));
  //    echo $cabecera;
    ?>
    <div class="container" style="margin-top:7em;">
      <div class="row">
        <h3>
          <?php echo $pretitulo.'<br>'.$carta->getEmisor()->nombre.' '.$carta->getEmisor()->apellidos.' a '.$carta->getReceptor()->nombre.' '.$carta->getReceptor()->apellidos.' ('.$carta->fecha.')'?>
        </h3>
      </div>
      <div class="row" style="margin-top:2em;">
        <table class="table table-bordered table-list table-hover tabla-ppal">
          <thead>
            <tr>
              <?php $i=0; foreach ($columnas as $key => $titulo): ?>
                <th style="text-align:center;">
                  <?php ++$i;
                  if ($i === count($columnas)){
                    echo "<em class='fa fa-cog'></em>";
                  }
                  else{
                    echo ucfirst($titulo);
                  }
                  ?>
                </th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php if ($datos): ?>
             <?php foreach ($datos as $key => $fila): ?>
              <tr>
                <?php $i=0; foreach ($fila as $key => $celda): ?>
                  <td>
                    <?php
                    ++$i;
                    if ($i === count($fila)) {
                      echo "<a href='./modif-viajes.php?id=$celda'; class='btn btn-default bot-pers'><em class='fa fa-pencil'></em><a><a href=javascript:alertaBorrado('./datos/borra-viajes.php?id=$celda'); class='btn btn-default bot-pers'><em class='fa fa-trash'></em><a>";
                    }
                    else{
                      echo $celda;
                    }
                    ?>
                  </td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
      <div class="row" >
        <a href="./modif-cartas.php?id=<?php echo $carta->idcartas; ?>" class="btn btn-primary" style="float:left;">Volver</a>
        <a href="./nueva-viajes.php?" class="btn btn-success" style="float:right;">Añadir viaje</a>
      </div>
    </div>

    <?php
      $pie = file_get_contents('./plantillas/pie.html');
      echo $pie;
     ?>
  </body>
</html>
