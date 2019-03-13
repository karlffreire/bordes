 <?php
require './datos/modelo.php';
$credenciales = explode('#',$_COOKIE["bordes"]);
session_start();
if (!isset($_COOKIE["bordes"]) || $_SESSION['proyecto'] != 'bordes') {
  header('location:./entrando.php');
}
$menda = filter_var($credenciales[0], FILTER_SANITIZE_STRING);
$grupos = miembroDe($menda);
$_SESSION["editor"] = false;
foreach ($grupos as $grupo) {
  if ($grupo == 'editor_bordes'){
    $_SESSION["editor"] = true;
  }
};

$edit = $_SESSION["editor"];

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="./css/estilo_index.css">
  <script type="text/javascript" src="./js/funBordes.js"></script>

</head>
<body data-spy="scroll" data-target=".navbar" data-offset="50" >
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid todo">
      <div class="navbar-header">
        <a class="navbar-brand" href="./index.php"><i class="fa fa-home" aria-hidden="true"></i> Bordes del Archivo</a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $menda;  ?></a>
          <ul class="dropdown-menu">
            <li><a href="./datos/desconexion.php">Desconectar</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
<div class="container">
  <div class="row" style="margin-top:150px;text-align:center;">
    <div class="col-lg-4">
      <div class="icon-menu-init">
        <i class="fa fa-users fa-4x" style="margin-top:40px;"></i>
      </div>
      <h2>Personas</h2>
      <p>Visualizar y gestionar la información de personas incluidas en la base de datos.</p>
      <p><a class="btn btn-default" href="./personas.php" role="button">Personas externas</a></p>
      <p><a class="btn btn-default" href="./autoras.php" role="button">Autoras</a></p>
      <p><a class="btn btn-default" href="./editores.php" role="button">Editores</a></p>
    </div>
    <div class="col-lg-4">
      <div class="icon-menu-init">
        <i class="fa fa-book fa-4x" style="margin-top:40px;"></i>
      </div>
      <h2>Mundo editorial</h2>
      <p>Visualizar y gestionar la información de empresas relacionadas con el mundo de la edición y de colecciones de obras incluidas en la base de datos.</p><p>También se inncluyen obras sin depósito legal, cuya referencia no es posible obtener a través de un sistema externo.</p>
      <p><a class="btn btn-default" href="./editoriales.php" role="button">Empresas de edición</a></p>
      <p><a class="btn btn-default" href="./colecciones.php?origen=index&editorial=" role="button">Colecciones</a></p>
      <p><a class="btn btn-default" href="./obrassindl.php?origen=index&autora=" role="button">Obras sin depósito</a></p>
    </div>
    <div class="col-lg-4">
      <div class="icon-menu-init">
        <i class="fa fa-map-signs fa-4x" style="margin-top:40px;"></i>
      </div>
      <h2>Actividades</h2>
      <p>Visualizar y gestionar la información de diferentes actividades y organizaciones relacionadas con la vida personal e institucional de las personas incluidas en la base de datos.</p>
      <p><a class="btn btn-default" href="./actividades.php" role="button">Actividades</a></p>
    </div>
  </div>
</div>


<footer>
  <p style="padding-top: 10px;">Unidad de SIG<a href="http://unidadsig.cchs.csic.es/sig/" style="margin-left: 80px;"><img src="./img/logo_usig.png" style="height: 35px;" /></a></p>
</footer>
</body>
</html>
