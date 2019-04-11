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
  $pagina = filter_var($_GET['p'],FILTER_SANITIZE_STRING);
  if (!isset($_GET['p'])) {
    header('location:./index.php');
  }
  $edit = $_SESSION["editor"];
  $columnas;
  if ($pagina == 'cartas') {
    $paginamostrar = $pagina;
    $columnas = array('fecha','identificador','asunto','remitente','destinatario','idcartas');
    $columnasb = array('fecha','identificador','asunto',"emisor.nombre||' '||emisor.apellidos as emisor","receptor.nombre||' '||receptor.apellidos as receptor",'idcartas');
    $filtros = unserialize(filter_var($_GET['f'],FILTER_SANITIZE_STRING));
    $orden = array('fecha','identificador');
    $datos = OperaBD::selec('datos.cartas inner join datos.personas emisor on cartas.idemisor = emisor.idpersonas left join datos.personas receptor on cartas.idreceptor = receptor.idpersonas',$columnasb,null,null,$orden);
  }
  else if ($pagina == 'personas') {
    $paginamostrar = $pagina;
    $columnas = array('nombre','apellidos','genero','tipopersona','fechanacimiento','idpersonas');
    $filtros = unserialize(filter_var($_GET['f'],FILTER_SANITIZE_STRING));
    $orden = array('nombre','apellidos','fechanacimiento');
    $datos = OperaBD::selec('datos.personas',$columnas,null,null,$orden);
  }
  else if ($pagina == 'acontecimientos') {
    $paginamostrar = $pagina;
    $columnas = array('nombre','fecha','idacontecimiento');
    $filtros = urldecode(unserialize(filter_var($_GET['f'])));
    $orden = array('nombre','fecha');
    $datos = OperaBD::selec('datos.acontecimiento',$columnas,null,null,$orden);
  }
  else if ($pagina == 'instituciones') {
    $paginamostrar = $pagina;
    $columnas = array('nombre','administracion','sede','idinstituciones');
    $columnasb = array('instituciones.nombre','administracion','lugares.nombre as sede','idinstituciones');
    $filtros = unserialize(filter_var($_GET['f'],FILTER_SANITIZE_STRING));
    $orden = array('nombre');
    $datos = OperaBD::selec('datos.instituciones inner join datos.lugares on sede = lugares.idlugares',$columnasb,null,null,$orden);
  }
  else {
    header('location:./index.php');
  }
  unset($_SESSION['persona']);
  unset($_SESSION['carta']);
 ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $pagina; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/estilo_index.css">
    <script type="text/javascript" src="./js/funBordes.js"></script>
  </head>
  <body onload="javascript:paginaTablas();">
    <?php
      $cabecera = str_replace('%menda%', $menda, file_get_contents('./plantillas/cabecera.html'));
      echo $cabecera;
    ?>
    <div class="container" style="margin-top:7em;">
      <div class="row">
        <caption>
          <h2>
            <?php echo ucfirst($paginamostrar); ?>
          </h2>
        </caption>
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
                      if ($edit) {
                        echo "<a href=modif-$pagina.php?id=$celda class='btn btn-default bot-pers'><em class='fa fa-pencil'></em></a><a href=javascript:alertaBorrado('./datos/borra-$pagina.php?id=$celda'); class='btn btn-default bot-pers'><em class='fa fa-trash'></em><a>";
                      }
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
      <div class="row">
        <p><a class="btn btn-success" href="./nueva-<?php echo $pagina;?>.php" role="button">Añadir <?php echo $pagina;?></a></p>
      </div>
    </div>

    <?php
      $pie = file_get_contents('./plantillas/pie.html');
      echo $pie;
     ?>
  </body>
</html>
