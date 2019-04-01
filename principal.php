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
    $columnas = array('Fecha','Identificador','Asunto','Palabras clave');
  }
  // else if ($pagina == 'viajes') {//MEJOR QUE SÓLO SE PUEDAN VER LOS VIAJES A PARTIR DE LAS CARTAS O PERSONAS
  //   $columnas = array('Identificador','Origen','Destino','Fecha');
  // }
  else if ($pagina == 'personas') {
    $columnas = array('Nombre','Género','Tipo de persona','Fecha de nacimiento');
  }
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
  <body onload="<?php echo "javascript:tablasDatos('$pagina')"; ?>">
    <?php
      $cabecera = str_replace('%menda%', $menda, file_get_contents('./plantillas/cabecera.html'));
      echo $cabecera;
    ?>
    <div class="container" style="margin-top:7em;">
      <caption>
        <h2>
          <?php echo ucfirst($pagina); ?>
        </h2>
      </caption>
      <table class="table table-bordered table-list table-hover tabla-ppal">
        <thead>
          <tr>
            <?php foreach ($columnas as $key => $titulo): ?>
              <th>
                <?php echo $titulo; ?>
              </th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>

    <?php
      $pie = file_get_contents('./plantillas/pie.html');
      echo $pie;
     ?>
  </body>
</html>
